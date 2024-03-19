@extends('layout.main')
@section('title', 'Main confirmation')

@section('content')


@include('main_confirmation.style')

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">

        <!-- <br>
        <br>
        <br>
        <br> -->

        <div class="row">

            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="widget-stat card main-tab bg-light" data-value="1">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <span class="me-3 bgl-primary text-primary">
                                <!-- <i class="ti-user"></i> -->
                                <svg id="icon-customers" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Total Register</p>
                                <h4 class="mb-0 text-blue user-count">0.00</h4>
                                <!-- <span class="badge badge-primary">3.5%</span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="widget-stat card main-tab" data-value="2">
                    <div class="card-body  p-4">
                        <div class="media ai-icon">
                            <span class="me-3 bgl-danger text-danger">
                                <svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Total Withdraw</p>
                                <h4 class="mb-0 text-danger withdraw-count">0.00</h4>
                                <!-- <span class="badge badge-danger">3.5%</span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="widget-stat card main-tab" data-value="3">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <span class="me-3 bgl-success text-success">
                                <svg id="icon-database-widget" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1">Total Deposit</p>
                                <h4 class="mb-0 text-success deposit-count">0.00</h4>
                                <!-- <span class="badge badge-success">3.5%</span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            @include('trade.filter_user')
        </div>

        <div class="tab-view">
            <!-- params -->
            <input type="hidden" class="userid">
            <input type="hidden" class="status" value="pending">
            <input type="hidden" class="reference_code">

            @include('main_confirmation.list_veiw_user')
            @include('main_confirmation.list_veiw_withdraw')
            @include('main_confirmation.list_veiw_deposit')
        </div>

        @include('main_confirmation.modal_user')
        @include('main_confirmation.modal_deposit')
        @include('main_confirmation.modal_withdraw')

        @include('wallet_title.modal_image')


    </div>
</div>


<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')
@parent
@include('main_confirmation.script')
@endsection

@section('footer')
@include('wallet_title.footer')
@endsection