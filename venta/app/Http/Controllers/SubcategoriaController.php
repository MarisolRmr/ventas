<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Subcategoria;
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
        return view('subcategorias.lista')->with(['subcategorias' => $subcategorias]);
    }

    // Mostrar vista de formulario
    public function create(){
        return view('subcategorias.create');
    }

    //editar
    public function edit(Subcategoria $subcategoria){
        return view('subcategorias.edit', compact('subcategoria'));
    }

    // Validar y guardar datos del formulario
    // Validar y guardar datos del formulario
    public function store(Request $request)
    {
        // Reglas de validación
        $this->validate($request, [
            'nombre' => 'required',
            'codigo' => 'required|min:5',
            'descripcion' => 'required'
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        //dd($userId);

        // Invocar el modelo Categoria para crear el registro con el user_id
        Subcategoria::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'categoria_id' => $request->categoria,
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
        $subcategoria->categoria = $request->categoria;
        $subcategoria->save();

        return redirect()->route('subcategorias.index')->with('actualizada', 'Subcategoría actualizada correctamente.');
    }

    public function delete($id)
    {
        Subcategoria::find($id)->delete();
        return redirect()->back()->with('success', 'Subcategoría eliminada correctamente');
    }
}
