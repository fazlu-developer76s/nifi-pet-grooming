@extends('layouts/app')
@section('content')
<div class="app-sidebar-bg"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile"
        class="stretched-link"></a></div>
<div id="content" class="app-content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ol class="breadcrumb float-xl-end">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item active">Welcome To Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <a href="hello">
                <div class="card">
                    <div class="card-body no-padding" style="height:208px">
                        <div class="alert alert-callout alert-info no-margin">
                            <strong class="text-xl" style="font-size: 50px;">1
                                <?php //$reqdata['COUNT(id)'];
                                ?></strong><br>
                            <span class="opacity-90">Request List</span>
                            <!-- <h1 class="pull-right text-info" style="margin-top: -20px;"><img src="assets/img/icon.png" width="100px"></h1> -->
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-9">
            <div class="row">
                <div class="col-lg-4">
                    <a href="hello">
                        <div class="card">
                            <div class="card-body no-padding">
                                <div class="alert alert-callout alert-danger no-margin">
                                    <!-- <h1 class="pull-right text-danger"><img src="assets/img/icon.png" width="50px;"></h1> -->
                                    <strong class="text-xl">42.90%</strong><br />
                                    <span class="opacity-50">Bounce rate</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="hello">
                        <div class="card">
                            <div class="card-body no-padding">
                                <div class="alert alert-callout alert-warning no-margin">
                                    <!-- <h1 class="pull-right text-warning"><img src="assets/img/icon.png" width="50px;"></h1> -->
                                    <strong class="text-xl">$ 32,829</strong><br />
                                    <span class="opacity-50">Revenue</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="hello">
                        <div class="card">
                            <div class="card-body no-padding">
                                <div class="alert alert-callout alert-success no-margin">
                                    <!-- <h1 class="pull-right text-success"><img src="assets/img/icon.png" width="50px;"></h1> -->
                                    <strong class="text-xl">42.90%</strong><br />
                                    <span class="opacity-50">Bounce rate</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="hello">
                        <div class="card">
                            <div class="card-body no-padding">
                                <div class="alert alert-callout alert-danger no-margin">
                                    <!-- <h1 class="pull-right text-danger"><img src="assets/img/icon.png" width="50px;"></h1> -->
                                    <strong class="text-xl">54 sec.</strong><br />
                                    <span class="opacity-50">Avg. time on site</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="hello">
                        <div class="card">
                            <div class="card-body no-padding">
                                <div class="alert alert-callout alert-warning no-margin">
                                    <!-- <h1 class="pull-right text-warning"><img src="assets/img/icon.png" width="50px;"></h1> -->
                                    <strong class="text-xl">$ 32,829</strong><br />
                                    <span class="opacity-50">Revenue</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4">
                    <a href="hello">
                        <div class="card">
                            <div class="card-body no-padding">
                                <div class="alert alert-callout alert-success no-margin">
                                    <!-- <h1 class="pull-right text-success"><img src="assets/img/icon.png" width="50px;"></h1> -->
                                    <strong class="text-xl">42.90%</strong><br />
                                    <span class="opacity-50">Bounce rate</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top"
    data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
</div>
@endsection
