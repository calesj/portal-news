<div class="card border border-primary">
    <div class="card-body">
        <form action="{{ route('admin.microsoft-api-setting.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{ __('admin.Api Microsoft Host') }}</label>
                <div class="input-group">
                    <input type="text" name="site_microsoft_api_host"  class="form-control" value="{{ $settings['site_microsoft_api_host'] }}">
                </div>
                @error('site_microsoft_api_host')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>{{ __('admin.Microsoft Api Key') }}</label>
                <div class="input-group">
                    <input type="text" name="site_microsoft_api_key"  class="form-control" value="{{ $settings['site_microsoft_api_key'] }}">
                </div>
                @error('site_microsoft_api_key')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>
