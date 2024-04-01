@extends('layout.main')
@section('title', 'Fee Settings')

@section('content')

    @include('fee.style')

    <!--**********************************
                                        Content body start
                                ***********************************-->

    <div class="content-body">
        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Settings</h4>
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

                                                        <input type="file" name="logo" id="logo"
                                                            class="form-control number br-style" required>

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
                                                        <input type="text" name="nameweb" autocomplete="off"
                                                            id="nameweb" class="form-control br-style"
                                                            placeholder="Enter company name ..." required>

                                                        <div class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label  required"
                                                        for="validationCustomUsername">
                                                        Trading Fee
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-percent"></i>
                                                        </span>
                                                        <input type="text" name="tradeffeepercent" autocomplete="off"
                                                            id="tradeffeepercent" class="form-control number br-style"
                                                            placeholder="Enter trade fee ..." required value="0">

                                                        <div class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required"
                                                        for="validationCustomUsername">
                                                        Withdraw Fee
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-percent"></i>
                                                        </span>
                                                        <input type="text" name="widtrwfeepercent" id="widtrwfeepercent"
                                                            autocomplete="off" class="form-control number br-style"
                                                            placeholder="Enter withdraw fee..." required value="0">

                                                        <div class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required" for="deposit_fee_percent">
                                                        Deposit fee
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-percent"></i>
                                                        </span>
                                                        <input type="text" name="deposit_fee_percent"
                                                            id="deposit_fee_percent" autocomplete="off"
                                                            class="form-control number br-style"
                                                            placeholder="Enter deposit fee ..." required value="0">

                                                        <div class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required"
                                                        for="profit_fee_percentage">
                                                        Profit fee
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-percent"></i>
                                                        </span>
                                                        <input type="text" name="profit_fee_percentage"
                                                            id="profit_fee_percentage" autocomplete="off"
                                                            class="form-control number br-style"
                                                            placeholder="Enter profit fee ..." required value="0">

                                                        <div class="invalid-feedback">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required" for="email">
                                                        Email
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-message"></i>
                                                        </span>
                                                        <input type="email" name="email" id="email"
                                                            autocomplete="off" class="form-control br-style"
                                                            placeholder="Enter email..." required value="">

                                                        <div class="invalid-feedback">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required" for="phone">
                                                        Phone
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-phone"></i>
                                                        </span>
                                                        <input type="text" name="phone" id="phone"
                                                            autocomplete="off" class="form-control br-style"
                                                            placeholder="Enter phone..." required value="">

                                                        <div class="invalid-feedback">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required" for="address">
                                                        Address
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-address-book"></i>
                                                        </span>
                                                        <input type="text" name="address" id="address"
                                                            autocomplete="off" class="form-control br-style"
                                                            placeholder="Enter address..." required value="">

                                                        <div class="invalid-feedback">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required" for="city">
                                                        City
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-city"></i> </span>
                                                        <input type="text" name="city" id="city"
                                                            autocomplete="off" class="form-control br-style"
                                                            placeholder="Enter city..." required value="">

                                                        <div class="invalid-feedback">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required" for="city">
                                                        Country
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"> <i class="fa fa-flag"></i> </span>
                                                        <input type="text" name="coutry" id="coutry"
                                                            autocomplete="off" class="form-control br-style"
                                                            placeholder="Enter country..." required value="">

                                                        <div class="invalid-feedback">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-2">
                                                <div class="mb-3 vertical-radius">
                                                    <label class="text-label form-label required" for="city">
                                                        Description
                                                    </label>
                                                    <div class="input-group">

                                                        <textarea rows="4" name="Description" id="Description" autocomplete="off" class="form-control br-style"
                                                            placeholder="Enter description..." required></textarea>

                                                        <div class="invalid-feedback">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                            <!-- <div class="col-lg-12 mb-2">
                                                                        <div class="mb-3 vertical-radius">
                                                                            <label class="text-label form-label  required" for="logo">
                                                                                En
                                                                            </label>
                                                                            <div class="input-group">

                                                                                <input type="file" name="en" id="en" class="form-control number br-style" required>

                                                                                <div class="invalid-feedback">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> -->


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
