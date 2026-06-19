<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //affiche le profiel
    public function show(){
        $user = Auth::user();
        if(!Auth::user()->hasVerifiedEmail()){
            return redirect('/email/verify');
        }
        return view('user.profile', compact('user'));
    }
    // affiche le formulaire de modif
    public function edit(){
        if(!Auth::user()->hasVerifiedEmail()){
            return redirect('/email/verify');
        }
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    //enreegister les modifs
    public function update(Request $request){
        $user = Auth::user();
        $request->validate([
            'login' => 'required|min:3|unique:users,login,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required'
        ]);

        $user->update([
            'login' => $request->login,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect('/profile');
    }

    //suprimer le compte
    public function destroy(Request $request){
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/register');
    }
}
