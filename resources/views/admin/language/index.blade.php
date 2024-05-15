@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1> {{__('Languages')}} </h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4> {{ __('All Languages') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.language.create') }}" class="btn btn-primary">
                      <i class="fas fa-plus"> {{ __('Create New') }} </i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th>{{ __('Language Name') }}</th>
                            <th>{{ __('Language Code') }}</th>
                            <th>{{ __('Default') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($languages as $language)
                            <tr>
                                <td>
                                    {{ $language->id }}
                                </td>
                                <td>{{ $language->name }}</td>
                                <td>{{ $language->lang }}</td>
                                <td>
                                    @if($language->default == 1)
                                        <div class="badge badge-primary">
                                            {{ __('Default') }}
                                        </div>
                                    @else
                                        <div class="badge badge-warning">
                                            {{ __('No') }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($language->status == 1)
                                        <div class="badge badge-success">
                                            {{ __('Active') }}
                                        </div>
                                    @else
                                        <div class="badge badge-danger">
                                            {{ __('Inactive') }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.language.edit', $language->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.language.destroy', $language->id) }}"
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

    </section>

@endsection

@push('scripts')
    <script>
        $("#table-1").dataTable({
            "columnDefs": [
                { "sortable": false, "targets": [2,3] }
            ]
        });
    </script>
@endpush
