<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function request()
	{
		return inertia('Auth/ForgotPassword', [
			'status' => session('status')
		]);
	}

	public function sendEmail(Request $request)
	{
		$request->validate(['email' => 'required|email']);
		$status = Password::sendResetLink(
			$request->only('email')
		);
		return $status === Password::ResetLinkSent ? back()->with(['status' => __($status)]) : back()->withErrors(['email' => __($status)]);
	}

	public function resetForm(Request $request)
	{
		return inertia('Auth/ResetPassword', [
			'email' => $request->email,
			'token' => $request->route('token')
		]);
	}

	public function resetHandler(Request $request)
	{
		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:3|confirmed',
		]);
		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function (User $user, string $password) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));
				$user->save();
				event(new PasswordReset($user));
			}
		);
		return $status === Password::PasswordReset ? redirect()->route('login')->with('status', __($status)) : back()->withErrors(['email' => [__($status)]]);
	}
}
