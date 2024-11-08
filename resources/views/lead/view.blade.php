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

    @if (isset($get_lead))
        @php $form_action = "lead.update"; @endphp
    @else
        @php $form_action = "lead.create"; @endphp
    @endif
    <input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
    <input type="hidden" id="lead_id" value="{{ isset($get_lead) ? $get_lead->id : ' ' }}">
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Lead</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Create Lead</li>
                    </ol>
                    <h1 class="page-header mb-0">Lead</h1>
                </div>
            </div>

            <!-- Row for equal division -->
            <div class="row">
                <!-- Form Section -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Lead Information</h4>
                        </div>

                        @switch($get_lead->loan_status)
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
                                                <td><strong>Lead Date:</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($get_lead->lead_create_date)->format('d F Y h:i A') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Work:</strong></td>
                                                <td>{{ $get_lead->work ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Work Address:</strong></td>
                                                <td>{{ $get_lead->work_address ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shop/Thiya:</strong></td>
                                                <td>{{ $get_lead->shop_thiya ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Home Address:</strong></td>
                                                <td>{{ $get_lead->home_address ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Loan Amount:</strong></td>
                                                <td>{{ $get_lead->loan_amount ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Balance :</strong></td>
                                                <td>{{ $get_lead->balance ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Old Loan :</strong></td>
                                                <td>{{ $get_lead->old_loan ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>File No. :</strong></td>
                                                <td>{{ $get_lead->old_loan ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>R. N. No. :</strong></td>
                                                <td>{{ $get_lead->old_loan ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Accountant Sign :</strong></td>
                                                <td>{{ $get_lead->old_loan ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Guarantor Name:</strong></td>
                                                <td>{{ $get_lead->old_loan ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Remark:</strong></td>
                                                <td>{{ $get_lead->reason_of_loan ?? 'N/A' }}</td>
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
                                                <td>{{ ucwords($get_lead->name ?? 'N/A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone:</strong></td>
                                                <td>{{ $get_lead->mobile ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Cheque:</strong></td>
                                                <td>{{ $get_lead->cheque ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Home Type:</strong></td>
                                                <td>{{ $get_lead->home_type ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>File Hain:</strong></td>
                                                <td>{{ $get_lead->file_hai ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tut:</strong></td>
                                                <td>{{ $get_lead->tut ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>+/-Day:</strong></td>
                                                <td>{{ $get_lead->plus_day ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Loan Type:</strong></td>
                                                <td>{{ $get_lead->loan_type ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Sr No:</strong></td>
                                                <td>{{ $get_lead->ser_no ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Amount :</strong></td>
                                                <td>{{ $get_lead->ser_no ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Guarantor:</strong></td>
                                                <td>{{ $get_lead->guarantor ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Service :</strong></td>
                                                <td>{{ $get_lead->service_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Lead Status:</strong></td>
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
                </div>
                @if ($get_lead->loan_status >= 3)
                    <div class="col-md-8">
                    @else
                        <div class="col-md-12">
                @endif

                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Activity Log</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group" id="note_html">
                            <!-- Notes will be appended here dynamically -->
                        </ul>
                        @if ($get_lead->loan_status < 3)
                            <button class="btn btn-outline-primary mt-5"
                                onclick="startDisscussion({{ isset($get_lead->id) ? $get_lead->id : ' ' }}, {{ Auth::user()->id }}, '');">Start
                                Discussion</button>
                        @endif
                    </div>
                </div>
            </div>

            @if ($get_lead->loan_status >= 3)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">Notes</h4>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">
                                @csrf
                                <!-- Textarea Field -->
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter your notes here"></textarea>

                                    <input type="hidden" id="hidden_id">
                                </div>
                                <!-- Select Field -->
                                <div class="mb-3">
                                    <label for="option" class="form-label">Select Status</label>
                                    <select class="form-select get_status" id="status" name="option" onchange="CheckStatus()">
                                        <option selected>Select an option</option>
                                        <option value="3" {{ $get_lead->loan_status == 3 ? 'selected' : '' }}>Under
                                            Discussion</option>
                                        {{-- <option value="4" {{ $get_lead->loan_status == 4 ? 'selected' : '' }}>Pending For KYC</option> --}}
                                        <option value="5" {{ $get_lead->loan_status == 5 ? 'selected' : '' }}>
                                            Qualified</option>
                                        <option value="6" {{ $get_lead->loan_status == 6 ? 'selected' : '' }}>Rejected
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 d-none select_route_id">
                                    <label for="option" class="form-label">Select Route</label>
                                    <select class="form-control custom-select-icon @error('route_id') is-invalid @enderror" name="route_id" id="select_route_id">
                                        <option value="">Select Route </option>
                                    @if($get_route)
                                        @foreach ($get_route as $route)
                                            <option value="{{ $route->id }}" >{{ ucwords($route->route) . ' ('. $route->title . ")"  }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                </div>
                                <!-- Submit Button -->
                                <span type="submit" class="btn btn-primary" onclick="return SaveNotes();">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection
