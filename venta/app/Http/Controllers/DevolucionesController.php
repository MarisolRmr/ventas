<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Devoluciones;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class DevolucionesController extends Controller{

    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    public function index(){
        $devoluciones = Devoluciones::with('usuario')->get();
        return view('devoluciones.lista')->with(['devoluciones' => $devoluciones]); 
    }

    
    // Mostrar vista de formulario
    public function create(){
        $productos = Producto::all();
        $clientes = Cliente::all();
        
        return view('devoluciones.create')->with(['productos' => $productos,'clientes' => $clientes]);
    }

    // Validar y guardar datos del formulario
    public function store(Request $request){
        // Reglas de validación
        $this->validate($request, [
            'nombreProducto' => 'required',
            'fecha' => 'required',
            'status' => 'required',
            'total' => 'required|integer',
            'pagado' => 'required|integer',
            'deuda' => 'required|integer',
            'statusPago' => 'required',
            'imagen'=>'required'
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        //dd($userId);

        // Invocar el modelo Categoria para crear el registro con el user_id
        Devoluciones::create([
            'nombreProducto' => $request->nombreProducto,
            'fecha' => $request->fecha,
            'cliente' => $request->cliente,
            'status' => $request->status,
            'total' => $request->total,
            'pagado' => $request->pagado,
            'deuda' => $request->deuda,
            'statusPago' => $request->status2,

            'imagen' => $request->imagen,
            'user_id' => $userId,
        ]);

        // Redireccionar a la vista de listado de categorías
        return redirect()->route('devoluciones.index')->with('agregada', 'Devolución agregada correctamente');
    }

    //para guardar la imagen de la devolucion
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

    //editar
    public function edit(Devoluciones $devolucion){
        
        $productos = Producto::all();
        $clientes = Cliente::all();
        
        return view('devoluciones.edit')->with(['productos' => $productos,'clientes' => $clientes, 'devolucion' => $devolucion]);
        
    }

    //guardar cambios editados
    public function update(Request $request, $id){
        
        $request->validate([
            'nombreProducto' => 'required',
            'fecha' => 'required',
            'status' => 'required',
            'total' => 'required|integer',
            'pagado' => 'required|integer',
            'deuda' => 'required|integer',
            'statusPago' => 'required',
            'imagen'=>'required'
        ]);

        $devolucion = Devoluciones::findOrFail($id);
        $devolucion->nombreProducto = $request->nombreProducto;
        $devolucion->fecha = $request->fecha;
        $devolucion->status = $request->status;
        $devolucion->total = $request->total;
        $devolucion->pagado = $request->pagado;
        $devolucion->deuda = $request->deuda;
        $devolucion->statusPago = $request->statusPago;
        $devolucion->save();

        return redirect()->route('devoluciones.index')->with('actualizada', 'Devolución actualizada correctamente');
    }

    public function delete($id){
        Devoluciones::find($id)->delete();
        return redirect()->back()->with('success', 'Devolución ha sido eliminado correctamente');
    }

    

}
