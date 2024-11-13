@extends('layouts/app')
@section('content')
    <style>
        .modal-content {
            margin-top: 300px;
        }
    </style>
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
                <!-- Table Section -->

                <div class="col-md-12">

                    <div class="card border-0 mb-4">

                        <div class="card-header h6 mb-0 bg-none p-3 d-flex align-items-center"
                            style="border-bottom: 1px solid #2196f3;">
                            <i class="fab fa-buromobelexperte fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                            Member List
                            <a href="{{ route('member.create') }}" class="ms-auto">
                                <button class="btn btn-primary">Create User</button>
                            </a>

                        </div>
                        <div class="container mt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="GET" action="{{ route('member.kyc') }}" class="row g-3">
                                        <!-- KYC Status Dropdown -->
                                        <div class="col-md-3">
                                            <label for="kyc_status" class="form-label">KYC Status</label>
                                            <select id="kyc_status" name="kyc_status" class="form-select">
                                                <option value="">Select Status</option>
                                                <option value="1" {{ request('kyc_status') == 1 ? 'selected' : '' }}>Submitted</option>
                                                <option value="2" {{ request('kyc_status') == 2 ? 'selected' : '' }}>Pending</option>
                                                <option value="3" {{ request('kyc_status') == 3 ? 'selected' : '' }}>Approved</option>
                                                <option value="4" {{ request('kyc_status') == 4 ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </div>

                                        <!-- From Date -->
                                        <div class="col-md-3">
                                            <label for="from_date" class="form-label">From Date</label>
                                            <input
                                                type="date"
                                                id="from_date"
                                                name="from_date"
                                                class="form-control"
                                                value="{{ request('from_date') }}"
                                            >
                                        </div>

                                        <!-- To Date -->
                                        <div class="col-md-3">
                                            <label for="to_date" class="form-label">To Date</label>
                                            <input
                                                type="date"
                                                id="to_date"
                                                name="to_date"
                                                class="form-control"
                                                value="{{ request('to_date') }}"
                                            >
                                        </div>

                                        <!-- Search Button -->
                                        <div class="col-md-3 d-flex align-items-end">
                                            <a href="{{ route('member.kyc') }}"><button type="button" class="btn btn-primary w-100">Clear</button></a>
                                            <button type="submit" class="btn btn-primary w-100 mx-3">Search</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Name </th>
                                        <th class="text-nowrap">Email</th>
                                        <th class="text-nowrap">Mobile No.</th>
                                        <th class="text-nowrap">Role</th>
                                        <th class="text-nowrap">KYC Status</th>
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($allkyc)
                                        @foreach ($allkyc as $member)
                                            @switch($member->kyc_status)
                                                @case(1)
                                                    @php
                                                        $kyc_status = 'Submitted';
                                                        $class = 'bg-success';
                                                    @endphp
                                                @break

                                                @case(2)
                                                    @php
                                                        $kyc_status = 'Pending';
                                                        $class = 'bg-warning';
                                                    @endphp
                                                @break

                                                @case(3)
                                                    @php
                                                        $kyc_status = 'Approved';
                                                        $class = 'bg-primary';
                                                    @endphp
                                                @break

                                                @case(4)
                                                    {{-- Changed to 4 to avoid duplicate --}}
                                                    @php
                                                        $kyc_status = 'Rejected';
                                                        $class = 'bg-danger';
                                                    @endphp
                                                @break

                                                @default
                                                    @php
                                                        $kyc_status = 'N/A';
                                                        $class = '';
                                                    @endphp
                                            @endswitch

                                            <tr class="odd gradeX {{ $class }}">
                                                <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                                <td>{{ $member->user_name }}</td>
                                                <td>{{ $member->email }}</td>
                                                <td>{{ $member->mobile_no }}</td>
                                                <td>{{ $member->role_title }}</td>
                                                <td>{{ $kyc_status }}</td>
                                                <td>{{ \Carbon\Carbon::parse($member->created_at)->format('d F Y h:i A') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('view.member.kyc', $member->id) }}"
                                                        class="text-primary me-2">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
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

    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verify Email Otp</h5>
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <div class="modal-body">
                    <form id="modalForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Enter Otp</label>
                            <input type="number" class="form-control" id="user_location_otp" required autocomplete="offf">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="checkUserLocationOtp();">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
