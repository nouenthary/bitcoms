@extends('layout.main')
@section('title', 'Future Trading Transactions')

@section('content')

    @include('trade.style')

    <!--**********************************
            Content body start
    ***********************************-->

    <div class="content-body">
        <div class="container-fluid" id="app">

            <div class="box-trade-view"></div>

        </div>
    </div>
    <!--**********************************
            Content body end
        ***********************************-->

@endsection


@section('scripts')
    @parent

    <script>
        $(function () {
            // view box
            let page = 1;
            let size = 10;

            // get data to box views
            function getDeposit() {
                $(".box-trade-view").load("/get_trading_by_user?size=" + size + "&page=" + page);
            }

            getDeposit();
            //
            $(document).on("click", ".btn-next", function () {
                page += 1;
                if (page > 1) {
                    $('.btn-prev').removeAttr('disabled', '');
                }
                getDeposit();

                let count = $(".box-card").length;
                if(count < size){
                    page -= 1;
                    getDeposit();
                    $('.btn-next').attr('disabled', '');
                }
            });
            //
            $(document).on("click", ".btn-prev", function () {
                if (page === 1) {
                    $('.btn-prev').attr('disabled', '');
                    return;
                }
                page -= 1;
                getDeposit();
            });

        });
    </script>
@endsection

@section('footer')
    @include('wallet_title.footer')
@endsection
