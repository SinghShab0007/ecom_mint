@extends('backend.layouts.app')
@section('title','Seller Show - ')
@section('content')

    <!-- Content Body Start -->
    <div class="content-body">
        <div class="container">
            <div class="profile-section-wrapper">
                <div class="content-tab-title">
                    <h4>{{ __('Seller earnings') }}</h4>
                </div>
                <div class="user-manage-table table-sm-responsive">
                    <table class="table table-sm p-table" id="mDataTable">
                        <thead>
                            <tr>
                                <th>{{ __('Sl') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Seller') }}</th>
                                <th>{{ __('Pay') }}</th>
                                <th>{{ __('Requested') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sellerWithdrawRequesr as $sellerRequest)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sellerRequest->created_at }}</td>
                                <td>{{ $sellerRequest->sellers->first_name }} {{ $sellerRequest->sellers->last_name }}</td>
                                <td>{{ number_format(array_sum(array_column(\App\Http\Controllers\Backend\WalletController::sellerEarningTotal($sellerRequest->seller_id), 'payout_amount')) -(\App\Http\Controllers\Backend\WalletController::sellerExistWithdrawTotal($sellerRequest->seller_id)),2) }}</td>
                                <td>{{ number_format($sellerRequest->amount,2) }}</td>
                                <td>
                                    <p class="msg-discription">{{ $sellerRequest->note }}	</p>
                                </td>
                                <td><span class="status-btn pending-btn">{{ $sellerRequest->withdraw_status }}</span></td>
                                <td>
                                    <div class="table-button-wrapper">
                                        <a href="#seller-massage" class="widthrow-btn action-btn" id="withdraw-btn_{{$sellerRequest->id}}" data-bs-toggle="modal" data-bank-name="{{$sellerRequest->bank_name}}" data-account-holder="{{$sellerRequest->account_holder}}" data-bank-account="{{$sellerRequest->account}}" data-routing-number="{{$sellerRequest->routing_number}}" data-payable-total="{{ number_format(array_sum(array_column(\App\Http\Controllers\Backend\WalletController::sellerEarningTotal($sellerRequest->seller_id), 'payout_amount')) -(\App\Http\Controllers\Backend\WalletController::sellerExistWithdrawTotal($sellerRequest->seller_id)),2) }}">

                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 122.88 83.78" style="enable-background:new 0 0 122.88 83.78" xml:space="preserve"><g><path d="M95.73,10.81c10.53,7.09,19.6,17.37,26.48,29.86l0.67,1.22l-0.67,1.21c-6.88,12.49-15.96,22.77-26.48,29.86 C85.46,79.88,73.8,83.78,61.44,83.78c-12.36,0-24.02-3.9-34.28-10.81C16.62,65.87,7.55,55.59,0.67,43.1L0,41.89l0.67-1.22 c6.88-12.49,15.95-22.77,26.48-29.86C37.42,3.9,49.08,0,61.44,0C73.8,0,85.45,3.9,95.73,10.81L95.73,10.81z M60.79,22.17l4.08,0.39 c-1.45,2.18-2.31,4.82-2.31,7.67c0,7.48,5.86,13.54,13.1,13.54c2.32,0,4.5-0.62,6.39-1.72c0.03,0.47,0.05,0.94,0.05,1.42 c0,11.77-9.54,21.31-21.31,21.31c-11.77,0-21.31-9.54-21.31-21.31C39.48,31.71,49.02,22.17,60.79,22.17L60.79,22.17L60.79,22.17z M109,41.89c-5.5-9.66-12.61-17.6-20.79-23.11c-8.05-5.42-17.15-8.48-26.77-8.48c-9.61,0-18.71,3.06-26.76,8.48 c-8.18,5.51-15.29,13.45-20.8,23.11c5.5,9.66,12.62,17.6,20.8,23.1c8.05,5.42,17.15,8.48,26.76,8.48c9.62,0,18.71-3.06,26.77-8.48 C96.39,59.49,103.5,51.55,109,41.89L109,41.89z"/></g></svg>
                                        </a>
                                        <a class="action-btn edit-btn" href="#earing-pay-modal" data-bs-toggle="modal" id="edit-item_{{$sellerRequest->id}}" data-id="{{$sellerRequest->id}}">
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
                                        <form user="deleteForm" method="POST"
                                              action="{{route('backend.sellers.withdraw.request.delete',$sellerRequest->id)}}">
                                            @csrf
                                            @method('DELETE')

                                            <a class="p-0 action action-btn delete-btn" href="javascript:void(0);"
                                               onclick="deleteWithSweetAlert(event,parentNode);">
                                                <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px">    <path d="M 14.984375 2.4863281 A 1.0001 1.0001 0 0 0 14 3.5 L 14 4 L 8.5 4 A 1.0001 1.0001 0 0 0 7.4863281 5 L 6 5 A 1.0001 1.0001 0 1 0 6 7 L 24 7 A 1.0001 1.0001 0 1 0 24 5 L 22.513672 5 A 1.0001 1.0001 0 0 0 21.5 4 L 16 4 L 16 3.5 A 1.0001 1.0001 0 0 0 14.984375 2.4863281 z M 6 9 L 7.7929688 24.234375 C 7.9109687 25.241375 8.7633438 26 9.7773438 26 L 20.222656 26 C 21.236656 26 22.088031 25.241375 22.207031 24.234375 L 24 9 L 6 9 z"/></svg>
                                            </a>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <nav class="new-pagination">
                        <ul class="pagination">
                            {{ $sellerWithdrawRequesr->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Body End -->

  <!-- Modal -->
  <div class="modal fade" id="earing-pay-modal">
         <form action="{{ route('backend.sellers.withdraw.verified') }}" method="GET">
            @csrf
    <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('Pay to seller') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="withdraw_id" id="withdraw_id" value="">
                    <div class="form-group row mt-2">
                        <label class="col-sm-4 col-from-label" for="payment_option">{{ __('Request Verified') }}</label>
                        <div class="col-sm-8">
                            <select name="withdraw_status" id="withdraw_status" class="form-control seller-payment-select">
                                <option value="Proceed" selected>{{ __('Proceed') }}</option>
                                <option value="Cancel">{{ __('Cancel') }}</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary text-white">{{ __('Save') }}</button>
                </div>
            </div>

    </div>
             </form>
  </div>
    <!-- modal -->
  <!--seller massage Modal -->
  <div class="modal fade" id="seller-massage">
      <div class="modal-dialog modal-dialog-centered">

          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">{{ __('Pay to seller') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                  <table class="table table-striped seller-table">
                      <tbody>
                      <tr>
                          <td>{{ __('Due to seller') }}</td>
                          <td id="pat">$139.500</td>
                      </tr>
                      <tr></tr>
                      <tr>
                          <td>{{ __('Bank Name') }}</td>
                          <td id="bnt"></td>
                      </tr>
                      <tr>
                          <td>{{ __('Bank Account Name') }}</td>
                          <td id="bat"></td>
                      </tr>
                      <tr>
                          <td>{{ __('Bank Account Number') }}</td>
                          <td id="banum"></td>
                      </tr>
                      <tr>
                          <td>{{ __('Bank Routing Number') }}	</td>
                          <td id="brnum"></td>
                      </tr>
                      </tbody>
                  </table>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
              </div>
          </div>

      </div>
  </div>
    <!-- modal -->
@endsection
@push('js')
    <script>
        "use strict";
        $('.action-btn').each(function () {

            let container = $(this);
            let service = container.data('id');
            $('#edit-item_'+service).on('click', function () {
               $('#withdraw_id').val($('#edit-item_'+service).data('id'))
            });
            //view modal
            $('#withdraw-btn_'+service).on('click', function () {

                $('#pat').text($('#withdraw-btn_'+service).data('payable-total'));
                $('#bnt').text($('#withdraw-btn_'+service).data('bank-name'));
                $('#bat').text($('#withdraw-btn_'+service).data('account-holder'));
                $('#banum').text($('#withdraw-btn_'+service).data('bank-account'));
                $('#brnum').text($('#withdraw-btn_'+service).data('routing-number'));
               $('#withdraw_id').val($('#edit-item_'+service).data('id'))
            });
        });
    </script>
@endpush
