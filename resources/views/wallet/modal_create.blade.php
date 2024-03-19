<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="form-validation">
                <form id="form-create" class="needs-validation" novalidate enctype="multipart/form-data">
                    <!-- <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Wallet</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-body">


                        @csrf

                        <input id="walletid" name="walletid" type="hidden" value="0">

                        <input id="fkwallettileid" name="fkwallettileid" type="hidden" value="">

                        @include('wallet.wallet_choose')

                        <div class="input-group mb-3">
                            <span class="input-group-text"> Address : </span>
                            <input type="text" class="form-control" id="wallet_address" name="wallet_address" placeholder="Enter wallet address" required readonly>
                            <span class="input-group-text fa-copy-form">
                                <i class="fa fa-copy"></i>
                            </span>
                        </div>

                        <div class="mb-3" style="display: none">
                            <label for="balance" class="form-label mb-2">Balance</label>
                            <input type="text" class="form-control" id="balance" name="balance" value="0">
                        </div>


                        <!-- <div class="mb-3">
                            <label for="formFileSm" class="form-label">Upload your private key</label>
                            <input class="form-control form-control-sm" id="private" name="private" type="file">
                        </div> -->

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-block btn-squares" id="btn-create">Add Wallet </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>