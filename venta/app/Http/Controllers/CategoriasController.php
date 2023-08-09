<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Subcategoria;
use Illuminate\Support\Facades\Auth;

class CategoriasController extends Controller
{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    // Mostrar vista de listado de categorías
    public function index()
    {
        $categorias = Categoria::with('usuario')->get();
        return view('categorias.lista')->with(['categorias' => $categorias]);
    }

    public function delete($id)
    {
        // Buscar la categoría por su ID
        $categoria = Categoria::find($id);

        
        // Obtener los productos asociados a la categoría
        $productos = Producto::where('categoria_id', $categoria->id)->get();

        // Eliminar los productos asociados
        foreach ($productos as $producto) {
            $producto->delete();
        }

        // Obtener los subcategorias asociados a la categoría
        $subcategorias = Subcategoria::where('categoria_id', $categoria->id)->get();

        // Eliminar los subcategorias asociados
        foreach ($subcategorias as $subcategoria) {
            $subcategoria->delete();
        }

        // Eliminar la categoría
        $categoria->delete();

        return redirect()->back()->with('success', 'La categoría, sus productos y subcategorias asociados han sido eliminados correctamente.');
        
    }

    // Mostrar vista de formulario
    public function create()
    {
        return view('categorias.create');
    }
    //editar
    public function edit(Categoria $categoria)
    {

        return view('categorias.edit', compact('categoria'));
    }

    // Validar y guardar datos del formulario
    public function store(Request $request)
    {
        // Reglas de validación
        $this->validate($request, [
            'nombre' => 'required',
            'codigo' => 'required|min:5',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        //dd($userId);

        // Invocar el modelo Categoria para crear el registro con el user_id
        Categoria::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => $userId,
        ]);

        // Redireccionar a la vista de listado de categorías
        return redirect()->route('categorias.index')->with('agregada', 'Categoría agregada correctamente');
    }
    //guardar cambios editados
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|min:5',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombre;
        $categoria->codigo = $request->codigo;
        $categoria->imagen = $request->imagen;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        return redirect()->route('categorias.index')->with('actualizada', 'Categoría actualizada correctamente.');
    }
}