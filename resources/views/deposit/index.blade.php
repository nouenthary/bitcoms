@extends('layout.main')

@section('title', 'Transfer Coins')

@section('content')

@include('deposit.style')

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">
        <div class="row">

            @include('deposit.filter')

            @include('deposit.list_view')

        </div>
    </div>
</div>

<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')

@parent

@include('deposit.script')

@endsection

@section('footer')
@include('wallet_title.footer')
@endsection