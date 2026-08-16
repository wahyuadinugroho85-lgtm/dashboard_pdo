<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Eksekutif Perkebunan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .modern-matrix { border-collapse: separate; border-spacing: 0; width: 100%; white-space: nowrap; }
        .modern-matrix th, .modern-matrix td { border-bottom: 1px solid #f1f5f9; padding: 10px 12px; }
        .modern-matrix thead th { border-bottom: 2px solid #e2e8f0; background-color: #f8fafc; position: sticky; top: 0; z-index: 10; }
        .row-border-strong td { border-bottom: 2px solid #e2e8f0 !important; }
        .valign-top { vertical-align: top; padding-top: 12px; }
        
        input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type="number"] { -moz-appearance: textfield; }

        #analytics-container:-webkit-full-screen { background-color: #f8fafc; padding: 2rem; overflow-y: auto; }
        #analytics-container:fullscreen { background-color: #f8fafc; padding: 2rem; overflow-y: auto; }
        
        .tooltip-table { width: max-content; min-width: 250px; }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900">

    <nav class="bg-white border-b border-slate-200 px-6 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-4">
            <a href="/input-data" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold px-5 py-2.5 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> Input Data
            </a>
            
            <form method="GET" action="/laporan-manajemen" class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-lg border border-slate-200 shadow-sm">
                <select name="bulan" class="bg-transparent text-sm font-semibold text-slate-700 outline-none cursor-pointer pl-2 pr-1">
                    @for($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>Bulan {{ $i }}</option> @endfor
                </select>
                <span class="text-slate-300">|</span>
                <select name="tahun" class="bg-transparent text-sm font-semibold text-slate-700 outline-none cursor-pointer pl-1 pr-2">
                    @for($i = 2023; $i <= date('Y') + 1; $i++) <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                </select>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-5 py-1.5 rounded-md transition-colors shadow-sm">Terapkan</button>
            </form>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="text-sm text-slate-500 border-r border-slate-200 pr-4 py-1">
                Masuk sebagai: <strong class="text-slate-800">{{ Auth::user()->name ?? 'Admin Laporan' }}</strong>
            </div>
            <div class="flex gap-2">
                <a href="/kelola-user" class="bg-white hover:bg-slate-50 text-slate-600 border border-slate-300 text-sm font-bold px-4 py-2 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                 ⚙️ Kelola User
               </a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-sm font-bold px-4 py-2 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="bg-white border-b border-slate-200 px-6 pt-5 sticky top-[75px] z-40">
        <ul class="flex space-x-8 text-sm font-semibold text-slate-500 overflow-x-auto">
            <li><button onclick="switchTab('tab-analytics')" id="btn-tab-analytics" class="tab-btn pb-3.5 border-b-[3px] border-indigo-600 text-indigo-700 transition-colors whitespace-nowrap">Dashboard Analytics</button></li>
            <li><button onclick="switchTab('tab-produksi')" id="btn-tab-produksi" class="tab-btn pb-3.5 border-b-[3px] border-transparent hover:text-slate-800 transition-colors whitespace-nowrap">Modul Produksi & Biaya</button></li>
            <li><button onclick="switchTab('tab-agronomi')" id="btn-tab-agronomi" class="tab-btn pb-3.5 border-b-[3px] border-transparent hover:text-slate-800 transition-colors whitespace-nowrap">Rawat & Pupuk</button></li>
            <li><button onclick="switchTab('tab-kualitas')" id="btn-tab-kualitas" class="tab-btn pb-3.5 border-b-[3px] border-transparent hover:text-slate-800 transition-colors whitespace-nowrap">Kualitas Buah</button></li>
            <li><button onclick="switchTab('tab-performance')" id="btn-tab-performance" class="tab-btn pb-3.5 border-b-[3px] border-transparent hover:text-slate-800 transition-colors whitespace-nowrap">Performance TK</button></li>
        </ul>
    </div>

    <div class="w-full px-6 py-8 overflow-x-auto">
        
        @php
            $monthNames = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
            $labelBulan = $monthNames[(int)$bulan] . '-' . substr($tahun, 2, 2);
            $nextMonth = $bulan == 12 ? 1 : $bulan + 1;
            $nextYear = $bulan == 12 ? $tahun + 1 : $tahun;
            $labelBulanNext = $monthNames[(int)$nextMonth] . '-' . substr($nextYear, 2, 2);
            $namaBulanIni = $monthNames[(int)$bulan];

            /* ========================================================= */
            /* 1. KALKULASI DATA EXECUTIVE SUMMARY & UMUM                */
            /* ========================================================= */
            $gRealKgSd = $dataMatrix['BP-2']['histori']['real_sd_'.$tahun]->tonase ?? 0;
            $gBgtKg1Thn = $dataMatrix['BP-2']['histori']['bgt_1_thn']->tonase ?? 0;
            
            $gRealKg = $dataMatrix['BP-2']['produksi']['current']['real']->tonase ?? 0;
            $gBgtKg = $dataMatrix['BP-2']['produksi']['current']['budget']->tonase ?? 0;
            $gRkbKg = $dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0;
            
            $gPctRkb = $gRkbKg > 0 ? ($gRealKg / $gRkbKg) * 100 : 0;
            $gPctBgt = $gBgtKg > 0 ? ($gRealKg / $gBgtKg) * 100 : 0;
            $gRealJjg = $dataMatrix['BP-2']['produksi']['current']['real']->janjang ?? 0;
            $gBjr = $gRealJjg > 0 ? $gRealKg / $gRealJjg : 0;

            $gTotalBiaya = ($dataMatrix['BP-2']['biaya']['real']->cost_panen ?? 0) + ($dataMatrix['BP-2']['biaya']['real']->cost_rawat ?? 0) + ($dataMatrix['BP-2']['biaya']['real']->cost_kantor ?? 0) + ($dataMatrix['BP-2']['biaya']['real']->cost_teknik ?? 0) + ($dataMatrix['BP-2']['biaya']['real']->cost_pks ?? 0);
            $gBiayaSd = ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_pks ?? 0);
            $gCostPerKgSd = $gRealKgSd > 0 ? ($gBiayaSd / $gRealKgSd) : 0;

            $gTotalRawat = 0; $gTotalPupuk = 0; $gTotalTK = 0; 
            $gTotalHkPanen = $dataMatrix['BP-2']['produksi']['current']['real']->hk_panen ?? 0;
            
            $bestProdPT = '-'; $bestProdPct = 0; $bestProdKg = 0;
            $bestCostPT = '-'; $bestCostPct = 99999999; $bestCostVal = 0;
            
            foreach($estates as $estate) {
                foreach($jenisPerawatan as $rawat) { $gTotalRawat += $dataMatrix[$estate->kode]['upkeep']['real'][$rawat]->luas_ha ?? 0; }
                foreach($jenisPupuk as $pupuk) { $gTotalPupuk += $dataMatrix[$estate->kode]['pupuk']['real'][$pupuk]->jumlah_kg ?? 0; }
                foreach($kategoriPekerja as $kat) {
                    if(isset($dataMatrix[$estate->kode]['pekerja'][$kat])) {
                        foreach($dataMatrix[$estate->kode]['pekerja'][$kat] as $pkj) { $gTotalTK += $pkj->jumlah_tk; }
                    }
                }

                $ptRealSdKg = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                $ptBgt1ThnKg = $dataMatrix[$estate->kode]['histori']['bgt_1_thn']->tonase ?? 0;
                $pctProd = $ptBgt1ThnKg > 0 ? ($ptRealSdKg / $ptBgt1ThnKg) * 100 : 0;
                if($pctProd > $bestProdPct) { $bestProdPct = $pctProd; $bestProdPT = $estate->kode; $bestProdKg = $ptRealSdKg; }

                $ptBSdReal = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0);
                $ckgReal = $ptRealSdKg > 0 ? ($ptBSdReal / $ptRealSdKg) : 0;
                $ptBgtKgSd = $dataMatrix[$estate->kode]['histori']['bgt_sd_bln']->tonase ?? 0;
                $ptBSdBgt = ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_pks ?? 0);
                $ckgBgt = $ptBgtKgSd > 0 ? ($ptBSdBgt / $ptBgtKgSd) : 0;
                $pctCost = $ckgBgt > 0 ? ($ckgReal / $ckgBgt) * 100 : 0;

                if($pctCost > 0 && $pctCost < $bestCostPct) { 
                    $bestCostPct = $pctCost; $bestCostPT = $estate->kode; $bestCostVal = $ckgReal; 
                }
            }

            /* ========================================================= */
            /* 2. KALKULASI DATA EKSTRAKSI & MILL                        */
            /* ========================================================= */
            $millBi = []; $millSd = [];
            $gTbsBi = 0; $gTbsSd = 0; $gCpoBi = 0; $gCpoSd = 0; $gKerBi = 0; $gKerSd = 0; $gPkoBi = 0; $gPkoSd = 0;

            foreach($estates as $estate) {
                $kgTbsBi = $dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0;
                $tonTbsBi = $kgTbsBi / 1000;
                $tonCpoBi = $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_cpo ?? 0;
                $tonKerBi = $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_ker ?? 0;
                $tonPkoBi = $dataMatrix[$estate->kode]['produksi']['current']['real']->ton_pko ?? 0;
                $oerBi = $tonTbsBi > 0 ? ($tonCpoBi / $tonTbsBi) * 100 : 0;
                $kerBi = $tonTbsBi > 0 ? ($tonKerBi / $tonTbsBi) * 100 : 0;
                $pkoBi = $tonKerBi > 0 ? ($tonPkoBi / $tonKerBi) * 100 : 0;
                $tonPalmProdukBi = $tonCpoBi + $tonKerBi;
                $tonPalmOilBi = $tonCpoBi + $tonPkoBi;
                $hsHaBi = $dataMatrix[$estate->kode]['produksi']['current']['real']->hs_ha ?? 0;
                $tonHaCpoBi = $hsHaBi > 0 ? $tonCpoBi / $hsHaBi : 0;
                $tonHaPalmOilBi = $hsHaBi > 0 ? $tonPalmOilBi / $hsHaBi : 0;
                $millBi[$estate->kode] = compact('kgTbsBi', 'oerBi', 'kerBi', 'pkoBi', 'tonCpoBi', 'tonKerBi', 'tonPalmProdukBi', 'tonPkoBi', 'tonPalmOilBi', 'tonHaCpoBi', 'tonHaPalmOilBi');
                
                $kgTbsSd = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                $tonTbsSd = $kgTbsSd / 1000;
                $tonCpoSd = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->ton_cpo ?? 0;
                $tonKerSd = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->ton_ker ?? 0;
                $tonPkoSd = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->ton_pko ?? 0;
                $oerSd = $tonTbsSd > 0 ? ($tonCpoSd / $tonTbsSd) * 100 : 0;
                $kerSd = $tonTbsSd > 0 ? ($tonKerSd / $tonTbsSd) * 100 : 0;
                $pkoSd = $tonKerSd > 0 ? ($tonPkoSd / $tonKerSd) * 100 : 0;
                $tonPalmProdukSd = $tonCpoSd + $tonKerSd;
                $tonPalmOilSd = $tonCpoSd + $tonPkoSd;
                $tonHaCpoSd = $hsHaBi > 0 ? $tonCpoSd / $hsHaBi : 0;
                $tonHaPalmOilSd = $hsHaBi > 0 ? $tonPalmOilSd / $hsHaBi : 0;
                $millSd[$estate->kode] = compact('kgTbsSd', 'oerSd', 'kerSd', 'pkoSd', 'tonCpoSd', 'tonKerSd', 'tonPalmProdukSd', 'tonPkoSd', 'tonPalmOilSd', 'tonHaCpoSd', 'tonHaPalmOilSd');
                
                $gTbsBi += $kgTbsBi; $gTbsSd += $kgTbsSd; $gCpoBi += $tonCpoBi; $gCpoSd += $tonCpoSd; $gKerBi += $tonKerBi; $gKerSd += $tonKerSd; $gPkoBi += $tonPkoBi; $gPkoSd += $tonPkoSd;
            }
            
            $gTonTbsBi = $gTbsBi / 1000; $gOerBi = $gTonTbsBi > 0 ? ($gCpoBi / $gTonTbsBi) * 100 : 0; $gPctKerBi = $gTonTbsBi > 0 ? ($gKerBi / $gTonTbsBi) * 100 : 0; $gPctPkoBi = $gKerBi > 0 ? ($gPkoBi / $gKerBi) * 100 : 0; $gPalmProdukBi = $gCpoBi + $gKerBi; $gPalmOilBi = $gCpoBi + $gPkoBi; $gHsHaTotal = $dataMatrix['BP-2']['produksi']['current']['real']->hs_ha ?? 0; $gTonHaCpoBi = $gHsHaTotal > 0 ? $gCpoBi / $gHsHaTotal : 0; $gTonHaPalmOilBi = $gHsHaTotal > 0 ? $gPalmOilBi / $gHsHaTotal : 0;
            $gTonTbsSd = $gTbsSd / 1000; $gOerSd = $gTonTbsSd > 0 ? ($gCpoSd / $gTonTbsSd) * 100 : 0; $gPctKerSd = $gTonTbsSd > 0 ? ($gKerSd / $gTonTbsSd) * 100 : 0; $gPctPkoSd = $gKerSd > 0 ? ($gPkoSd / $gKerSd) * 100 : 0; $gPalmProdukSd = $gCpoSd + $gKerSd; $gPalmOilSd = $gCpoSd + $gPkoSd; $gTonHaCpoSd = $gHsHaTotal > 0 ? $gCpoSd / $gHsHaTotal : 0; $gTonHaPalmOilSd = $gHsHaTotal > 0 ? $gPalmOilSd / $gHsHaTotal : 0;

            /* ========================================================= */
            /* 3. KALKULASI DATA BIAYA & DEVIASI COST                    */
            /* ========================================================= */
            $biayaStats = []; $gBiayaRealSd = 0; $gBiayaBgtSd = 0;
            
            foreach($estates as $estate) {
                $tBiayaSd = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0);
                $tPalmProdukKg = ($millSd[$estate->kode]['tonPalmProdukSd'] ?? 0) * 1000;
                $tPalmOilKg = ($millSd[$estate->kode]['tonPalmOilSd'] ?? 0) * 1000;
                $bgtRecord = $dataMatrix[$estate->kode]['biaya']['budget_year'] ?? null;
                $costPalmProdukBgt = $bgtRecord->bgt_cost_palm_produk ?? 0;
                $costPalmOilBgt = $bgtRecord->bgt_cost_palm_oil ?? 0;
                $costPalmProdukReal = $tPalmProdukKg > 0 ? $tBiayaSd / $tPalmProdukKg : 0;
                $costPalmOilReal = $tPalmOilKg > 0 ? $tBiayaSd / $tPalmOilKg : 0;
                $devProdRpKg = $costPalmProdukBgt - $costPalmProdukReal;
                $devOilRpKg = $costPalmOilBgt - $costPalmOilReal;
                $devProdRp = $devProdRpKg * $tPalmProdukKg;
                $devOilRp = $devOilRpKg * $tPalmOilKg;
                $biayaStats[$estate->kode] = compact('costPalmProdukReal', 'costPalmOilReal', 'costPalmProdukBgt', 'costPalmOilBgt', 'devProdRpKg', 'devProdRp', 'devOilRpKg', 'devOilRp');
                $gBiayaRealSd += $tBiayaSd;
            }

            $gPalmProdukKgTotal = $gPalmProdukSd * 1000; $gPalmOilKgTotal = $gPalmOilSd * 1000;
            $gCostPalmProdukReal = $gPalmProdukKgTotal > 0 ? $gBiayaRealSd / $gPalmProdukKgTotal : 0;
            $gCostPalmOilReal = $gPalmOilKgTotal > 0 ? $gBiayaRealSd / $gPalmOilKgTotal : 0;
            $bgtRecordBP2 = $dataMatrix['BP-2']['biaya']['budget_year'] ?? null;
            $gCostPalmProdukBgt = $bgtRecordBP2->bgt_cost_palm_produk ?? 0;
            $gCostPalmOilBgt = $bgtRecordBP2->bgt_cost_palm_oil ?? 0;
            $gDevProdRpKg = $gCostPalmProdukBgt - $gCostPalmProdukReal;
            $gDevProdRp = $gDevProdRpKg * $gPalmProdukKgTotal;
            $gDevOilRpKg = $gCostPalmOilBgt - $gCostPalmOilReal;
            $gDevOilRp = $gDevOilRpKg * $gPalmOilKgTotal;
        @endphp

        <!-- ================= TAB 0: DASHBOARD ANALYTICS ================= -->
        <div id="tab-analytics" class="tab-content block w-full space-y-6">
            <div id="analytics-container" class="transition-all duration-300 rounded-xl">
                
                <div class="bg-gradient-to-r from-indigo-700 via-blue-600 to-sky-500 rounded-2xl shadow-lg p-6 mb-6 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-white border-l-4 border-indigo-500 shadow-sm p-4 rounded-xl flex items-center gap-4">
                        <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Pencapaian Produksi Terbaik</p>
                            <p class="text-sm text-slate-700 mt-1">Divisi <strong class="text-lg text-indigo-700">{{ $bestProdPT }}</strong> memimpin dengan <strong class="text-lg text-indigo-700">{{ number_format($bestProdPct, 1) }}%</strong> dari Target Tahunan (Terkumpul {{ number_format($bestProdKg / 1000, 0) }} Ton).</p>
                        </div>
                    </div>
                    <div class="bg-white border-l-4 border-emerald-500 shadow-sm p-4 rounded-xl flex items-center gap-4">
                        <div class="bg-emerald-100 text-emerald-600 p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Efisiensi Terbaik (% Cost/Kg vs Bgt)</p>
                            <p class="text-sm text-slate-700 mt-1">Divisi <strong class="text-lg text-emerald-700">{{ $bestCostPT }}</strong> mencatat pengeluaran terhemat (<strong class="text-lg text-emerald-700">{{ number_format($bestCostPct, 1) }}%</strong> thd Bgt) di angka Rp {{ number_format($bestCostVal, 2) }}/Kg TBS.</p>
                        </div>
                    </div>
                </div>

                <div id="dynamic-dashboard-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <!-- POIN 1: SUMMARY PRODUKSI INTERAKTIF -->
                    <div id="w-summary-prod" data-wname="Summary Produksi (Tabel Interaktif)" class="widget-item col-span-1 md:col-span-2 lg:col-span-4 bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-4 border-b border-slate-100 bg-slate-50/80 flex justify-between items-center">
                            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                <span class="bg-indigo-500 w-2 h-4 rounded-sm inline-block"></span> 
                                Data Pencapaian Produksi - {{ $labelBulan }}
                            </h3>
                        </div>
                        <div class="overflow-x-auto p-4">
                            <table class="w-full text-sm text-right border-collapse">
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
                                    <!-- ROW RKB -->
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

                                    <!-- ROW REAL -->
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

                                    <!-- ROW DEV -->
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
                                    <!-- POIN 2: PERBAIKAN RUMUS DEVIASI Jjg/Pkk -->
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

                    <div id="w-biaya" data-wname="Total Biaya (M)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-amber-500 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total Biaya (M)</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gBiayaRealSd / 1000000, 2) }} M</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Biaya Operasional s.d Bulan Ini</p>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-lg group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="absolute left-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700">
                                <div class="font-bold text-amber-300 mb-2 border-b border-slate-600 pb-1">Detail Biaya per PT (M)</div>
                                <table class="w-full">
                                    @foreach($estates as $estate)
                                        @php $ptBiaya = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0); @endphp
                                        <tr class="border-b border-slate-700 last:border-0"><td class="py-1.5 font-medium">{{ $estate->kode }}</td><td class="text-right font-bold text-white">{{ number_format($ptBiaya / 1000000, 2) }} M</td></tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="w-cost" data-wname="Cost / Kg TBS (Rp)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-emerald-500 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Cost/Kg TBS</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gCostPerKgSd, 2) }}</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Rp S.D Bln / Kg TBS S.D Bln</p>
                        </div>
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700">
                                <div class="font-bold text-emerald-300 mb-2 border-b border-slate-600 pb-1">Detail Cost/Kg (S.D Bln) per PT</div>
                                <table class="w-full text-right">
                                    <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-2">Bgt Rp/Kg</th><th class="pb-1 pl-2">Real Rp/Kg</th><th class="pb-1 pl-2">% Bgt</th></tr>
                                    @foreach($estates as $estate)
                                        @php 
                                            // Real
                                            $tSd = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                            $bSd = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0);
                                            $ptCostKgSd = $tSd > 0 ? ($bSd / $tSd) : 0;
                                            // Bgt
                                            $tBgtSd = $dataMatrix[$estate->kode]['histori']['bgt_sd_bln']->tonase ?? 0;
                                            $bBgtSd = ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_pks ?? 0);
                                            $ptBgtCostKg = $tBgtSd > 0 ? ($bBgtSd / $tBgtSd) : 0;
                                            // Pct
                                            $pC = $ptBgtCostKg > 0 ? ($ptCostKgSd / $ptBgtCostKg) * 100 : 0;
                                        @endphp
                                        <tr class="border-b border-slate-700 last:border-0">
                                            <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                            <td class="pl-3">{{ number_format($ptBgtCostKg, 2) }}</td>
                                            <td class="pl-3 font-bold text-white">{{ number_format($ptCostKgSd, 2) }}</td>
                                            <td class="pl-3 {{ $pC <= 100 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($pC, 1) }}%</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="w-cost-produk" data-wname="Cost Palm Produk (Rp/Kg)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-slate-500 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Cost Palm Produk</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gCostPalmProdukReal, 0) }}</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Rp S.D Bln / Kg Produk S.D Bln</p>
                        </div>
                        <div class="p-3 bg-slate-100 text-slate-600 rounded-lg group-hover:bg-slate-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                        </div>
                        <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700">
                                <div class="font-bold text-slate-300 mb-2 border-b border-slate-600 pb-1">Detail Cost Palm Produk per PT</div>
                                <table class="w-full text-right">
                                    <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-2">Bgt Rp/Kg</th><th class="pb-1 pl-2">Real Rp/Kg</th><th class="pb-1 pl-2">% Bgt</th></tr>
                                    @foreach($estates as $estate)
                                        @php
                                            $bgt = $biayaStats[$estate->kode]['costPalmProdukBgt'];
                                            $real = $biayaStats[$estate->kode]['costPalmProdukReal'];
                                            $pct = $bgt > 0 ? ($real / $bgt) * 100 : 0;
                                        @endphp
                                        <tr class="border-b border-slate-700 last:border-0">
                                            <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                            <td class="pl-3">{{ number_format($bgt, 0) }}</td>
                                            <td class="pl-3 font-bold text-white">{{ number_format($real, 0) }}</td>
                                            <td class="pl-3 {{ $pct <= 100 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($pct, 1) }}%</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="w-cost-oil" data-wname="Cost Palm Oil (Rp/Kg)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-green-600 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Cost Palm Oil</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gCostPalmOilReal, 0) }}</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Rp S.D Bln / Kg Oil S.D Bln</p>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700">
                                <div class="font-bold text-green-300 mb-2 border-b border-slate-600 pb-1">Detail Cost Palm Oil per PT</div>
                                <table class="w-full text-right">
                                    <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-2">Bgt Rp/Kg</th><th class="pb-1 pl-2">Real Rp/Kg</th><th class="pb-1 pl-2">% Bgt</th></tr>
                                    @foreach($estates as $estate)
                                        @php
                                            $bgt = $biayaStats[$estate->kode]['costPalmOilBgt'];
                                            $real = $biayaStats[$estate->kode]['costPalmOilReal'];
                                            $pct = $bgt > 0 ? ($real / $bgt) * 100 : 0;
                                        @endphp
                                        <tr class="border-b border-slate-700 last:border-0">
                                            <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                            <td class="pl-3">{{ number_format($bgt, 0) }}</td>
                                            <td class="pl-3 font-bold text-white">{{ number_format($real, 0) }}</td>
                                            <td class="pl-3 {{ $pct <= 100 ? 'text-emerald-400' : 'text-rose-400' }}">{{ number_format($pct, 1) }}%</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="w-bjr" data-wname="Rata-rata BJR" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-sky-500 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Rata-rata BJR</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gBjr, 2) }}</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Berat Janjang Rata-rata</p>
                        </div>
                        <div class="p-3 bg-sky-50 text-sky-600 rounded-lg group-hover:bg-sky-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        </div>
                        <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700">
                                <div class="font-bold text-sky-300 mb-2 border-b border-slate-600 pb-1">Detail BJR per PT (Bln Ini vs Bln Lalu)</div>
                                <table class="w-full text-right">
                                    <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-2">Bln Ini</th><th class="pb-1 pl-2">Bln Lalu</th><th class="pb-1 pl-2">Trend</th></tr>
                                    @foreach($estates as $estate)
                                        @php 
                                            $bIni = $dataMatrix[$estate->kode]['produksi']['current']['bjr_real'] ?? 0;
                                            $bLalu = $dataMatrix[$estate->kode]['produksi']['current']['bjr_last_month'] ?? 0;
                                        @endphp
                                        <tr class="border-b border-slate-700 last:border-0">
                                            <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                            <td class="pl-3 font-bold text-white">{{ number_format($bIni, 2) }}</td>
                                            <td class="pl-3">{{ number_format($bLalu, 2) }}</td>
                                            <td class="pl-3 text-center text-lg">
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

                    <div id="w-rawat" data-wname="Total Rawat (Ha)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-teal-500 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total Rawat (Ha)</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gTotalRawat, 2) }}</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Realisasi Perawatan</p>
                        </div>
                        <div class="p-3 bg-teal-50 text-teal-600 rounded-lg group-hover:bg-teal-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <div class="absolute left-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700" style="min-width: 400px;">
                                <div class="font-bold text-teal-300 mb-2 border-b border-slate-600 pb-1 flex justify-between">
                                    <span>Detail Rawat per PT</span>
                                    <span class="text-slate-400 font-normal">Termasuk Cost/Ha & Pencapaian</span>
                                </div>
                                <table class="w-full text-right">
                                    <tr class="text-slate-400 border-b border-slate-600">
                                        <th class="text-left pb-1">PT</th>
                                        <th class="pb-1 pl-2 text-center">Blok</th>
                                        <th class="pb-1 pl-2">Luas (Ha)</th>
                                        <th class="pb-1 pl-2">% RKB</th>
                                        <th class="pb-1 pl-2">Cost/Ha (Rp)</th>
                                    </tr>
                                    @foreach($estates as $estate)
                                        @php
                                            $luasTtl = 0; 
                                            $blokTtl = 0; 
                                            $luasRkb = 0;
                                            foreach($jenisPerawatan as $rawat) { 
                                                $luasTtl += $dataMatrix[$estate->kode]['upkeep']['real'][$rawat]->luas_ha ?? 0; 
                                                $blokTtl += $dataMatrix[$estate->kode]['upkeep']['real'][$rawat]->jml_blok ?? 0; 
                                                $luasRkb += $dataMatrix[$estate->kode]['upkeep']['rkb'][$rawat]->luas_ha ?? 0; 
                                            }
                                            $pct = $luasRkb > 0 ? ($luasTtl / $luasRkb) * 100 : 0;
                                            $costRawatSdBln = $dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0;
                                            $costHa = $luasTtl > 0 ? $costRawatSdBln / $luasTtl : 0;
                                        @endphp
                                        <tr class="border-b border-slate-700 last:border-0">
                                            <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                            <td class="pl-2 text-center">{{ number_format($blokTtl, 0) }}</td>
                                            <td class="pl-2 font-bold text-white">{{ number_format($luasTtl, 2) }}</td>
                                            <td class="pl-2 text-emerald-400">{{ number_format($pct, 1) }}%</td>
                                            <td class="pl-2 text-amber-300">{{ number_format($costHa, 0) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="w-pupuk" data-wname="Total Pupuk (Ton)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-yellow-500 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total Pupuk (Ton)</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gTotalPupuk, 0) }}</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Aplikasi Bulan Ini</p>
                        </div>
                        <div class="p-3 bg-yellow-50 text-yellow-600 rounded-lg group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div class="absolute left-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700">
                                <div class="font-bold text-yellow-300 mb-2 border-b border-slate-600 pb-1">Detail Pupuk per PT (Ton)</div>
                                <table class="w-full text-right">
                                    <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-2">Bgt</th><th class="pb-1 pl-2">Real</th><th class="pb-1 pl-2">% Pencapaian</th></tr>
                                    @foreach($estates as $estate)
                                        @php 
                                            $pR = 0; $pB = 0; 
                                            foreach($jenisPupuk as $ppk) { 
                                                $pR += $dataMatrix[$estate->kode]['pupuk']['real'][$ppk]->jumlah_kg ?? 0; 
                                                $pB += $dataMatrix[$estate->kode]['pupuk']['budget'][$ppk]->jumlah_kg ?? 0; 
                                            } 
                                            $pP = $pB > 0 ? ($pR/$pB)*100 : 0;
                                        @endphp
                                        <tr class="border-b border-slate-700 last:border-0">
                                            <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                            <td class="pl-2">{{ number_format($pB, 0) }}</td>
                                            <td class="pl-2 font-bold text-white">{{ number_format($pR, 0) }}</td>
                                            <td class="pl-2 {{ $pP >= 100 ? 'text-emerald-400' : 'text-amber-400' }}">{{ number_format($pP, 1) }}%</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="w-tk" data-wname="Total Kinerja TK (Org)" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-blue-500 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total Kinerja TK</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gTotalTK, 0) }}</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Jumlah Orang Terinput</p>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700">
                                <div class="font-bold text-blue-300 mb-2 border-b border-slate-600 pb-1">Detail TK per PT</div>
                                <table class="w-full text-right">
                                    <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-2">Total Orang</th></tr>
                                    @foreach($estates as $estate)
                                        @php 
                                            $ptTk = 0; 
                                            foreach($kategoriPekerja as $kat) { 
                                                if(isset($dataMatrix[$estate->kode]['pekerja'][$kat])) { 
                                                    foreach($dataMatrix[$estate->kode]['pekerja'][$kat] as $pkj) { 
                                                        $ptTk += $pkj->jumlah_tk; 
                                                    } 
                                                } 
                                            } 
                                        @endphp
                                        <tr class="border-b border-slate-700 last:border-0">
                                            <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                            <td class="font-bold text-white">{{ number_format($ptTk, 0) }} Orang</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="w-kunjungan" data-wname="HK Panen" class="widget-item col-span-1 group relative bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-center justify-between border-l-4 border-l-rose-500 hover:shadow-md transition-all cursor-help">
                        <div>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-1 flex items-center gap-1">Total HK Panen</p>
                            <h3 class="text-2xl font-extrabold text-slate-800">{{ number_format($gTotalHkPanen, 0) }}</h3>
                            <p class="text-xs font-medium text-slate-400 mt-1">Hari Kerja Panen Realisasi</p>
                        </div>
                        <div class="p-3 bg-rose-50 text-rose-600 rounded-lg group-hover:bg-rose-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="absolute right-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                            <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700">
                                <div class="font-bold text-rose-300 mb-2 border-b border-slate-600 pb-1">Detail HK Panen per PT</div>
                                <table class="w-full text-right">
                                    <tr class="text-slate-400 border-b border-slate-600"><th class="text-left pb-1">PT</th><th class="pb-1 pl-2">Total HK</th></tr>
                                    @foreach($estates as $estate)
                                        <tr class="border-b border-slate-700 last:border-0">
                                            <td class="py-1.5 text-left font-medium">{{ $estate->kode }}</td>
                                            <td class="font-bold text-white">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->hk_panen ?? 0, 0) }} HK</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="w-chart-prod" data-wname="Chart: Produksi per PT" class="widget-item col-span-1 md:col-span-2 lg:col-span-4 bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Kinerja Produksi (Ton) per PT</h3>
                        <div class="relative h-80 w-full"><canvas id="chartProduksi"></canvas></div>
                    </div>

                    <div id="w-chart-cost" data-wname="Chart: Cost/Kg per PT" class="widget-item col-span-1 md:col-span-2 lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Grafik Cost / Kg TBS per PT (S.D Bln Ini)</h3>
                        <div class="relative h-64 w-full"><canvas id="chartCostKg"></canvas></div>
                    </div>

                    <div id="w-chart-biaya" data-wname="Chart: Distribusi Biaya" class="widget-item col-span-1 lg:col-span-1 bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Distribusi Total Biaya</h3>
                        <div class="relative h-64 w-full flex justify-center"><canvas id="chartBiayaPie"></canvas></div>
                    </div>

                    <div id="w-chart-mutu" data-wname="Chart: Mutu Ancak" class="widget-item col-span-1 lg:col-span-1 bg-white rounded-xl shadow-sm border border-slate-200 p-5">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Rata-rata Mutu (%)</h3>
                        <div class="relative h-64 w-full"><canvas id="chartMutu"></canvas></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= MODAL PENGATURAN DASHBOARD ================= -->
        <div id="modal-layout" class="fixed inset-0 z-[200] hidden bg-slate-900/60 backdrop-blur-sm flex justify-center items-center">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden flex flex-col max-h-[90vh]">
                <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-800">Sesuaikan Tampilan Dashboard</h3>
                    <button onclick="document.getElementById('modal-layout').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 overflow-y-auto flex-1 text-sm text-slate-600">
                    <p class="mb-4">Centang data yang ingin ditampilkan dan tarik ikon <span class="inline-block px-1 bg-slate-200 rounded">☰</span> untuk mengatur urutan posisinya di layar utama.</p>
                    <ul id="layout-list" class="space-y-2"></ul>
                </div>
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex justify-end gap-3">
                    <button onclick="resetLayout()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg transition-colors text-sm">Kembalikan Default</button>
                    <button onclick="saveLayout()" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow transition-colors text-sm">Simpan & Terapkan</button>
                </div>
            </div>
        </div>

        <!-- ================= TAB 1: MODUL PRODUKSI & BIAYA ================= -->
        <div id="tab-produksi" class="tab-content hidden min-w-[900px]">
            
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <table class="modern-matrix text-sm">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-left text-slate-400 font-medium">Bulan Berjalan & Histori</th>
                            @foreach($estates as $estate)
                                <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase tracking-wider">{{ $estate->kode }}</th>
                            @endforeach
                            <th class="text-center font-bold text-indigo-800 bg-indigo-50 uppercase tracking-wider shadow-sm">BP-2</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        <tr class="bg-slate-50/50">
                            <td colspan="3" class="text-left font-bold text-slate-700 border-r border-slate-100 pl-4">HS (Ha)</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-medium text-slate-800">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_ha ?? 0, 2) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($dataMatrix['BP-2']['produksi']['current']['real']->hs_ha ?? 0, 2) }}</td>
                        </tr>
                        <tr class="bg-slate-50/50 row-border-strong">
                            <td colspan="3" class="text-left font-bold text-slate-700 border-r border-slate-100 pl-4">HS (Pokok)</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-medium text-slate-800">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0, 0) }}</td>
                        </tr>

                        <tr>
                            <td rowspan="4" class="valign-top font-bold text-slate-800 bg-slate-50/80 border-r border-slate-100 w-24 text-center">{{ $labelBulan }}</td>
                            <td rowspan="4" class="valign-top font-bold text-indigo-700 bg-indigo-50/30 border-r border-slate-100 w-20 text-center">RKB</td>
                            <td class="font-medium">Produksi (Ton)</td>
                            @foreach($estates as $estate) 
                                <td class="text-right">{{ number_format(($dataMatrix[$estate->kode]['produksi']['current']['rkb']->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format(($dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        <tr>
                            <td class="">Janjang</td>
                            @foreach($estates as $estate) 
                                <td class="text-right">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['rkb']->janjang ?? 0, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($dataMatrix['BP-2']['produksi']['current']['rkb']->janjang ?? 0, 0) }}</td>
                        </tr>
                        <tr>
                            <td class="">Bjr</td>
                            @foreach($estates as $estate) 
                                <td class="text-right text-slate-500">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['bjr_rkb'] ?? 0, 2) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($dataMatrix['BP-2']['produksi']['current']['bjr_rkb'] ?? 0, 2) }}</td>
                        </tr>
                        <tr class="row-border-strong">
                            <td class="">Jjg/Pkk</td>
                            @foreach($estates as $estate)
                                @php 
                                    $hsPkk = $dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0;
                                    $rkbJjgPkk = $hsPkk > 0 ? ($dataMatrix[$estate->kode]['produksi']['current']['rkb']->janjang ?? 0) / $hsPkk : 0; 
                                @endphp
                                <td class="text-right text-slate-500">{{ number_format($rkbJjgPkk, 2) }}</td>
                            @endforeach
                            @php 
                                $gHsPkk = $dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0;
                                $grkbJjgPkk = $gHsPkk > 0 ? ($dataMatrix['BP-2']['produksi']['current']['rkb']->janjang ?? 0) / $gHsPkk : 0; 
                            @endphp
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-500">{{ number_format($grkbJjgPkk, 2) }}</td>
                        </tr>

                        <tr>
                            <td rowspan="4" class="bg-slate-50/80 border-r border-slate-100"></td>
                            <td rowspan="4" class="valign-top font-bold text-emerald-700 bg-emerald-50/30 border-r border-slate-100 text-center">Real</td>
                            <td class="font-bold text-slate-800">Produksi (Ton)</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-bold text-slate-900">{{ number_format(($dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format(($dataMatrix['BP-2']['produksi']['current']['real']->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-800">Janjang</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-bold text-slate-900">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->janjang ?? 0, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($dataMatrix['BP-2']['produksi']['current']['real']->janjang ?? 0, 0) }}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-700">Bjr</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-medium text-slate-700">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['bjr_real'] ?? 0, 2) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($dataMatrix['BP-2']['produksi']['current']['bjr_real'] ?? 0, 2) }}</td>
                        </tr>
                        <tr class="row-border-strong">
                            <td class="font-medium text-slate-700">Jjg/Pkk</td>
                            @foreach($estates as $estate)
                                @php 
                                    $hsPkk = $dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0;
                                    $realJjgPkk = $hsPkk > 0 ? ($dataMatrix[$estate->kode]['produksi']['current']['real']->janjang ?? 0) / $hsPkk : 0; 
                                @endphp
                                <td class="text-right font-medium text-slate-700">{{ number_format($realJjgPkk, 2) }}</td>
                            @endforeach
                            @php 
                                $gHsPkk = $dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0;
                                $grealJjgPkk = $gHsPkk > 0 ? ($dataMatrix['BP-2']['produksi']['current']['real']->janjang ?? 0) / $gHsPkk : 0; 
                            @endphp
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($grealJjgPkk, 2) }}</td>
                        </tr>

                        <tr>
                            <td rowspan="3" class="bg-slate-50/80 border-r border-slate-100 row-border-strong"></td>
                            <td rowspan="3" class="valign-top font-bold text-rose-700 bg-rose-50/30 border-r border-slate-100 text-center row-border-strong">Dev</td>
                            <td class="font-medium text-slate-700">Produksi (Ton)</td>
                            @foreach($estates as $estate)
                                @php
                                    $r = $dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0;
                                    $b = $dataMatrix[$estate->kode]['produksi']['current']['rkb']->tonase ?? 0;
                                    $dev = ($r - $b) / 1000;
                                    $colorClass = $dev < 0 ? 'text-rose-600 bg-rose-50/40' : 'text-emerald-600 bg-emerald-50/40';
                                @endphp
                                <td class="text-right font-bold {{ $colorClass }}">{{ $dev < 0 ? '('.number_format(abs($dev), 0).')' : number_format($dev, 0) }}</td>
                            @endforeach
                            @php
                                $gr = $dataMatrix['BP-2']['produksi']['current']['real']->tonase ?? 0;
                                $gb = $dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0;
                                $gdev = ($gr - $gb) / 1000;
                                $gColor = $gdev < 0 ? 'text-rose-600 bg-rose-50' : 'text-emerald-600 bg-emerald-50';
                            @endphp
                            <td class="text-right font-bold {{ $gColor }}">{{ $gdev < 0 ? '('.number_format(abs($gdev), 0).')' : number_format($gdev, 0) }}</td>
                        </tr>
                        <tr class="bg-amber-50/40">
                            <td class="font-bold text-amber-800">% Pencapaian</td>
                            @foreach($estates as $estate)
                                @php
                                    $r = $dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0;
                                    $b = $dataMatrix[$estate->kode]['produksi']['current']['rkb']->tonase ?? 0;
                                    $pct = $b > 0 ? ($r / $b) * 100 : 0; 
                                @endphp
                                <td class="text-right font-semibold text-amber-700">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            @php 
                                $gr = $dataMatrix['BP-2']['produksi']['current']['real']->tonase ?? 0;
                                $gb = $dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0;
                                $gpct = $gb > 0 ? ($gr / $gb) * 100 : 0; 
                            @endphp
                            <td class="text-right font-bold text-amber-800 bg-amber-100/50">{{ number_format($gpct, 2) }}</td>
                        </tr>
                        <!-- POIN 2: PERBAIKAN RUMUS DEVIASI Jjg/Pkk -->
                        <tr class="row-border-strong">
                            <td class="text-left font-bold text-rose-600">Jjg/Pkk</td>
                            @foreach($estates as $estate)
                                @php
                                    $hsPkk = $dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0;
                                    $rkbJjgPkk = $hsPkk > 0 ? ($dataMatrix[$estate->kode]['produksi']['current']['rkb']->janjang ?? 0) / $hsPkk : 0;
                                    $realJjgPkk = $hsPkk > 0 ? ($dataMatrix[$estate->kode]['produksi']['current']['real']->janjang ?? 0) / $hsPkk : 0;
                                    $devJjgPkk = $realJjgPkk - $rkbJjgPkk;
                                @endphp
                                <td class="text-right font-bold {{ $devJjgPkk < 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $devJjgPkk < 0 ? '('.number_format(abs($devJjgPkk), 2).')' : number_format($devJjgPkk, 2) }}</td>
                            @endforeach
                            @php
                                $gHsPkk = $dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0;
                                $grkbJjgPkk = $gHsPkk > 0 ? ($dataMatrix['BP-2']['produksi']['current']['rkb']->janjang ?? 0) / $gHsPkk : 0;
                                $grealJjgPkk = $gHsPkk > 0 ? ($dataMatrix['BP-2']['produksi']['current']['real']->janjang ?? 0) / $gHsPkk : 0;
                                $gdevJjgPkk = $grealJjgPkk - $grkbJjgPkk;
                            @endphp
                            <td class="text-right font-bold {{ $gdevJjgPkk < 0 ? 'text-rose-600' : 'text-emerald-600' }} bg-indigo-50/30">{{ $gdevJjgPkk < 0 ? '('.number_format(abs($gdevJjgPkk), 2).')' : number_format($gdevJjgPkk, 2) }}</td>
                        </tr>

                        <tr class="bg-emerald-50/20">
                            <td colspan="2" class="font-semibold text-emerald-800 border-r border-slate-100 pl-4">Kunjungan</td>
                            <td class=""></td>
                            @foreach($estates as $estate) <td class="text-right font-medium text-emerald-700">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->kunjungan ?? 0, 2) }}</td> @endforeach
                            <td class="text-right font-bold text-emerald-800 bg-emerald-100/40">{{ number_format($dataMatrix['BP-2']['produksi']['current']['real']->kunjungan ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="font-semibold text-slate-700 border-r border-slate-100 pl-4">Ha/Hk</td>
                            <td class=""></td>
                            @foreach($estates as $estate) <td class="text-right">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->ha_hk ?? 0, 2) }}</td> @endforeach
                            <td class="text-right font-bold bg-indigo-50/30">{{ number_format($dataMatrix['BP-2']['produksi']['current']['real']->ha_hk ?? 0, 2) }}</td>
                        </tr>
                        <tr class="row-border-strong">
                            <td colspan="2" class="font-semibold text-slate-700 border-r border-slate-100 pl-4">Kg/Hk</td>
                            <td class=""></td>
                            @foreach($estates as $estate) <td class="text-right font-medium">{{ number_format($dataMatrix[$estate->kode]['produksi']['current']['real']->kg_hk ?? 0, 0) }}</td> @endforeach
                            <td class="text-right font-bold bg-indigo-50/30">{{ number_format($dataMatrix['BP-2']['produksi']['current']['real']->kg_hk ?? 0, 0) }}</td>
                        </tr>
                        
                        <!-- POIN 3: HA CAVEL REAL & DEVIASI -->
                        <tr>
                            <td rowspan="3" class="valign-top font-semibold text-slate-700 bg-slate-50/80 border-r border-slate-100 text-center">
                                Ha Cavel / Hari<br>
                                <input type="number" value="26" class="mt-2 w-14 text-center text-sm font-bold text-slate-700 border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white shadow-sm py-1">
                            </td>
                            <td class="font-semibold text-slate-700 border-r border-slate-100 text-center">Cavel</td>
                            <td class="text-center text-slate-500">Ha</td>
                            @foreach($estates as $estate)
                                @php $cavel = ($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_ha ?? 0) / 6; @endphp
                                <td class="text-right">{{ number_format($cavel, 2) }}</td>
                            @endforeach
                            @php $gcavel = ($dataMatrix['BP-2']['produksi']['current']['real']->hs_ha ?? 0) / 6; @endphp
                            <td class="text-right font-bold bg-indigo-50/30">{{ number_format($gcavel, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-slate-700 border-r border-slate-100 text-center">Real</td>
                            <td class="text-center text-slate-500">Ha</td>
                            @foreach($estates as $estate)
                                @php $realHa = $dataMatrix[$estate->kode]['produksi']['current']['real']->ha_cavel_real ?? 0; @endphp
                                <td class="text-right font-medium text-slate-800">
                                    <!-- INPUTAN MANUAL HA CAVEL REAL -->
                                    <input type="number" step="0.01" value="{{ $realHa }}" class="w-16 text-right border border-slate-300 rounded px-1 text-sm bg-slate-50">
                                </td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30">
                                @php $gRealHa = $dataMatrix['BP-2']['produksi']['current']['real']->ha_cavel_real ?? 0; @endphp
                                {{ number_format($gRealHa, 2) }}
                            </td>
                        </tr>
                        <tr class="row-border-strong">
                            <td class="font-semibold text-rose-600 border-r border-slate-100 text-center">Dev</td>
                            <td class="text-center text-slate-500">Ha</td>
                            @foreach($estates as $estate)
                                @php
                                    $cavel = ($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_ha ?? 0) / 6;
                                    $realHa = $dataMatrix[$estate->kode]['produksi']['current']['real']->ha_cavel_real ?? 0;
                                    $devHa = $realHa - $cavel;
                                @endphp
                                <td class="text-right font-medium {{ $devHa < 0 ? 'text-rose-500 bg-rose-50/30' : 'text-emerald-500 bg-emerald-50/30' }}">
                                    {{ $devHa < 0 ? '('.number_format(abs($devHa), 2).')' : number_format($devHa, 2) }}
                                </td>
                            @endforeach
                            <td class="text-right font-bold text-rose-600 bg-rose-100/50">
                                @php
                                    $gcavel = ($dataMatrix['BP-2']['produksi']['current']['real']->hs_ha ?? 0) / 6;
                                    $gRealHa = $dataMatrix['BP-2']['produksi']['current']['real']->ha_cavel_real ?? 0;
                                    $gDevHa = $gRealHa - $gcavel;
                                @endphp
                                {{ $gDevHa < 0 ? '('.number_format(abs($gDevHa), 2).')' : number_format($gDevHa, 2) }}
                            </td>
                        </tr>

                        <!-- POIN 5: SCRIPT JS OTOMATIS & POIN 4: JJG/HA -->
                        <tr class="border-t-[3px] border-slate-300">
                            <td rowspan="6" class="valign-top font-bold text-slate-800 bg-slate-50/80 border-r border-slate-100 text-center">{{ $labelBulanNext }}</td>
                            <td class="font-bold text-indigo-700 bg-indigo-50/30 border-r border-slate-100 text-center">RKB</td>
                            <td class="font-bold text-slate-800">Produksi (Ton)</td>
                            @foreach($estates as $estate) <td class="text-right font-bold">{{ number_format(($dataMatrix[$estate->kode]['produksi']['next']['rkb']->tonase ?? 0) / 1000, 0) }}</td> @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format(($dataMatrix['BP-2']['produksi']['next']['rkb']->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-slate-600 bg-indigo-50/30 border-r border-slate-100 text-center">HKE</td>
                            <td class="font-medium text-slate-800">Janjang</td>
                            @foreach($estates as $estate) <td class="text-right font-medium">{{ number_format($dataMatrix[$estate->kode]['produksi']['next']['rkb']->janjang ?? 0, 0) }}</td> @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($dataMatrix['BP-2']['produksi']['next']['rkb']->janjang ?? 0, 0) }}</td>
                        </tr>
                        <tr>
                            <td rowspan="4" class="valign-top bg-indigo-50/30 border-r border-slate-100 text-center pt-3">
                                <!-- HKE INPUT ID DITAMBAHKAN UNTUK HITUNGAN JS -->
                                <input type="number" id="input-hke" value="24" oninput="calculateTonHari()" class="w-14 text-center text-sm font-bold text-indigo-700 border border-indigo-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white shadow-sm py-1">
                            </td>
                            <td class="font-medium text-slate-700">Bjr</td>
                            @foreach($estates as $estate)
                                @php
                                    $nT = $dataMatrix[$estate->kode]['produksi']['next']['rkb']->tonase ?? 0;
                                    $nJ = $dataMatrix[$estate->kode]['produksi']['next']['rkb']->janjang ?? 0;
                                    $nBjr = $nJ > 0 ? $nT / $nJ : 0;
                                @endphp
                                <td class="text-right text-slate-500">{{ number_format($nBjr, 2) }}</td>
                            @endforeach
                            @php
                                $gnT = $dataMatrix['BP-2']['produksi']['next']['rkb']->tonase ?? 0;
                                $gnJ = $dataMatrix['BP-2']['produksi']['next']['rkb']->janjang ?? 0;
                                $gnBjr = $gnJ > 0 ? $gnT / $gnJ : 0;
                            @endphp
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gnBjr, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="font-medium text-slate-700">Jjg/Pkk</td>
                            @foreach($estates as $estate)
                                @php
                                    $nJjg = $dataMatrix[$estate->kode]['produksi']['next']['rkb']->janjang ?? 0;
                                    $hsPokok = $dataMatrix[$estate->kode]['produksi']['current']['real']->hs_pokok ?? 0;
                                    $nJjgPkk = $hsPokok > 0 ? $nJjg / $hsPokok : 0;
                                @endphp
                                <td class="text-right text-slate-400">{{ number_format($nJjgPkk, 2) }}</td>
                            @endforeach
                            @php
                                $ghsPokok = $dataMatrix['BP-2']['produksi']['current']['real']->hs_pokok ?? 0;
                                $gnJjgPkk = $ghsPokok > 0 ? $gnJ / $ghsPokok : 0;
                            @endphp
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-400">{{ number_format($gnJjgPkk, 2) }}</td>
                        </tr>
                        
                        <!-- POIN 4: RUMUS Jjg/Ha = Janjang / (Kunjungan * Luas HS) -->
                        <tr class="bg-amber-50/40">
                            <td class="font-bold text-amber-800">Jjg/Ha</td>
                            @foreach($estates as $estate)
                                @php
                                    $nJjg = $dataMatrix[$estate->kode]['produksi']['next']['rkb']->janjang ?? 0;
                                    $kunjungan = $dataMatrix[$estate->kode]['produksi']['current']['real']->kunjungan ?? 0;
                                    $hsHa = $dataMatrix[$estate->kode]['produksi']['current']['real']->hs_ha ?? 0;
                                    $jjgHa = ($kunjungan * $hsHa) > 0 ? $nJjg / ($kunjungan * $hsHa) : 0;
                                @endphp
                                <td class="text-right font-semibold text-amber-700">{{ number_format($jjgHa, 2) }}</td>
                            @endforeach
                            @php
                                $gnJjg = $dataMatrix['BP-2']['produksi']['next']['rkb']->janjang ?? 0;
                                $gKunjungan = $dataMatrix['BP-2']['produksi']['current']['real']->kunjungan ?? 0;
                                $gHsHa = $dataMatrix['BP-2']['produksi']['current']['real']->hs_ha ?? 0;
                                $gJjgHa = ($gKunjungan * $gHsHa) > 0 ? $gnJjg / ($gKunjungan * $gHsHa) : 0;
                            @endphp
                            <td class="text-right font-bold text-amber-800 bg-amber-100/50">{{ number_format($gJjgHa, 2) }}</td>
                        </tr>
                        
                        <!-- POIN 5: RUMUS Ton/Hari DIHITUNG VIA JAVASCRIPT BERDASARKAN INPUTAN HKE -->
                        <tr class="row-border-strong">
                            <td class="font-bold text-slate-800">Ton/Hari</td>
                            @foreach($estates as $estate)
                                @php $nTon = ($dataMatrix[$estate->kode]['produksi']['next']['rkb']->tonase ?? 0) / 1000; @endphp
                                <td class="text-right font-bold text-slate-800 ton-hari-cell" data-ton="{{ $nTon }}">0</td>
                            @endforeach
                            @php $gnTon = ($dataMatrix['BP-2']['produksi']['next']['rkb']->tonase ?? 0) / 1000; @endphp
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900 ton-hari-cell" data-ton="{{ $gnTon }}">0</td>
                        </tr>

                        <!-- Poin 6: Row "Rerata Real" dan "Deviasi" yang sebelumnya ada disini sudah dihapus secara permanen -->

                        <tr>
                            <td colspan="2" class="font-semibold text-slate-700 border-r border-slate-100 pl-4">Bgt {{ $tahun }}</td>
                            <td class="text-center font-medium text-slate-500 border-r border-slate-100">Ton</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-medium">{{ number_format(($dataMatrix[$estate->kode]['histori']['bgt_1_thn']->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format(($dataMatrix['BP-2']['histori']['bgt_1_thn']->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="font-semibold text-slate-700 border-r border-slate-100 pl-4">Bgt sd {{ $namaBulanIni }} {{ $tahun }}</td>
                            <td class="text-center font-medium text-slate-500 border-r border-slate-100">Ton</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-medium">{{ number_format(($dataMatrix[$estate->kode]['histori']['bgt_sd_bln']->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format(($dataMatrix['BP-2']['histori']['bgt_sd_bln']->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        <tr class="row-border-strong">
                            <td colspan="2" class="font-semibold text-slate-700 border-r border-slate-100 pl-4">E-Sensus sd {{ $namaBulanIni }} {{ $tahun }}</td>
                            <td class="text-center font-medium text-slate-500 border-r border-slate-100">Ton</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-medium">{{ number_format(($dataMatrix[$estate->kode]['histori']['sns_sd_bln']->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format(($dataMatrix['BP-2']['histori']['sns_sd_bln']->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        
                        <tr class="bg-orange-100/70">
                            <td colspan="2" class="font-bold text-orange-800 border-r border-orange-200 pl-4">Real Sd {{ $namaBulanIni }} - {{ $tahun - 3 }}</td>
                            <td class="text-center font-bold text-orange-700 border-r border-orange-200">Ton</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-bold text-orange-900">{{ number_format(($dataMatrix[$estate->kode]['histori']['real_sd_'.($tahun-3)]->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-orange-200/50 text-orange-900">{{ number_format(($dataMatrix['BP-2']['histori']['real_sd_'.($tahun-3)]->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        <tr class="bg-emerald-100/70">
                            <td colspan="2" class="font-bold text-emerald-800 border-r border-emerald-200 pl-4">Real Sd {{ $namaBulanIni }} - {{ $tahun - 2 }}</td>
                            <td class="text-center font-bold text-emerald-700 border-r border-emerald-200">Ton</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-bold text-emerald-900">{{ number_format(($dataMatrix[$estate->kode]['histori']['real_sd_'.($tahun-2)]->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-emerald-200/50 text-emerald-900">{{ number_format(($dataMatrix['BP-2']['histori']['real_sd_'.($tahun-2)]->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        <tr class="bg-amber-100/70">
                            <td colspan="2" class="font-bold text-amber-800 border-r border-amber-200 pl-4">Real Sd {{ $namaBulanIni }} - {{ $tahun - 1 }}</td>
                            <td class="text-center font-bold text-amber-700 border-r border-amber-200">Ton</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-bold text-amber-900">{{ number_format(($dataMatrix[$estate->kode]['histori']['real_sd_'.($tahun-1)]->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-amber-200/50 text-amber-900">{{ number_format(($dataMatrix['BP-2']['histori']['real_sd_'.($tahun-1)]->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>
                        <tr class="bg-slate-100/70 row-border-strong">
                            <td colspan="2" class="font-bold text-slate-800 border-r border-slate-200 pl-4">Real Sd {{ $namaBulanIni }} - {{ $tahun }}</td>
                            <td class="text-center font-bold text-slate-700 border-r border-slate-200">Ton</td>
                            @foreach($estates as $estate) 
                                <td class="text-right font-bold text-slate-900">{{ number_format(($dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0) / 1000, 0) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-slate-200/50 text-slate-900">{{ number_format(($dataMatrix['BP-2']['histori']['real_sd_'.$tahun]->tonase ?? 0) / 1000, 0) }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="font-semibold text-slate-700 text-right border-r border-slate-100">% Bgt {{ substr($tahun, 2, 2) }}</td>
                            <td class="text-center font-medium text-slate-500 border-r border-slate-100">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $realThnIni = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                    $bgtFull = $dataMatrix[$estate->kode]['histori']['bgt_1_thn']->tonase ?? 0;
                                    $pct = $bgtFull > 0 ? ($realThnIni / $bgtFull) * 100 : 0;
                                @endphp
                                <td class="text-right font-medium text-slate-700">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">
                                @php 
                                    $gRealThnIni = $dataMatrix['BP-2']['histori']['real_sd_'.$tahun]->tonase ?? 0; 
                                    $gBgtFull = $dataMatrix['BP-2']['histori']['bgt_1_thn']->tonase ?? 0; 
                                @endphp
                                {{ number_format($gBgtFull > 0 ? ($gRealThnIni / $gBgtFull) * 100 : 0, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="font-semibold text-slate-700 text-right border-r border-slate-100">% Bgt sd {{ $namaBulanIni }} {{ substr($tahun, 2, 2) }}</td>
                            <td class="text-center font-medium text-slate-500 border-r border-slate-100">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $realThnIni = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                    $bgtSd = $dataMatrix[$estate->kode]['histori']['bgt_sd_bln']->tonase ?? 0;
                                    $pct = $bgtSd > 0 ? ($realThnIni / $bgtSd) * 100 : 0;
                                @endphp
                                <td class="text-right font-medium text-slate-700">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">
                                @php 
                                    $gRealThnIni = $dataMatrix['BP-2']['histori']['real_sd_'.$tahun]->tonase ?? 0; 
                                    $gBgtSd = $dataMatrix['BP-2']['histori']['bgt_sd_bln']->tonase ?? 0; 
                                @endphp
                                {{ number_format($gBgtSd > 0 ? ($gRealThnIni / $gBgtSd) * 100 : 0, 2) }}
                            </td>
                        </tr>
                        <tr class="row-border-strong">
                            <td colspan="2" class="font-semibold text-slate-700 text-right border-r border-slate-100">% E-Sns sd {{ $namaBulanIni }} {{ substr($tahun, 2, 2) }}</td>
                            <td class="text-center font-medium text-slate-500 border-r border-slate-100">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $realThnIni = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                    $snsSd = $dataMatrix[$estate->kode]['histori']['sns_sd_bln']->tonase ?? 0;
                                    $pct = $snsSd > 0 ? ($realThnIni / $snsSd) * 100 : 0;
                                @endphp
                                <td class="text-right font-medium text-slate-700">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">
                                @php 
                                    $gRealThnIni = $dataMatrix['BP-2']['histori']['real_sd_'.$tahun]->tonase ?? 0; 
                                    $gSnsSd = $dataMatrix['BP-2']['histori']['sns_sd_bln']->tonase ?? 0; 
                                @endphp
                                {{ number_format($gSnsSd > 0 ? ($gRealThnIni / $gSnsSd) * 100 : 0, 2) }}
                            </td>
                        </tr>
                        
                        <tr class="bg-emerald-100/60">
                            <td colspan="2" class="font-bold text-emerald-800 text-right border-r border-emerald-200">% R-{{ substr($tahun-1, 2, 2) }}</td>
                            <td class="text-center font-bold text-emerald-700 border-r border-emerald-200">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $realThnIni = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                    $rPrev = $dataMatrix[$estate->kode]['histori']['real_sd_'.($tahun-1)]->tonase ?? 0;
                                    $pct = $rPrev > 0 ? ($realThnIni / $rPrev) * 100 : 0;
                                @endphp
                                <td class="text-right font-bold text-emerald-900">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-emerald-200/50 text-emerald-900">
                                @php 
                                    $gRealThnIni = $dataMatrix['BP-2']['histori']['real_sd_'.$tahun]->tonase ?? 0; 
                                    $gRPrev = $dataMatrix['BP-2']['histori']['real_sd_'.($tahun-1)]->tonase ?? 0; 
                                @endphp
                                {{ number_format($gRPrev > 0 ? ($gRealThnIni / $gRPrev) * 100 : 0, 2) }}
                            </td>
                        </tr>
                        <tr class="bg-emerald-100/60 row-border-strong">
                            <td colspan="2" class="font-bold text-emerald-800 text-right border-r border-emerald-200">% R-{{ substr($tahun-2, 2, 2) }}</td>
                            <td class="text-center font-bold text-emerald-700 border-r border-emerald-200">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $realThnIni = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                    $rPrev2 = $dataMatrix[$estate->kode]['histori']['real_sd_'.($tahun-2)]->tonase ?? 0;
                                    $pct = $rPrev2 > 0 ? ($realThnIni / $rPrev2) * 100 : 0;
                                @endphp
                                <td class="text-right font-bold text-emerald-900">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-emerald-200/50 text-emerald-900">
                                @php 
                                    $gRealThnIni = $dataMatrix['BP-2']['histori']['real_sd_'.$tahun]->tonase ?? 0; 
                                    $gRPrev2 = $dataMatrix['BP-2']['histori']['real_sd_'.($tahun-2)]->tonase ?? 0; 
                                @endphp
                                {{ number_format($gRPrev2 > 0 ? ($gRealThnIni / $gRPrev2) * 100 : 0, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- TABLE 2: EKSTRAKSI & MILL -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
                <table class="modern-matrix text-sm text-center align-middle" style="white-space: nowrap;">
                    <thead class="bg-slate-50 border-b-2 border-slate-200">
                        <tr>
                            <th rowspan="2" colspan="2" class="text-left font-bold text-slate-600 uppercase tracking-wider pl-4 align-middle">DATA EKSTRAKSI & MILL</th>
                            @foreach($estates as $estate)
                                <th colspan="2" class="text-center font-bold text-slate-700 border-l border-slate-200">{{ $estate->kode }}</th>
                            @endforeach
                            <th colspan="2" class="text-center font-bold text-indigo-800 bg-indigo-50 border-l border-indigo-100">TOTAL BP-2</th>
                        </tr>
                        <tr>
                            @foreach($estates as $estate)
                                <th class="text-center font-medium text-slate-500 border-l border-slate-200 text-xs">Bulan Ini</th>
                                <th class="text-center font-medium text-slate-500 text-xs">s.d Bulan Ini</th>
                            @endforeach
                            <th class="text-center font-medium text-indigo-600 bg-indigo-50 border-l border-indigo-100 text-xs">Bulan Ini</th>
                            <th class="text-center font-medium text-indigo-600 bg-indigo-50 text-xs">s.d Bulan Ini</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="font-bold text-slate-800 text-left pl-4 w-32 border-r border-slate-100">Kg Tbs</td>
                            <td class="text-center font-medium text-slate-400 w-12">Kg</td>
                            @foreach($estates as $estate)
                                <td class="text-right font-bold text-slate-800 border-l border-slate-100">{{ number_format($millBi[$estate->kode]['kgTbsBi'], 0) }}</td>
                                <td class="text-right font-bold text-slate-800">{{ number_format($millSd[$estate->kode]['kgTbsSd'], 0) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900 border-l border-indigo-50/50">{{ number_format($gTbsBi, 0) }}</td>
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gTbsSd, 0) }}</td>
                        </tr>

                        <tr class="bg-yellow-50/80 hover:bg-yellow-50 transition-colors">
                            <td class="font-bold text-yellow-800 text-left pl-4 border-r border-yellow-100">OER</td>
                            <td class="text-center font-medium text-yellow-600">%</td>
                            @foreach($estates as $estate)
                                <td class="text-right font-bold text-yellow-900 border-l border-yellow-200/50">{{ number_format($millBi[$estate->kode]['oerBi'], 2) }}%</td>
                                <td class="text-right font-bold text-yellow-900">{{ number_format($millSd[$estate->kode]['oerSd'], 2) }}%</td>
                            @endforeach
                            <td class="text-right font-bold bg-yellow-100/80 text-yellow-900 border-l border-yellow-200/50">{{ number_format($gOerBi, 2) }}%</td>
                            <td class="text-right font-bold bg-yellow-100/80 text-yellow-900">{{ number_format($gOerSd, 2) }}%</td>
                        </tr>

                        <tr class="bg-yellow-50/80 hover:bg-yellow-50 transition-colors row-border-strong border-b border-yellow-200">
                            <td class="font-bold text-yellow-800 text-left pl-4 border-r border-yellow-100">KER</td>
                            <td class="text-center font-medium text-yellow-600">%</td>
                            @foreach($estates as $estate)
                                <td class="text-right font-bold text-yellow-900 border-l border-yellow-200/50">{{ number_format($millBi[$estate->kode]['kerBi'], 2) }}%</td>
                                <td class="text-right font-bold text-yellow-900">{{ number_format($millSd[$estate->kode]['kerSd'], 2) }}%</td>
                            @endforeach
                            <td class="text-right font-bold bg-yellow-100/80 text-yellow-900 border-l border-yellow-200/50">{{ number_format($gPctKerBi, 2) }}%</td>
                            <td class="text-right font-bold bg-yellow-100/80 text-yellow-900">{{ number_format($gPctKerSd, 2) }}%</td>
                        </tr>

                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="font-medium text-slate-700 text-left pl-4 border-r border-slate-100">Ton CPO</td>
                            <td class="text-center font-medium text-slate-400">Ton</td>
                            @foreach($estates as $estate)
                                <td class="text-right border-l border-slate-100">{{ number_format($millBi[$estate->kode]['tonCpoBi'], 0) }}</td>
                                <td class="text-right">{{ number_format($millSd[$estate->kode]['tonCpoSd'], 0) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900 border-l border-indigo-50/50">{{ number_format($gCpoBi, 0) }}</td>
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gCpoSd, 0) }}</td>
                        </tr>

                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="font-medium text-slate-700 text-left pl-4 border-r border-slate-100">Ton KER</td>
                            <td class="text-center font-medium text-slate-400">Ton</td>
                            @foreach($estates as $estate)
                                <td class="text-right border-l border-slate-100">{{ number_format($millBi[$estate->kode]['tonKerBi'], 0) }}</td>
                                <td class="text-right">{{ number_format($millSd[$estate->kode]['tonKerSd'], 0) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900 border-l border-indigo-50/50">{{ number_format($gKerBi, 0) }}</td>
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gKerSd, 0) }}</td>
                        </tr>

                        <tr class="bg-orange-50/50 hover:bg-orange-50 transition-colors row-border-strong">
                            <td class="font-bold text-orange-900 text-left pl-4 border-r border-orange-100">Ton Palm Produk</td>
                            <td class="text-center font-bold text-orange-600">Ton</td>
                            @foreach($estates as $estate)
                                <td class="text-right font-bold text-orange-800 border-l border-orange-200/50">{{ number_format($millBi[$estate->kode]['tonPalmProdukBi'], 0) }}</td>
                                <td class="text-right font-bold text-orange-800">{{ number_format($millSd[$estate->kode]['tonPalmProdukSd'], 0) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-orange-100/60 text-orange-900 border-l border-orange-200/50">{{ number_format($gPalmProdukBi, 0) }}</td>
                            <td class="text-right font-bold bg-orange-100/60 text-orange-900">{{ number_format($gPalmProdukSd, 0) }}</td>
                        </tr>

                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="font-medium text-slate-700 text-left pl-4 border-r border-slate-100">PKO</td>
                            <td class="text-center font-medium text-slate-400">%</td>
                            @foreach($estates as $estate)
                                <td class="text-right border-l border-slate-100">{{ number_format($millBi[$estate->kode]['pkoBi'], 2) }}%</td>
                                <td class="text-right">{{ number_format($millSd[$estate->kode]['pkoSd'], 2) }}%</td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900 border-l border-indigo-50/50">{{ number_format($gPctPkoBi, 2) }}%</td>
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gPctPkoSd, 2) }}%</td>
                        </tr>

                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="font-medium text-slate-700 text-left pl-4 border-r border-slate-100">Ton PKO</td>
                            <td class="text-center font-medium text-slate-400">Ton</td>
                            @foreach($estates as $estate)
                                <td class="text-right border-l border-slate-100">{{ number_format($millBi[$estate->kode]['tonPkoBi'], 0) }}</td>
                                <td class="text-right">{{ number_format($millSd[$estate->kode]['tonPkoSd'], 0) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900 border-l border-indigo-50/50">{{ number_format($gPkoBi, 0) }}</td>
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gPkoSd, 0) }}</td>
                        </tr>

                        <tr class="bg-emerald-100/50 hover:bg-emerald-100 transition-colors row-border-strong">
                            <td class="font-bold text-emerald-900 text-left pl-4 border-r border-emerald-200">Ton Palm Oil</td>
                            <td class="text-center font-bold text-emerald-600">Ton</td>
                            @foreach($estates as $estate)
                                <td class="text-right font-bold text-emerald-800 border-l border-emerald-200/50">{{ number_format($millBi[$estate->kode]['tonPalmOilBi'], 0) }}</td>
                                <td class="text-right font-bold text-emerald-800">{{ number_format($millSd[$estate->kode]['tonPalmOilSd'], 0) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-emerald-200/60 text-emerald-900 border-l border-emerald-300/50">{{ number_format($gPalmOilBi, 0) }}</td>
                            <td class="text-right font-bold bg-emerald-200/60 text-emerald-900">{{ number_format($gPalmOilSd, 0) }}</td>
                        </tr>

                        <tr class="bg-emerald-500 text-white">
                            <td class="font-bold text-left pl-4 border-r border-emerald-400">Ton/Ha CPO</td>
                            <td class="text-center font-bold border-r border-emerald-400">Ton/Ha</td>
                            @foreach($estates as $estate)
                                <td class="text-right font-bold border-l border-emerald-400">{{ number_format($millBi[$estate->kode]['tonHaCpoBi'], 2) }}</td>
                                <td class="text-right font-bold">{{ number_format($millSd[$estate->kode]['tonHaCpoSd'], 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-emerald-600 border-l border-emerald-700">{{ number_format($gTonHaCpoBi, 2) }}</td>
                            <td class="text-right font-bold bg-emerald-600">{{ number_format($gTonHaCpoSd, 2) }}</td>
                        </tr>

                        <tr class="bg-emerald-700 text-white shadow-inner">
                            <td class="font-bold text-left pl-4 border-r border-emerald-600">Ton/Ha Palm Oil</td>
                            <td class="text-center font-bold border-r border-emerald-600">Ton/Ha</td>
                            @foreach($estates as $estate)
                                <td class="text-right font-bold border-l border-emerald-600">{{ number_format($millBi[$estate->kode]['tonHaPalmOilBi'], 2) }}</td>
                                <td class="text-right font-bold">{{ number_format($millSd[$estate->kode]['tonHaPalmOilSd'], 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-emerald-800 border-l border-emerald-900">{{ number_format($gTonHaPalmOilBi, 2) }}</td>
                            <td class="text-right font-bold bg-emerald-800">{{ number_format($gTonHaPalmOilSd, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- POIN 7: TABLE BIAYA PDO & TOTAL -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
                <table class="modern-matrix text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-left font-bold text-emerald-800 bg-emerald-50 border-b-2 border-emerald-200 uppercase tracking-wider pl-4">BIAYA PDO & TOTAL (Rp 000)</th>
                            @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-yellow-300 uppercase tracking-wider">{{ $estate->kode }}</th> @endforeach
                            <th class="text-center font-bold text-slate-800 bg-yellow-400 uppercase tracking-wider shadow-sm">BP-2</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600 font-bold">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td rowspan="2" class="text-left py-2 px-3 border-r border-slate-200 bg-white sticky left-0 z-10 w-24">PDO</td>
                            <td class="text-center py-2 px-3 text-slate-600 border-r border-slate-200 bg-white sticky left-[96px] z-10 w-16 italic">Bi</td>
                            @foreach($estates as $estate)
                                <td class="text-right py-2 px-4">
                                    <input type="number" class="w-full text-right border border-slate-300 rounded px-1 font-medium bg-slate-50" value="{{ $dataMatrix[$estate->kode]['biaya_pdo']['bi'] ?? 0 }}">
                                </td>
                            @endforeach
                            <td class="text-right py-2 px-4 bg-slate-50 font-bold">0</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors row-border-strong border-b-2 border-slate-300">
                            <td class="text-center py-2 px-3 text-slate-600 border-r border-slate-200 bg-white sticky left-[96px] z-10 italic">Sbi</td>
                            @foreach($estates as $estate)
                                <td class="text-right py-2 px-4">
                                    <input type="number" class="w-full text-right border border-slate-300 rounded px-1 font-medium bg-slate-50" value="{{ $dataMatrix[$estate->kode]['biaya_pdo']['sbi'] ?? 0 }}">
                                </td>
                            @endforeach
                            <td class="text-right py-2 px-4 bg-slate-50 font-bold">0</td>
                        </tr>
                    </tbody>
                    <tbody class="text-slate-600">
                        @php $komponenBiaya = ['Panen' => 'cost_panen', 'Rawat' => 'cost_rawat', 'Kantor' => 'cost_kantor', 'Teknik' => 'cost_teknik', 'PKS' => 'cost_pks']; @endphp
                        @foreach($komponenBiaya as $label => $field)
                        <tr>
                            <td colspan="2" class="font-semibold text-slate-700 pl-4 border-r border-slate-200">Total {{ $label }} (M)</td>
                            @foreach($estates as $estate) 
                                <td class="text-right">{{ number_format(($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->$field ?? 0) / 1000000, 2) }}</td> 
                            @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format(($dataMatrix['BP-2']['biaya_sd_bln']['real']->$field ?? 0) / 1000000, 2) }}</td>
                        </tr>
                        @endforeach
                        
                        <tr class="bg-amber-50/50 row-border-strong border-b-2 border-amber-200">
                            <td class="font-bold text-amber-900 pl-4 border-r border-amber-200">TOTAL By Operasional (M)</td>
                            <td class="text-center font-bold text-amber-700 w-16 border-r border-amber-200">M</td>
                            @php $gTBiaya = 0; @endphp
                            @foreach($estates as $estate)
                                @php 
                                    $tBiaya = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0);
                                    $gTBiaya += $tBiaya;
                                @endphp
                                <td class="text-right font-bold text-amber-800">{{ number_format($tBiaya / 1000000, 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-amber-200/40 text-amber-900">{{ number_format($gTBiaya / 1000000, 2) }}</td>
                        </tr>
                        
                        <tr class="bg-emerald-50/50 row-border-strong border-b-2 border-emerald-200">
                            <td class="font-bold text-emerald-900 pl-4 border-r border-emerald-200">COST / KG TBS (S.D BLN INI)</td>
                            <td class="text-center font-bold text-emerald-700 border-r border-emerald-200">Rp</td>
                            @foreach($estates as $estate)
                                @php
                                    $tBiayaSd = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0);
                                    $realKgSd = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                    $costPerKg = $realKgSd > 0 ? $tBiayaSd / $realKgSd : 0;
                                @endphp
                                <td class="text-right font-bold text-emerald-800">{{ number_format($costPerKg, 2) }}</td>
                            @endforeach
                            <td class="text-right font-bold bg-emerald-200/40 text-emerald-900">{{ number_format($gCostPerKgSd, 2) }}</td>
                        </tr>

                        <tr class="bg-slate-200/60 font-bold text-slate-800">
                            <td class="pl-4 border-r border-slate-300">COST Palm Produk</td>
                            <td class="text-center italic border-r border-slate-300">Real sd {{ $namaBulanIni }}</td>
                            @foreach($estates as $estate)
                                <td class="text-right border-slate-300">{{ number_format($biayaStats[$estate->kode]['costPalmProdukReal'], 0) }}</td>
                            @endforeach
                            <td class="text-right bg-slate-300/50">{{ number_format($gCostPalmProdukReal, 0) }}</td>
                        </tr>

                        <tr class="bg-emerald-200/50 font-bold text-emerald-900 row-border-strong border-b-2 border-emerald-300">
                            <td class="pl-4 border-r border-emerald-300">COST Palm Oil</td>
                            <td class="text-center italic border-r border-emerald-300">Real sd {{ $namaBulanIni }}</td>
                            @foreach($estates as $estate)
                                <td class="text-right border-emerald-300">{{ number_format($biayaStats[$estate->kode]['costPalmOilReal'], 0) }}</td>
                            @endforeach
                            <td class="text-right bg-emerald-300/40">{{ number_format($gCostPalmOilReal, 0) }}</td>
                        </tr>

                        <tr class="bg-slate-700 text-white font-bold">
                            <td class="pl-4 border-r border-slate-600">COST Palm Prod Budget {{ $tahun }}</td>
                            <td class="text-center border-r border-slate-600">Rp/Kg</td>
                            @foreach($estates as $estate)
                                <td class="text-right border-slate-600">{{ number_format($biayaStats[$estate->kode]['costPalmProdukBgt'], 0) }}</td>
                            @endforeach
                            <td class="text-right bg-slate-800">{{ number_format($gCostPalmProdukBgt, 0) }}</td>
                        </tr>
                        <tr class="bg-slate-600 text-white font-bold">
                            <td class="pl-12 text-right pr-4 border-r border-slate-500">Deviasi</td>
                            <td class="text-center border-r border-slate-500">Rp/Kg</td>
                            @foreach($estates as $estate)
                                @php $d = $biayaStats[$estate->kode]['devProdRpKg']; @endphp
                                <td class="text-right border-slate-500">{{ $d < 0 ? '('.number_format(abs($d), 0).')' : number_format($d, 0) }}</td>
                            @endforeach
                            @php $gd = $gDevProdRpKg; @endphp
                            <td class="text-right bg-slate-700">{{ $gd < 0 ? '('.number_format(abs($gd), 0).')' : number_format($gd, 0) }}</td>
                        </tr>
                        <tr class="text-white font-bold">
                            <td class="pl-12 text-right pr-4 border-r border-white/20 bg-slate-800">+/-</td>
                            <td class="text-center border-r border-white/20 bg-slate-800">Rp</td>
                            @foreach($estates as $estate)
                                @php $rp = $biayaStats[$estate->kode]['devProdRp']; @endphp
                                <td class="text-right border-white/20 {{ $rp < 0 ? 'bg-red-600' : 'bg-emerald-600' }}">{{ $rp < 0 ? '('.number_format(abs($rp), 0).')' : number_format($rp, 0) }}</td>
                            @endforeach
                            @php $grp = $gDevProdRp; @endphp
                            <td class="text-right border-white/20 {{ $grp < 0 ? 'bg-red-700' : 'bg-emerald-700' }}">{{ $grp < 0 ? '('.number_format(abs($grp), 0).')' : number_format($grp, 0) }}</td>
                        </tr>

                        <tr class="bg-emerald-700 text-white font-bold">
                            <td class="pl-4 border-r border-emerald-600">COST Palm Oil Budget {{ $tahun }}</td>
                            <td class="text-center border-r border-emerald-600">Rp/Kg</td>
                            @foreach($estates as $estate)
                                <td class="text-right border-emerald-600">{{ number_format($biayaStats[$estate->kode]['costPalmOilBgt'], 0) }}</td>
                            @endforeach
                            <td class="text-right bg-emerald-800">{{ number_format($gCostPalmOilBgt, 0) }}</td>
                        </tr>
                        <tr class="bg-emerald-600 text-white font-bold">
                            <td class="pl-12 text-right pr-4 border-r border-emerald-500">Deviasi</td>
                            <td class="text-center border-r border-emerald-500">Rp/Kg</td>
                            @foreach($estates as $estate)
                                @php $d = $biayaStats[$estate->kode]['devOilRpKg']; @endphp
                                <td class="text-right border-emerald-500">{{ $d < 0 ? '('.number_format(abs($d), 0).')' : number_format($d, 0) }}</td>
                            @endforeach
                            @php $gd = $gDevOilRpKg; @endphp
                            <td class="text-right bg-emerald-700">{{ $gd < 0 ? '('.number_format(abs($gd), 0).')' : number_format($gd, 0) }}</td>
                        </tr>
                        <tr class="text-white font-bold border-b-4 border-emerald-900">
                            <td class="pl-12 text-right pr-4 border-r border-white/20 bg-emerald-800">+/-</td>
                            <td class="text-center border-r border-white/20 bg-emerald-800">Rp</td>
                            @foreach($estates as $estate)
                                @php $rp = $biayaStats[$estate->kode]['devOilRp']; @endphp
                                <td class="text-right border-white/20 {{ $rp < 0 ? 'bg-red-600' : 'bg-emerald-600' }}">{{ $rp < 0 ? '('.number_format(abs($rp), 0).')' : number_format($rp, 0) }}</td>
                            @endforeach
                            @php $grp = $gDevOilRp; @endphp
                            <td class="text-right border-white/20 {{ $grp < 0 ? 'bg-red-700' : 'bg-emerald-700' }}">{{ $grp < 0 ? '('.number_format(abs($grp), 0).')' : number_format($grp, 0) }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= TAB 2: RAWAT & PUPUK ================= -->
        <div id="tab-agronomi" class="tab-content hidden min-w-[900px]">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <table class="modern-matrix text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-left text-slate-400 font-medium">Realisasi Rawat & Pemupukan</th>
                            @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase tracking-wider">{{ $estate->kode }}</th> @endforeach
                            <th class="text-center font-bold text-indigo-800 bg-indigo-50 uppercase tracking-wider shadow-sm">BP-2</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        <tr><td colspan="{{ count($estates) + 3 }}" class="font-bold text-slate-700 bg-slate-100 uppercase tracking-wider border-y-2 border-slate-200">Perawatan Kebun (Ha)</td></tr>
                        @foreach($jenisPerawatan as $rawat)
                        <tr class="bg-slate-50/30 hover:bg-slate-50 transition-colors">
                            <td class="font-bold text-slate-800 pl-4">{{ $rawat }} (Real)</td>
                            <td class="text-center font-medium text-slate-500 w-16">Ha</td>
                            @foreach($estates as $estate) <td class="text-right font-bold text-slate-900">{{ number_format($dataMatrix[$estate->kode]['upkeep']['real'][$rawat]->luas_ha ?? 0, 2) }}</td> @endforeach
                            @php $gRawat = 0; foreach($estates as $estate){ $gRawat += $dataMatrix[$estate->kode]['upkeep']['real'][$rawat]->luas_ha ?? 0; } @endphp
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gRawat, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- POIN 4 & 5: TABLE ROTASI PRUNING -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <table class="modern-matrix text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-left font-bold text-slate-800 uppercase tracking-wider bg-slate-50">Rotasi Pruning</th>
                            <th class="text-center font-bold text-emerald-900 bg-emerald-400 uppercase"><= 6 Bln</th>
                            <th class="text-center font-bold text-emerald-900 bg-emerald-300 uppercase">6.01-9 Bln</th>
                            <th class="text-center font-bold text-yellow-900 bg-yellow-300 uppercase">9.01-12 Bln</th>
                            <th class="text-center font-bold text-white bg-red-600 uppercase">> 12 Bln</th>
                            <th class="text-center font-bold text-slate-800 bg-slate-200 uppercase">G.Ttl</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-800 font-bold">
                        @foreach($estates as $estate)
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td rowspan="2" class="text-center align-middle border-r border-slate-200 w-24">{{ $estate->kode }}</td>
                            <td class="text-left border-r border-slate-200 w-24">Blok</td>
                            @php $bTtl = 0; $lTtl = 0; @endphp
                            @foreach($kategoriPruning as $kp)
                                @php $b = $dataMatrix[$estate->kode]['rotasi_pruning'][$kp]->jml_blok ?? 0; $bTtl += $b; @endphp
                                <td class="text-center">{{ number_format($b, 0) }}</td>
                            @endforeach
                            <td class="text-center bg-slate-100">{{ number_format($bTtl, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 row-border-strong border-b-2 border-slate-300">
                            <td class="text-left border-r border-slate-200 w-24">Luas</td>
                            @foreach($kategoriPruning as $kp)
                                @php $l = $dataMatrix[$estate->kode]['rotasi_pruning'][$kp]->luas_ha ?? 0; $lTtl += $l; @endphp
                                <td class="text-center">{{ number_format($l, 2) }}</td>
                            @endforeach
                            <td class="text-center bg-slate-100">{{ number_format($lTtl, 2) }}</td>
                        </tr>
                        @endforeach
                        
                        <!-- BARIS BP-2 -->
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed bg-slate-50/50">
                            <td rowspan="2" class="text-center align-middle border-r border-slate-200 w-24">BP-2</td>
                            <td class="text-left border-r border-slate-200 w-24">Blok</td>
                            @php $gBTtl = 0; $gLTtl = 0; @endphp
                            @foreach($kategoriPruning as $kp)
                                @php $b = $dataMatrix['BP-2']['rotasi_pruning'][$kp]->jml_blok ?? 0; $gBTtl += $b; @endphp
                                <td class="text-center">{{ number_format($b, 0) }}</td>
                            @endforeach
                            <td class="text-center bg-slate-200">{{ number_format($gBTtl, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 row-border-strong border-b-2 border-slate-300 bg-slate-50/50">
                            <td class="text-left border-r border-slate-200 w-24">Luas</td>
                            @foreach($kategoriPruning as $kp)
                                @php $l = $dataMatrix['BP-2']['rotasi_pruning'][$kp]->luas_ha ?? 0; $gLTtl += $l; @endphp
                                <td class="text-center">{{ number_format($l, 2) }}</td>
                            @endforeach
                            <td class="text-center bg-slate-200">{{ number_format($gLTtl, 2) }}</td>
                        </tr>
                        
                        <!-- SUMMARY KANAN BAWAH -->
                        @php
                            $gt9BlnBlok = ($dataMatrix['BP-2']['rotasi_pruning']['Pruning 9.01-12 Bln']->jml_blok ?? 0) + ($dataMatrix['BP-2']['rotasi_pruning']['Pruning > 12 Bln']->jml_blok ?? 0);
                            $gt9BlnLuas = ($dataMatrix['BP-2']['rotasi_pruning']['Pruning 9.01-12 Bln']->luas_ha ?? 0) + ($dataMatrix['BP-2']['rotasi_pruning']['Pruning > 12 Bln']->luas_ha ?? 0);
                        @endphp
                        <tr>
                            <td colspan="4" class="border-0 bg-white"></td>
                            <td colspan="3" class="bg-yellow-300 text-yellow-900 border-0 text-right pr-4 py-2">
                                <div class="flex justify-between items-center w-full">
                                    <span>> 9Bln</span>
                                    <span class="text-lg">{{ number_format($gt9BlnBlok, 0) }} Blok</span>
                                </div>
                                <div class="text-lg">{{ number_format($gt9BlnLuas, 2) }} Ha</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- POIN 6: TABLE RKB PUPUK -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <table class="modern-matrix text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-left font-bold text-slate-800 uppercase tracking-wider bg-slate-50">RKB Pupuk Per<br>{{ $namaBulanIni }} {{ $tahun }}</th>
                            <th class="text-center font-medium text-slate-500 bg-slate-50">Sat</th>
                            @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase">{{ $estate->kode }}</th> @endforeach
                            <th class="text-center font-bold text-slate-800 bg-slate-200 uppercase">BP-2</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-800 font-bold">
                        @foreach($jenisPupuk as $pupuk)
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td colspan="2" class="text-left border-r border-slate-200">{{ $pupuk }}</td>
                            <td class="text-center border-r border-slate-200">Ton</td>
                            @foreach($estates as $estate) <td class="text-right">{{ number_format($dataMatrix[$estate->kode]['pupuk']['budget'][$pupuk]->jumlah_kg ?? 0, 0) }}</td> @endforeach
                            @php $gPpk = 0; foreach($estates as $estate){ $gPpk += $dataMatrix[$estate->kode]['pupuk']['budget'][$pupuk]->jumlah_kg ?? 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gPpk, 0) }}</td>
                        </tr>
                        @endforeach
                        
                        <tr class="bg-yellow-300 text-yellow-900 border-y-2 border-yellow-500">
                            <td colspan="2" class="text-left border-r border-yellow-400">Total Pupuk</td>
                            <td class="text-center border-r border-yellow-400">Ton</td>
                            @foreach($estates as $estate)
                                @php $tPpk = 0; foreach($jenisPupuk as $ppk){ $tPpk += $dataMatrix[$estate->kode]['pupuk']['budget'][$ppk]->jumlah_kg ?? 0; } @endphp
                                <td class="text-right">{{ number_format($tPpk, 0) }}</td>
                            @endforeach
                            @php $gTppk = 0; foreach($estates as $estate){ foreach($jenisPupuk as $ppk){ $gTppk += $dataMatrix[$estate->kode]['pupuk']['budget'][$ppk]->jumlah_kg ?? 0; } } @endphp
                            <td class="text-right bg-yellow-400">{{ number_format($gTppk, 0) }}</td>
                        </tr>

                        <tr class="bg-emerald-300 text-emerald-900 border-b border-emerald-400 border-dashed">
                            <td colspan="2" class="text-left border-r border-emerald-400">HKE</td>
                            <td class="text-center border-r border-emerald-400">Hari</td>
                            @foreach($estates as $estate) <td class="text-center">20</td> @endforeach
                            <td class="text-center bg-emerald-400">20</td>
                        </tr>
                        <tr class="bg-emerald-300 text-emerald-900 row-border-strong border-b-4 border-emerald-500">
                            <td colspan="2" class="text-left border-r border-emerald-400"></td>
                            <td class="text-center border-r border-emerald-400">Ton/Hari</td>
                            @foreach($estates as $estate)
                                @php $tPpk = 0; foreach($jenisPupuk as $ppk){ $tPpk += $dataMatrix[$estate->kode]['pupuk']['budget'][$ppk]->jumlah_kg ?? 0; } @endphp
                                <td class="text-right">{{ number_format($tPpk / 20, 0) }}</td>
                            @endforeach
                            <td class="text-right bg-emerald-400">{{ number_format($gTppk / 20, 0) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ================= TAB 4: KUALITAS BUAH ================= -->
        <div id="tab-kualitas" class="tab-content hidden min-w-[900px] space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                <table class="modern-matrix text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-left text-slate-400 font-medium">Kinerja Mutu Ancak (% Real vs Target)</th>
                            @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase tracking-wider">{{ $estate->kode }}</th> @endforeach
                            <th class="text-center font-bold text-indigo-800 bg-indigo-50 uppercase tracking-wider shadow-sm">BP-2</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        @foreach($kriteriaMutu as $mutu)
                        <tr class="bg-slate-50/30">
                            <td colspan="2" class="font-bold text-slate-800 pl-4">{{ $mutu }} (% Target)</td>
                            @foreach($estates as $estate) <td class="text-right font-medium text-slate-500">{{ number_format($dataMatrix[$estate->kode]['kualitas']['rkb'][$mutu]->persentase ?? 0, 2) }}</td> @endforeach
                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">0.00</td>
                        </tr>
                        <tr class="row-border-strong">
                            <td colspan="2" class="font-bold text-emerald-700 pl-4">{{ $mutu }} (% Real)</td>
                            @foreach($estates as $estate) <td class="text-right font-bold text-slate-900">{{ number_format($dataMatrix[$estate->kode]['kualitas']['real'][$mutu]->persentase ?? 0, 2) }}</td> @endforeach
                            <td class="text-right font-bold bg-emerald-100/50 text-emerald-800">0.00</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= TAB 5: PERFORMANCE TK ================= -->
        <div id="tab-performance" class="tab-content hidden min-w-[900px] space-y-6">
            
            <!-- POIN 7: TABLE HKNE KARYAWAN & KELAS PEMANEN -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
                <table class="modern-matrix text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-left font-bold text-slate-800 bg-slate-50 border-r border-slate-200 uppercase">Perihal</th>
                            <th class="text-center font-bold text-slate-500 bg-slate-50 border-r border-slate-200">Sat</th>
                            @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase tracking-wider">{{ $estate->kode }}</th> @endforeach
                            <th class="text-center font-bold text-slate-800 bg-slate-200 uppercase shadow-sm">BP-2</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-800 font-bold">
                        
                        <!-- BAGIAN HKNE KARYAWAN -->
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td rowspan="6" class="text-center align-middle border-r border-slate-200 w-32 bg-white">HKNE Kary PANEN<br><span class="text-xs text-slate-500 font-normal">HKE: 24</span></td>
                            <td class="text-left border-r border-slate-200 w-24">Sakit</td>
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">Hk</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Sakit')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gv = 0; foreach($estates as $estate){ $gv += isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Sakit')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gv, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td class="text-left border-r border-slate-200 w-24">Cuti</td>
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">Hk</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Cuti')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gv = 0; foreach($estates as $estate){ $gv += isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Cuti')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gv, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td class="text-left border-r border-slate-200 w-24">Mangkir</td>
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">Hk</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Mangkir')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gv = 0; foreach($estates as $estate){ $gv += isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Mangkir')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gv, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td class="text-left border-r border-slate-200 w-24">Ijin</td>
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">Hk</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Ijin')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gv = 0; foreach($estates as $estate){ $gv += isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Ijin')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gv, 0) }}</td>
                        </tr>
                        <tr class="bg-emerald-100/50 border-y border-emerald-300">
                            <td class="text-left border-r border-emerald-200 w-24">Total</td>
                            <td class="text-center border-r border-emerald-200 text-slate-500 font-medium">Hk</td>
                            @foreach($estates as $estate)
                                @php $tHk = 0; if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { foreach($dataMatrix[$estate->kode]['pekerja']['HKNE'] as $p) $tHk+=$p->jumlah_tk; } @endphp
                                <td class="text-right text-emerald-800">{{ number_format($tHk, 0) }}</td>
                            @endforeach
                            @php $gHk = 0; foreach($estates as $estate){ if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { foreach($dataMatrix[$estate->kode]['pekerja']['HKNE'] as $p) $gHk+=$p->jumlah_tk; } } @endphp
                            <td class="text-right bg-emerald-200 text-emerald-900">{{ number_format($gHk, 0) }}</td>
                        </tr>
                        <tr class="bg-slate-50/50 border-b-2 border-slate-300">
                            <td class="text-left border-r border-slate-200 w-24">%</td>
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium"></td>
                            @foreach($estates as $estate) <td class="text-right text-slate-600 font-medium">0.00</td> @endforeach
                            <td class="text-right bg-slate-100 text-slate-700 font-medium">0.00</td>
                        </tr>
                        <tr class="bg-yellow-300 text-yellow-900 border-b-4 border-yellow-500">
                            <td colspan="2" class="text-left border-r border-yellow-400">Rata2 Hkne/hari</td>
                            <td class="text-center border-r border-yellow-400 font-medium">Hk</td>
                            @foreach($estates as $estate)
                                @php $tHk = 0; if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { foreach($dataMatrix[$estate->kode]['pekerja']['HKNE'] as $p) $tHk+=$p->jumlah_tk; } @endphp
                                <td class="text-right">{{ number_format($tHk / 24, 0) }}</td>
                            @endforeach
                            <td class="text-right bg-yellow-400">{{ number_format($gHk / 24, 0) }}</td>
                        </tr>

                        <!-- BAGIAN JAM KERJA -->
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td rowspan="6" class="text-center align-middle border-r border-slate-200 w-32 bg-white">Jam Kerja</td>
                            <td class="text-left border-r border-slate-200 w-24">Tersedia</td>
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">Tk</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Tersedia')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gTsd = 0; foreach($estates as $estate){ $gTsd += isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Tersedia')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gTsd, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-200 border-dotted">
                            <td rowspan="2" class="text-center align-middle border-r border-slate-200 w-24">Pagi</td>
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">Tk</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Pagi')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gPgi = 0; foreach($estates as $estate){ $gPgi += isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Pagi')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gPgi, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $tsd = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Tersedia')->jumlah_tk ?? 0) : 0;
                                    $pgi = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Pagi')->jumlah_tk ?? 0) : 0;
                                    $pct = $tsd > 0 ? ($pgi / $tsd) * 100 : 0;
                                @endphp
                                <td class="text-right text-slate-600 font-medium">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            <td class="text-right bg-slate-100 text-slate-700 font-medium">{{ number_format($gTsd > 0 ? ($gPgi/$gTsd)*100 : 0, 2) }}</td>
                        </tr>
                        
                        <tr class="hover:bg-slate-50 border-b border-slate-200 border-dotted">
                            <td rowspan="2" class="text-center align-middle border-r border-slate-200 w-24">Siang</td>
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">Tk</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Siang')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gSng = 0; foreach($estates as $estate){ $gSng += isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Siang')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gSng, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                            <td class="text-center border-r border-slate-200 text-slate-500 font-medium">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $tsd = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Tersedia')->jumlah_tk ?? 0) : 0;
                                    $sng = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Siang')->jumlah_tk ?? 0) : 0;
                                    $pct = $tsd > 0 ? ($sng / $tsd) * 100 : 0;
                                @endphp
                                <td class="text-right text-slate-600 font-medium">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            <td class="text-right bg-slate-100 text-slate-700 font-medium">{{ number_format($gTsd > 0 ? ($gSng/$gTsd)*100 : 0, 2) }}</td>
                        </tr>
                        
                        <tr class="bg-yellow-300 text-yellow-900 border-b border-yellow-500">
                            <td rowspan="2" class="text-center align-middle border-r border-yellow-400 w-24">Sore</td>
                            <td class="text-center border-r border-yellow-400 font-medium text-yellow-800">Tk</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Sore')->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gSor = 0; foreach($estates as $estate){ $gSor += isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Sore')->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-yellow-400">{{ number_format($gSor, 0) }}</td>
                        </tr>
                        <tr class="bg-yellow-300 text-yellow-900 border-b-4 border-yellow-500">
                            <td class="text-center align-middle border-r border-slate-200 w-32 bg-white border-b-0"></td>
                            <td class="text-center border-r border-yellow-400 font-medium text-yellow-800">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $tsd = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Tersedia')->jumlah_tk ?? 0) : 0;
                                    $sor = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Sore')->jumlah_tk ?? 0) : 0;
                                    $pct = $tsd > 0 ? ($sor / $tsd) * 100 : 0;
                                @endphp
                                <td class="text-right">{{ number_format($pct, 2) }}</td>
                            @endforeach
                            <td class="text-right bg-yellow-400">{{ number_format($gTsd > 0 ? ($gSor/$gTsd)*100 : 0, 2) }}</td>
                        </tr>

                        <!-- BAGIAN KELAS PEMANEN -->
                        @php $kelasPemanen = ['A', 'B', 'C', 'D']; @endphp
                        @foreach($kelasPemanen as $idx => $kls)
                        <tr class="hover:bg-slate-50 border-b border-slate-200 border-dotted">
                            @if($idx === 0)
                                <td rowspan="16" class="text-left align-top border-r border-slate-200 w-32 bg-white pt-4">Kelas Pemanen Berdasarkan Pendapatan<br>({{ $namaBulanIni }})</td>
                            @endif
                            <td rowspan="4" class="text-center align-middle border-r border-slate-200 w-24 font-extrabold text-lg text-indigo-700">{{ $kls }}</td>
                            <td class="text-left border-r border-slate-200 text-slate-800">Jml TK</td>
                            @foreach($estates as $estate)
                                @php $v = isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->jumlah_tk ?? 0) : 0; @endphp
                                <td class="text-right">{{ number_format($v, 0) }}</td>
                            @endforeach
                            @php $gKls = 0; foreach($estates as $estate){ $gKls += isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->jumlah_tk ?? 0) : 0; } @endphp
                            <td class="text-right bg-slate-100">{{ number_format($gKls, 0) }}</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-200 border-dotted">
                            <td class="text-left border-r border-slate-200 text-slate-600">%</td>
                            @foreach($estates as $estate)
                                @php 
                                    $tKls = 0; if(isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'])){ foreach($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'] as $p) $tKls+=$p->jumlah_tk; }
                                    $v = isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->jumlah_tk ?? 0) : 0;
                                @endphp
                                <td class="text-right text-slate-600 font-medium">{{ number_format($tKls > 0 ? ($v/$tKls)*100 : 0, 2) }}%</td>
                            @endforeach
                            @php $gTkls = 0; foreach($estates as $estate){ if(isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'])){ foreach($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'] as $p) $gTkls+=$p->jumlah_tk; } } @endphp
                            <td class="text-right bg-slate-100 text-slate-700 font-medium">{{ number_format($gTkls > 0 ? ($gKls/$gTkls)*100 : 0, 2) }}%</td>
                        </tr>
                        <tr class="hover:bg-slate-50 border-b border-slate-200 border-dotted">
                            <td class="text-left border-r border-slate-200 text-emerald-700">/ Hari</td>
                            @foreach($estates as $estate) <td class="text-right text-emerald-700">0</td> @endforeach
                            <td class="text-right bg-emerald-50 text-emerald-800">0</td>
                        </tr>
                        <tr class="bg-emerald-50/50 hover:bg-emerald-100/50 border-b border-slate-300 border-dashed">
                            <td class="text-left border-r border-slate-200 text-emerald-800">Avr/Bln</td>
                            @foreach($estates as $estate) <td class="text-right text-emerald-800">0</td> @endforeach
                            <td class="text-right bg-emerald-100 text-emerald-900">0</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- TABLE EXISTING: PERFORMANCE TK (OLD) -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="modern-matrix text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-left text-slate-400 font-medium">Performance Tenaga Kerja Kategori Bawaan</th>
                            @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase tracking-wider">{{ $estate->kode }}</th> @endforeach
                            <th class="text-center font-bold text-indigo-800 bg-indigo-50 uppercase tracking-wider shadow-sm">BP-2</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        @foreach(['Umur', 'Status Keluarga', 'Masa Kerja', 'Mutasi'] as $kategori)
                            <tr>
                                <td colspan="{{ count($estates) + 3 }}" class="font-bold text-slate-700 bg-slate-100 uppercase tracking-wider border-y-2 border-slate-200">{{ $kategori }}</td>
                            </tr>
                            @php $hasData = false; @endphp
                            @foreach($estates as $estate)
                                @if(isset($dataMatrix[$estate->kode]['pekerja'][$kategori]))
                                    @foreach($dataMatrix[$estate->kode]['pekerja'][$kategori] as $pekerja)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="w-8"></td>
                                            <td class="font-medium text-slate-800">{{ $pekerja->sub_kategori }}</td>
                                            @php $gTotalTk = 0; @endphp
                                            @foreach($estates as $est)
                                                @php
                                                    $val = 0;
                                                    if(isset($dataMatrix[$est->kode]['pekerja'][$kategori])){
                                                        $match = $dataMatrix[$est->kode]['pekerja'][$kategori]->firstWhere('sub_kategori', $pekerja->sub_kategori);
                                                        $val = $match ? $match->jumlah_tk : 0;
                                                        $gTotalTk += $val;
                                                    }
                                                @endphp
                                                <td class="text-right">{{ number_format($val, 0) }}</td>
                                            @endforeach
                                            <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gTotalTk, 0) }}</td>
                                        </tr>
                                        @php $hasData = true; break; @endphp 
                                    @endforeach
                                @endif
                            @endforeach
                            @if(!$hasData)
                            <tr>
                                <td></td>
                                <td class="text-slate-400 italic text-xs">Belum ada data inputan</td>
                                <td colspan="{{ count($estates) + 1 }}"></td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- SCRIPT FUNGSI LAYAR PENUH & TAB SWITCHER -->
    <script>
        function toggleFullscreen() {
            let elem = document.getElementById("analytics-container");
            if (!document.fullscreenElement) {
                elem.requestFullscreen().catch(err => { alert(`Error: Tidak dapat membuka mode layar penuh.`); });
            } else {
                document.exitFullscreen();
            }
        }

        document.addEventListener('fullscreenchange', (event) => {
            let elem = document.getElementById("analytics-container");
            if (document.fullscreenElement) {
                elem.classList.add('bg-slate-50', 'p-8', 'overflow-y-auto');
            } else {
                elem.classList.remove('bg-slate-50', 'p-8', 'overflow-y-auto');
            }
            if(window.myCharts) { window.myCharts.forEach(chart => chart.resize()); }
        });

        // FUNGSI POIN 5: KALKULASI TON/HARI VIA JAVASCRIPT
        function calculateTonHari() {
            let hke = parseFloat(document.getElementById('input-hke').value) || 1; // || 1 untuk menghindari division by zero
            document.querySelectorAll('.ton-hari-cell').forEach(cell => {
                let ton = parseFloat(cell.getAttribute('data-ton')) || 0;
                let result = ton / hke;
                // Format angka dengan 2 angka di belakang koma
                cell.innerText = result.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            });
        }

        const defaultLayout = [
            { id: 'w-summary-prod', visible: true }, { id: 'w-biaya', visible: true }, 
            { id: 'w-cost', visible: true }, { id: 'w-cost-produk', visible: true },
            { id: 'w-cost-oil', visible: true }, { id: 'w-bjr', visible: true },
            { id: 'w-rawat', visible: true }, { id: 'w-pupuk', visible: true }, 
            { id: 'w-tk', visible: true }, { id: 'w-kunjungan', visible: true },
            { id: 'w-chart-prod', visible: true }, { id: 'w-chart-cost', visible: true }, 
            { id: 'w-chart-biaya', visible: true }, { id: 'w-chart-mutu', visible: true }
        ];

        let currentLayout = defaultLayout;
        let savedLayout = localStorage.getItem('exec_layout');
        if (savedLayout) {
            let parsedLayout = JSON.parse(savedLayout);
            let missingWidgets = defaultLayout.filter(def => !parsedLayout.some(saved => saved.id === def.id));
            currentLayout = [...parsedLayout, ...missingWidgets];
        }

        function renderLayout() {
            const container = document.getElementById('dynamic-dashboard-grid');
            const listModal = document.getElementById('layout-list');
            listModal.innerHTML = '';

            currentLayout.forEach(item => {
                const el = document.getElementById(item.id);
                if (el) {
                    container.appendChild(el);
                    el.style.display = item.visible ? '' : 'none';

                    const wName = el.getAttribute('data-wname');
                    const li = document.createElement('li');
                    li.className = 'flex items-center justify-between p-3 bg-white border border-slate-200 rounded shadow-sm';
                    li.setAttribute('data-id', item.id);
                    li.innerHTML = `
                        <div class="flex items-center gap-3">
                            <span class="cursor-move text-slate-400 hover:text-indigo-600 px-1">☰</span>
                            <span class="font-semibold text-slate-700">${wName}</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer toggle-vis" ${item.visible ? 'checked' : ''}>
                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    `;
                    listModal.appendChild(li);
                }
            });
        }

        function saveLayout() {
            const listItems = document.querySelectorAll('#layout-list li');
            const newLayout = [];
            listItems.forEach(li => {
                newLayout.push({ id: li.getAttribute('data-id'), visible: li.querySelector('.toggle-vis').checked });
            });
            currentLayout = newLayout;
            localStorage.setItem('exec_layout', JSON.stringify(currentLayout));
            renderLayout();
            document.getElementById('modal-layout').classList.add('hidden');
        }

        function resetLayout() {
            currentLayout = defaultLayout;
            localStorage.setItem('exec_layout', JSON.stringify(currentLayout));
            renderLayout();
            document.getElementById('modal-layout').classList.add('hidden');
        }

        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('border-indigo-600', 'text-indigo-700');
                el.classList.add('border-transparent', 'text-slate-500', 'hover:text-slate-800');
            });
            document.getElementById(tabId).classList.remove('hidden');
            let activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.classList.remove('border-transparent', 'text-slate-500', 'hover:text-slate-800');
            activeBtn.classList.add('border-indigo-600', 'text-indigo-700');
            
            if(tabId === 'tab-analytics' && window.myCharts) { window.myCharts.forEach(chart => chart.resize()); }
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderLayout();
            new Sortable(document.getElementById('layout-list'), { animation: 150, handle: '.cursor-move' });
            
            // Panggil sekali untuk menghitung awal saat halaman di-load
            calculateTonHari();
        });
    </script>

    <!-- SCRIPT CHART.JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            const labels = {!! json_encode($estates->pluck('kode')) !!};
            
            const dataProdReal = [
                @foreach($estates as $estate)
                    {{ ($dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0) / 1000 }},
                @endforeach
            ];
            const dataProdBgt = [
                @foreach($estates as $estate)
                    {{ ($dataMatrix[$estate->kode]['produksi']['current']['budget']->tonase ?? 0) / 1000 }},
                @endforeach
            ];
            const dataProdRkb = [
                @foreach($estates as $estate)
                    {{ ($dataMatrix[$estate->kode]['produksi']['current']['rkb']->tonase ?? 0) / 1000 }},
                @endforeach
            ];

            const dataCostKg = [
                @foreach($estates as $estate)
                    @php
                        $tSd = ($dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0);
                        $bSd = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0);
                        echo ($tSd > 0 ? $bSd / $tSd : 0) . ',';
                    @endphp
                @endforeach
            ];

            const dataMutu = [
                @php
                    $sampleEstate = $estates->first();
                    if($sampleEstate) {
                        foreach($kriteriaMutu as $mutu) {
                            echo ($dataMatrix[$sampleEstate->kode]['kualitas']['real'][$mutu]->persentase ?? 0) . ',';
                        }
                    }
                @endphp
            ];

            Chart.defaults.font.family = 'Inter';

            const ctxProd = document.getElementById('chartProduksi').getContext('2d');
            const chartProd = new Chart(ctxProd, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'Budget (Ton)', data: dataProdBgt, backgroundColor: '#fcd34d', borderRadius: 4 },
                        { label: 'RKB (Ton)', data: dataProdRkb, backgroundColor: '#cbd5e1', borderRadius: 4 },
                        { label: 'Realisasi (Ton)', data: dataProdReal, backgroundColor: '#4f46e5', borderRadius: 4 }
                    ]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: { tooltip: { padding: 10, bodySpacing: 5 } }
                }
            });

            const ctxCost = document.getElementById('chartCostKg').getContext('2d');
            const chartCost = new Chart(ctxCost, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cost / Kg (S.D Bln Ini)',
                        data: dataCostKg,
                        borderColor: '#f43f5e',
                        backgroundColor: 'rgba(244, 63, 94, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#f43f5e',
                        pointRadius: 4,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false }
                }
            });

            const ctxBiaya = document.getElementById('chartBiayaPie').getContext('2d');
            const chartBiaya = new Chart(ctxBiaya, {
                type: 'doughnut',
                data: {
                    labels: ['Panen', 'Rawat', 'Kantor', 'Teknik', 'PKS'],
                    datasets: [{
                        data: [
                            {{ ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_panen ?? 0) / 1000000 }},
                            {{ ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_rawat ?? 0) / 1000000 }},
                            {{ ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_kantor ?? 0) / 1000000 }},
                            {{ ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_teknik ?? 0) / 1000000 }},
                            {{ ($dataMatrix['BP-2']['biaya_sd_bln']['real']->cost_pks ?? 0) / 1000000 }}
                        ],
                        backgroundColor: ['#10b981', '#f59e0b', '#64748b', '#0ea5e9', '#8b5cf6'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false, 
                    plugins: { legend: { position: 'right' } },
                    cutout: '65%'
                }
            });

            const ctxMutu = document.getElementById('chartMutu').getContext('2d');
            const chartMutu = new Chart(ctxMutu, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kriteriaMutu) !!},
                    datasets: [{
                        label: 'Persentase Mutu (%)',
                        data: dataMutu,
                        backgroundColor: '#0ea5e9',
                        borderRadius: 4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false }
                }
            });

            window.myCharts = [chartProd, chartCost, chartBiaya, chartMutu];
        });
    </script>
</body>
</html>
