@extends('layouts/app')
@section('content')
@if(isset($get_package))
@php $form_action = "package.update" @endphp
@else
@php $form_action = "package.create" @endphp
@endif
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Package</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create Package</li>
                    </ol>
                    <h1 class="page-header mb-0">Package</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Package
                            </div>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ (isset($get_package)) ? $get_package->id : '' ; }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Select Service </label>
                                            <select class="form-control custom-select-icon @error('service_id') is-invalid @enderror" name="service_id">
                                                <option value="">Select Service</option>
                                                @if($service)
                                                    @foreach ($service as $ser)
                                                        <option value="{{ $ser->id }}" @if(!empty($get_package->service_id)) {{ @$get_package->service_id == $ser->id ? 'selected' : '' }} @else {{ (old('service_id') == $ser->id) ? 'selected' : '' ; }} @endif>{{ $ser->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('service_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" placeholder="Enter Title" value="@if(empty($get_package)) {{ old('title') }} @else {{ (isset($get_package)) ? $get_package->title : '' ; }} @endif" />
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Package Charge</label>
                                            <input class="form-control @error('package_charge') is-invalid @enderror" type="text" name="package_charge" placeholder="Enter Package Charge" value="@if(empty($get_package)) {{ old('package_charge') }} @else {{ (isset($get_package)) ? $get_package->package_charge : '' ; }} @endif" />
                                            @error('package_charge')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-control custom-select-icon @error('status') is-invalid @enderror" name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }} {{ (isset($get_package) && $get_package->status == 1) ? 'selected' : '' ; }}>Active </option>
                                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }} {{ (isset($get_package) && $get_package->status == 2) ? 'selected' : '' ; }}>Inactive </option>
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
                            Package List
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Service</th>
                                        <th class="text-nowrap">Title</th>
                                        <th class="text-nowrap">Charge</th>
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($allpackage)
                                    @foreach ($allpackage as $package)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                        <td>{{ $package->service_title }}</td>
                                        <td>{{ $package->title }}</td>
                                        <td>{{ $package->package_charge }}</td>
                                        <td>{{ \Carbon\Carbon::parse($package->created_at)->format('d F Y h:i A') }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $package->id }}" {{ ($package->status==1) ? 'checked' : '' }}  onchange="ChangeStatus('packages',{{ $package->id }});" >
                                              </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('package.edit', $package->id) }}" class="text-primary me-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('package.destroy', $package->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this package?');">
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
