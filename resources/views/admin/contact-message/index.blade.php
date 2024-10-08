@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h4> {{ __('Contact Message') }} </h4>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4> {{ __('All messages') }}</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-sub">
                        <thead>
                        <tr>
                            <th class="text-center">
                                #
                            </th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('Message') }}</th>
                            <th>{{ __('Replied') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>{{ ++$loop->index }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->subject }}</td>
                                <td>{{ $message->message }}</td>

                                <td>
                                    @if($message->replied == 1)
                                        <i style="font-size: 20px" class="fas fa-check text-success"></i>
                                    @else
                                        <i style="font-size: 20px" class="fas fa-clock text-warning"></i>
                                    @endif
                                </td>
                                {{--                                <td>--}}
                                {{--                                    @if($socialLink->status === 1)--}}
                                {{--                                        <span class="badge badge-success">--}}
                                {{--                                         {{ __('Yes') }}--}}
                                {{--                                        </span>--}}
                                {{--                                    @else--}}
                                {{--                                        <span class="badge badge-danger">--}}
                                {{--                                           {{ __('No') }}--}}
                                {{--                                        </span>--}}
                                {{--                                    @endif--}}
                                {{--                                </td>--}}
                                <td>
                                    <a href="" class="btn btn-primary" data-toggle="modal"
                                       data-target="#exampleModal-{{ $message->id }}">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                    <a href="{{ route('admin.social-link.destroy', $message->id) }}"
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

    @foreach($messages as $message)
        <!-- Modal -->
        <div class="modal fade" id="exampleModal-{{ $message->id }}" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Reply To:') }} {{ $message->email }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.contact-message.send-reply') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">{{ __('Subject') }}</label>
                                <input type="text" name="subject" class="form-control">
                                <input type="hidden" name="email" value="{{ $message->email }}" class="form-control">
                                <input type="hidden" name="message_id" value="{{ $message->id }}" class="form-control">
                                @error('subject')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <label for="">{{ __('Message') }}</label>
                            <textarea name="message" class="form-control" style="height: 200px !important;"></textarea>
                            @error('message')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script>

        $("#table-sub").dataTable({
            "columnDefs": [
                {
                    "sortable": false,
                    "targets": [1]
                }
            ],
            "order": [[0, "desc"]]
        });

    </script>
@endpush
