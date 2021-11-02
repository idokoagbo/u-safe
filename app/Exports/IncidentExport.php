<?php

namespace App\Exports;

use App\IncidentResponse;
use Maatwebsite\Excel\Concerns\FromCollection;

class IncidentExport implements FromCollection
{
    public function collection()
    {
        return IncidentResponse::all();
    }
    
}