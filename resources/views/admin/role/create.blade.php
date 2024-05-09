@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Role')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create Role') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.role.store')}}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">{{ __('Role Name') }}</label>
                        <input type="text" name="role" id="name" class="form-control">
                        @error('role')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr>
                    @foreach($permissions as $groupName => $permission)
                        <div class="form-group">
                            <h6 class="text-primary"> {{ $groupName }} </h6>

                            <div class="form-group">
                                <div class="row">
                                    @foreach($permission as $item)

                                        <div class="col-md-2">
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" name="permissions[]"
                                                       class="custom-switch-input" value="{{ $item->name }}">
                                                <span class="custom-switch-indicator"></span>
                                                <span
                                                    class="custom-switch-description text-primary">{{ $item->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                @endforeach

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Create')}}</button>
                </form>
            </div>
        </div>
    </section>

@endsection
