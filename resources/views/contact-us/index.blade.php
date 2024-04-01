@extends('layout.main')
@section('title', 'Contact Us')

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

            @php
                $model = DB::table('tblcontactus')->first();

                $company = DB::table('tblcompany')->first();

                $name = '';
                $logo = 'https://t4.ftcdn.net/jpg/02/42/83/23/240_F_242832348_HvNHaiEu6tAlklMGTSYgjS20RV2jjeKq.jpg';

                if($company != null){
                  $name = $company->nameweb;
                  $logo = $company->logo;
                }
            

            @endphp

            @if ($model != null)
                <div class="col-xl-12 col-md-12">
                    <div class="card justify-content-center">
                        <div class="card-body d-flex">
                            <div class="d-block">
                                <img src="{{$logo}}" class="avatar avatar-xxl border-primary rounded-circle"
                                    alt="">
                            </div>
                            <div class="w-100 ps-4">
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        <h4 class="card-title mb-1"> {{ $name }} </h4>

                                        <div class="d-flex align-items-center pe-md-4 pe-2 mb-2">
                                            <div class="pe-2">
                                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M20 4.5H4C3.20435 4.5 2.44129 4.81607 1.87868 5.37868C1.31607 5.94129 1 6.70435 1 7.5V17.5C1 18.2956 1.31607 19.0587 1.87868 19.6213C2.44129 20.1839 3.20435 20.5 4 20.5H20C20.7956 20.5 21.5587 20.1839 22.1213 19.6213C22.6839 19.0587 23 18.2956 23 17.5V7.5C23 6.70435 22.6839 5.94129 22.1213 5.37868C21.5587 4.81607 20.7956 4.5 20 4.5ZM21 17.25L16.1 12.85L21 9.42V17.25ZM3 9.42L7.9 12.85L3 17.25V9.42ZM9.58 14.03L11.43 15.32C11.5974 15.4361 11.7963 15.4984 12 15.4984C12.2037 15.4984 12.4026 15.4361 12.57 15.32L14.42 14.03L19.42 18.5H4.6L9.58 14.03ZM4 6.5H20C20.1857 6.50149 20.3673 6.55467 20.5245 6.65358C20.6817 6.75249 20.8083 6.89322 20.89 7.06L12 13.28L3.11 7.06C3.19171 6.89322 3.31826 6.75249 3.47545 6.65358C3.63265 6.55467 3.81428 6.50149 4 6.5Z"
                                                        fill="#F79F19" />
                                                </svg>
                                            </div>
                                            <h5 class="font-w400 mb-0">
                                                {{ $model->email }}
                                            </h5>
                                        </div>

                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
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
