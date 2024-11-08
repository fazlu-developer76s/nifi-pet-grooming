@extends('layouts/app')
@section('content')
    <div class="container-fluid">
        <div id="content" class="app-content">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:;">Role</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-arrow-back"></i> Permission</li>
                    </ol>
                    <h1 class="page-header mb-0">Role</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card border-0 mb-4">
                        <div class="card-header h6 mb-0 bg-none p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa fa-user-shield fa-lg fa-fw text-dark text-opacity-50 me-1"></i>
                                Update Permission
                            </div>
                            <a href="{{ route('roles') }}">
                                <button class="btn btn-primary">List Roles</button>
                            </a>
                        </div>
                        <form action="{{ route('permission.update') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <h4> Title:  {{ $getrole->title }}</h4>
                                        <input type="hidden" name="role_id" value="{{ $getrole->id }}">
                                    </div>
                                    <div class="col-md-12">
                                        <input type="checkbox" id="check_all" onchange="Checkall();">
                                        <label class="form-label" for="check_all">Check All</label> <br>
                                    </div>
                                </div>
                                <div class="row">
                                    @if($getallpermission)
                                    @foreach ( $getallpermission as $permission)

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <input type="checkbox" class="mt-2 sub_check" id="check{{ $permission->id }}" value="{{ (!empty($permission->permission_status->id)) ? $permission->permission_status->id : $permission->id ; }}" name="permission[]" {{ (!empty($permission->permission_status->permission_status) && $permission->permission_status->permission_status == 1) ? 'checked' : ' ' ; }}>
                                            <input type="hidden" value="{{ (!empty($permission->id)) ? $permission->id : ' ' ; }}" name="hidden_id[]">
                                            <label class="form-label" for="check{{ $permission->id }}">{{ $permission->title }}</label> <br>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer bg-none d-flex p-3">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function Checkall() {
        // Check or uncheck all checkboxes based on the main checkbox
        $(".sub_check").prop("checked", $("#check_all").is(':checked'));
    }
</script>
