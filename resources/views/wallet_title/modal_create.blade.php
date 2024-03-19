<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="form-validation">
                <form id="form-create" class="needs-validations" novalidate enctype="multipart/form-data">
                    <!-- <div class="modal-header">
                        <h1 class="modal-title fs-5" id="form-title">Add Wallet Title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-body">


                        @csrf

                        <div style="display: none;">
                            <input id="walletid" name="walletid" type="hidden" value="0">

                            <input id="imagecurency" name="imagecurency" type="" value="">

                            <input id="namecurencywallet" name="namecurencywallet" type="" value="">

                            <input id="namecurency" name="namecurency" type="" value="">
                        </div>

                        <!-- <img id="image-view" name="image-view" src="https://seeklogo.com/images/B/bitcoin-logo-594596D72F-seeklogo.com.png" alt="your image" width="120px" height="120px" /> -->

                        <div class="row">
                            <div class="col-xl-12">

                                @include('wallet_title.wallet_choose')

                                <!-- <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label form-label required" for="walletaddress">
                                        Wallet address
                                    </label>

                                    <div class="col-lg-9">
                                        <input class="form-control" id="walletaddress" name="walletaddress" placeholder="Enter wallet address" required readonly>
                                        <div class="invalid-feedback">
                                            Please enter wallet address.
                                        </div>
                                    </div>
                                </div> -->


                                <div class="input-group mb-3">
                                    <span class="input-group-text"> Address : </span>
                                    <input type="text" class="form-control" id="walletaddress" name="walletaddress" placeholder="Enter wallet address" required >
                                    <span class="input-group-text">
                                        <i class="fa fa-copy"></i>
                                    </span>
                                </div>


                                <!-- <div class="mb-3 row">
                                    <label class="col-lg-3 col-form-label  form-label required" for="qrimage">
                                        Qr Image
                                    </label>
                                    <div class="col-lg-9">
                                        <input type="file" class="form-control" id="qrimage" name="qrimage" placeholder="Enter your qr image">
                                        <div class="invalid-feedback">
                                            Please enter Qr image.
                                        </div>
                                    </div>
                                </div> -->

                                <div class="avatar-upload d-flex align-items-center">
                                    <div class=" position-relative ">
                                        <div class="avatar-preview">

                                            <img id="image-view-qr" name="image-view-qr" src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="your image" width="120px" height="120px" />

                                        </div>
                                        <div class="change-btn d-flex align-items-center flex-wrap">
                                            <input type="file" class="form-control d-none" id="qrimage" name="qrimage" accept=".png, .jpg, .jpeg">
                                            <label for="qrimage" class="btn btn-primary light btn-sm ms-0">
                                             <i class="fa fa-qrcode"></i>   Select Qr
                                                Image
                                            </label>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block btn-sqaure" id="btn-create">Add Wallet Title</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
