<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplatePupukMutuSheet implements FromArray, WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'kode_pt', 'tipe_data', 'bulan', 'tahun',
            'pupuk_dolomite_kg', 'pupuk_kieserite_kg', 'pupuk_kaptan_kg', 'pupuk_tsp_kg', 'pupuk_urea_kg', 'pupuk_mop_kg', 'pupuk_mikro_kg',
            'mutu_unripe', 'mutu_ripe', 'mutu_over_ripe', 'mutu_empty_bunch', 'mutu_abnormal'
        ];
    }

    public function array(): array
    {
        return [
            ['H-1', 'REAL', 7, 2026, 71763, 636572, 0, 576668, 840330, 850391, 222949, 23.42, 58.05, 7.77, 1.52, 9.24]
        ];
    }

    public function title(): string { return '4. Pupuk & Mutu'; }
}
