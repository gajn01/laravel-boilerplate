<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\Store;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SummaryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(Request $request)
    {
        return Store::select('id','code','name','area')->get();
    }

    public function headings():array{
        return [
            '#',
            'Code',
            'Name',
            'Area'
        ];
    }
}
