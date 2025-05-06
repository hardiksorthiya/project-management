<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TaskExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(array $selectedIds)
{
    $this->selectedIds = $selectedIds;
}

    public function collection()
    {
        return Task::with('project', 'assignee')
            ->latest()
            ->whereIn('id', $this->selectedIds)
            // → Uncomment below if you want only completed tasks
            // ->where('status', 'completed')
            ->get();
    }

    public function headings(): array
    {
        return ['Project Name', 'Title', 'Assigned To', 'Status', 'Priority', 'Start At', 'Due At'];
    }

    public function map($task): array
    {
        return [
            $task->project->name ?? '-',
            $task->title,
            $task->assignee?->name ?? '-',
            ucfirst($task->status),
            ucfirst($task->priority),
            optional($task->start_at)->format('d M Y H:i'),
            optional($task->due_at)->format('d M Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'D9E1F2'],
                ],
            ],
        ];
    }
}
