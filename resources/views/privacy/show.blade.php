@extends('layout.main')
@section('title', 'Privacy Policy')

@section('content')

<style>
    .pdf-image {
        margin-top: 5px;
    }
</style>

<!--**********************************
            Content body start
    ***********************************-->

<div class="content-body">
    <div class="container-fluid">
        <br>
        <br>
        <br>
        <br>

    
        @if($language == 'en')
            <div>
                <img src="/privacy/Privacy Policy English_Page_1.jpg" width="100%" alt="" class="pdf-image">
                <img src="/privacy/Privacy Policy English_Page_2.jpg" width="100%" alt="" class="pdf-image">
                <img src="/privacy/Privacy Policy English_Page_3.jpg" width="100%" alt="" class="pdf-image">
            </div>
        @endif

        @if($language == 'fr')
              <div>
                <img src="/privacy/politique de confidentialité French_Page_1.jpg" width="100%" alt="" class="pdf-image">
                <img src="/privacy/politique de confidentialité French_Page_2.jpg" width="100%" alt="" class="pdf-image">
            </div>
        @endif

        @if($language == 'sp')
            <div>
                <img src="/privacy/política de privacidad Spanish_Page_1.jpg" width="100%" alt="" class="pdf-image">
                <img src="/privacy/política de privacidad Spanish_Page_2.jpg" width="100%" alt="" class="pdf-image">
            </div>
        @endif

       

    </div>
</div>

<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')
@parent
@include('fee.script')
@endsection

@section('footer')
@include('wallet_title.footer')
@endsection