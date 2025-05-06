@section('title', 'Task Details')
<x-app-layout>
    <div class="container mt-4">
        <h2>Task Details</h2>

        <div class="card">
            <div class="card-body">
                <h4>{{ $task->title }}</h4>
                <p><strong>Project:</strong> {{ $task->project->name ?? '-' }}</p>
                <p><strong>Assigned To:</strong> {{ $task->assignee->name ?? 'Unassigned' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
                <p><strong>Priority:</strong> {{ ucfirst($task->priority) }}</p>
                <p><strong>Start At:</strong> {{ $task->start_at ? \Carbon\Carbon::parse($task->start_at)->format('d M Y H:i') : '-' }}</p>
                <p><strong>Due At:</strong> {{ $task->due_at ? \Carbon\Carbon::parse($task->due_at)->format('d M Y H:i') : '-' }}</p>
                <p><strong>Description:</strong> {{ $task->description }}</p>

                @if ($task->parent)
                    <p><strong>Subtask Of:</strong> {{ $task->parent->title }}</p>
                @endif

                @if ($task->subtasks->count())
                    <p><strong>Subtasks:</strong></p>
                    <ul>
                        @foreach ($task->subtasks as $sub)
                            <li>{{ $sub->title }} ({{ ucfirst($sub->status) }})</li>
                        @endforeach
                    </ul>
                @endif

                <a href="{{ route('task.edit', $task->id) }}" class="btn btn-primary btn-sm">Edit Task</a>
                <a href="{{ route('tasks.all') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
        </div>
    </div>
</x-app-layout>
