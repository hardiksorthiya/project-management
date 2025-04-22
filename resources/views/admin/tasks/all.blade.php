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
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
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
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $task->project->name ?? '-' }}</td>
                                                <td>{{ $task->title }}</td>
                                                <td>{{ $task->assignee?->name ?? 'Unassigned' }}</td>
                                                <td><span class="badge bg-info">{{ ucfirst($task->status) }}</span></td>
                                                <td>{{ ucfirst($task->priority) }}</td>
                                                <td>{{ $task->due_at ? \Carbon\Carbon::parse($task->due_at)->format('d M Y H:i') : '-' }}</td>
                                                <td>
                                                    <a href="{{ route('task.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $task->id }}">Delete</button>

                                                    <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $task->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $task->id }}">Delete Confirmation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete <strong>{{ $task->title }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('task.destroy', $task->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>