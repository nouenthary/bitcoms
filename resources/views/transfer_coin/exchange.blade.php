<div class="col-xl-12">
    <form id="form-create">

        @csrf

        <div class="card">
            <div class="card-body pb-2">
                <h1 class="text-center no-border font-w600 fs-60 mt-2"><span class="text-success">Jiade</span> to <span class="text-danger">Bitcoins</span> Coins at the<br> Jiade with no additional charges</h1>
                <h4 class="text-center ">Trusted by millions user with over $1 Trillion in crypto transactions.</h4>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="text-center mt-3 row justify-content-center">
                            <div class="col-xl-5">
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6">
                                        <input type="number" readonly class="form-control mb-3" id="balance" name="balance" placeholder="" value="0">
                                    </div>
                                    <div class="col-xl-6 col-sm-6">
                                        <select class="default-select exchange-select form-control select2-width-75" id="fkwalletid" name="fkwalletid">
                                            <option value="">All</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-xl-1">
                                <div class="equalto">
                                    =
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="row">
                                    <div class="col-xl-6 col-sm-6">
                                        <input type="number" readonly class="form-control mb-3" id="amount" name="amount" placeholder="Amount Exchange" value="0">
                                    </div>
                                    <div class="col-xl-6 col-sm-6">
                                        <select class="default-select exchange-select form-control" id="towalletname" name="towalletname">
                                            <option value="USDT">USDT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4 mb-4">

                            <input type="hidden" id="tranfercoinid" name="tranfercoinid" value="0" />
                            <input type="hidden" id="fkuserid" name="fkuserid" value="0" />
                            <input type="hidden" id="fromwalletname" name="fromwalletname" value="" />
                            <input type="hidden" id="logofromwallet" name="logofromwallet" value="" />
                            <input type="hidden" id="logotowallet" name="logotowallet" value="" />
                            <input type="hidden" id="exchange_price" name="exchange_price" value="" />

                            <button class="btn btn-warning mx-auto btn-sm" id="btn-exchange">
                                <i class="fa fa-exchange"></i> TRANSFER COINS
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>