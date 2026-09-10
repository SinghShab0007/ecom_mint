@extends('backend.layouts.app')
@section('title','Commissions List - ')
@section('content')
<div class="content-body">
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="brand" role="tabpanel" aria-labelledby="brand-tab">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col">
                        <h5 class="py-2">@lang('Commissions List')</h5>
                    </div>
                    <div class="col-md-4 text-end align-self-center mt-2">
                        <form action="" method="get">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search..." aria-describedby="basic-addon2">
                                <button class="input-group-text btn btn-warning" id="basic-addon2"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="responsibe-table">
                    <table class="table p-table">
                        <thead>
                            <tr>
                                <th>@lang('#')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Commission Rate')</th>
                                <th>@lang('Created At')</th>
                                <th>@lang('Updated At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($commissions as $commission)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $commission->name }}</td>
                                <td>{{ $commission->commission_rate }}%</td>
                                <td>{{ date('d-m-Y H:i A', strtotime($commission->created_at)) }}</td>
                                <td>{{ date('d-m-Y H:i A', strtotime($commission->updated_at)) }}</td>
                                <td>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" data-url="{{ route('backend.commissions.update', $commission->id) }}" data-rate="{{ $commission->commission_rate }}" data-category="{{ $commission->name }}" class="action edit-commission"><button><i class="fas fa-edit"></i></button></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-12 text-center mt-4">
                        {{ $commissions->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab Content End -->
</div>

<div class="modal fade" id="commission-edit-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="commission-edit-form ajaxform_instant_reload" action="" method="post">
                @csrf
                @method('put')

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update commission rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Category Name</label>
                        <input type="text" class="form-control category" id="recipient-name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="">{{ __('Commission Rate') }}</label>
                        <div class="input-group mb-3">
                            <input type="number" step="0.1" class="form-control rate" name="rate" placeholder="Commission Rate" aria-describedby="basic-addon2">
                            <span class="input-group-text btn btn-warning" id="basic-addon2">%</span>
                        </div>
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
@endsection

@push('js')
    <script>
        $('.edit-commission').on('click', function() {
            let url = $(this).data('url');
            let rate = $(this).data('rate');
            let category = $(this).data('category');
            $('.rate').val(rate);
            $('.category').val(category);
            $('.commission-edit-form').attr('action', url);
            $('#commission-edit-modal').modal('show');
        })
    </script>
@endpush
