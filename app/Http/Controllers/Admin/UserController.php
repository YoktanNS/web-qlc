<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'user')
            ->with('profile')
            ->when($request->search, fn ($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
            )
            ->oldest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Admin tidak bisa dihapus.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
