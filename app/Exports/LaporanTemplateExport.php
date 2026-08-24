<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\TemplateProduksiSheet;
use App\Exports\Sheets\TemplateBiayaSheet;
use App\Exports\Sheets\TemplatePerawatanSheet;
use App\Exports\Sheets\TemplatePupukMutuSheet;
use App\Exports\Sheets\TemplatePekerjaSheet;

class LaporanTemplateExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        return [
            new TemplateProduksiSheet(),
            new TemplateBiayaSheet(),
            new TemplatePerawatanSheet(),
            new TemplatePupukMutuSheet(),
            new TemplatePekerjaSheet(),
        ];
    }
}
