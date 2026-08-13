<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Estate;
use App\Models\Production;
use App\Models\OperationalCost;
use App\Models\Upkeep;
use App\Models\Fertilizer;
use App\Models\HarvestQuality;
use App\Models\WorkerPerformance;
use Carbon\Carbon;

class LaporanImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Melewati baris jika data identitas kosong
            if (!isset($row['kode_pt']) || !isset($row['tipe_data']) || !isset($row['bulan']) || !isset($row['tahun'])) {
                continue; 
            }

            // Mencari ID Estate berdasarkan kode PT di Excel
            $estate = Estate::where('kode', strtoupper($row['kode_pt']))->first();
            if (!$estate) continue;

            $periode = Carbon::createFromDate($row['tahun'], $row['bulan'], 1)->format('Y-m-d');
            $matchAttr = [
                'estate_id' => $estate->id, 
                'periode' => $periode, 
                'tipe' => strtoupper($row['tipe_data'])
            ];

            // 1. Simpan Data Produksi
            Production::updateOrCreate($matchAttr, [
                'tonase' => $row['tonase'] ?? 0,
                'janjang' => $row['janjang'] ?? 0,
                'hk_panen' => $row['hk_panen'] ?? 0,
                'luas_cavel' => $row['luas_cavel'] ?? 0,
                'hs_ha' => $row['hs_ha'] ?? 0,          
                'hs_pokok' => $row['hs_pokok'] ?? 0,    
                'kunjungan' => $row['kunjungan'] ?? 0,  
                'ha_hk' => $row['ha_hk'] ?? 0,          
                'kg_hk' => $row['kg_hk'] ?? 0,
                'ton_cpo' => $row['ton_cpo'] ?? 0,      // UPDATE
                'ton_ker' => $row['ton_ker'] ?? 0,      // UPDATE
                'ton_pko' => $row['ton_pko'] ?? 0       // UPDATE
            ]);

            // 2. Simpan Data Biaya Operasional
            OperationalCost::updateOrCreate($matchAttr, [
                'cost_panen' => $row['cost_panen'] ?? 0,
                'cost_rawat' => $row['cost_rawat'] ?? 0,
                'cost_kantor' => $row['cost_kantor'] ?? 0,
                'cost_teknik' => $row['cost_teknik'] ?? 0,
                'cost_pks' => $row['cost_pks'] ?? 0,
            ]);

            // 3. Simpan Data Perawatan Kebun
            $rawatMapping = [
                'Rwt Piringan Manual' => 'rwt_piringan_ha',
                'PPT Chemist' => 'ppt_chemist_ha',
                'Rwt Gawangan Manual' => 'rwt_gawangan_man_ha',
                'Rwt Gawangan Chemist' => 'rwt_gawangan_chem_ha',
                'Pruning' => 'pruning_ha',
            ];
            foreach ($rawatMapping as $jenis => $col) {
                if (isset($row[$col]) && $row[$col] > 0) {
                    Upkeep::updateOrCreate(
                        array_merge($matchAttr, ['jenis_pekerjaan' => $jenis]),
                        ['luas_ha' => $row[$col]]
                    );
                }
            }

            // 4. Simpan Data Pemupukan
            $pupukMapping = [
                'Dolomite' => 'pupuk_dolomite_kg',
                'Kieserite' => 'pupuk_kieserite_kg',
                'Kaptan' => 'pupuk_kaptan_kg',
                'TSP / RP' => 'pupuk_tsp_kg',
                'Urea' => 'pupuk_urea_kg',
                'MOP' => 'pupuk_mop_kg',
                'Mikro-Mg' => 'pupuk_mikro_kg',
            ];
            foreach ($pupukMapping as $jenis => $col) {
                if (isset($row[$col]) && $row[$col] > 0) {
                    Fertilizer::updateOrCreate(
                        array_merge($matchAttr, ['jenis_pupuk' => $jenis]),
                        ['jumlah_kg' => $row[$col]]
                    );
                }
            }

            // 5. Simpan Data Kualitas / Mutu
            $mutuMapping = [
                'Unripe' => 'mutu_unripe',
                'Ripe' => 'mutu_ripe',
                'Over Ripe' => 'mutu_over_ripe',
                'Empty Bunch' => 'mutu_empty_bunch',
                'Abnormal' => 'mutu_abnormal',
            ];
            foreach ($mutuMapping as $jenis => $col) {
                if (isset($row[$col]) && $row[$col] > 0) {
                    HarvestQuality::updateOrCreate(
                        array_merge($matchAttr, ['kriteria' => $jenis]),
                        ['persentase' => $row[$col]]
                    );
                }
            }

            // 6. Simpan Data Kinerja Tenaga Kerja
            $tkMap = [
                'Umur' => ['< 25' => 'tk_umur_kurang_25', '25 - 40' => 'tk_umur_25_40', '40 - 50' => 'tk_umur_40_50', '> 50' => 'tk_umur_lebih_50'],
                'Status Keluarga' => ['KK' => 'tk_status_kk', 'Lj' => 'tk_status_lj'],
                'Masa Kerja' => ['<= 1bln' => 'tk_masa_kurang_1bln', '2-3Bln' => 'tk_masa_2_3bln', '> 3Bln' => 'tk_masa_lebih_3bln'],
                'Mutasi' => ['Masuk (Bi)' => 'tk_mutasi_masuk_bi', 'Masuk (Sbi)' => 'tk_mutasi_masuk_sbi', 'Keluar (Bi)' => 'tk_mutasi_keluar_bi', 'Keluar (Sbi)' => 'tk_mutasi_keluar_sbi']
            ];
            foreach ($tkMap as $kategori => $subs) {
                foreach ($subs as $subKat => $col) {
                    if (isset($row[$col]) && $row[$col] > 0) {
                        WorkerPerformance::updateOrCreate(
                            array_merge($matchAttr, ['kategori' => $kategori, 'sub_kategori' => $subKat]), 
                            ['jumlah_tk' => $row[$col]]
                        );
                    }
                }
            }
        }
    }
}