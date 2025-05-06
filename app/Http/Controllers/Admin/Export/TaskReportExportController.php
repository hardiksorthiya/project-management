<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Exports\TaskExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Admin\TaskReportExportController;

class TaskReportExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new TaskExport, 'tasks.xlsx');
    }

    public function exportPdf()
    {
        $tasks = Task::all();
        $pdf = Pdf::loadView('admin.tasks.export-pdf', compact('tasks'));
        return $pdf->download('tasks.pdf');
    }
}

