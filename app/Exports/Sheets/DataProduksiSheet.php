<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Estate;
use App\Models\Production;
use Carbon\Carbon;

class DataProduksiSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $bulan; protected $tahun;
    public function __construct($bulan, $tahun) { $this->bulan = $bulan; $this->tahun = $tahun; }

    public function headings(): array {
        return ['kode_pt', 'tipe_data', 'bulan', 'tahun', 'tonase', 'janjang', 'hk_panen', 'luas_cavel', 'hs_ha', 'hs_pokok', 'kunjungan', 'ha_hk', 'kg_hk', 'ton_cpo', 'ton_ker', 'ton_pko', 'ha_cavel_real', 'hke'];
    }

    public function collection() {
        $periode = Carbon::createFromDate($this->tahun, $this->bulan, 1)->format('Y-m-d');
        $estates = Estate::where('kode', '!=', 'BP-2')->get();
        $tipes = ['REAL', 'RKB', 'BUDGET', 'SENSUS'];
        $data = [];

        foreach ($estates as $estate) {
            foreach ($tipes as $tipe) {
                $prod = Production::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->first();
                if($prod) {
                    $data[] = [
                        'kode_pt' => $estate->kode, 'tipe_data' => $tipe, 'bulan' => $this->bulan, 'tahun' => $this->tahun,
                        'tonase' => $prod->tonase ?? null, 'janjang' => $prod->janjang ?? null, 'hk_panen' => $prod->hk_panen ?? null,
                        'luas_cavel' => $prod->luas_cavel ?? null, 'hs_ha' => $prod->hs_ha ?? null, 'hs_pokok' => $prod->hs_pokok ?? null,
                        'kunjungan' => $prod->kunjungan ?? null, 'ha_hk' => $prod->ha_hk ?? null, 'kg_hk' => $prod->kg_hk ?? null,
                        'ton_cpo' => $prod->ton_cpo ?? null, 'ton_ker' => $prod->ton_ker ?? null, 'ton_pko' => $prod->ton_pko ?? null,
                        'ha_cavel_real' => $prod->ha_cavel_real ?? null, 'hke' => $prod->hke ?? null,
                    ];
                }
            }
        }
        return collect($data);
    }
    public function title(): string { return '1. Produksi'; }
}
