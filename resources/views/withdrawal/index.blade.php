@extends('layout.main')
@section('title', 'Withdrawal')

@section('content')

@include('withdrawal.style')

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">

        @include('withdrawal.tab')

        <div class="tab-content" id="nav-tabContent">



            <div class="tab-pane active show fade" id="nav-etherum" role="tabpanel" aria-labelledby="nav-etherum-tab">
                @include('withdrawal.transaction')
            </div>

            <div class="tab-pane fade " id="nav-bitcoin" role="tabpanel" aria-labelledby="nav-bitcoin-tab">
                @include('withdrawal.card_wallet')
            </div>

        </div>

    </div>
</div>

@include('withdrawal.modal_deposit')

<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')
@parent
@include('withdrawal.script')
@endsection

@section('footer')
@include('wallet_title.footer')
@endsection