@extends('layout.main')
@section('title', 'Wallet')

@section('content')

@include('wallet.style')

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">
        @include('wallet.card_wallet')
    </div>
</div>

@include('wallet.modal_create')

@include('wallet.modal_deposit')
<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')
@parent
@include('wallet.script')
@endsection

@section('footer')
@include('wallet_title.footer')
@endsection