<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil semua data user dari database
        $users = User::all();
        
        // Menampilkan halaman view kelola user
        return view('users.index', compact('users'));
    }

    // Jika nanti Anda ingin menambahkan fungsi tambah user, gunakan ini:
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User baru berhasil ditambahkan!');
    }
}
