<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\DataProduksiSheet;
use App\Exports\Sheets\DataBiayaSheet;
use App\Exports\Sheets\DataPerawatanSheet;
use App\Exports\Sheets\DataPupukMutuSheet;
use App\Exports\Sheets\DataPekerjaSheet;

class LaporanDataExport implements WithMultipleSheets
{
    use Exportable;

    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function sheets(): array
    {
        return [
            new DataProduksiSheet($this->bulan, $this->tahun),
            new DataBiayaSheet($this->bulan, $this->tahun),
            new DataPerawatanSheet($this->bulan, $this->tahun),
            new DataPupukMutuSheet($this->bulan, $this->tahun),
            new DataPekerjaSheet($this->bulan, $this->tahun),
        ];
    }
}
