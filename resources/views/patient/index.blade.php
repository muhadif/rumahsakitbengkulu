@extends('layouts.app', ['title' => __('Manajemen Data Penyakit')])

@section('content')
    @include('layouts.headers.head')
    
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Data Penyakit') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <div class="dropdown">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="" class="btn btn-sm bg-yellow text-white">{{ __('Filter / Perhitungan') }}</a>
                                    <div class="filter-dropup dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <h5 class="card-title text-uppercase text-light text-muted mb-0">filter / perhitungan</h5>
                                        <br>
                                            <form action="{{ route('calculate_apriori') }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                  <label for="">Min Support</label>
                                                  <input type="text"
                                                    class="form-control form-control-alternative" name="support" id=""  placeholder="Min Support">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Min Confident</label>
                                                    <input type="text"
                                                      class="form-control form-control-alternative" name="confidence" id=""  placeholder="Min Confident">
                                                </div>
                                                <div class="text-right">
                                                    <input type="submit" name="submit" id="" class="btn btn-primary btn-sm" href="#" role="button" value="Proses"/>
                                                </div>

                                            </form>   
                                    </div>
                                </div>
                                
                                <a href="" class="btn btn-sm btn-success">{{ __('Cetak') }}</a>
                                <a href="{{ route('patients.create') }}" class="btn btn-sm btn-primary">{{ __('Tambah Data Penyakit') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('No') }}</th>
                                    <th scope="col">{{ __('Kode') }}</th>
                                    <th scope="col">{{ __('Tanggal') }}</th>
                                    <th scope="col">{{ __('Nama Pasien') }}</th>
                                    <th scope="col">{{ __('Diagnosa') }}</th>
                                    <th scope="col">{{ __('Kategori') }}</th>
                                    <th scope="col">{{ __('Alamat') }}</th>
                                    <th scope="col">{{ __('Aksi') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $key => $value)
                                    <tr>
                                        {{-- <td>{{ $user->name }}</td> --}}
                                        <td>{{ $patients->firstitem() + $key }}</td>
                                        <td>
                                            {{-- <a href="mailto:{{ $user->email }}">{{ $user->email }}</a> --}}
                                            {{ $value->id }}
                                        </td>
                                        <td>
                                            {{-- {{ $user->created_at->format('d/m/Y H:i') }} --}}
                                            {{ $value->date }}
                                        </td>
                                        <td>
                                            {{ $value->name }}
                                        </td>
                                        <td>
                                            {{ $value->diagnosis }}
                                        </td>
                                        <td>
                                            {{ $value->category }}
                                        </td>
                                        <td>
                                            {{ $value->address }}
                                        </td>
                                        <td class="text-right">
                                            <a class="btn text-white bg-teal btn-sm" href="{{ route('patients.edit', ['patient'=>$value->id]) }}" role="button">Edit</a>
                                            <a class="btn btn-danger btn-sm" href="{{ route('patients.destroy', ['patient'=>$value->id]) }}" role="button">Hapus</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $patients->links() }}
                        </nav>
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
        $('#dataNav').addClass('active');
    </script>
@endpush