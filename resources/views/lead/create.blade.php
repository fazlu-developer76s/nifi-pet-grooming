@extends('layouts/app')
@section('content')
    @if (isset($get_lead))
        @php $form_action = "lead.update" @endphp
    @else
        @php $form_action = "lead.create" @endphp
    @endif
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
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Add Lead
                            </div>
                            <a href="{{ route('lead') }}">
                                <button class="btn btn-primary">List Lead</button>
                            </a>
                        </div>
                        <form action="{{ route($form_action) }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ isset($get_lead) ? $get_lead->id : '' }}" name="hidden_id">
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Select Route No. </label>
                                            <select class="form-control custom-select-icon @error('route_id') is-invalid @enderror" name="route_id">
                                                    <option value="">Select Route </option>
                                                @if($get_route)
                                                    @foreach ($get_route as $route)
                                                        <option value="{{ $route->id }}" @if(empty($get_lead)) {{ old('route_id') == $route->id ? 'selected' : '' }} @else {{ (isset($get_lead) && $get_lead->route_id == $route->id) ? 'selected' : '' ; }} @endif >{{ ucwords($route->route) . ' ('. $route->title . ")"  }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('route_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Date</label>
                                            <input class="form-control @error('date') is-invalid @enderror" type="date"
                                                name="date" placeholder="Enter date"
                                                value="{{ isset($get_lead) ? $get_lead->date : old('date') }}" />
                                            @error('date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input class="form-control @error('name') is-invalid @enderror" type="text"
                                                name="name" placeholder="Enter Name"
                                                value="{{ isset($get_lead) ? $get_lead->name : old('name') }}" />
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="mb-3">
                                            <label class="form-label">Work</label>
                                            <input class="form-control @error('work') is-invalid @enderror" type="text" name="work"
                                                placeholder="Enter Work"
                                                value="{{ isset($get_lead) ? $get_lead->work : old('work') }}" />
                                            @error('work')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Mobile No.</label>
                                            <input class="form-control @error('mobile') is-invalid @enderror" type="text"
                                                name="mobile" placeholder="Enter Mobile No."
                                                value="{{ isset($get_lead) ? $get_lead->mobile : old('mobile') }}" />
                                            @error('mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="mb-3">
                                            <label class="form-label">Work Address</label>
                                            <input class="form-control @error('work_address') is-invalid @enderror"
                                                type="text" name="work_address" placeholder="Enter Work Address"
                                                value="{{ isset($get_lead) ? $get_lead->work_address : old('work_address') }}" />
                                            @error('work_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">
                                            <label class="form-label">Cheque</label> <br>
                                            <label for="cheque_yes">
                                                Y:
                                                <input type="radio" id="cheque_yes" name="cheque" value="Y"
                                                    {{ isset($get_lead) && $get_lead->cheque == 'Y' ? 'checked' : '' }}
                                                    {{ old('cheque') == 'Y' ? 'checked' : '' }}>
                                            </label>
                                            <label for="cheque_no">
                                                N:
                                                <input type="radio" id="cheque_no" name="cheque" value="N"
                                                    {{ isset($get_lead) && $get_lead->cheque == 'N' ? 'checked' : '' }}
                                                    {{ old('cheque') == 'N' ? 'checked' : '' }}>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Shop/Thiya</label> <br>
                                            <label for="shop_own">
                                                OWN:
                                                <input type="radio" id="shop_own" name="shop_thiya" value="OWN"
                                                    {{ isset($get_lead) && $get_lead->work_address == 'OWN' ? 'checked' : '' }}
                                                    {{ old('shop_thiya') == 'OWN' ? 'checked' : '' }}>
                                            </label>
                                            <label for="shop_rented">
                                                RENTED:
                                                <input type="radio" id="shop_rented" name="shop_thiya" value="RENTED"
                                                    {{ isset($get_lead) && $get_lead->work_address == 'RENTED' ? 'checked' : '' }}
                                                    {{ old('shop_thiya') == 'RENTED' ? 'checked' : '' }}>
                                            </label>
                                            @error('shop_thiya')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Home</label> <br>
                                            OWN : <input type="radio" name="home" value="OWN"
                                                {{ isset($get_lead) && $get_lead->home == 'OWN' ? 'checked' : (old('home') == 'OWN' ? 'checked' : '') }} />
                                            RENTED : <input type="radio" name="home" value="RENTED"
                                                {{ isset($get_lead) && $get_lead->home == 'RENTED' ? 'checked' : (old('home') == 'RENTED' ? 'checked' : '') }} />
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="mb-3">
                                            <label class="form-label">Home Address</label>
                                            <input class="form-control @error('home_address') is-invalid @enderror"
                                                type="text" name="home_address" placeholder="Enter home_address"
                                                value="{{ isset($get_lead) ? $get_lead->home_address : old('home_address') }}" />
                                            @error('home_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">
                                            <label class="form-label">File Hai</label> <br>
                                            Y : <input type="radio" name="file_hai" value="Y"
                                                {{ isset($get_lead) && $get_lead->file_hai == 'Y' ? 'checked' : (old('file_hai') == 'Y' ? 'checked' : '') }} />
                                            N : <input type="radio" name="file_hai" value="N"
                                                {{ isset($get_lead) && $get_lead->file_hai == 'N' ? 'checked' : (old('file_hai') == 'N' ? 'checked' : '') }} />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Loan Amount</label>
                                            <input class="form-control @error('loan_amount') is-invalid @enderror"
                                                type="number" name="loan_amount" placeholder="Enter Loan Amount"
                                                value="{{ isset($get_lead) ? $get_lead->loan_amount : old('loan_amount') }}" />
                                            @error('loan_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Tut</label>
                                            <input class="form-control @error('tut') is-invalid @enderror" type="number"
                                                name="tut" placeholder="Enter Tut"
                                                value="{{ isset($get_lead) ? $get_lead->tut : old('tut') }}" />
                                            @error('tut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Balance</label>
                                            <input class="form-control @error('balance') is-invalid @enderror"
                                                type="number" name="balance" placeholder="Enter Balance"
                                                value="{{ isset($get_lead) ? $get_lead->balance : old('balance') }}" />
                                            @error('balance')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">+/- Day</label>
                                            <input class="form-control @error('plus_minus_day') is-invalid @enderror"
                                                type="number" name="plus_minus_day" placeholder="Enter +/- Day"
                                                value="{{ isset($get_lead) ? $get_lead->plus_minus_day : old('plus_minus_day') }}" />
                                            @error('plus_minus_day')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Old Loan</label>
                                            <input class="form-control @error('old_loan') is-invalid @enderror"
                                                type="number" name="old_loan" placeholder="Enter Old Loan"
                                                value="{{ isset($get_lead) ? $get_lead->old_loan : old('old_loan') }}" />
                                            @error('old_loan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">
                                            <label class="form-label">Loan Type</label> <br>
                                            New : <input type="radio" name="loan_type" value="New"
                                                {{ isset($get_lead) && $get_lead->loan_type == 'New' ? 'checked' : (old('loan_type') == 'New' ? 'checked' : '') }} />
                                            Renew : <input type="radio" name="loan_type" value="Renew"
                                                {{ isset($get_lead) && $get_lead->loan_type == 'Renew' ? 'checked' : (old('loan_type') == 'Renew' ? 'checked' : '') }} />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">File No.</label>
                                            <input class="form-control @error('file_no') is-invalid @enderror"
                                                type="number" name="file_no" placeholder="Enter File No."
                                                value="{{ isset($get_lead) ? $get_lead->file_no : old('file_no') }}" />
                                            @error('file_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Ser.</label>
                                            <input class="form-control @error('ser') is-invalid @enderror" type="number"
                                                name="ser" placeholder="Enter Ser."
                                                value="{{ isset($get_lead) ? $get_lead->ser : old('ser') }}" />
                                            @error('ser')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">R. N.</label>
                                            <input class="form-control @error('r_n') is-invalid @enderror" type="number"
                                                name="r_n" placeholder="Enter R. N."
                                                value="{{ isset($get_lead) ? $get_lead->r_n : old('r_n') }}" />
                                            @error('r_n')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">R. Head Sign</label>
                                            <input class="form-control @error('r_head_sign') is-invalid @enderror"
                                                type="number" name="r_head_sign" placeholder="Enter R. Head Sign"
                                                value="{{ isset($get_lead) ? $get_lead->r_head_sign : old('r_head_sign') }}" />
                                            @error('r_head_sign')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Amount</label>
                                            <input class="form-control @error('amount') is-invalid @enderror"
                                                type="number" name="amount" placeholder="Enter Amount"
                                                value="{{ isset($get_lead) ? $get_lead->amount : old('amount') }}" />
                                            @error('amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Accountant Sign</label>
                                            <input class="form-control @error('accountant_sign') is-invalid @enderror"
                                                type="number" name="accountant_sign" placeholder="Enter Accountant Sign"
                                                value="{{ isset($get_lead) ? $get_lead->accountant_sign : old('accountant_sign') }}" />
                                            @error('accountant_sign')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="mb-3">
                                            <label class="form-label">Guarantor</label> <br>
                                            Yes: <input type="radio" name="guarantor" value="Y" {{ isset($get_lead) && $get_lead->guarantor == 'Y' ? 'checked' : (old('guarantor') == 'Y' ? 'checked' : '') }} />
                                            No: <input type="radio" name="guarantor" value="N" {{ isset($get_lead) && $get_lead->guarantor == 'N' ? 'checked' : (old('guarantor') == 'N' ? 'checked' : '') }} />
                                            @error('guarantor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Guarantor Name</label>
                                            <input class="form-control @error('guarantor_name') is-invalid @enderror" type="text" name="guarantor_name" placeholder="Enter Guarantor Name" value="{{ isset($get_lead) ? $get_lead->guarantor_name : old('guarantor_name') }}" />
                                            @error('guarantor_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Service </label>
                                            <select class="form-control custom-select-icon @error('service') is-invalid @enderror" name="service">
                                                <option value="">Select Service</option>
                                                @if($get_service)
                                                    @foreach ($get_service as $service)
                                                        <option value="{{ $service->id }}" @if(empty($get_lead)) {{ old('service') == $service->id ? 'selected' : '' }} @else {{ (isset($get_lead) && $get_lead->service_no == $service->id) ? 'selected' : '' ; }} @endif >{{ ucwords($service->title) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Lead User </label>
                                            <select class="form-control custom-select-icon @error('user_id') is-invalid @enderror" name="user_id">
                                                <option value="">Select User</option>
                                                @if($get_user)
                                                    @foreach ($get_user as $user)
                                                        <option value="{{ $user->id }}" @if(empty($get_lead)) {{ old('user_id') == $user->id ? 'selected' : '' }} @else {{ (isset($get_lead) && $get_lead->user_id == $user->id) ? 'selected' : '' ; }} @endif {{ $user->id == Auth::user()->id ? 'selected':''; }}>{{ ucwords($user->name) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label">Remark</label>
                                            <textarea class="form-control @error('reason_of_loan') is-invalid @enderror" name="reason_of_loan" placeholder="Enter Remark" rows="3">{{ isset($get_lead) ? $get_lead->reason_of_loan : old('reason_of_loan') }}</textarea>
                                            @error('reason_of_loan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>





                                </div>
                            </div>
                            <div class="card-footer bg-none d-flex p-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>
                                    Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
