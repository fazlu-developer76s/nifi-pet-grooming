@extends('layouts/app')
@section('content')
<style>
    .modal-content{
        margin-top: 100px; /* Adjusted for better center positioning */
    }
    .card-body {
        padding: 20px;
    }

    .member-info, .aadhar-info, .pan-info, .bank-info {
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .member-info p, .aadhar-info p, .pan-info p, .bank-info p {
        font-size: 14px;
        line-height: 1.6;
    }

    .member-info hr, .aadhar-info hr, .pan-info hr, .bank-info hr {
        margin-top: 15px;
        margin-bottom: 15px;
    }

    .text-center {
        text-align: center;
    }

    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .rounded {
        border-radius: 8px;
    }

    .card-body .row {
        margin-top: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .card-body .row {
            flex-direction: column;
        }

        .col-md-6 {
            margin-bottom: 20px;
        }
    }

    /* Modal styling */
    .modal-body {
        padding: 20px; /* Added padding for better spacing */
    }

    .form-label {
        margin-bottom: 10px; /* Space between label and input field */
    }

    .form-control {
        margin-bottom: 15px; /* Adds spacing below the input field */
    }

    .modal-header {
        padding-bottom: 10px; /* Adjusts space between header and content */
    }

    .modal-footer {
        padding-top: 15px; /* Ensures the footer has space above it */
    }
</style>
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('member.kyc') }}">KYC Members</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Member Details</li>
                    </ol>
                    <h1 class="page-header mb-0">Member Details</h1>
                </div>
            </div>
            <!-- Member Details Section -->
            <div class="row">
                <!-- Member Detail Card -->
                <div class="col-md-12">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex align-items-center" style="border-bottom: 1px solid #2196f3;">
                            <i class="fab fa-buromobelexperte fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                            Member Information
                            <a href="{{ route('member.kyc') }}" class="ms-auto">
                                <button class="btn btn-secondary">Back to KYC Member List</button>
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <!-- Member Info Section -->
                                <div class="col-md-6">
                                    <div class="member-info">
                                        <hr>
                                        <h4 class="text-center text-primary">Member Info</h4>
                                        <hr>
                                        <p><strong>Name:</strong> {{ @$member->user_name }}</p>
                                        <p><strong>Email:</strong> {{ @$member->email }}</p>
                                        <p><strong>Mobile No:</strong> {{ @$member->mobile_no }}</p>
                                        <p><strong>Role:</strong> {{ @$member->role_title }}</p>
                                        <p><strong>KYC Status:</strong>
                                            @if($member->kyc_status == 1)
                                                Pending
                                            @elseif($member->kyc_status == 2)
                                                Approved
                                            @else
                                                Rejected
                                            @endif
                                        </p>
                                        <p><strong>Update KYC Status:</strong></p>
                                        <form action="{{ route('update.kyc.status', $member->id) }}" method="POST">
                                            @csrf
                                            @method('PUT') <!-- Assuming you're using PUT method for updates -->
                                            <select name="kyc_status" class="form-select" aria-label="Update KYC Status">
                                                <option value="1">Select Kyc Status</option>
                                                <option value="2" @if($member->kyc_status == 2) selected @endif>Pending</option>
                                                <option value="3" @if($member->kyc_status == 3) selected @endif>Approved</option>
                                                <option value="4" @if($member->kyc_status == 4) selected @endif>Rejected</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Aadhar Info Section -->
                                <div class="col-md-6">
                                    <div class="aadhar-info">
                                        <hr>
                                        <h4 class="text-center text-success">Aadhar Info</h4>
                                        <hr>
                                        <div class="aadhar-photo">
                                            <strong>Aadhar Image:</strong> <img class="img-fluid rounded" src="data:image/jpeg;base64,{{ @$member->aadhar_profile_photo }}" alt="Aadhar Photo">
                                        </div>
                                        <p><strong>Aadhar No:</strong> {{ @$member->aadhar_no }}</p>
                                        <p><strong>Father's Name:</strong> {{ @$member->aadhar_father_name }}</p>
                                        <p><strong>Date of Birth:</strong> {{ @$member->aadhar_dob }}</p>
                                        <p><strong>Mobile No:</strong> {{ @$member->aadhar_mobile_no }}</p>
                                        <p><strong>Zipcode:</strong> {{ @$member->aadhar_zipcode }}</p>
                                        <p><strong>Country:</strong> {{ @$member->aadhar_country }}</p>
                                        <p><strong>State:</strong> {{ @$member->aadhar_state }}</p>
                                        <p><strong>City:</strong> {{ @$member->aadhar_city }}</p>
                                        <p><strong>Address:</strong> {{ @$member->aadhar_address }}</p>
                                        <p><strong>Status:</strong> {{ ($member->is_aadhar_verified == 1) ? "Verified":'Not Verified' ;}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- PAN Info Section -->
                                <div class="col-md-6">
                                    <div class="pan-info">
                                        <hr>
                                        <h4 class="text-center text-warning">PAN Info</h4>
                                        <hr>
                                        <p><strong>PAN Number:</strong> {{ @$member->pan_no }}</p>
                                        <p><strong>Name on PAN:</strong> {{ @$member->pan_name }}</p>
                                        <p><strong>Status:</strong> {{ ($member->is_pan_verified == 1) ? "Verified":'Not Verified' ;}}</p>
                                    </div>
                                </div>
                                <!-- Bank Info Section -->
                                <div class="col-md-6">
                                    <div class="bank-info">
                                        <hr>
                                        <h4 class="text-center text-info">Bank Info</h4>
                                        <hr>
                                        <p><strong>Bank Name:</strong> {{ @$member->bank_name }}</p>
                                        <p><strong>Account Number:</strong> {{ @$member->account_no }}</p>
                                        <p><strong>IFSC Code:</strong> {{ @$member->ifsc_code }}</p>
                                        <p><strong>Account Holder's Name:</strong> {{ @$member->account_holder_name }}</p>
                                        <p><strong>Status:</strong> {{ ($member->is_bank_verified == 1) ? "Verified":'Not Verified' ;}}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bank-info">
                                        <hr>
                                        <h4 class="text-center text-info">Live Photo</h4>
                                        <img class="img-fluid rounded"src="{{ asset('storage/' . (optional(@$member)->live_photo ?: 'default-placeholder.jpg')) }}"alt="Aadhar Photo" width="50%">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="bank-info">
                                        <hr>
                                        <h4 class="text-center text-info">Live Video</h4>
                                        <video class="img-fluid rounded" controls width="100%">
                                            <source src="{{ asset('storage/' . (optional($member)->live_video ?: 'default-placeholder.mp4')) }}" type="video/mp4" ">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Section (For OTP verification, if needed) -->
            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Verify Email Otp</h5>
                        </div>
                        <div class="modal-body">
                            <form id="modalForm">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Enter Otp</label>
                                    <input type="number" class="form-control" id="user_location_otp" required autocomplete="off">
                                </div>
                                <button type="button" class="btn btn-primary" onclick="checkUserLocationOtp();">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
