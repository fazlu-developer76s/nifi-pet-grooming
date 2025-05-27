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
            @switch(request()->segment(2))
            @case(1)
                @php $head_booking_status = "Open"; @endphp
            @break
            @case(2)
                @php $head_booking_status = "Accept"; @endphp
            @break
            @case(3)
                @php $head_booking_status = "Complete"; @endphp
            @break
            @case(4)
                @php $head_booking_status = "Cancel"; @endphp
            @break
            @default
                @php $head_booking_status = "N/A"; @endphp
        @endswitch
            <div class="d-flex align-items-center mb-5">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Booking</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> {{ $head_booking_status }} Booking </li>
                    </ol>
                    <h1 class="page-header mb-0">{{ $head_booking_status }} Booking</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <!-- Table Section -->
                <div class="col-md-12">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex align-items-center" style="border-bottom: 1px solid #2196f3;">
                            <i class="fab fa-buromobelexperte fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                            {{ $head_booking_status }}  Booking List
                            <!--<a href="{{ route('lead.create') }}" class="ms-auto">-->
                            <!--    <button class="btn btn-primary">Create Lead</button>-->
                            <!--</a>-->
                        </div>


                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <!--<div class="row">-->
                                <!--    <div class="col-md-7">-->

                                <!--    </div>-->

                                <!--    <div class="col-md-3">-->
                                <!--        <form action="{{ route('lead') }}" method="POST" enctype="multipart/form-data">-->
                                <!--         @csrf-->
                                <!--        <select name="type" class="form-control">-->
                                <!--            <option value="contact_us">Contact Us</option>-->
                                <!--            <option value="contact_us">Property</option>-->
                                <!--        </select> -->
                                <!--    <input type="submit">-->
                                <!--    </form>-->
                                <!--    </div>-->
                                <!--     <div class="col-md-1">-->

                                <!--    </div>-->
                                <!--</div>-->

                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Username</th>
                                        <th class="text-nowrap">Package Name</th>
                                        <th class="text-nowrap">Package Type</th>
                                        <th class="text-nowrap">Booking Date</th>
                                        <th class="text-nowrap">Booking Time</th>
                                        <th class="text-nowrap">Booking Amount</th>
                                        <th class="text-nowrap">Tax Amount</th>
                                        <th class="text-nowrap">Total Amount</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Created At</th>
                                        <th class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($bookings)
                                    @foreach ($bookings as $book)
                                    @switch(@$book->booking_status)
                                    @case(1)
                                        @php $booking_status = "Open"; @endphp
                                    @break
                                    @case(2)
                                        @php $booking_status = "Accept"; @endphp
                                    @break
                                    @case(3)
                                        @php $booking_status = "Complete"; @endphp
                                    @break
                                    @case(4)
                                        @php $booking_status = "Cancel"; @endphp
                                    @break
                                    @default
                                        @php $booking_status = "N/A"; @endphp
                                @endswitch
                                    <tr class="odd gradeX">
                                        <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($book->post_user_name) }}</td>
                                        <td>{{ ucwords($book->package_name) }}</td>
                                        <td>{{ ucwords($book->package_type) }}</td>
                                        <td>{{ \Carbon\Carbon::parse(@$book->booking_date)->format('d F Y') ?? 'N/A' }}
                                        <td>{{ \Carbon\Carbon::parse(@$book->booking_time)->format('h:i A') ?? 'N/A' }}

                                        <td>{{ $book->booking_amount }}</td>
                                        <td>{{ $book->tax_amount }}</td>
                                        <td>{{ $book->total_amount }}</td>
                                        <td>{{ $booking_status }}</td>
                                        <td>{{ \Carbon\Carbon::parse(@$book->created_at)->format('d F Y h:i A') ?? 'N/A' }}
                                        <td>

                                            <a href="{{ route('lead.view', $book->id) }}" class="text-success me-2">
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
@endsection
