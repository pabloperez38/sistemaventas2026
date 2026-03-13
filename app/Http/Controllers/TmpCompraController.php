<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\TmpCompra;
use Illuminate\Http\Request;

class TmpCompraController extends Controller
{

    public function tmp_compras(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'cantidad' => 'required|numeric|min:1'
        ]);

        $producto = Producto::where('codigo', $request->codigo)->first();

        if ($producto) {
            $tmp_compra = new TmpCompra();

            $tmp_compra->cantidad = $request->cantidad;
            $tmp_compra->producto_id = $producto->id;
            $tmp_compra->session_id = session()->getId();

            $tmp_compra->save();

            return response()->json([
                'success' => true,
                'producto' => $producto,
                'codigo' => $request->codigo,
                'cantidad' => $request->cantidad,
                'subtotal' => $producto->precio_compra * $request->cantidad
            ]);
        } else {

            return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
        }
    }
    public function index()
    {
        //
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
        //
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
    public function destroy(TmpCompra $tmpCompra)
    {
        //
    }
}
