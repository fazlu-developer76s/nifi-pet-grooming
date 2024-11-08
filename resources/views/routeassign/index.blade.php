@extends('layouts/app')
@section('content')
@if(isset($assignroute))
@php $form_action = "routeassign.update" @endphp
@else
@php $form_action = "routeassign.create" @endphp
@endif
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Route Assign</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create Route Assign</li>
                    </ol>
                    <h1 class="page-header mb-0">Route Assign</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Route Assign
                            </div>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ (isset($assignroute)) ? $assignroute->id : '' ; }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Select Route </label>
                                            <select class="form-control custom-select-icon @error('route_id') is-invalid @enderror" name="route_id" @if(!empty($assignroute)) disabled @endif>
                                                <option value="">Select Route</option>
                                                @if($allroute)
                                                    @foreach ($allroute as $routes)
                                                        <option value="{{ $routes->id }}" @if(empty($assignroute)) {{ old('route_id') == $routes->id ? 'selected' : '' }} @else {{ (isset($assignroute) && $assignroute->route_id == $routes->id) ? 'selected' : '' ; }} @endif>{{ $routes->route }} {{ '('.$routes->title.')' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('route_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Select User </label>
                                            <select class="form-control custom-select-icon @error('user_id') is-invalid @enderror" name="user_id" >
                                                <option value="">Select User</option>
                                                @if($alluser)
                                                    @foreach ($alluser as $user)
                                                        <option value="{{ $user->id }}" @if(empty($assignroute)) {{ old('user_id') == $user->id ? 'selected' : '' }} @else {{ (isset($assignroute) && $assignroute->user_id == $user->id) ? 'selected' : '' ; }} @endif>{{ $user->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Route Assign Status</label>
                                            <select class="form-control custom-select-icon @error('status') is-invalid @enderror" name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }} {{ (isset($assignroute) && $assignroute->status == 1) ? 'selected' : '' ; }}>Active Route Assign</option>
                                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }} {{ (isset($assignroute) && $assignroute->status == 2) ? 'selected' : '' ; }}>Inactive Route Assign</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-none d-flex p-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="col-md-6">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex align-items-center" style="border-bottom: 1px solid #2196f3;">
                            <i class="fab fa-buromobelexperte fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                            Route Assign List
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Route</th>
                                        <th class="text-nowrap">Route Name</th>
                                        <th class="text-nowrap">User Name</th>
                                        <th class="text-nowrap">Assign Date</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($allrouteassign)
                                    @foreach ($allrouteassign as $assign)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                        <td>{{ $assign->route }}</td>
                                        <td>{{ $assign->title }}</td>
                                        <td>{{ $assign->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($assign->created_at)->format('d F Y h:i A') }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $assign->id }}" {{ ($assign->status==1) ? 'checked' : '' }}  onchange="ChangeStatus('assignroutes',{{ $assign->id }});" >
                                              </div>
                                        </td>
                                        <td class="text-center">

                                            <form action="{{ route('routeassign.remove', $assign->id) }}" method="GET" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this Route Assign?');">
                                                    <i class="fa fa-remove"></i>
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
    </div>
@endsection
