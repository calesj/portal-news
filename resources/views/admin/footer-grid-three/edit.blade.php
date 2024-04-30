@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Footer Grid One')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create link for footer grind one') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.footer-grid-one.update', $footer->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">{{ __('Language')}}</label>
                        <select name="language" id="language-select" class="form-control select2">
                            <option value="">--{{ __('Select') }}--</option>
                            @foreach($languages as $lang)
                                <option {{ $lang->lang == $footer->language ? 'selected' : '' }} value="{{ $lang->lang }}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                        @error('lang')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ $footer->name }}">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Url') }}</label>
                        <input type="text" name="url" class="form-control" value="{{ $footer->url }}">
                        @error('url')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">{{ __('Status')}}</label>
                        <select name="status" class="form-control">
                            <option {{ $footer->status == 1 ? 'selected' : '' }} value="1">{{ __('Active') }}</option>
                            <option {{ $footer->status == 0 ? 'selected' : '' }} value="0">{{ __('Inactive') }}</option>
                        </select>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
                </form>
            </div>
        </div>
    </section>

@endsection
