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
    </style>
</head>
<body class="text-slate-800 antialiased">

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
        
        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span>👥</span> Daftar Akses Pengguna
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-600 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-6">ID</th>
                            <th class="py-3 px-6">Nama Pengguna</th>
                            <th class="py-3 px-6">Email</th>
                            <th class="py-3 px-6 text-center">Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-6 text-slate-500">{{ $user->id }}</td>
                            <td class="py-3 px-6 font-semibold text-slate-800">{{ $user->name }}</td>
                            <td class="py-3 px-6 text-indigo-600">{{ $user->email }}</td>
                            <td class="py-3 px-6 text-center text-slate-500">{{ $user->created_at->format('d M Y') }}</td>
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

</body>
</html>
