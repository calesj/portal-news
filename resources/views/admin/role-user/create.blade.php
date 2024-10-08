@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Role User')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create User with Role') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.role-users.store')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">{{ __('User Name') }}</label>
                        <input type="text" name="name" class="form-control">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Email') }}</label>
                        <input type="text" name="email" class="form-control">
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" class="form-control">
                        @error('password_confirmation')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Role') }}</label>
                        <select name="role" id="" class="select2 form-control">
                            <option value=""> {{ __('--Select--') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"> {{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Create')}}</button>
                </form>
            </div>
        </div>
    </section>

@endsection
