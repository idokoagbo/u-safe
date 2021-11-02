<?php

namespace App\Exports;

use App\Notification;
use Maatwebsite\Excel\Concerns\FromCollection;

class HeadcountExport implements FromCollection
{
    public function collection()
    {
        return Notification::all();
    }
    
}