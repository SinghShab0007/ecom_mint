<form action="{{ route('seller.sale.update',$sale->id) }}" method="post">
    @csrf
    @method('patch')
    <div class="row">
        <div class="col-lg-6 my-2">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $sale->name }}">
        </div>
        <div class="col-lg-6 my-2">
            <label for="total">{{ __('Total Amount') }}</label>
            <input type="number" name="total" id="edit-total" class="form-control" placeholder="Total Amount" value="{{ $sale->total }}">
        </div>
        <div class="col-lg-6 my-2">
            <label for="invoice">{{ __('Invoice') }}</label>
            <input type="text" name="invoice" class="form-control" placeholder="Invoice" value="{{ $sale->invoice }}">
        </div>
        <div class="col-lg-6 my-2">
            <label for="pay">{{ __('Pay Amount') }}</label>
            <input type="number" name="paid" id="edit-paid" class="form-control" placeholder="Pay Amount" value="{{ $sale->paid }}">
        </div>
        <div class="col-lg-6 my-2">
            <label for="mobile">{{ __('Mobile') }}</label>
            <input type="number" name="mobile" class="form-control" placeholder="Phone number" value="{{ $sale->mobile }}">
        </div>
        <div class="col-lg-6 my-2">
            <label for="deu">{{ __('Due Amount') }}</label>
            <input type="number" name="due" id="edit-due" class="form-control" placeholder="Deu Amount" value="{{ $sale->due }}" readonly>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn maan-submit-btn">{{ __('Update') }}</button>
    </div>
</form>

@push('js')
    <script>
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
    </script>
@endpush
