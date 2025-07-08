<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function notice()
	{
		return inertia('Auth/VerifyEmail', [
			'status' => session('status')
		]);
	}

	public function handle(EmailVerificationRequest $request)
	{
		$request->fulfill();
		return redirect()->route('home');
	}

	public function resend(Request $request)
	{
		$request->user()->sendEmailVerificationNotification();
		return back()->with('status', 'Verification link sent!');
	}
}
