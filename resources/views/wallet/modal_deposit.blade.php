<div class="modal fade" id="modalDeposit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
        <div class="modal-content bg">
            <div class="form-validation">
                <form id="form-create-deposit" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="form-title">
                            <!-- Add Deposit -->
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @csrf

                        <input id="depositid" name="depositid" type="hidden" value="0">

                        <input id="fkuserid" name="fkuserid" type="hidden" value="0">

                        <input id="fkwalletid" name="fkwalletid" type="hidden" value="0">

                        <input id="qrimage" name="qrimage" type="hidden" value="">

                        <div class="row">
                            <div class="col-xl-12">

                                <div class="mb-3 row">
                                    <div class="col-lg-12">

                                        <div class="mb-3 row">
                                            <div class="col-lg-12">
                                                <div class=" alert alert-primary alert-dismissible fade show">

                                                    <!-- <div class="icon-box btn-circle btn-sx icon-box-xs bg-success"> -->
                                                    <i class="fa fa-text-width"></i>
                                                    <!-- </div> -->

                                                    <strong>
                                                        <span class="text-address-show">USDT (TRC20)</span>
                                                    </strong>

                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-rounded btn-warning btn-xs">
                                            Manual audit
                                        </button>
                                    </div>
                                </div>


                                <div class="mb-3 row">
                                    <div class="col-lg-9">
                                    </div>

                                    <div class="col-lg-3">
                                        <img id="image-view-qr" name="image-view-qr" src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="your image" width="160px" height="160px" />

                                    </div>
                                </div>

                                <div class="mb-3 row" style="display: none;">
                                    <label class="col-lg-3 col-form-label form-label required" for="namecurency">Name
                                        Wallet

                                    </label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control" id="namewallet" name="namewallet" placeholder="Enter name wallet" required>
                                        <div class="invalid-feedback">
                                            Please enter a name currency.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row" style="display: none;">
                                    <label class="col-lg-3 col-form-label  form-label required" for="walletaddr">
                                        Wallet address

                                    </label>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="walletaddr" name="walletaddr" placeholder="Enter wallet address" required>
                                        <div class="invalid-feedback">
                                            Please enter wallet address.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-12 col-form-label  form-label">
                                        Please transfer to this address <span class="text-warning">USDT</span>
                                    </label>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-lg-12">
                                        <div class=" alert alert-primary alert-dismissible fade show">

                                            <i class="fa fa-copy" style="font-size: 22px"></i>

                                            <strong>
                                                <span class="text-address">Welcome !</span>
                                            </strong>

                                        </div>
                                    </div>

                                </div>



                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label  form-label required" for="amount">
                                        Number of recharges

                                    </label>
                                    <div class="col-lg-9">
                                        <input class="form-control number" id="amount" name="amount" placeholder="Please Enter the recharges amount" required value="0" autocomplete="off">
                                        <div class="invalid-feedback">
                                            Please enter wallet amount.
                                        </div>
                                    </div>
                                </div>




                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label  form-label required" for="paymentvoucher">
                                        Payment Voucher
                                    </label>
                                    <div class="col-lg-9">
                                        <input type="file" class="form-control" id="paymentvoucher" name="paymentvoucher" placeholder="Enter your qr image">
                                        <div class="invalid-feedback">
                                            Please enter payment voucher.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 row" style="display: none;">
                                    <label class="col-lg-3 col-form-label  form-label required" for="status">
                                        Status
                                    </label>
                                    <div class="col-lg-9">
                                        <select class="form-control" id="status" name="status">
                                            <option value="pending">
                                                Pending
                                            </option>
                                            <option value="done">
                                                Done
                                            </option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please enter payment status.
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <img id="image-view-voucher" name="image-view-voucher" src="https://images.assetsdelivery.com/compings_v2/infadel/infadel1712/infadel171200119.jpg" alt="your image" width="120px" height="120px" />

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-block btn-squares" id="btn-create-deposit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>