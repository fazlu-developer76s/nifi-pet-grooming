@extends('layouts/app')
@section('content')
@if(isset($assignroute))
@php $form_action = "routeassign.update" @endphp
@else
@php $form_action = "routeassign.create" @endphp
@endif
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Route Assign</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> View Route Assign</li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Route : {{ @$assign_route[0]->route_no.'/'.@$assign_route[0]->route_title }} </li>
                    </ol>
                    <h1 class="page-header mb-0">Route Assign</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #2196f3;">
                            <div class="d-flex align-items-center">
                                <i class="fab fa-buromobelexperte fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                View Route Assign
                            </div>
                            <a href="{{ route('routeassign') }}">
                                <button class="btn btn-primary">List Assign Route</button>
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="data-table-default" class="table table-striped table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        <th class="text-nowrap">Route</th>
                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">User Name</th>
                                        <th class="text-nowrap">Assign Date</th>
                                        <th class="text-nowrap">Remove Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($assign_route)
                                    @foreach ($assign_route  as $assign)
                                    <tr class="odd gradeX">
                                        <td width="1%" class="fw-bold text-dark">{{ $loop->iteration }}</td>
                                        <td>{{ $assign->route_no }}</td>
                                        <td>{{ $assign->route_title }}</td>
                                        <td>{{ $assign->username }}</td>
                                        <td>{{ \Carbon\Carbon::parse($assign->created_at)->format('d F Y h:i A') }}</td>
                                        <td>{{ (!empty($assign->updated_at)) ?  \Carbon\Carbon::parse($assign->updated_at)->format('d F Y h:i A') : ' ' ; }}</td>
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
