<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function index()
    {
        return view('clienthome');
    }

    public function store()
    {
        $token = $this->generateApiKey();

        auth()->user()->update(['api_token' => $token]);

        return response($token, 200);
    }

    private function generateApiKey()
    {
        do {
            $token = str_random(60);
        } while(User::where('api_token', $token)->exists());

        return $token;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        do {
            $token = str_random(60);
        } while(User::where('verification_key', $token)->exists());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'verification_key' => $token
        ]);

        Auth::login($user);

        Mail::to($user)->send(new EmailVerification($user));

        return redirect('client')
            ->with('status', 'Please, confirm your email to proceed.');
    }

    public function verify($token)
    {
        $user = User::where('verification_key', $token)->first();

        if(!$user) {
            return response('The provided verification token is invalid. Perhaps it has been clicked before?', 400);
        }

        $token = $this->generateApiKey();

        $user->verified = true;
        $user->verification_key = null;
        $user->api_token = $token;
        $user->save();

        Auth::login($user);

        return redirect('/client');
    }

    public function edit()
    {
        return view('clientmanage');
    }

    public function update(Request $request)
    {

    }
}
