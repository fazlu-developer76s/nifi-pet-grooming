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
    </style>
    @if (isset($get_booking))
        @php $form_action = "lead.update"; @endphp
    @else
        @php $form_action = "lead.create"; @endphp
    @endif
    <input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" id="lead_id" value="{{ isset($get_booking) ? $get_booking->id : ' ' }}">
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Booking</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> View Booking</li>
                    </ol>
                    <h1 class="page-header mb-0">Booking</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <!-- Form Section -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Booking Information</h4>
                        </div>
                        @switch($get_booking->booking_status)
                            @case(1)
                                @php $loan_status = "Pending"; @endphp
                            @break

                            @case(2)
                                @php $loan_status = "Accept"; @endphp
                            @break

                            @case(3)
                                @php $loan_status = "Complete"; @endphp
                            @break

                            @case(4)
                                @php $loan_status = "Cancel"; @endphp
                            @break

                            @default
                                @php $loan_status = "Unknown"; @endphp
                        @endswitch
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Package Name:</strong></td>
                                            <td>{{ ucwords($get_booking->package_name ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Package Type:</strong></td>
                                            <td>{{ $get_booking->package_type ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Booking Time:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse(@$get_booking->booking_time)->format('h:i A') ?? 'N/A' }}
                                        </tr>
                                        <tr>
                                            <td><strong>Booking Date:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($get_booking->created_at)->format('d F Y h:i A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Booking Amount:</strong></td>
                                            <td>{{ $get_booking->booking_amount ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Admin Tax Amount:</strong></td>
                                            <td>{{ $get_booking->tax_amount ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Amount:</strong></td>
                                            <td>{{ $get_booking->total_amount ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Booking Status:</strong></td>
                                            <td id="fetch_loan_status">
                                                {{ isset($loan_status) ? str_replace('_', ' ', $loan_status) : 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Booking Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>User Name:</strong></td>
                                            <td>{{ ucwords($get_booking->post_user_name ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>User Image:</strong></td>
                                            <td>

                                                @if (!empty($get_booking->post_user_image))
                                                       <img src="{{ asset('storage/' . $get_booking->post_user_image) }}"
                                                           alt="Pet Image" width="100">
                                                   @else
                                                       N/A
                                                   @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>User Email:</strong></td>
                                            <td>{{ ucwords($get_booking->post_user_email ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>User Mobile :</strong></td>
                                            <td>{{ ucwords($get_booking->post_user_mobile_no ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong> Accept User Name:</strong></td>
                                            <td>{{ ucwords($get_booking->accept_user_name ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong> Accept User Image:</strong></td>
                                            <td>

                                                @if (!empty($get_booking->accept_user_image))
                                                       <img src="{{ asset('storage/' . $get_booking->accept_user_image) }}"
                                                           alt="Pet Image" width="100">
                                                   @else
                                                       N/A
                                                   @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong> Accept User Email:</strong></td>
                                            <td>{{ ucwords($get_booking->accept_user_email ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong> Accept User Mobile :</strong></td>
                                            <td>{{ ucwords($get_booking->accept_user_mobile_no ?? 'N/A') }}</td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Pet Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Pet Name:</strong></td>
                                            <td>{{ $get_booking->pet_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pet Image:</strong></td>
                                            <td>
                                                @if (!empty($get_booking->pet_image))
                                                    <img src="{{ asset('storage/' . $get_booking->pet_image) }}"
                                                        alt="Pet Image" width="100">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pet Gender:</strong></td>
                                            <td>{{ $get_booking->pet_gender ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pet Type:</strong></td>
                                            <td>{{ $get_booking->pet_type ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pet Breed:</strong></td>
                                            <td>{{ $get_booking->pet_breed ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pet Weight:</strong></td>
                                            <td>{{ $get_booking->pet_weight ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pet Age:</strong></td>
                                            <td>{{ $get_booking->pet_age ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pet Aggression:</strong></td>
                                            <td>{{ $get_booking->pet_aggression ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pet Vaccinated:</strong></td>
                                            <td>{{ $get_booking->pet_vaccinated ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Address Information</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td><strong>Flat / House No.:</strong></td>
                                        <td>{{ $get_booking->flat_house_no ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Area / Sector / Locality:</strong></td>
                                        <td>{{ $get_booking->area_sector_locality ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>City / District:</strong></td>
                                        <td>{{ $get_booking->city_district ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>State:</strong></td>
                                        <td>{{ $get_booking->state ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pincode:</strong></td>
                                        <td>{{ $get_booking->pincode ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Complete Address:</strong></td>
                                        <td>{{ $get_booking->complete_address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email Address:</strong></td>
                                        <td>{{ $get_booking->email_address ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Payment In Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Payment ID:</strong></td>
                                            <td>{{ $get_booking->payment_in_id ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Order ID:</strong></td>
                                            <td>{{ $get_booking->payment_in_order_id ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Method:</strong></td>
                                            <td>{{ $get_booking->payment_in_method ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Amount Paid:</strong></td>
                                            <td>₹{{ number_format($get_booking->payment_in_amount, 2) ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status:</strong></td>
                                            <td>{{ ucwords($get_booking->payment_in_status ?? 'N/A') }}</td>
                                        </tr>
                                           <tr>
                                            <td><strong>Payment Date:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($get_booking->payment_in_date)->format('d F Y h:i A') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Payment Out Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Payment ID:</strong></td>
                                            <td>{{ $get_booking->payment_out_id ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Order ID:</strong></td>
                                            <td>{{ $get_booking->payment_out_order_id ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Method:</strong></td>
                                            <td>{{ $get_booking->payment_out_method ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Amount Paid:</strong></td>
                                            <td>₹{{ number_format($get_booking->payment_out_amount, 2) ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Status:</strong></td>
                                            <td>{{ ucwords($get_booking->payment_out_status ?? 'N/A') }}</td>
                                        </tr>
                                           <tr>
                                            <td><strong>Payment Date:</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($get_booking->payment_out_date)->format('d F Y h:i A') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
