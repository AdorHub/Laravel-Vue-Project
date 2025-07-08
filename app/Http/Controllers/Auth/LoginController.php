<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
	public function index()
	{
		return inertia('Auth/Login', [
			'status' => session('status')
		]);
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'email' => 'required|email|max:255',
			'password' => 'required|min:3',
		]);
		if (Auth::attempt($data, $request->remember)) {
			$request->session()->regenerate();
			return redirect()->intended('dashboard');
		}
		return back()->withErrors(['email' => 'Email or Password is wrong!'])->onlyInput('email');
	}

	public function destroy(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('home');
	}
}
