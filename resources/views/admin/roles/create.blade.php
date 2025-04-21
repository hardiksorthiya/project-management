@section('title', isset($role) ? 'Edit Role' : 'Create Role')
<x-app-layout>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($role) ? 'Edit Role' : 'Create Role' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($role) ? 'Edit Role' : 'Create Role' }}</li>
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
                            <h3 class="card-title">{{ isset($role) ? 'Edit Role' : 'Add New Role' }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary float-start">Back</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(isset($role))
                                    @method('PUT')
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">Role Name</label>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name', $role->name ?? '') }}">
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <h4 class="mb-3">Assign Permissions</h4>

                                <div class="row">
                                    @foreach($permissions as $group => $groupPermissions)
                                        <div class="col-md-4 mb-4">
                                            <div class="border rounded p-3">
                                                <strong>{{ $group }}</strong>
                                                <hr>
                                                @foreach($groupPermissions as $permission)
                                                    <div>
                                                        <label class="form-check-label">
                                                            <input 
                                                                type="checkbox" 
                                                                class="form-check-input"
                                                                name="permissions[]" 
                                                                value="{{ $permission->name }}"
                                                                {{ isset($role) && $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                                >
                                                            {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="submit" class="btn btn-primary">{{ isset($role) ? 'Update' : 'Create' }} Role</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
