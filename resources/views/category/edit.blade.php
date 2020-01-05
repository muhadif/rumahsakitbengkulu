@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Edit User')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('User Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('data.update', $data) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>
                            
                            <div class="pl-lg-4">

                                {{-- Name --}}
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', $data->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- Tanggal --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Tanggal') }}</label>
                                    <div class="input-group input-group-alternative{{ $errors->has('date') ? ' is-invalid' : '' }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control" name="date" placeholder="Select date" type="date"  value="{{ old('date', $data->date) }}" required>
                                    </div>
                                    @if ($errors->has('date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('date') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- Kategori --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Kategori') }}</label>
                                    <select name="category" id="category" class="form-control input-group-alternative{{ $errors->has('category') ? ' is-invalid' : '' }}" value="{{ old('category', $data->category) }}" required  data-toggle="select" title="Simple select" data-live-search="true" data-live-search-placeholder="Search ...">
                                        <option>Penyakit Dalam</option>
                                    </select>

                                    @if ($errors->has('category'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- Alamat --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Alamat') }}</label>
                                    <textarea name="address" class="form-control form-control-alternative{{ $errors->has('address') ? ' is-invalid' : '' }}"  rows="3"></textarea>
                                    
                                    @if ($errors->has('address'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- Doctor --}}
                                <div class="form-group">
                                    <label class="form-control-label" >{{ __('Doctor') }}</label>
                                    <input type="text" name="doctor" class="form-control form-control-alternative{{ $errors->has('doctor') ? ' is-invalid' : '' }}" placeholder="{{ __('Doctor') }}" required>
                                    
                                    @if ($errors->has('doctor'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('doctor') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                {{-- Diagnosis --}}
                                <div class="form-group{{ $errors->has('diagnosis') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-diagnosis">{{ __('Diagnosis') }}</label>
                                    <input type="diagnosis" name="diagnosis" id="input-diagnosis" class="form-control form-control-alternative{{ $errors->has('diagnosis') ? ' is-invalid' : '' }}" placeholder="{{ __('Diagnosis') }}" value="{{ old('diagnosis', $data->diagnosis) }}" required>

                                    @if ($errors->has('diagnosis'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('diagnosis') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="reset" class="btn btn-danger">{{ __('Reset') }}</button>

                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
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