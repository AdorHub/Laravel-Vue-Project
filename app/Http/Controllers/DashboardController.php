<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
	{
		$listings = $request->user()->type !== 'suspended' ? $request->user()->listings()->latest()->paginate(10) : null;
		return inertia('Dashboard', [
			'listings' => $listings,
			'status' => session('status')
		]);
	}
}
