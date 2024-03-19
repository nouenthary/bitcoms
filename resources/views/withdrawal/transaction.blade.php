<input type="hidden" name="p_status" id="p_status" value="">
<input type="hidden" name="p_wallet" id="p_wallet" value="">
<div class="col-xl-12">

    <div class="card">
        <div class="card-header flex-wrap border-0 row">

            <div class="col-md-3 col-sm-12">
                <h4 class="card-title mb-lg-0 mb-2">Wallet Transaction </h4>
            </div>

            <div class="col-md-3 col-sm-12">
                <div class="input-hasicon mb-sm-0 mb-131">
                    <input name="start_date" id="start_date" class="form-control my-date" placeholder="YYYY/MM/DD">
                    <div class="icon"><i class="far fa-calendar"></i></div>
                </div>

            </div>

            <div class="col-md-3 col-sm-12">
                <div class="input-hasicon mb-sm-0 mb-31">
                    <input name="end_date" id="end_date" class="form-control my-date" placeholder="YYYY/MM/DD">
                    <div class="icon"><i class="far fa-calendar"></i></div>
                </div>
            </div>

            <div class="col-md-3 col-sm-12">
                <ul class=" nav nav-pills">
                    <li class="nav-item my-1" data-status="">
                        <button class="nav-link active">All Status</button>
                    </li>
                    <li class="nav-item my-1" data-status="pending">
                        <button class="nav-link">Pending</button>
                    </li>
                    <li class="nav-item my-1" data-status="done">
                        <button class="nav-link">Done</button>
                    </li>
                </ul>
            </div>

        </div>
        <div class="card-body pt-0">
            <div class="tab-content" id="pills-tabContent">
                <div class="table-responsive dataTabletrade">
                    <table id="table-history" class="table shadow-hover display  orderbookTable tickettable display mb-4 no-footer">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Wallet Name</th>
                                <th>Balance</th>
                                <th>Total Balance</th>
                                <th>Fee</th>
                                <th>Total Fee</th>
                                <th>Address</th>
                                <th>Link</th>
                                <th>Status</th>
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

<!-- wallet -->

<div class="col-xl-12">
    <div class="card">
        <div class="card-header flex-wrap border-0 row">

            <div class="col-md-3 col-sm-12">
                <h4 class="card-title mb-lg-0 mb-2">Withdraw Transaction </h4>
            </div>

        </div>
        <div class="card-body pt-0">

            <div class="tab-content" id="pills-tabContents">
                <div class="table-responsive dataTabletrade">
                    <table id="table-history-wallet" class="table shadow-hover display orderbookTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Account</th>
                                <!-- <th>Wallet Name</th> -->
                                <th>Balance</th>
                                <th>Total Balance</th>
                                <th>Fee</th>
                                <th>Total Fee</th>
                                <th>Address</th>
                                <th>Link</th>
                                <th>Status</th>
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