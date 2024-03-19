<div class="list-deposit">
    <div class="col-lg-12">
        <div class="card transaction-table">
            <div class="card-header border-0 flex-wrap pb-0">
                <div class="mb-2">
                    <h4 class="card-title">

                        <span class="me-3 bgl-primary text-primary">

                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>

                        Recent user deposits
                    </h4>
                    <p class="mb-sm-3 mb-0"></p>
                </div>

                @include('main_confirmation.status')

            </div>

            <div class="card-body p-2">

                <div class="table-responsive">
                    <table class="table table-responsive-md table-deposit" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Date</th>
                                <th>Account</th>
                                <th>Wallet Name</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Voucher</th>
                                <th>Qr Image</th>
                                <th class="text-start">Approved by</th>
                                <th>Approved at</th>
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