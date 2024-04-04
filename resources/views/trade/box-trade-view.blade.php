@foreach($trading as $trade)

    <div class="bg-darks mb-2 p-3 text-white box-card" style="border-radius: 10px ; background: #35465d">

        <div class="d-flex justify-content-between">
            <div>
                Trading Pair
            </div>

            <div class="text-uppercase">
                <span>{{$trade->namecurrency}}/USDT</span>
            </div>
        </div>


        <div class="d-flex justify-content-between">
            <div>
                direction
            </div>

            <div class="{{ $trade->tradetitle == 'buy less' ? 'text-danger' : 'text-success' }}">
                {{$trade->tradetitle}}
            </div>
        </div>


        <div class="d-flex justify-content-between">
            <div>
                Buy price
            </div>

            <div>
                {{$trade->lastprice}}
            </div>
        </div>


        <div class="d-flex justify-content-between">
            <div>
                USDTLot size
            </div>

            <div>
                {{$trade->amount}}
            </div>
        </div>


        <div class="d-flex justify-content-between">
            <div>
                Order duration
            </div>

            <div>
                {{$trade->timetrade}}s
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <div>
                handing fee
            </div>

            <div>
                {{$trade->feeamount}} USDT
            </div>
        </div>


        <div class="d-flex justify-content-between">
            <div>
                Sell Time
            </div>

            <div>
                {{$trade->dateupdate}} {{$trade->timeupdate}}
            </div>
        </div>


        <div class="d-flex justify-content-between">
            <div>
                profit and loss
            </div>

            <div class="text-success">
                {{$trade->totalamount}} USDT
            </div>
        </div>

    </div>

@endforeach

<div class="d-flex">
    <div class="col-xl-5 col-lg-5 col-sm-12 ">
        <button class="btn btn-primary btn-block btn-sm btn-prev" >
            Previous
        </button>
    </div>

    <div class="col-xl-2 col-lg-2 col-sm-12 "></div>

    <div class="col-xl-5 col-lg-5 col-sm-12 ">
        <button class="btn btn-primary btn-block btn-sm btn-next">
            Next
        </button>
    </div>
</div>
