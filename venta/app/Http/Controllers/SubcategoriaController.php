<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class SubcategoriaController extends Controller{

    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    // Mostrar vista de listado de subcategorías
    public function index(){
        $subcategorias = Subcategoria::with('usuario')->get();
        // Obtener los nombres de categoría correspondientes a cada producto
        $categorias = Categoria::whereIn('id', $subcategorias->pluck('categoria_id'))->pluck('nombre', 'id');
        return view('subcategorias.lista')->with(['subcategorias' => $subcategorias, 'categorias' => $categorias]);
    }

    // Mostrar vista de formulario
    public function create(){
        $categorias = Categoria::all();
        return view('subcategorias.create', compact('categorias'));
    }

    //editar
    public function edit(Subcategoria $subcategoria){
        $categorias = Categoria::all();
        return view('subcategorias.edit', compact('subcategoria','categorias'));
    }

    // Validar y guardar datos del formulario
    public function store(Request $request)
    {
        // Reglas de validación
        $this->validate($request, [
            'nombre' => 'required',
            'codigo' => 'required|min:5',
            'descripcion' => 'required',
            'categoria_id' => 'required',
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        //dd($userId);

        // Invocar el modelo Categoria para crear el registro con el user_id
        Subcategoria::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'categoria_id' => $request->categoria_id,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => $userId,
        ]);

        // Redireccionar a la vista de listado de categorías
        return redirect()->route('subcategorias.index')->with('agregada', 'Categoría agregada correctamente');
    }

    //para guardar la imagen de la marca
    public function store_imagen(Request $request){
        //identificar el archivo que se sube en dropzone
        $imagen=$request->file('file');

        //convertimos el arreglo input a formato json
        //return response()->json(['imagen'=>$imagen->extension()]);
        //genera un id unico para cada una de las imagenes que se cargan en el server
        $nombreImagen = Str::uuid() . ".". $imagen->extension();

        //implementar intervention Image 
        $imagenServidor=Image::make($imagen);

        //agregamos efectps de intervention image: indicamos la medida de cada imagen
        $imagenServidor->fit(1000,1000);

        //movemos la imagen a un lugar fisico del servidor
        $imagenPath=public_path('uploads'). '/'. $nombreImagen;

        //pasamos la imagen de memoria al server
        $imagenServidor->save($imagenPath);

        ///verificamos que el nombre del archivo se ponga como unico
        return response()->json(['imagen'=>$nombreImagen]);

    }

    //guardar cambios editados
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'codigo' => 'required',
            'categoria_id' => 'required',
        ]);

        $subcategoria = Subcategoria::findOrFail($id);
        $subcategoria->nombre = $request->nombre;
        $subcategoria->descripcion = $request->descripcion;
        $subcategoria->codigo = $request->codigo;
        $subcategoria->categoria_id = $request->categoria_id;
        $subcategoria->save();

        return redirect()->route('subcategorias.index')->with('actualizada', 'Subcategoría actualizada correctamente.');
    }

    public function delete($id)
    {
        $subcategoria = Subcategoria::find($id);
        // Obtener los productos asociados a la subcategoría
        $productos = Producto::where('subcategoria_id', $subcategoria->id)->get();

        // Quitar la subcategoría de los productos asociados
        foreach ($productos as $producto) {
            // Actualizar el ID de subcategoría a null en cada producto
            $producto->subcategoria_id = null;
            $producto->save();
        }

        // Eliminar la subcategoría
        $subcategoria->delete();


        return redirect()->back()->with('success', 'Subcategoría eliminada correctamente');
    }
}
