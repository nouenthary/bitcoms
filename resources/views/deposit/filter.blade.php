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

                    <div class="col-xl-4 col-sm-12" style="display:none">
                        <label class="form-label">Wallet Name : </label>
                        <select class="form-control default-select wide fkwalletid select2-width-75" id="walletid" name="walletid">
                            <option value="">Select Menu</option>
                        </select>
                    </div>


                    <div class="col-xl-6 col-sm-12">
                        <div class="mb-3 vertical-radius">
                            <label class="text-label form-label  required" for="start_date">
                                Start Date :
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                <input id="start_date" name="start_date" class="form-control my-date" placeholder="YYYY/MM/DD">
                                <div class="invalid-feedback">
                                    Please Enter a username.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-sm-12">
                        <div class="mb-3 vertical-radius">
                            <label class="text-label form-label  required" for="start_date">
                                To Date :
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"> <i class="fa fa-calendar"></i> </span>
                                <input id="end_date" name="end_date" class="form-control my-date" placeholder="YYYY/MM/DD">
                                <div class="invalid-feedback">
                                    Please Enter a username.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
</div>

<div class="row">
    <div style="display: none;">
        @include('deposit.filter_user')
    </div>

    <div>
        @include('deposit.filter_wallet_title')
    </div>
</div>