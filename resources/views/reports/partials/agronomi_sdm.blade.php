<!-- ================= TAB 2: RAWAT & PUPUK ================= -->
<div id="tab-agronomi" class="tab-content hidden w-full space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
        <table class="modern-matrix text-sm w-full min-w-[900px]">
            <thead>
                <tr>
                    <th colspan="2" class="text-left text-slate-400 font-medium">Realisasi Rawat & Pemupukan</th>
                    @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase tracking-wider">{{ $estate->kode }}</th> @endforeach
                    <th class="text-center font-bold text-indigo-800 bg-indigo-50 uppercase tracking-wider shadow-sm">BP-2</th>
                </tr>
            </thead>
            <tbody class="text-slate-600">
                <!-- BARIS PERAWATAN -->
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

                <!-- BARIS PEMUPUKAN -->
                <tr><td colspan="{{ count($estates) + 3 }}" class="font-bold text-slate-700 bg-slate-100 uppercase tracking-wider border-y-2 border-slate-200">Aplikasi Pupuk (Kg)</td></tr>
                @foreach($jenisPupuk as $pupuk)
                <tr class="bg-slate-50/30 hover:bg-slate-50 transition-colors">
                    <td class="font-bold text-slate-800 pl-4">{{ $pupuk }} (Real)</td>
                    <td class="text-center font-medium text-slate-500 w-16">Kg</td>
                    @foreach($estates as $estate) <td class="text-right font-bold text-slate-900">{{ number_format($dataMatrix[$estate->kode]['pupuk']['real'][$pupuk]->jumlah_kg ?? 0, 0) }}</td> @endforeach
                    @php $gPupuk = 0; foreach($estates as $estate){ $gPupuk += $dataMatrix[$estate->kode]['pupuk']['real'][$pupuk]->jumlah_kg ?? 0; } @endphp
                    <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($gPupuk, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- TABLE ROTASI PRUNING -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
        <table class="modern-matrix text-sm w-full min-w-[900px]">
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

    <!-- TABLE RKB PUPUK -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
        <table class="modern-matrix text-sm w-full min-w-[900px]">
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
                        <td class="text-right">{{ number_format(20 > 0 ? $tPpk / 20 : 0, 0) }}</td>
                    @endforeach
                    <td class="text-right bg-emerald-400">{{ number_format(20 > 0 ? $gTppk / 20 : 0, 0) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<!-- ================= TAB 4: KUALITAS BUAH ================= -->
<div id="tab-kualitas" class="tab-content hidden w-full space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
        <table class="modern-matrix text-sm w-full min-w-[900px]">
            <thead>
                <tr>
                    <th colspan="2" class="text-left text-slate-400 font-medium">Kinerja Mutu Ancak (% Real vs Target)</th>
                    @foreach($estates as $estate) <th class="text-center font-bold text-slate-700 bg-slate-100 uppercase tracking-wider">{{ $estate->kode }}</th> @endforeach
                    <th class="text-center font-bold text-indigo-800 bg-indigo-50 uppercase tracking-wider shadow-sm">BP-2 (Rata-rata)</th>
                </tr>
            </thead>
            <tbody class="text-slate-600">
                @foreach($kriteriaMutu as $mutu)
                <tr class="bg-slate-50/30">
                    <td colspan="2" class="font-bold text-slate-800 pl-4">{{ $mutu }} (% Target)</td>
                    @foreach($estates as $estate) <td class="text-right font-medium text-slate-500">{{ number_format($dataMatrix[$estate->kode]['kualitas']['rkb'][$mutu]->persentase ?? 0, 2) }}</td> @endforeach
                    
                    @php
                        $tMutuRkb = 0; $cMutuRkb = 0;
                        foreach($estates as $estate) {
                            $vRkb = $dataMatrix[$estate->kode]['kualitas']['rkb'][$mutu]->persentase ?? 0;
                            if($vRkb > 0) { $tMutuRkb += $vRkb; $cMutuRkb++; }
                        }
                    @endphp
                    <td class="text-right font-bold bg-indigo-50/30 text-indigo-900">{{ number_format($cMutuRkb > 0 ? $tMutuRkb / $cMutuRkb : 0, 2) }}</td>
                </tr>
                <tr class="row-border-strong">
                    <td colspan="2" class="font-bold text-emerald-700 pl-4">{{ $mutu }} (% Real)</td>
                    @foreach($estates as $estate) <td class="text-right font-bold text-slate-900">{{ number_format($dataMatrix[$estate->kode]['kualitas']['real'][$mutu]->persentase ?? 0, 2) }}</td> @endforeach
                    
                    @php
                        $tMutuReal = 0; $cMutuReal = 0;
                        foreach($estates as $estate) {
                            $vReal = $dataMatrix[$estate->kode]['kualitas']['real'][$mutu]->persentase ?? 0;
                            if($vReal > 0) { $tMutuReal += $vReal; $cMutuReal++; }
                        }
                    @endphp
                    <td class="text-right font-bold bg-emerald-100/50 text-emerald-800">{{ number_format($cMutuReal > 0 ? $tMutuReal / $cMutuReal : 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ================= TAB 5: PERFORMANCE TK ================= -->
<div id="tab-performance" class="tab-content hidden w-full space-y-6">
    
    <!-- TABLE HKNE KARYAWAN & KELAS PEMANEN -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
        <table class="modern-matrix text-sm w-full min-w-[900px]">
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
                    <td rowspan="8" class="text-center align-middle border-r border-slate-200 w-32 bg-white">HKNE Kary PANEN<br><span class="text-xs text-slate-500 font-normal">HKE: {{ number_format($hkeBulanIni, 0) }}</span></td>
                    <td class="text-left border-r border-slate-200 w-24">Kerja</td>
                    <td class="text-center border-r border-slate-200 text-slate-500 font-medium">Hk</td>
                    @foreach($estates as $estate)
                        @php $v = isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Kerja')->jumlah_tk ?? 0) : 0; @endphp
                        <td class="text-right">{{ number_format($v, 0) }}</td>
                    @endforeach
                    @php $gKerja = 0; foreach($estates as $estate){ $gKerja += isset($dataMatrix[$estate->kode]['pekerja']['HKNE']) ? ($dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Kerja')->jumlah_tk ?? 0) : 0; } @endphp
                    <td class="text-right bg-slate-100">{{ number_format($gKerja, 0) }}</td>
                </tr>
                <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
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
                        @php 
                            $tHk = 0; 
                            if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { 
                                foreach(['Sakit', 'Cuti', 'Mangkir', 'Ijin'] as $sub) {
                                    $tHk += $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', $sub)->jumlah_tk ?? 0;
                                }
                            } 
                        @endphp
                        <td class="text-right text-emerald-800">{{ number_format($tHk, 0) }}</td>
                    @endforeach
                    @php 
                        $gHk = 0; 
                        foreach($estates as $estate){ 
                            if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { 
                                foreach(['Sakit', 'Cuti', 'Mangkir', 'Ijin'] as $sub) {
                                    $gHk += $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', $sub)->jumlah_tk ?? 0;
                                }
                            } 
                        } 
                    @endphp
                    <td class="text-right bg-emerald-200 text-emerald-900">{{ number_format($gHk, 0) }}</td>
                </tr>
                <tr class="bg-slate-50/50 border-b-2 border-slate-300">
                    <td class="text-left border-r border-slate-200 w-24">%</td>
                    <td class="text-center border-r border-slate-200 text-slate-500 font-medium"></td>
                    @foreach($estates as $estate)
                        @php 
                            $tHkne = 0; 
                            $kerja = 0;
                            if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { 
                                foreach(['Sakit', 'Cuti', 'Mangkir', 'Ijin'] as $sub) {
                                    $tHkne += $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', $sub)->jumlah_tk ?? 0;
                                }
                                $kerja = $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', 'Kerja')->jumlah_tk ?? 0;
                            }
                            $totHk = $kerja + $tHkne;
                            $pct = $totHk > 0 ? ($tHkne / $totHk) * 100 : 0;
                        @endphp
                        <td class="text-right text-slate-600 font-medium">{{ number_format($pct, 2) }}</td>
                    @endforeach
                    @php 
                        $gTotHk = $gKerja + $gHk;
                        $gPct = $gTotHk > 0 ? ($gHk / $gTotHk) * 100 : 0;
                    @endphp
                    <td class="text-right bg-slate-100 text-slate-700 font-medium">{{ number_format($gPct, 2) }}</td>
                </tr>
                <tr class="bg-yellow-300 text-yellow-900 border-b-4 border-yellow-500">
                    <td class="text-left border-r border-yellow-400 w-24">Rata2 Hkne/hari</td>
                    <td class="text-center border-r border-yellow-400 font-medium">Hk</td>
                    @foreach($estates as $estate)
                        @php 
                            $tHkne = 0; 
                            if(isset($dataMatrix[$estate->kode]['pekerja']['HKNE'])) { 
                                foreach(['Sakit', 'Cuti', 'Mangkir', 'Ijin'] as $sub) {
                                    $tHkne += $dataMatrix[$estate->kode]['pekerja']['HKNE']->firstWhere('sub_kategori', $sub)->jumlah_tk ?? 0;
                                }
                            } 
                        @endphp
                        <td class="text-right">{{ number_format($hkeBulanIni > 0 ? $tHkne / $hkeBulanIni : 0, 0) }}</td>
                    @endforeach
                    <td class="text-right bg-yellow-400">{{ number_format($hkeBulanIni > 0 ? $gHk / $hkeBulanIni : 0, 0) }}</td>
                </tr>

                <!-- BAGIAN JAM KERJA -->
                <tr class="hover:bg-slate-50 border-b border-slate-300 border-dashed">
                    <td rowspan="7" class="text-center align-middle border-r border-slate-200 w-32 bg-white">Jam Kerja</td>
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
                            $pgi = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Pagi')->jumlah_tk ?? 0) : 0;
                            $sng = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Siang')->jumlah_tk ?? 0) : 0;
                            $pct = $pgi > 0 ? ($sng / $pgi) * 100 : 0;
                        @endphp
                        <td class="text-right text-slate-600 font-medium">{{ number_format($pct, 2) }}</td>
                    @endforeach
                    <td class="text-right bg-slate-100 text-slate-700 font-medium">{{ number_format($gPgi > 0 ? ($gSng/$gPgi)*100 : 0, 2) }}</td>
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
                    <td class="text-center border-r border-yellow-400 font-medium text-yellow-800">%</td>
                    @foreach($estates as $estate)
                        @php 
                            $pgi = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Pagi')->jumlah_tk ?? 0) : 0;
                            $sor = isset($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']) ? ($dataMatrix[$estate->kode]['pekerja']['Jam Kerja']->firstWhere('sub_kategori', 'Sore')->jumlah_tk ?? 0) : 0;
                            $pct = $pgi > 0 ? ($sor / $pgi) * 100 : 0;
                        @endphp
                        <td class="text-right">{{ number_format($pct, 2) }}</td>
                    @endforeach
                    <td class="text-right bg-yellow-400">{{ number_format($gPgi > 0 ? ($gSor/$gPgi)*100 : 0, 2) }}</td>
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
                            $tKls = 0; 
                            if(isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'])){ 
                                foreach($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'] as $p) {
                                    if(in_array($p->sub_kategori, ['A','B','C','D'])) { $tKls+=$p->jumlah_tk; }
                                }
                            }
                            $v = isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->jumlah_tk ?? 0) : 0;
                        @endphp
                        <td class="text-right text-slate-600 font-medium">{{ number_format($tKls > 0 ? ($v/$tKls)*100 : 0, 2) }}%</td>
                    @endforeach
                    @php 
                        $gTkls = 0; 
                        foreach($estates as $estate){ 
                            if(isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'])){ 
                                foreach($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen'] as $p) {
                                    if(in_array($p->sub_kategori, ['A','B','C','D'])) { $gTkls+=$p->jumlah_tk; }
                                }
                            } 
                        } 
                    @endphp
                    <td class="text-right bg-slate-100 text-slate-700 font-medium">{{ number_format($gTkls > 0 ? ($gKls/$gTkls)*100 : 0, 2) }}%</td>
                </tr>
                <tr class="hover:bg-slate-50 border-b border-slate-200 border-dotted">
                    <td class="text-left border-r border-slate-200 text-emerald-700">/ Hari</td>
                    @foreach($estates as $estate) 
                        @php 
                            $avr = isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->avr_bln ?? 0) : 0;
                            $perHari = $hkeBulanIni > 0 ? $avr / $hkeBulanIni : 0;
                        @endphp
                        <td class="text-right text-emerald-700">{{ number_format($perHari, 2) }}</td> 
                    @endforeach
                    @php
                        $gAvr = 0;
                        foreach($estates as $estate){
                            $gAvr += isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->avr_bln ?? 0) : 0;
                        }
                        $gPerHari = $hkeBulanIni > 0 ? $gAvr / $hkeBulanIni : 0;
                    @endphp
                    <td class="text-right bg-emerald-50 text-emerald-800">{{ number_format($gPerHari, 2) }}</td>
                </tr>
                <tr class="bg-emerald-50/50 hover:bg-emerald-100/50 border-b border-slate-300 border-dashed">
                    <td class="text-left border-r border-slate-200 text-emerald-800">Avr/Bln</td>
                    @foreach($estates as $estate) 
                        @php $avr = isset($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']) ? ($dataMatrix[$estate->kode]['pekerja']['Kelas Pemanen']->firstWhere('sub_kategori', $kls)->avr_bln ?? 0) : 0; @endphp
                        <td class="text-right text-emerald-800">{{ number_format($avr, 2) }}</td> 
                    @endforeach
                    <td class="text-right bg-emerald-100 text-emerald-900">{{ number_format($gAvr, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- TABLE RKK (MANUAL 100%) -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto mb-6">
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
                            // Sbi = (Bi bulan ini) + (Sbi bulan lalu) // otomatis dihitung dari controller/tabel, tp utk tampilan:
                            $vSbiLalu = $dataMatrix[$estate->kode]['pekerja_lalu']['Mutasi']->firstWhere('sub_kategori', 'Masuk (Sbi)')->jumlah_tk ?? 0;
                            $vBiKini = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', 'Masuk (Bi)')->jumlah_tk ?? 0) : 0;
                            $vSbi = $vSbiLalu + $vBiKini;
                        @endphp
                        <td class="text-right">{{ number_format($vSbi, 0) }}</td>
                    @endforeach
                    @php 
                        $gMasukSbi = 0; 
                        foreach($estates as $estate) { 
                            $vSbiLalu = $dataMatrix[$estate->kode]['pekerja_lalu']['Mutasi']->firstWhere('sub_kategori', 'Masuk (Sbi)')->jumlah_tk ?? 0;
                            $vBiKini = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', 'Masuk (Bi)')->jumlah_tk ?? 0) : 0;
                            $gMasukSbi += ($vSbiLalu + $vBiKini); 
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
                            // Diambil dari inputan manual, disimpan di kolom persentase
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
                            // Sbi = (Bi bulan ini) + (Sbi bulan lalu)
                            $vSbiLalu = $dataMatrix[$estate->kode]['pekerja_lalu']['Mutasi']->firstWhere('sub_kategori', 'Keluar (Sbi)')->jumlah_tk ?? 0;
                            $vBiKini = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', 'Keluar (Bi)')->jumlah_tk ?? 0) : 0;
                            $vSbi = $vSbiLalu + $vBiKini;
                        @endphp
                        <td class="text-right">{{ number_format($vSbi, 0) }}</td>
                    @endforeach
                    @php 
                        $gKeluarSbi = 0; 
                        foreach($estates as $estate) { 
                            $vSbiLalu = $dataMatrix[$estate->kode]['pekerja_lalu']['Mutasi']->firstWhere('sub_kategori', 'Keluar (Sbi)')->jumlah_tk ?? 0;
                            $vBiKini = isset($dataMatrix[$estate->kode]['pekerja']['Mutasi']) ? ($dataMatrix[$estate->kode]['pekerja']['Mutasi']->firstWhere('sub_kategori', 'Keluar (Bi)')->jumlah_tk ?? 0) : 0;
                            $gKeluarSbi += ($vSbiLalu + $vBiKini); 
                        } 
                    @endphp
                    <td class="text-right bg-slate-100">{{ number_format($gKeluarSbi, 0) }}</td>
                </tr>
                <tr class="bg-amber-300 text-amber-900 border-b border-amber-400">
                    <td class="text-left border-r border-amber-400 w-24">% Keluar Sbi</td>
                    @foreach($estates as $estate)
                        @php 
                            // Diambil dari inputan manual, disimpan di kolom persentase
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

    <!-- TABLE EXISTING: PERFORMANCE TK (OLD) -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
        <table class="modern-matrix text-sm w-full min-w-[900px]">
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
