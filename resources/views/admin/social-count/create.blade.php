@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Category')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create Category') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.category.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">{{ __('Language')}}</label>
                        <select name="language" id="language-select" class="form-control select2">
                            <option value="">--{{ __('Select') }}--</option>
                            @foreach($languages as $lang)
                                <option value="{{ $lang->lang }}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                        @error('lang')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Show at Nav')}}</label>
                        <select name="show_at_nav" id="" class="form-control">
                            <option value="1">{{ __('Yes') }}</option>
                            <option value="0">{{ __('No') }}</option>
                        </select>
                        @error('default')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">{{ __('Status')}}</label>
                        <select name="status" id="" class="form-control">
                            <option value="1">{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Create')}}</button>
                </form>
            </div>
        </div>
    </section>

@endsection
