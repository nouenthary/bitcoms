@extends('layout.main')
@section('title', 'Fee Settings')

@section('content')


@include('wallet.style')

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Admin Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">

                            <form class="needs-validation" novalidate enctype="multipart/form-data">

                                <img width="100px" src="images/no-img-avatar.png" alt="" class="view-logo">

                                <br>
                                <br>

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-lg-12 mb-2">
                                            <div class="mb-3 vertical-radius">
                                                <label class="text-label form-label  required" for="logo">
                                                    Logo
                                                </label>
                                                <div class="input-group">

                                                    <input type="file" name="logo" id="logo" class="form-control number br-style" required>

                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-2">
                                            <div class="mb-3 vertical-radius">
                                                <label class="text-label form-label  required" for="nameweb">
                                                    Company
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text"> <i class="fa fa-home"></i> </span>
                                                    <input type="text" name="nameweb" autocomplete="off" id="nameweb" class="form-control br-style" placeholder="Enter company name ..." required>

                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 mb-2">
                                            <div class="mb-3 vertical-radius">
                                                <label class="text-label form-label  required" for="validationCustomUsername">
                                                    Trading Fee
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text"> <i class="fa fa-percent"></i> </span>
                                                    <input type="text" name="tradeffeepercent" autocomplete="off" id="tradeffeepercent" class="form-control number br-style" placeholder="Enter trade fee percent..." required value="0">

                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-12 mb-2">
                                            <div class="mb-3 vertical-radius">
                                                <label class="text-label form-label  required" for="validationCustomUsername">
                                                    Withdraw Fee
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text"> <i class="fa fa-percent"></i> </span>
                                                    <input type="text" name="widtrwfeepercent" id="widtrwfeepercent" autocomplete="off" class="form-control number br-style" placeholder="Enter trwithdrawade fee percent..." required value="0">

                                                    <div class="invalid-feedback">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="col-xl-12">

                            <button type="submit" class="btn btn-primary btn-block" id="btn-create">Submit</button>

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
@include('fee.script')
@endsection

@section('footer')
@include('wallet_title.footer')
@endsection