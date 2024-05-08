@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h4> {{ __('Social Links') }}</h4>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4> {{ __('All Links') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.social-link.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"> {{ __('Create New') }} </i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th>{{ __('Icon') }}</th>
                            <th>{{ __('Url') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($socialLinks as $socialLink)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td><i style="font-size: 30px" class="{{ $socialLink->icon }}"></i></td>
                                <td>{{ $socialLink->url }}</td>
                                <td>
                                    @if($socialLink->status === 1)
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
                                    <a href="{{ route('admin.social-link.edit', $socialLink->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.social-link.destroy', $socialLink->id) }}"
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

        $("#table-sub").dataTable({
            "columnDefs": [
                {
                    "sortable": false,
                    "targets": [1]
                }
            ]
        });

    </script>
@endpush
