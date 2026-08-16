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

            /* KALKULASI DATA EXECUTIVE SUMMARY & UMUM */
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

            /* KALKULASI DATA EKSTRAKSI & MILL */
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

            /* KALKULASI DATA BIAYA & DEVIASI COST */
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

        <!-- PEMANGGILAN FILE PARTIALS -->
        @include('reports.partials.analytics')
        @include('reports.partials.produksi')
        @include('reports.partials.agronomi_sdm')

        <!-- MODAL PENGATURAN DASHBOARD -->
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

    </div>

    <!-- SCRIPT FUNGSI LAYAR PENUH & TAB SWITCHER -->
    <script>
        function toggleFullscreen() {
            let elem = document.getElementById("analytics-container");
            if (!document.fullscreenElement) {
                elem.requestFullscreen().catch(err => { alert(`Error: Tidak dapat membuka mode layar penuh.`); });
            } else { document.exitFullscreen(); }
        }

        document.addEventListener('fullscreenchange', (event) => {
            let elem = document.getElementById("analytics-container");
            if (document.fullscreenElement) { elem.classList.add('bg-slate-50', 'p-8', 'overflow-y-auto'); } 
            else { elem.classList.remove('bg-slate-50', 'p-8', 'overflow-y-auto'); }
            if(window.myCharts) { window.myCharts.forEach(chart => chart.resize()); }
        });

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
        });
    </script>

    <!-- SCRIPT CHART.JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = {!! json_encode($estates->pluck('kode')) !!};
            
            const dataProdReal = [
                @foreach($estates as $estate) {{ ($dataMatrix[$estate->kode]['produksi']['current']['real']->tonase ?? 0) / 1000 }}, @endforeach
            ];
            const dataProdBgt = [
                @foreach($estates as $estate) {{ ($dataMatrix[$estate->kode]['produksi']['current']['budget']->tonase ?? 0) / 1000 }}, @endforeach
            ];
            const dataProdRkb = [
                @foreach($estates as $estate) {{ ($dataMatrix[$estate->kode]['produksi']['current']['rkb']->tonase ?? 0) / 1000 }}, @endforeach
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
                    responsive: true, maintainAspectRatio: false,
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
                        label: 'Cost / Kg (S.D Bln Ini)', data: dataCostKg, borderColor: '#f43f5e', backgroundColor: 'rgba(244, 63, 94, 0.1)', borderWidth: 3, pointBackgroundColor: '#fff', pointBorderColor: '#f43f5e', pointRadius: 4, tension: 0.3, fill: true
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false } }
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
                        borderWidth: 0, hoverOffset: 4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' } }, cutout: '65%' }
            });

            const ctxMutu = document.getElementById('chartMutu').getContext('2d');
            const chartMutu = new Chart(ctxMutu, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kriteriaMutu) !!},
                    datasets: [{ label: 'Persentase Mutu (%)', data: dataMutu, backgroundColor: '#0ea5e9', borderRadius: 4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false } }
            });

            window.myCharts = [chartProd, chartCost, chartBiaya, chartMutu];
        });
    </script>
</body>
</html>
