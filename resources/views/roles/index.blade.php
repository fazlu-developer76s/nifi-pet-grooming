@extends('layouts/app')
@section('content')
    <div class="container-fluid">
        {{-- <div class="row"> --}}
            <div id="content" class="app-content">
                <div class="d-flex align-items-center mb-3">
                    <div>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript:;">Role</a></li>
                            <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Role</li>
                        </ol>
                        <h1 class="page-header mb-0">Role</h1>
                    </div>
                </div>

                <!-- Row for equal division -->
                <div class="row">
                    <!-- Form Section -->
                    <div class="col-md-6 d-none">
                        <div class="card border-0 mb-4">
                            <div class="card-header h6 mb-0 bg-none p-3">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Role
                            </div>
                            <form action="{{ route('store.roles') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                @if(isset($find_role) && $find_role->id)
                                                <input type="hidden" name="hidden_id" value="{{ $find_role->id }}">
                                                @endif
                                                <label class="form-label">Role Title</label>
                                                <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" placeholder="Enter Role Title" value="{{ ( isset($find_role)  && $find_role->title) ? $find_role->title : ' ' ; }} {{ old('title') }}"  />
                                                   <!-- Display Error Message Below the Input Field -->
                                                    @error('title')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                           </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Role Status</label>
                                                    <select class="form-control custom-select-icon" name="status">
                                                        <option value="1" {{ ( isset($find_role) && $find_role->status == 1)?'selected':''; }}>Active Role</option>
                                                        <option value="2" {{ ( isset($find_role) && $find_role->status == 2)?'selected':''; }}>Inactive Role</option>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-none d-flex p-3">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>Submit</button>
                                    {{-- <button type="reset" class="btn btn-danger ms-2">RESET</button> --}}
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="col-md-12">
                        <div class="card border-0 mb-4">
                            <div class="card-header h6 mb-0 bg-none p-3" style="border-bottom: 1px solid #2196f3;">
                                <i class="fab fa-buromobelexperte fa-lg fa-fw text-dark text-opacity-50 me-1"></i> Role List
                            </div>
                            <div class="card-body">
                                <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th width="1%"></th>
                                            <th class="text-nowrap">Role</th>
                                            <th class="text-nowrap">Created Date</th>
                                            <th class="text-nowrap">Status</th>
                                            <th class="text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($get_role)
                                        @foreach($get_role as $role)
                                        <tr class="odd gradeX">
                                            <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                            <td>{{ $role->title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d F Y h:i A') }}</td>

                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $role->id }}" {{ ($role->status==1) ? 'checked' : '' }}  onchange="ChangeStatus('roles',{{ $role->id }});" >
                                                  </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('permission', $role->id) }}" class="text-primary me-2">
                                                    <i class="fa fa-lock"></i>
                                                </a>
                                                <a href="{{ route('edit.roles', $role->id) }}" class="text-primary me-2">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('destroy.roles', $role->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this role?');">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
    </div>
@endsection
