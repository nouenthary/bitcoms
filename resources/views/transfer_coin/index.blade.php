@extends('layout.main')

@section('title', 'Transfer Coins')

@section('content')

@include('transfer_coin.style')

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">
        <div class="row">

            @include('transfer_coin.exchange')

            @include('transfer_coin.list_view')

        </div>
    </div>
</div>

<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')

@parent

@include('transfer_coin.script')

@endsection

@section('footer')
@include('wallet_title.footer')
@endsection