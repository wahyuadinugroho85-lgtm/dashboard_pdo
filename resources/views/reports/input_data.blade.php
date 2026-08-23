<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Laporan Operasional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        .tab-active { background-color: #4f46e5; color: white; border-color: #4f46e5; }
        .tab-inactive { background-color: white; color: #64748b; border-color: #e2e8f0; }
        .form-input { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-size: 0.875rem; outline: none; transition: border-color 0.2s; }
        .form-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2); }
        .form-label { display: block; font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.025em; }
    </style>
</head>
<body class="text-slate-800 antialiased">

    <!-- Navbar -->
    <nav class="bg-indigo-600 px-6 py-4 flex justify-between items-center shadow-md text-white sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <a href="/laporan-manajemen" class="hover:bg-indigo-700 p-2 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-xl font-bold tracking-wide">Portal Entry Data Operasional</h1>
        </div>
        <div class="text-sm font-medium bg-indigo-800 px-4 py-1.5 rounded-full">
            👤 {{ Auth::user()->name ?? 'Staf Data Entry' }}
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- PANEL KIRI: IMPORT & EXPORT EXCEL -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                    
                    <!-- BOX IMPORT -->
                    <h2 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-3 mb-4 flex items-center gap-2">
                        <span>📥</span> Import Data Cepat (Excel)
                    </h2>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed">Gunakan fitur ini jika Anda sudah mengisi data menggunakan template Excel yang disediakan. Pastikan format kolom tidak diubah.</p>
                    <form action="/import-data" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="file" name="file_excel" required class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-200 rounded-lg p-1">
                        <div class="flex gap-2">
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg transition-colors shadow-sm text-sm">Unggah Excel</button>
                            <a href="/download-template" class="w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2 px-4 rounded-lg transition-colors border border-slate-300 text-sm">Unduh Template</a>
                        </div>
                    </form>

                    <!-- BOX EXPORT -->
                    <h2 class="text-lg font-bold text-slate-800 border-b border-slate-200 pb-3 mt-8 mb-4 flex items-center gap-2">
                        <span>📤</span> Export Data Terinput
                    </h2>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed">Unduh data bulan tertentu yang sudah ada di sistem ke dalam format Excel untuk melihat, merevisi, atau membackup data.</p>
                    <form action="{{ route('export.data') }}" method="GET" class="space-y-4">
                        <div class="flex gap-2">
                            <select name="bulan" required class="form-input bg-white w-1/2">
                                @for($i=1; $i<=12; $i++) <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>Bulan {{ $i }}</option> @endfor
                            </select>
                            <select name="tahun" required class="form-input bg-white w-1/2">
                                @for($i=2023; $i<=date('Y')+1; $i++) <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors shadow-sm text-sm">Download Data (.xlsx)</button>
                    </form>
                    
                </div>

                <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-5 text-indigo-800 text-sm shadow-sm">
                    <h3 class="font-bold mb-2 flex items-center gap-2"><span>💡</span> Panduan Input Manual</h3>
                    <ul class="list-disc pl-5 space-y-1 opacity-90">
                        <li>Pilih Divisi/PT, Periode, dan Jenis Data (RKB/REAL) terlebih dahulu di Panel Kanan.</li>
                        <li>Isi form sesuai dengan kelompok tabulasinya.</li>
                        <li>Kosongkan kolom (jangan diisi 0) jika data memang tidak tersedia atau belum ada, agar sistem tidak menghitungnya sebagai *pembagi* rata-rata.</li>
                    </ul>
                </div>
            </div>

            <!-- PANEL KANAN: FORM MANUAL INTERAKTIF -->
            <div class="w-full lg:w-2/3">
                <form action="/input-data" method="POST" id="mainForm" class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                    @csrf
                    
                    <!-- HEADER FORM: Kunci Utama (Wajib) -->
                    <div class="bg-slate-50 border-b border-slate-200 p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="form-label">Divisi / PT *</label>
                                <select name="estate_id" required class="form-input bg-white font-bold text-indigo-700">
                                    <option value="">-- Pilih PT --</option>
                                    @foreach($estates as $estate) <option value="{{ $estate->id }}">{{ $estate->kode }} - {{ $estate->nama }}</option> @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Bulan *</label>
                                <select name="bulan" required class="form-input bg-white">
                                    @for($i=1; $i<=12; $i++) <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>Bulan {{ $i }}</option> @endfor
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Tahun *</label>
                                <select name="tahun" required class="form-input bg-white">
                                    @for($i=2023; $i<=date('Y')+1; $i++) <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Jenis Data *</label>
                                <select name="tipe" required class="form-input bg-emerald-50 font-bold text-emerald-700 border-emerald-300">
                                    <option value="REAL">REAL (Aktual)</option>
                                    <option value="RKB">RKB (Rencana)</option>
                                    <option value="BUDGET">BUDGET TAHUNAN</option>
                                    <option value="SENSUS">E-SENSUS</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- TABULASI MENU -->
                    <div class="flex flex-wrap border-b border-slate-200 bg-slate-50/50 p-2 gap-2">
                        <button type="button" onclick="openTab('prod')" id="btn-prod" class="tab-btn tab-active px-4 py-2 text-sm font-bold rounded-md border">Produksi & Biaya</button>
                        <button type="button" onclick="openTab('rawat')" id="btn-rawat" class="tab-btn tab-inactive px-4 py-2 text-sm font-bold rounded-md border">Rawat & Pruning</button>
                        <button type="button" onclick="openTab('pupuk')" id="btn-pupuk" class="tab-btn tab-inactive px-4 py-2 text-sm font-bold rounded-md border">Pupuk & Mutu</button>
                        <button type="button" onclick="openTab('sdm')" id="btn-sdm" class="tab-btn tab-inactive px-4 py-2 text-sm font-bold rounded-md border">SDM & Kinerja</button>
                    </div>

                    <!-- ISI TAB 1: PRODUKSI & BIAYA -->
                    <div id="tab-prod" class="tab-content block p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Kolom Produksi -->
                            <div class="space-y-4">
                                <h3 class="font-bold text-indigo-700 border-b pb-2">Data Produksi Inti</h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <div><label class="form-label">Tonase TBS (Kg)</label><input type="number" step="0.01" name="produksi[tonase]" class="form-input"></div>
                                    <div><label class="form-label">Janjang Panen</label><input type="number" step="1" name="produksi[janjang]" class="form-input"></div>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div><label class="form-label">Hektar Statement (Ha)</label><input type="number" step="0.01" name="produksi[hs_ha]" class="form-input"></div>
                                    <div><label class="form-label">HS Pokok</label><input type="number" step="1" name="produksi[hs_pokok]" class="form-input"></div>
                                    <div><label class="form-label">Ha Cavel (Real)</label><input type="number" step="0.01" name="produksi[ha_cavel_real]" class="form-input" placeholder="0.00"></div>
                                </div>
                                <div class="grid grid-cols-3 gap-3">
                                    <div><label class="form-label">HK Panen</label><input type="number" step="0.01" name="produksi[hk_panen]" class="form-input"></div>
                                    <div><label class="form-label">Kunjungan</label><input type="number" step="0.01" name="produksi[kunjungan]" class="form-input"></div>
                                    <div><label class="form-label">Ha/Hk</label><input type="number" step="0.01" name="produksi[ha_hk]" class="form-input"></div>
                                </div>
                                
                                <div class="mt-3">
                                    <label class="form-label text-indigo-700 font-bold">HKE (Hari Kerja Efektif) - WAJIB DIISI!</label>
                                    <p class="text-[10px] text-slate-500 mb-1 leading-tight">Bulan Ini misal: 26. Bulan Depan (RKB) misal: 24.</p>
                                    <input type="number" step="1" name="produksi[hke]" class="form-input w-1/3 bg-indigo-50 border-indigo-300 font-bold text-indigo-700" placeholder="Contoh: 26">
                                </div>
                                
                                <h3 class="font-bold text-indigo-700 border-b pb-2 pt-4">Data Ekstraksi Mill (Ton)</h3>
                                <div class="grid grid-cols-3 gap-3">
                                    <div><label class="form-label">Produksi CPO</label><input type="number" step="0.01" name="produksi[ton_cpo]" class="form-input"></div>
                                    <div><label class="form-label">Produksi KER</label><input type="number" step="0.01" name="produksi[ton_ker]" class="form-input"></div>
                                    <div><label class="form-label">Produksi PKO</label><input type="number" step="0.01" name="produksi[ton_pko]" class="form-input"></div>
                                </div>
                            </div>
                            
                            <!-- Kolom Biaya -->
                            <div class="space-y-4">
                                <h3 class="font-bold text-amber-700 border-b pb-2">Biaya Operasional (Rp)</h3>
                                <div><label class="form-label">Biaya Panen</label><input type="number" step="1" name="biaya[cost_panen]" class="form-input"></div>
                                <div><label class="form-label">Biaya Rawat</label><input type="number" step="1" name="biaya[cost_rawat]" class="form-input"></div>
                                <div><label class="form-label">Biaya Kantor/Admin</label><input type="number" step="1" name="biaya[cost_kantor]" class="form-input"></div>
                                <div><label class="form-label">Biaya Teknik</label><input type="number" step="1" name="biaya[cost_teknik]" class="form-input"></div>
                                <div><label class="form-label">Biaya PKS</label><input type="number" step="1" name="biaya[cost_pks]" class="form-input"></div>
                                <div><label class="form-label font-bold text-emerald-700">Biaya PDO (Bi)</label><input type="number" step="1" name="biaya[pdo_bi]" class="form-input w-1/2" placeholder="Rp..."></div>
                                
                                <div class="bg-amber-50 p-3 rounded-lg mt-4 border border-amber-200">
                                    <h4 class="text-xs font-bold text-amber-800 mb-2">Khusus Target Budget (Hanya diisi jika memilih Jenis Data BUDGET)</h4>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div><label class="form-label">Bgt Cost Palm Produk (Rp/Kg)</label><input type="number" step="0.01" name="biaya[bgt_cost_palm_produk]" class="form-input"></div>
                                        <div><label class="form-label">Bgt Cost Palm Oil (Rp/Kg)</label><input type="number" step="0.01" name="biaya[bgt_cost_palm_oil]" class="form-input"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ISI TAB 2: RAWAT & PRUNING -->
                    <div id="tab-rawat" class="tab-content hidden p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <h3 class="font-bold text-teal-700 border-b pb-2">Perawatan Kebun Standar</h3>
                                @foreach($jenisPerawatan as $rawat)
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 flex items-center justify-between gap-2">
                                    <div class="w-2/5 font-semibold text-sm text-slate-700">{{ $rawat }}</div>
                                    <div class="w-1/5"><label class="form-label text-[10px]">Luas (Ha)</label><input type="number" step="0.01" name="rawat[{{ $rawat }}][luas_ha]" class="form-input px-2 py-1"></div>
                                    <div class="w-1/5"><label class="form-label text-[10px]">Jml Blok</label><input type="number" step="1" name="rawat[{{ $rawat }}][jml_blok]" class="form-input px-2 py-1"></div>
                                    <div class="w-1/5"><label class="form-label text-[10px] text-amber-600">Cost/Ha (Rp)</label><input type="number" step="1" name="rawat[{{ $rawat }}][cost_ha]" class="form-input border-amber-300 px-2 py-1" placeholder="Rp..."></div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="space-y-4">
                                <h3 class="font-bold text-teal-700 border-b pb-2 flex items-center gap-2">
                                    <span>✂️</span> Modul Rotasi Pruning
                                </h3>
                                @foreach($kategoriPruning as $kp)
                                <div class="bg-teal-50 p-3 rounded-lg border border-teal-100 flex items-center justify-between gap-2">
                                    <div class="w-2/5 font-semibold text-sm text-teal-800">{{ $kp }}</div>
                                    <div class="w-1/5"><label class="form-label text-[10px] text-teal-700">Luas (Ha)</label><input type="number" step="0.01" name="rawat[{{ $kp }}][luas_ha]" class="form-input border-teal-300 px-2 py-1"></div>
                                    <div class="w-1/5"><label class="form-label text-[10px] text-teal-700">Jml Blok</label><input type="number" step="1" name="rawat[{{ $kp }}][jml_blok]" class="form-input border-teal-300 px-2 py-1"></div>
                                    <div class="w-1/5"><label class="form-label text-[10px] text-amber-600">Cost/Ha (Rp)</label><input type="number" step="1" name="rawat[{{ $kp }}][cost_ha]" class="form-input border-amber-300 px-2 py-1" placeholder="Rp..."></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- ISI TAB 3: PUPUK & MUTU -->
                    <div id="tab-pupuk" class="tab-content hidden p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <h3 class="font-bold text-yellow-700 border-b pb-2">Aplikasi Pupuk (Kg)</h3>
                                @foreach($jenisPupuk as $pupuk)
                                <div class="flex items-center justify-between gap-4 bg-slate-50 p-2 border-b border-slate-100 rounded">
                                    <div class="w-1/2 font-semibold text-sm text-slate-700">{{ $pupuk }}</div>
                                    <div class="w-1/2"><input type="number" step="0.01" name="pupuk[{{ $pupuk }}][jumlah_kg]" class="form-input" placeholder="Total Kg..."></div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="space-y-4">
                                <h3 class="font-bold text-sky-700 border-b pb-2">Kriteria Mutu Buah (%)</h3>
                                @foreach($kriteriaMutu as $mutu)
                                <div class="flex items-center justify-between gap-4 bg-slate-50 p-2 border-b border-slate-100 rounded">
                                    <div class="w-1/2 font-semibold text-sm text-slate-700">{{ $mutu }}</div>
                                    <div class="w-1/2 relative">
                                        <input type="number" step="0.01" name="mutu[{{ $mutu }}][persentase]" class="form-input pr-8" placeholder="0.00">
                                        <span class="absolute right-3 top-2 text-slate-400 font-bold">%</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- ISI TAB 4: TENAGA KERJA -->
                    <div id="tab-sdm" class="tab-content hidden p-6">
                        <p class="text-xs text-slate-500 mb-4 bg-blue-50 p-3 rounded-lg border border-blue-100">
                            Isi jumlah orang (TK/Hk) pada kolom yang tersedia. Khusus untuk Kelas Pemanen, isikan juga Avr/Bln nya.
                        </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($subKategoriPekerja as $kategori => $subs)
                            <div class="bg-white border border-slate-200 rounded-lg shadow-sm overflow-hidden">
                                <h4 class="font-bold text-white text-xs bg-slate-700 px-3 py-2 uppercase">{{ $kategori }}</h4>
                                <div class="p-3 space-y-2">
                                    @foreach($subs as $sub)
                                    <div class="flex items-center justify-between gap-2">
                                        <label class="text-sm text-slate-600 font-medium w-1/3 truncate" title="{{ $sub }}">{{ $sub }}</label>
                                        <input type="number" step="1" name="pekerja[{{ $kategori }}][{{ $sub }}][jumlah_tk]" class="form-input w-1/3 text-center px-1" placeholder="TK">
                                        @if($kategori == 'Kelas Pemanen')
                                            <input type="number" step="0.01" name="pekerja[{{ $kategori }}][{{ $sub }}][avr_bln]" class="form-input w-1/3 text-center px-1 border-emerald-300" placeholder="Avr/Bln">
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- TOMBOL SUBMIT FINAL -->
                    <div class="bg-slate-100 border-t border-slate-200 p-6 flex justify-end gap-3">
                        <button type="reset" class="px-6 py-2.5 bg-white border border-slate-300 text-slate-600 font-bold rounded-lg hover:bg-slate-50 transition-colors shadow-sm text-sm">Kosongkan Form</button>
                        <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md transition-all transform hover:-translate-y-0.5 text-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Seluruh Data
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPT TABULASI -->
    <script>
        function openTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => {
                el.classList.remove('block');
                el.classList.add('hidden');
            });
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('tab-active');
                el.classList.add('tab-inactive');
            });
            
            document.getElementById('tab-' + tabId).classList.remove('hidden');
            document.getElementById('tab-' + tabId).classList.add('block');
            
            document.getElementById('btn-' + tabId).classList.remove('tab-inactive');
            document.getElementById('btn-' + tabId).classList.add('tab-active');
        }
    </script>
    
    <!-- SCRIPT UNTUK MENYIMPAN PILIHAN FORM SECARA OTOMATIS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Nama "name" dari elemen select dropdown di halaman input Anda
            const formFields = ['estate_id', 'tipe', 'bulan', 'tahun'];
            
            formFields.forEach(field => {
                const el = document.querySelector(`select[name="${field}"]`);
                if (el) {
                    // 1. Saat halaman baru dimuat, kembalikan ke pilihan sebelumnya
                    const savedVal = localStorage.getItem(`input_${field}`);
                    if (savedVal) {
                        el.value = savedVal; 
                    }
                    
                    // 2. Jika Bapak mengubah pilihan dropdown, otomatis catat di memori
                    el.addEventListener('change', function() {
                        localStorage.setItem(`input_${field}`, this.value);
                    });
                }
            });

            // 3. Cadangan: Pastikan memori tercatat juga saat tombol "Simpan" ditekan
            const formInput = document.getElementById('mainForm');
            if(formInput) {
                formInput.addEventListener('submit', function() {
                    formFields.forEach(field => {
                        const el = document.querySelector(`select[name="${field}"]`);
                        if(el) localStorage.setItem(`input_${field}`, el.value);
                    });
                });
            }
        });
    </script>
</body>
</html>
