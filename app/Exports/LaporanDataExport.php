<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Estate;
use App\Models\Production;
use App\Models\OperationalCost;
use App\Models\Upkeep;
use App\Models\Fertilizer;
use App\Models\HarvestQuality;
use App\Models\WorkerPerformance;
use Carbon\Carbon;

class LaporanDataExport implements FromCollection, WithHeadings
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function headings(): array
    {
        return [
            'kode_pt', 'tipe_data', 'bulan', 'tahun',
            
            'tonase', 'janjang', 'hk_panen', 'luas_cavel', 'hs_ha', 'hs_pokok', 'kunjungan', 'ha_hk', 'kg_hk', 'ton_cpo', 'ton_ker', 'ton_pko', 'ha_cavel_real', 'hke',
            
            'cost_panen', 'cost_rawat', 'cost_kantor', 'cost_teknik', 'cost_pks', 'pdo_bi', 'bgt_cost_palm_produk', 'bgt_cost_palm_oil',
            
            'rwt_piringan_manual_ha', 'rwt_piringan_manual_blok', 'rwt_piringan_manual_cost_ha',
            'ppt_chemist_ha', 'ppt_chemist_blok', 'ppt_chemist_cost_ha',
            'rwt_gawangan_manual_ha', 'rwt_gawangan_manual_blok', 'rwt_gawangan_manual_cost_ha',
            'rwt_gawangan_chemist_ha', 'rwt_gawangan_chemist_blok', 'rwt_gawangan_chemist_cost_ha',
            'pruning_ha', 'pruning_blok', 'pruning_cost_ha',

            'pruning_kurang_6_bln_ha', 'pruning_kurang_6_bln_blok', 'pruning_kurang_6_bln_cost_ha',
            'pruning_6_9_bln_ha', 'pruning_6_9_bln_blok', 'pruning_6_9_bln_cost_ha',
            'pruning_9_12_bln_ha', 'pruning_9_12_bln_blok', 'pruning_9_12_bln_cost_ha',
            'pruning_lebih_12_bln_ha', 'pruning_lebih_12_bln_blok', 'pruning_lebih_12_bln_cost_ha',
            
            'pupuk_dolomite_kg', 'pupuk_kieserite_kg', 'pupuk_kaptan_kg', 'pupuk_tsp_kg', 'pupuk_urea_kg', 'pupuk_mop_kg', 'pupuk_mikro_kg',
            
            'mutu_unripe', 'mutu_ripe', 'mutu_over_ripe', 'mutu_empty_bunch', 'mutu_abnormal',
            
            'tk_umur_kurang_25', 'tk_umur_25_40', 'tk_umur_40_50', 'tk_umur_lebih_50',
            'tk_status_kk', 'tk_status_lj',
            'tk_masa_kurang_1bln', 'tk_masa_2_3bln', 'tk_masa_lebih_3bln',
            'tk_mutasi_masuk_bi', 'tk_mutasi_masuk_sbi', 'tk_mutasi_keluar_bi', 'tk_mutasi_keluar_sbi',
            'tk_hkne_sakit', 'tk_hkne_cuti', 'tk_hkne_mangkir', 'tk_hkne_ijin',
            'tk_jam_tersedia', 'tk_jam_pagi', 'tk_jam_siang', 'tk_jam_sore',
            
            'tk_kelas_a', 'tk_kelas_a_avr',
            'tk_kelas_b', 'tk_kelas_b_avr',
            'tk_kelas_c', 'tk_kelas_c_avr',
            'tk_kelas_d', 'tk_kelas_d_avr'
        ];
    }

    public function collection()
    {
        $periode = Carbon::createFromDate($this->tahun, $this->bulan, 1)->format('Y-m-d');
        $estates = Estate::where('kode', '!=', 'BP-2')->get();
        $tipes = ['REAL', 'RKB', 'BUDGET', 'SENSUS'];
        
        $data = [];

        $allPerawatan = [
            'Rwt Piringan Manual' => 'rwt_piringan_manual',
            'PPT Chemist' => 'ppt_chemist',
            'Rwt Gawangan Manual' => 'rwt_gawangan_manual',
            'Rwt Gawangan Chemist' => 'rwt_gawangan_chemist',
            'Pruning' => 'pruning',
            'Pruning <= 6 Bln' => 'pruning_kurang_6_bln',
            'Pruning 6.01-9 Bln' => 'pruning_6_9_bln',
            'Pruning 9.01-12 Bln' => 'pruning_9_12_bln',
            'Pruning > 12 Bln' => 'pruning_lebih_12_bln'
        ];

        foreach ($estates as $estate) {
            foreach ($tipes as $tipe) {
                
                $prod = Production::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->first();
                $cost = OperationalCost::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->first();
                $upkeeps = Upkeep::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->get()->keyBy('jenis_pekerjaan');
                $ferts = Fertilizer::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->get()->keyBy('jenis_pupuk');
                $quals = HarvestQuality::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->get()->keyBy('kriteria');
                $workers = WorkerPerformance::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->get();

                $getTk = function($kat, $sub) use ($workers) {
                    $w = $workers->where('kategori', $kat)->where('sub_kategori', $sub)->first();
                    return $w ? $w->jumlah_tk : null;
                };

                $getTkAvr = function($kat, $sub) use ($workers) {
                    $w = $workers->where('kategori', $kat)->where('sub_kategori', $sub)->first();
                    return $w ? $w->avr_bln : null;
                };

                $row = [
                    'kode_pt' => $estate->kode,
                    'tipe_data' => $tipe,
                    'bulan' => $this->bulan,
                    'tahun' => $this->tahun,
                    
                    'tonase' => $prod->tonase ?? null,
                    'janjang' => $prod->janjang ?? null,
                    'hk_panen' => $prod->hk_panen ?? null,
                    'luas_cavel' => $prod->luas_cavel ?? null,
                    'hs_ha' => $prod->hs_ha ?? null,
                    'hs_pokok' => $prod->hs_pokok ?? null,
                    'kunjungan' => $prod->kunjungan ?? null,
                    'ha_hk' => $prod->ha_hk ?? null,
                    'kg_hk' => $prod->kg_hk ?? null,
                    'ton_cpo' => $prod->ton_cpo ?? null,
                    'ton_ker' => $prod->ton_ker ?? null,
                    'ton_pko' => $prod->ton_pko ?? null,
                    'ha_cavel_real' => $prod->ha_cavel_real ?? null,
                    'hke' => $prod->hke ?? null,

                    'cost_panen' => $cost->cost_panen ?? null,
                    'cost_rawat' => $cost->cost_rawat ?? null,
                    'cost_kantor' => $cost->cost_kantor ?? null,
                    'cost_teknik' => $cost->cost_teknik ?? null,
                    'cost_pks' => $cost->cost_pks ?? null,
                    'pdo_bi' => $cost->pdo_bi ?? null,
                    'bgt_cost_palm_produk' => $cost->bgt_cost_palm_produk ?? null,
                    'bgt_cost_palm_oil' => $cost->bgt_cost_palm_oil ?? null,
                ];

                foreach($allPerawatan as $oriName => $slugName) {
                    $row[$slugName . '_ha'] = $upkeeps[$oriName]->luas_ha ?? null;
                    $row[$slugName . '_blok'] = $upkeeps[$oriName]->jml_blok ?? null;
                    $row[$slugName . '_cost_ha'] = $upkeeps[$oriName]->cost_ha ?? null;
                }

                $remainingData = [
                    'pupuk_dolomite_kg' => $ferts['Dolomite']->jumlah_kg ?? null,
                    'pupuk_kieserite_kg' => $ferts['Kieserite']->jumlah_kg ?? null,
                    'pupuk_kaptan_kg' => $ferts['Kaptan']->jumlah_kg ?? null,
                    'pupuk_tsp_kg' => $ferts['TSP / RP']->jumlah_kg ?? null,
                    'pupuk_urea_kg' => $ferts['Urea']->jumlah_kg ?? null,
                    'pupuk_mop_kg' => $ferts['MOP']->jumlah_kg ?? null,
                    'pupuk_mikro_kg' => $ferts['Mikro-Mg']->jumlah_kg ?? null,

                    'mutu_unripe' => $quals['Unripe']->persentase ?? null,
                    'mutu_ripe' => $quals['Ripe']->persentase ?? null,
                    'mutu_over_ripe' => $quals['Over Ripe']->persentase ?? null,
                    'mutu_empty_bunch' => $quals['Empty Bunch']->persentase ?? null,
                    'mutu_abnormal' => $quals['Abnormal']->persentase ?? null,

                    'tk_umur_kurang_25' => $getTk('Umur', '< 25'),
                    'tk_umur_25_40' => $getTk('Umur', '25 - 40'),
                    'tk_umur_40_50' => $getTk('Umur', '40 - 50'),
                    'tk_umur_lebih_50' => $getTk('Umur', '> 50'),

                    'tk_status_kk' => $getTk('Status Keluarga', 'KK'),
                    'tk_status_lj' => $getTk('Status Keluarga', 'Lj'),

                    'tk_masa_kurang_1bln' => $getTk('Masa Kerja', '<= 1bln'),
                    'tk_masa_2_3bln' => $getTk('Masa Kerja', '2-3Bln'),
                    'tk_masa_lebih_3bln' => $getTk('Masa Kerja', '> 3Bln'),

                    'tk_mutasi_masuk_bi' => $getTk('Mutasi', 'Masuk (Bi)'),
                    'tk_mutasi_masuk_sbi' => $getTk('Mutasi', 'Masuk (Sbi)'),
                    'tk_mutasi_keluar_bi' => $getTk('Mutasi', 'Keluar (Bi)'),
                    'tk_mutasi_keluar_sbi' => $getTk('Mutasi', 'Keluar (Sbi)'),

                    'tk_hkne_sakit' => $getTk('HKNE', 'Sakit'),
                    'tk_hkne_cuti' => $getTk('HKNE', 'Cuti'),
                    'tk_hkne_mangkir' => $getTk('HKNE', 'Mangkir'),
                    'tk_hkne_ijin' => $getTk('HKNE', 'Ijin'),

                    'tk_jam_tersedia' => $getTk('Jam Kerja', 'Tersedia'),
                    'tk_jam_pagi' => $getTk('Jam Kerja', 'Pagi'),
                    'tk_jam_siang' => $getTk('Jam Kerja', 'Siang'),
                    'tk_jam_sore' => $getTk('Jam Kerja', 'Sore'),

                    'tk_kelas_a' => $getTk('Kelas Pemanen', 'A'),
                    'tk_kelas_a_avr' => $getTkAvr('Kelas Pemanen', 'A'),
                    'tk_kelas_b' => $getTk('Kelas Pemanen', 'B'),
                    'tk_kelas_b_avr' => $getTkAvr('Kelas Pemanen', 'B'),
                    'tk_kelas_c' => $getTk('Kelas Pemanen', 'C'),
                    'tk_kelas_c_avr' => $getTkAvr('Kelas Pemanen', 'C'),
                    'tk_kelas_d' => $getTk('Kelas Pemanen', 'D'),
                    'tk_kelas_d_avr' => $getTkAvr('Kelas Pemanen', 'D')
                ];

                // Cek apakah minimal ada 1 data yang terisi, agar tidak render row kosong
                $hasData = false;
                foreach (array_slice($row, 4) as $val) {
                    if ($val !== null) { $hasData = true; break; }
                }
                foreach ($remainingData as $val) {
                    if ($val !== null) { $hasData = true; break; }
                }

                if($hasData) {
                    $data[] = array_merge($row, $remainingData);
                }
            }
        }
        
        return collect($data);
    }
}