<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\MovimientoCaja;
use Illuminate\Http\Request;

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
        $caja = Caja::with('movimientos')->findOrFail($id);

        // 🔹 Colección de movimientos
        $movimientos = collect();

        // 👉 Apertura
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
        ]);

        // 👉 Movimientos reales
        foreach ($caja->movimientos as $m) {
            $movimientos->push([
                'tipo' => $m->tipo,
                'descripcion' => $m->descripcion,
                'monto' => $m->monto,
                'fecha' => $m->created_at,
            ]);
        }

        // 👉 Ordenar
        $movimientos = $movimientos->sortBy('fecha');

        // 🔥 Totales
        $ingresos = $caja->movimientos->where('tipo', 'ingreso')->sum('monto');
        $egresos  = $caja->movimientos->where('tipo', 'egreso')->sum('monto');

        // 👉 Total esperado
        $total_esperado = $caja->monto_inicial + $ingresos - $egresos;

        // 👉 Total real (si ya cerró)
        $total_real = $caja->monto_final ?? 0;

        // 👉 Diferencia
        $diferencia = $total_real - $total_esperado;

        // 🔥 Inyectar en el objeto (para la vista)
        $caja->ingresos = $ingresos;
        $caja->egresos = $egresos;
        $caja->total_esperado = $total_esperado;
        $caja->total_real = $total_real;
        $caja->diferencia = $diferencia;

        return view('admin.cajas.show', compact('caja', 'movimientos'));
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

        $caja = Caja::with('movimientos')->findOrFail($id);

        $movimientos = collect();

        // 👉 1. Agregar apertura de caja
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
        ]);

        // 👉 2. Agregar movimientos reales
        foreach ($caja->movimientos as $m) {
            $movimientos->push([
                'tipo' => $m->tipo,
                'descripcion' => $m->descripcion,
                'monto' => $m->monto,
                'fecha' => $m->created_at,
            ]);
        }

        // 👉 3. Ordenar por fecha
        $movimientos = $movimientos->sortBy('fecha');

        // 🔥 ACÁ VA TU CÓDIGO DE SALDO
        $saldo = 0;

        $movimientos = $movimientos->map(function ($mov) use (&$saldo) {

            if (in_array($mov['tipo'], ['apertura', 'ingreso'])) {
                $saldo += $mov['monto'];
            } else {
                $saldo -= $mov['monto'];
            }

            $mov['saldo'] = $saldo;

            return $mov;
        });

        return view('admin.cajas.ingresoegreso', compact('caja', 'movimientos'));
    }

    public function store_ingresos_egresos(Request $request, $id)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'required'
        ]);

        MovimientoCaja::create([
            'monto' => $request->monto,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'caja_id' => $id
        ]);
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
        $caja = Caja::with('movimientos')->findOrFail($id);

        $movimientos = collect();

        // 👉 1. Agregar apertura de caja
        $movimientos->push([
            'tipo' => 'apertura',
            'descripcion' => 'Apertura de caja',
            'monto' => $caja->monto_inicial,
            'fecha' => $caja->fecha_apertura,
        ]);

        // 👉 2. Agregar movimientos reales
        foreach ($caja->movimientos as $m) {
            $movimientos->push([
                'tipo' => $m->tipo,
                'descripcion' => $m->descripcion,
                'monto' => $m->monto,
                'fecha' => $m->created_at,
            ]);
        }

        // 👉 3. Ordenar por fecha
        $movimientos = $movimientos->sortBy('fecha');

        // 🔥 ACÁ VA TU CÓDIGO DE SALDO
        $saldo = 0;

        $movimientos = $movimientos->map(function ($mov) use (&$saldo) {

            if (in_array($mov['tipo'], ['apertura', 'ingreso'])) {
                $saldo += $mov['monto'];
            } else {
                $saldo -= $mov['monto'];
            }

            $mov['saldo'] = $saldo;

            return $mov;
        });
        return view('admin.cajas.cierre', compact('caja', 'movimientos'));
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
