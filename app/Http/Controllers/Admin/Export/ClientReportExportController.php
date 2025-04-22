<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Exports\ClientsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\ClientReportExportController;

class ClientReportExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new ClientsExport, 'clients.xlsx');
    }

    public function exportPdf()
    {
        $clients = Client::all();
        $pdf = Pdf::loadView('admin.clients.export-pdf', compact('clients'));
        return $pdf->download('clients.pdf');
    }
}

