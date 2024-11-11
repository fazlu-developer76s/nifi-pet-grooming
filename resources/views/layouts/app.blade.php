@php
    $company = \App\Helpers\Global_helper::companyDetails();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ (!empty($title)) ? $title : config('app.name', 'Laravel') ; }} </title>
    <style>
        .bootstrap-tagsinput {
            margin: 0;
            width: 100%;
            padding: 0.5rem 0.75rem 0;
            font-size: 1rem;
            line-height: 1.25;
            transition: border-color 0.15s ease-in-out;
        }
        .bootstrap-tagsinput.has-focus {
            background-color: #fff;
            border-color: #5cb3fd;
        }
        .label-info {
            display: inline-block;
            background-color: #636c72;
            padding: 0 .4em .15em;
            border-radius: .25rem;
            margin-bottom: 0.4em;
        }
        .bootstrap-tagsinput input {
            margin-bottom: 0.5em;
        }
        .app-sidebar{
            background: #24244c !important;
            color: black !important;
        }
    </style>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/'.$company->favicon) }}">
    <link href="{{ asset('assets/css/fontawesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/default/app.min.css') }}" rel="stylesheet" />
    <!----Table-- -->
    <link href="{{ asset('assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" />
    <!----Table---->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">



</head>
<!----Head----->
@include('layouts.header')
@include('layouts.sidebar')
@yield('content')
<!-- Collect Emi Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form inside the modal -->
          <form id="modalForm" action="/submit-form" method="POST">
            <div class="mb-3">
              <label for="loan_number" class="form-label">Loan Number</label>
              <input type="text" class="form-control" id="loan_number" name="loan_number" required placeholder="Please Enter Your Loan Number" oninput="FetchLoanDetail();">
            </div>
            <div class="mb-3 collect_name d-none">
              <label for="collect_name" class="form-label">Name</label>
              <input type="text" class="form-control" id="collect_name" name="collect_name" required>
            </div>
            <div class="mb-3 collect_amount d-none">
              <label for="collect_amount" class="form-label">Amount</label>
              <input type="text" class="form-control" id="collect_amount" name="collect_amount" required>
            </div>
            <div class="mb-3 collect_emi d-none">
              <label for="collect_emi" class="form-label">Emi</label>
              <input class="form-control" id="collect_emi" name="collect_emi" rows="3" required>
            </div>
            <div class="mb-3 collect_last_emi d-none">
              <label for="collect_last_emi" class="form-label">Last Emi</label>
              <input class="form-control" id="collect_last_emi" name="collect_last_emi" rows="3" required>
            </div>
            <div class="mb-3 collect_remark d-none">
              <label for="collect_remark" class="form-label">Remark</label>
              <textarea class="form-control" id="collect_remark" name="collect_remark" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary submit_button d-none">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@include('layouts.footer')
