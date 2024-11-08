@extends('layouts/app')
@section('content')
    <style>
        .modal {

            /*From Right/Left */
            &.drawer {
                display: flex !important;
                pointer-events: none;

                * {
                    pointer-events: none;
                }

                .modal-dialog {
                    margin: 0px;
                    display: flex;
                    flex: auto;
                    transform: translate(25%, 0);

                    .modal-content {
                        border: none;
                        border-radius: 0px;

                        .modal-body {
                            overflow: auto;
                        }
                    }
                }

                &.show {
                    pointer-events: auto;

                    * {
                        pointer-events: auto;
                    }

                    .modal-dialog {
                        transform: translate(0, 0);
                    }
                }

                &.right-align {
                    flex-direction: row-reverse;
                }

                &.left-align {
                    &:not(.show) {
                        .modal-dialog {
                            transform: translate(-25%, 0);
                        }
                    }
                }
            }
        }
        .job-tracking-vertical {
            display: flex;
            flex-direction: column;
            position: relative;
            padding-left: 31px;
            margin-top: 30px;
        }

        .status {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }

        .status-text {
            margin-left: 10px;
        }

        /* All statuses will be green */
        .status-text i { color: green; }

        strong {
            margin-top: 10px !important;
        }

        /* Vertical Line */
        .job-tracking-vertical:before {
            content: '';
            position: absolute;
            left: 17px;
            height: 100%;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #ddd;
        }

        .status:before {
            content: '';
            position: absolute;
            left: -19px;
            top: 50%;
            width: 12px;
            height: 12px;
            background-color: white;
            border: 3px solid #ddd;
            border-radius: 50%;
            z-index: 1;
        }

        .status:before { border-color: green; }

        /* Ensure the vertical line stops at the last item */
        .status:last-child:before { bottom: 0; }

        .status-dot {
            /* width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
            background-color: green;  */
            /* All dots are green */
        }
    </style>
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Lead</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> List Lead</li>
                    </ol>
                    <h1 class="page-header mb-0">Lead</h1>
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
                            Lead List
                            <a href="{{ route('lead.create') }}" class="ms-auto">
                                <button class="btn btn-primary">Create Lead</button>
                            </a>
                        </div>


                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Email</th>
                                        <th class="text-nowrap">Mobile No.</th>
                                        <th class="text-nowrap">Zipcode</th>
                                        <th class="text-nowrap">Loan Amount</th>
                                        <th class="text-nowrap">Loan Reason</th>
                                        <th class="text-nowrap">Address</th>
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
                                            @switch($lead->loan_status)
                                                @case(1)
                                                    @php $loan_status =  "Pending"  @endphp
                                                @break

                                                @case(2)
                                                    @php $loan_status =  "View"  @endphp
                                                @break

                                                @case(3)
                                                    @php $loan_status =  "Under_Discussion"  @endphp
                                                @break

                                                @case(4)
                                                    @php $loan_status =  "Pending_Kyc"  @endphp
                                                @break

                                                @case(5)
                                                    @php $loan_status =  "Qualified"  @endphp
                                                @break

                                                @case(6)
                                                    @php $loan_status =  "Rejected"  @endphp
                                                @break

                                                @default
                                            @endswitch
                                            <tr class="odd gradeX">
                                                <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                                <td>{{ ucwords($lead->name) }}</td>
                                                <td>{{ $lead->email }}</td>
                                                <td>{{ $lead->mobile }}</td>
                                                <td>{{ $lead->zip_code }}</td>
                                                <td>{{ $lead->loan_amount }}</td>
                                                <td>{{ $lead->reason_of_loan }}</td>
                                                <td>{{ $lead->address }}</td>
                                                <td>{{ ucwords($lead->username) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($lead->created_at)->format('d F Y h:i A') }}
                                                </td>
                                                <td>
                                                    <div class="loan_status {{ $loan_status }}">
                                                        {{ str_replace('_', ' ', $loan_status) }}</div>
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="flexSwitchCheckDefault{{ $lead->id }}"
                                                            {{ $lead->status == 1 ? 'checked' : '' }}
                                                            onchange="ChangeStatus('loan_requests',{{ $lead->id }});">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" class="text-success me-2" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalRight" onclick="ViewrightModal({{ $lead->id }})">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('lead.destroy', $lead->id) }}" method="POST"
                                                        style="display: inline;">
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

    <div class="right_modal">
        <!-- Right Modal -->
        <div class="modal fade drawer right-align" id="exampleModalRight" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{-- <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Right Align Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> --}}
                    <div class="modal-body">
                        <div class="job-tracking-vertical">



                        </div>
                    </div>


                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>





@endsection
