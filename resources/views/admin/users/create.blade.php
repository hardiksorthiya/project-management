@section('title', isset($user) ? 'Edit User' : 'Create User')
<x-app-layout>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($user) ? 'Edit User' : 'Create User' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ isset($user) ? 'Edit User' : 'Create User' }}</li>
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
                            <h3 class="card-title">{{ isset($user) ? 'Edit User' : 'Add New User' }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary float-start">Back</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST">
                                @csrf
                                @if(isset($user))
                                    @method('PUT')
                                @endif

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control" required>
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control" required>
                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control" required>
                                    @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                {{-- Role --}}
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select id="role" name="role" class="form-select" required>
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ old('role', isset($user) && $user->hasRole($role->name) ? $role->name : '') == $role->name ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        Password
                                        @if(isset($user)) <small class="text-muted">(Leave blank to keep unchanged)</small> @endif
                                    </label>
                                    <input type="password" id="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
                                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                {{-- Submit --}}
                                <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Create' }} User</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
