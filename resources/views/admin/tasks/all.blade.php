@section('title', 'All Tasks')
<x-app-layout>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">All Tasks</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Tasks</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @if (session('success') || session('error'))
                        <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show mt-3" role="alert" id="session-alert">
                            {{ session('success') ?? session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <script>
                            setTimeout(() => {
                                const alert = document.getElementById('session-alert');
                                if (alert) {
                                    alert.classList.remove('show');
                                    alert.classList.add('fade');
                                    setTimeout(() => alert.remove(), 300);
                                }
                            }, 5000);
                        </script>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of All Tasks</h3>
                            <div class="card-tools">
                                <a href="{{ route('tasks.createUnified') }}" class="btn btn-sm btn-primary">Add Task</a>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <form action="{{ route('tasks.bulkAction') }}" method="POST">
                                @csrf
                                <div class="mb-2 p-2">
                                    <button type="submit" name="action" value="export_excel" class="btn btn-success btn-sm">Export to Excel</button>
                                    <button type="submit" name="action" value="export_pdf" class="btn btn-secondary btn-sm">Export to PDF</button>
                                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete selected tasks?')">Delete Selected</button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th>
                                                <th>Sr No.</th>
                                                <th>Project</th>
                                                <th>Title</th>
                                                <th>Assigned To</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                <th>Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tasks as $index => $task)
                                                <tr>
                                                    <td><input type="checkbox" name="selected_ids[]" value="{{ $task->id }}"></td>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $task->project->name ?? '-' }}</td>
                                                    <td>{{ $task->title }}</td>
                                                    <td>{{ $task->assignee?->name ?? 'Unassigned' }}</td>
                                                    <td><span class="badge bg-info">{{ ucfirst($task->status) }}</span></td>
                                                    <td>{{ ucfirst($task->priority) }}</td>
                                                    <td>{{ $task->due_at ? \Carbon\Carbon::parse($task->due_at)->format('d M Y H:i') : '-' }}</td>
                                                    <td>
                                                        <a href="{{ route('task.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                        <a href="{{ route('task.show', $task->id) }}" class="btn btn-sm btn-info">View</a>                                                        
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('select-all').addEventListener('change', function(e) {
        const checked = e.target.checked;
        document.querySelectorAll('input[name="selected_ids[]"]').forEach(cb => cb.checked = checked);
    });

    function copyTaskLink(taskId) {
        const taskUrl = `{{ url('/tasks') }}/${taskId}`;
        navigator.clipboard.writeText(taskUrl).then(() => {
            alert('✅ Task link copied to clipboard!');
        }).catch(err => {
            console.error('❌ Could not copy link: ', err);
        });
    }
</script>