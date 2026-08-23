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

            // 1. Production (Hanya memproses yang ada isinya agar tidak Error NULL)
            $dataProd = [];
            $prodFields = ['tonase', 'janjang', 'hs_ha', 'hs_pokok', 'ha_cavel_real', 'hk_panen', 'kunjungan', 'ha_hk', 'hke', 'ton_cpo', 'ton_ker', 'ton_pko'];
            foreach ($prodFields as $field) {
                if (isset($row[$field]) && trim($row[$field]) !== '') {
                    $dataProd[$field] = $row[$field];
                }
            }
            if (!empty($dataProd)) {
                Production::updateOrCreate($matchAttr, $dataProd);
            }

            // 2. Operational Cost
            $dataBiaya = [];
            $biayaFields = ['cost_panen', 'cost_rawat', 'cost_kantor', 'cost_teknik', 'cost_pks', 'pdo_bi', 'bgt_cost_palm_produk', 'bgt_cost_palm_oil'];
            foreach ($biayaFields as $field) {
                if (isset($row[$field]) && trim($row[$field]) !== '') {
                    $dataBiaya[$field] = $row[$field];
                }
            }
            if (!empty($dataBiaya)) {
                OperationalCost::updateOrCreate($matchAttr, $dataBiaya);
            }

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
                $dataRawat = [];
                if (isset($row[$cols['ha']]) && trim($row[$cols['ha']]) !== '') $dataRawat['luas_ha'] = $row[$cols['ha']];
                if (isset($row[$cols['blok']]) && trim($row[$cols['blok']]) !== '') $dataRawat['jml_blok'] = $row[$cols['blok']];
                if (isset($row[$cols['cost']]) && trim($row[$cols['cost']]) !== '') $dataRawat['cost_ha'] = $row[$cols['cost']];
                
                if (!empty($dataRawat)) {
                    Upkeep::updateOrCreate(array_merge($matchAttr, ['jenis_pekerjaan' => $nama]), $dataRawat);
                }
            }

            // 4. Fertilizer
            $ferts = [
                'Dolomite' => 'pupuk_dolomite_kg',
                'Kieserite' => 'pupuk_kieserite_kg',
                'Kaptan' => 'pupuk_kaptan_kg',
                'TSP / RP' => 'pupuk_tsp_kg',
                'Urea' => 'pupuk_urea_kg',
                'MOP' => 'pupuk_mop_kg',
                'Mikro-Mg' => 'pupuk_mikro_kg',
            ];
            foreach($ferts as $nama => $col) {
                if(isset($row[$col]) && trim($row[$col]) !== '') {
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
                if(isset($row[$col]) && trim($row[$col]) !== '') {
                    HarvestQuality::updateOrCreate(array_merge($matchAttr, ['kriteria' => $nama]), ['persentase' => $row[$col]]);
                }
            }

            // 6. Worker Performance (Standard - Hanya input "Bi" dan "Kerja")
            $workers = [
                'Umur' => ['< 25' => 'tk_umur_kurang_25', '25 - 40' => 'tk_umur_25_40', '40 - 50' => 'tk_umur_40_50', '> 50' => 'tk_umur_lebih_50'],
                'Status Keluarga' => ['KK' => 'tk_status_kk', 'Lj' => 'tk_status_lj'],
                'Masa Kerja' => ['<= 1bln' => 'tk_masa_kurang_1bln', '2-3Bln' => 'tk_masa_2_3bln', '> 3Bln' => 'tk_masa_lebih_3bln'],
                'Mutasi' => ['Masuk (Bi)' => 'tk_mutasi_masuk_bi', 'Keluar (Bi)' => 'tk_mutasi_keluar_bi'], // Sbi tidak diimport karena otomatis
                'HKNE' => ['Kerja' => 'tk_hkne_kerja', 'Sakit' => 'tk_hkne_sakit', 'Cuti' => 'tk_hkne_cuti', 'Mangkir' => 'tk_hkne_mangkir', 'Ijin' => 'tk_hkne_ijin'],
                'Jam Kerja' => ['Tersedia' => 'tk_jam_tersedia', 'Pagi' => 'tk_jam_pagi', 'Siang' => 'tk_jam_siang', 'Sore' => 'tk_jam_sore'],
            ];

            foreach($workers as $kategori => $subs) {
                foreach($subs as $sub => $col) {
                    if(isset($row[$col]) && trim($row[$col]) !== '') {
                        WorkerPerformance::updateOrCreate(array_merge($matchAttr, ['kategori' => $kategori, 'sub_kategori' => $sub]), ['jumlah_tk' => $row[$col]]);
                    }
                }
            }
            
            // 7. Mutasi RKK dengan Persentase (BARU)
            $mutasiPct = [
                '% Keluar Bi' => 'tk_mutasi_pct_keluar_bi',
                '% Keluar Sbi' => 'tk_mutasi_pct_keluar_sbi',
            ];
            foreach($mutasiPct as $sub => $col) {
                if(isset($row[$col]) && trim($row[$col]) !== '') {
                    WorkerPerformance::updateOrCreate(array_merge($matchAttr, ['kategori' => 'Mutasi', 'sub_kategori' => $sub]), ['persentase' => $row[$col]]);
                }
            }
            
            // 8. Worker Performance (Kelas Pemanen dgn Avr)
            $pemanen = [
                'A' => ['tk' => 'tk_kelas_a', 'avr' => 'tk_kelas_a_avr'],
                'B' => ['tk' => 'tk_kelas_b', 'avr' => 'tk_kelas_b_avr'],
                'C' => ['tk' => 'tk_kelas_c', 'avr' => 'tk_kelas_c_avr'],
                'D' => ['tk' => 'tk_kelas_d', 'avr' => 'tk_kelas_d_avr'],
            ];
            foreach($pemanen as $kelas => $cols) {
                $dataPemanen = [];
                if(isset($row[$cols['tk']]) && trim($row[$cols['tk']]) !== '') $dataPemanen['jumlah_tk'] = $row[$cols['tk']];
                if(isset($row[$cols['avr']]) && trim($row[$cols['avr']]) !== '') $dataPemanen['avr_bln'] = $row[$cols['avr']];
                
                if(!empty($dataPemanen)) {
                    WorkerPerformance::updateOrCreate(array_merge($matchAttr, ['kategori' => 'Kelas Pemanen', 'sub_kategori' => $kelas]), $dataPemanen);
                }
            }
        }
    }
}
