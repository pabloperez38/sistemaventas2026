<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\MetodoPago;
use App\Models\MovimientoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Ramsey\Uuid\v1;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caja_abierta = Caja::whereNull('fecha_cierre')->first();
        $cajas = Caja::orderBy('fecha_apertura', 'desc')->get();
        return view('admin.cajas.index', compact('cajas', 'caja_abierta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cajas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha_apertura' => 'required|date',
            'monto_inicial' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255'
        ]);

        Caja::create([
            'fecha_apertura' => $request->fecha_apertura,
            'monto_inicial' => $request->monto_inicial,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('admin.ventas.create')->with('swal', [
            'icon' => 'success',
            'title' => 'Caja abierta exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $caja = Caja::with(
            'movimientos.metodosPago.metodoPago',
            'ventas.pagos.metodoPago' // 🔥 IMPORTANTE IGUAL QUE ingresoegreso
        )->findOrFail($id);

        $movimientos = collect();

        $totalesMetodos = [
            'efectivo' => 0,
            'debito' => 0,
            'credito' => 0,
            'transferencia' => 0,
        ];

        // 🔹 1. APERTURA
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
            'metodo' => 'Apertura',
            'metodo_codigo' => 'apertura',
        ]);

        // 🔹 2. MOVIMIENTOS MANUALES (ingresos/egresos)
        foreach ($caja->movimientos as $movimiento) {

            if ($movimiento->metodosPago && $movimiento->metodosPago->count()) {

                foreach ($movimiento->metodosPago as $mp) {

                    $metodoCodigo = strtolower($mp->metodoPago->codigo ?? 'efectivo');

                    $movimientos->push([
                        'tipo' => $movimiento->tipo,
                        'descripcion' => $movimiento->descripcion,
                        'monto' => $mp->monto,
                        'fecha' => $movimiento->created_at,
                        'metodo' => $mp->metodoPago->nombre,
                        'metodo_codigo' => $metodoCodigo,
                    ]);

                    if (isset($totalesMetodos[$metodoCodigo])) {
                        $totalesMetodos[$metodoCodigo] += $movimiento->tipo === 'egreso'
                            ? -$mp->monto
                            : $mp->monto;
                    }
                }
            } else {

                // fallback (por si hay datos viejos)
                $movimientos->push([
                    'tipo' => $movimiento->tipo,
                    'descripcion' => $movimiento->descripcion,
                    'monto' => $movimiento->monto,
                    'fecha' => $movimiento->created_at,
                    'metodo' => 'Efectivo',
                    'metodo_codigo' => 'efectivo',
                ]);

                if ($movimiento->tipo === 'ingreso') {
                    $totalesMetodos['efectivo'] += $movimiento->monto;
                } elseif ($movimiento->tipo === 'egreso') {
                    $totalesMetodos['efectivo'] -= $movimiento->monto;
                }
            }
        }

        // 🔹 3. PAGOS DE VENTAS (NUEVA LÓGICA)
        foreach ($caja->ventas as $venta) {

            foreach ($venta->pagos as $pago) {

                $metodo = $pago->metodoPago;
                if (!$metodo) continue;

                $idMetodo = $metodo->id;

                // 🔥 EFECTIVO (ID = 1)
                if ($idMetodo == 1) {

                    $movimientos->push([
                        'tipo' => 'ingreso',
                        'descripcion' => 'Venta #' . $venta->id,
                        'monto' => $pago->monto,
                        'fecha' => $pago->created_at,
                        'metodo' => $metodo->nombre,
                        'metodo_codigo' => 'efectivo',
                    ]);

                    $totalesMetodos['efectivo'] += $pago->monto;
                } else {

                    $map = [
                        2 => 'debito',
                        3 => 'credito',
                        4 => 'transferencia',
                    ];

                    $codigo = $map[$idMetodo] ?? 'desconocido';

                    $movimientos->push([
                        'tipo' => 'pago',
                        'descripcion' => 'Venta #' . $venta->id,
                        'monto' => $pago->monto,
                        'fecha' => $pago->created_at,
                        'metodo' => $metodo->nombre,
                        'metodo_codigo' => $codigo,
                    ]);

                    if (isset($totalesMetodos[$codigo])) {
                        $totalesMetodos[$codigo] += $pago->monto;
                    }
                }
            }
        }

        // 🔹 ORDENAR
        $movimientos = $movimientos->sortBy('fecha')->values();

        // 🔹 SALDO (solo efectivo)
        $saldo = 0;

        $movimientos = $movimientos->map(function ($mov) use (&$saldo) {

            if ($mov['tipo'] === 'apertura') {
                $saldo += $mov['monto'];
            }

            if (($mov['metodo_codigo'] ?? '') === 'efectivo') {

                if (in_array($mov['tipo'], ['ingreso', 'apertura'])) {
                    $saldo += $mov['monto'];
                }

                if ($mov['tipo'] === 'egreso') {
                    $saldo -= $mov['monto'];
                }
            }

            $mov['saldo'] = $saldo;
            return $mov;
        });

        $saldoFinal = $movimientos->last()['saldo'] ?? 0;

        // 🔹 TOTALES GENERALES (opcional)
        $ingresos = $movimientos->where('tipo', 'ingreso')->sum('monto');
        $egresos = $movimientos->where('tipo', 'egreso')->sum('monto');

        $caja->ingresos = $ingresos;
        $caja->egresos = $egresos;
        $caja->total_esperado = $saldoFinal;
        $caja->total_real = $caja->monto_final ?? 0;
        $caja->diferencia = $caja->total_real - $saldoFinal;

        return view('admin.cajas.show', compact(
            'caja',
            'movimientos',
            'totalesMetodos',
            'saldoFinal'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Caja $caja, $id)
    {
        $caja = Caja::findOrFail($id)->first();
        return view('admin.cajas.edit', compact('caja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $caja = Caja::findOrFail($id)->first();

        $request->validate([
            'fecha_apertura' => 'required|date',
            'monto_inicial' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255'
        ]);

        $caja->update([
            'fecha_apertura' => $request->fecha_apertura,
            'monto_inicial' => $request->monto_inicial,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('admin.cajas.index')
            ->with('swal', [
                'icon' => 'success',
                'title' => 'Caja actualizada exitosamente',
                'timer' => 2000
            ]);
    }

    public function ingresoegreso($id)
    {
        $caja = Caja::with(
            'movimientos.metodosPago.metodoPago',
            'ventas.pagos.metodoPago'
        )->findOrFail($id);

        $movimientos = collect();

        $totalesMetodos = [
            'efectivo' => 0,
            'debito' => 0,
            'credito' => 0,
            'transferencia' => 0,
        ];

        // 🔹 Apertura
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
            'metodo' => 'Apertura',
            'metodo_codigo' => 'apertura',
            'metodo_id' => 1, // cuenta como efectivo
        ]);

        // 🔹 Movimientos manuales
        foreach ($caja->movimientos as $movimiento) {

            if ($movimiento->metodosPago && $movimiento->metodosPago->count()) {

                foreach ($movimiento->metodosPago as $mp) {

                    $metodoCodigo = Str::of($mp->metodoPago->codigo ?? '')
                        ->trim()
                        ->lower()
                        ->toString();

                    $movimientos->push([
                        'tipo' => $movimiento->tipo,
                        'descripcion' => $movimiento->descripcion,
                        'monto' => $mp->monto,
                        'fecha' => $movimiento->created_at,
                        'metodo' => $mp->metodoPago->nombre ?? ucfirst($metodoCodigo),
                        'metodo_codigo' => $metodoCodigo ?: 'desconocido',
                        'metodo_id' => $mp->metodo_pago_id,
                    ]);

                  
                }
            } else {

                // fallback → efectivo
                $movimientos->push([
                    'tipo' => $movimiento->tipo,
                    'descripcion' => $movimiento->descripcion,
                    'monto' => $movimiento->monto,
                    'fecha' => $movimiento->created_at,
                    'metodo' => 'Efectivo',
                    'metodo_codigo' => 'efectivo',
                    'metodo_id' => 1,
                ]);

              
            }
        }

        // 🔹 Ventas
        foreach ($caja->ventas as $venta) {
            foreach ($venta->pagos as $pago) {

                $metodo = $pago->metodoPago;
                if (!$metodo) continue;

                $idMetodo = $metodo->id;

                if ($idMetodo == 1) {

                    // 🔥 EFECTIVO
                    $movimientos->push([
                        'tipo' => 'ingreso',
                        'descripcion' => 'Venta #' . $venta->id,
                        'monto' => $pago->monto,
                        'fecha' => $pago->created_at,
                        'metodo' => $metodo->nombre,
                        'metodo_codigo' => 'efectivo',
                        'metodo_id' => 1,
                    ]);

                    $totalesMetodos['efectivo'] += $pago->monto;
                } else {

                    $map = [
                        2 => 'debito',
                        3 => 'credito',
                        4 => 'transferencia',
                    ];

                    $codigo = $map[$idMetodo] ?? 'desconocido';

                    $movimientos->push([
                        'tipo' => 'pago',
                        'descripcion' => 'Venta #' . $venta->id,
                        'monto' => $pago->monto,
                        'fecha' => $pago->created_at,
                        'metodo' => $metodo->nombre,
                        'metodo_codigo' => $codigo,
                        'metodo_id' => $idMetodo,
                    ]);

                    if (isset($totalesMetodos[$codigo])) {
                        $totalesMetodos[$codigo] += $pago->monto;
                    }
                }
            }
        }

        // 🔹 Ordenar
        $movimientos = $movimientos->sortBy('fecha')->values();

        // 🔥 SALDO CORRECTO (SIN DUPLICAR APERTURA)
        $saldo = 0;

        $movimientos = $movimientos->map(function ($mov) use (&$saldo) {

            // apertura solo una vez
            if ($mov['tipo'] === 'apertura') {
                $saldo += $mov['monto'];
            }

            // SOLO efectivo afecta caja
            if (($mov['metodo_id'] ?? null) == 1) {

                if ($mov['tipo'] === 'ingreso') {
                    $saldo += $mov['monto'];
                }

                if ($mov['tipo'] === 'egreso') {
                    $saldo -= $mov['monto'];
                }
            }

            $mov['saldo'] = $saldo;

            return $mov;
        });

        $saldoFinal = $movimientos->last()['saldo'] ?? 0;

        $metodosPago = MetodoPago::where('activo', true)->get();

        return view('admin.cajas.ingresoegreso', compact(
            'caja',
            'movimientos',
            'saldoFinal',
            'totalesMetodos',
            'metodosPago'
        ));
    }

    public function store_ingresos_egresos(Request $request, $id)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'required',
            'metodo_pago_id' => 'required|exists:metodos_pago,id',
        ]);

        DB::transaction(function () use ($request, $id) {

            $movimiento = MovimientoCaja::create([
                'monto' => $request->monto,
                'descripcion' => $request->descripcion,
                'tipo' => $request->tipo,
                'caja_id' => $id,
                'metodo_pago_id' => $request->metodo_pago_id,
            ]);

            /*  $movimiento->metodosPago()->create([
                'metodo_pago_id' => $request->metodo_pago_id,
                'monto' => $request->monto
            ]); */
        });

        return redirect()->route('admin.cajas.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Movimiento de caja creado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cerrar($id)
    {
        $caja = Caja::with('movimientos', 'ventas.pagos')->findOrFail($id);

        $movimientos = collect();

        // Totales por m�todo, ahora separados
        $totalesMetodos = [
            'efectivo' => 0,
            'debito' => 0,
            'credito' => 0,
            'transferencia' => 0,
        ];


        // 1?? Apertura (solo para mostrar en la tabla)
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
            'metodo' => 'Apertura'
        ]);

        // 2?? Movimientos reales de caja (solo efectivo)
        foreach ($caja->movimientos as $m) {
            $movimientos->push([
                'tipo' => $m->tipo,
                'descripcion' => $m->descripcion,
                'monto' => $m->monto,
                'fecha' => $m->created_at,
                'metodo' => $m->tipo == 'ingreso' ? 'Efectivo' : null,
            ]);

            // ? Solo sumar ingresos que comienzan con "Venta"
            if ($m->tipo == 'ingreso' && str_starts_with($m->descripcion, 'Venta')) {
                $totalesMetodos['efectivo'] += $m->monto;
            }
        }

        // 3?? Pagos de ventas (efectivo ya contado)
        $ventas = $caja->ventas;
        foreach ($ventas as $venta) {
            foreach ($venta->pagos as $pago) {
                if ($pago->metodo == 'efectivo') continue; // ya est� contado
                $movimientos->push([
                    'tipo' => 'pago',
                    'descripcion' => 'Venta #' . $venta->id,
                    'monto' => $pago->monto,
                    'fecha' => $pago->created_at,
                    'metodo' => ucfirst($pago->metodo),
                ]);

                // Acumular totales por m�todo
                if (isset($totalesMetodos[$pago->metodo])) {
                    $totalesMetodos[$pago->metodo] += $pago->monto;
                }
            }
        }

        // 4?? Ordenar por fecha
        $movimientos = $movimientos->sortBy('fecha');

        // 5?? Calcular saldo (solo efectivo)
        $saldo = 0;
        $movimientos = $movimientos->map(function ($mov) use (&$saldo) {
            if ($mov['tipo'] == 'apertura' || $mov['tipo'] == 'ingreso') {
                $saldo += $mov['monto'];
            } elseif ($mov['tipo'] == 'egreso') {
                $saldo -= $mov['monto'];
            }
            $mov['saldo'] = $saldo;
            return $mov;
        });

        $saldoFinal = $movimientos->last()['saldo'] ?? 0;
        return view('admin.cajas.cierre', compact('caja', 'movimientos', 'saldoFinal', 'totalesMetodos'));
    }

    public function store_cierre(Request $request, $id)
    {
        $caja = Caja::findOrFail($id)->first();

        $request->validate([
            'monto_final' => 'required|numeric|min:0',

        ]);

        $caja->update([
            'fecha_cierre' => $request->fecha_cierre,
            'monto_final' => $request->monto_final,
            'activo' => 0

        ]);

        return redirect()->route('admin.cajas.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Caja cerrada exitosamente',
            'timer' => 2000
        ]);
    }
}
