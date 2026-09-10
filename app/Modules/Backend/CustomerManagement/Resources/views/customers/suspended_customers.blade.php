@extends('backend.layouts.app')
@section('title','Suspended Customer - ')
@push('css')
    @include('backend.includes.datatable_css')
@endpush
@section('content')
    <div class="content-body">
    @include('customermanagement::nav')
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="suspended-customers" aria-labelledby="suspended-customers-tab">
                <div class="container">

                    <div class="content-table mt-0">
                        <table id="mDataTable" class="table p-table">
                            <thead>
                            <tr>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Phone Number')}}</th>
                                <th scope="col">{{__('Gender')}}</th>
                                <th scope="col">{{__('Suspended')}}</th>
                                <th scope="col">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
        <!-- modal content -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{__('New message')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="messageForm">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">{{__('Subject')}}:</label>
                                <input name="subject" class="form-control" type="text" required>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">{{__('Message')}}:</label>
                                <textarea name="message" rows="3" class="form-control" required id="message-text"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                            <button type="submit" class="btn btn-primary">{{__('Send message')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('backend.includes.datatable_js')
    <script>

        $(function () {
            "use strict";

            $(document).ready(function(){
                // DataTable
                var table = $('#mDataTable');
                table.DataTable({
                    ajax: "{{route('backend.suspended_customer.list')}}",
                    columns: [
                        { data: 'last_name' },
                        { data: 'email'},
                        { data: 'mobile' },
                        { data: 'gender' },
                        { data: 'is_suspended' },
                        { data: 'action',searchable:false,sortable:false },
                    ]
                });

            });


            $(document).on('click','#mDataTable .suspend', function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: public_path +'/admin/customer/changeStatus',
                    data: {'status': status, 'id': id,'field': 'is_suspended'},
                    success: function(data){
                        notification('success', data.message);
                    }
                });
            });

            var mailModal = document.getElementById('exampleModal')
            mailModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget
                //  initiate an AJAX request
                let form = document.getElementById('messageForm');
                // Extract info from data-bs-* attributes
                var recipient = button.getAttribute('data-bs-recipient')
                var recipient_name = button.getAttribute('data-bs-recipient_name')

                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    var message = form.querySelector('.modal-body textarea').value;
                    var subject = form.querySelector('.modal-body input').value;
                    $.ajax({
                        type: "get",
                        dataType: "json",
                        url: public_path + '/admin/customer/sendMail',
                        data: {'subject':subject,'name': recipient_name, 'email': recipient, 'message': message},
                        success: function (data) {
                            $('#exampleModal').modal('hide');
                            notification('success', data.message);
                        }
                    });
                });
            })
        });
    </script>
@endpush
