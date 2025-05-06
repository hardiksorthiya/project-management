<!DOCTYPE html>
<html>

<head>
    <title>Tasks PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid #333;
            padding: 8px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <h2>Task List</h2>
    <table>
        <thead>
            <tr>
                <th>Sr. No</th>
                <th>Project</th>
                <th>Title</th>
                <th>Description</th>
                <th>Assign to</th>
                <th>Start Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks  as $index => $task)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $task->project->name ?? '-' }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->assignee?->name ?? 'Unassigned' }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($task->status) }}</span></td>
                    <td>{{ $task->start_at ? \Carbon\Carbon::parse($task->start_at)->format('d M Y H:i') : '-' }}</td>
                    <td>{{ $task->due_at ? \Carbon\Carbon::parse($task->due_at)->format('d M Y H:i') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
