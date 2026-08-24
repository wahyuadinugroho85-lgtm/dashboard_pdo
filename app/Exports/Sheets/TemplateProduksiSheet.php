<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplateProduksiSheet implements FromArray, WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'kode_pt', 'tipe_data', 'bulan', 'tahun',
            'tonase', 'janjang', 'hk_panen', 'luas_cavel', 'hs_ha', 'hs_pokok', 
            'kunjungan', 'ha_hk', 'kg_hk', 'ton_cpo', 'ton_ker', 'ton_pko', 
            'ha_cavel_real', 'hke'
        ];
    }

    public function array(): array
    {
        return [
            ['H-1', 'REAL', 7, 2026, 145641996, 8537153, 166, 26, 12500, 1500000, 5.10, 3.49, 1688, 30643.5, 6714.1, 2954.2, 28.5, 26]
        ];
    }

    public function title(): string { return '1. Produksi'; }
}
