@extends('frontend.layouts.master')

@section('content')

    <section class="blog_pages">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Breadcrumb -->
                    <ul class="breadcrumbs bg-light mb-4">
                        <li class="breadcrumbs__item">
                            <a href="{{ url('/') }}" class="breadcrumbs__url">
                                <i class="fa fa-home"></i> {{ __('frontend.Home') }}</a>
                        </li>
                        <li class="breadcrumbs__item">
                            <a href="javascript:;" class="breadcrumbs__url">{{ __('frontend.News') }}</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="blog_page_search">
                        <form action="{{ route('news') }}" method="GET">
                            <div class="row">
                                <div class="col-lg-5">
                                    <input type="text" name="search" placeholder="Type here" value="{{ request()->search }}">
                                </div>
                                <div class="col-lg-4">
                                    <select name="category">
                                        <option value="">{{ __('frontend.All') }}</option>
                                        @foreach($categories as $category)
                                            <option {{ $category->slug === request()->category ? 'selected' : '' }} value="{{ $category->slug }}">{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <button type="submit">{{ __('frontend.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <aside class="wrapper__list__article ">
                        @if(request()->has('category'))
                            <h4 class="border_section">{{ __('frontend.Category') }}: {{ request()->category }} </h4>
                        @endif

                        <div class="row">
                            @foreach($news as $post)
                                <div class="col-lg-6">
                                    <!-- Post Article -->
                                    <div class="article__entry">
                                        <div class="article__image">
                                            <a href="{{ route('news-details', $post->slug) }}">
                                                <img src="{{ asset($post->image) }}" alt="" class="img-fluid">
                                            </a>
                                        </div>
                                        <div class="article__content">
                                            <div class="article__category">
                                                {{ $post->category->name }}
                                            </div>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                <span class="text-primary">
                                                    {{ __('frontend.By') }} {{ $post->author->name }}
                                                </span>
                                                </li>
                                                <li class="list-inline-item">
                                                <span class="text-dark text-capitalize">
                                                    {{ date('d M Y', strtotime($post->created_at)) }}
                                                </span>
                                                </li>

                                            </ul>
                                            <h5>
                                                <a href="{{ route('news-details', $post->slug) }}">
                                                    {!! truncateStr($post->title) !!}
                                                </a>
                                            </h5>
                                            <p>
                                                {!! truncateStr($post->content) !!}
                                            </p>
                                            <a href="{{ route('news-details', $post->slug) }}" class="btn btn-outline-primary mb-4 text-capitalize"> {{ __('frontend.read
                                                more') }}</a>
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                            @if(count($news) === 0)
                                <div class="text-center w-100">
                                    <h4> {{ __('frontend.No News Found') }} :(</h4>
                                </div>
                            @endif
                        </div>

                    </aside>

                    <div class="text-center" style="display: flex;
                    justify-content: center">
                        <!-- Pagination -->
                        {{ $news->appends(request()->query())->links() }}
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="sidebar-sticky">
                        <aside class="wrapper__list__article ">
                            <h4 class="border_section">Sidebar</h4>
                            <div class="wrapper__list__article-small">
                                @foreach($recentNews as $news)
                                    @if($loop->index < 3)
                                        <div class="mb-3">
                                            <!-- Post Article -->
                                            <div class="card__post card__post-list">
                                                <div class="image-sm">
                                                    <a href="{{ route('news-details', $news->slug) }}">
                                                        <img src="{{ asset($news->image) }}" class="img-fluid" alt="">
                                                    </a>
                                                </div>


                                                <div class="card__post__body ">
                                                    <div class="card__post__content">

                                                        <div class="card__post__author-info mb-2">
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item">
                                                            <span class="text-primary">
                                                                {{ __('frontend.By') }} {{ $news->author->name }}
                                                            </span>
                                                                </li>
                                                                <li class="list-inline-item">
                                                            <span class="text-dark text-capitalize">
                                                                {{ date('d M Y', strtotime($news->created_at)) }}
                                                            </span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <div class="card__post__title">
                                                            <h6>
                                                                <a href="{{ route('news-details', $news->slug) }}">
                                                                    {!! truncateStr($news->title) !!}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Post Article -->
                                        <div class="article__entry">
                                            <div class="article__image">
                                                <a href="{{ route('news-details', $news->slug) }}">
                                                    <img src="{{ asset($news->image) }}" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="article__content">
                                                <div class="article__category">
                                                    travel
                                                </div>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                <span class="text-primary">
                                                    {{ __('frontend.By') }} {{ $news->author->name }}
                                                </span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                <span class="text-dark text-capitalize">
                                                    {{ date('d M Y', strtotime($news->created_at)) }}
                                                </span>
                                                    </li>

                                                </ul>
                                                <h5>
                                                    <a href="{{ route('news-details', $news->slug) }}">
                                                        {!! truncateStr($news->title) !!}
                                                    </a>
                                                </h5>
                                                <p>
                                                    {!! truncateStr($news->content, 100) !!}
                                                </p>
                                                <a href="{{ route('news-details', $news->slug) }}" class="btn btn-outline-primary mb-4 text-capitalize">{{ __('frontend.Read more') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </aside>

                        <aside class="wrapper__list__article">
                            <h4 class="border_section">tags</h4>
                            <div class="blog-tags p-0">
                                <ul class="list-inline">
                                    @foreach($mostCommonTags as $commonTags)
                                        <li class="list-inline-item">
                                            <a href="{{ route('news', ['tag' => $commonTags->name]) }}">
                                                #{{ $commonTags->name }} ({{ convertToKFormat($commonTags->count) }})
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>

                        <aside class="wrapper__list__article">
                            <h4 class="border_section">{{ __('frontend.newsletter') }}</h4>
                            <!-- Form Subscribe -->
                            <div class="widget__form-subscribe bg__card-shadow">
                                <h6>
                                    {{ __('frontend.The most important world news and events of the day.') }}
                                </h6>
                                <p><small>{{ __('frontend.Get magzrenvi daily newsletter on your inbox.') }}</small></p>
                                <form action="" class="newsletter-form">
                                    <div class="input-group ">
                                        <input type="text" class="form-control" name="email" placeholder="Your email address">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary newsletter-button" type="submit">{{ __('frontend.sign up') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </aside>

                        @if($ad->side_bar_ad_status)
                            <br>
                            <aside class="wrapper__list__article">
                                <h4 class="border_section">{{ __('frontend.Advertise') }}</h4>
                                <a href="{{ $ad->side_bar_ad_url }}">
                                    <figure>
                                        <img src="{{ asset($ad->side_bar_ad) }}" alt="" class="img-fluid">
                                    </figure>
                                </a>
                            </aside>
                        @endif
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
        @if($ad->news_page_ad_status)
            <a href="{{ $ad->news_page_ad_url }}">
                <div class="large_add_banner my-4">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="large_add_banner_img">
                                    <img src="{{ asset($ad->news_page_ad) }}" alt="adds">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

        @endif
    </section>

@endsection
