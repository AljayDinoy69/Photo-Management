<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Support\Facades\Gate;
use App\Http\Middleware\Admin;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('listings')
        ->filter(request(['search', 'user_role']))
        ->paginate(5)
        ->withQueryString();

        return Inertia::render('Admin/AdminDashboard', [
            'users' => $users,
            'status' => session('status')
        ]);
    }

    public function show(User $user)
    {
        $user_listings = $user
        ->listings()
        ->filter(request(['search', 'disapproved']))
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return Inertia::render('Admin/UserProfile', [
            'user' => $user,
            'listings' => $user_listings,
            'status' => session('status')
        ]);
    }

    public function role(Request $request, User $user)
    {
        Gate::authorize('modifyRole', $user);
        $request->validate([
            'role' => 'string|required'
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.index')->with('status', "User role changed to {$request->role} successfully.");

    }

    public function approve(Listing $listing)
    {

        Gate::authorize('approve', $listing);
        $listing->update(['approved' => !$listing->approved]);

        $msg = $listing->approved ? 'approved' : 'disapproved';
        return redirect()->back()->with('status', "Listing {$msg} successfully.");

    }
}
