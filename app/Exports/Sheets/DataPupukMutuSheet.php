<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Estate;
use App\Models\Fertilizer;
use App\Models\HarvestQuality;
use Carbon\Carbon;

class DataPupukMutuSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $bulan; protected $tahun;
    public function __construct($bulan, $tahun) { $this->bulan = $bulan; $this->tahun = $tahun; }

    public function headings(): array {
        return ['kode_pt', 'tipe_data', 'bulan', 'tahun', 'pupuk_dolomite_kg', 'pupuk_kieserite_kg', 'pupuk_kaptan_kg', 'pupuk_tsp_kg', 'pupuk_urea_kg', 'pupuk_mop_kg', 'pupuk_mikro_kg', 'mutu_unripe', 'mutu_ripe', 'mutu_over_ripe', 'mutu_empty_bunch', 'mutu_abnormal'];
    }

    public function collection() {
        $periode = Carbon::createFromDate($this->tahun, $this->bulan, 1)->format('Y-m-d');
        $estates = Estate::where('kode', '!=', 'BP-2')->get();
        $tipes = ['REAL', 'RKB', 'BUDGET', 'SENSUS'];
        $data = [];

        foreach ($estates as $estate) {
            foreach ($tipes as $tipe) {
                $ferts = Fertilizer::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->get()->keyBy('jenis_pupuk');
                $quals = HarvestQuality::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->get()->keyBy('kriteria');
                
                if($ferts->count() > 0 || $quals->count() > 0) {
                    $data[] = [
                        'kode_pt' => $estate->kode, 'tipe_data' => $tipe, 'bulan' => $this->bulan, 'tahun' => $this->tahun,
                        'pupuk_dolomite_kg' => $ferts['Dolomite']->jumlah_kg ?? null, 'pupuk_kieserite_kg' => $ferts['Kieserite']->jumlah_kg ?? null, 'pupuk_kaptan_kg' => $ferts['Kaptan']->jumlah_kg ?? null,
                        'pupuk_tsp_kg' => $ferts['TSP / RP']->jumlah_kg ?? null, 'pupuk_urea_kg' => $ferts['Urea']->jumlah_kg ?? null, 'pupuk_mop_kg' => $ferts['MOP']->jumlah_kg ?? null, 'pupuk_mikro_kg' => $ferts['Mikro-Mg']->jumlah_kg ?? null,
                        'mutu_unripe' => $quals['Unripe']->persentase ?? null, 'mutu_ripe' => $quals['Ripe']->persentase ?? null, 'mutu_over_ripe' => $quals['Over Ripe']->persentase ?? null, 'mutu_empty_bunch' => $quals['Empty Bunch']->persentase ?? null, 'mutu_abnormal' => $quals['Abnormal']->persentase ?? null,
                    ];
                }
            }
        }
        return collect($data);
    }
    public function title(): string { return '4. Pupuk & Mutu'; }
}
