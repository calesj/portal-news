 @extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('News')}} </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create News') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.news.update', $news->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="">{{ __('Language')}}</label>
                        <select name="language" id="language-select" class="form-control select2">
                            <option value="">--{{ __('Select') }}--</option>
                            @foreach($languages as $lang)
                                <option
                                    {{ $lang->lang === $news->language ? 'selected' : '' }} value="{{ $lang->lang }}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                        @error('language')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">{{ __('Category')}}</label>
                        <select name="category" id="category" class="form-control">
                            <option value=""> {{ __('Select') }}</option>
                            @foreach($categories as $category)
                                <option
                                    {{ $category->id === $news->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            <option value=""></option>
                        </select>
                        @error('category')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Image') }}</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">{{ __('Choose File') }}</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                        @error('image')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Title') }}</label>
                        <input type="text" name="title" value="{{ $news->title }}" class="form-control">
                        @error('title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Content') }}</label>
                        <textarea name="content" class="summernote-simple">{{ $news->content }}</textarea>
                        @error('content')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tags"> {{ __('Tags') }} </label>
                        <input name="tags" type="text" value="{{ formatTags($news->tags()->pluck('name')->toArray()) }}"
                               class="form-control inputtags">
                        @error('tags')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Meta Title') }}</label>
                        <input value="{{ $news->meta_title }}" type="text" name="meta_title" class="form-control">
                        @error('meta_title')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Meta Description') }}</label>
                        <textarea name="meta_description" class="form-control">{{ $news->meta_description }}</textarea>
                        @error('meta_description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="control-label">{{ __('Status') }}</div>
                                <label class="custom-switch mt-2">
                                    <input {{ $news->status === 1 ? 'checked' : '' }} value="1" type="checkbox"
                                           name="status" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        @if(canAccess(['news status', 'news all-access']))
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="control-label">{{ __('Is Breaking News') }}</div>
                                    <label class="custom-switch mt-2">
                                        <input {{ $news->is_breaking_news === 1 ? 'checked' : '' }} value="1"
                                               type="checkbox" name="is_breaking_news"
                                               class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="control-label">{{ __('Show At Slider') }}</div>
                                    <label class="custom-switch mt-2">
                                        <input {{ $news->show_at_slider === 1 ? 'checked' : '' }} value="1" type="checkbox"
                                               name="show_at_slider" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>

                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="control-label">{{ __('Show At Popular') }}</div>
                                    <label class="custom-switch mt-2">
                                        <input {{ $news->show_at_popular === 1 ? 'checked' : '' }} type="checkbox"
                                               name="show_at_popular" value="1" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </div>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Update')}}</button>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.image-preview').css({
                "background-image": "url({{ asset($news->image) }})",
                "background-size": "cover",
                "background-position": "center center"
            })

            $('#language-select').on('change', function () {
                let lang = $(this).val()
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.fetch-news-category') }}",
                    data: {lang: lang},
                    success: function (data) {
                        $('#category').html("");
                        $('#category').html("<option value=''>{{ __('---Select---') }}</option>");

                        $.each(data, function (index, data) {
                            $('#category').append(`<option value='${data.id}'> ${data.name} </option>`);
                        })

                    },
                    error: function (error) {
                        console.log(error)
                    }
                })
            })
        })
    </script>
@endpush
