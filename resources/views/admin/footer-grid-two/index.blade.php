@extends('admin.layouts.master')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1> {{__('Footer')}} </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4> {{ __('All footer grid two links') }}</h4>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    @foreach($languages as $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->index === 0 ? 'active' : '' }}"
                               id="home-tab2" data-toggle="tab" href="#home-{{ $language->lang }}" role="tab"
                               aria-controls="home" aria-selected="true">{{ $language->name }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content tab-bordered" id="myTab3Content">
                    @foreach($languages as $language)
                        @php
                            $footerTitle = \App\Models\FooterTitle::where(['language' => $language->lang, 'key' => 'grid_two_title'])
                            ->first()
                        @endphp
                        <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                             id="home-{{ $language->lang }}" role="tabpanel" aria-labelledby="home-tab2">
                            <div class="card-body">
                                <form action="{{ route('admin.footer-grid-two.title') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">{{ __('Footer Title') }}</label>
                                        <input type="text" class="form-control" name="title" value="{{ @$footerTitle->value }}">
                                        <input type="hidden" value="{{ $language->lang }}"  class="form-control" name="language">
                                    </div>
                                    <div class="div-form-group"></div>
                                    <button type="submit" class="btn btn-primary"> {{ __('Save') }}</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4> {{ __('All footer grid two links') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.footer-grid-two.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"> {{ __('Create New') }} </i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    @foreach($languages as $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->index === 0 ? 'active' : '' }}"
                               id="home-tab2" data-toggle="tab" href="#home-{{ $language->lang }}" role="tab"
                               aria-controls="home" aria-selected="true">{{ $language->name }}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content tab-bordered" id="myTab3Content">
                    @foreach($languages as $language)
                        @php
                            $footerGridTwo = \App\Models\FooterGridTwo::where('language', $language->lang)
                            ->orderByDesc('id')->get()
                        @endphp
                        <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                             id="home-{{ $language->lang }}" role="tabpanel" aria-labelledby="home-tab2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-{{ $language->lang }}">
                                        <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Language') }}</th>
                                            <th>{{ __('Url') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($footerGridTwo as $footer)
                                            <tr>
                                                <td> {{ $footer->id }}</td>
                                                <td> {{ $footer->name }}</td>
                                                <td> {{ $footer->language }}</td>
                                                <td> {{ $footer->url }}</td>

                                                <td>
                                                    @if($footer->status === '1')
                                                        <span class="badge badge-success">
                                                                {{ __('Yes') }}
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                                {{ __('No') }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('admin.footer-grid-two.edit', $footer->id) }}" class="btn btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.footer-grid-two.destroy', $footer->id) }}"
                                                       class="btn btn-danger delete-item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        @foreach($languages as $language)
        $("#table-{{ $language->lang }}").dataTable({
            "columnDefs": [
                {"sortable": false, "targets": [2, 3]}
            ]
        });
        @endforeach
    </script>
@endpush
