<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplateBiayaSheet implements FromArray, WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'kode_pt', 'tipe_data', 'bulan', 'tahun',
            'cost_panen', 'cost_rawat', 'cost_kantor', 'cost_teknik', 'cost_pks', 
            'pdo_bi', 'bgt_cost_palm_produk', 'bgt_cost_palm_oil'
        ];
    }

    public function array(): array
    {
        return [
            ['H-1', 'REAL', 7, 2026, 5000000, 2000000, 1000000, 1500000, 3000000, 15000, 6500, 8500]
        ];
    }

    public function title(): string { return '2. Biaya Operasional'; }
}
