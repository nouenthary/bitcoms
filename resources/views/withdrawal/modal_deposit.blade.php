<div class="modal fade" id="modalDeposit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg ">
        <div class="modal-content bg">
            <div class="form-validation">
                <form id="form-create-deposit" class="needs-validation" novalidate enctype="multipart/form-data">

                    <div class="modal-body">

                        @csrf

                        <div style="display:none">

                            <input class="form-control" id="withdrawid" name="withdrawid" type="" value="0" placeholder="walletid">

                            <input class="form-control" id="fkuserid" name="fkuserid" type="" value="0" placeholder="fkuserid">

                            <input class="form-control" id="fkwalletid" name="fkwalletid" type="" value="0" placeholder="fkwalletid">

                            <input class="form-control" id="balance" name="balance" type="" value="" placeholder="balance">

                            <input class="form-control" id="fee" name="fee" type="" value="" placeholder="fee">

                            <input class="form-control" id="totalamount" name="totalamount" type="" value="" placeholder="totalamount">

                            <input class="form-control" id="feeamount" name="feeamount" type="" value="" placeholder="feeamount">

                            <input class="form-control" id="status" name="status" type="" value="pending" placeholder="status">

                        </div>


                        <div class="row">
                            <div class="col-xl-12">

                                <div class="mb-3 row">
                                    <div class="card  digital-cash">
                                        <div class="card-header border-0">
                                            <h4 class="card-title">Withdraw now !</h4>
                                        </div>
                                        <div class="card-body py-0">
                                            <div class="text-center">
                                                <div class="media d-block">

                                                    <img class="rounded-circle t-img-logo" src="https://seeklogo.com/images/B/bitcoin-logo-594596D72F-seeklogo.com.png" width="60px" height="60px" alt="wallet-title">

                                                    <div class="media-content">
                                                        <h4 class="mt-0 mt-md-4 fs-20 font-w700 text-dark mb-0 ">Digital Cash</h4>
                                                        <span class="font-w600 text-dark t-name">Bitcoin</span>
                                                        <span class="my-4 fs-16 font-w600 text-black d-block t-balance text-uppercase"> BITCOIN = 43,474.50 USD</span>
                                                        <!-- <span class="my-4 fs-16 font-w600 text-black d-block t-fee">Fee = 2,00.00</span> -->
                                                        <span class="my-4 fs-16 font-w600 text-black d-block t-total-amount">Total Amount = 3,000.00</span>
                                                        <!-- <span class="my-4 fs-16 font-w600 text-black d-block t-total-fee">Total Fee = 3,00.00</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-secondarys text-whites" style="width: 100px;"> Add Address : </span>
                                    <input type="text" class="form-control codeaddress" id="codeaddress" name="codeaddress" placeholder="Enter code address" required>
                                </div>

                                <div class="input-group mb-3" style="display: none;">
                                    <span class="input-group-text bg-secondarys text-whites" style="width: 100px;">Add Link : </span>
                                    <input type="text" class="form-control codelink_default" id="codelink_default" name="codelink_default" placeholder="Enter Code link" required>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label  form-label required" for="codelink">
                                        Upload Qr Image
                                    </label>
                                    <div class="col-lg-9">
                                        <input type="file" class="form-control" id="codelink" name="codelink" placeholder="Enter your qr image">
                                        <div class="invalid-feedback">
                                            Please enter Qr Image
                                        </div>
                                    </div>
                                </div>

                                <img id="image-view" name="image-view" src="https://images.assetsdelivery.com/compings_v2/infadel/infadel1712/infadel171200119.jpg" alt="your image" width="120px" height="120px" />


                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-block" id="btn-create-deposit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>