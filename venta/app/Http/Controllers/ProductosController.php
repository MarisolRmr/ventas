<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Marca;

use Illuminate\Support\Facades\Auth;

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

        // Obtener los nombres de marcas correspondientes a cada producto
        $marcas = Categoria::whereIn('id', $productos->pluck('marca_id'))->pluck('nombre', 'id');

        return view('productos.lista')->with([
            'productos' => $productos,
            'categorias' => $categorias,
            'marcas' => $marcas,
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
        $marcas = Marca::all();
        return view('productos.create', compact('categorias','marcas'));
    }

    //editar
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $marcas = Marca::all();
        return view('productos.edit', compact('producto','categorias','marcas'));
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
            'marca_id' => 'required',
        ]);
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Invocar el modelo Producto para crear el registro
        Producto::create([
            'nombre' => $request->nombre,
            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_compra,
            'unidades' => $request->unidades,
            'categoria_id' => $request->categoria_id,
            'marca_id' => $request->marca_id,
            'user_id' => $userId,
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
            'marca_id' => 'required',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->precio_compra = $request->precio_compra;
        $producto->unidades = $request->unidades;
        $producto->categoria_id = $request->categoria_id;
        $producto->marca_id = $request->marca_id;
        $producto->save();

        return redirect()->route('productos.index')->with('actualizado', 'Producto actualizado correctamente.');
    }


}
