<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Estate;
use App\Models\Upkeep;
use Carbon\Carbon;

class DataPerawatanSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $bulan; protected $tahun;
    public function __construct($bulan, $tahun) { $this->bulan = $bulan; $this->tahun = $tahun; }

    public function headings(): array {
        return ['kode_pt', 'tipe_data', 'bulan', 'tahun', 'rwt_piringan_manual_ha', 'rwt_piringan_manual_blok', 'rwt_piringan_manual_cost_ha', 'ppt_chemist_ha', 'ppt_chemist_blok', 'ppt_chemist_cost_ha', 'rwt_gawangan_manual_ha', 'rwt_gawangan_manual_blok', 'rwt_gawangan_manual_cost_ha', 'rwt_gawangan_chemist_ha', 'rwt_gawangan_chemist_blok', 'rwt_gawangan_chemist_cost_ha', 'pruning_ha', 'pruning_blok', 'pruning_cost_ha', 'pruning_kurang_6_bln_ha', 'pruning_kurang_6_bln_blok', 'pruning_kurang_6_bln_cost_ha', 'pruning_6_9_bln_ha', 'pruning_6_9_bln_blok', 'pruning_6_9_bln_cost_ha', 'pruning_9_12_bln_ha', 'pruning_9_12_bln_blok', 'pruning_9_12_bln_cost_ha', 'pruning_lebih_12_bln_ha', 'pruning_lebih_12_bln_blok', 'pruning_lebih_12_bln_cost_ha'];
    }

    public function collection() {
        $periode = Carbon::createFromDate($this->tahun, $this->bulan, 1)->format('Y-m-d');
        $estates = Estate::where('kode', '!=', 'BP-2')->get();
        $tipes = ['REAL', 'RKB', 'BUDGET', 'SENSUS'];
        $data = [];

        $allPerawatan = ['Rwt Piringan Manual' => 'rwt_piringan_manual', 'PPT Chemist' => 'ppt_chemist', 'Rwt Gawangan Manual' => 'rwt_gawangan_manual', 'Rwt Gawangan Chemist' => 'rwt_gawangan_chemist', 'Pruning' => 'pruning', 'Pruning <= 6 Bln' => 'pruning_kurang_6_bln', 'Pruning 6.01-9 Bln' => 'pruning_6_9_bln', 'Pruning 9.01-12 Bln' => 'pruning_9_12_bln', 'Pruning > 12 Bln' => 'pruning_lebih_12_bln'];

        foreach ($estates as $estate) {
            foreach ($tipes as $tipe) {
                $upkeeps = Upkeep::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->get()->keyBy('jenis_pekerjaan');
                if($upkeeps->count() > 0) {
                    $row = ['kode_pt' => $estate->kode, 'tipe_data' => $tipe, 'bulan' => $this->bulan, 'tahun' => $this->tahun];
                    foreach($allPerawatan as $oriName => $slugName) {
                        $row[$slugName . '_ha'] = $upkeeps[$oriName]->luas_ha ?? null;
                        $row[$slugName . '_blok'] = $upkeeps[$oriName]->jml_blok ?? null;
                        $row[$slugName . '_cost_ha'] = $upkeeps[$oriName]->cost_ha ?? null;
                    }
                    $data[] = $row;
                }
            }
        }
        return collect($data);
    }
    public function title(): string { return '3. Perawatan Kebun'; }
}
