<div class="row">
    <div class="col-lg-3">
        <p>{{__('Category')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select name="faq_category_id"
                    class="form-select category form-control{{ $errors->has('faq_category_id') ? ' is-invalid' : '' }}"
                    required>
                <option value="">{{ __('Select Category') }}</option>
                @foreach($faq_categories as $key => $cat)
                    <option value="{{$cat->id}}" data-id="{{$cat->id}}"
                            @if($cat->id==$faq->faq_category_id||$cat->id==old('faq_category_id'))) selected @endif >{{$cat->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('faq_category_id'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('faq_category_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Sub-Category')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <select name="faq_sub_category_id"
                    class="form-select subcategory form-control{{ $errors->has('faq_sub_category_id') ? ' is-invalid' : '' }}"
                    required>
                <option value="">{{__('Select Sub-Category') }}</option>
                @foreach($faq_sub_categories as $key => $sub_cat)
                    <option value="{{$sub_cat->id}}" data-id="{{$sub_cat->faq_category_id}}"
                            @if($sub_cat->id==$faq->faq_sub_category_id||$sub_cat->id==old('faq_sub_category_id'))) selected @endif >{{$sub_cat->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('faq_sub_category_id'))
                <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('faq_sub_category_id') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Question')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input name="question" type="text" required
                   class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}"
                   value="@if($faq->question){{$faq->question}}@else{{ old('question') }}@endif"
                   placeholder="Question">
            @if ($errors->has('question'))
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('question') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Answer')}} <span class="text-red">*</span></p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <textarea name="answer"
                      class="form-control"
                      required>@if($faq->answer){{$faq->answer}}@else{{ old('answer') }}@endif</textarea>
            @error('answer')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
    </div>
    <div class="col-lg-3">
        <p>{{__('Order')}} </p>
    </div>
    <div class="col-lg-7">
        <div class="input-group">
            <input id="order" type="number" min="0"
                   class="form-control @error('order') is-invalid @enderror"
                   name="order"
                   value="@if($faq->order){{$faq->order}}@else{{ old('order')??1 }}@endif"
                   required placeholder="Order"
                   autofocus>

            @error('order')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>

</div>

@push('js')
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {

                // validate form on keyup and submit
                $("#faqForm").validate();

                $(document).on( "change", '.category',function() {
                    $(".subcategory option").removeAttr("disabled");
                    var id = ($(this).find(":selected").data("id"));
                    $("#faqForm .subcategory option[data-id]:not([data-id='" + id + "'])").attr("disabled", "true");
                });

            });
        })(jQuery);

    </script>
@endpush
