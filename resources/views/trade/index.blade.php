@extends('layout.main')
@section('title', 'Future Trading')

@section('content')

    @include('trade.style')

    <!--**********************************
                                                                                        Content body start
                                                                               ***********************************-->

    <div class="content-body">
        <div class="container-fluid">

            <div class="row ">


                <input type="hidden" name="trade-status" id="trade-status" value="{{ Auth::user()->status }}"/>


                <div class="col-xl-12">
                    <div class="card bg-darks">

                        <div class="card-body">

                            <div class="market-coin flex-wrap">

                                <div class="d-flex align-items-center coin-box">

                                    <button class="btn btn-outline-secondary mb-1 btn-show-currency" data-toggle="modal"
                                            data-target="#modal-show-currcency">
                                        <i class="fa fa-bars"></i>
                                    </button>

                                    <div style="width: 10px"></div>

                                    <span>
                                    <img style="display: none;" class="v-logo-view" height="30px" width="30px"
                                         src="https://assets.coingecko.com/coins/images/1/large/bitcoin.png?1696501400"
                                         alt="">
                                </span>
                                    <div class="ms-3" style="display: none;">
                                        <span class="fs-14 font-w400 d-name">Bitcoin</span>
                                        <a href="javascript:void(0);">
                                            <h4 class="font-w600 mb-0">
                                                <span class="default-name text-uppercase">BTCUSTD</span>
                                            </h4>
                                        </a>
                                    </div>
                                </div>
                                <div class="coin-box" style="display: none;">
                                    <span class="mb-1 d-block">Mark Price</span>
                                    <div class="d-flex align-items-center">
                                        <h5 class="font-w600 m-0 d-currcent-price text-success text-current-price">
                                            0,00</h5>
                                        <span class="text-danger ms-2 d-current-price-percent">0%</span>
                                    </div>
                                </div>
                                <div class="coin-box text-white">
                                    <span class="mb-1 d-block text-white">Funding Rate</span>
                                    <h5 class="font-w600 m-0 text-warning d-rate-funding text-white">0%/hr</h5>
                                </div>
                                <div class="coin-box text-white">
                                    <span class="mb-1 d-block text-white">Volume</span>
                                    <h5 class="font-w600 m-0 text-green d-valume text-white">0,00k</h5>
                                </div>

                                <div class="coin-box">
                                    <span class="mb-1 d-block">Your Balance</span>
                                    <h5 class="font-w600 m-0 ml-2">
                                        <span class="text-balance text-danger ml-2">0,00</span> USTD
                                    </h5>
                                </div>
                            </div>


                            <div id="tradingview_85dc0"></div>


                            <div class="row mt-2">
                                <div class="col-sm-6">
                                    <button class="btn btn-danger btn-block btn-buy-less btn-sm">
                                    <span id="t-buy-less">
                                        0,00
                                    </span> <br>
                                        Buy less
                                    </button>
                                </div>

                                <div class="col-sm-6">
                                    <button class="btn btn-success btn-block btn-buy-more btn-sm">
                                    <span id="t-buy-more">
                                        0,00
                                    </span> <br>
                                        Buy more
                                    </button>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>


            {{--    load url --}}
{{--            <div class="box-trade-view"></div>--}}
            {{--    load url --}}


        </div>
    </div>

    @include('trade.modal_create')
    @include('trade.modal_trade')
    @include('trade.modal_choose_wallet')

    <!--**********************************
                                                                                    Content body end
                                                                                ***********************************-->

@endsection

@section('scripts')
    @parent
    @include('trade.script')
@endsection

@section('footer')
    @include('wallet_title.footer')
@endsection
