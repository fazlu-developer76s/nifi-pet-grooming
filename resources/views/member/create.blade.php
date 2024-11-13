@extends('layouts/app')
@section('content')
@if(isset($get_member))
@php $form_action = "member.update" @endphp
@else
@php $form_action = "member.create" @endphp
@endif
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Member</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create Member</li>
                    </ol>
                    <h1 class="page-header mb-0">Member</h1>
                </div>
            </div>

            <!-- Row for equal division -->
            <div class="row">
                <!-- Form Section -->
                <div class="col-md-8">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Member
                            </div>
                            <a href="{{ route('member') }}">
                                <button class="btn btn-primary">List User</button>
                            </a>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ (isset($get_member)) ? $get_member->id : '' ; }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Member Role </label>
                                            <select class="form-control custom-select-icon @error('role_id') is-invalid @enderror" name="role_id">
                                                <option value="">Select Role</option>
                                                @if($get_role)
                                                    @foreach ($get_role as $role)
                                                        <option value="{{ $role->id }}" @if(empty($get_member)) {{ old('role_id') == $role->id ? 'selected' : '' }} @else {{ (isset($get_member) && $get_member->role_id == $role->id) ? 'selected' : '' ; }} @endif>{{ $role->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('role_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Employee Type</label>
                                            <input class="form-control @error('employe_type') is-invalid @enderror" type="text" name="employe_type" placeholder="Enter employe_type" value="@if(empty($get_member)) {{ old('employe_type') }} @else {{ (isset($get_member)) ? $get_member->employe_type : '' ; }} @endif" />
                                            @error('employe_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Enter Name" value="@if(empty($get_member)) {{ old('name') }} @else {{ (isset($get_member)) ? $get_member->name : '' ; }} @endif" />
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter Email" value=" @if(empty($get_member)) {{ old('email') }} @else {{ (isset($get_member)) ? $get_member->email : '' ; }} @endif" />
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Mobile No.</label>
                                            <input class="form-control @error('mobile_no') is-invalid @enderror" type="text" name="mobile_no" placeholder="Enter Mobile No." value="@if(empty($get_member)) {{ old('mobile_no') }} @else {{ (isset($get_member)) ? $get_member->mobile_no : '' ; }} @endif" />
                                            @error('mobile_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Aadhar No.</label>
                                            <input class="form-control @error('aadhar_no') is-invalid @enderror" type="text" name="aadhar_no" placeholder="Enter Aadhar No." value="@if(empty($get_member)) {{ old('aadhar_no') }} @else {{ (isset($get_member)) ? $get_member->aadhar_no : '' ; }} @endif" />
                                            @error('aadhar_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Member Status</label>
                                            <select class="form-control custom-select-icon @error('status') is-invalid @enderror" name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }} {{ (isset($get_member) && $get_member->status == 1) ? 'selected' : '' ; }}>Active Member</option>
                                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }} {{ (isset($get_member) && $get_member->status == 2) ? 'selected' : '' ; }}>Inactive Member</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @if(empty($get_member))
                                     <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control @error('password') is-invalid @enderror" type="text" name="password" placeholder="Enter Name" value="@if(empty($get_member)) {{ old('password') }} @else {{ (isset($get_member)) ? $get_member->password : '' ; }} @endif" />
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer bg-none d-flex p-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
