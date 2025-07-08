<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function index()
	{
		return inertia('Auth/Register');
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'name' => 'required|max:255',
			'email' => 'required|lowercase|email|max:255',
			'password' => 'required|confirmed|min:3',
		]);

		$user = User::create($data);
		event(new Registered($user));
		Auth::login($user);
		return redirect()->route('home');
	}
}
