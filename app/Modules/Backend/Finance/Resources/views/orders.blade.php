@extends('layouts.seller')

@section('title','Sale List - ')

@push('css')
    @include('backend.includes.datatable_css')
@endpush

@section('content')

    <!-- Content Body Start -->
    <div class="content-body">
        <div class="container">
            <div class="profile-section-wrapper">
                <div class="profile-title">
                    <h3>Sale List</h3>
                </div>
                <div class="account-starement-subtitle">
                    <div class="left-side">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <div class="right-side">
                        <a href="#newsale-modal" class="btn maan-submit-btn text-white" data-bs-toggle="modal">New Sale</a>
                    </div>
                </div>
                <div class="user-manage-table table-sm-responsive">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Invoice</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>Mobile</th>
                            <th>Total</th>
                            <th>Pay Amount</th>
                            <th>Deu Amount</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->invoice }}</td>
                                <td>{{ $sale->created_at }}</td>
                                <td>{{ $sale->name }}</td>
                                <td>{{ $sale->mobile }}</td>
                                <td>{{ $sale->total }}</td>
                                <td>{{ $sale->paid }}</td>
                                <td>{{ $sale->due }}</td>
                                <td>
                                    <div class="button-group">
                                        <form action="{{ route('seller.sale.destroy',$sale->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <a href="#edit-modal" data-bs-toggle="modal" onclick="edit({{$sale->id}})">
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     width="494.936px" height="494.936px" viewBox="0 0 494.936 494.936" style="enable-background:new 0 0 494.936 494.936;"
                                                     xml:space="preserve">
                                                    <g>
                                                        <g>
                                                            <path d="M389.844,182.85c-6.743,0-12.21,5.467-12.21,12.21v222.968c0,23.562-19.174,42.735-42.736,42.735H67.157
                                                                c-23.562,0-42.736-19.174-42.736-42.735V150.285c0-23.562,19.174-42.735,42.736-42.735h267.741c6.743,0,12.21-5.467,12.21-12.21
                                                                s-5.467-12.21-12.21-12.21H67.157C30.126,83.13,0,113.255,0,150.285v267.743c0,37.029,30.126,67.155,67.157,67.155h267.741
                                                                c37.03,0,67.156-30.126,67.156-67.155V195.061C402.054,188.318,396.587,182.85,389.844,182.85z"/>
                                                            <path d="M483.876,20.791c-14.72-14.72-38.669-14.714-53.377,0L221.352,229.944c-0.28,0.28-3.434,3.559-4.251,5.396l-28.963,65.069
                                                                c-2.057,4.619-1.056,10.027,2.521,13.6c2.337,2.336,5.461,3.576,8.639,3.576c1.675,0,3.362-0.346,4.96-1.057l65.07-28.963
                                                                c1.83-0.815,5.114-3.97,5.396-4.25L483.876,74.169c7.131-7.131,11.06-16.61,11.06-26.692
                                                                C494.936,37.396,491.007,27.915,483.876,20.791z M466.61,56.897L257.457,266.05c-0.035,0.036-0.055,0.078-0.089,0.107
                                                                l-33.989,15.131L238.51,247.3c0.03-0.036,0.071-0.055,0.107-0.09L447.765,38.058c5.038-5.039,13.819-5.033,18.846,0.005
                                                                c2.518,2.51,3.905,5.855,3.905,9.414C470.516,51.036,469.127,54.38,466.61,56.897z"/>
                                                        </g>
                                                    </g>
                                                    </svg>
                                            </a>
                                            <a href="" onclick="deleteWithSweetAlert(event,parentNode)">
                                                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px">    <path d="M 14.984375 2.4863281 A 1.0001 1.0001 0 0 0 14 3.5 L 14 4 L 8.5 4 A 1.0001 1.0001 0 0 0 7.4863281 5 L 6 5 A 1.0001 1.0001 0 1 0 6 7 L 24 7 A 1.0001 1.0001 0 1 0 24 5 L 22.513672 5 A 1.0001 1.0001 0 0 0 21.5 4 L 16 4 L 16 3.5 A 1.0001 1.0001 0 0 0 14.984375 2.4863281 z M 6 9 L 7.7929688 24.234375 C 7.9109687 25.241375 8.7633438 26 9.7773438 26 L 20.222656 26 C 21.236656 26 22.088031 25.241375 22.207031 24.234375 L 24 9 L 6 9 z"/></svg>
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if($sales->hasPages())
                        <nav class="new-pagination">
                            <ul class="pagination">
                                @if($sales->onFirstPage())
                                    <li class="page-item active"><a class="page-link">{{ __('Previous') }}</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $sales->previousPageUrl() }}">{{ __('Previous') }}</a></li>
                                @endif
                                @foreach($sales->getUrlRange($sales->firstItem(),$sales->lastItem()) as $key => $url)
                                    @if($sales->currentPage() == $key)
                                        <li class="page-item active"><a class="page-link">{{ $key }}</a></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $key }}</a></li>
                                    @endif
                                @endforeach
                                @if($sales->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $sales->nextPageUrl() }}">{{ __('Next') }}</a></li>
                                @else
                                    <li class="page-item active"><a class="page-link">{{ __('Next') }}</a></li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Content Body End -->

    <!-- new sale modal -->
    <div class="modal fade" id="newsale-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('New Sale') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('seller.sale.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 my-2">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Name">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="total">{{ __('Total Amount') }}</label>
                                <input type="number" name="total" id="total" class="form-control" placeholder="Total Amount">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="invoice">{{ __('Invoice') }}</label>
                                <input type="text" name="invoice" class="form-control" placeholder="Invoice">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="pay">{{ __('Pay Amount') }}</label>
                                <input type="number" name="paid" id="paid" class="form-control" placeholder="Pay Amount">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="mobile">{{ __('Mobile') }}</label>
                                <input type="number" name="mobile" class="form-control" placeholder="Phone number">
                            </div>
                            <div class="col-lg-6 my-2">
                                <label for="deu">{{ __('Due Amount') }}</label>
                                <input type="number" name="due" id="due" class="form-control" placeholder="Deu Amount" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="submit" class="btn maan-submit-btn">{{ __('Save Now') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sale Edit Modal -->
    <div class="modal fade" id="edit-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('Edit Sale') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">

                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script>
        function edit(id)
        {
            var csrf = "{{ csrf_token() }}";
            $.ajax({
                url : "{{ route('seller.sale.edit') }}",
                data: {_token:csrf,id:id},
                type: "POST"
            }).done(function(e){
                $("#modal-body").html(e);

                $("#edit-total").on('input',function(){
                    var total = $(this).val();
                    var paid = $("#edit-paid").val();
                    var due = total - paid;
                    $("#edit-due").val(due);
                })

                $("#edit-paid").on('input',function(){
                    var total = $("#edit-total").val();
                    var paid = $(this).val();
                    var due = total - paid;
                    $("#edit-due").val(due);
                })
            })
        }
    </script>
    <script>
        $("#total").on('input',function(){
            var total = $(this).val();
            var paid = $("#paid").val();
            var due = total - paid;
            $("#due").val(due);
        })

        $("#paid").on('input',function(){
            var total = $("#total").val();
            var paid = $(this).val();
            var due = total - paid;
            $("#due").val(due);
        })
    </script>
@endpush
