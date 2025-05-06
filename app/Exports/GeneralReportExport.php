<?php

namespace App\Exports;

use App\Models\CallDetailsRecordModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class GeneralReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CallDetailsRecordModel::all();
    }
}
