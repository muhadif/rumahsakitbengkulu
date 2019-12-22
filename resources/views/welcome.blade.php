@extends('layouts.app', ['class' => 'bg-default'])

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mt-7 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6 text-center">
                        <img src="img/baktihusada.png" width="25%" alt="">
                        <br><br>
                        <h1 class="text-white" >RSUD Arga Makmur Bengkulu</h1>
                        <span class="text-light">Alamat : Khadijah, Jl. Siti Khodijah No.08, Kali, Arma Jaya, Kabupaten Bengkulu Utara, Bengkulu </span>
                        <br><br>
                        <a name="" id="" class="btn btn-warning" href="{{ route('register') }}" role="button">
                                <i class="ni ni-circle-08"></i>
                                <span class="nav-link-inner--text">Registrasi</span>
                        </a>
                        <a name="" id="" class="btn btn-primary" href="{{ route('login') }}" role="button">
                                <i class="ni ni-key-25"></i>
                                <span class="nav-link-inner--text">Masuk</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <div class="container mt--10 pb-5"></div>
@endsection
