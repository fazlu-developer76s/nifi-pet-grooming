@extends('layouts/app')
@section('content')
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Lead</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Qualified List Lead</li>
                    </ol>
                    <h1 class="page-header mb-0"> Qualified Lead</h1>
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
                            Qualified Lead List

                        </div>


                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>

                                        <th width="1%"></th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Mobile No.</th>
                                        <th class="text-nowrap">Work</th>
                                        <th class="text-nowrap">Loan Amount</th>
                                        <th class="text-nowrap">User Name</th>
                                        <th class="text-nowrap">Created Date</th>
                                        <th class="text-nowrap">Lead Status</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($alllead)
                                        @foreach ($alllead as $lead)
                                            @switch($lead->kyc_status)
                                                @case(1)
                                                    @php $kyc_status =  "Pending_Kyc"  @endphp
                                                @break

                                                @case(2)
                                                    @php $kyc_status =  "Submited"  @endphp
                                                @break

                                                @case(3)
                                                    @php $kyc_status =  "Approved"  @endphp
                                                @break

                                                @case(4)
                                                    @php $kyc_status =  "Rejected"  @endphp
                                                @break

                                                @default
                                            @endswitch
                                            <tr class="odd gradeX">
                                                <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                                <td>{{ ucwords(@$lead->lead_name) }}</td>
                                                <td>{{ @$lead->lead_mobile }}</td>
                                                <td>{{ @$lead->lead_work }}</td>
                                                <td>{{ @$lead->lead_loan_amount }}</td>
                                                <td>{{ ucwords(@$lead->username) }}</td>
                                                <td>{{ \Carbon\Carbon::parse(@$lead->created_at)->format('d F Y h:i A') }}
                                                </td>
                                                <td>
                                                    <div class="loan_status {{ $kyc_status }}">
                                                        {{ str_replace('_', ' ', $kyc_status) }}</div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="flexSwitchCheckDefault{{ $lead->id }}"
                                                            {{ $lead->status == 1 ? 'checked' : '' }}
                                                            onchange="ChangeStatus('kyc_leads',{{ $lead->id }});">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('kyclead.view', $lead->id) }}"
                                                        class="text-success me-2">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    {{-- <form action="{{ route('lead.destroy', $lead->id) }}" method="POST"
                                                        style="display: inline;"> --}}
                                                        {{-- <a href="{{ route('lead.edit', $lead->id) }}" class="text-primary me-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('lead.destroy', $lead->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Are you sure you want to delete this lead?');">
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
