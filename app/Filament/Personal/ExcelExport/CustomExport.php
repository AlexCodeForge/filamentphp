<?php

namespace App\Filament\Personal\ExcelExport;

use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class CustomExport extends ExcelExport
{

    public function setUp()
    {
        // dd($this);
        $this->withFilename('custom_export');
    }
}
