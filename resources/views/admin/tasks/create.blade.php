@section('title', isset($task) ? 'Edit Task' : 'Create Task')
<x-app-layout>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($task) ? 'Edit Task' : 'Create Task' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($task) ? 'Edit Task' : 'Create Task' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ isset($task) ? 'Edit Task' : 'Add New Task' }}</h3>
                            <div class="card-tools">
                                <a href="{{ isset($project) ? route('projects.task.index', $project->id) : route('tasks.all') }}"
                                    class="btn btn-sm btn-primary float-start">
                                    Back
                                </a>

                            </div>
                        </div>

                        <div class="card-body">
                            <form
                                action="{{ isset($task)
                                    ? route('task.update', $task->id)
                                    : (isset($project)
                                        ? route('projects.task.store', $project->id)
                                        : route('tasks.storeUnified')) }}"
                                method="POST">
                                @csrf
                                @if (isset($task))
                                    @method('PUT')
                                @endif

                                @if (isset($project))
                                    <input type="text" class="form-control" value="{{ $project->name }}" readonly
                                        disabled>
                                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                                @else
                                    <label class="form-label">Select Project</label>
                                    <select name="project_id" class="form-select" required>
                                        <option value="">Select Project</option>
                                        @foreach ($allProjects as $proj)
                                            <option value="{{ $proj->id }}"
                                                {{ old('project_id') == $proj->id ? 'selected' : '' }}>
                                                {{ $proj->name }}</option>
                                        @endforeach
                                    </select>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" required
                                        value="{{ old('title', $task->title ?? '') }}">
                                    @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control">{{ old('description', $task->description ?? '') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Start Time</label>
                                        <input type="datetime-local" name="start_at" class="form-control"
                                            value="{{ old('start_at', isset($task->start_at) ? \Carbon\Carbon::parse($task->start_at)->format('Y-m-d\TH:i') : '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Due Time</label>
                                        <input type="datetime-local" name="due_at" class="form-control"
                                            value="{{ old('due_at', isset($task->due_at) ? \Carbon\Carbon::parse($task->due_at)->format('Y-m-d\TH:i') : '') }}">
                                        @error('due_at')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Priority</label>
                                        <select name="priority" class="form-select">
                                            @foreach (['low', 'medium', 'high'] as $level)
                                                <option value="{{ $level }}"
                                                    {{ old('priority', $task->priority ?? '') === $level ? 'selected' : '' }}>
                                                    {{ ucfirst($level) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            @foreach (['pending', 'in-progress', 'completed'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ old('status', $task->status ?? '') === $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Assign To</label>
                                        <select name="assigned_to" class="form-select">
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('assigned_to', $task->assigned_to ?? '') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subtask Of</label>
                                    <select name="parent_id" class="form-select">
                                        <option value="">No Parent (Main Task)</option>
                                        @foreach ($tasks as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_id', $task->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">{{ isset($task) ? 'Update' : 'Create' }}
                                    Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
