@extends('layouts/app')
@section('content')
@php $form_action = "refer.create" @endphp
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Coupon</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create Coupon</li>
                    </ol>
                    <h1 class="page-header mb-0">Coupon</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Coupon
                            </div>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ (isset($get_package)) ? $get_package->id : '' ; }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">
                                    {{-- <span> <a href="{{ route('refer') }}">Genrate Code</a> </span> --}}
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Coupon Code</label>
                                            <input class="form-control @error('coupon_code') is-invalid @enderror" type="text" name="coupon_code" placeholder="Enter Title" value="{{ rand(9999999999999999,0000000000000000); }}" readonly />
                                            @error('coupon_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Coupon Type</label>
                                            <select class="form-control @error('code_type') is-invalid @enderror" name="code_type">
                                                <option value="">Select Coupon Type</option>
                                                <option value="1" @if(old('code_type', $get_package->code_type ?? '') == '1') selected @endif>Flat</option>
                                                <option value="2" @if(old('code_type', $get_package->code_type ?? '') == '2') selected @endif>Percentage</option>
                                            </select>
                                            @error('code_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Coupon Value</label>
                                            <input class="form-control @error('coupon_value') is-invalid @enderror" type="text" name="coupon_value" placeholder="Enter Coupon Charge" value="@if(empty($get_package)) {{ old('coupon_value') }} @else {{ (isset($get_package)) ? $get_package->coupon_value : '' ; }} @endif" />
                                            @error('coupon_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Is Coupon Resuable</label> <br>
                                            <input  type="checkbox" name="is_coupon_reused" placeholder="Enter Coupon Charge" value="1" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Coupon Expiry</label>
                                            <input class="form-control @error('expiry_date') is-invalid @enderror" type="date" name="expiry_date" placeholder="Enter Coupon Charge" value="{{ old('expiry_date') }}" />
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
                            Coupon List
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Code</th>
                                        <th class="text-nowrap">Type</th>
                                        <th class="text-nowrap">Value</th>
                                        <th class="text-nowrap">Expiry Date</th>
                                        <th class="text-nowrap">Is Reusable</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Is Coupon Used</th>
                                        {{-- <th class="text-nowrap">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($allrefer)
                                    @foreach ($allrefer as $coupon)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                        <td>{{ $coupon->coupon_code }}</td>
                                        <td>{{ ($coupon->code_type==1) ? 'Flat' : 'Percentage'; }}</td>
                                        <td>{{ $coupon->value }}</td>
                                        <td>{{ ($coupon->expiry_date) ? \Carbon\Carbon::parse($coupon->expiry_date)->format('d F Y') : 'N/A' ; }}</td>
                                        <td>{{ ($coupon->is_coupon_reused==1)? 'Yes' :'No'; }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $coupon->id }}" {{ ($coupon->status==1) ? 'checked' : '' }}  onchange="ChangeStatus('refers',{{ $coupon->id }});" >
                                              </div>
                                        </td>
                                        <td>{{ ($coupon->is_used_coupon==1)? 'Yes' :'No'; }}</td>
                                        <td>
                                            {{-- <a href="{{ route('refer.edit', $coupon->id) }}" class="text-primary me-2">
                                                <i class="fa fa-edit"></i>
                                            </a> --}}
                                            {{-- <form action="{{ route('refer.destroy', $coupon->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this package?');">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form> --}}
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

