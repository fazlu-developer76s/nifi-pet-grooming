@extends('layouts/app')

@section('content')
    <style>
        strong {
            font-weight: bold;
        }

        .lead-status-badge {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 12px;
        }

        .info_div {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .first_div {
            flex: 0 0 40%;
            text-align: left;
        }

        .second_div {
            flex: 0 0 55%;
            text-align: left;
        }

        .container-fluid {
            padding: 0 2rem;
        }

        .page-header {
            margin-bottom: 1rem;
        }

        .breadcrumb-item {
            font-size: 0.9rem;
        }

        .card {
            margin-bottom: 2rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        @media (max-width: 768px) {
            .info_div {
                flex-direction: column;
                text-align: left;
            }

            .second_div {
                text-align: left;
                margin-top: 0.5rem;
            }
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
        }
        .custom-label {
            font-weight: bold;
        }
        .bordered {
            border: 1px solid #000;
            padding: 10px;
        }
        .checkbox-inline input {
            margin-left: 5px;
            margin-right: 5px;
        }

    </style>

    @php
        $form_action = isset($get_lead[0]) ? 'lead.update' : 'lead.create';
    @endphp

    <input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" id="lead_id" value="{{ isset($get_lead[0]) ? $get_lead[0]->id : '' }}">

    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-4">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Lead</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Lead Kyc</li>
                    </ol>
                    <h1 class="page-header mb-0">Lead Kyc</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white d-flex align-items-center">
                            <h4 class="mb-0">Lead Kyc Information</h4>
                        </div>

                        @php
                            $kyc_status = match ($get_lead[0]->kyc_status ?? 0) {
                                1 => 'Pending',
                                2 => 'Submitted',
                                3 => 'Approved',
                                4 => 'Rejected',
                                default => 'Unknown',
                            };
                        @endphp
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-12">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="custom-label">File No:</label>
                                            <input type="text" class="form-control" value="{{ $get_lead[0]->lead_file_no }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="custom-label">Date:</label>
                                            <input type="text" class="form-control" value="{{ date('d-m-Y',strtotime($get_lead[0]->created_at)) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="custom-label">Route No:</label>
                                            <input type="text" class="form-control" value="{{ @$get_lead[0]->route_no }}">
                                        </div>
                                    </div>

                                    <!-- Customer Info -->
                                    <div class="bordered mb-3">
                                        <h6 class="section-title text-primary">Customer Information</h6>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Customer Name:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->lead_name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">S/o, D/o, W/o:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->son_of }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Aadhar No.:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->aadhar_no }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Pan No.:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->pan_no }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Type of Work:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->type_of_work }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Shop Address:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->lead_address }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Shop Type:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="shopType" value="own" {{ $get_lead[0]->shop_type==1 ? 'checked' : ' ' ; }}>
                                                    <label class="form-check-label">Own</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="shopType" value="rented" {{ $get_lead[0]->shop_type==2 ? 'checked' : ' ' ; }}>
                                                    <label class="form-check-label">Rented</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Home Address:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->lead_home_address }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Home Type:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="homeType" value="own" {{ $get_lead[0]->lead_home_type=="OWN" ? 'checked' : ' ' ; }}>
                                                    <label class="form-check-label">Own</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="homeType" value="rented" {{ $get_lead[0]->lead_home_type=="RENTED" ? 'checked' : ' ' ; }}>
                                                    <label class="form-check-label">Rented</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Marital Status:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="maritalStatus" value="married" {{ $get_lead[0]->material_status==1 ? 'checked' : ' ' ; }}>
                                                    <label class="form-check-label">Married</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="maritalStatus" value="single" {{ $get_lead[0]->material_status==2 ? 'checked' : ' ' ; }}>
                                                    <label class="form-check-label">Single</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Mobile No:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->lead_mobile }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">SMS No:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->sms_no }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label class="custom-label">Reference 1 Name:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->reference_1_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-label">Reference 1 Mobile:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->reference_1_mobile }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-label">Reference 1 Realtion:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->reference_1_mobile }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label class="custom-label">Reference 2 Name:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->reference_2_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-label">Reference 2 Mobile:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->reference_2_mobile }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-label">Reference 2 Realtion:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->reference_2_mobile }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Loan Information -->
                                    <div class="bordered mb-3">
                                        <h6 class="section-title text-warning">Loan Information</h6>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Loan Amount:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->lead_loan_amount }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Processing Fees:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->processing_fees }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">EMI:</label>
                                                <input type="text" class="form-control" value="{{ $get_lead[0]->emi }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Cheque:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cheque" value="yes" {{ $get_lead[0]->cheque==1 ? 'checked' : ' ' ; }}>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cheque" value="no"{{ $get_lead[0]->cheque==2 ? 'checked' : ' ' ; }}>
                                                    <label class="form-check-label">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Guarantor 1 Information -->
                                    @foreach ($get_lead as $lead)
                                    <div class="bordered mb-3">
                                        <h6 class="section-title text-success">Guarantor {{ $loop->iteration }}</h6>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Guarantor Name:</label>
                                                <input type="text" class="form-control" value="{{ $lead->guarantor_name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">S/o, D/o, W/o:</label>
                                                <input type="text" class="form-control" value="{{ $lead->guarantor_son_of }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Type of Work:</label>
                                                <input type="text" class="form-control" value="{{ $lead->guarantor_type_of_work }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Shop Address:</label>
                                                <input type="text" class="form-control" value="{{ $lead->guarantor_shop_address }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label class="custom-label">Mobile No:</label>
                                                <input type="text" class="form-control" value="{{ $lead->guarantor_mobile_no_1 }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-label">Alternate Mobile No:</label>
                                                <input type="text" class="form-control" value="{{ $lead->guarantor_mobile_no_2 }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="custom-label">Shop Type:</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="shopType{{ $loop->iteration }}" value="own" {{ $lead->guarantor_shop_type == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label">Own</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="shopType{{ $loop->iteration }}" value="rented" {{ $lead->guarantor_shop_type == 2 ? 'checked' : '' }}>
                                                    <label class="form-check-label">Rented</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Home Address:</label>
                                                <input type="text" class="form-control" value="{{ $lead->guarantor_home_address }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">L.Load:</label>
                                                <input type="text" class="form-control" value="{{ $lead->guarantor_land_load }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                    <!-- Attachements  Information -->
                                    <div class="bordered mb-3">
                                        <h6 class="section-title text-secondary">Attachements</h6>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Aadhar Card:</label> <br>
                                                @if($get_lead[0]->aadhar_docs)
                                                <a href="" class="">View Aadhar Card</a>
                                                @else
                                                <p class="mt-2">Not Available</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Pan Card:</label> <br>
                                                @if($get_lead[0]->pan_docs)
                                                <a href="" class="">View Pan Card</a>
                                                @else
                                                <p class="mt-2">Not Available</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Electricity Bill:</label> <br>
                                                @if($get_lead[0]->elec_bill)
                                                <a href="" class="">View Electricity Bill</a>
                                                @else
                                                <p class="mt-2">Not Available</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Photo:</label> <br>
                                                @if($get_lead[0]->photo)
                                                <a href="" class="">View Photo</a>
                                                @else
                                                <p class="mt-2">Not Available</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Businness Pic:</label> <br>
                                                @if($get_lead[0]->business_pic)
                                                <a href="" class="">View Businness Pic</a>
                                                @else
                                                <p class="mt-2">Not Available</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Gurn Docs:</label> <br>
                                                @if($get_lead[0]->gurn_docs)
                                                <a href="" class="">View Gurn Docs</a>
                                                @else
                                                <p class="mt-2">Not Available</p>
                                                @endif
                                            </div>

                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <label class="custom-label">Side Verify:</label> <br>
                                                @if($get_lead[0]->side_verify)
                                                <a href="" class="">View Side Verify</a>
                                                @else
                                                <p class="mt-2">Not Available</p>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <label class="custom-label">Rc Vehcile:</label> <br>
                                                @if($get_lead[0]->rc_vehicle)
                                                <a href="" class="">View Rc Vehcile</a>
                                                @else
                                                <p class="mt-2">Not Available</p>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                    <div class="bordered mb-3">
                                        <h6 class="section-title text-danger">Remark</h6>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                @if($get_lead[0]->remark)
                                                <p class="mt-2">{{ $get_lead[0]->remark }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-12">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><strong>Kyc Status:</strong></td>
                                        <td>
                                            <span class="badge {{ $kyc_status == 'Pending' ? 'bg-warning' : ($kyc_status == 'Submitted' ? 'bg-info' : ($kyc_status == 'Approved' ? 'bg-success' : 'bg-danger')) }} lead-status-badge">
                                                {{ $kyc_status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Qualified By:</strong></td>
                                        <td>{{ ucwords($get_lead[0]->username ?? 'N/A') }}</td>
                                    </tr>
                                    @if($get_lead[0]->kyc_status > 2)
                                    <tr>
                                        <td><strong>Submitted By:</strong></td>
                                        <td>{{ ucwords($get_lead[0]->agent_name ?? 'N/A') }}</td>
                                    </tr>
                                    @endif
                                    @if($get_lead[0]->kyc_status == 2)
                                    <tr>
                                        <td><strong>Change Kyc Status:</strong></td>
                                        <td>
                                            <select id="routeSelect" onchange="Change_kyc_status({{ $get_lead[0]->id }});">
                                                <option value="">Select Kyc Status</option>
                                                <option value="3" {{ $get_lead[0]->kyc_status == 3 ? 'selected' : '' }}>Approved</option>
                                                <option value="4" {{ $get_lead[0]->kyc_status == 4 ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                           <!-- Loan Information -->
                           @if($get_lead[0]->kyc_status == 3)
                           <div class="bordered mb-3">
                            <h6 class="section-title text-info">Loan Disbursement Information</h6>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="custom-label">Loan Number:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->loan_number }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">Loan Amount:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->amount }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="custom-label">Rate Of Interest:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->rate_of_interest }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">Frequency:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->frequency }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="custom-label">Tenure:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->tenure }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">Process Charge:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->process_charge }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="custom-label">File Charge:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->file_charge }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">Other Charge 1:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->other_charges_1 }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="custom-label">Other Charge 2:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->other_charges_2 }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">Other Charge 3:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->other_charges_3 }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="custom-label">Other Charge 4:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->other_charges_4 }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="custom-label">Other Charge 5:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->other_charges_5 }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label class="custom-label">Disbursment Amount:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->disbrused_amount }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-label">Emi Amount:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->emi_amount }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="custom-label">Pending Amount:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->pending_amount }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="custom-label">Loan Start Date:</label>
                                    <input type="text" class="form-control" value="{{ $loan_detail->loan_start_date }}">
                                </div>
                                @switch($loan_detail->loan_status)
                                    @case(2)
                                    @php  $loan_status_msg = "Approved But Not Disbursment" @endphp
                                        @break
                                    @case(3)
                                    @php  $loan_status_msg = "Disbursment" @endphp
                                        @break
                                    @case(4)
                                    @php  $loan_status_msg = "Reject" @endphp
                                        @break
                                    @case(5)
                                    @php  $loan_status_msg = "Closed" @endphp
                                        @break

                                    @default
                                    @php  $loan_status_msg = "N/A" @endphp
                                    @break

                                @endswitch
                                <div class="col-md-6">
                                    <label class="custom-label">Loan Status:</label>
                                    <input type="text" class="form-control" value="{{ $loan_status_msg }}">
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Structure -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Kyc Approved Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myForm" action="{{route('kyc.process')}}" method="post">
                    @csrf
                    <input type="hidden" name="hidden_id" class="kyc_id">
                    <input type="hidden" name="kyc_status" class="kyc_status">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Rate Of Interest</label>
                                <input class="form-control" type="number" name="rate_of_interest" placeholder="Rate Of Interest" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="frequencySelect" class="form-label">Frequency</label>
                                <select class="form-select" id="frequencySelect" name="frequency" required >
                                  <option value="" selected>Select Frequency</option>
                                  <option value="1">Daily</option>
                                  <option value="2">Weekly</option>
                                  <option value="3">Monthly</option>
                                  <option value="4">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tenure</label>
                                <input class="form-control" type="number" name="tenure" placeholder="Enter Tenure" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Process Charge</label>
                                <input class="form-control" type="number" name="process_charge" placeholder="Enter Process Charge" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">File Charge</label>
                                <input class="form-control" type="number" name="file_charge" placeholder="Enter File Charge" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Other Charge 1</label>
                                <input class="form-control" type="number" name="other_charges_1" placeholder="Other Charge 1" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Other Charge 2</label>
                                <input class="form-control" type="number" name="other_charges_2" placeholder="Enter Other Charge 2" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Other Charge 3</label>
                                <input class="form-control" type="number" name="other_charges_3" placeholder="Enter Other Charge 3" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Other Charge 4</label>
                                <input class="form-control" type="number" name="other_charges_4" placeholder="Enter Other Charge 4" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Other Charge 5</label>
                                <input class="form-control" type="number" name="other_charges_5" placeholder="Enter Other Charge 5" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Loan Start Date</label>
                            <input class="form-control" type="date" name="start_date" placeholder="Enter Other Charge 5" value="{{ date('Y-m-d') }}" required />
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Modal Structure -->
<div class="modal fade" id="RejectModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Reject Kyc Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myForm" action="{{route('kyc.process')}}" method="post">
                    @csrf
                    <input type="hidden" name="hidden_id" class="kyc_id">
                    <input type="hidden" name="kyc_status" class="kyc_status">
                    <div class="mb-3">
                        <label for="name" class="form-label">Reason</label>
                        <textarea type="text" class="form-control" id="name" required name="reason"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
