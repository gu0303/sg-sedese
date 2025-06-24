<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PerfilController extends Controller{
    public function index(){   
        $user = Auth::user();
        return view('profile.profile', compact('user'));
    }

    public function edit()
{
    $user = Auth::user();
    return view('profile.edit', compact('user'));
}

public function update(Request $request){

     /** @var \App\Models\User $user */
    $user = Auth::user();

    // Validação dos dados
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    // Atualiza nome e email
    $user->name = $request->name;
    $user->email = $request->email;

    // Atualiza senha, se foi preenchida
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('profile.profile')->with('success', 'Perfil atualizado com sucesso!');
}

}
