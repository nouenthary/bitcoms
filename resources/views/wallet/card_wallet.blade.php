<div class="row">

    <div class="col-md-4 col-sm-12">
        <div class="card my-card" id="btn-create-address">

            <div class="card-body text-center pt-3">
                <div class="icon-box btn-circle icon-box-sm bg-danger">
                    <i class="fa fa-plus text-white"></i>
                </div>

                <br />
                <br />

                <h4>Create new wallet</h4>
            </div>
        </div>
    </div>

</div>


<div style="display : none" class="hidden">
    <div class="col-md-4 col-sm-12 card-wallet-item">
        <div class="card bg my-card">

            <div class="card-body text-center pt-3">

                <img class="rounded-circle img-logo" src="https://seeklogo.com/images/B/bitcoin-logo-594596D72F-seeklogo.com.png" width="60px" height="60px" alt="wallet-title">

                <div class="mt-3">
                    <h5 class="m-auto mb-0 text-name-currency">Expense</h5>
                </div>
                <div class="count-nums mt-1">
                    <p class="ms-2 text-dark text-currencys">Wallet Address</p>
                </div>

                <form class="form-valide-with-icon needs-validation" novalidate="">

                    <div class="mb-3 vertical-radius">
                        <div class="input-group transparent-append">

                            <button class="btn btn-square bg-dangers text-white btn-xs" type="button">
                                <!-- <i class="fa fa-box"></i> -->
                                <img width="25px" height="25px" class="image-currency-logo" src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg">

                            </button>

                            <input type="text" class="form-control address" name="address" id="address" placeholder="wallet address" readonly>

                            <button class="btn btn-danger btn-square btn-xs" type="button" id="fa-copy">
                                <i class="fa fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <img width="160px" height="160px" class="qr-image" src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg">
                    </div>

                    <br />

                    <div class="bg-light p-1 text-left">
                        <h5 class="text-left">
                            <span class="text-left text-whites">Balance :</span> <span class="text-orange text-balance">0 </span>
                            <span class="text-currency text-orange text-uppercase">USD</span>
                        </h5>
                    </div>

                    <br />
                    <button type="button" class="btn me-2 btn-danger btn-square btn-block btn-deposit">Deposit</button>
                    <br /><br />
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row" id="row-wallet">

</div>