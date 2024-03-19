<div class="modal fade" id="modal-trade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="form-validation">
                <form id="form-trade" class="needs-validation" novalidate enctype="multipart/form-data">

                    <div class="modal-body">

                        @csrf

                        <div class="box-center">
                            <div class="trade-count-down bg-secondary">
                                <p class="text-center text-count-down">
                                    0
                                </p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm header-border table-responsive-sm">

                                <tbody>
                                    <tr>
                                        <td>
                                            Trading Pair
                                        </td>
                                        <td class="text-type font-weight-bold text-uppercase">
                                            <span class="text-currcency">XXX</span> /USTD
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Direction
                                        </td>
                                        <td class="text-buy text-danger">
                                            Buy less
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Buy price
                                        </td>
                                        <td class="text-amount">
                                            0,00
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            Current Price
                                        </td>
                                        <td class="text-current-price">
                                            0,00
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Lot size
                                        </td>
                                        <td class="text-percent">
                                            <span class="text-lot">0,00</span> <span class="text-currcencys text-uppercase">USDT</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footers m-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    <button type="button" class="btn btn-secondary btn-block btn-squares" data-bs-dismiss="modal">
                                        Continue to trade
                                    </button>
                                </div>


                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
