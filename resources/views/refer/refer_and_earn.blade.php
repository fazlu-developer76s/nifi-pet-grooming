@extends('layouts/app')
@section('content')
@php $form_action = "refer.earn" @endphp
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Refer And Earn</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Update Refer And Earn </li>
                    </ol>
                    <h1 class="page-header mb-0">Refer And Earn</h1>
                </div>
            </div>
            <!-- Row for equal division -->
            <div class="row">
                @foreach ($earn_refer as $refer)
                <div class="col-md-6">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Update Refer And Earn {{ ($refer->user_type==1)?'Groomers helper':'Customer'; }}
                            </div>
                        </div>

                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ (isset($refer)) ? $refer->id : '' ; }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Is ON</label> <br>
                                            <input  type="checkbox" name="is_on" placeholder="Enter Coupon Charge" value="1" {{ ($refer->is_on==1)?'checked':'unchecked'; }} />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Is Profit</label> <br>
                                            <input  type="checkbox" name="is_profit" placeholder="Enter Coupon Charge" value="1" {{ ($refer->is_profit==1)?'checked':'unchecked'; }}  />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">No Of Billing </label>
                                            <input class="form-control @error('billing_no') is-invalid @enderror" type="text" name="billing_no" placeholder="Enter Coupon Charge" value="@if(!empty($refer)) {{ $refer->billing_no }} @endif" />
                                            @error('billing_no')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-none d-flex p-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

