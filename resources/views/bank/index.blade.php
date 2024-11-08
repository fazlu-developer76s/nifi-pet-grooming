@extends('layouts/app')
@section('content')
@if(isset($get_bank))
@php $form_action = "bank.update" @endphp
@else
@php $form_action = "bank.create" @endphp
@endif
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Bank Details</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create bank Detail</li>
                    </ol>
                    <h1 class="page-header mb-0">Banks</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <div class="col-md-5">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Service
                            </div>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ (isset($get_bank)) ? $get_bank->id : '' ; }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account Name</label>
                                            <input class="form-control @error('account_name') is-invalid @enderror" type="text" name="account_name" placeholder="Enter Account Name" value="@if(empty($get_bank)){{ old('account_name') }}@else {{ (isset($get_bank)) ? $get_bank->account_name : '' ; }} @endif" />
                                            @error('account_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                  <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Account No.</label>
                                            <input class="form-control @error('account_no') is-invalid @enderror" type="text" name="account_no" placeholder="Enter Account No" value="@if(empty($get_bank)){{ old('account_no') }}@else {{ (isset($get_bank)) ? $get_bank->account_no : '' ; }} @endif" />
                                            @error('account_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div><div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Bank Name</label>
                                            <input class="form-control @error('bank_name') is-invalid @enderror" type="text" name="bank_name" placeholder="Enter Bank Name" value="@if(empty($get_bank)){{ old('bank_name') }}@else {{ (isset($get_bank)) ? $get_bank->bank_name : '' ; }} @endif" />
                                            @error('bank_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div><div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">IFSC Code</label>
                                            <input class="form-control @error('ifsc_code') is-invalid @enderror" type="text" name="ifsc_code" placeholder="Enter IFSC Code" value="@if(empty($get_bank)){{ old('ifsc_code') }}@else {{ (isset($get_bank)) ? $get_bank->ifsc_code : '' ; }} @endif" />
                                            @error('ifsc_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Type</label>
                                            <select class="form-control custom-select-icon @error('type') is-invalid @enderror" name="type">
                                                <option value="1" {{ old('type') == 1 ? 'selected' : '' }} {{ (isset($get_bank) && $get_bank->type == 1) ? 'selected' : '' ; }}>Account</option>
                                                <option value="2" {{ old('type') == 2 ? 'selected' : '' }} {{ (isset($get_bank) && $get_bank->type == 2) ? 'selected' : '' ; }}>UPI</option>
                                            </select>
                                            @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Used For</label>
                                            <select class="form-control custom-select-icon @error('used_for') is-invalid @enderror" name="used_for">
                                                <option value="1" {{ old('used_for') == 1 ? 'selected' : '' }} {{ (isset($get_bank) && $get_bank->used_for == 1) ? 'selected' : '' ; }}>Collection</option>
                                                <option value="2" {{ old('used_for') == 2 ? 'selected' : '' }} {{ (isset($get_bank) && $get_bank->used_for == 2) ? 'selected' : '' ; }}>Disbursment</option>
                                            </select>
                                            @error('type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-control custom-select-icon @error('status') is-invalid @enderror" name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }} {{ (isset($get_bank) && $get_bank->status == 1) ? 'selected' : '' ; }}>Active</option>
                                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }} {{ (isset($get_bank) && $get_bank->status == 2) ? 'selected' : '' ; }}>Inactive</option>
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
                <div class="col-md-7">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex align-items-center" style="border-bottom: 1px solid #2196f3;">
                            <i class="fab fa-buromobelexperte fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                            Bank Detail List
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Acc. Name</th>
                                        <th class="text-nowrap">Acc. No</th>
                                        <th class="text-nowrap">Bank Name</th>
                                        <th class="text-nowrap">IFSC Code</th>
                                        <th class="text-nowrap">Type</th>
                                        <th class="text-nowrap">Used For</th>
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($bank)
                                    @foreach ($bank as $bank)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                        <td>{{ $bank->account_name }}</td>
                                        <td>{{ $bank->account_no }}</td>
                                        <td>{{ $bank->bank_name }}</td>
                                        <td>{{ $bank->ifsc_code }}</td>
                                        <td>{{ ($bank->type==1) ? 'Account' : 'UPI'; }}</td>
                                        <td>{{ ($bank->used_for==1) ? 'Collection' : 'Disbursement'; }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bank->created_at)->format('d F Y h:i A') }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault{{ $bank->id }}" {{ ($bank->status==1) ? 'checked' : '' }}  onchange="ChangeStatus('banks',{{ $bank->id }});" >
                                              </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('bank.edit', $bank->id) }}" class="text-primary me-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('bank.destroy', $bank->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this bank ?');">
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
