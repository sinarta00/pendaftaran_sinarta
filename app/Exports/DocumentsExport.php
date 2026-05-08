<?php

namespace App\Exports;

use App\Models\DocumentUpload;
use Maatwebsite\Excel\Concerns\FromCollection;

class DocumentsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DocumentUpload::all();
    }
}
