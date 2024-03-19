@extends('layout.main')
@section('title', 'Wallet Title')

@section('content')
<!--*********************************
            Content body start
    ***********************************-->
@include('wallet_title.style')

<!-- <br> <br> <br> -->

<div class="content-body">

    <div class="container-fluid">

        <!-- <div class="pt-0"></div> -->

        <button type="button" class="btn btn-danger btn-sm" id="btn-open-form-create">
            <i class="fa fa-plus-circle"></i>
            Wallet Title
        </button>

        <div class="pt-2"></div>

        @include('wallet_title.list_view')

    </div>
</div>

@include('wallet_title.modal_create')

@include('wallet_title.modal_delete')

@include('wallet_title.modal_image')

<!--**********************************
                Content body end
    ***********************************-->
@endsection

@section('scripts')
@parent
@include('wallet_title.script')
@endsection

@section('footer')
@include('wallet_title.footer')
@endsection