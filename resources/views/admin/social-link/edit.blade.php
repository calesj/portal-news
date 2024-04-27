@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Social Links')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create Social Link') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.social-link.update', $socialLink->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">{{ __('Icon') }}</label>
                        <br>
                        <!-- Button tag -->
                        <button class="btn btn-primary" name="icon" data-icon="{{ $socialLink->icon }}" role="iconpicker"></button>
                        @error('icon')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Url') }}</label>
                        <input type="text" name="url" id="url" class="form-control" value="{{ $socialLink->url }}">
                        @error('url')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">{{ __('Status')}}</label>
                        <select name="status" id="" class="form-control">
                            <option {{$socialLink->status === 1 ? 'selected' : ''}} value="1">{{ __('Active') }}</option>
                            <option {{$socialLink->status === 0 ? 'selected' : ''}} value="0">{{ __('Inactive') }}</option>
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
