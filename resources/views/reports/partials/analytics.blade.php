<style>
    /* =========================================================
       HANYA BERLAKU SAAT MODE PRESENTASI (FULLSCREEN)
       ========================================================= */
       
    /* 1. Background Animasi Mewah (Dark Gradient) */
    @keyframes moveGradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    #analytics-container:fullscreen, 
    #analytics-container:-webkit-full-screen {
        background: linear-gradient(-45deg, #0f172a, #1e1b4b, #09090b, #172554);
        background-size: 400% 400%;
        animation: moveGradient 15s ease infinite;
        padding: 3rem;
        overflow-y: auto;
    }

    /* 2. Efek Card Kaca Transparan & Animasi Masuk berurutan */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    #analytics-container:fullscreen .widget-item {
        background: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        color: #f8fafc !important;
        opacity: 0;
        animation: fadeUp 0.8s ease forwards;
    }
    
    #analytics-container:fullscreen .widget-item:nth-child(1) { animation-delay: 0.1s; }
    #analytics-container:fullscreen .widget-item:nth-child(2) { animation-delay: 0.2s; }
    #analytics-container:fullscreen .widget-item:nth-child(3) { animation-delay: 0.3s; }
    #analytics-container:fullscreen .widget-item:nth-child(4) { animation-delay: 0.4s; }
    #analytics-container:fullscreen .widget-item:nth-child(5) { animation-delay: 0.5s; }

    /* 3. Efek Sorot (Hover) Mewah dengan Glowing */
    #analytics-container:fullscreen .widget-item:hover {
        transform: translateY(-5px) scale(1.01);
        border-color: rgba(56, 189, 248, 0.6) !important; /* Warna cyan/biru neon */
        box-shadow: 0 15px 35px rgba(56, 189, 248, 0.2);
        z-index: 50;
    }

    /* 4. Perubahan Teks agar terbaca di Background Gelap */
    #analytics-container:fullscreen h3 { color: #ffffff !important; }
    #analytics-container:fullscreen .text-slate-800, 
    #analytics-container:fullscreen .text-slate-900,
    #analytics-container:fullscreen .text-slate-700,
    #analytics-container:fullscreen .text-slate-600 { color: #f8fafc !important; }
    
    #analytics-container:fullscreen .text-slate-500, 
    #analytics-container:fullscreen .text-slate-400 { color: #cbd5e1 !important; }
    
    #analytics-container:fullscreen .bg-white,
    #analytics-container:fullscreen .bg-slate-50,
    #analytics-container:fullscreen .bg-slate-100,
    #analytics-container:fullscreen .bg-slate-200 { background: transparent !important; }
    
    #analytics-container:fullscreen table th { background: rgba(255, 255, 255, 0.1) !important; color: #e2e8f0 !important; }
    #analytics-container:fullscreen table td { border-color: rgba(255, 255, 255, 0.15) !important; color: #f8fafc !important; }

    /* PERBAIKAN HOVER TABEL: Mencegah baris jadi putih saat disorot */
    #analytics-container:fullscreen table tbody tr:hover,
    #analytics-container:fullscreen table tbody tr:hover > td,
    #analytics-container:fullscreen table tbody tr:hover > th {
        background-color: rgba(255, 255, 255, 0.15) !important; 
        color: #ffffff !important; 
    }

    /* 5. TOOLTIP PREMIUM (Sangat Kontras, Terang, & Jelas) */
    #analytics-container:fullscreen .tooltip-table .tooltip-box {
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(16px);
        border: 1px solid #cbd5e1 !important; 
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3) !important; 
    }
    
    #analytics-container:fullscreen .tooltip-table .tooltip-box * {
        color: #1e293b !important; 
    }
    #analytics-container:fullscreen .tooltip-table .tooltip-box th { 
        border-bottom-color: #cbd5e1 !important; 
        color: #475569 !important; 
        background: transparent !important;
    }
    #analytics-container:fullscreen .tooltip-table .tooltip-box td { 
        border-bottom-color: #f1f5f9 !important; 
    }
    
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-emerald-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-emerald-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-emerald-600 { color: #059669 !important; }
    
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-amber-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-amber-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-amber-600 { color: #d97706 !important; }
    
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-rose-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-rose-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-rose-600 { color: #e11d48 !important; }
    
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-sky-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-sky-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-sky-600 { color: #0284c7 !important; }
    
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-yellow-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-yellow-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-yellow-600 { color: #ca8a04 !important; }
    
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-indigo-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-indigo-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-indigo-600 { color: #4f46e5 !important; }
    
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-orange-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-orange-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-orange-600 { color: #ea580c !important; }

    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-purple-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-purple-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-purple-600 { color: #9333ea !important; }

    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-cyan-300,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-cyan-400,
    #analytics-container:fullscreen .tooltip-table .tooltip-box .text-cyan-600 { color: #0891b2 !important; }

    /* Mencegah teks terpotong melipat ke bawah di tooltip */
    .tooltip-box table { white-space: nowrap; }

    /* 6. Tombol Exit Melayang Canggih */
    @keyframes pulseNeon {
        0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }
    
    #floating-exit-btn { display: none; }
    #analytics-container:fullscreen #floating-exit-btn {
        display: flex; position: fixed; top: 2rem; right: 3rem; z-index: 9999;
        background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px);
        border: 1px solid rgba(226, 232, 240, 1); color: #ef4444;
        padding: 0.75rem 1.5rem; border-radius: 50px;
        align-items: center; gap: 0.5rem; font-weight: bold; cursor: pointer;
        transition: all 0.3s ease; animation: pulseNeon 2s infinite;
    }
    #analytics-container:fullscreen #floating-exit-btn:hover {
        background: #ef4444; color: white; border-color: #ef4444; animation: none;
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.6);
    }
    
    #analytics-container:fullscreen .hide-on-fullscreen { display: none !important; }
    #analytics-container:fullscreen .fullscreen-header { display: block !important; }
</style>

<div id="tab-analytics" class="tab-content block w-full space-y-6">
    <div id="analytics-container" class="transition-all duration-300 rounded-xl relative">
        
        <!-- Tombol Floating Keluar Presentasi -->
        <button id="floating-exit-btn" onclick="document.exitFullscreen()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            Tutup Presentasi
        </button>

        @php
            $gPctCostOil = $gCostPalmOilBgt > 0 ? ($gCostPalmOilReal / $gCostPalmOilBgt) * 100 : 0;
        @endphp

        <div class="bg-gradient-to-r from-indigo-700 via-blue-600 to-sky-500 rounded-2xl shadow-lg p-6 mb-6 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hide-on-fullscreen">
            <div>
                <h2 class="text-3xl font-extrabold tracking-wide mb-1">Executive Analytics Summary</h2>
                <p class="text-indigo-100 font-medium opacity-90 text-sm">Capaian Kinerja Operasional s.d {{ $namaBulanIni }} {{ $tahun }}</p>
            </div>
            <div class="flex gap-2">
                <button onclick="document.getElementById('modal-layout').classList.remove('hidden')" class="bg-white/20 hover:bg-white/30 text-white backdrop-blur-sm border border-white/30 text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Sesuaikan Widget
                </button>
                <button onclick="toggleFullscreen()" class="bg-white text-indigo-700 hover:bg-slate-50 text-sm font-bold px-4 py-2.5 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                    Mode Presentasi
                </button>
            </div>
        </div>

        <!-- Judul Header Muncul HANYA di Mode Presentasi -->
        <div class="hidden fullscreen-header text-center mb-10 w-full" style="display: none;">
            <h1 class="text-4xl font-extrabold text-white tracking-widest uppercase mb-2">Executive Analytics Dashboard</h1>
            <p class="text-xl text-cyan-400 font-bold">Laporan Kinerja Operasional Perkebunan s.d {{ $namaBulanIni }} {{ $tahun }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="widget-item bg-white border-l-4 border-indigo-500 shadow-sm p-4 rounded-xl flex items-center gap-4 transition-all duration-300">
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Pencapaian Produksi Terbaik</p>
                    <p class="text-sm text-slate-700 mt-1">Divisi <strong class="text-lg text-indigo-700">{{ $bestProdPT }}</strong> memimpin dengan <strong class="text-lg text-indigo-700">{{ number_format($bestProdPct, 1) }}%</strong> dari Target Tahunan (Terkumpul {{ number_format($bestProdKg / 1000, 0) }} Ton).</p>
                </div>
            </div>
            
            <div class="widget-item bg-white border-l-4 {{ $gPctCostOil > 100 ? 'border-rose-500' : 'border-emerald-500' }} shadow-sm p-4 rounded-xl flex items-center gap-4 transition-all duration-300">
                <div class="{{ $gPctCostOil > 100 ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600' }} p-3 rounded-full hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Efisiensi Cost/Kg Palm Oil</p>
                    <p class="text-sm text-slate-700 mt-1">Realisasi <strong>BP-2</strong> mencapai <strong class="text-lg {{ $gPctCostOil > 100 ? 'text-rose-600' : 'text-emerald-700' }}">{{ number_format($gPctCostOil, 1) }}%</strong> thd Bgt (Angka Rp {{ number_format($gCostPalmOilReal, 0) }}/Kg Palm Oil).</p>
                </div>
            </div>
        </div>

        <div id="dynamic-dashboard-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div id="w-summary-prod" data-wname="Summary Produksi (Tabel Interaktif)" class="widget-item col-span-1 md:col-span-2 lg:col-span-4 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300">
                <div class="p-4 border-b border-slate-100 bg-slate-50/80 flex justify-between items-center hide-on-fullscreen">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <span class="bg-indigo-500 w-2 h-4 rounded-sm inline-block"></span> 
                        Data Pencapaian Produksi - {{ $labelBulan }}
                    </h3>
                </div>
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-right border-collapse min-w-[1000px]">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-2 px-3 text-slate-400 font-bold bg-white sticky left-0 z-10 w-24">Bulan</th>
                                <th class="text-left py-2 px-3 text-slate-400 font-bold bg-white sticky left-[96px] z-10 w-24">Jenis</th>
                                <th class="text-left py-2 px-3 text-slate-400 font-bold bg-white sticky left-[192px] z-10 border-r border-slate-200 w-40">Indikator</th>
                                @foreach($estates as $estate)
                                    <th class="py-2 px-4 font-bold text-slate-700 bg-slate-50">{{ $estate->kode }}</th>
                                @endforeach
                                <th class="py-2 px-4 font-bold text-indigo-800 bg-indigo-50">BP-2 (TOTAL)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td rowspan="4" class="text-left py-2 px-3 font-bold text-slate-700 bg-white sticky left-0 z-10">{{ $labelBulan }}</td>
                                <td rowspan="4" class="text-left py-2 px-3 font-bold text-indigo-600 bg-white sticky left-[96px] z-10">RKB</td>
                                <td class="text-left py-2 px-3 text-slate-600 border-r border-slate-200 bg-white sticky left-[192px] z-10">Produksi (Ton)</td>
                                @foreach($estates as $estate) <td class="py-2 px-4">{{ number_format(($dataMatrix[$estate->kode]['produksi']['current']['rkb']->tonase ?? 0) / 1000, 0) }}</td> @endforeach
                                <td class="py-2 px-4 font-bold text-indigo-900 bg-indigo-50/50">{{ number_format(($dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0) / 1000, 0) }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="text-left py-2 px-3 text-slate-600 border-r border-slate-200 bg-white sticky left-[192px] z-10">Janjang</td>
                                @foreach($estates as $estate) <td class="py-2 px-4">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['rkb']->janjang ?? 0, 0) }}</td> @endforeach
                                <td class="py-2 px-4 font-bold text-indigo-900 bg-indigo-50/50">{{ number_format($dataMatrix['BP-2']['produksi']['current']['rkb']->janjang ?? 0, 0) }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="text-left py-2 px-3 text-slate-600 border-r border-slate-200 bg-white sticky left-[192px] z-10">Bjr</td>
                                @foreach($estates as $estate) <td class="py-2 px-4 text-slate-500">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['bjr_rkb'] ?? 0, 2) }}</td> @endforeach
                                <td class="py-2 px-4 font-bold text-indigo-900 bg-indigo-50/50">{{ number_format($dataMatrix['BP-2']['produksi']['current']['bjr_rkb'] ?? 0, 2) }}</td>
                            </tr>
                            <tr class="border-b-2 border-slate-200 hover:bg-slate-50 transition-colors">
                                <td class="text-left py-2 px-3 text-slate-600 border-r border-slate-200 bg-white sticky left-[192px] z-10">Jjg/Pkk</td>
                                @foreach($estates as $estate)
                                    @php $rkbJjgPkk = ($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0) > 0 ? ($dataMatrix[$estate->kode]['produksi']['current']['rkb']->janjang ?? 0) / ($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0) : 0; @endphp
                                    <td class="py-2 px-4 text-slate-500">{{ number_format($rkbJjgPkk, 2) }}</td>
                                @endforeach
                                @php $grkbJjgPkk = ($dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0) > 0 ? ($dataMatrix['BP-2']['produksi']['current']['rkb']->janjang ?? 0) / ($dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0) : 0; @endphp
                                <td class="py-2 px-4 font-bold text-indigo-500 bg-indigo-50/50">{{ number_format($grkbJjgPkk, 2) }}</td>
                            </tr>

                            <tr class="bg-emerald-50/30 hover:bg-emerald-50/50 transition-colors">
                                <td rowspan="4" class="text-left py-2 px-3 bg-white sticky left-0 z-10"></td>
                                <td rowspan="4" class="text-left py-2 px-3 font-bold text-emerald-600 bg-white sticky left-[96px] z-10 border-l-4 border-emerald-500">Real</td>
                                <td class="text-left py-2 px-3 font-bold text-slate-800 border-r border-slate-200 bg-white sticky left-[192px] z-10">Produksi (Ton)</td>
                                @foreach($estates as $estate) <td class="py-2 px-4 font-bold text-slate-900">{{ number_format(($dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0) / 1000, 0) }}</td> @endforeach
                                <td class="py-2 px-4 font-bold text-indigo-900 bg-indigo-50/50">{{ number_format(($dataMatrix['BP-2']['produksi']['current']['real']->tonase ?? 0) / 1000, 0) }}</td>
                            </tr>
                            <tr class="bg-emerald-50/30 hover:bg-emerald-50/50 transition-colors">
                                <td class="text-left py-2 px-3 font-bold text-slate-800 border-r border-slate-200 bg-white sticky left-[192px] z-10">Janjang</td>
                                @foreach($estates as $estate) <td class="py-2 px-4 font-bold text-slate-900">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->janjang ?? 0, 0) }}</td> @endforeach
                                <td class="py-2 px-4 font-bold text-indigo-900 bg-indigo-50/50">{{ number_format($dataMatrix['BP-2']['produksi']['current']['real']->janjang ?? 0, 0) }}</td>
                            </tr>
                            <tr class="bg-emerald-50/30 hover:bg-emerald-50/50 transition-colors">
                                <td class="text-left py-2 px-3 text-slate-700 border-r border-slate-200 bg-white sticky left-[192px] z-10">Bjr</td>
                                @foreach($estates as $estate) <td class="py-2 px-4 font-medium text-slate-700">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['bjr_real'] ?? 0, 2) }}</td> @endforeach
                                <td class="py-2 px-4 font-bold text-indigo-900 bg-indigo-50/50">{{ number_format($dataMatrix['BP-2']['produksi']['current']['bjr_real'] ?? 0, 2) }}</td>
                            </tr>
                            <tr class="bg-emerald-50/30 hover:bg-emerald-50/50 transition-colors border-b-2 border-slate-200">
                                <td class="text-left py-2 px-3 text-slate-700 border-r border-slate-200 bg-white sticky left-[192px] z-10">Jjg/Pkk</td>
                                @foreach($estates as $estate)
                                    @php $realJjgPkk = ($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0) > 0 ? ($dataMatrix[$estate->kode]['produksi']['current']['real']->janjang ?? 0) / ($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0) : 0; @endphp
                                    <td class="py-2 px-4 font-medium text-slate-700">{{ number_format($realJjgPkk, 2) }}</td>
                                @endforeach
                                @php $grealJjgPkk = ($dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0) > 0 ? ($dataMatrix['BP-2']['produksi']['current']['real']->janjang ?? 0) / ($dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0) : 0; @endphp
                                <td class="py-2 px-4 font-bold text-indigo-900 bg-indigo-50/50">{{ number_format($grealJjgPkk, 2) }}</td>
                            </tr>

                            <tr class="bg-rose-50/20 hover:bg-rose-50/50 transition-colors">
                                <td rowspan="3" class="text-left py-2 px-3 bg-white sticky left-0 z-10"></td>
                                <td rowspan="3" class="text-left py-2 px-3 font-bold text-rose-600 bg-white sticky left-[96px] z-10 border-l-4 border-rose-500">Dev</td>
                                <td class="text-left py-2 px-3 text-slate-700 border-r border-slate-200 bg-white sticky left-[192px] z-10">Produksi (Ton)</td>
                                @foreach($estates as $estate)
                                    @php
                                        $dev = (($dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0) - ($dataMatrix[$estate->kode]['produksi']['current']['rkb']->tonase ?? 0)) / 1000;
                                    @endphp
                                    <td class="py-2 px-4 font-bold {{ $dev < 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $dev < 0 ? '('.number_format(abs($dev), 0).')' : number_format($dev, 0) }}</td>
                                @endforeach
                                @php $gdev = (($dataMatrix['BP-2']['produksi']['current']['real']->tonase ?? 0) - ($dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0)) / 1000; @endphp
                                <td class="py-2 px-4 font-bold {{ $gdev < 0 ? 'text-rose-600' : 'text-emerald-600' }} bg-indigo-50/30">{{ $gdev < 0 ? '('.number_format(abs($gdev), 0).')' : number_format($gdev, 0) }}</td>
                            </tr>
                            <tr class="bg-amber-50/30 hover:bg-amber-50/60 transition-colors">
                                <td class="text-left py-2 px-3 font-bold text-amber-800 border-r border-slate-200 bg-white sticky left-[192px] z-10">% Pencapaian</td>
                                @foreach($estates as $estate)
                                    @php
                                        $r = $dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0;
                                        $b = $dataMatrix[$estate->kode]['produksi']['current']['rkb']->tonase ?? 0;
                                        $pct = $b > 0 ? ($r / $b) * 100 : 0; 
                                    @endphp
                                    <td class="py-2 px-4 font-bold text-amber-700">{{ number_format($pct, 2) }}</td>
                                @endforeach
                                @php $gpct = ($dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0) > 0 ? ($dataMatrix['BP-2']['produksi']['current']['real']->tonase ?? 0) / ($dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0) * 100 : 0; @endphp
                                <td class="py-2 px-4 font-bold text-amber-800 bg-amber-100/50">{{ number_format($gpct, 2) }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors border-b border-slate-200">
                                <td class="text-left py-2 px-3 text-slate-600 border-r border-slate-200 bg-white sticky left-[192px] z-10">Jjg/Pkk</td>
                                @foreach($estates as $estate)
                                    @php
                                        $hsPkk = $dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0;
                                        $rkbJjgPkk = $hsPkk > 0 ? ($dataMatrix[$estate->kode]['produksi']['current']['rkb']->janjang ?? 0) / $hsPkk : 0;
                                        $realJjgPkk = $hsPkk > 0 ? ($dataMatrix[$estate->kode]['produksi']['current']['real']->janjang ?? 0) / $hsPkk : 0;
                                        $devJjgPkk = $realJjgPkk - $rkbJjgPkk;
                                    @endphp
                                    <td class="py-2 px-4 font-bold {{ $devJjgPkk < 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $devJjgPkk < 0 ? '('.number_format(abs($devJjgPkk), 2).')' : number_format($devJjgPkk, 2) }}</td>
                                @endforeach
                                @php
                                    $gHsPkk = $dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0;
                                    $grkbJjgPkk = $gHsPkk > 0 ? ($dataMatrix['BP-2']['produksi']['current']['rkb']->janjang ?? 0) / $gHsPkk : 0;
                                    $grealJjgPkk = $gHsPkk > 0 ? ($dataMatrix['BP-2']['produksi']['current']['real']->janjang ?? 0) / $gHsPkk : 0;
                                    $gdevJjgPkk = $grealJjgPkk - $grkbJjgPkk;
                                @endphp
                                <td class="py-2 px-4 font-bold {{ $gdevJjgPkk < 0 ? 'text-rose-600' : 'text-emerald-600' }} bg-indigo-50/30">{{ $gdevJjgPkk < 0 ? '('.number_format(abs($gdevJjgPkk), 2).')' : number_format($gdevJjgPkk, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ================= WIDGET DATA BARU DITAMBAHKAN DI SINI ================= -->
            
            <!-- 1. WIDGET KINERJA MUTU ANCAK (RATA-RATA RIPE) -->
            <div id="w-mutu-ancak" data-wname="Mutu Ancak" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-purple-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Rata-rata Mutu Ripe</p>
                    @php
                        $tMutuReal = 0; $cMutuReal = 0;
                        foreach($estates as $estate) {
                            $vReal = $dataMatrix[$estate->kode]['kualitas']['real']['Ripe']->persentase ?? 0;
                            if($vReal > 0) { $tMutuReal += $vReal; $cMutuReal++; }
                        }
                        $gMutuRipe = $cMutuReal > 0 ? $tMutuReal / $cMutuReal : 0;
                    @endphp
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gMutuRipe, 2) }}%</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Buah Masak (Ripe) Realisasi</p>
                </div>
                <div class="p-3 bg-purple-50 text-purple-600 rounded-lg group-hover:bg-purple-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-purple-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail Mutu Ancak per PT (% Real)</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600">
                                <th class="text-left pb-1 pr-3">PT</th>
                                @foreach($kriteriaMutu as $mutu) <th class="pb-1 px-2">{{ $mutu }}</th> @endforeach
                            </tr>
                            @foreach($estates as $estate)
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium pr-3">{{ $estate->kode }}</td>
                                    @foreach($kriteriaMutu as $mutu) 
                                        <td class="px-2">{{ number_format($dataMatrix[$estate->kode]['kualitas']['real'][$mutu]->persentase ?? 0, 2) }}%</td> 
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <!-- 2. WIDGET ROTASI PRUNING (> 9 BULAN KRITIS) -->
            <div id="w-pruning-kritis" data-wname="Pruning Kritis" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-red-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Pruning > 9 Bulan</p>
                    @php
                        $gt9BlnLuas = ($dataMatrix['BP-2']['rotasi_pruning']['Pruning 9.01-12 Bln']->luas_ha ?? 0) + ($dataMatrix['BP-2']['rotasi_pruning']['Pruning > 12 Bln']->luas_ha ?? 0);
                    @endphp
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gt9BlnLuas, 2) }} <span class="text-sm font-bold text-slate-500">Ha</span></h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Luas Pruning Kritis (BP-2)</p>
                </div>
                <div class="p-3 bg-red-50 text-red-600 rounded-lg group-hover:bg-red-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div class="absolute left-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-red-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail Pruning > 9 Bln per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600">
                                <th class="text-left pb-1">PT</th>
                                <th class="pb-1 pl-4">9.01 - 12 Bln (Ha)</th>
                                <th class="pb-1 pl-4">> 12 Bln (Ha)</th>
                                <th class="pb-1 pl-4">Total Kritis</th>
                            </tr>
                            @foreach($estates as $estate)
                                @php 
                                    $l9_12 = $dataMatrix[$estate->kode]['rotasi_pruning']['Pruning 9.01-12 Bln']->luas_ha ?? 0;
                                    $l12_up = $dataMatrix[$estate->kode]['rotasi_pruning']['Pruning > 12 Bln']->luas_ha ?? 0;
                                    $totKritis = $l9_12 + $l12_up;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4">{{ number_format($l9_12, 2) }}</td>
                                    <td class="pl-4 text-red-400">{{ number_format($l12_up, 2) }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($totKritis, 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <!-- 3. WIDGET TINGKAT KEHADIRAN (HKNE KARYAWAN) -->
            <div id="w-kehadiran" data-wname="Tingkat Kehadiran" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-cyan-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Tingkat Kehadiran</p>
                    @php
                        $gHkKerja = 0; $gHkAbsen = 0;
                        foreach($estates as $estate){ 
                            if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { 
                                $gHkKerja += $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Kerja')->jumlah_tk ?? 0;
                                foreach(['Sakit', 'Cuti', 'Mangkir', 'Ijin'] as $sub) {
                                    $gHkAbsen += $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', $sub)->jumlah_tk ?? 0;
                                }
                            } 
                        }
                        $gTotHkne = $gHkKerja + $gHkAbsen;
                        $gPctHadir = $gTotHkne > 0 ? ($gHkKerja / $gTotHkne) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gPctHadir, 2) }}%</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Kehadiran Kary. Panen (BP-2)</p>
                </div>
                <div class="p-3 bg-cyan-50 text-cyan-600 rounded-lg group-hover:bg-cyan-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-cyan-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail HKNE Kary. Panen per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600">
                                <th class="text-left pb-1">PT</th>
                                <th class="pb-1 pl-4 text-emerald-400">Kerja</th>
                                <th class="pb-1 pl-4 text-rose-400">Absen (M/S/I/C)</th>
                                <th class="pb-1 pl-4">% Hadir</th>
                            </tr>
                            @foreach($estates as $estate)
                                @php 
                                    $hkKerja = 0; $hkAbsen = 0;
                                    if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { 
                                        $hkKerja = $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Kerja')->jumlah_tk ?? 0;
                                        foreach(['Sakit', 'Cuti', 'Mangkir', 'Ijin'] as $sub) {
                                            $hkAbsen += $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', $sub)->jumlah_tk ?? 0;
                                        }
                                    }
                                    $tot = $hkKerja + $hkAbsen;
                                    $pct = $tot > 0 ? ($hkKerja / $tot) * 100 : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($hkKerja, 0) }}</td>
                                    <td class="pl-4">{{ number_format($hkAbsen, 0) }}</td>
                                    <td class="pl-4 font-bold text-cyan-400">{{ number_format($pct, 2) }}%</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <!-- BATAS WIDGET TAMBAHAN -->


            <div id="w-biaya" data-wname="Total Biaya (M)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-amber-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total Biaya (M)</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gBiayaRealSd / 1000000, 2) }} M</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Biaya Operasional s.d Bulan Ini</p>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-lg group-hover:bg-amber-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="absolute left-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-amber-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail Biaya per PT (M)</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600">
                                <th class="text-left pb-1">PT</th>
                                <th class="pb-1 pl-4">Bgt (1 Thn)</th>
                                <th class="pb-1 pl-4">Real (Sbi)</th>
                                <th class="pb-1 pl-4">%</th>
                            </tr>
                            @foreach($estates as $estate)
                                @php 
                                    $bgt1ThnCost = \App\Models\OperationalCost::where('estate_id', $estate->id)
                                        ->whereYear('periode', $tahun)
                                        ->where('tipe', 'BUDGET')
                                        ->get()
                                        ->sum(function($c) { return $c->cost_panen + $c->cost_rawat + $c->cost_kantor + $c->cost_teknik + $c->cost_pks; });
                                        
                                    $ptBiaya = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + 
                                               ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + 
                                               ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + 
                                               ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + 
                                               ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0); 
                                               
                                    $bgtM = $bgt1ThnCost / 1000000;
                                    $realM = $ptBiaya / 1000000;
                                    $pct = $bgtM > 0 ? ($realM / $bgtM) * 100 : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4">{{ number_format($bgtM, 2) }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($realM, 2) }}</td>
                                    <td class="pl-4 {{ $pct <= 100 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($pct, 1) }}%</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div id="w-cost" data-wname="Cost / Kg TBS (Rp)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-emerald-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Cost/Kg TBS</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gCostPerKgSd, 2) }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Rp S.D Bln / Kg TBS S.D Bln</p>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-emerald-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail Cost/Kg (S.D Bln) per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-4">Bgt Rp/Kg</th><th class="pb-1 pl-4">Real Rp/Kg</th><th class="pb-1 pl-4">% Bgt</th></tr>
                            @foreach($estates as $estate)
                                @php 
                                    $tSd = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                    $bSd = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0);
                                    $ptCostKgSd = $tSd > 0 ? ($bSd / $tSd) : 0;
                                    
                                    $tBgt1Thn = $dataMatrix[$estate->kode]['histori']['bgt_1_thn']->tonase ?? 0;
                                    $bBgt1Thn = \App\Models\OperationalCost::where('estate_id', $estate->id)
                                        ->whereYear('periode', $tahun)
                                        ->where('tipe', 'BUDGET')
                                        ->get()
                                        ->sum(function($c) { return $c->cost_panen + $c->cost_rawat + $c->cost_kantor + $c->cost_teknik + $c->cost_pks; });
                                    
                                    $ptBgtCostKg = $tBgt1Thn > 0 ? ($bBgt1Thn / $tBgt1Thn) : 0;
                                    $pC = $ptBgtCostKg > 0 ? ($ptCostKgSd / $ptBgtCostKg) * 100 : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4">{{ number_format($ptBgtCostKg, 2) }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($ptCostKgSd, 2) }}</td>
                                    <td class="pl-4 {{ $pC <= 100 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($pC, 1) }}%</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div id="w-cost-produk" data-wname="Cost Palm Produk (Rp/Kg)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-slate-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Cost Palm Produk</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gCostPalmProdukReal, 0) }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Rp S.D Bln / Kg Produk S.D Bln</p>
                </div>
                <div class="p-3 bg-slate-100 text-slate-600 rounded-lg group-hover:bg-slate-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-slate-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail Cost Palm Produk per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-4">Bgt Rp/Kg</th><th class="pb-1 pl-4">Real Rp/Kg</th><th class="pb-1 pl-4">% Bgt</th></tr>
                            @foreach($estates as $estate)
                                @php
                                    $bgt = $biayaStats[$estate->kode]['costPalmProdukBgt'];
                                    $real = $biayaStats[$estate->kode]['costPalmProdukReal'];
                                    $pct = $bgt > 0 ? ($real / $bgt) * 100 : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4">{{ number_format($bgt, 0) }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($real, 0) }}</td>
                                    <td class="pl-4 {{ $pct <= 100 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($pct, 1) }}%</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div id="w-cost-oil" data-wname="Cost Palm Oil (Rp/Kg)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-green-600 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Cost Palm Oil</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gCostPalmOilReal, 0) }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Rp S.D Bln / Kg Oil S.D Bln</p>
                </div>
                <div class="p-3 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-green-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail Cost Palm Oil per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-4">Bgt Rp/Kg</th><th class="pb-1 pl-4">Real Rp/Kg</th><th class="pb-1 pl-4">% Bgt</th></tr>
                            @foreach($estates as $estate)
                                @php
                                    $bgt = $biayaStats[$estate->kode]['costPalmOilBgt'];
                                    $real = $biayaStats[$estate->kode]['costPalmOilReal'];
                                    $pct = $bgt > 0 ? ($real / $bgt) * 100 : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4">{{ number_format($bgt, 0) }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($real, 0) }}</td>
                                    <td class="pl-4 {{ $pct <= 100 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($pct, 1) }}%</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div id="w-bjr" data-wname="Rata-rata BJR" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-sky-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Rata-rata BJR</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gBjr, 2) }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Berat Janjang Rata-rata</p>
                </div>
                <div class="p-3 bg-sky-50 text-sky-600 rounded-lg group-hover:bg-sky-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-sky-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail BJR per PT (Bln Ini vs Bln Lalu)</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-4">Bln Ini</th><th class="pb-1 pl-4">Bln Lalu</th><th class="pb-1 pl-4">Trend</th></tr>
                            @foreach($estates as $estate)
                                @php 
                                    $bIni = $dataMatrix[$estate->kode]['produksi']['current']['bjr_real'] ?? 0;
                                    $bLalu = $dataMatrix[$estate->kode]['produksi']['current']['bjr_last_month'] ?? 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($bIni, 2) }}</td>
                                    <td class="pl-4">{{ number_format($bLalu, 2) }}</td>
                                    <td class="pl-4 text-center text-lg">
                                        @if($bIni > $bLalu) <span class="text-emerald-400">📈</span>
                                        @elseif($bIni < $bLalu) <span class="text-rose-400">📉</span>
                                        @else <span class="text-slate-400">-</span> @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <!-- ========================= WIDGET TOTAL RAWAT (HA) ========================= -->
            <div id="w-rawat" data-wname="Total Rawat (Ha)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-teal-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total Rawat (Ha)</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gTotalRawat, 2) }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Realisasi Perawatan</p>
                </div>
                <div class="p-3 bg-teal-50 text-teal-600 rounded-lg group-hover:bg-teal-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                
                <div class="absolute left-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl border border-slate-700 overflow-hidden whitespace-nowrap" style="min-width: 480px;">
                        <div class="bg-slate-800/90 px-4 pt-4 pb-2 border-b border-slate-600 sticky top-0 z-10 flex justify-between">
                            <span class="font-bold text-teal-300 text-sm tracking-wide">Detail Rawat & Cost per Pekerjaan</span>
                        </div>
                        <div class="max-h-[300px] overflow-y-auto px-4 pb-4 mt-2">
                            <table class="w-full text-right">
                                <thead>
                                    <tr class="text-slate-400 bg-slate-800/95 backdrop-blur sticky top-0 z-10 border-b border-slate-600">
                                        <th class="text-left py-2 font-semibold">PT</th>
                                        <th class="text-left py-2 pl-4 font-semibold">Jenis Pekerjaan</th>
                                        <th class="py-2 pl-4 text-center font-semibold">Blok</th>
                                        <th class="py-2 pl-4 font-semibold">Luas (Ha)</th>
                                        <th class="py-2 pl-4 font-semibold">Cost/Ha (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($estates as $estate)
                                        @php $isFirst = true; @endphp
                                        @foreach($jenisPerawatan as $job)
                                            @php
                                                $l = $dataMatrix[$estate->kode]['upkeep']['real'][$job]->luas_ha ?? 0; 
                                                $b = $dataMatrix[$estate->kode]['upkeep']['real'][$job]->jml_blok ?? 0; 
                                                $c = $dataMatrix[$estate->kode]['upkeep']['real'][$job]->cost_ha ?? 0; 
                                            @endphp
                                            
                                            @if($l > 0 || $b > 0 || $c > 0)
                                            <tr class="border-b border-slate-700/50 last:border-0 hover:bg-slate-700/50 transition-colors">
                                                <td class="py-2 text-left font-bold text-slate-300 align-top">{{ $isFirst ? $estate->kode : '' }}</td>
                                                <td class="py-2 text-left pl-4 text-slate-400" title="{{ $job }}">{{ $job }}</td>
                                                <td class="py-2 pl-4 text-center">{{ number_format($b, 0) }}</td>
                                                <td class="py-2 pl-4 font-bold text-white">{{ number_format($l, 2) }}</td>
                                                <td class="py-2 pl-4 text-amber-400">{{ number_format($c, 0) }}</td>
                                            </tr>
                                            @php $isFirst = false; @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================= WIDGET TOTAL PUPUK ========================= -->
            <div id="w-pupuk" data-wname="Total Pupuk (Ton)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-yellow-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total Pupuk (Ton)</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gTotalPupuk / 1000, 2) }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Aplikasi Bulan Ini</p>
                </div>
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                
                <div class="absolute left-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl border border-slate-700 overflow-hidden whitespace-nowrap" style="min-width: 480px;">
                        <div class="bg-slate-800/90 px-4 pt-4 pb-2 border-b border-slate-600 sticky top-0 z-10">
                            <div class="font-bold text-yellow-300 text-sm tracking-wide">Detail Aplikasi Pupuk Sbi (Ton) per Pekerjaan</div>
                        </div>
                        
                        <div class="max-h-[300px] overflow-y-auto px-4 pb-4 mt-2">
                            <table class="w-full text-right">
                                <thead>
                                    <tr class="text-slate-400 bg-slate-800/95 backdrop-blur sticky top-0 z-10 border-b border-slate-600">
                                        <th class="text-left py-2 font-semibold">PT</th>
                                        <th class="text-left py-2 pl-4 font-semibold">Jenis Pupuk</th>
                                        <th class="py-2 pl-4 font-semibold text-center">Bgt (1 Thn)</th>
                                        <th class="py-2 pl-4 font-semibold text-center">Real (Sbi)</th>
                                        <th class="py-2 pl-4 font-semibold">% Pencapaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($estates as $estate)
                                        @php $isFirst = true; @endphp
                                        @foreach($jenisPupuk as $ppk)
                                            @php
                                                $bgt1ThnKg = \App\Models\Fertilizer::where('estate_id', $estate->id)
                                                    ->whereYear('periode', $tahun)
                                                    ->where('tipe', 'BUDGET')->where('jenis_pupuk', $ppk)->sum('jumlah_kg');
                                                    
                                                $realSbiKg = \App\Models\Fertilizer::where('estate_id', $estate->id)
                                                    ->whereYear('periode', $tahun)->whereMonth('periode', '<=', $bulan)
                                                    ->where('tipe', 'REAL')->where('jenis_pupuk', $ppk)->sum('jumlah_kg');
                                                
                                                $bgt1ThnTon = $bgt1ThnKg / 1000;
                                                $realSbiTon = $realSbiKg / 1000;
                                                $pctSbi = $bgt1ThnTon > 0 ? ($realSbiTon / $bgt1ThnTon) * 100 : 0;
                                            @endphp
                                            
                                            @if($bgt1ThnTon > 0 || $realSbiTon > 0)
                                            <tr class="border-b border-slate-700/50 last:border-0 hover:bg-slate-700/50 transition-colors">
                                                <td class="py-2 text-left font-bold text-slate-300 align-top">{{ $isFirst ? $estate->kode : '' }}</td>
                                                <td class="py-2 text-left pl-4 text-slate-400 truncate" title="{{ $ppk }}">{{ $ppk }}</td>
                                                <td class="py-2 pl-4 text-center">{{ number_format($bgt1ThnTon, 2) }}</td>
                                                <td class="py-2 pl-4 text-center font-bold text-white">{{ number_format($realSbiTon, 2) }}</td>
                                                <td class="py-2 pl-4 {{ $pctSbi >= 100 ? 'text-emerald-400' : 'text-amber-400' }}">{{ number_format($pctSbi, 1) }}%</td>
                                            </tr>
                                            @php $isFirst = false; @endphp
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="w-jamkerja" data-wname="Data Jam Kerja" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-blue-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Data Jam Kerja</p>
                    @php
                        $gTsd = 0; $gPgi = 0;
                        foreach($estates as $estate){
                            $gTsd += isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Tersedia')->jumlah_tk ?? 0) : 0;
                            $gPgi += isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Pagi')->jumlah_tk ?? 0) : 0;
                        }
                        $pctPgi = $gTsd > 0 ? ($gPgi / $gTsd) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gTsd, 0) }} <span class="text-sm font-bold text-slate-500">TK Tersedia</span></h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Kehadiran Pagi: {{ number_format($pctPgi, 2) }}%</p>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-blue-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail Jam Kerja per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600">
                                <th class="text-left pb-1">PT</th>
                                <th class="pb-1 pl-4">Tersedia</th>
                                <th class="pb-1 pl-4 text-emerald-400">% Pagi</th>
                                <th class="pb-1 pl-4 text-yellow-400">% Siang</th>
                                <th class="pb-1 pl-4 text-orange-400">% Sore</th>
                            </tr>
                            @foreach($estates as $estate)
                                @php 
                                    $tsd = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Tersedia')->jumlah_tk ?? 0) : 0;
                                    $pgi = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Pagi')->jumlah_tk ?? 0) : 0;
                                    $sng = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Siang')->jumlah_tk ?? 0) : 0;
                                    $sor = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Sore')->jumlah_tk ?? 0) : 0;
                                    
                                    $pPagi = $tsd > 0 ? ($pgi / $tsd) * 100 : 0;
                                    $pSiang = $pgi > 0 ? ($sng / $pgi) * 100 : 0;
                                    $pSore = $pgi > 0 ? ($sor / $pgi) * 100 : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($tsd, 0) }}</td>
                                    <td class="pl-4 font-medium text-emerald-400">{{ number_format($pPagi, 1) }}%</td>
                                    <td class="pl-4 font-medium text-yellow-400">{{ number_format($pSiang, 1) }}%</td>
                                    <td class="pl-4 font-medium text-orange-400">{{ number_format($pSore, 1) }}%</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div id="w-kunjungan" data-wname="HK Panen" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-rose-500 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total HK Panen</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gTotalHkPanen ?? 0, 0) }}</h3>
                    <p class="text-xs font-medium text-slate-400 mt-1">Hari Kerja Panen Realisasi</p>
                </div>
                <div class="p-3 bg-rose-50 text-rose-600 rounded-lg group-hover:bg-rose-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-rose-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail HK Panen per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-4">Total HK</th></tr>
                            @foreach($estates as $estate)
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->hk_panen ?? 0, 0) }} HK</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div id="w-cpo" data-wname="Total CPO & OER" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-orange-500 hover:shadow-md transition-all duration-300 cursor-help">
                @php
                    $gCpoBi = 0; $gTbsBi = 0;
                    foreach($estates as $estate) {
                        $gCpoBi += $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_cpo ?? 0;
                        $gTbsBi += ($dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0) / 1000;
                    }
                    $gOerBi = $gTbsBi > 0 ? ($gCpoBi / $gTbsBi) * 100 : 0;
                @endphp
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total CPO & OER</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gCpoBi, 0) }} <span class="text-sm font-bold text-slate-500">Ton</span></h3>
                    <p class="text-xs font-bold text-orange-600 mt-1">OER: {{ number_format($gOerBi, 2) }}% (Bln Ini)</p>
                </div>
                <div class="p-3 bg-orange-50 text-orange-600 rounded-lg group-hover:bg-orange-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-orange-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail CPO & OER per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-4">Ton</th><th class="pb-1 pl-4">OER %</th></tr>
                            @foreach($estates as $estate)
                                @php
                                    $cpo = $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_cpo ?? 0;
                                    $tbs = ($dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0) / 1000;
                                    $oer = $tbs > 0 ? ($cpo / $tbs) * 100 : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($cpo, 0) }}</td>
                                    <td class="pl-4 text-orange-400">{{ number_format($oer, 2) }}%</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div id="w-pko" data-wname="Total PKO & KER" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-yellow-600 hover:shadow-md transition-all duration-300 cursor-help">
                @php
                    $gPkoBi = 0; $gKerBi = 0;
                    foreach($estates as $estate) {
                        $gPkoBi += $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_pko ?? 0;
                        $gKerBi += $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_ker ?? 0;
                    }
                    $gPctKerBi = $gTbsBi > 0 ? ($gKerBi / $gTbsBi) * 100 : 0;
                @endphp
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total PKO & KER</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gPkoBi, 0) }} <span class="text-sm font-bold text-slate-500">Ton</span></h3>
                    <p class="text-xs font-bold text-yellow-600 mt-1">KER: {{ number_format($gPctKerBi, 2) }}% (Bln Ini)</p>
                </div>
                <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-yellow-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail PKO & KER per PT</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-4">Ton</th><th class="pb-1 pl-4">KER %</th></tr>
                            @foreach($estates as $estate)
                                @php
                                    $pko = $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_pko ?? 0;
                                    $ker = $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_ker ?? 0;
                                    $tbs = ($dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0) / 1000;
                                    $pctKer = $tbs > 0 ? ($ker / $tbs) * 100 : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($pko, 0) }}</td>
                                    <td class="pl-4 text-yellow-400">{{ number_format($pctKer, 2) }}%</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div id="w-pemanen" data-wname="Kinerja Pemanen (Avr)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-indigo-600 hover:shadow-md transition-all duration-300 cursor-help">
                <div>
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Kinerja Pemanen</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 flex items-baseline gap-1">
                        @php
                            $gTkls = 0; $gAvr = 0;
                            foreach($estates as $estate){ 
                                if(isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'])){ 
                                    foreach(['A','B','C','D'] as $kls) {
                                        $tk = $dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->jumlah_tk ?? 0;
                                        $avr = $dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->avr_bln ?? 0;
                                        $gTkls += $tk;
                                        $gAvr += ($avr * $tk);
                                    }
                                } 
                            }
                            $avgAll = $gTkls > 0 ? $gAvr / $gTkls : 0;
                        @endphp
                        {{ number_format($avgAll, 2) }} <span class="text-sm font-bold text-slate-500">Hk/Bln</span>
                    </h3>
                    <p class="text-xs font-medium text-indigo-600 mt-1">Rata-rata Kelas A-D Seluruh PT</p>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-500 group-hover:text-white transition-colors hide-on-fullscreen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto">
                    <div class="tooltip-box bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-4 border border-slate-700 whitespace-nowrap min-w-max">
                        <div class="font-bold text-indigo-300 mb-2 border-b border-slate-600 pb-1 text-sm tracking-wide">Detail Rata-rata Avr per Kelas</div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">Kelas</th><th class="pb-1 pl-4">Total TK</th><th class="pb-1 pl-4">Avr/Bln</th></tr>
                            @foreach(['A','B','C','D'] as $kls)
                                @php
                                    $tkKls = 0; $avrKlsTotal = 0;
                                    foreach($estates as $estate){
                                        $tk = isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->jumlah_tk ?? 0) : 0;
                                        $avr = isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->avr_bln ?? 0) : 0;
                                        $tkKls += $tk;
                                        $avrKlsTotal += ($avr * $tk);
                                    }
                                    $avgKls = $tkKls > 0 ? $avrKlsTotal / $tkKls : 0;
                                @endphp
                                <tr class="border-b border-slate-700 last:border-0">
                                    <td class="py-1.5 text-left font-bold text-indigo-400">Kelas {{ $kls }}</td>
                                    <td class="pl-4 text-slate-300">{{ number_format($tkKls, 0) }} Org</td>
                                    <td class="pl-4 font-bold text-white">{{ number_format($avgKls, 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            
            <div id="w-tk" data-wname="Performance TK" class="widget-item col-span-1 md:col-span-2 lg:col-span-4 bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6 transition-all duration-300">
                <table class="modern-matrix text-sm w-full min-w-[900px]">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-left font-bold text-slate-800 bg-slate-50 border-r border-slate-200 uppercase">PERFORMANCE TENAGA KERJA</th>
                            @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase tracking-wider">{{ $estate->kode }}</th> @endforeach
                            <th class="text-center font-bold text-slate-800 bg-slate-200 uppercase shadow-sm">BP-2</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-800 font-bold">
                        <!-- RKK MASUK -->
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td rowspan="2" class="text-center align-middle border-r border-slate-200 w-32 bg-white">Masuk</td>
                            <td class="text-left border-r border-slate-200 w-24">Bi</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', 'Masuk (Bi)')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gMasukBi = 0; foreach($estates as $estate){ $gMasukBi += isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', 'Masuk (Bi)')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gMasukBi, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b-2 border-slate-300 row-border-strong">
                            <td class="text-left border-r border-slate-200 w-24">Sbi</td>
                            @foreach($estates as $estate)
                                @php
                                    $vSbi = isset($dataMatrix[$estate->kode]['pekerja_sbi']['Mutasi']) ? $dataMatrix[$estate->kode]['pekerja_sbi']['Mutasi']->where('sub_kategori', 'Masuk (Bi)')->sum('jumlah_tk') : 0;
                                @endphp
                                <td class="text-right">{{ number_format($vSbi, 0) }}</td>
                            @endforeach
                            @php
                                $gMasukSbi = 0;
                                foreach($estates as $estate) {
                                    $gMasukSbi += isset($dataMatrix[$estate->kode]['pekerja_sbi']['Mutasi']) ? $dataMatrix[$estate->kode]['pekerja_sbi']['Mutasi']->where('sub_kategori', 'Masuk (Bi)')->sum('jumlah_tk') : 0;
                                }
                            @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gMasukSbi, 0) }}</td>
                        </tr>

                        <!-- RKK KELUAR -->
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td rowspan="4" class="text-center align-top pt-4 border-r border-slate-200 w-32 bg-white">Keluar</td>
                            <td class="text-left border-r border-slate-200 w-24">Bi</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', 'Keluar (Bi)')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gKeluarBi = 0; foreach($estates as $estate){ $gKeluarBi += isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', 'Keluar (Bi)')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gKeluarBi, 0) }}</td>
                        </tr>
                        <tr class="bg-yellow-50/50 hover:bg-yellow-100/50 border-b border-slate-300 border-dashed">
                            <td class="text-left border-r border-slate-200 w-24">% Keluar Bi</td>
                            @foreach($estates as $estate)
                                @php
                                    $vPct = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', '% Keluar Bi')->persentase ?? 0) : 0;
                                @endphp
                                <td class="text-right text-yellow-800">{{ number_format($vPct, 2) }}%</td>
                            @endforeach
                            @php
                                $tPctKeluarBi = 0; $cPctKeluarBi = 0;
                                foreach($estates as $estate) {
                                    $v = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', '% Keluar Bi')->persentase ?? 0) : 0;
                                    if($v > 0) { $tPctKeluarBi += $v; $cPctKeluarBi++; }
                                }
                            @endphp
                            <td class="text-right bg-yellow-100 text-yellow-900">{{ number_format($cPctKeluarBi > 0 ? $tPctKeluarBi / $cPctKeluarBi : 0, 2) }}%</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td class="text-left border-r border-slate-200 w-24">Sbi</td>
                            @foreach($estates as $estate)
                                @php
                                    $vSbi = isset($dataMatrix[$estate->kode]['pekerja_sbi']['Mutasi']) ? $dataMatrix[$estate->kode]['pekerja_sbi']['Mutasi']->where('sub_kategori', 'Keluar (Bi)')->sum('jumlah_tk') : 0;
                                @endphp
                                <td class="text-right">{{ number_format($vSbi, 0) }}</td>
                            @endforeach
                            @php
                                $gKeluarSbi = 0;
                                foreach($estates as $estate) {
                                    $gKeluarSbi += isset($dataMatrix[$estate->kode]['pekerja_sbi']['Mutasi']) ? $dataMatrix[$estate->kode]['pekerja_sbi']['Mutasi']->where('sub_kategori', 'Keluar (Bi)')->sum('jumlah_tk') : 0;
                                }
                            @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gKeluarSbi, 0) }}</td>
                        </tr>
                        <tr class="bg-amber-300 text-amber-900 border-b border-amber-400">
                            <td class="text-left border-r border-amber-400 w-24">% Keluar Sbi</td>
                            @foreach($estates as $estate)
                                @php
                                    $vPct = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', '% Keluar Sbi')->persentase ?? 0) : 0;
                                @endphp
                                <td class="text-right">{{ number_format($vPct, 2) }}%</td>
                            @endforeach
                            @php
                                $tPctKeluarSbi = 0; $cPctKeluarSbi = 0;
                                foreach($estates as $estate) {
                                    $v = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', '% Keluar Sbi')->persentase ?? 0) : 0;
                                    if($v > 0) { $tPctKeluarSbi += $v; $cPctKeluarSbi++; }
                                }
                            @endphp
                            <td class="text-right bg-amber-400">{{ number_format($cPctKeluarSbi > 0 ? $tPctKeluarSbi / $cPctKeluarSbi : 0, 2) }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="w-chart-prod" data-wname="Chart: Produksi per PT" class="widget-item col-span-1 md:col-span-2 lg:col-span-4 bg-white rounded-xl shadow-sm border border-slate-200 p-5 transition-all duration-300">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Kinerja Produksi (Ton) per PT</h3>
                <div class="relative h-80 w-full"><canvas id="chartProduksi"></canvas></div>
            </div>

            <div id="w-chart-cost" data-wname="Chart: Cost/Kg per PT" class="widget-item col-span-1 md:col-span-2 lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-5 transition-all duration-300">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Grafik Cost / Kg TBS per PT (S.D Bln Ini)</h3>
                <div class="relative h-64 w-full"><canvas id="chartCostKg"></canvas></div>
            </div>

            <div id="w-chart-biaya" data-wname="Chart: Distribusi Biaya" class="widget-item col-span-1 lg:col-span-1 bg-white rounded-xl shadow-sm border border-slate-200 p-5 transition-all duration-300">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Distribusi Total Biaya</h3>
                <div class="relative h-64 w-full flex justify-center"><canvas id="chartBiayaPie"></canvas></div>
            </div>

            <div id="w-chart-mutu" data-wname="Chart: Mutu Ancak" class="widget-item col-span-1 lg:col-span-1 bg-white rounded-xl shadow-sm border border-slate-200 p-5 transition-all duration-300">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Tren Rata-rata Mutu (%)</h3>
                <div class="relative h-64 w-full"><canvas id="chartMutu"></canvas></div>
            </div>

        </div>
    </div>
</div>

<script>
    setInterval(() => {
        let clock = document.getElementById('pres-clock');
        if(clock) {
            let now = new Date();
            clock.innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
    }, 1000);
</script>
