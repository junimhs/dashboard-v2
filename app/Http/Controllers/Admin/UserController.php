<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\UserCreateRequest;
use App\Http\Requests\Admin\Users\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Jenssegers\Agent\Agent;
use MongoDB\Driver\Session;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();


        if($request->query()) {
            if($request->trashed == 'true') {
                $query->onlyTrashed();
            }

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

    public function edit(Request $request, $id)
    {
        return Inertia::render('users/edit', [
            'user' => User::withTrashed()->findOrFail($id),
            'filters' => $request->query()
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);
        $user = User::withTrashed()->findOrFail($id);
        $user->update($validated);

        return redirect()->route('admin.users.index')->with(['type' => 'success', 'message' => 'Usuario editado com sucesso!']);
    }

    public function destroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $msg = $user->deleted_at ? 'Usuario restaurado com sucesso!' : 'Usuario excluido com sucesso!';

        if ($user->id == auth()->user()->id) {
            auth()->logout();
            $user->delete();
        }elseif (!!$user->deleted_at) {
            $user->restore();
        }else {
            $user->delete();
        }

        return redirect()->route('admin.users.index')->with(['type' => 'success', 'message' => $msg]);
    }

    public function profile(Request $request)
    {
        $devices = $this->sessions($request)->all();
        return Inertia::render('users/profile', [
            'user' => User::withTrashed()->findOrFail(auth()->user()->id),
            'devices' => $devices
        ]);
    }

    public function deviceDestroy($id)
    {
        if ($id == \session()->getId()) {
            return redirect()->route('admin.home')->with(['type' => 'error', 'message' => 'Dispositivo atual nao pode ser desconectado!']);
        }

        DB::table('sessions')
            ->where('user_id', auth()->user()->id)
            ->where('id', '!=', \session()->getId())->delete();

        return redirect()->route('admin.home')->with(['type' => 'success', 'message' => 'Dispositivo desconectado com sucesso!']);
    }

    private function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', $request->user()->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);
            return (object) [
                'id' => $session->id,
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId() ? 'Sim' : 'Nao',
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->locale('pt')->diffForHumans(),
            ];
        });
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

}
