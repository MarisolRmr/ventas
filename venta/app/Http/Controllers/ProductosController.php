<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
class ProductosController extends Controller
{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    //mostrar vista de listado productos
    public function index()
    {
        $productos = Producto::all();
        
        // Obtener los nombres de categoría correspondientes a cada producto
        $categorias = Categoria::whereIn('id', $productos->pluck('categoria_id'))->pluck('nombre', 'id');

        return view('productos.lista')->with([
            'productos' => $productos,
            'categorias' => $categorias,
        ]);
    }

    public function delete($id)
    {
        Producto::find($id)->delete();
        return redirect()->back()->with('success', 'Producto eliminado correctamente');
    }
    
    // Mostrar vista de formulario
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    //editar
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();

        return view('productos.edit', compact('producto','categorias'));
    }

    // Validar y guardar datos del formulario
    public function store(Request $request)
    {
        // Reglas de validación
        $this->validate($request, [
            'nombre' => 'required',
            'unidades' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'categoria_id' => 'required',
        ]);

        // Invocar el modelo Producto para crear el registro
        Producto::create([
            'nombre' => $request->nombre,
            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_compra,
            'unidades' => $request->unidades,
            'categoria_id' => $request->categoria_id,
        ]);

        // Redireccionar a la vista de listado de categorías
        return redirect()->route('productos.index')->with('agregada', 'Producto agregado correctamente');
    }
    //guardar cambios editados
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'unidades' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'categoria_id' => 'required',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->precio_compra = $request->precio_compra;
        $producto->unidades = $request->unidades;
        $producto->categoria_id = $request->categoria_id;
        $producto->save();

        return redirect()->route('productos.index')->with('actualizado', 'Producto actualizado correctamente.');
    }


}
