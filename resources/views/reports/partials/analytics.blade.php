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
                                    $tSd = $dataMatrix[$estate->kode]['histori']['real_sd_'.$tahun]->tonase ?? 0;
                                    $bSd = ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['real']->cost_pks ?? 0);
                                    $ptCostKgSd = $tSd > 0 ? ($bSd / $tSd) : 0;
                                    $tBgtSd = $dataMatrix[$estate->kode]['histori']['bgt_sd_bln']->tonase ?? 0;
                                    $bBgtSd = ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_panen ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_rawat ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_kantor ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_teknik ?? 0) + ($dataMatrix[$estate->kode]['biaya_sd_bln']['budget']->cost_pks ?? 0);
                                    $ptBgtCostKg = $tBgtSd > 0 ? ($bBgtSd / $tBgtSd) : 0;
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
                <!-- TOOLTIP RAWAT DIPERBARUI -->
                <div class="absolute left-0 top-[105%] tooltip-table z-[100] opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all duration-200 pointer-events-none">
                    <div class="bg-slate-800 text-slate-100 text-xs rounded-lg shadow-xl p-3 border border-slate-700" style="min-width: 480px;">
                        <div class="font-bold text-teal-300 mb-2 border-b border-slate-600 pb-1 flex justify-between">
                            <span>Detail Rawat & Cost per Pekerjaan</span>
                        </div>
                        <table class="w-full text-right">
                            <tr class="text-slate-400 border-b border-slate-600 bg-slate-800 sticky top-0">
                                <th class="text-left pb-1">PT</th>
                                <th class="text-left pb-1 pl-2">Jenis Pekerjaan</th>
                                <th class="pb-1 pl-2 text-center">Blok</th>
                                <th class="pb-1 pl-2">Luas (Ha)</th>
                                <th class="pb-1 pl-2">Cost/Ha (Rp)</th>
                            </tr>
                            @foreach($estates as $estate)
                                @php 
                                    $isFirst = true; 
                                    $allJobs = array_merge($jenisPerawatan, $kategoriPruning);
                                @endphp
                                @foreach($allJobs as $job)
                                    @php
                                        $l = $dataMatrix[$estate->kode]['upkeep']['real'][$job]->luas_ha ?? 0; 
                                        $b = $dataMatrix[$estate->kode]['upkeep']['real'][$job]->jml_blok ?? 0; 
                                        $c = $dataMatrix[$estate->kode]['upkeep']['real'][$job]->cost_ha ?? 0; 
                                    @endphp
                                    
                                    @if($l > 0 || $b > 0 || $c > 0)
                                    <tr class="border-b border-slate-700/50 last:border-0 hover:bg-slate-700/50 transition-colors">
                                        <td class="py-1.5 text-left font-bold text-slate-300">{{ $isFirst ? $estate->kode : '' }}</td>
                                        <td class="py-1.5 text-left pl-2 text-slate-400 truncate max-w-[140px]" title="{{ $job }}">{{ $job }}</td>
                                        <td class="py-1.5 pl-2 text-center">{{ number_format($b, 0) }}</td>
                                        <td class="py-1.5 pl-2 font-bold text-white">{{ number_format($l, 2) }}</td>
                                        <td class="py-1.5 pl-2 text-amber-400">{{ number_format($c, 0) }}</td>
                                    </tr>
                                    @php $isFirst = false; @endphp
                                    @endif
                                @endforeach
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
