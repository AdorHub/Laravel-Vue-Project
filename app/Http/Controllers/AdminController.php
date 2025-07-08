<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{	
	public function index()
	{
		$users = User::with('listings')
			->filter(request(['search', 'user_type']))
			->paginate(10)
			->withQueryString();
		return inertia('Admin/AdminDashboard', [
			'users' => $users,
			'status' => session('status')
		]);
	}

	public function show(User $user) {
		$listings = $user->listings()
			->filter(request(['search', 'disapproved']))
			->latest()
			->paginate(10)
			->withQueryString();
		return inertia('Admin/UserPage', [
			'user' => $user,
			'listings' => $listings,
			'status' => session('status')
		]);
	}

	public function type(Request $request, User $user)
	{
		Gate::authorize('modifyType', $user);
		$request->validate(['type' => 'required|string']);
		$user->update(['type' => $request->type]);
		return redirect()->route('admin.index')->with('status', 'User type changed to ' . strtoupper($request->type) . ' successfully!');
	}

	public function approve(Listing $listing)
	{
		Gate::authorize('approve', $listing);
		$listing->update([
			'approved' => !$listing->approved
		]);
		$msg = $listing->approved ? 'approved' : 'disapproved';
		return redirect()->back()->with('status', "Listing {$msg} successfully!");
	}
}
