<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserCreateRequest;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();


        if($request->query()) {
            if(!is_null($request->id)) {
                $query->where('id', $request->id);
            }

            if(!is_null($request->name)) {
                $query->where('name', 'LIKE', "%{$request->name}%");
            }

            if(!is_null($request->email)) {
                $query->where('email', 'LIKE', "%{$request->email}%");
            }
        }

        return Inertia::render('users/index',[
            'users' => $query->where('email', '!=', auth()->user()->email)->paginate(5)->appends('name', request('name'))->appends('id', request('id'))->appends('email', request('email')),
            'filters' => $request->query()
        ]);
    }

    public function create()
    {
        return Inertia::render('users/create');
    }

    public function store(UserCreateRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with(['type' => 'success', 'message' => 'Usuario cadastrado com sucesso!']);
    }

    public function edit($id)
    {
        return Inertia::render('users/edit', [
            'user' => User::findOrFail($id)
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('admin.users.index')->with(['type' => 'success', 'message' => 'Usuario editado com sucesso!']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == auth()->user()->id) {
            auth()->logout();
            $user->delete();
        }else {
            $user->delete();
        }


        return redirect()->route('admin.users.index')->with(['type' => 'success', 'message' => 'Usuario excluido com sucesso!']);
    }

}
