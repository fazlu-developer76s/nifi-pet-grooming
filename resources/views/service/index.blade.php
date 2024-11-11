@extends('layouts/app')
@section('content')
@if(isset($get_service))
@php $form_action = "service.update" @endphp
@else
@php $form_action = "service.create" @endphp
@endif
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Service</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create Service</li>
                    </ol>
                    <h1 class="page-header mb-0">Service</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Service
                            </div>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ (isset($get_service)) ? $get_service->id : '' ; }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" placeholder="Enter Title" value="@if(empty($get_service)) {{ old('title') }} @else {{ (isset($get_service)) ? $get_service->title : '' ; }} @endif" />
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Service Charge</label>
                                            <input class="form-control @error('service_charge') is-invalid @enderror" type="text" name="service_charge" placeholder="Enter Service Charge" value="@if(empty($get_service)) {{ old('service_charge') }} @else {{ (isset($get_service)) ? $get_service->service_charge : '' ; }} @endif" />
                                            @error('service_charge')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-control custom-select-icon @error('status') is-invalid @enderror" name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }} {{ (isset($get_service) && $get_service->status == 1) ? 'selected' : '' ; }}>Active </option>
                                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }} {{ (isset($get_service) && $get_service->status == 2) ? 'selected' : '' ; }}>Inactive </option>
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
                            Service List
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Title</th>
                                        <th class="text-nowrap">Charge</th>
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($allservice)
                                    @foreach ($allservice as $service)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                        <td>{{ $service->title }}</td>
                                        <td>{{ $service->service_charge }}</td>
                                        <td>{{ \Carbon\Carbon::parse($service->created_at)->format('d F Y h:i A') }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $service->id }}" {{ ($service->status==1) ? 'checked' : '' }}  onchange="ChangeStatus('services',{{ $service->id }});" >
                                              </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('service.edit', $service->id) }}" class="text-primary me-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('service.destroy', $service->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this service?');">
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
