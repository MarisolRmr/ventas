<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Redireccionar al dashboard de administrador
    public function index(User $user){
        return view('dashboard', [
            'user' => $user
        ]);
    }
}
