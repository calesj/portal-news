@extends('frontend.layouts.master')

@section('content')
    <!-- Tranding News carousel-->
    @include('frontend.home-components.tranding-news')
    <!-- End Tranding News carousel -->

    <!-- Hero News Section -->
    @include('frontend.home-components.hero-slider')
    <!-- End Hero News -->

    <div class="large_add_banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="large_add_banner_img">
                        <img src="images/placeholder_large.jpg" alt="adds">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular news category -->
    @include('frontend.home-components.main-news')
    <!-- End Popular news category -->
@endsection
