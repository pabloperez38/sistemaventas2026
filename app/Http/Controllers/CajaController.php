<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\MetodoPago;
use App\Models\MovimientoCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'ventas.pagos'
        )->findOrFail($id);

        $movimientos = collect();

        // Totales por método
        $totalesMetodos = [
            'efectivo' => 0,
            'debito' => 0,
            'credito' => 0,
            'transferencia' => 0,
        ];

        // 1️⃣ Apertura
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
            'metodo' => 'Apertura'
        ]);

        // 2️⃣ Movimientos reales de caja
        foreach ($caja->movimientos as $m) {
            $movimientos->push([
                'tipo' => $m->tipo,
                'descripcion' => $m->descripcion,
                'monto' => $m->monto,
                'fecha' => $m->created_at,
                'metodo' => $m->tipo == 'ingreso' ? 'Efectivo' : null,
            ]);

            // ✅ Solo sumar ingresos que comienzan con "Venta"
            if ($m->tipo == 'ingreso' && str_starts_with($m->descripcion, 'Venta')) {
                $totalesMetodos['efectivo'] += $m->monto;
                
            }
        }

        // 3️⃣ Pagos de ventas (efectivo ya contado)
        foreach ($caja->ventas as $venta) {
            foreach ($venta->pagos as $pago) {
                if ($pago->metodo == 'efectivo') continue; // ya está contado
                $movimientos->push([
                    'tipo' => 'pago',
                    'descripcion' => 'Venta #' . $venta->id,
                    'monto' => $pago->monto,
                    'fecha' => $pago->created_at,
                    'metodo' => ucfirst($pago->metodo),
                ]);

                if (isset($totalesMetodos[$pago->metodo])) {
                    $totalesMetodos[$pago->metodo] += $pago->monto;
                }
            }
        }

        // Ordenar por fecha
        $movimientos = $movimientos->sortBy('fecha')->values();

        // Calcular saldo solo efectivo
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

        // Totales generales
        $ingresos = $caja->movimientos->where('tipo', 'ingreso')->sum('monto');
        $egresos = $caja->movimientos->where('tipo', 'egreso')->sum('monto');
        $total_esperado = $caja->monto_inicial + $ingresos - $egresos;
        $total_real = $caja->monto_final ?? 0;
        $diferencia = $total_real - $total_esperado;

        // Pasar todo a la vista
        $caja->ingresos = $ingresos;
        $caja->egresos = $egresos;
        $caja->total_esperado = $total_esperado;
        $caja->total_real = $total_real;
        $caja->diferencia = $diferencia;

        return view('admin.cajas.show', compact('caja', 'movimientos', 'totalesMetodos', 'saldoFinal'));
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
            'ventas.pagos'
        )->findOrFail($id);

        //  return $caja;

        $movimientos = collect();

        // Totales por método, ahora separados
        $totalesMetodos = [
            'efectivo' => 0,
            'debito' => 0,
            'credito' => 0,
            'transferencia' => 0,
        ];


        // 1️⃣ Apertura (solo para mostrar en la tabla)
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
            'metodo' => 'Apertura'
        ]);

        // 2️⃣ Movimientos reales de caja
        foreach ($caja->movimientos as $m) {

            // 2a. Movimientos con métodos de pago asociados
            if ($m->metodosPago && $m->metodosPago->count()) {
                foreach ($m->metodosPago as $mp) {
                    $metodo = $mp->metodoPago->codigo ?? null;

                    $movimientos->push([
                        'tipo' => $m->tipo,
                        'descripcion' => $m->descripcion,
                        'monto' => $mp->monto,
                        'fecha' => $m->created_at,
                        'metodo' => ucfirst($metodo),
                    ]);

                    // Totales por método
                   /*  if (isset($totalesMetodos[$metodo])) {
                        if ($m->tipo === 'ingreso') {
                            $totalesMetodos[$metodo] += $mp->monto;
                        } elseif ($m->tipo === 'egreso') {
                            $totalesMetodos[$metodo] -= $mp->monto;
                        }
                    } */
                }
            }

            // 2b. Movimientos manuales de efectivo sin método de pago
            if ($m->tipo === 'ingreso' && (! $m->metodosPago || $m->metodosPago->isEmpty())) {
                $movimientos->push([
                    'tipo' => $m->tipo,
                    'descripcion' => $m->descripcion,
                    'monto' => $m->monto,
                    'fecha' => $m->created_at,
                    'metodo' => 'Efectivo', // asumimos que es efectivo manual
                ]);

                // Sumar al total de efectivo
                $totalesMetodos['efectivo'] += $m->monto;
            }
        }
        // 3️⃣ Pagos de ventas (efectivo ya contado)
        $ventas = $caja->ventas;
        foreach ($ventas as $venta) {
            foreach ($venta->pagos as $pago) {
                if ($pago->metodo == 'efectivo') continue; // ya está contado
                $movimientos->push([
                    'tipo' => 'pago',
                    'descripcion' => 'Venta #' . $venta->id,
                    'monto' => $pago->monto,
                    'fecha' => $pago->created_at,
                    'metodo' => ucfirst($pago->metodo),

                ]);

                // Acumular totales por método
                if (isset($totalesMetodos[$pago->metodo])) {
                    $totalesMetodos[$pago->metodo] += $pago->monto;
                }
            }
        }

        // 4️⃣ Ordenar por fecha
        $movimientos = $movimientos->sortBy('fecha');

        // 5️⃣ Calcular saldo (solo efectivo)
        $saldo = 0;
        $movimientos = $movimientos->map(function ($mov) use (&$saldo) {
            if ($mov['tipo'] == 'apertura') {
                $saldo += $mov['monto'];
            } elseif ($mov['metodo'] === 'Efectivo') {

                if ($mov['tipo'] === 'ingreso') {
                    $saldo += $mov['monto'];
                } elseif ($mov['tipo'] === 'egreso') {
                    $saldo -= $mov['monto'];
                }
            }
            $mov['saldo'] = $saldo;
            return $mov;
        });

        $saldoFinal = $movimientos->last()['saldo'] ?? 0;

        $metodosPago = MetodoPago::where('activo', true)->get();

        return view('admin.cajas.ingresoegreso', compact('caja', 'movimientos', 'saldoFinal', 'totalesMetodos', 'metodosPago'));
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
                'caja_id' => $id
            ]);

            $movimiento->metodosPago()->create([
                'metodo_pago_id' => $request->metodo_pago_id,
                'monto' => $request->monto
            ]);
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

        // Totales por método, ahora separados
        $totalesMetodos = [
            'efectivo' => 0,
            'debito' => 0,
            'credito' => 0,
            'transferencia' => 0,
        ];


        // 1️⃣ Apertura (solo para mostrar en la tabla)
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
            'metodo' => 'Apertura'
        ]);

        // 2️⃣ Movimientos reales de caja (solo efectivo)
        foreach ($caja->movimientos as $m) {
            $movimientos->push([
                'tipo' => $m->tipo,
                'descripcion' => $m->descripcion,
                'monto' => $m->monto,
                'fecha' => $m->created_at,
                'metodo' => $m->tipo == 'ingreso' ? 'Efectivo' : null,
            ]);

            // ✅ Solo sumar ingresos que comienzan con "Venta"
            if ($m->tipo == 'ingreso' && str_starts_with($m->descripcion, 'Venta')) {
                $totalesMetodos['efectivo'] += $m->monto;
            }
        }

        // 3️⃣ Pagos de ventas (efectivo ya contado)
        $ventas = $caja->ventas;
        foreach ($ventas as $venta) {
            foreach ($venta->pagos as $pago) {
                if ($pago->metodo == 'efectivo') continue; // ya está contado
                $movimientos->push([
                    'tipo' => 'pago',
                    'descripcion' => 'Venta #' . $venta->id,
                    'monto' => $pago->monto,
                    'fecha' => $pago->created_at,
                    'metodo' => ucfirst($pago->metodo),
                ]);

                // Acumular totales por método
                if (isset($totalesMetodos[$pago->metodo])) {
                    $totalesMetodos[$pago->metodo] += $pago->monto;
                }
            }
        }

        // 4️⃣ Ordenar por fecha
        $movimientos = $movimientos->sortBy('fecha');

        // 5️⃣ Calcular saldo (solo efectivo)
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
