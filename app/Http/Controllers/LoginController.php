<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("Auth/Login");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $sessionId = Session::getId();

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            $cartChange=(new CartController)->compareCarts($sessionId);
            return !$cartChange?redirect()->intended():$cartChange;
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * signs out active user
     */
    public function destroy(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Inertia::location('/');
    }
}
