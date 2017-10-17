<?php

namespace App\Http\Controllers;

use App\User;
use App\Request as ServiceRequest;
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
        $pending = ServiceRequest::where('status', 'pending')->get();
        $open = ServiceRequest::where('status', 'open')->get();
        $closed = ServiceRequest::where('status', 'closed')->get();

        $data = [
            'pending' => $pending->count(),
            'open' => $open->count(),
            'closed' => $closed->count()
        ];

        $notifications = auth()->user()->notifications()->get();

        return view('home')
            ->with('pending', $pending)
            ->with('open', $open)
            ->with('closed', $closed)
            ->with('data', $data)
            ->with('notifications', $notifications);
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

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

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
