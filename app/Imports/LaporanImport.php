<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Estate;
use App\Models\Production;
use App\Models\Upkeep;
use App\Models\Fertilizer;
use App\Models\WorkerPerformance;
use App\Models\HarvestQuality;
use App\Models\OperationalCost;
use Carbon\Carbon;

class LaporanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Validasi baris kosong
            if (!isset($row['kode_pt']) || !isset($row['tipe_data']) || !isset($row['bulan']) || !isset($row['tahun'])) {
                continue;
            }

            $estate = Estate::where('kode', $row['kode_pt'])->first();
            if (!$estate) continue;

            $periode = Carbon::createFromDate($row['tahun'], $row['bulan'], 1)->format('Y-m-d');
            $matchAttr = ['estate_id' => $estate->id, 'periode' => $periode, 'tipe' => strtoupper($row['tipe_data'])];

            // 1. Production
            Production::updateOrCreate($matchAttr, [
                'tonase' => $row['tonase'] ?? null,
                'janjang' => $row['janjang'] ?? null,
                'hs_ha' => $row['hs_ha'] ?? null,
                'hs_pokok' => $row['hs_pokok'] ?? null,
                'ha_cavel_real' => $row['ha_cavel_real'] ?? null,
                'hk_panen' => $row['hk_panen'] ?? null,
                'kunjungan' => $row['kunjungan'] ?? null,
                'ha_hk' => $row['ha_hk'] ?? null,
                'hke' => $row['hke'] ?? null,
                'ton_cpo' => $row['ton_cpo'] ?? null,
                'ton_ker' => $row['ton_ker'] ?? null,
                'ton_pko' => $row['ton_pko'] ?? null,
            ]);

            // 2. Operational Cost
            OperationalCost::updateOrCreate($matchAttr, [
                'cost_panen' => $row['cost_panen'] ?? null,
                'cost_rawat' => $row['cost_rawat'] ?? null,
                'cost_kantor' => $row['cost_kantor'] ?? null,
                'cost_teknik' => $row['cost_teknik'] ?? null,
                'cost_pks' => $row['cost_pks'] ?? null,
                'pdo_bi' => $row['pdo_bi'] ?? null,
                'bgt_cost_palm_produk' => $row['bgt_cost_palm_produk'] ?? null,
                'bgt_cost_palm_oil' => $row['bgt_cost_palm_oil'] ?? null,
            ]);

            // 3. Upkeep / Perawatan
            $upkeeps = [
                'Rwt Piringan Manual' => ['ha' => 'rwt_piringan_manual_ha', 'blok' => 'rwt_piringan_manual_blok', 'cost' => 'rwt_piringan_manual_cost_ha'],
                'PPT Chemist' => ['ha' => 'ppt_chemist_ha', 'blok' => 'ppt_chemist_blok', 'cost' => 'ppt_chemist_cost_ha'],
                'Rwt Gawangan Manual' => ['ha' => 'rwt_gawangan_manual_ha', 'blok' => 'rwt_gawangan_manual_blok', 'cost' => 'rwt_gawangan_manual_cost_ha'],
                'Rwt Gawangan Chemist' => ['ha' => 'rwt_gawangan_chemist_ha', 'blok' => 'rwt_gawangan_chemist_blok', 'cost' => 'rwt_gawangan_chemist_cost_ha'],
                'Pruning' => ['ha' => 'pruning_ha', 'blok' => 'pruning_blok', 'cost' => 'pruning_cost_ha'],
                'Pruning <= 6 Bln' => ['ha' => 'pruning_kurang_6_bln_ha', 'blok' => 'pruning_kurang_6_bln_blok', 'cost' => 'pruning_kurang_6_bln_cost_ha'],
                'Pruning 6.01-9 Bln' => ['ha' => 'pruning_6_9_bln_ha', 'blok' => 'pruning_6_9_bln_blok', 'cost' => 'pruning_6_9_bln_cost_ha'],
                'Pruning 9.01-12 Bln' => ['ha' => 'pruning_9_12_bln_ha', 'blok' => 'pruning_9_12_bln_blok', 'cost' => 'pruning_9_12_bln_cost_ha'],
                'Pruning > 12 Bln' => ['ha' => 'pruning_lebih_12_bln_ha', 'blok' => 'pruning_lebih_12_bln_blok', 'cost' => 'pruning_lebih_12_bln_cost_ha'],
            ];

            foreach($upkeeps as $nama => $cols) {
                if(isset($row[$cols['ha']]) || isset($row[$cols['blok']]) || isset($row[$cols['cost']])) {
                    Upkeep::updateOrCreate(array_merge($matchAttr, ['jenis_pekerjaan' => $nama]), [
                        'luas_ha' => $row[$cols['ha']] ?? null,
                        'jml_blok' => $row[$cols['blok']] ?? null,
                        'cost_ha' => $row[$cols['cost']] ?? null,
                    ]);
                }
            }

            // 4. Fertilizer
            $ferts = [
                'Dolomite' => 'pupuk_dolomite_kg',
                'Kieserite' => 'pupuk_kieserite_kg',
                'Kaptan' => 'pupuk_kaptan_kg',
                'TSP / RP' => 'pupuk_tsp_kg', // Harus match dgn Template
                'Urea' => 'pupuk_urea_kg',
                'MOP' => 'pupuk_mop_kg',
                'Mikro-Mg' => 'pupuk_mikro_kg',
            ];
            foreach($ferts as $nama => $col) {
                if(isset($row[$col])) {
                    Fertilizer::updateOrCreate(array_merge($matchAttr, ['jenis_pupuk' => $nama]), ['jumlah_kg' => $row[$col]]);
                }
            }

            // 5. Harvest Quality
            $quals = [
                'Unripe' => 'mutu_unripe',
                'Ripe' => 'mutu_ripe',
                'Over Ripe' => 'mutu_over_ripe',
                'Empty Bunch' => 'mutu_empty_bunch',
                'Abnormal' => 'mutu_abnormal',
            ];
            foreach($quals as $nama => $col) {
                if(isset($row[$col])) {
                    HarvestQuality::updateOrCreate(array_merge($matchAttr, ['kriteria' => $nama]), ['persentase' => $row[$col]]);
                }
            }

            // 6. Worker Performance (Standard)
            $workers = [
                'Umur' => ['< 25' => 'tk_umur_kurang_25', '25 - 40' => 'tk_umur_25_40', '40 - 50' => 'tk_umur_40_50', '> 50' => 'tk_umur_lebih_50'],
                'Status Keluarga' => ['KK' => 'tk_status_kk', 'Lj' => 'tk_status_lj'],
                'Masa Kerja' => ['<= 1bln' => 'tk_masa_kurang_1bln', '2-3Bln' => 'tk_masa_2_3bln', '> 3Bln' => 'tk_masa_lebih_3bln'],
                'Mutasi' => ['Masuk (Bi)' => 'tk_mutasi_masuk_bi', 'Masuk (Sbi)' => 'tk_mutasi_masuk_sbi', 'Keluar (Bi)' => 'tk_mutasi_keluar_bi', 'Keluar (Sbi)' => 'tk_mutasi_keluar_sbi'],
                'HKNE' => ['Sakit' => 'tk_hkne_sakit', 'Cuti' => 'tk_hkne_cuti', 'Mangkir' => 'tk_hkne_mangkir', 'Ijin' => 'tk_hkne_ijin'],
                'Jam Kerja' => ['Tersedia' => 'tk_jam_tersedia', 'Pagi' => 'tk_jam_pagi', 'Siang' => 'tk_jam_siang', 'Sore' => 'tk_jam_sore'],
            ];

            foreach($workers as $kategori => $subs) {
                foreach($subs as $sub => $col) {
                    if(isset($row[$col])) {
                        WorkerPerformance::updateOrCreate(array_merge($matchAttr, ['kategori' => $kategori, 'sub_kategori' => $sub]), ['jumlah_tk' => $row[$col]]);
                    }
                }
            }
            
            // 7. Worker Performance (Kelas Pemanen dgn Avr)
            $pemanen = [
                'A' => ['tk' => 'tk_kelas_a', 'avr' => 'tk_kelas_a_avr'],
                'B' => ['tk' => 'tk_kelas_b', 'avr' => 'tk_kelas_b_avr'],
                'C' => ['tk' => 'tk_kelas_c', 'avr' => 'tk_kelas_c_avr'],
                'D' => ['tk' => 'tk_kelas_d', 'avr' => 'tk_kelas_d_avr'],
            ];
            foreach($pemanen as $kelas => $cols) {
                if(isset($row[$cols['tk']]) || isset($row[$cols['avr']])) {
                    WorkerPerformance::updateOrCreate(array_merge($matchAttr, ['kategori' => 'Kelas Pemanen', 'sub_kategori' => $kelas]), [
                        'jumlah_tk' => $row[$cols['tk']] ?? null,
                        'avr_bln' => $row[$cols['avr']] ?? null,
                    ]);
                }
            }
        }
    }
}