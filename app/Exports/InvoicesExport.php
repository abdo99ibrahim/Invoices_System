<?php

namespace App\Exports;

use App\Models\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection
{
    public function headings(): array
    {
        return [
            '#',
            'User',
            'Date',
        ];
    }
    public function collection()
    {
        // return invoices::all();
        return invoices::select('invoice_number','invoice_date','due_date','product','Amount_Collection','Amount_Commission','discount','Value_VAT','Rate_VAT','total','status','Payment_Date','note')->get();
    }

}

