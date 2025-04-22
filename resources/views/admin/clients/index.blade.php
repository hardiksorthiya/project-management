@section('title', 'Client List')
<x-app-layout>
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ __('Client List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Client List') }}</li>
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

                    <!--begin::Card-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Clients</h3>
                            <div class="card-tools">
                                <a href="{{ route('clients.create') }}" class="btn btn-sm btn-primary">
                                    Add Client
                                </a>
                                <a href="{{ route('clients.export.excel') }}" class="btn btn-success btn-sm">Export to Excel</a>
                                    <a href="{{ route('clients.export.pdf') }}" class="btn btn-danger btn-sm">Export to PDF</a>
                                
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Company</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clients as $index => $client)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->email ?? '-' }}</td>
                                                <td>{{ $client->phone ?? '-' }}</td>
                                                <td>{{ $client->company_name ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    
                                                    <!-- Delete Button Trigger Modal -->
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $client->id }}">
                                                        Delete
                                                    </button>

                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $client->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $client->id }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger text-white">
                                                                    <h5 class="modal-title" id="deleteModalLabel{{ $client->id }}">Delete Confirmation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete <strong>{{ $client->name }}</strong>?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
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
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">No clients found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- Pagination links -->
<div class="mt-3 px-3">
    {{ $clients->links() }}
</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-->

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
