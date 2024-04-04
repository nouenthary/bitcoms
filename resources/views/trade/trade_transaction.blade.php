@extends('layout.main')
@section('title', 'Future Trading Transactions')

@section('content')

@include('trade.style')

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">

        <div class="col-xl-12">
            <div class="filter cm-content-box box-primary">
                <div class="content-title SlideToolHeader">
                    <div class="cpa">
                        <i class="fa fa-filter me-2"></i>filter
                    </div>
                    <div class="tools">
                        <a href="javascript:void(0);" class="expand handle"><i class="fal fa-angle-down"></i></a>
                    </div>
                </div>
                <div class="cm-content-body form excerpt">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-xl-3 col-sm-6">
                                <label class="form-label">Trade : </label>
                                <select class="form-control default-select wide wintrade select2-width-75">
                                    <option value="">Select Menu</option>
                                    <option value="win">win</option>
                                    <option value="lose">lose</option>
                                </select>
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <label class="form-label">Start Date : </label>
                                <input id="start_date" name="start_date" class="form-control my-date" placeholder="YYYY/MM/DD">
                            </div>

                            <div class="col-xl-3 col-sm-6">
                                <label class="form-label">To Date : </label>
                                <input id="end_date" name="end_date" class="form-control my-date" placeholder="YYYY/MM/DD">
                            </div>

                            <div class="col-xl-3 col-sm-6 align-self-end">
                                <div>
                                    <button class="btn btn-primary me-2 btn-filter" title="Click here to Search" type="button">
                                        <i class="fa fa-filter me-1"></i>Filter
                                    </button>
                                    <button class="btn btn-danger light btn-remove-filter" title="Click here to remove filter" type="button">
                                        Remove Filter
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @include('trade.filter_user')
        </div>

        <input type="hidden" name="p_status" id="p_status" value="">
        <input type="hidden" name="p_wallet" id="p_wallet" value="">
        <input type="hidden" name="fkuserid" id="fkuserid" value="">
        <input type="hidden" name="referrercode" id="referrercode" value="">

        <div class="col-xl-12">

            <div class="card">
                <div class="card-header flex-wrap border-0 row">

                    <div class="col-md-3 col-sm-12">
                        <h4 class="card-title mb-lg-0 mb-2">List Transactions </h4>
                    </div>

                </div>
                <div class="card-body pt-0">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="table-responsive">
                            <table id="table-history-a1" class="table shadow-hover display orderbookTable ">
                                <thead>
                                    <tr>
                                        <th>User </th>
                                        <th>Date </th>
                                        <th>Description</th>
                                        <th>Trade Title</th>
                                        <th>Trade Time</th>
                                        <th>Amount </th>
                                        <th>Total Amount </th>
                                        <th>Fee</th>
                                        <th>Amount Fee</th>
                                        <th>Trade</th>
                                        <th>Last Price</th>
                                        <!-- <th>Status</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')
@parent
@include('trade.script')
@endsection

@section('footer')
@include('wallet_title.footer')
@endsection
