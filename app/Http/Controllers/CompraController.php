<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\TmpCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DetalleCompra;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::orderBy('id', 'desc')->get();
        return view('admin.compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        $session_id = session()->getId();
        $tmp_compras = TmpCompra::where('session_id', $session_id)->get();

        return view('admin.compras.create', compact('productos', 'proveedores', 'tmp_compras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return response()->json($request->all());


        $request->validate([
            'fecha' => 'required|date',
            'proveedor_id' => 'required|exists:proveedors,id',
            'comprobante' => 'required|string|max:100'
        ]);
        // dd($request);
        $session_id = session()->getId();
        //dd(session()->getId());
        $tmp = TmpCompra::with('producto')
            ->where('session_id', $session_id)
            ->get();
        //dd($tmp);
        // validar que haya al menos un producto
        if ($tmp->count() < 1) {
            return redirect()->route('admin.compras.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Debe agregar al menos un producto a la compra.',
                'timer' => 2000
            ]);
        }

        try {

            DB::transaction(function () use ($request, $tmp, $session_id) {
                // dd('ENTRO A LA TRANSACCION');
                // calcular total desde backend
                $total = 0;

                foreach ($tmp as $item) {
                    // $total += $item->producto->precio_compra * $item->cantidad;
                    $total += $item->precio_compra * $item->cantidad;
                }
                //dd($total);
                // crear compra
                $compra = Compra::create([
                    'fecha' => $request->fecha,
                    'comprobante' => $request->comprobante,
                    'precio_final' => $total,
                    'proveedor_id' => $request->proveedor_id
                ]);
                //dd($compra);
                // guardar detalle
                foreach ($tmp as $item) {

                    DetalleCompra::create([
                        'compra_id' => $compra->id,
                        'producto_id' => $item->producto_id,
                        'cantidad' => $item->cantidad,
                        'precio_compra' => $item->precio_compra
                    ]);

                    $producto = $item->producto;

                    $producto->increment('stock', $item->cantidad);

                    $producto->update([
                        'precio_compra' => $item->precio_compra
                    ]);
                }

                // limpiar carrito temporal
                TmpCompra::where('session_id', $session_id)->delete();
            });

            return redirect()->route('admin.compras.index')->with('swal', [
                'icon' => 'success',
                'title' => 'Compra creada exitosamente',
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
        $compra = Compra::with(['proveedor', 'detalles.producto'])->findOrFail($id);
        return view('admin.compras.show', compact('compra'));
    }

    public function anular($id)
    {
        $compra = Compra::with('detalles.producto')->findOrFail($id);

        if ($compra->activo == 0) {
            return redirect()->route('admin.compras.index')->with('swal', [
                'icon' => 'error',
                'title' => 'La compra ya está anulada.',
                'timer' => 2000
            ]);
        }

        DB::transaction(function () use ($compra) {

            foreach ($compra->detalles as $detalle) {

                $producto = $detalle->producto;

                // restar stock
                $producto->stock -= $detalle->cantidad;

                $producto->save();
            }

            // marcar compra como anulada
            $compra->activo = 0;
            $compra->save();
        });

        return redirect()->route('admin.compras.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Compra anulada correctamente',
            'timer' => 2000
        ]);
    }
}
