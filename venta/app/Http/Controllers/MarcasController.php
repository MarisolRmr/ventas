<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

class MarcasController extends Controller
{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    // Mostrar vista de listado de marcas
    public function index()
    {
        $marcas = Marca::with('usuario')->get();
        return view('marcas.lista')->with(['marcas' => $marcas]);
    }
    //eliminar marca
    public function delete($id)
    {
        Marca::find($id)->delete();
        return redirect()->back()->with('success', 'Marca eliminada correctamente');
    }
    // Mostrar vista de formulario
    public function create()
    {
        return view('marcas.create');
    }
    //editar
    public function edit(Marca $marca)
    {

        return view('marcas.edit', compact('marca'));
    }

    // Validar y guardar datos del formulario
    public function store(Request $request)
    {
        // Reglas de validación
        $this->validate($request, [
            'nombre' => 'required',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        //dd($userId);

        // Invocar el modelo Marca para crear el registro con el user_id
        Marca::create([
            'nombre' => $request->nombre,
            'imagen' => $request->imagen,
            'descripcion' => $request->descripcion,
            'user_id' => $userId,
        ]);

        // Redireccionar a la vista de listado de Marcas
        return redirect()->route('marcas.index')->with('agregada', 'Marca agregada correctamente');
    }

    //guardar cambios editados
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'imagen' => 'required',
            'descripcion' => 'required',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->nombre = $request->nombre;
        $categoria->imagen = $request->imagen;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();

        return redirect()->route('marcas.index')->with('actualizada', 'Marca actualizada correctamente.');
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
}
