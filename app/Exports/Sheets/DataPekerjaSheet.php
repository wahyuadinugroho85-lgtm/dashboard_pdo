<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Estate;
use App\Models\WorkerPerformance;
use Carbon\Carbon;

class DataPekerjaSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $bulan; protected $tahun;
    public function __construct($bulan, $tahun) { $this->bulan = $bulan; $this->tahun = $tahun; }

    public function headings(): array {
        return ['kode_pt', 'tipe_data', 'bulan', 'tahun', 'tk_umur_kurang_25', 'tk_umur_25_40', 'tk_umur_40_50', 'tk_umur_lebih_50', 'tk_status_kk', 'tk_status_lj', 'tk_masa_kurang_1bln', 'tk_masa_2_3bln', 'tk_masa_lebih_3bln', 'tk_mutasi_masuk_bi', 'tk_mutasi_keluar_bi', 'tk_mutasi_pct_keluar_bi', 'tk_mutasi_pct_keluar_sbi', 'tk_hkne_kerja', 'tk_hkne_sakit', 'tk_hkne_cuti', 'tk_hkne_mangkir', 'tk_hkne_ijin', 'tk_jam_tersedia', 'tk_jam_pagi', 'tk_jam_siang', 'tk_jam_sore', 'tk_kelas_a', 'tk_kelas_a_avr', 'tk_kelas_b', 'tk_kelas_b_avr', 'tk_kelas_c', 'tk_kelas_c_avr', 'tk_kelas_d', 'tk_kelas_d_avr'];
    }

    public function collection() {
        $periode = Carbon::createFromDate($this->tahun, $this->bulan, 1)->format('Y-m-d');
        $estates = Estate::where('kode', '!=', 'BP-2')->get();
        $tipes = ['REAL', 'RKB', 'BUDGET', 'SENSUS'];
        $data = [];

        foreach ($estates as $estate) {
            foreach ($tipes as $tipe) {
                $workers = WorkerPerformance::where('estate_id', $estate->id)->where('periode', $periode)->where('tipe', $tipe)->get();
                if($workers->count() > 0) {
                    $getTk = function($kat, $sub) use ($workers) { $w = $workers->where('kategori', $kat)->where('sub_kategori', $sub)->first(); return $w ? $w->jumlah_tk : null; };
                    $getTkAvr = function($kat, $sub) use ($workers) { $w = $workers->where('kategori', $kat)->where('sub_kategori', $sub)->first(); return $w ? $w->avr_bln : null; };
                    $getTkPct = function($kat, $sub) use ($workers) { $w = $workers->where('kategori', $kat)->where('sub_kategori', $sub)->first(); return $w ? $w->persentase : null; };

                    $data[] = [
                        'kode_pt' => $estate->kode, 'tipe_data' => $tipe, 'bulan' => $this->bulan, 'tahun' => $this->tahun,
                        'tk_umur_kurang_25' => $getTk('Umur', '< 25'), 'tk_umur_25_40' => $getTk('Umur', '25 - 40'), 'tk_umur_40_50' => $getTk('Umur', '40 - 50'), 'tk_umur_lebih_50' => $getTk('Umur', '> 50'),
                        'tk_status_kk' => $getTk('Status Keluarga', 'KK'), 'tk_status_lj' => $getTk('Status Keluarga', 'Lj'),
                        'tk_masa_kurang_1bln' => $getTk('Masa Kerja', '<= 1bln'), 'tk_masa_2_3bln' => $getTk('Masa Kerja', '2-3Bln'), 'tk_masa_lebih_3bln' => $getTk('Masa Kerja', '> 3Bln'),
                        'tk_mutasi_masuk_bi' => $getTk('Mutasi', 'Masuk (Bi)'), 'tk_mutasi_keluar_bi' => $getTk('Mutasi', 'Keluar (Bi)'), 'tk_mutasi_pct_keluar_bi' => $getTkPct('Mutasi', '% Keluar Bi'), 'tk_mutasi_pct_keluar_sbi' => $getTkPct('Mutasi', '% Keluar Sbi'),
                        'tk_hkne_kerja' => $getTk('HKNE', 'Kerja'), 'tk_hkne_sakit' => $getTk('HKNE', 'Sakit'), 'tk_hkne_cuti' => $getTk('HKNE', 'Cuti'), 'tk_hkne_mangkir' => $getTk('HKNE', 'Mangkir'), 'tk_hkne_ijin' => $getTk('HKNE', 'Ijin'),
                        'tk_jam_tersedia' => $getTk('Jam Kerja', 'Tersedia'), 'tk_jam_pagi' => $getTk('Jam Kerja', 'Pagi'), 'tk_jam_siang' => $getTk('Jam Kerja', 'Siang'), 'tk_jam_sore' => $getTk('Jam Kerja', 'Sore'),
                        'tk_kelas_a' => $getTk('Kelas Pemanen', 'A'), 'tk_kelas_a_avr' => $getTkAvr('Kelas Pemanen', 'A'), 'tk_kelas_b' => $getTk('Kelas Pemanen', 'B'), 'tk_kelas_b_avr' => $getTkAvr('Kelas Pemanen', 'B'), 'tk_kelas_c' => $getTk('Kelas Pemanen', 'C'), 'tk_kelas_c_avr' => $getTkAvr('Kelas Pemanen', 'C'), 'tk_kelas_d' => $getTk('Kelas Pemanen', 'D'), 'tk_kelas_d_avr' => $getTkAvr('Kelas Pemanen', 'D')
                    ];
                }
            }
        }
        return collect($data);
    }
    public function title(): string { return '5. Tenaga Kerja'; }
}
