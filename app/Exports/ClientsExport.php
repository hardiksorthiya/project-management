<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Client::select('name', 'email', 'phone', 'company_name', 'address')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Phone', 'Company', 'Address'];
    }
}

