<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }

    public function store(Request $request){
        
        $this->validate($request, [
         'email'=>'required|email',
         'password'=>'required'
        ]); 
        $user = User::where('email', $request->email)->first();


        // Verificar si el usuario existe y si su status es 'Activado'
        if (!$user || $user->status !== 'Activado') {
            return back()->with('mensaje', 'Credenciales incorrectas o Usuario desactivado');
        }
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)){
            return back()->with('mensaje', 'Credenciales incorrectas');
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function register(){
        return view('auth.register');
    }

    public function store_register(Request $request){
       
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => "required|unique:users|min:3|max:20",
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);


        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make( $request->password )
        ]);

    
        auth()->attempt($request->only('email', 'password'));

        return redirect()->route('posts.index', auth()->user() );
        
    }
    public function index(){
        $usuarios = User::where('eliminado', 'no')->get();
        return view('usuarios.lista')->with(['usuarios' => $usuarios]);
    }
    
    //vista de usuarios
    public function create(){
        return view('usuarios.create');
    }
    public function store_user(Request $request){
       
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'name' => 'required|max:30',
            'apellido' => 'required|max:30',
            'username' => "required|unique:users|min:3|max:20",
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|min:6',
            'imagen' => 'required',
            'telefono' => 'required|integer',
            'status' => 'required',
            'rol' => 'required',
        ]);


        Usuario::create([
            'name' => $request->name,
            'username' => $request->username,
            'eliminado' => 'no',
            'email' => $request->email,
            'password' => Hash::make( $request->password ),
            'apellido' => $request->apellido,
            'status' => $request->status,
            'rol' => $request->rol,
            'imagen' => $request->imagen,
            'telefono' => $request->telefono,
            
        ]);

        return redirect()->route('usuarios.index' );
        
    }

    //guardar cambios editados
    public function update(Request $request, $id)
    {
        if($request->password){
            $request->validate([
                'name' => 'required|max:30',
                'apellido' => 'required|max:30',
                'username' => "required|min:3|max:20",
                'email' => 'required|email|max:60',
                'password' => 'required|min:6',
                'imagen' => 'required',
                'telefono' => 'required|integer',
                'status' => 'required',
                'rol' => 'required',
            ]);
    
            $usuario = Usuario::findOrFail($id);
            $usuario->name = $request->name;
            $usuario->eliminado = 'no';
            $usuario->apellido = $request->apellido;
            $usuario->username = $request->username;
            $usuario->email = $request->email;
            $usuario->imagen = $request->imagen;
            $usuario->telefono = $request->telefono;
            $usuario->status = $request->status;
            $usuario->rol = $request->rol;
            $usuario->password = Hash::make( $request->password );
            $usuario->save();
        }else{
            $request->validate([
                'name' => 'required|max:30',
                'apellido' => 'required|max:30',
                'username' => "required|min:3|max:20",
                'email' => 'required|email|max:60',
                'imagen' => 'required',
                'telefono' => 'required|integer',
                'status' => 'required',
                'rol' => 'required',
            ]);
    
            $usuario = Usuario::findOrFail($id);
            $usuario->name = $request->name;
            $usuario->eliminado = 'no';
            $usuario->apellido = $request->apellido;
            $usuario->username = $request->username;
            $usuario->email = $request->email;
            $usuario->imagen = $request->imagen;
            $usuario->telefono = $request->telefono;
            $usuario->status = $request->status;
            $usuario->rol = $request->rol;
            $usuario->save();
        }
        

        return redirect()->route('usuarios.index')->with('actualizada', 'Usuario actualizado correctamente.');
    }

    public function edit(Usuario $usuario){
        
        return view('usuarios.edit', compact('usuario'));
    }
    
    public function delete($id)
    {
        $usuario = Usuario::find($id);
        if ($usuario) {
            $usuario->update([
                'eliminado' => 'si',
                'status' => 'Desactivado',
                'name' => null,
                'apellido' => null,
                'email' => null,
                'password' => null,
                'imagen' => null,
                'telefono' => null,
                'rol' => null,
            ]);
            return redirect()->back()->with('success', 'Usuario eliminado correctamente');
        } else {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }
    }
}
