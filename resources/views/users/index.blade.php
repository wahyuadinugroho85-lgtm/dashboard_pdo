<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        /* Animasi Modal */
        .modal-enter { animation: modalFadeIn 0.2s ease-out forwards; }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="text-slate-800 antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center gap-4">
            <a href="/laporan-manajemen" class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 p-2 rounded-lg transition-colors font-bold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-xl font-bold tracking-wide text-slate-800">Manajemen Pengguna</h1>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-4 py-8">
        
        <!-- Notifikasi -->
        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
                <strong class="font-bold">Error!</strong>
                <ul class="list-disc pl-5 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabel User -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span>👥</span> Daftar Akses Pengguna
                </h2>
                <button onclick="openAddModal()" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg transition-colors text-sm flex items-center gap-1 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah User
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-600 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-6 w-16">ID</th>
                            <th class="py-3 px-6">Nama Pengguna</th>
                            <th class="py-3 px-6 text-center w-48">Tanggal Dibuat</th>
                            <th class="py-3 px-6 text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-6 text-slate-500">{{ $user->id }}</td>
                            <td class="py-3 px-6 font-semibold text-slate-800">{{ $user->name }}</td>
                            <td class="py-3 px-6 text-center text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-6 flex justify-center gap-2">
                                <button onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="bg-amber-100 text-amber-700 hover:bg-amber-200 px-3 py-1.5 rounded text-xs font-bold transition-colors">Edit</button>
                                <button onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1.5 rounded text-xs font-bold transition-colors" {{ auth()->id() == $user->id ? 'disabled' : '' }}>Hapus</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-6 px-6 text-center text-slate-500 italic">Belum ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH USER -->
    <div id="modal-add" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex justify-center items-center">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden modal-enter">
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800">Tambah Pengguna Baru</h3>
                <button type="button" onclick="closeModal('modal-add')" class="text-slate-400 hover:text-rose-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('kelola.user.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-4 text-sm">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Nama Pengguna (Username)</label>
                        <input type="text" name="name" required class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:border-indigo-500 focus:outline-none" placeholder="Masukkan nama pengguna...">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Password</label>
                        <input type="password" name="password" required minlength="8" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:border-indigo-500 focus:outline-none" placeholder="Minimal 8 karakter">
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-add')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT USER -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex justify-center items-center">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden modal-enter">
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                <h3 class="font-bold text-slate-800">Edit Pengguna</h3>
                <button type="button" onclick="closeModal('modal-edit')" class="text-slate-400 hover:text-rose-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form id="form-edit" method="POST">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-4 text-sm">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Nama Pengguna (Username)</label>
                        <input type="text" name="name" id="edit-name" required class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Password Baru <span class="text-xs font-normal text-slate-400">(Kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password" minlength="8" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:border-indigo-500 focus:outline-none" placeholder="Minimal 8 karakter">
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-end gap-2">
                    <button type="button" onclick="closeModal('modal-edit')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg text-sm">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL HAPUS USER -->
    <div id="modal-delete" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex justify-center items-center">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden modal-enter">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-rose-100 flex items-center justify-center mx-auto mb-4 text-rose-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="font-bold text-lg text-slate-800 mb-2">Hapus Pengguna?</h3>
                <p class="text-sm text-slate-500 mb-6">Anda yakin ingin menghapus akses untuk <strong id="delete-name" class="text-slate-800"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
                
                <form id="form-delete" method="POST" class="flex justify-center gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeModal('modal-delete')" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold rounded-lg text-sm">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-lg text-sm">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Kontrol Modal -->
    <script>
        function openAddModal() {
            document.getElementById('modal-add').classList.remove('hidden');
        }

        function openEditModal(id, name) {
            document.getElementById('edit-name').value = name;
            document.getElementById('form-edit').action = '/kelola-user/' + id;
            document.getElementById('modal-edit').classList.remove('hidden');
        }

        function openDeleteModal(id, name) {
            document.getElementById('delete-name').innerText = name;
            document.getElementById('form-delete').action = '/kelola-user/' + id;
            document.getElementById('modal-delete').classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</body>
</html>
