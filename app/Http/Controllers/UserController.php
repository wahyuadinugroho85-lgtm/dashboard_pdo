<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        // Validasi: memastikan 'name' wajib diisi, max 255 karakter, dan belum dipakai user lain
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Karena tabel DB Laravel secara default mewajibkan ada 'email',
        // Kita buatkan email fiktif di belakang layar secara otomatis agar tidak error.
        $dummyEmail = strtolower(str_replace(' ', '', $request->name)) . rand(1000, 9999) . '@sistem.local';

        User::create([
            'name' => $request->name,
            'email' => $dummyEmail,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // Mengupdate data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8', // Password opsional saat edit
        ]);

        $user->name = $request->name;
        
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
        
        // Cegah pengguna menghapus akunnya sendiri (keamanan ekstra)
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }
        
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }
}
