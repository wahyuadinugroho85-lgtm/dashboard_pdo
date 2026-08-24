<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Estate;
use App\Models\OperationalCost;
use Carbon\Carbon;

class DataBiayaSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $bulan; protected $tahun;
    public function __construct($bulan, $tahun) { $this->bulan = $bulan; $this->tahun = $tahun; }

    public function headings(): array {
        return ['kode_pt', 'tipe_data', 'bulan', 'tahun', 'cost_panen', 'cost_rawat', 'cost_kantor', 'cost_teknik', 'cost_pks', 'pdo_bi', 'bgt_cost_palm_produk', 'bgt_cost_palm_oil'];
    }

    public function collection() {
        $periode = Carbon::createFromDate($this->tahun, $this->bulan, 1)->format('Y-m-d');
        $estates = Estate::where('kode', '!=', 'BP-2')->get();
        $tipes = ['REAL', 'RKB', 'BUDGET', 'SENSUS'];
        $data = [];

        foreach ($estates as $estate) {
            foreach ($tipes as $tipe) {
                $cost = OperationalCost::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->first();
                if($cost) {
                    $data[] = [
                        'kode_pt' => $estate->kode, 'tipe_data' => $tipe, 'bulan' => $this->bulan, 'tahun' => $this->tahun,
                        'cost_panen' => $cost->cost_panen ?? null, 'cost_rawat' => $cost->cost_rawat ?? null, 'cost_kantor' => $cost->cost_kantor ?? null,
                        'cost_teknik' => $cost->cost_teknik ?? null, 'cost_pks' => $cost->cost_pks ?? null, 'pdo_bi' => $cost->pdo_bi ?? null,
                        'bgt_cost_palm_produk' => $cost->bgt_cost_palm_produk ?? null, 'bgt_cost_palm_oil' => $cost->bgt_cost_palm_oil ?? null,
                    ];
                }
            }
        }
        return collect($data);
    }
    public function title(): string { return '2. Biaya Operasional'; }
}
