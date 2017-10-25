<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        return view('clienthome');
    }

    public function store()
    {
        $token = '';
        do {
            $token = str_random(60);
        } while(User::where('api_key', $token)->exists());

        auth()->user()->update(['api_key' => $token]);

        return response($token, 200);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $token = '';
        do {
            $token = str_random(60);
        } while(User::where('api_key', $token)->exists());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_key' => $token
        ]);

        Auth::login($user);

        return redirect('client')
            ->with('status', 'Please, confirm your email to proceed.');
    }
}
