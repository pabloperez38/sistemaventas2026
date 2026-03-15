<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\TmpVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TmpVentaController extends Controller
{

    public function tmp_ventas(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'cantidad' => 'required|numeric|min:1'
        ]);

        $producto = Producto::where('codigo', $request->codigo)->first();
        $session_id = session()->getId();

        if ($producto) {
            $tmp_venta = TmpVenta::where('producto_id', $producto->id)
                ->where('session_id', $session_id)
                ->first();

            if ($tmp_venta) {

                $tmp_venta->cantidad += $request->cantidad;
            } else {

                $tmp_venta = new TmpVenta();
                $tmp_venta->producto_id = $producto->id;
                $tmp_venta->session_id = $session_id;
                $tmp_venta->cantidad = $request->cantidad;
                $tmp_venta->precio_venta = $producto->precio_venta;
            }

            $tmp_venta->save();

            return response()->json([
                'id_venta' => $tmp_venta->id,
                'success' => true,
                'producto' => $producto,
                'cantidad' => $tmp_venta->cantidad,
                'subtotal' => $producto->precio_venta * $tmp_venta->cantidad
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ]);
        }
    }
    public function actualizarPrecio(Request $request)
    {
        TmpVenta::where('producto_id', $request->id)
            ->update([
                'precio_venta' => $request->precio
            ]);

        return response()->json(['ok' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'proveedor_id' => 'required|exists:proveedors,id',
            'comprobante' => 'required|string|max:50'
        ]);

        $session_id = session()->getId();

        $tmp = TmpVenta::with('producto')
            ->where('session_id', $session_id)
            ->get();

        // validar que haya al menos un producto
        if ($tmp->count() < 1) {
            return back()->with('error', 'Debe agregar al menos un producto a la venta.');
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
                ]);

                // guardar detalle
                foreach ($tmp as $item) {

                    DetalleVenta::create([
                        'venta_id' => $venta->id,
                        'producto_id' => $item->producto_id,
                        'cantidad' => $item->cantidad,
                        'cliente_id' => $request->cliente_id,
                        'precio_venta' => $item->producto->precio_venta
                    ]);
                }

                // limpiar carrito temporal
                TmpVenta::where('session_id', $session_id)->delete();
            });

            return redirect()->route('admin.ventas.index')->with('swal', [
                'icon' => 'success',
                'title' => 'Rol creado exitosamente',
                'timer' => 2000
            ]);
        } catch (\Exception $e) {

            return back()->with('error', 'Error al registrar la venta');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TmpVenta $tmpVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = TmpVenta::findOrFail($id);

        //dd($producto);

        $producto->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
