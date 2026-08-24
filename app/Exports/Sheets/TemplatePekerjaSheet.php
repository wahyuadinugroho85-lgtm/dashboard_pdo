<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplatePekerjaSheet implements FromArray, WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'kode_pt', 'tipe_data', 'bulan', 'tahun',
            'tk_umur_kurang_25', 'tk_umur_25_40', 'tk_umur_40_50', 'tk_umur_lebih_50',
            'tk_status_kk', 'tk_status_lj',
            'tk_masa_kurang_1bln', 'tk_masa_2_3bln', 'tk_masa_lebih_3bln',
            'tk_mutasi_masuk_bi', 'tk_mutasi_keluar_bi', 'tk_mutasi_pct_keluar_bi', 'tk_mutasi_pct_keluar_sbi',
            'tk_hkne_kerja', 'tk_hkne_sakit', 'tk_hkne_cuti', 'tk_hkne_mangkir', 'tk_hkne_ijin',
            'tk_jam_tersedia', 'tk_jam_pagi', 'tk_jam_siang', 'tk_jam_sore',
            'tk_kelas_a', 'tk_kelas_a_avr', 'tk_kelas_b', 'tk_kelas_b_avr', 'tk_kelas_c', 'tk_kelas_c_avr', 'tk_kelas_d', 'tk_kelas_d_avr'
        ];
    }

    public function array(): array
    {
        return [
            [
                'H-1', 'REAL', 7, 2026,
                15, 45, 20, 5, 55, 30, 10, 20, 55, 2, 0, 8.15, 43.63, 100, 5, 2, 0, 1, 80, 60, 15, 5,
                20, 450.5, 30, 300.2, 10, 200.1, 5, 100.5
            ]
        ];
    }

    public function title(): string { return '5. Tenaga Kerja'; }
}
