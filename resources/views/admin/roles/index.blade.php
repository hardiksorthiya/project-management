@section('title', 'Roles List')
<x-app-layout>
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ __('Roles List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Roles List') }}</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">

            <!--begin::Row-->
            <div class="row">
                <!-- Start col -->
                <div class="col-12">
                  @if (session('success') || session('error'))
                  <div 
                      class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} alert-dismissible fade show mt-3" 
                      role="alert" 
                      id="session-alert"
                  >
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
              
                    <!--begin::Latest Order Widget-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Roles</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                                <button type="button" class="btn btn-tool">
                                    <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary float-start">
                                        Create Role
                                    </a>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Role Name</th>
                                            <th>Permission</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $index => $role)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @if($role->permissions->isEmpty())
                                                        <span class="badge bg-danger">No Permissions</span>
                                                    @else
                                                        @foreach ($role->permissions as $permission)
                                                            <span class="badge bg-primary">{{ $permission->name }}</span>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                  <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                  <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}">
                                                    Delete
                                                </button>
                                                <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
                                                  <div class="modal-dialog modal-dialog-centered">
                                                      <div class="modal-content">
                                                          <div class="modal-header bg-danger text-white">
                                                              <h5 class="modal-title" id="deleteModalLabel{{ $role->id }}">Delete Confirmation</h5>
                                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                          </div>
                                                          <div class="modal-body">
                                                              Are you sure you want to delete <strong>{{ $role->name }}</strong>?
                                                          </div>
                                                          <div class="modal-footer">
                                                              <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
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
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
    <!-- Modal -->

</x-app-layout>


