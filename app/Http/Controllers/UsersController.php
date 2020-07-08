<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function index(Request $request)
    {
//        if (Gate::allows('user_view'))
        $users = User::query();
        if ($request->has('s')) {
            $users->search($request->s);
        }
        return view('admin.users.index', [
            'users' => $users->paginate(20),
            'search_term' => $request->s,
        ]);
//        return redirect('/')->with(['error' => 'You are not allowed to view this page']);
    }

    public function show(User $user)
    {
        return view('admin.users.show', [
            'usr' => $user->load(['deposits'])
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }
}
