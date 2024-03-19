<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="form-validation">
                <form id="form-create" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Order Confirmation
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        @csrf

                        {{-- <div class="table-responsive"> --}}
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
                                            Current Price
                                        </td>
                                        <td class="text-current-price">
                                            0,00
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="">
                                            Select expiration time
                                        </td>
                                        <td>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">

                                            <div class="row">

                                                <div class="col-md-1">

                                                </div>

                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-block btn-time"
                                                        data-time="30">
                                                        30s
                                                    </button>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-block btn-time"
                                                        data-time="60" disabled>
                                                        60s
                                                    </button>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-block btn-time"
                                                        data-time="180" disabled>
                                                        180s
                                                    </button>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-block btn-time"
                                                        data-time="1800" disabled>
                                                        1800s
                                                    </button>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-outline-success btn-block btn-time"
                                                        data-time="10080" disabled>
                                                        10080s
                                                    </button>
                                                </div>

                                                <div class="col-md-1">

                                                </div>

                                            </div>

                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            Fee percentage
                                        </td>
                                        <td class="text-percent">
                                            <span class="text-fee">0,00</span> <span>%</span>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            Lot size
                                        </td>
                                        <td class="text-percent">
                                            <span class="text-lot">0,00</span> <span
                                                class="text-currcencys text-uppercase">USDT</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2">
                                            <input type="text" id="amount" name="amount" class="form-control number"
                                                autocomplete="off" placeholder="Enter lot size">
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            Balance <span class="text-balance">0,00</span> USTD
                                        </td>
                                        <td class="text-percent">
                                            Handing fee = <span class="text-fee-amount">0,00</span> amount = <span
                                                class="text-amount-total">1,00</span> USTD
                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                            {{--
                        </div> --}}

                        <input id="tradeid" name="tradeid" type="hidden" value="0">
                        <input id="fkuserid" name="fkuserid" type="hidden" value="0">
                        <input id="feepercent" name="feepercent" type="hidden" value="0">
                        <input id="feeamount" name="feeamount" type="hidden" value="0">
                        <!-- <input id="amount" name="amount" type="hidden" value="0"> -->
                        <input id="totalamount" name="totalamount" type="hidden" value="0">
                        <input id="namecurrency" name="namecurrency" type="hidden" value="">
                        <input id="wintrade" name="wintrade" type="hidden">
                        <input id="lastprice" name="lastprice" type="hidden" value="0">
                        <input id="logocurrency" name="logocurrency" type="hidden" value="">
                        <input id="dateupdate" name="dateupdate" type="hidden" value="">
                        <input id="timeupdate" name="timeupdate" type="hidden" value="">
                        <input id="timetrade" name="timetrade" type="hidden" value="0">
                        <input id="tradetitle" name="tradetitle" type="hidden" value="buy less">
                        <input id="status" name="status" type="hidden" value="complete">

                    </div>
                    <div class="modal-footers m-4">
                        <div class="col-md-12">
                            <div class="row">
                                <div class=" col-sm-6">
                                    <button type="button" class="btn btn-light btn-block btn-squares"
                                        data-bs-dismiss="modal">Cancel </button>
                                </div>

                                <div class=" col-sm-6">
                                    <button type="submit" class="btn btn-danger btn-block btn-squares"
                                        id="btn-create">OK </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>