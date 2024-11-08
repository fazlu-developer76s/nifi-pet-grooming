@extends('layouts/app')
@section('content')
@if(isset($get_route))
@php $form_action = "route.update" @endphp
@else
@php $form_action = "route.create" @endphp
@endif
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Route</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create Route</li>
                    </ol>
                    <h1 class="page-header mb-0">Route</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Route
                            </div>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ (isset($get_route)) ? $get_route->id : '' ; }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Route</label>
                                            <input class="form-control @error('route') is-invalid @enderror" type="text" name="route" placeholder="Enter Name" value="@if(empty($get_route)) {{ old('route') }} @else {{ (isset($get_route)) ? $get_route->route : '' ; }} @endif" />
                                            @error('route')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" placeholder="Enter Name" value="@if(empty($get_route)) {{ old('title') }} @else {{ (isset($get_route)) ? $get_route->title : '' ; }} @endif" />
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Route Status</label>
                                            <select class="form-control custom-select-icon @error('status') is-invalid @enderror" name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }} {{ (isset($get_route) && $get_route->status == 1) ? 'selected' : '' ; }}>Active Route</option>
                                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }} {{ (isset($get_route) && $get_route->status == 2) ? 'selected' : '' ; }}>Inactive Route</option>
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
                            Route List
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Route</th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($allroute)
                                    @foreach ($allroute as $route)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                        <td>{{ $route->route }}</td>
                                        <td>{{ $route->title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($route->created_at)->format('d F Y h:i A') }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $route->id }}" {{ ($route->status==1) ? 'checked' : '' }}  onchange="ChangeStatus('routes',{{ $route->id }});" >
                                              </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('routeassign.view', $route->id) }}" class="text-success me-2">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('route.edit', $route->id) }}" class="text-primary me-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('route.destroy', $route->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this route?');">
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
    </div>
@endsection
