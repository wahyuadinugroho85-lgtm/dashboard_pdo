<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estate;
use App\Models\Production;
use App\Models\Upkeep;
use App\Models\Fertilizer;
use App\Models\WorkerPerformance;
use App\Models\HarvestQuality;
use App\Models\OperationalCost;
use Carbon\Carbon;
use App\Imports\LaporanImport;
use App\Exports\LaporanTemplateExport;
use App\Exports\LaporanDataExport; 
use Maatwebsite\Excel\Facades\Excel;

class MonthlyDashboardController extends Controller
{
    private $jenisPerawatan = ['Rwt Piringan Manual', 'PPT Chemist', 'Rwt Gawangan Manual', 'Rwt Gawangan Chemist', 'Pruning'];
    private $kategoriPruning = ['Pruning <= 6 Bln', 'Pruning 6.01-9 Bln', 'Pruning 9.01-12 Bln', 'Pruning > 12 Bln'];
    private $jenisPupuk = ['Dolomite', 'Kieserite', 'Kaptan', 'TSP / RP', 'Urea', 'MOP', 'Mikro-Mg'];
    private $kriteriaMutu = ['Unripe', 'Ripe', 'Over Ripe', 'Empty Bunch', 'Abnormal'];
    
    private $kategoriPekerja = ['Umur', 'Status Keluarga', 'Masa Kerja', 'Mutasi', 'HKNE', 'Jam Kerja', 'Kelas Pemanen'];

    public function index(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);
        $periodeDate = Carbon::createFromDate($tahun, $bulan, 1);
        $periode = $periodeDate->format('Y-m-d');
        
        $lastMonth = $periodeDate->copy()->subMonth()->format('Y-m-d');
        $lastYearMonth = $periodeDate->copy()->subYear()->format('Y-m-d');

        $nextMonthDate = $periodeDate->copy()->addMonth();
        $nextPeriode = $nextMonthDate->format('Y-m-d');

        $estates = Estate::where('kode', '!=', 'BP-2')->orderBy('kode', 'asc')->get();
        $dataMatrix = [];

        $historicalYears = [$tahun, $tahun - 1, $tahun - 2, $tahun - 3];

        foreach ($estates as $estate) {
            $kode = $estate->kode;

            $prodRkb = Production::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'RKB')->first();
            $prodReal = Production::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'REAL')->first();
            $prodBgt = Production::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'BUDGET')->first();
            $prodSns = Production::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'SENSUS')->first();

            $realLastMonth = Production::where('estate_id', $estate->id)->where('periode', $lastMonth)->where('tipe', 'REAL')->first();
            $realLastYearMonth = Production::where('estate_id', $estate->id)->where('periode', $lastYearMonth)->where('tipe', 'REAL')->first();

            $prodRkbNext = Production::where('estate_id', $estate->id)->where('periode', $nextPeriode)->where('tipe', 'RKB')->first();

            $dataMatrix[$kode]['produksi']['current'] = [
                'rkb' => $prodRkb, 
                'real' => $prodReal, 
                'budget' => $prodBgt, 
                'sensus' => $prodSns,
                'bjr_rkb' => ($prodRkb && $prodRkb->janjang > 0) ? ($prodRkb->tonase / $prodRkb->janjang) : 0,
                'bjr_real' => ($prodReal && $prodReal->janjang > 0) ? ($prodReal->tonase / $prodReal->janjang) : 0,
                'bjr_last_month' => ($realLastMonth && $realLastMonth->janjang > 0) ? ($realLastMonth->tonase / $realLastMonth->janjang) : 0,
                'bjr_last_year' => ($realLastYearMonth && $realLastYearMonth->janjang > 0) ? ($realLastYearMonth->tonase / $realLastYearMonth->janjang) : 0,
            ];
            
            $dataMatrix[$kode]['produksi']['next'] = ['rkb' => $prodRkbNext];

            $dataMatrix[$kode]['histori']['bgt_1_thn'] = Production::where('estate_id', $estate->id)->whereYear('periode', $tahun)->where('tipe', 'BUDGET')
                ->selectRaw('SUM(tonase) as tonase, SUM(janjang) as janjang, SUM(ton_cpo) as ton_cpo, SUM(ton_ker) as ton_ker, SUM(ton_pko) as ton_pko')->first();
            
            $dataMatrix[$kode]['histori']['bgt_sd_bln'] = Production::where('estate_id', $estate->id)->whereYear('periode', $tahun)->whereMonth('periode', '<=', $bulan)->where('tipe', 'BUDGET')
                ->selectRaw('SUM(tonase) as tonase, SUM(janjang) as janjang, SUM(ton_cpo) as ton_cpo, SUM(ton_ker) as ton_ker, SUM(ton_pko) as ton_pko')->first();
            
            $dataMatrix[$kode]['histori']['sns_sd_bln'] = Production::where('estate_id', $estate->id)->whereYear('periode', $tahun)->whereMonth('periode', '<=', $bulan)->where('tipe', 'SENSUS')
                ->selectRaw('SUM(tonase) as tonase, SUM(janjang) as janjang, SUM(ton_cpo) as ton_cpo, SUM(ton_ker) as ton_ker, SUM(ton_pko) as ton_pko')->first();

            foreach ($historicalYears as $yr) {
                $dataMatrix[$kode]['histori']['real_sd_'.$yr] = Production::where('estate_id', $estate->id)->whereYear('periode', $yr)->whereMonth('periode', '<=', $bulan)->where('tipe', 'REAL')
                    ->selectRaw('SUM(tonase) as tonase, SUM(janjang) as janjang, SUM(ton_cpo) as ton_cpo, SUM(ton_ker) as ton_ker, SUM(ton_pko) as ton_pko')->first();
            }

            $dataMatrix[$kode]['upkeep']['rkb'] = Upkeep::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'RKB')->get()->keyBy('jenis_pekerjaan');
            $dataMatrix[$kode]['upkeep']['real'] = Upkeep::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'REAL')->get()->keyBy('jenis_pekerjaan');
            
            foreach($this->kategoriPruning as $kp) {
                $dataMatrix[$kode]['rotasi_pruning'][$kp] = Upkeep::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'REAL')->where('jenis_pekerjaan', $kp)->first();
            }

            $dataMatrix[$kode]['pupuk']['budget'] = Fertilizer::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'BUDGET')->get()->keyBy('jenis_pupuk');
            $dataMatrix[$kode]['pupuk']['real'] = Fertilizer::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'REAL')->get()->keyBy('jenis_pupuk');
            
            $dataMatrix[$kode]['biaya'] = [
                'real' => OperationalCost::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'REAL')->first(),
                'budget_year' => OperationalCost::where('estate_id', $estate->id)->whereYear('periode', $tahun)->where('tipe', 'BUDGET')->orderBy('bgt_cost_palm_produk', 'desc')->first(),
            ];

            $dataMatrix[$kode]['biaya_sd_bln'] = [
                'real' => OperationalCost::where('estate_id', $estate->id)->whereYear('periode', $tahun)->whereMonth('periode', '<=', $bulan)->where('tipe', 'REAL')
                    ->selectRaw('SUM(cost_panen) as cost_panen, SUM(cost_rawat) as cost_rawat, SUM(cost_kantor) as cost_kantor, SUM(cost_teknik) as cost_teknik, SUM(cost_pks) as cost_pks')->first(),
                'budget' => OperationalCost::where('estate_id', $estate->id)->whereYear('periode', $tahun)->whereMonth('periode', '<=', $bulan)->where('tipe', 'BUDGET')
                    ->selectRaw('SUM(cost_panen) as cost_panen, SUM(cost_rawat) as cost_rawat, SUM(cost_kantor) as cost_kantor, SUM(cost_teknik) as cost_teknik, SUM(cost_pks) as cost_pks')->first(),
            ];
            
            // PERBAIKAN RUMUS SBI:
            // Menjumlahkan pdo_bi dari bulan 1 sampai bulan yang dipilih (Sbi otomatis)
            $pdoSbiOtomatis = OperationalCost::where('estate_id', $estate->id)
                ->whereYear('periode', $tahun)
                ->whereMonth('periode', '<=', $bulan)
                ->where('tipe', 'REAL')
                ->sum('pdo_bi');

            $biayaReal = $dataMatrix[$kode]['biaya']['real'] ?? null;
            $dataMatrix[$kode]['biaya_pdo'] = [
                'bi' => $biayaReal ? ($biayaReal->pdo_bi ?? 0) : 0,
                'sbi' => $pdoSbiOtomatis, // Menggunakan hasil perhitungan otomatis
            ];
            
            $dataMatrix[$kode]['kualitas']['rkb'] = HarvestQuality::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'RKB')->get()->keyBy('kriteria');
            $dataMatrix[$kode]['kualitas']['real'] = HarvestQuality::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'REAL')->get()->keyBy('kriteria');
            
            $dataMatrix[$kode]['pekerja'] = WorkerPerformance::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', 'REAL')->get()->groupBy('kategori');
        }

        $dataMatrix['BP-2'] = $this->calculateGrandTotal($dataMatrix, $estates, $historicalYears);

        $jenisPerawatan = $this->jenisPerawatan;
        $kategoriPruning = $this->kategoriPruning;
        $jenisPupuk = $this->jenisPupuk;
        $kriteriaMutu = $this->kriteriaMutu;
        $kategoriPekerja = $this->kategoriPekerja;

        return view('reports.monthly_dashboard', compact(
            'bulan', 'tahun', 'estates', 'dataMatrix', 'historicalYears', 'jenisPerawatan', 'kategoriPruning', 'jenisPupuk', 'kriteriaMutu', 'kategoriPekerja'
        ));
    }

    private function calculateGrandTotal($matrix, $estates, $historicalYears)
    {
        $total = [
            'produksi' => [
                'current' => [], 
                'next' => [
                    'rkb' => (object)['tonase'=>0, 'janjang'=>0]
                ]
            ], 
            'histori' => [], 
            'biaya' => [
                'real' => (object)['cost_panen' => 0, 'cost_rawat' => 0, 'cost_kantor' => 0, 'cost_teknik' => 0, 'cost_pks' => 0, 'pdo_bi' => 0, 'pdo_sbi' => 0],
                'budget_year' => (object)['bgt_cost_palm_produk' => 0, 'bgt_cost_palm_oil' => 0] 
            ],
            'biaya_sd_bln' => [
                'real' => (object)['cost_panen' => 0, 'cost_rawat' => 0, 'cost_kantor' => 0, 'cost_teknik' => 0, 'cost_pks' => 0],
                'budget' => (object)['cost_panen' => 0, 'cost_rawat' => 0, 'cost_kantor' => 0, 'cost_teknik' => 0, 'cost_pks' => 0]
            ],
            'biaya_pdo' => [
                'bi' => 0,
                'sbi' => 0
            ],
            'rotasi_pruning' => []
        ];

        foreach($this->kategoriPruning as $kp) { 
            $total['rotasi_pruning'][$kp] = (object)['jml_blok' => 0, 'luas_ha' => 0]; 
        }

        $kategoriProd = ['rkb', 'real', 'budget', 'sensus'];
        foreach($kategoriProd as $k) { 
            $total['produksi']['current'][$k] = (object)[
                'tonase' => 0, 'janjang' => 0, 'hs_ha' => 0, 'hs_pokok' => 0,
                'kunjungan' => 0, 'ha_hk' => 0, 'kg_hk' => 0,
                'ton_cpo' => 0, 'ton_ker' => 0, 'ton_pko' => 0,
                'ha_cavel_real' => 0
            ]; 
        }
        
        $historiKeys = ['bgt_1_thn', 'bgt_sd_bln', 'sns_sd_bln'];
        foreach($historicalYears as $yr) { 
            $historiKeys[] = 'real_sd_'.$yr; 
        }
        foreach($historiKeys as $hk) { 
            $total['histori'][$hk] = (object)['tonase' => 0, 'janjang' => 0, 'ton_cpo' => 0, 'ton_ker' => 0, 'ton_pko' => 0]; 
        }

        $sumBgtProdRate = 0; 
        $sumBgtOilRate = 0; 
        $countBgt = 0;

        foreach ($estates as $estate) {
            $kode = $estate->kode;
            
            $bgtRecord = $matrix[$kode]['biaya']['budget_year'] ?? null;
            $costPalmProdukBgt = $bgtRecord->bgt_cost_palm_produk ?? 0;
            $costPalmOilBgt = $bgtRecord->bgt_cost_palm_oil ?? 0;
            
            if ($costPalmProdukBgt > 0 || $costPalmOilBgt > 0) {
                $sumBgtProdRate += $costPalmProdukBgt;
                $sumBgtOilRate += $costPalmOilBgt;
                $countBgt++;
            }

            foreach($kategoriProd as $k) {
                if(isset($matrix[$kode]['produksi']['current'][$k]) && $matrix[$kode]['produksi']['current'][$k] !== null) {
                    $item = $matrix[$kode]['produksi']['current'][$k];
                    $total['produksi']['current'][$k]->tonase += $item->tonase ?? 0;
                    $total['produksi']['current'][$k]->janjang += $item->janjang ?? 0;
                    $total['produksi']['current'][$k]->hs_ha += $item->hs_ha ?? 0;
                    $total['produksi']['current'][$k]->hs_pokok += $item->hs_pokok ?? 0;
                    $total['produksi']['current'][$k]->ha_cavel_real += $item->ha_cavel_real ?? 0;
                }
            }
            
            if(isset($matrix[$kode]['produksi']['current']['real']) && $matrix[$kode]['produksi']['current']['real'] !== null) {
                $realData = $matrix[$kode]['produksi']['current']['real'];
                $total['produksi']['current']['real']->kunjungan += $realData->kunjungan ?? 0;
                $total['produksi']['current']['real']->ha_hk += $realData->ha_hk ?? 0;
                $total['produksi']['current']['real']->kg_hk += $realData->kg_hk ?? 0;
            }
            
            if(isset($matrix[$kode]['produksi']['next']['rkb']) && $matrix[$kode]['produksi']['next']['rkb'] !== null) {
                $nextData = $matrix[$kode]['produksi']['next']['rkb'];
                $total['produksi']['next']['rkb']->tonase += $nextData->tonase ?? 0;
                $total['produksi']['next']['rkb']->janjang += $nextData->janjang ?? 0;
            }

            foreach($historiKeys as $hk) {
                if(isset($matrix[$kode]['histori'][$hk]) && $matrix[$kode]['histori'][$hk] !== null) {
                    $total['histori'][$hk]->tonase += $matrix[$kode]['histori'][$hk]->tonase ?? 0;
                    $total['histori'][$hk]->janjang += $matrix[$kode]['histori'][$hk]->janjang ?? 0;
                    $total['histori'][$hk]->ton_cpo += $matrix[$kode]['histori'][$hk]->ton_cpo ?? 0;
                    $total['histori'][$hk]->ton_ker += $matrix[$kode]['histori'][$hk]->ton_ker ?? 0;
                    $total['histori'][$hk]->ton_pko += $matrix[$kode]['histori'][$hk]->ton_pko ?? 0;
                }
            }
            
            $biayaTipe = ['real', 'budget'];
            foreach($biayaTipe as $bt) {
                if(isset($matrix[$kode]['biaya'][$bt]) && $matrix[$kode]['biaya'][$bt] !== null) {
                    $total['biaya'][$bt]->cost_panen += $matrix[$kode]['biaya'][$bt]->cost_panen ?? 0;
                    $total['biaya'][$bt]->cost_rawat += $matrix[$kode]['biaya'][$bt]->cost_rawat ?? 0;
                    $total['biaya'][$bt]->cost_kantor += $matrix[$kode]['biaya'][$bt]->cost_kantor ?? 0;
                    $total['biaya'][$bt]->cost_teknik += $matrix[$kode]['biaya'][$bt]->cost_teknik ?? 0;
                    $total['biaya'][$bt]->cost_pks += $matrix[$kode]['biaya'][$bt]->cost_pks ?? 0;
                }
                if(isset($matrix[$kode]['biaya_sd_bln'][$bt]) && $matrix[$kode]['biaya_sd_bln'][$bt] !== null) {
                    $total['biaya_sd_bln'][$bt]->cost_panen += $matrix[$kode]['biaya_sd_bln'][$bt]->cost_panen ?? 0;
                    $total['biaya_sd_bln'][$bt]->cost_rawat += $matrix[$kode]['biaya_sd_bln'][$bt]->cost_rawat ?? 0;
                    $total['biaya_sd_bln'][$bt]->cost_kantor += $matrix[$kode]['biaya_sd_bln'][$bt]->cost_kantor ?? 0;
                    $total['biaya_sd_bln'][$bt]->cost_teknik += $matrix[$kode]['biaya_sd_bln'][$bt]->cost_teknik ?? 0;
                    $total['biaya_sd_bln'][$bt]->cost_pks += $matrix[$kode]['biaya_sd_bln'][$bt]->cost_pks ?? 0;
                }
            }

            $total['biaya_pdo']['bi'] += $matrix[$kode]['biaya_pdo']['bi'] ?? 0;
            $total['biaya_pdo']['sbi'] += $matrix[$kode]['biaya_pdo']['sbi'] ?? 0;

            foreach($this->kategoriPruning as $kp) {
                if(isset($matrix[$kode]['rotasi_pruning'][$kp])) {
                    $total['rotasi_pruning'][$kp]->jml_blok += $matrix[$kode]['rotasi_pruning'][$kp]->jml_blok ?? 0;
                    $total['rotasi_pruning'][$kp]->luas_ha += $matrix[$kode]['rotasi_pruning'][$kp]->luas_ha ?? 0;
                }
            }
        }

        $total['biaya']['budget_year']->bgt_cost_palm_produk = $countBgt > 0 ? $sumBgtProdRate / $countBgt : 0;
        $total['biaya']['budget_year']->bgt_cost_palm_oil = $countBgt > 0 ? $sumBgtOilRate / $countBgt : 0;

        return $total;
    }

    public function create()
    {
        $estates = Estate::where('kode', '!=', 'BP-2')->get();
        $jenisPerawatan = $this->jenisPerawatan;
        $kategoriPruning = $this->kategoriPruning;
        $jenisPupuk = $this->jenisPupuk;
        $kriteriaMutu = $this->kriteriaMutu;
        
        $subKategoriPekerja = [
            'Umur' => ['< 25', '25 - 40', '40 - 50', '> 50'],
            'Status Keluarga' => ['KK', 'Lj'],
            'Masa Kerja' => ['<= 1bln', '2-3Bln', '> 3Bln'],
            'Mutasi' => ['Masuk (Bi)', 'Masuk (Sbi)', 'Keluar (Bi)', 'Keluar (Sbi)'],
            'HKNE' => ['Sakit', 'Cuti', 'Mangkir', 'Ijin'],
            'Jam Kerja' => ['Tersedia', 'Pagi', 'Siang', 'Sore'],
            'Kelas Pemanen' => ['A', 'B', 'C', 'D']
        ];
        
        return view('reports.input_data', compact('estates', 'jenisPerawatan', 'kategoriPruning', 'jenisPupuk', 'kriteriaMutu', 'subKategoriPekerja'));
    }

    public function store(Request $request)
    {
        $periode = Carbon::createFromDate($request->tahun, $request->bulan, 1)->format('Y-m-d');
        $matchAttr = ['estate_id' => $request->estate_id, 'periode' => $periode, 'tipe' => $request->tipe];
        
        if ($request->has('produksi')) {
            $dataProd = [];
            $fields = ['tonase', 'janjang', 'hk_panen', 'luas_cavel', 'hs_ha', 'hs_pokok', 'kunjungan', 'ha_hk', 'kg_hk', 'ton_cpo', 'ton_ker', 'ton_pko', 'ha_cavel_real', 'hke'];
            foreach ($fields as $field) {
                if (isset($request->produksi[$field]) && $request->produksi[$field] !== '') {
                    $dataProd[$field] = $request->produksi[$field];
                }
            }
            if (!empty($dataProd)) { 
                Production::updateOrCreate($matchAttr, $dataProd); 
            }
        }

        if ($request->has('biaya')) {
            $dataBiaya = [];
            // pdo_sbi DIHAPUS DARI ARRAY FIELDS
            $fields = ['cost_panen', 'cost_rawat', 'cost_kantor', 'cost_teknik', 'cost_pks', 'bgt_cost_palm_produk', 'bgt_cost_palm_oil', 'pdo_bi'];
            foreach ($fields as $field) {
                if (isset($request->biaya[$field]) && $request->biaya[$field] !== '') {
                    $dataBiaya[$field] = $request->biaya[$field];
                }
            }
            if (!empty($dataBiaya)) { 
                OperationalCost::updateOrCreate($matchAttr, $dataBiaya); 
            }
        }

        if ($request->has('rawat')) {
            foreach ($request->rawat as $jenis => $val) {
                $dataRawat = [];
                // PENAMBAHAN 'cost_ha' KE DALAM ARRAY DI BAWAH INI
                foreach (['luas_ha', 'biaya_upah', 'jml_blok', 'cost_ha'] as $field) {
                    if (isset($val[$field]) && $val[$field] !== '') { 
                        $dataRawat[$field] = $val[$field]; 
                    }
                }
                if (!empty($dataRawat)) {
                    Upkeep::updateOrCreate(array_merge($matchAttr, ['jenis_pekerjaan' => $jenis]), $dataRawat);
                }
            }
        }

        if ($request->has('pupuk')) {
            foreach ($request->pupuk as $jenis => $val) {
                $dataPupuk = [];
                foreach (['jumlah_kg', 'biaya'] as $field) {
                    if (isset($val[$field]) && $val[$field] !== '') { 
                        $dataPupuk[$field] = $val[$field]; 
                    }
                }
                if (!empty($dataPupuk)) {
                    Fertilizer::updateOrCreate(array_merge($matchAttr, ['jenis_pupuk' => $jenis]), $dataPupuk);
                }
            }
        }

        if ($request->has('mutu')) {
            foreach ($request->mutu as $kriteria => $val) {
                if (isset($val['persentase']) && $val['persentase'] !== '') {
                    HarvestQuality::updateOrCreate(array_merge($matchAttr, ['kriteria' => $kriteria]), ['persentase' => $val['persentase']]);
                }
            }
        }

        if ($request->has('pekerja')) {
            foreach ($request->pekerja as $kategori => $subs) {
                foreach ($subs as $subKategori => $val) {
                    $dataPekerja = [];
                    foreach (['jumlah_tk', 'persentase'] as $field) {
                        if (isset($val[$field]) && $val[$field] !== '') { 
                            $dataPekerja[$field] = $val[$field]; 
                        }
                    }
                    if (!empty($dataPekerja)) {
                        WorkerPerformance::updateOrCreate(array_merge($matchAttr, ['kategori' => $kategori, 'sub_kategori' => $subKategori]), $dataPekerja);
                    }
                }
            }
        }

        return redirect('/input-data')->with('success', 'Seluruh data operasional bulan ' . $request->bulan . '/' . $request->tahun . ' berhasil disimpan!');
    }

    public function importExcel(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new LaporanImport, $request->file('file_excel'));
            return redirect('/input-data')->with('success', 'Data Excel berhasil diimport dan masuk ke dalam database!');
        } catch (\Exception $e) {
            return redirect('/input-data')->with('error', 'Gagal import. Detail: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new LaporanTemplateExport, 'Template_Data_Operasional.xlsx');
    }

    public function exportData(Request $request)
    {
        $bulan = $request->input('bulan', date('n'));
        $tahun = $request->input('tahun', date('Y'));
        
        $fileName = 'Data_Operasional_Bulan_' . $bulan . '_Tahun_' . $tahun . '.xlsx';
        return Excel::download(new LaporanDataExport($bulan, $tahun), $fileName);
    }
}
