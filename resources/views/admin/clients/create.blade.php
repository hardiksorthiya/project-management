@section('title', isset($client) ? 'Edit Client' : 'Create Client')
<x-app-layout>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($client) ? 'Edit Client' : 'Create Client' }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ isset($client) ? 'Edit Client' : 'Create Client' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert" id="session-alert">
                            {{ session('success') }}
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
                        <div class="card-body">
                            <form action="{{ isset($client) ? route('clients.update', $client->id) : route('clients.store') }}" method="POST">
                                @csrf
                                @if(isset($client))
                                    @method('PUT')
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">Client Name</label>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name', $client->name ?? '') }}">
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $client->email ?? '') }}">
                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone ?? '') }}">
                                    @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $client->company_name ?? '') }}">
                                    @error('company_name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" class="form-control" rows="3">{{ old('address', $client->address ?? '') }}</textarea>
                                    @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">{{ isset($client) ? 'Update' : 'Create' }} Client</button>
                                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back</a>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
