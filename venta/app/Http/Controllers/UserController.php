<?php

namespace App\Http\Controllers;

use App\Models\User;
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
}
