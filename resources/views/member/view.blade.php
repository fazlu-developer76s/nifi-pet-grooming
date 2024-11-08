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

@php
    $form_action = isset($all_loan) ? "lead.update" : "lead.create";
@endphp

<div class="container-fluid">
    <div id="content" class="app-content">
        <div class="d-flex align-items-center mb-3">
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Borrower</a></li>
                    <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i>Loans</li>
                </ol>
                <h1 class="page-header mb-0">Borrower Loans</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Borrower Pending Loans Information</h4>
                    </div>


                    @switch($all_loan[0]->loan_status)
                        @case(1)
                            @php $loan_status = "Pending"; @endphp
                        @break

                        @case(2)
                            @php $loan_status = "View"; @endphp
                        @break

                        @case(3)
                            @php $loan_status = "Under_Discussion"; @endphp
                        @break

                        @case(4)
                            @php $loan_status = "Pending_Kyc"; @endphp
                        @break

                        @case(5)
                            @php $loan_status = "Qualified"; @endphp
                        @break

                        @case(6)
                            @php $loan_status = "Rejected"; @endphp
                        @break

                        @default
                            @php $loan_status = "Unknown"; @endphp
                    @endswitch
                    <div class="card-body">
                        @foreach ($running_loan as $pending)
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ ucwords($all_loan[0]->name ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $all_loan[0]->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $all_loan[0]->mobile ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Zipcode:</strong></td>
                                            <td>{{ $all_loan[0]->zip_code ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Address:</strong></td>
                                            <td>{{ $all_loan[0]->address ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Loan Amount:</strong></td>
                                            <td>{{ $all_loan[0]->loan_amount ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Borrower Status:</strong></td>
                                            <td id="fetch_loan_status">
                                                {{ isset($loan_status) ? str_replace('_',' ', $loan_status) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Reason For Loan:</strong></td>
                                            <td>{{ $all_loan[0]->reason_of_loan ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created By:</strong></td>
                                            <td>{{ isset($get_user->name) ? ucwords($get_user->name) : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ ucwords($all_loan[0]->name ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $all_loan[0]->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $all_loan[0]->mobile ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Zipcode:</strong></td>
                                            <td>{{ $all_loan[0]->zip_code ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Address:</strong></td>
                                            <td>{{ $all_loan[0]->address ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Loan Amount:</strong></td>
                                            <td>{{ $all_loan[0]->loan_amount ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Borrower Status:</strong></td>
                                            <td id="fetch_loan_status">
                                                {{ isset($loan_status) ? str_replace('_',' ', $loan_status) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Reason For Loan:</strong></td>
                                            <td>{{ $all_loan[0]->reason_of_loan ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created By:</strong></td>
                                            <td>{{ isset($get_user->name) ? ucwords($get_user->name) : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Borrower Close Loans Information</h4>
                    </div>

                    @switch($all_loan[0]->loan_status)
                        @case(1)
                            @php $loan_status = "Pending"; @endphp
                        @break

                        @case(2)
                            @php $loan_status = "View"; @endphp
                        @break

                        @case(3)
                            @php $loan_status = "Under_Discussion"; @endphp
                        @break

                        @case(4)
                            @php $loan_status = "Pending_Kyc"; @endphp
                        @break

                        @case(5)
                            @php $loan_status = "Qualified"; @endphp
                        @break

                        @case(6)
                            @php $loan_status = "Rejected"; @endphp
                        @break

                        @default
                            @php $loan_status = "Unknown"; @endphp
                    @endswitch
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ ucwords($all_loan[0]->name ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $all_loan[0]->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $all_loan[0]->mobile ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Zipcode:</strong></td>
                                            <td>{{ $all_loan[0]->zip_code ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Address:</strong></td>
                                            <td>{{ $all_loan[0]->address ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Loan Amount:</strong></td>
                                            <td>{{ $all_loan[0]->loan_amount ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Borrower Status:</strong></td>
                                            <td id="fetch_loan_status">
                                                {{ isset($loan_status) ? str_replace('_',' ', $loan_status) : 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Reason For Loan:</strong></td>
                                            <td>{{ $all_loan[0]->reason_of_loan ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created By:</strong></td>
                                            <td>{{ isset($get_user->name) ? ucwords($get_user->name) : 'N/A' }}</td>
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
