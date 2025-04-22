
@section('title', isset($project) ? 'Edit Project' : 'Create Project')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const userSelect = document.querySelector('.select-users');
        if (userSelect) {
            $(userSelect).select2({
                placeholder: "Assign Users",
                allowClear: true,
                width: '100%'
            });
        }
    });
</script>


<x-app-layout>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($project) ? 'Edit Project' : 'Create Project' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($project) ? 'Edit Project' : 'Create Project' }}</li>
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
                        <div class="card-body">
                            <form action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}" method="POST">
                                @csrf
                                @if(isset($project)) @method('PUT') @endif

                                <div class="mb-3">
                                    <label class="form-label">Project Name</label>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name', $project->name ?? '') }}">
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description', $project->description ?? '') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $project->start_date ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $project->end_date ?? '') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="active" {{ (old('status', $project->status ?? '') === 'active') ? 'selected' : '' }}>Active</option>
                                            <option value="completed" {{ (old('status', $project->status ?? '') === 'completed') ? 'selected' : '' }}>Completed</option>
                                            <option value="on-hold" {{ (old('status', $project->status ?? '') === 'on-hold') ? 'selected' : '' }}>On-Hold</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Priority</label>
                                        <select name="priority" class="form-select" required>
                                            <option value="low" {{ (old('priority', $project->priority ?? '') === 'low') ? 'selected' : '' }}>Low</option>
                                            <option value="medium" {{ (old('priority', $project->priority ?? '') === 'medium') ? 'selected' : '' }}>Medium</option>
                                            <option value="high" {{ (old('priority', $project->priority ?? '') === 'high') ? 'selected' : '' }}>High</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Client</label>
                                    <select name="client_id" class="form-select">
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ (old('client_id', $project->client_id ?? '') == $client->id) ? 'selected' : '' }}>{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Assign Users</label>
                                    <select name="user_ids[]" class="form-select select-users" multiple>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ (isset($selectedUsers) && in_array($user->id, $selectedUsers)) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                

                                <button type="submit" class="btn btn-primary">{{ isset($project) ? 'Update' : 'Create' }} Project</button>
                                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>