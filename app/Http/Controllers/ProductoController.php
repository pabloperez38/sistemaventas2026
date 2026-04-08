<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $query = Producto::withTrashed();

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', '%' . $buscar . '%')
                    ->orWhere('codigo', 'like', '%' . $buscar . '%');
            });
        }

        $productos = $query
            ->orderBy('nombre', 'asc')
            ->paginate(10);

        return view('admin.productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        $marcas = Marca::orderBy('nombre', 'asc')->get();
        return view('admin.productos.create', compact('categorias', 'marcas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return response()->json($request->all());

        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|unique:productos,codigo|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'marca_id' => 'required|exists:marcas,id',
            'precio_compra' => 'required|numeric|decimal:0,2',
            'precio_venta' => 'required|numeric|decimal:0,2',
            'stock' => 'required|integer',
            'stock_minimo' => 'required|integer',
        ]);

        Producto::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'categoria_id' => $request->categoria_id,
            'marca_id' => $request->marca_id,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'stock' => $request->stock,
            'stock_minimo' => $request->stock_minimo,
        ]);

        return redirect()->route('admin.productos.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Producto creado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        $marcas = Marca::all();
        return view('admin.productos.edit', compact('producto', 'categorias', 'marcas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|unique:productos,codigo,' . $producto->id,
            'categoria_id' => 'required|exists:categorias,id',
            'marca_id' => 'required|exists:marcas,id',
            'precio_compra' => 'required|numeric|decimal:0,2',
            'precio_venta' => 'required|numeric|decimal:0,2',
            'stock' => 'required|integer',
            'stock_minimo' => 'required|integer',
        ]);

        $producto->update($datos);

        return redirect()->route('admin.productos.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Producto actualizado exitosamente',
            'timer' => 2000
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        $producto->activo = 0;
        $producto->save();

        $producto->delete();

        return redirect()->route('admin.productos.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Producto eliminado correctamente',
            'timer' => 2000
        ]);
    }

    public function restaurar($id)
    {
        $producto = Producto::withTrashed()->findOrFail($id);

        $producto->restore();
        $producto->activo = 1;
        $producto->save();

        return redirect()->route('admin.productos.index')->with('swal', [
            'icon' => 'success',
            'title' => 'Producto restaurado correctamente',
            'timer' => 2000
        ]);
    }
    public function updatePrice(Request $request)
    {

        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        $marcas = Marca::orderBy('nombre', 'asc')->get();

        return view('admin.productos.update_price', compact('categorias', 'marcas'));
    }

    public function actualizarPrecios(Request $request)
    {
        // dd('entro', $request->all());

        $request->validate([
            'porcentaje' => 'required|numeric|min:0',
            'tipo' => 'required|in:aumento,descuento',
            'categorias' => 'nullable|array',
            'marcas' => 'nullable|array',
        ]);

        $accion = $request->accion;

        $porcentaje = $request->porcentaje;
        $tipo = $request->tipo;
        $categorias = $request->categorias;
        $marcas = $request->marcas;

        $query = Producto::query();

        if (!empty($categorias)) {
            $query->whereIn('categoria_id', $categorias);
        }

        if (!empty($marcas)) {
            $query->whereIn('marca_id', $marcas);
        }

        $total = $query->count();

        if ($total === 0) {
            return back()->with('error', 'No hay productos para actualizar');
        }

        $factor = $tipo === 'aumento'
            ? (1 + $porcentaje / 100)
            : (1 - $porcentaje / 100);

        // =========================
        // 👀 PREVIEW
        // =========================
        if ($accion === 'preview') {

            $productos = $query->limit(100)->get();

            $preview = $productos->map(function ($p) use ($factor) {
                return [
                    'nombre' => $p->nombre,
                    'precio_actual' => $p->precio_venta,
                    'precio_nuevo' => round($p->precio_venta * $factor, 2),
                ];
            });

            return view('admin.productos.preview', [
                'preview' => $preview,
                'total' => $total,
                'requestData' => $request->all()
            ]);
        }

        // =========================
        // ⚡ APLICAR
        // =========================
        DB::beginTransaction();

        try {

            $query->update([
                'precio_venta' => DB::raw("ROUND(precio_venta * $factor, 2)")
            ]);

            DB::commit();

            return redirect()->route('admin.productos.index')->with('swal', [
                'icon' => 'success',
                'total' => $total,
                'title' => "Se actualizaron {$total} productos correctamente",
                'timer' => 2000
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('admin.productos.index')->with('swal', [
                'icon' => 'error',
                'title' => 'Error al actualizar precios',
                'timer' => 2000
            ]);
        }
    }
}
