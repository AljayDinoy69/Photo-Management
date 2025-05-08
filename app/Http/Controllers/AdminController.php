<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Listing;


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

    public function role(Request $request, User $user)
    {
        $request->validate([
            'role' => 'string|required',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.index')->with('status', "User role changed to {$request->role} successfully.");

    }
}
