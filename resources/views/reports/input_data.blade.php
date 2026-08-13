<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Operasional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background-color: #f8fafc; } input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; } input[type="number"] { -moz-appearance: textfield; }</style>
</head>
<body class="text-slate-800 antialiased py-8 px-4">

    <div class="max-w-5xl mx-auto space-y-6">
        
        <div class="flex justify-between items-center mb-2">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Manajemen Data Laporan</h2>
                <p class="text-sm font-medium text-slate-500 mt-1">Pilih metode input manual atau upload via Excel.</p>
            </div>
            <a href="/laporan-manajemen" class="bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                &larr; Lihat Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-200 font-bold flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-rose-50 text-rose-700 rounded-lg border border-rose-200 font-bold flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-emerald-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-emerald-100 bg-emerald-50/50 flex justify-between items-center">
                <h3 class="text-base font-bold text-emerald-800 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Import Data Cepat via Excel
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <form action="/import-data" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih File Excel (.xlsx / .csv)</label>
                            <input type="file" name="file_excel" accept=".xlsx,.xls,.csv" class="w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-md cursor-pointer" required>
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-md shadow transition-colors">
                            Mulai Upload & Proses Data
                        </button>
                    </form>
                </div>
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 text-sm">
                    <strong class="text-slate-800 block mb-2">PENTING: Aturan Format Header Excel</strong>
                    <p class="text-slate-600 mb-2">Unduh file template di bawah ini. Pastikan Anda <strong>tidak mengubah nama kolom (baris ke-1)</strong> agar sistem dapat membacanya dengan benar.</p>
                    <code class="block bg-slate-800 text-emerald-400 p-3 rounded text-xs overflow-x-auto leading-relaxed whitespace-nowrap">
                        kode_pt | tipe_data | bulan | tahun | tonase | janjang | hk_panen | luas_cavel | hs_ha | hs_pokok | kunjungan | ha_hk | kg_hk | ton_cpo | ton_ker | ton_pko | cost_panen | cost_rawat | cost_kantor | cost_teknik | cost_pks | bgt_cost_palm_produk | bgt_cost_palm_oil | rwt_piringan_ha | ppt_chemist_ha | rwt_gawangan_man_ha | rwt_gawangan_chem_ha | pruning_ha | pupuk_dolomite_kg | pupuk_kieserite_kg | pupuk_kaptan_kg | pupuk_tsp_kg | pupuk_urea_kg | pupuk_mop_kg | pupuk_mikro_kg | mutu_unripe | mutu_ripe | mutu_over_ripe | mutu_empty_bunch | mutu_abnormal | tk_umur_kurang_25 | tk_umur_25_40 | tk_umur_40_50 | tk_umur_lebih_50 | tk_status_kk | tk_status_lj | tk_masa_kurang_1bln | tk_masa_2_3bln | tk_masa_lebih_3bln | tk_mutasi_masuk_bi | tk_mutasi_masuk_sbi | tk_mutasi_keluar_bi | tk_mutasi_keluar_sbi
                    </code>
                    
                    <div class="mt-5 border-t border-slate-200 pt-4">
                        <a href="/download-template" class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-4 py-2 rounded-md transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download File Template (.xlsx)
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 py-2">
            <div class="h-px bg-slate-300 flex-1"></div>
            <span class="text-slate-400 font-bold text-sm uppercase tracking-widest">ATAU INPUT MANUAL</span>
            <div class="h-px bg-slate-300 flex-1"></div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-800">Form Input Data Laporan Terpadu</h3>
            </div>
            
            <div class="p-6">
                <div class="mb-4 text-xs font-medium text-amber-700 bg-amber-50 p-3 rounded border border-amber-200">
                    <strong>Tips Edit Data:</strong> Jika ada kesalahan input, cukup pilih kembali Identitas Data (PT, Tipe, Bulan, Tahun) yang sama, lalu masukkan angka yang benar. Sistem otomatis menimpa data.
                </div>

                <form action="/input-data" method="POST" class="space-y-8" id="form-input">
                    @csrf
                    
                    <div class="bg-indigo-50/50 p-5 rounded-lg border border-indigo-100">
                        <h3 class="text-sm font-bold text-indigo-900 mb-4 uppercase tracking-wider">Identitas Data</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Pilih Divisi / PT</label>
                                <select name="estate_id" class="w-full border border-slate-300 rounded p-2 focus:ring-2 focus:ring-indigo-500 text-sm" required>
                                    @foreach($estates as $estate) <option value="{{ $estate->id }}">{{ $estate->kode }}</option> @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Tipe Data</label>
                                <select name="tipe" class="w-full border border-slate-300 rounded p-2 focus:ring-2 focus:ring-indigo-500 text-sm" required>
                                    <option value="REAL">Realisasi (REAL)</option>
                                    <option value="RKB">Target Bulanan (RKB)</option>
                                    <option value="BUDGET">Budget Tahunan</option>
                                    <option value="SENSUS">E-Sensus</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Bulan</label>
                                <select name="bulan" class="w-full border border-slate-300 rounded p-2 focus:ring-2 focus:ring-indigo-500 text-sm" required>
                                    @for($i=1; $i<=12; $i++) <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>Bulan {{ $i }}</option> @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2">Tahun</label>
                                <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full border border-slate-300 rounded p-2 focus:ring-2 focus:ring-indigo-500 text-sm" required>
                            </div>
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-lg overflow-hidden">
                        <div class="bg-slate-100 px-4 py-3 border-b border-slate-200"><h3 class="text-sm font-bold text-slate-800">1. Data Produksi & Mill</h3></div>
                        <div class="p-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 bg-white">
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Tonase TBS (Kg)</label><input type="number" step="0.01" name="produksi[tonase]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Janjang</label><input type="number" name="produksi[janjang]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">HK Panen</label><input type="number" step="0.01" name="produksi[hk_panen]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Luas Cavel (Ha)</label><input type="number" step="0.01" name="produksi[luas_cavel]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Kunjungan</label><input type="number" step="0.01" name="produksi[kunjungan]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">HS (Ha)</label><input type="number" step="0.01" name="produksi[hs_ha]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">HS (Pokok)</label><input type="number" name="produksi[hs_pokok]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Ha / Hk</label><input type="number" step="0.01" name="produksi[ha_hk]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Kg / Hk</label><input type="number" step="0.01" name="produksi[kg_hk]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1 text-yellow-600">Ton CPO</label><input type="number" step="0.01" name="produksi[ton_cpo]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1 text-yellow-600">Ton KER</label><input type="number" step="0.01" name="produksi[ton_ker]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1 text-yellow-600">Ton PKO</label><input type="number" step="0.01" name="produksi[ton_pko]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-lg overflow-hidden">
                        <div class="bg-slate-100 px-4 py-3 border-b border-slate-200"><h3 class="text-sm font-bold text-slate-800">2. Biaya Operasional (Rp)</h3></div>
                        <div class="p-4 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 bg-white">
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Panen</label><input type="number" name="biaya[cost_panen]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Rawat</label><input type="number" name="biaya[cost_rawat]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Kantor</label><input type="number" name="biaya[cost_kantor]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">Teknik</label><input type="number" name="biaya[cost_teknik]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">PKS</label><input type="number" name="biaya[cost_pks]" placeholder="0" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            
                            <!-- INPUT BUDGET KHUSUS UNTUK TIPE DATA BUDGET -->
                            <div class="bg-indigo-50 p-2 rounded border border-indigo-100"><label class="block text-xs font-bold text-indigo-700 mb-1">Bgt Cost Palm Prod</label><input type="number" step="0.01" name="biaya[bgt_cost_palm_produk]" placeholder="Rp/Kg" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            <div class="bg-indigo-50 p-2 rounded border border-indigo-100"><label class="block text-xs font-bold text-indigo-700 mb-1">Bgt Cost Palm Oil</label><input type="number" step="0.01" name="biaya[bgt_cost_palm_oil]" placeholder="Rp/Kg" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border border-slate-200 rounded-lg overflow-hidden bg-white">
                            <div class="bg-slate-100 px-4 py-3 border-b border-slate-200"><h3 class="text-sm font-bold text-slate-800">3. Perawatan Kebun (Ha)</h3></div>
                            <div class="p-4 space-y-3">
                                @foreach($jenisPerawatan as $rawat)
                                <div class="flex items-center justify-between gap-3">
                                    <label class="text-xs font-semibold text-slate-700 w-1/2 truncate">{{ $rawat }}</label>
                                    <input type="number" step="0.01" name="rawat[{{ $rawat }}][luas_ha]" placeholder="Luas (Ha)" class="w-1/2 border border-slate-300 rounded p-1.5 text-sm">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="border border-slate-200 rounded-lg overflow-hidden bg-white">
                            <div class="bg-slate-100 px-4 py-3 border-b border-slate-200"><h3 class="text-sm font-bold text-slate-800">4. Aplikasi Pupuk (Ton)</h3></div>
                            <div class="p-4 space-y-3">
                                @foreach($jenisPupuk as $pupuk)
                                <div class="flex items-center justify-between gap-3">
                                    <label class="text-xs font-semibold text-slate-700 w-1/2 truncate">{{ $pupuk }}</label>
                                    <input type="number" step="0.01" name="pupuk[{{ $pupuk }}][jumlah_kg]" placeholder="Jumlah (Ton)" class="w-1/2 border border-slate-300 rounded p-1.5 text-sm">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-lg overflow-hidden">
                        <div class="bg-slate-100 px-4 py-3 border-b border-slate-200"><h3 class="text-sm font-bold text-slate-800">5. Kualitas / Mutu Ancak (%)</h3></div>
                        <div class="p-4 grid grid-cols-2 md:grid-cols-5 gap-4 bg-white">
                            @foreach($kriteriaMutu as $mutu)
                            <div><label class="block text-xs font-semibold text-slate-600 mb-1">{{ $mutu }}</label><input type="number" step="0.01" name="mutu[{{ $mutu }}][persentase]" placeholder="0%" class="w-full border border-slate-300 rounded p-2 text-sm"></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-lg overflow-hidden">
                        <div class="bg-slate-100 px-4 py-3 border-b border-slate-200"><h3 class="text-sm font-bold text-slate-800">6. Kinerja Tenaga Kerja</h3></div>
                        <div class="p-5 bg-white space-y-6">
                            @foreach($subKategoriPekerja as $kategori => $subs)
                            <div>
                                <h4 class="text-xs font-bold text-indigo-700 uppercase mb-3 border-b border-slate-100 pb-2">{{ $kategori }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    @foreach($subs as $sub)
                                    <div class="bg-slate-50 p-3 rounded-md border border-slate-200 shadow-sm">
                                        <label class="block text-xs font-semibold text-slate-700 mb-2">{{ $sub }}</label>
                                        <div class="flex gap-2">
                                            <input type="number" name="pekerja[{{ $kategori }}][{{ $sub }}][jumlah_tk]" placeholder="Jml TK" class="w-1/2 border border-slate-300 rounded p-1.5 text-sm outline-none focus:ring-1 focus:ring-indigo-500">
                                            <input type="number" step="0.01" name="pekerja[{{ $kategori }}][{{ $sub }}][persentase]" placeholder="Pct (%)" class="w-1/2 border border-slate-300 rounded p-1.5 text-sm outline-none focus:ring-1 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-6 mt-6 flex justify-end gap-3 border-t border-slate-200">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-md shadow-md transition-colors w-full md:w-auto">Simpan Data Manual</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    if (e.target.tagName === 'BUTTON' && e.target.type === 'submit') return true;
                    if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') {
                        e.preventDefault();
                        const form = e.target.closest('form');
                        if (!form) return;
                        const focusableElements = Array.from(form.querySelectorAll('input:not([type="hidden"]):not([disabled]), select:not([disabled]), button[type="submit"]'));
                        const currentIndex = focusableElements.indexOf(e.target);
                        if (currentIndex > -1 && currentIndex < focusableElements.length - 1) {
                            focusableElements[currentIndex + 1].focus();
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>