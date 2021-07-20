<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all()->count();
        return Inertia::render('home', [
            'countUsers' => $users
        ]);
    }
}
