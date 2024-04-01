@extends('layout.main')
@section('title', 'Privacy Policy')

@section('content')

@include('main_confirmation.style')

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

        <div class="col-md-6">
            <div class="card profile-card card-bx m-b30 ">
                <div class="card-header">
                    <h4 class="card-title">Language Name</h4>
                </div>
                <form class="profile-form">
                    <div class="card-body">
                        <input type="text" class="form-control language_name" id="language_name" name="language_name" value="" placeholder="Enter Language Name">
                        <br>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-create">Add Language</button>
                    </div>

                </form>
            </div>
        </div>


        <div class="image-box">
            <div class="col-md-12 cart-image">
                <div class="card profile-card card-bx m-b30 ">
                    <div class="card-header">
                        <div class="row">
                            <h4 class="card-title">
                                Language : <span class="t-name">EN</span>
                            </h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row t-row-image">

                            <div class="col-md-2">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid t-image" src="images/product/1.jpg" alt="">
                                    </div>

                                    <button class="btn mt-1 btn-outline-danger btn-sm btn-block">
                                        <i class="fa fa-remove"></i>
                                    </button>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid" src="images/product/1.jpg" alt="">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid" src="images/product/1.jpg" alt="">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid" src="images/product/1.jpg" alt="">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid" src="images/product/1.jpg" alt="">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="new-arrival-product">
                                    <div class="new-arrivals-img-contnent">
                                        <img class="img-fluid" src="images/product/1.jpg" alt="">
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card-footer">
                        <input type="file" name="image_path" id="image_path" class="form-control image_path">
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!--**********************************
        Content body end
    ***********************************-->

@endsection

@section('scripts')
@parent
@include('privacy.script')
@endsection

@section('footer')
@include('wallet_title.footer')
@endsection