<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\DetalleVenta;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\TmpVenta;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumberFormatter;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caja_abierta = Caja::whereNull('fecha_cierre')->first();
        $ventas = Venta::orderBy('id', 'desc')->get();
        return view('admin.ventas.index', compact('ventas', 'caja_abierta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        $session_id = session()->getId();
        $tmp_ventas = TmpVenta::where('session_id', $session_id)->get();
        $caja_abierta = Caja::whereNull('fecha_cierre')->first();

        if ($caja_abierta) {
            return view('admin.ventas.create', compact('productos', 'clientes', 'tmp_ventas'));
        } else {
            return redirect()->route('admin.cajas.create')->with('swal', [
                'icon' => 'error',
                'title' => 'Para vender debe abrir caja primero.',
                'timer' => 2000
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
            'pagos' => 'required|array',
            'pagos.*.metodo' => 'required',
            'pagos.*.monto' => 'required|numeric|min:0.01',
        ]);

        $session_id = session()->getId();

        $tmp = TmpVenta::with('producto')
            ->where('session_id', $session_id)
            ->get();

        // validar que haya al menos un producto
        if ($tmp->count() < 1) {
            return redirect()->route('admin.ventas.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Debe agregar al menos un producto a la venta.',
                'timer' => 2000
            ]);
        }


        try {

            $venta = DB::transaction(function () use ($request, $tmp, $session_id) {

                // calcular total desde backend
                $total = 0;

                foreach ($tmp as $item) {
                    $total += $item->producto->precio_venta * $item->cantidad;
                }

                //Registrar en caja
                $caja = Caja::whereNull('fecha_cierre')->first();
                $caja_id = $caja->id;

                // crear venta
                $venta = Venta::create([
                    'fecha' => $request->fecha,
                    'precio_final' => $total,
                    'cliente_id' => $request->cliente_id,
                    'caja_id' => $caja_id,
                    'user_id' => Auth::id()
                ]);

                // 🔥 MULTIPAGO
                $totalPagado = 0;

                if ($request->has('pagos')) {

                    foreach ($request->pagos as $pago) {

                        // guardar pago
                        $venta->pagos()->create([
                            'metodo' => $pago['metodo'],
                            'monto' => $pago['monto'],
                            'venta_id' => $venta->id
                        ]);

                        $totalPagado += $pago['monto'];

                        // 👉 SOLO efectivo entra a caja
                        if ($pago['metodo'] == 'efectivo') {
                            MovimientoCaja::create([
                                'monto' => $pago['monto'],
                                'descripcion' => "Venta #{$venta->id}",
                                'tipo' => "ingreso",
                                'caja_id' => $caja_id
                            ]);
                        }
                    }
                } else {
                    // 🔥 fallback (tu sistema actual)
                    $venta->pagos()->create([
                        'metodo' => $request->metodo,
                        'monto' => $venta->precio_final,
                        'venta_id' => $venta->id
                    ]);

                    if ($request->metodo == 'efectivo') {
                        MovimientoCaja::create([
                            'monto' => $total,
                            'descripcion' => "Venta de productos",
                            'tipo' => "ingreso",
                            'caja_id' => $caja_id
                        ]);
                    }

                    $totalPagado = $venta->precio_final;
                }

                // 🔥 VALIDACIÓN PRO
                if (round($totalPagado, 2) < round($venta->precio_final, 2)) {
                    throw new \Exception("El total pagado es menor al total de la venta");
                }

                // guardar detalle
                foreach ($tmp as $item) {

                    DetalleVenta::create([
                        'venta_id' => $venta->id,
                        'producto_id' => $item->producto_id,
                        'cantidad' => $item->cantidad,
                        'proveedor_id' => $request->proveedor_id,
                        'precio_venta' => $item->producto->precio_venta
                    ]);

                    $producto = $item->producto;
                    $producto->decrement('stock', $item->cantidad);
                }

                // limpiar carrito temporal
                TmpVenta::where('session_id', $session_id)->delete();

                return $venta;
            });

            $config = Configuracion::first();

            if ($config && $config->imprimir_ticket) {
                // dd("ANTES DE IMPRIMIR", $venta->id);
                $this->ImprimirTicket($venta->id);
            }

            return redirect()->route('admin.ventas.create')->with('swal', [
                'icon' => 'success',
                'title' => 'Venta creada exitosamente',
                'timer' => 2000
            ]);
        } catch (\Exception $e) {

            dd($e->getMessage(), $e->getLine(), $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $venta = Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
        return view('admin.ventas.show', compact('venta'));
    }

    public function anular($id)
    {
        $venta = Venta::with('detalles.producto')->findOrFail($id);

        // 🔴 Ya anulada
        if ($venta->activo == 0) {
            return redirect()->route('admin.ventas.index')->with('swal', [
                'icon' => 'error',
                'title' => 'La venta ya está anulada.',
                'timer' => 2000
            ]);
        }

        // 🔴 Límite de días
        if ($venta->created_at->diffInDays(now()) > 7) {
            return redirect()->route('admin.ventas.index')->with('swal', [
                'icon' => 'error',
                'title' => 'No se puede anular una venta con más de 7 días.',
                'timer' => 2000
            ]);
        }

        DB::transaction(function () use ($venta) {

            $total = 0;

            foreach ($venta->detalles as $detalle) {

                $producto = $detalle->producto;

                if ($producto) {
                    // 🔹 devolver stock
                    $producto->increment('stock', $detalle->cantidad);
                }

                // 🔹 calcular total (ajustá si tu campo es otro)
                $total += $detalle->cantidad * (float) $detalle->precio_venta;
            }

            // 🔹 anular venta
            $venta->update([
                'activo' => 0
            ]);

            // 🔹 buscar caja activa
            $caja = Caja::whereNull('fecha_cierre')->first();

            // 🔹 registrar movimiento en caja (inverso)
            if ($caja) {
                MovimientoCaja::create([
                    'monto' => $total,
                    'descripcion' => "Anulación de venta #{$venta->id}",
                    'tipo' => "egreso", // 👈 inverso del ingreso original
                    'caja_id' => $caja->id
                ]);
            }
        });

        return redirect()->route('admin.ventas.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Venta anulada correctamente',
            'timer' => 2000
        ]);
    }

    public function pdf($id)
    {
        $configuracion = Configuracion::first();
        $venta = Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);

        // convertir número a texto
        $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);

        $numero = floor($venta->precio_final);
        $centavos = round(($venta->precio_final - $numero) * 100);

        $total_letras = ucfirst($formatter->format($numero)) . ' pesos';

        if ($centavos > 0) {
            $total_letras .= ' con ' . $formatter->format($centavos) . ' centavos';
        }

        $pdf = PDF::loadView('admin.ventas.pdf', compact('configuracion', 'venta', 'total_letras'));

        return $pdf->stream();
    }

    public function ImprimirTicket($id)
    {
        try {
            // Función para alinear a la derecha
            function rightText($text, $width)
            {
                $len = mb_strlen($text, 'UTF-8');
                if ($len >= $width) return mb_substr($text, 0, $width);
                return str_repeat(' ', $width - $len) . $text;
            }

            // Función para alinear a la izquierda
            function leftText($text, $width)
            {
                $len = mb_strlen($text, 'UTF-8');
                if ($len >= $width) return mb_substr($text, 0, $width);
                return $text . str_repeat(' ', $width - $len);
            }

            $venta = Venta::with(['detalles.producto', 'pagos.metodoPago', 'cliente', 'user'])
                ->findOrFail($id);

            $config = Configuracion::first();

            $connector = new WindowsPrintConnector("POS80");
            $printer = new Printer($connector);

            $printer->setFont(Printer::FONT_A);
            $line = str_repeat("-", 48) . "\n";

            // 🏪 ENCABEZADO
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->setTextSize(2, 2);
            $printer->text($config->nombre_empresa . "\n");
            $printer->setTextSize(1, 1);
            $printer->setEmphasis(false);
            $printer->text("CUIT: " . $config->cuit . "\n");

            if ($config->direccion) $printer->text($config->direccion . "\n");
            if ($config->telefono) $printer->text("Tel: " . $config->telefono . "\n");

            $printer->text($line);

            // 🧾 INFO VENTA
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Venta #: " . $venta->id . "\n");
            $printer->text("Fecha: " . $venta->created_at->format('d/m/Y H:i') . "\n");

            if ($venta->user) {
                $printer->text("Vendedor: " . $venta->user->name . "\n");
            }

            if ($venta->cliente) {
                $printer->text("Cliente: " . $venta->cliente->nombre . "\n");
            }

            $printer->text($line);

            // 📋 CABECERA DE PRODUCTOS
            $printer->setEmphasis(true);
            $printer->text(
                leftText("Detalle", 36) .
                    rightText("Subtotal", 12) . "\n"
            );
            $printer->setEmphasis(false);
            $printer->text($line);

            // 🛒 PRODUCTOS
            foreach ($venta->detalles as $detalle) {
                $nombre = mb_strimwidth($detalle->producto->nombre ?? 'Producto', 0, 36, "");
                $cantidad = $detalle->cantidad;
                $precioUnitario = number_format($detalle->precio_venta, 2, '.', '');
                $subtotal = number_format($detalle->cantidad * $detalle->precio_venta, 2, '.', '');

                // Nombre del producto
                $printer->text($nombre . "\n");

                // Cantidad x Precio Unitario (indentado) y Subtotal alineado a la derecha
                $printer->text(
                    "  " . $cantidad . " x $" . $precioUnitario .
                        rightText("$" . $subtotal, 48 - (mb_strlen("  " . $cantidad . " x $" . $precioUnitario))) . "\n"
                );
            }

            $printer->text($line);

            // 💰 TOTAL (primero, para que sepa cuánto debe pagar)
            $total = number_format($venta->precio_final, 2, '.', '');
            $printer->setEmphasis(true);
            $printer->text(
                leftText("TOTAL", 36) .
                    rightText("$" . $total, 12) . "\n"
            );
            $printer->setEmphasis(false);
            $printer->text($line);

            // 💳 PAGOS (después del total)
            if ($venta->pagos->count() > 0) {
                $printer->setEmphasis(true);
                $printer->text(leftText("Forma de Pago", 36) . rightText("Monto", 12) . "\n");
                $printer->setEmphasis(false);

                $totalPagado = 0;
                foreach ($venta->pagos as $pago) {
                    $metodo = ucfirst($pago->metodo ?? 'Efectivo');
                    $monto = number_format($pago->monto, 2, '.', '');
                    $totalPagado += $pago->monto;

                    $printer->text(
                        leftText($metodo, 36) .
                            rightText("$" . $monto, 12) . "\n"
                    );
                }

                $printer->text($line);
            } else {
                $totalPagado = $venta->precio_final;
            }

            // 💵 VUELTO (si corresponde, después de los pagos)
            if ($totalPagado > $venta->precio_final) {
                $cambio = number_format($totalPagado - $venta->precio_final, 2, '.', '');
                $printer->text(
                    leftText("VUELTO", 36) .
                        rightText("$" . $cambio, 12) . "\n"
                );
                $printer->text($line);
            }

            // 🙏 PIE
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("¡Gracias por su compra!\n");
            $printer->text("Vuelva pronto\n");
            $printer->feed(2);

            // Cortar y cerrar
            $printer->cut();
            $printer->close();

            return "Ticket impreso correctamente!";
        } catch (\Exception $e) {
            return "ERROR: " . $e->getMessage();
        }
    }
}
