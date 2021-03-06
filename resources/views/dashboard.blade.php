@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card filter-card card-stats mb-4 mb-lg-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Filter</h5>
                                <br>

                                {{-- Form grafik --}}
                                <form action="{{ route('home') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label for="">Tanggal</label>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                    </div>
                                                    <input id="chart-date" name="date" class="form-control" placeholder="Select date" type="date" value="2020-01-06" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Diagnosa</label>
                                            <select name="diagnosis" id="chart-diagnosis" class="form-control input-group-alternative" data-toggle="select" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
                                                <option value="all" selected>All</option>
                                                @foreach ($diagnoses as $value)
                                                    <option value="{{ $value->diagnosis }}">{{ $value->diagnosis }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="">Alamat</label>
                                            <select name="address" id="chart-address" class="form-control input-group-alternative" data-toggle="select" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
                                                <option value="all" selected>All</option>
                                                @foreach ($addresses as $value)
                                                    <option value="{{ $value->address }}">{{ $value->address }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="hidden-treasure" for="">x</label>
                                            <input id="chart-filter-button" type="submit" class="btn-filter btn btn-primary" value="Filter"/>
                                        </div>
                                    </div>
                                </form>                                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card bg-gradient-default shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-light ls-1 mb-1">Grafik</h6>
                                <h2 class="text-white mb-0">Data Jumlah Penyakit</h2>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Chart -->
                        <div class="chart">
                            <!-- Chart wrapper -->
                            <canvas id="chart-disease" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>
        $('#homeNav').addClass('active');
        $(document).ready(function() {
            $('#chart-date').val(new Date().toDateInputValue());
        })
    </script>
@endpush