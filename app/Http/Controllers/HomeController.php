<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('users.show', ['user' => auth()->user()]);
    }

    public function userslist()
    {
        $users = User::all();

        return view('users.index', ['users' => $users]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->update($request->only(['name', 'email', 'password']));

        return redirect('users')
            ->with('status', 'User updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect('users')
            ->with('status', 'User deleted.');
    }
}
