<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Cliente;

class ClientesController extends Controller
{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    // Mostrar vista de listado de clientes
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.lista')->with(['clientes' => $clientes]);
    }
    //eliminar cliente
    public function delete($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->delete();
            return redirect()->back()->with('success', 'Cliente eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el cliente debido a las relaciones existentes');
        }
    }
    // Mostrar vista de formulario
    public function create()
    {
        return view('clientes.create');
    }
    //editar
    public function edit(cliente $cliente)
    {

        return view('clientes.edit', compact('cliente'));
    }

    // Validar y guardar datos del formulario
    public function store(Request $request)
    {
        // Reglas de validación
        $this->validate($request, [
            'nombre' => 'required',
            'codigo' => 'required|integer|min:5',
            'email' => 'required',
        ]);


        // Invocar el modelo cliente para crear el registro con el user_id
        cliente::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'empresa' => $request->empresa,
            'pais' => $request->pais,
            'ciudad' => $request->ciudad,
            'direccion' => $request->direccion,
            'imagen' => $request->imagen,
        ]);

        // Redireccionar a la vista de listado de clientes
        return redirect()->route('clientes.index')->with('agregada', 'Cliente agregado correctamente');
    }

    //guardar cambios editados
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|integer|min:5',
            'email' => 'required',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->nombre = $request->nombre;
        $cliente->codigo = $request->codigo;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->pais = $request->pais;
        $cliente->ciudad = $request->ciudad;
        $cliente->direccion = $request->direccion;
        $cliente->empresa = $request->empresa;
        $cliente->imagen = $request->imagen;
        $cliente->save();

        return redirect()->route('clientes.index')->with('actualizada', 'Cliente actualizado correctamente.');
    }

    
}