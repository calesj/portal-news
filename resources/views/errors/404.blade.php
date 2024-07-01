@extends('frontend.layouts.master')

@section('content')
<!-- 404 start-->
<section class="wrap__section">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-sm-10 col-md-8 col-lg-7 m-auto text-center">
                <div class="error_text">
                    <div class="img">
                        <img src="{{ asset('frontend/assets/images/error.jpg') }}" alt="error">
                    </div>
                    <h4>OOOps ! Sorry Page Not Found</h4>
                    <p> The page you are looking for does not exist. It may have been moved, or removed altogether.
                    </p>
                    <a class="btn btn-primary" href="{{ route('dashboard') }}">go home</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- 404 end -->
@endsection
