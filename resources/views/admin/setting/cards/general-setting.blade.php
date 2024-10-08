<div class="card border border-primary">
    <div class="card-body">
        <form action="{{ route('admin.general-setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{ __('Site Name') }}</label>
                <input type="text" name="site_name" class="form-control" value="{{ @$settings['site_name'] }}">
                @error('site_name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <img src="{{ asset(@$settings['site_logo']) }}" alt="">
            <div class="form-group">
                <label>{{ __('Site Logo') }}</label>
                <input type="file" name="site_logo" class="form-control">
                @error('site_logo')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <img src="{{ asset(@$settings['site_favicon']) }}" alt="">
            <div class="form-group">
                <label>{{ __('Site Favicon') }}</label>
                <input type="file" name="site_favicon" class="form-control">
                @error('site_favicon')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>
