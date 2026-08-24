<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplatePerawatanSheet implements FromArray, WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'kode_pt', 'tipe_data', 'bulan', 'tahun',
            'rwt_piringan_manual_ha', 'rwt_piringan_manual_blok', 'rwt_piringan_manual_cost_ha',
            'ppt_chemist_ha', 'ppt_chemist_blok', 'ppt_chemist_cost_ha',
            'rwt_gawangan_manual_ha', 'rwt_gawangan_manual_blok', 'rwt_gawangan_manual_cost_ha',
            'rwt_gawangan_chemist_ha', 'rwt_gawangan_chemist_blok', 'rwt_gawangan_chemist_cost_ha',
            'pruning_ha', 'pruning_blok', 'pruning_cost_ha',
            'pruning_kurang_6_bln_ha', 'pruning_kurang_6_bln_blok', 'pruning_kurang_6_bln_cost_ha',
            'pruning_6_9_bln_ha', 'pruning_6_9_bln_blok', 'pruning_6_9_bln_cost_ha',
            'pruning_9_12_bln_ha', 'pruning_9_12_bln_blok', 'pruning_9_12_bln_cost_ha',
            'pruning_lebih_12_bln_ha', 'pruning_lebih_12_bln_blok', 'pruning_lebih_12_bln_cost_ha'
        ];
    }

    public function array(): array
    {
        return [
            [
                'H-1', 'REAL', 7, 2026,
                376.55, 12, 100000, 1349.01, 20, 150000, 384.80, 5, 80000, 32.39, 2, 70000, 1337.85, 25, 200000,
                150.5, 3, 100000, 100.2, 2, 110000, 50.1, 1, 120000, 0, 0, 0
            ]
        ];
    }

    public function title(): string { return '3. Perawatan Kebun'; }
}
