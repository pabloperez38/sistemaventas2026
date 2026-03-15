<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\TmpVenta;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::orderBy('id', 'desc')->get();
        return view('admin.ventas.index', compact('ventas'));
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

        return view('admin.ventas.create', compact('productos', 'clientes', 'tmp_ventas'));
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

                // crear venta
                $venta = Venta::create([
                    'fecha' => $request->fecha,
                    'precio_final' => $total,
                    'cliente_id' => $request->cliente_id,
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        //
    }
}
