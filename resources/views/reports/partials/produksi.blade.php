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
                        @endphp
                        <td class="text-right font-bold {{ $dev < 0 ? 'text-rose-600' : 'text-emerald-600' }}">{{ $dev < 0 ? '('.number_format(abs($dev), 0).')' : number_format($dev, 0) }}</td>
                    @endforeach
                    @php
                        $gr = $dataMatrix['BP-2']['produksi']['current']['real']->tonase ?? 0;
                        $gb = $dataMatrix['BP-2']['produksi']['current']['rkb']->tonase ?? 0;
                        $gdev = ($gr - $gb) / 1000;
                    @endphp
                    <td class="text-right font-bold {{ $gdev < 0 ? 'text-rose-600 bg-rose-50/30' : 'text-emerald-600 bg-emerald-50/30' }}">{{ $gdev < 0 ? '('.number_format(abs($gdev), 0).')' : number_format($gdev, 0) }}</td>
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
                
                @php 
                    // Variabel $hkeBulanIni sekarang menggunakan nilai global dari Controller.
                    // Fallback di bawah ini hanya agar tidak error bagi 0 jika variabel kosong.
                    if(!isset($hkeBulanIni) || $hkeBulanIni <= 0) $hkeBulanIni = 26; 
                @endphp
                <tr>
                    <td rowspan="3" class="valign-top font-semibold text-slate-700 bg-slate-50/80 border-r border-slate-100 text-center">
                        Ha Cavel / Hari<br>
                        <div class="mt-2 text-center text-sm font-bold text-slate-800 bg-white border border-slate-300 rounded py-1 w-14 mx-auto shadow-sm">
                            {{ number_format($hkeBulanIni, 0) }}
                        </div>
                    </td>
                    <td class="font-semibold text-slate-700 border-r border-slate-100 text-center">Cavel</td>
                    <td class="text-center text-slate-500">Ha</td>
                    @foreach($estates as $estate)
                        @php $cavel = ($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_ha ?? 0) / $hkeBulanIni; @endphp
                        <td class="text-right">{{ number_format($cavel, 2) }}</td>
                    @endforeach
                    @php $gcavel = ($dataMatrix['BP-2']['produksi']['current']['real']->hs_ha ?? 0) / $hkeBulanIni; @endphp
                    <td class="text-right font-bold bg-indigo-50/30">{{ number_format($gcavel, 2) }}</td>
                </tr>
                <tr>
                    <td class="font-semibold text-slate-700 border-r border-slate-100 text-center">Real</td>
                    <td class="text-center text-slate-500">Ha</td>
                    @foreach($estates as $estate)
                        @php $realHa = $dataMatrix[$estate->kode]['produksi']['current']['real']->ha_cavel_real ?? 0; @endphp
                        <td class="text-right font-medium text-slate-800">{{ number_format($realHa, 2) }}</td>
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
                            $cavel = ($dataMatrix[$estate->kode]['produksi']['current']['real']->hs_ha ?? 0) / $hkeBulanIni;
                            $realHa = $dataMatrix[$estate->kode]['produksi']['current']['real']->ha_cavel_real ?? 0;
                            $devHa = $realHa - $cavel;
                        @endphp
                        <td class="text-right font-medium {{ $devHa < 0 ? 'text-rose-500 bg-rose-50/30' : 'text-emerald-500 bg-emerald-50/30' }}">
                            {{ $devHa < 0 ? '('.number_format(abs($devHa), 2).')' : number_format($devHa, 2) }}
                        </td>
                    @endforeach
                    <td class="text-right font-bold text-rose-600 bg-rose-100/50">
                        @php
                            $gcavel = ($dataMatrix['BP-2']['produksi']['current']['real']->hs_ha ?? 0) / $hkeBulanIni;
                            $gRealHa = $dataMatrix['BP-2']['produksi']['current']['real']->ha_cavel_real ?? 0;
                            $gDevHa = $gRealHa - $gcavel;
                        @endphp
                        {{ $gDevHa < 0 ? '('.number_format(abs($gDevHa), 2).')' : number_format($gDevHa, 2) }}
                    </td>
                </tr>

                @php 
                    // Variabel $hkeBulanDepan sekarang menggunakan nilai global dari Controller.
                    // Fallback di bawah ini hanya agar tidak error bagi 0 jika variabel kosong.
                    if(!isset($hkeBulanDepan) || $hkeBulanDepan <= 0) $hkeBulanDepan = 24;
                @endphp
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
                        <div class="mt-1 text-center text-sm font-bold text-indigo-800 bg-white border border-indigo-200 rounded py-1 w-14 mx-auto shadow-sm">
                            {{ number_format($hkeBulanDepan, 0) }}
                        </div>
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
                
                <tr class="row-border-strong">
                    <td class="font-bold text-slate-800">Ton/Hari</td>
                    @foreach($estates as $estate)
                        @php 
                            $nTon = ($dataMatrix[$estate->kode]['produksi']['next']['rkb']->tonase ?? 0) / 1000; 
                            $tonPerHari = $hkeBulanDepan > 0 ? $nTon / $hkeBulanDepan : 0;
                        @endphp
                        <td class="text-right font-bold text-slate-800">{{ number_format($tonPerHari, 2) }}</td>
                    @endforeach
                    @php 
                        $gnTon = ($dataMatrix['BP-2']['produksi']['next']['rkb']->tonase ?? 0) / 1000; 
                        $gTonPerHari = $hkeBulanDepan > 0 ? $gnTon / $hkeBulanDepan : 0;
                    @endphp
                    <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gTonPerHari, 2) }}</td>
                </tr>

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
                        <td class="text-right py-2 px-4 font-medium text-slate-700">
                            {{ number_format($dataMatrix[$estate->kode]['biaya_pdo']['bi'] ?? 0, 0) }}
                        </td>
                    @endforeach
                    <td class="text-right py-2 px-4 bg-slate-50 font-bold">
                        @php 
                            $gPdoBi = 0; 
                            foreach($estates as $estate) { 
                                $gPdoBi += $dataMatrix[$estate->kode]['biaya_pdo']['bi'] ?? 0; 
                            } 
                        @endphp
                        {{ number_format($gPdoBi, 0) }}
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors row-border-strong border-b-2 border-slate-300">
                    <td class="text-center py-2 px-3 text-slate-600 border-r border-slate-200 bg-white sticky left-[96px] z-10 italic">Sbi</td>
                    @foreach($estates as $estate)
                        <td class="text-right py-2 px-4 font-medium text-slate-700">
                            {{ number_format($dataMatrix[$estate->kode]['biaya_pdo']['sbi'] ?? 0, 0) }}
                        </td>
                    @endforeach
                    <td class="text-right py-2 px-4 bg-slate-50 font-bold">
                        @php 
                            $gPdoSbi = 0; 
                            foreach($estates as $estate) { 
                                $gPdoSbi += $dataMatrix[$estate->kode]['biaya_pdo']['sbi'] ?? 0; 
                            } 
                        @endphp
                        {{ number_format($gPdoSbi, 0) }}
                    </td>
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