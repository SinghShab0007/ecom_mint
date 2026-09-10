@extends('backend.layouts.app')
@section('title','Installed Addon - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
        <div class="container">
            @include('backend.pages.addons.nav')
            <!-- Tab Manu End -->
        </div>
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="installed-addon" aria-labelledby="installed-addon-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="s-category">

                            </div>
                        </div>
                        <div class="col-lg-3 offset-lg-6">

                        </div>
                    </div>
                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Image')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Version')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($addons as $key=>$addon)
                                <tr>
                                    <td>
                                            <img src="{{URL::to('uploads/addons/'.$addon->image_300x300)}}"
                                                 alt="promo">
                                    </td>
                                    <td>{{$addon->addon_title??''}}</td>
                                    <td>{{$addon->addon_version??''}}</td>
                                    <td>
                                        <div class="form-switch">
                                            <input class="form-check-input status" @if($addon->is_active)checked
                                                   @endif data-id="{{$addon->id}}" type="checkbox">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>
@endsection

@push('js')
    <!--Data Tables js-->
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/jquery-3.5.1.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/jszip.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('backend/assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js')}}"></script>
    <script>
        $(function () {

            "use strict";
            var table = $('#mDataTable').DataTable();
            table.buttons().destroy();
            table.order([[1,'asc']]);

            $(document).on('click', '#mDataTable .status', function () {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path + '/admin/addon/changeStatus',
                    data: {'status': status, 'id': id, 'field': 'is_active'},
                    success: function (data) {
                        notification('success', data.message);
                        window.location.reload();
                    }
                });
            });
        });
    </script>
@endpush
