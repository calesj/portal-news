@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Ads')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Update Ads') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.ad.update', 1)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <h5>{{ __('Home Page Ads') }}</h5>
                    <div class="form-group">
                        <img src="{{ asset($ad->home_top_bar_ad) }}" width="200px" alt="">
                        <br>
                        <label for="name">{{ __('Top Bar ad') }}</label>
                        <input type="file" name="home_top_bar_ad" id="name" class="form-control">
                        @error('home_top_bar_ad')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input
                                {{ $ad->home_top_bar_ad_status == 1 ? 'checked' : '' }}
                                name="home_top_bar_ad_status"
                                value="1" type="checkbox"
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <div class="form-group">
                        <img src="{{ asset($ad->home_middle_ad) }}" width="200px" alt="">
                        <br>
                        <label for="">{{ __('Middle ad') }}</label>
                        <input type="file" name="home_middle_ad" id="name" class="form-control">
                        @error('home_middle_ad')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input
                                {{ $ad->home_middle_ad_status == 1 ? 'checked' : '' }}
                                name="home_middle_ad_status"
                                value="1" type="checkbox"
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <h5>{{ __('News View Page Ads') }}</h5>
                    <div class="form-group">
                        <img src="{{ asset($ad->view_page_ad) }}" width="200px" alt="">
                        <br>
                        <label for="">{{ __('Bottom ad') }}</label>
                        <input type="file" name="view_page_ad" id="name" class="form-control">
                        @error('view_page_ad')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input
                                {{ $ad->view_page_ad_status == 1 ? 'checked' : '' }}
                                name="view_page_ad_status"
                                value="1" type="checkbox"
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <h5>{{ __('News Page Ads') }}</h5>
                    <div class="form-group">
                        <img src="{{ asset($ad->news_page_ad) }}" width="200px" alt="">
                        <br>
                        <label for="">{{ __('Bottom ad') }}</label>
                        <input type="file" name="news_page_ad" id="name" class="form-control">
                        @error('news_page_ad')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input
                                {{ $ad->news_page_ad_status == 1 ? 'checked' : '' }}
                                name="news_page_ad_status"
                                value="1" type="checkbox"
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <h5>{{ __('Sidebar Ad') }}</h5>
                    <div class="form-group">
                        <img src="{{ asset($ad->side_bar_ad) }}" width="200px" alt="">
                        <br>
                        <label for="">{{ __('Sidebar ad') }}</label>
                        <input type="file" name="side_bar_ad" id="name" class="form-control">
                        @error('side_bar_ad')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <label class="custom-switch mt-2">
                            <input
                                {{ $ad->side_bar_ad_status == 1 ? 'checked' : '' }}
                                name="side_bar_ad_status"
                                value="1" type="checkbox"
                                class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
                </form>
            </div>
        </div>
    </section>

@endsection
