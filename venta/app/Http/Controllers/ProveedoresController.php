<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\Models\Proveedores;

class ProveedoresController extends Controller{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    public function index(){
        $proveedores = Proveedores::all();
        return view('proveedores.lista')->with(['proveedores' => $proveedores]);
    }

    public function create(){
        return view('proveedores.create');
    }

    public function store(Request $request){
       
        $this->validate($request, [
            'nombre' => 'required',
            'codigo' => 'required|integer|min:5',
            'email' => 'required',
        ]);
       
        Proveedores::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'pais' => $request->pais,
            'ciudad' => $request->ciudad,
            'direccion' => $request->direccion,
            'imagen' => $request->imagen,
        ]);

        return redirect()->route('proveedores.index')->with('agregada', 'Proveedor agregado correctamente');
    }

    public function delete($id){
        Proveedores::find($id)->delete();
        return redirect()->back()->with('success', 'Proveedor eliminado correctamente');
    }

    public function edit(Proveedores $proveedor){

        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required|integer|min:5',
            'email' => 'required',
        ]);

        $cliente = Proveedores::findOrFail($id);
        $cliente->nombre = $request->nombre;
        $cliente->codigo = $request->codigo;
        $cliente->email = $request->email;
        $cliente->telefono = $request->telefono;
        $cliente->pais = $request->pais;
        $cliente->ciudad = $request->ciudad;
        $cliente->direccion = $request->direccion;
        $cliente->imagen = $request->imagen;
        $cliente->save();

        return redirect()->route('proveedores.index')->with('actualizada', 'Proveedor actualizado correctamente.');
    }
}
