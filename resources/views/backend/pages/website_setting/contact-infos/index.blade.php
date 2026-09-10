@extends('backend.layouts.app')
@section('title', 'Contact Infos List - ')
@section('content')
<div class="content-body">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="brand" role="tabpanel" aria-labelledby="brand-tab">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col">
                        <h5 class="py-2">@lang('Contact Infos List')</h5>
                    </div>
                    <div class="col-md-4 text-end align-self-center mt-2">
                        <a href="javascript:void(0)" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#contact-create-modal"><i class="fas fa-plus-circle"></i> @lang('Add new')</a>
                    </div>
                </div>
                <div class="responsibe-table">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('#')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Number')</th>
                                <th>@lang('Created At')</th>
                                <th>@lang('Updated At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($infos as $info)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $info->value['title'] ?? '' }}</td>
                                <td>{{ $info->value['number'] ?? '' }}</td>
                                <td>{{ date('d-m-Y H:i A', strtotime($info->created_at)) }}</td>
                                <td>{{ date('d-m-Y H:i A', strtotime($info->updated_at)) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" data-url="{{ route('backend.contact-infos.update', $info->id) }}" data-title="{{ $info->value['title'] ?? '' }}" data-number="{{ $info->value['number'] ?? '' }}" class="btn text-warning btn-sm edit-commission"><i class="fas fa-edit"></i></a>
                                        <a class="action-confirm btn text-danger btn-sm" data-type="DELETE" data-action="{{ route('backend.contact-infos.destroy', $info->id) }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        {{ $infos->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab Content End -->
</div>
@endsection

@push('modal')
<div class="modal fade" id="contact-create-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="ajaxform_instant_reload" action="{{ route('backend.contact-infos.store') }}" method="post">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create contact info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="col-form-label">Contact Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="number">{{ __('Contact Number') }}</label>
                        <input type="text" class="form-control" name="number" id="number" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning submit-btn"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="contact-edit-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="contact-edit-form ajaxform_instant_reload" action="" method="post">
                @csrf
                @method('put')

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update commission rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="col-form-label">Contact Title</label>
                        <input type="text" class="form-control title" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="number">{{ __('Contact Number') }}</label>
                        <input type="text" class="form-control number" name="number" id="number" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning submit-btn"><i class="fas fa-save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('js')
    <script>
        $('.edit-commission').on('click', function() {
            let url = $(this).data('url');
            let title = $(this).data('title');
            let number = $(this).data('number');
            $('.title').val(title);
            $('.number').val(number);
            $('.contact-edit-form').attr('action', url);
            $('#contact-edit-modal').modal('show');
        })
    </script>
@endpush
