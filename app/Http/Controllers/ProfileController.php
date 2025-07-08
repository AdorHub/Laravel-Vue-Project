<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request)
	{
		return inertia('Profile/Edit', [
			'user' => $request->user(),
			'status' => session('status')
		]);
	}

	public function updateInfo(Request $request)
	{
		$data = $request->validate([
			'name' => 'required|max:255',
			'email' => ['required', 'email', 'lowercase', 'max:255', Rule::unique(User::class)->ignore($request->user()->id)]
		]);
		$request->user()->fill($data);
		if ($request->user()->isDirty('email')) {
			$request->user()->email_verified_at = null;
		}
		$request->user()->save();
		return redirect()->route('profile.edit');
	}

	public function updatePassword(Request $request)
	{
		$request->validate([
			'current_password' => 'required|current_password',
			'password' => 'required|confirmed|min:3'
		]);
		$request->user()->update([
			'password' => Hash::make($request->password)
		]);
		return redirect()->route('profile.edit');
	}

	public function destroy(Request $request)
	{
		$request->validate([
			'password' => 'required|current_password|min:3'
		]);
		$user = $request->user();
		Auth::logout();
		$user->delete();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect()->route('home');
	}
}
