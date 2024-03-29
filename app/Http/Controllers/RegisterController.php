<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return inertia("Auth/Register");

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $req=$request->validate(
        [
            'name' => ['required','max:30'],
            'email' => ['required', 'email'],
            'password' => ['required','confirmed','min:6'],
        ]
        );

        User::create($req);

        return redirect("/login");
    }
}
