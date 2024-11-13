@extends('layouts/app')
@section('content')
<style>
    .dropdown-menu {
    max-height: 400px; /* Limit the height for large lists */
    overflow-y: auto; /* Add scroll for long lists */
}

@media (max-width: 576px) {
    .dropdown-menu {
        min-width: 100%; /* Make dropdown full-width on small devices */
    }
    .dropdown a {
        width: 100%; /* Ensure the button spans the container */
    }
}

</style>
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
                <div class="col-md-12">
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
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" placeholder="Enter Title" value="@if(empty($get_package)) {{ old('title') }} @else {{ (isset($get_package)) ? $get_package->title : '' ; }} @endif" />
                                            @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Small Breed</label>
                                            <input class="form-control @error('small_charge') is-invalid @enderror" type="text" name="small_charge" placeholder="Enter Package Charge" value="@if(empty($get_package)) {{ old('small_charge') }} @else {{ (isset($get_package)) ? $get_package->small_charge : '' ; }} @endif" />
                                            @error('small_charge')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Large Breed</label>
                                            <input class="form-control @error('large_charge') is-invalid @enderror" type="text" name="large_charge" placeholder="Enter Package Charge" value="@if(empty($get_package)) {{ old('large_charge') }} @else {{ (isset($get_package)) ? $get_package->large_charge : '' ; }} @endif" />
                                            @error('large_charge')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Gaint Breed</label>
                                            <input class="form-control @error('gaint_charge') is-invalid @enderror" type="text" name="gaint_charge" placeholder="Enter Package Charge" value="@if(empty($get_package)) {{ old('gaint_charge') }} @else {{ (isset($get_package)) ? $get_package->gaint_charge : '' ; }} @endif" />
                                            @error('gaint_charge')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                <div class="col-md-12">
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
                                        <th class="text-nowrap">Title</th>
                                        <th class="text-nowrap">Small Breed</th>
                                        <th class="text-nowrap">Large Breed</th>
                                        <th class="text-nowrap">Gaint Breed</th>
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
                                        <td>{{ $package->title }}</td>
                                        <td>{{ $package->small_charge }}</td>
                                        <td>{{ $package->large_charge }}</td>
                                        <td>{{ $package->gaint_charge }}</td>
                                        <td>{{ \Carbon\Carbon::parse($package->created_at)->format('d F Y h:i A') }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $package->id }}" {{ ($package->status==1) ? 'checked' : '' }}  onchange="ChangeStatus('packages',{{ $package->id }});" >
                                              </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <ul class="dropdown-menu p-3 shadow-lg" aria-labelledby="dropdownMenuLink" style="min-width: 300px;">
                                                    @foreach ($service as $row)
                                                    @php
                                                        $items = DB::table('add_package_service')
                                                            ->where('package_id', $package->id)
                                                            ->where('service_id', $row->id)
                                                            ->first();
                                                    @endphp
                                                    <li class="d-flex align-items-center justify-content-between mb-2">
                                                        <label class="form-check-label mb-0" for="service-{{ $row->id }}">{{ $row->title }}</label>
                                                        <input type="checkbox"
                                                            id="service-{{ $row->id }}"
                                                            name="add_permission"
                                                            class="form-check-input ms-2"
                                                            data-package="{{ $package->id }}"
                                                            data-service="{{ $row->id }}"
                                                            {{ (isset($items) && $items->status == 1) ? 'checked' : '' }}>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>

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

