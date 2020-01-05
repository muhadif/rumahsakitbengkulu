@extends('layouts.app', ['title' => __('Kelola Data Penyakit')])

@section('content')
    @include('users.partials.header', ['title' => __('Tambah Data Penyakit')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Data Penyakit') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('data.index') }}" class="btn btn-sm btn-primary">{{ __('Kembali') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('data.store') }}" autocomplete="off">
                            @csrf
                            
                            <h6 class="heading-small text-muted mb-4">{{ __('Informasi Penyakit') }}</h6>
                            <div class="pl-lg-4">

                                {{-- Kode --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Nama Pasien') }}</label>
                                    <input type="text" name="id" class="form-control form-control-alternative" placeholder="{{ __('Kode') }}" required>
                                </div>

                                {{-- Nama --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Nama Pasien') }}</label>
                                    <input type="text" name="name" class="form-control form-control-alternative" placeholder="{{ __('Nama Pasien') }}" required>
                                </div>

                                {{-- Tanggal --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Tanggal') }}</label>
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control" name="date" placeholder="Select date" type="date" >
                                    </div>
                                </div>

                                {{-- Kategori --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Kategori') }}</label>
                                    <select name="category" id="category" class="form-control input-group-alternative" data-toggle="select" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
                                        @foreach ($categories as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Alamat --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Alamat') }}</label>
                                    <textarea name="address" class="form-control form-control-alternative"  rows="3"></textarea>
                                </div>

                                {{-- Doctor --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Doctor') }}</label>
                                    <select name="doctor" id="doctor" class="form-control input-group-alternative" data-toggle="select" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
                                        @foreach ($doctors as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Diagnosa --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Diagnosa') }}</label>
                                    <input type="text" name="diagnosis" class="form-control form-control-alternative" placeholder="{{ __('Diagnosa') }}" required>
                                </div>

                                {{-- Reset/Simpan --}}
                                <div class="text-right">
                                    <button type="reset" class="btn btn-danger">{{ __('Reset') }}</button>

                                    <button type="submit" class="btn btn-success">{{ __('Simpan') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        $('#dataNav').addClass('active');
    </script>
@endpush