<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Konstruktor pengunci akses (Hanya Admin)
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware(function ($request, $next) {
            // Cek murni dari kolom 'role' di database
            if (auth()->check() && auth()->user()->role !== 'admin') {
                abort(403, 'Akses Ditolak! Hanya Admin yang dapat mengelola user.');
            }
            return $next($request);
        });
    }

    // Menampilkan daftar user
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        // Validasi form ditambah role
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user', // Validasi pilihan role
        ]);

        // Email fiktif agar tidak error bawaan Laravel
        $dummyEmail = strtolower(str_replace(' ', '', $request->name)) . rand(1000, 9999) . '@sistem.local';

        User::create([
            'name' => $request->name,
            'email' => $dummyEmail,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Simpan role ke database
        ]);

        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // Mengupdate data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8', 
            'role' => 'required|in:admin,user', // Validasi update role
        ]);

        $user->name = $request->name;
        $user->role = $request->role; // Update role
        
        // Hanya update password jika kolom password diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cegah admin menghapus akunnya sendiri secara tidak sengaja
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }
        
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }
}