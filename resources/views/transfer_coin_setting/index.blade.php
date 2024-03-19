@extends('layout.main')

@section('title', 'Transfer Coins')

@section('content')

@include('transfer_coin_setting.style')

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">
        <div class="row">

            @include('transfer_coin_setting.filter')

            @include('transfer_coin_setting.list_view')

        </div>
    </div>
</div>

<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')

@parent

@include('transfer_coin_setting.script')

@endsection

@section('footer')
@include('wallet_title.footer')
@endsection