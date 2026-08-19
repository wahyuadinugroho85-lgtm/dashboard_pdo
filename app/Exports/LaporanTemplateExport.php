<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'kode_pt',
            'tipe_data',
            'bulan',
            'tahun',
            
            // Kolom Produksi
            'tonase',
            'janjang',
            'hk_panen',
            'luas_cavel',
            'hs_ha',
            'hs_pokok',
            'kunjungan',
            'ha_hk',
            'kg_hk',
            'ton_cpo',
            'ton_ker',
            'ton_pko',
            'ha_cavel_real',
            'hke',
            
            // Kolom Biaya Operasional (Rp)
            'cost_panen',
            'cost_rawat',
            'cost_kantor',
            'cost_teknik',
            'cost_pks',
            'pdo_bi',
            'bgt_cost_palm_produk',
            'bgt_cost_palm_oil',
            
            // Kolom Perawatan Kebun (Ha)
            'rwt_piringan_manual_ha',
            'rwt_piringan_manual_blok',
            'rwt_piringan_manual_cost_ha',
            'ppt_chemist_ha',
            'ppt_chemist_blok',
            'ppt_chemist_cost_ha',
            'rwt_gawangan_manual_ha',
            'rwt_gawangan_manual_blok',
            'rwt_gawangan_manual_cost_ha',
            'rwt_gawangan_chemist_ha',
            'rwt_gawangan_chemist_blok',
            'rwt_gawangan_chemist_cost_ha',
            'pruning_ha',
            'pruning_blok',
            'pruning_cost_ha',

            // Rotasi Pruning (Ha, Blok, Cost)
            'pruning_kurang_6_bln_ha',
            'pruning_kurang_6_bln_blok',
            'pruning_kurang_6_bln_cost_ha',
            'pruning_6_9_bln_ha',
            'pruning_6_9_bln_blok',
            'pruning_6_9_bln_cost_ha',
            'pruning_9_12_bln_ha',
            'pruning_9_12_bln_blok',
            'pruning_9_12_bln_cost_ha',
            'pruning_lebih_12_bln_ha',
            'pruning_lebih_12_bln_blok',
            'pruning_lebih_12_bln_cost_ha',
            
            // Kolom Aplikasi Pupuk (Kg / Ton)
            'pupuk_dolomite_kg',
            'pupuk_kieserite_kg',
            'pupuk_kaptan_kg',
            'pupuk_tsp_kg',
            'pupuk_urea_kg',
            'pupuk_mop_kg',
            'pupuk_mikro_kg',

            // Kolom Mutu Ancak (%)
            'mutu_unripe',
            'mutu_ripe',
            'mutu_over_ripe',
            'mutu_empty_bunch',
            'mutu_abnormal',

            // Kolom Kinerja Tenaga Kerja (Jumlah TK)
            'tk_umur_kurang_25',
            'tk_umur_25_40',
            'tk_umur_40_50',
            'tk_umur_lebih_50',
            'tk_status_kk',
            'tk_status_lj',
            'tk_masa_kurang_1bln',
            'tk_masa_2_3bln',
            'tk_masa_lebih_3bln',
            'tk_mutasi_masuk_bi',
            'tk_mutasi_masuk_sbi',
            'tk_mutasi_keluar_bi',
            'tk_mutasi_keluar_sbi',
            'tk_hkne_sakit',
            'tk_hkne_cuti',
            'tk_hkne_mangkir',
            'tk_hkne_ijin',
            'tk_hkne_total_tk', // KOLOM BARU TOTAL TK
            'tk_jam_tersedia',
            'tk_jam_pagi',
            'tk_jam_siang',
            'tk_jam_sore',
            
            // TK Kelas Pemanen (TK & Avr)
            'tk_kelas_a',
            'tk_kelas_a_avr',
            'tk_kelas_b',
            'tk_kelas_b_avr',
            'tk_kelas_c',
            'tk_kelas_c_avr',
            'tk_kelas_d',
            'tk_kelas_d_avr'
        ];
    }

    public function array(): array
    {
        return [
            // Baris dummy data sebagai contoh format pengisian
            [
                'H-1', 'REAL', 7, 2026, 
                145641996, 8537153, 166, 26, 12500, 1500000, 5.10, 3.49, 1688, 30643.5, 6714.1, 2954.2, 28.5, 26,
                5000000, 2000000, 1000000, 1500000, 3000000, 15000, 6500, 8500,
                376.55, 12, 100000, 1349.01, 20, 150000, 384.80, 5, 80000, 32.39, 2, 70000, 1337.85, 25, 200000,
                150.5, 3, 100000, 100.2, 2, 110000, 50.1, 1, 120000, 0, 0, 0,
                71763, 636572, 0, 576668, 840330, 850391, 222949,
                23.42, 58.05, 7.77, 1.52, 9.24,
                15, 45, 20, 5,
                55, 30,
                10, 20, 55,
                2, 1, 0, 1,
                5, 2, 0, 1, 100, // Tambahan Dummy Data untuk Total TK
                80, 60, 15, 5,
                20, 450.5, 30, 300.2, 10, 200.1, 5, 100.5
            ],
        ];
    }
}
