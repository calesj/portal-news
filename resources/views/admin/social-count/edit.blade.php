@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Social Count')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Update Social Link') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.social-count.update', $socialCount->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">{{ __('Language')}}</label>
                        <select name="language" id="language-select" class="form-control select2">
                            <option value="">--{{ __('Select') }}--</option>
                            @foreach($languages as $lang)
                                <option
                                    {{ $lang->lang === $socialCount->language ? 'selected' : '' }} value="{{ $lang->lang }}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                        @error('lang')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Icon') }}</label>
                        <br>
                        <!-- Button tag -->
                        <button class="btn btn-primary" data-icon="{{ $socialCount->icon }}" name="icon"
                                role="iconpicker"></button>
                        @error('icon')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Url') }}</label>
                        <input type="text" name="url" id="url" class="form-control" value="{{ $socialCount->url }}">
                        @error('url')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Fan Count') }}</label>
                        <input type="text" value="{{ $socialCount->fan_count }}" name="fan_count" id="name"
                               class="form-control">
                        @error('fan_count')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Fan Type') }}</label>
                        <input type="text" name="fan_type" value="{{ $socialCount->fan_type }}" id="fan_type"
                               class="form-control" placeholder="Ex: Likes, fans, followers">
                        @error('fan_type')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Button Text') }}</label>
                        <input type="text" name="button_text" value="{{ $socialCount->button_text }}"
                               class="form-control">
                        @error('button_text')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Pick Your Color</label>
                        <div class="input-group colorpickerinput">
                            <input type="text" name="color" value="{{ $socialCount->color }}" class="form-control">
                            <div class="input-group-append">
                                <div style="cursor: pointer" class="input-group-text">
                                    <i class="fas fa-fill-drip"></i>
                                </div>
                            </div>
                        </div>
                        @error('color')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">{{ __('Status')}}</label>
                        <select name="status" id="" class="form-control">
                            <option
                                {{ $socialCount->status === 1 ? 'selected' : '' }} value="1">{{ __('Active') }}</option>
                            <option
                                {{ $socialCount->status === 0 ? 'selected' : '' }} value="0">{{ __('Inactive') }}</option>
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

@push('scripts')
    <script>
        $(".colorpickerinput").colorpicker({
            format: 'hex',
            component: '.input-group-append',
        });
    </script>
@endpush
