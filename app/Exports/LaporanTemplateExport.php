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
            'ton_cpo',      // UPDATE DARI OER
            'ton_ker',      // UPDATE DARI KER
            'ton_pko',      // UPDATE DARI PKO
            
            // Kolom Biaya Operasional (Rp)
            'cost_panen',
            'cost_rawat',
            'cost_kantor',
            'cost_teknik',
            'cost_pks',
            
            // Kolom Perawatan Kebun (Ha)
            'rwt_piringan_ha',
            'ppt_chemist_ha',
            'rwt_gawangan_man_ha',
            'rwt_gawangan_chem_ha',
            'pruning_ha',
            
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
            'tk_mutasi_keluar_sbi'
        ];
    }

    public function array(): array
    {
        return [
            // Baris dummy data sebagai contoh format pengisian
            [
                'H-1', 'REAL', 7, 2026, 
                145641996, 8537153, 166, 26, 12500, 1500000, 5.10, 3.49, 1688, 
                30643.5, 6714.1, 2954.2, // UPDATE Data Dummy untuk Ton CPO, KER, PKO
                5000000, 2000000, 1000000, 1500000, 3000000,
                376.55, 1349.01, 384.80, 32.39, 1337.85,
                71763, 636572, 0, 576668, 840330, 850391, 222949,
                23.42, 58.05, 7.77, 1.52, 9.24,
                15, 45, 20, 5,
                55, 30,
                10, 20, 55,
                2, 1, 0, 1
            ],
        ];
    }
}