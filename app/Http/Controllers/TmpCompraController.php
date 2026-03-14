<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\TmpCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TmpCompraController extends Controller
{

    public function tmp_compras(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'cantidad' => 'required|numeric|min:1'
        ]);

        $producto = Producto::where('codigo', $request->codigo)->first();
        $session_id = session()->getId();

        if ($producto) {
            $tmp_compra = TmpCompra::where('producto_id', $producto->id)
                ->where('session_id', $session_id)
                ->first();

            if ($tmp_compra) {

                $tmp_compra->cantidad += $request->cantidad;
            } else {

                $tmp_compra = new TmpCompra();
                $tmp_compra->producto_id = $producto->id;
                $tmp_compra->session_id = $session_id;
                $tmp_compra->cantidad = $request->cantidad;
                $tmp_compra->precio_compra = $producto->precio_compra;
            }

            $tmp_compra->save();

            return response()->json([
                'id_compra' => $tmp_compra->id,
                'success' => true,
                'producto' => $producto,
                'cantidad' => $tmp_compra->cantidad,
                'subtotal' => $producto->precio_compra * $tmp_compra->cantidad
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
        TmpCompra::where('producto_id', $request->id)
            ->update([
                'precio_compra' => $request->precio
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

        $tmp = TmpCompra::with('producto')
            ->where('session_id', $session_id)
            ->get();

        // validar que haya al menos un producto
        if ($tmp->count() < 1) {
            return back()->with('error', 'Debe agregar al menos un producto a la compra.');
        }

        try {

            DB::transaction(function () use ($request, $tmp, $session_id) {

                // calcular total desde backend
                $total = 0;

                foreach ($tmp as $item) {
                    $total += $item->producto->precio_compra * $item->cantidad;
                }

                // crear compra
                $compra = Compra::create([
                    'fecha' => $request->fecha,
                    'comprobante' => $request->comprobante,
                    'precio_final' => $total,
                ]);

                // guardar detalle
                foreach ($tmp as $item) {

                    DetalleCompra::create([
                        'compra_id' => $compra->id,
                        'producto_id' => $item->producto_id,
                        'cantidad' => $item->cantidad,
                        'proveedor_id' => $request->proveedor_id,
                        'precio_c0mpra' => $item->producto->precio_compra
                    ]);
                }

                // limpiar carrito temporal
                TmpCompra::where('session_id', $session_id)->delete();
            });

            return redirect()->route('admin.compras.index')->with('swal', [
                'icon' => 'success',
                'title' => 'Rol creado exitosamente',
                'timer' => 2000
            ]);
        } catch (\Exception $e) {

            return back()->with('error', 'Error al registrar la compra');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TmpCompra $tmpCompra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TmpCompra $tmpCompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TmpCompra $tmpCompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = TmpCompra::findOrFail($id);

        //dd($producto);

        $producto->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
