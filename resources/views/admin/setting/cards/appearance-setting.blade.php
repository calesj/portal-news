<div class="card border border-primary">
    <div class="card-body">
        <form action="{{ route('admin.general-appearence.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Pick Your Color</label>
                <div class="input-group colorpickerinput">
                    <input type="text" name="site_color"  class="form-control" value="{{ @$settings['site_color'] }}">
                    <div class="input-group-append">
                        <div style="cursor: pointer" class="input-group-text">
                            <i class="fas fa-fill-drip"></i>
                        </div>
                    </div>
                </div>
                @error('site_color')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        $(".colorpickerinput").colorpicker({
            format: 'hex',
            component: '.input-group-append',
        });
    </script>
@endpush
