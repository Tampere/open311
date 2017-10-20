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

        $notifications = auth()->user()->unreadNotifications()->get();
        $notifications->markAsRead();

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
        if(!auth()->user()->admin) return response('Sinulla ei ole oikeutta tähän toimintoon.', 403);

        $users = User::all();

        return view('users.index', ['users' => $users]);
    }

    public function update(Request $request, User $user)
    {
        if(!auth()->user()->admin) return response('Sinulla ei ole oikeutta tähän toimintoon.', 403);

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
            ->with('status', 'Käyttäjän tiedot päivitettiin.');
    }

    public function setAdmin(User $user)
    {
        if(!auth()->user()->admin) return response('Sinulla ei ole oikeutta tähän toimintoon.', 403);

        $user->admin = true;
        $user->save();

        return redirect('users')
            ->with('status', 'Käyttäjä merkattu pääkäyttäjäksi');
    }

    public function setNotAdmin(User $user)
    {
        if(!auth()->user()->admin) return response('Sinulla ei ole oikeutta tähän toimintoon.', 403);

        $user->admin = false;
        $user->save();

        return redirect('users')
            ->with('status', 'Pääkäyttäjästatus poistettu');
    }

    public function destroy(User $user)
    {
        if(!auth()->user()->admin) return response('Sinulla ei ole oikeutta tähän toimintoon.', 403);

        $user->delete();

        return redirect('users')
            ->with('status', 'Käyttäjä poistettiin.');
    }
}
