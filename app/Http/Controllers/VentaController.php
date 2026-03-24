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

        ]);

        //dd($request);

        $session_id = session()->getId();

        $tmp = TmpVenta::with('producto')
            ->where('session_id', $session_id)
            ->get();

        // validar que haya al menos un producto
        if ($tmp->count() < 1) {
            return redirect()->route('admin.compras.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Debe agregar al menos un producto a la venta.',
                'timer' => 2000
            ]);
        }

        try {

            DB::transaction(function () use ($request, $tmp, $session_id) {

                // calcular total desde backend
                $total = 0;

                foreach ($tmp as $item) {
                    $total += $item->producto->precio_venta * $item->cantidad;
                }
                //Registrar en caja
                $caja_id = Caja::whereNull('fecha_cierre')->first()->id;
                // crear venta
                $venta = Venta::create([
                    'fecha' => $request->fecha,
                    'precio_final' => $total,
                    'cliente_id' => $request->cliente_id,
                    'caja_id' => $caja_id,
                    'user_id' => Auth::id()
                ]);

                MovimientoCaja::create([
                    'monto' => $total,
                    'descripcion' => "Venta de productos",
                    'tipo' => "ingreso",
                    'caja_id' => $caja_id
                ]);

                //dd($venta);
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
            });

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
}
