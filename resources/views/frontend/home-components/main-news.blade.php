<section class="pt-0 mt-5">
    <div class="popular__section-news">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="wrapper__list__article">
                        <h4 class="border_section">{{ __('frontend.recent post') }}</h4>
                    </div>
                    <div class="row ">
                        @foreach($recentNews as $news)
                            @if($loop->index <= 1)
                                <div class="col-sm-12 col-md-6 mb-4">
                                    <!-- Post Article -->
                                    <div class="card__post ">
                                        <div class="card__post__body card__post__transition">
                                            <a href="{{ route('news-details', $news->slug) }}">
                                                <img src="{{ asset($news->image) }}" class="img-fluid" alt="">
                                            </a>
                                            <div class="card__post__content bg__post-cover">
                                                <div class="card__post__category">
                                                    {{ $news->category->name }}
                                                </div>
                                                <div class="card__post__title">
                                                    <h5>
                                                        <a href="{{ route('news-details', $news->slug) }}">
                                                            {!! truncateStr($news->title, 100) !!}
                                                        </a>
                                                    </h5>
                                                </div>
                                                <div class="card__post__author-info">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <a href="javascript:;">
                                                                {{ __('frontend.By') }} {{ $news->author->name }}
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                        <span>
                                                            {{ date('d M, Y', strtotime($news->created_at)) }}
                                                        </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row ">
                        <div class="col-sm-12 col-md-6">
                            <div class="wrapp__list__article-responsive">
                                @foreach($recentNews as $news)
                                    @if($loop->index > 1 && $loop->index <= 3)
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
                                                                    {{ date('d M, Y', strtotime($news->created_at)) }}
                                                                </span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <div class="card__post__title">
                                                            <h6>
                                                                <a href="{{ route('news-details', $news->slug) }}">
                                                                    {!! truncateStr($news->title, 100) !!}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 ">
                            <div class="wrapp__list__article-responsive">
                                @foreach($recentNews as $news)
                                    @if($loop->index > 3 && $loop->index <= 5)
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
                                                                    {{ date('d M, Y', strtotime($news->created_at)) }}
                                                                </span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <div class="card__post__title">
                                                            <h6>
                                                                <a href="{{ route('news-details', $news->slug) }}">
                                                                    {!! truncateStr($news->title, 100) !!}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 col-lg-4">
                    <aside class="wrapper__list__article">
                        <h4 class="border_section">{{ __('frontend.popular post') }}</h4>
                        <div class="wrapper__list-number">
                            <!-- List Article -->
                            @foreach($popularNews as $key => $news)
                                <div class="card__post__list">
                                    <div class="list-number">
                                        <span>
                                            {{ ++$key }}
                                        </span>
                                    </div>
                                    <a href="javascript:;" class="category">
                                        {{ $news->category->name }}
                                    </a>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <h5>
                                                <a href="{{ route('news-details', $news->slug) }}">
                                                    {!! truncateStr($news->title) !!}
                                                </a>
                                            </h5>
                                        </li>
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>

    <!-- Post news carousel -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <aside class="wrapper__list__article">
                    <h4 class="border_section">{{ @$categorySectionOne->first()->category->name }}</h4>
                </aside>
            </div>
            <div class="col-md-12">

                <div class="article__entry-carousel">
                    @foreach($categorySectionOne as $news)
                        <div class="item">
                            <!-- Post Article -->
                            <div class="article__entry">
                                <div class="article__image">
                                    <a href="{{ route('news-details', $news->slug) }}">
                                        <img src="{{ asset($news->image) }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                                <div class="article__content">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <span class="text-primary">
                                                {{ __('frontend.By') }} {{ $news->author->name }}
                                            </span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span>
                                                {{ date('d M, Y', strtotime($news->created_at)) }}
                                            </span>
                                        </li>

                                    </ul>
                                    <h5>
                                        <a href="{{ route('news-details', $news->slug) }}">
                                            {!! truncateStr($news->title) !!}
                                        </a>
                                    </h5>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <aside class="wrapper__list__article">
                    <h4 class="border_section">{{ @$categorySectionTwo->first()->category->name }}</h4>
                </aside>
            </div>
            <div class="col-md-12">

                <div class="article__entry-carousel">
                    @foreach($categorySectionTwo as $news)
                        <div class="item">
                            <!-- Post Article -->
                            <div class="article__entry">
                                <div class="article__image">
                                    <a href="{{ route('news-details', $news->slug) }}">
                                        <img src="{{ asset($news->image) }}" alt="" class="img-fluid">
                                    </a>
                                </div>
                                <div class="article__content">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <span class="text-primary">
                                                {{ __('frontend.By') }} {{ $news->author->name }}
                                            </span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span>
                                                {{ date('d M, Y', strtotime($news->created_at)) }}
                                            </span>
                                        </li>

                                    </ul>
                                    <h5>
                                        <a href="{{ route('news-details', $news->slug) }}">
                                            {!! truncateStr($news->title) !!}
                                        </a>
                                    </h5>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- End Popular news category -->


    <!-- Popular news category -->
    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <aside class="wrapper__list__article mb-0">
                        <h4 class="border_section">{{ @$categorySectionThree->first()->category->name }}</h4>
                        <div class="row">
                            @foreach($categorySectionThree as $news)
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <!-- Post Article -->
                                        <div class="article__entry">
                                            <div class="article__image">
                                                <a href="{{ route('news-details', $news->slug) }}">
                                                    <img src="{{ asset($news->image) }}" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="article__content">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <span class="text-primary">
                                                            {{ __('frontend.By') }} {{ $news->author->name }}
                                                        </span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span>
                                                            {{ date('d M, Y', strtotime($news->created_at)) }}
                                                        </span>
                                                    </li>

                                                </ul>
                                                <h5>
                                                    <a href="{{ route('news-details', $news->slug) }}">
                                                        {!! truncateStr($news->title) !!}
                                                    </a>
                                                </h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </aside>

                    @if(!empty($ad->home_middle_ad_status) && $ad->home_middle_ad_status === 1)
                        <a href="{{ $ad->home_middle_ad_url }}">
                            <div class="small_add_banner">
                                <div class="small_add_banner_img">
                                    <img src="{{ asset($ad->home_middle_ad)}}" alt="adds">
                                </div>
                            </div>
                        </a>
                    @endif

                    <aside class="wrapper__list__article mt-5">
                        <h4 class="border_section">{{ @$categorySectionFour->first()->category->name }}</h4>

                        <div class="wrapp__list__article-responsive">
                            <!-- Post Article List -->
                            @foreach($categorySectionFour as $news)
                                <div class="card__post card__post-list card__post__transition mt-30">
                                    <div class="row ">
                                        <div class="col-md-5">
                                            <div class="card__post__transition">
                                                <a href="{{ route('news-details', $news->slug) }}">
                                                    <img src="{{ asset($news->image) }}" class="img-fluid w-100" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-7 my-auto pl-0">
                                            <div class="card__post__body ">
                                                <div class="card__post__content  ">
                                                    <div class="card__post__category ">
                                                        {{ $news->category->name }}
                                                    </div>
                                                    <div class="card__post__author-info mb-2">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                                <span class="text-primary">
                                                                    {{ __('frontend.By') }} {{ $news->author->name }}
                                                                </span>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <span class="text-dark text-capitalize">
                                                                    {{ date('d M, Y', strtotime($news->created_at)) }}
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="card__post__title">
                                                        <h5>
                                                            <a href="{{ route('news-details', $news->slug) }}">
                                                                {!! truncateStr($news->title) !!}
                                                            </a>
                                                        </h5>
                                                        <p class="d-none d-lg-block d-xl-block mb-0">
                                                            {!! truncateStr($news->content, 100) !!}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </aside>
                </div>

                <div class="col-md-4">
                    <div class="sticky-top">
                        <aside class="wrapper__list__article">
                            <h4 class="border_section">{{ __('frontend.Most Viewed') }}</h4>
                            <div class="wrapper__list__article-small">

                                <!-- Post Article -->
                                @foreach($mostViewedNews as $news)
                                    @if($loop->index === 0)
                                        <div class="article__entry">
                                            <div class="article__image">
                                                <a href="{{ route('news-details', $news->slug) }}">
                                                    <img src="{{ asset($news->image) }}" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="article__content">
                                                <div class="article__category">
                                                    {{ $news->category->name }}
                                                </div>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                    <span class="text-primary">
                                                        {{ __('frontend.By') }} {{ $news->author->name }}
                                                    </span>
                                                    </li>
                                                    <li class="list-inline-item">
                                                    <span class="text-dark text-capitalize">
                                                        {{ date('d M, Y', strtotime($news->created_at)) }}
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
                                                <a href="{{ route('news-details', $news->slug) }}" class="btn btn-outline-primary mb-4 text-capitalize"> read
                                                    more
                                                </a>
                                            </div>
                                        </div>
                                    @else
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
                                                                    {{ date('d M, Y', strtotime($news->created_at)) }}
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
                                    @endif

                                @endforeach
                            </div>
                        </aside>

                        <aside class="wrapper__list__article">
                            <h4 class="border_section">{{ __('frontend.Stay connected') }}</h4>
                            <!-- widget Social media -->
                            <div class="wrap__social__media">
                                @foreach($socialCounts as $socialCount)
                                    <a href="{{ $socialCount->url }}" target="_blank">
                                        <div class="social__media__widget mt-2" style="background-color: {{ $socialCount->color }}">
                                            <span class="social__media__widget-icon">
                                                <i class="{{ $socialCount->icon }}"></i>
                                            </span>
                                            <span class="social__media__widget-counter">
                                                {{ $socialCount->fan_count }} {{ $socialCount->fan_type }}
                                            </span>
                                            <span class="social__media__widget-name">
                                                {{ $socialCount->button_text }}
                                            </span>
                                        </div>
                                    </a>
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

                        @if(!empty($ad->side_bar_ad_status) && $ad->side_bar_ad_status === 1)
                            <aside class="wrapper__list__article">
                                <h4 class="border_section">{{ __('frontend.Advertise') }}</h4>
                                <a href="{{ $ad->side_bar_ad_url }}">
                                    <figure>
                                        <img src="{{ asset($ad->side_bar_ad) }}" alt="adds" class="img-fluid">
                                    </figure>
                                </a>
                            </aside>
                        @endif

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
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
