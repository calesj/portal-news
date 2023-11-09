@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Language')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Edit Language') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.language.update', $language->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">{{ __('Language')}}</label>
                        <select name="lang" id="language-select" class="form-control select2">
                            <option value="">--Select--</option>
                            @foreach(config('language') as $key => $lang)
                                <option
                                    @if($language->lang === $key)
                                        selected
                                    @endif
                                    value="{{ $key }}">{{$lang['name']}}</option>
                            @endforeach
                        </select>
                        @error('lang')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input readonly type="text" name="name" id="name" value="{{ $language->name }}" class="form-control">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">{{ __('Slug') }}</label>
                        <input readonly type="text" class="form-control" name="slug" id="slug" value="{{ $language->slug }}">
                        @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="default">{{ __('Is it Default?')}}</label>
                        <select name="default" id="" class="form-control">
                            <option {{ $language->default ? 'selected' : null }} value="1">{{ __('Yes') }}</option>
                            <option {{ !$language->default ? 'selected' : null }} value="0">{{ __('No') }}</option>
                        </select>
                        @error('default')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">{{ __('Status')}}</label>
                        <select name="status" id="" class="form-control">
                            <option {{ $language->status ? 'selected' : null }} value="1">{{ __('Active') }}</option>
                            <option {{ !$language->status ? 'selected' : null }} value="0">{{ __('Inactive') }}</option>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#language-select').on('change', function () {
                let value = $(this).val();
                let name = $(this).children(':selected').text();
                $('#slug').val(value);
                $('#name').val(name);
            })
        })
    </script>
@endpush
