@extends('backend.layouts.app')

@section('title','Edit Coupon | ')

@section('content')
    <div class="content-body">
        <div class="container">
            <div class="content-tab-title">
                <h4>{{ __('Edit Coupon') }}</h4>
            </div>
        </div>
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                <div class="container">
                    <form id="faqForm" method="post" action="{{route('backend.coupon.update',$coupon->id)}}" class="add-brand-form">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="col-lg-3">
                                <p>{{__('Coupon Type')}} <span class="text-red">*</span></p>
                            </div>
                            <div class="col-lg-7">
                                <div class="input-group">
                                    <select name="type" class="form-select category form-control{{ $errors->has('faq_category_id') ? ' is-invalid' : '' }}" required id="type" disabled>
                                        <option value="">{{ __('Select Category') }}</option>
                                        <option value="product" {{ $coupon->type == 'product' ? 'selected' : '' }}>{{ __('For Product') }}</option>
                                        <option value="cart" {{ $coupon->type == 'cart' ? 'selected' : '' }}>{{ __('For Total Order') }}</option>
                                    </select>

                                    @if ($errors->has('type'))
                                        <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('type') }}</strong>
            </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row" id="coupon-form">
                            @if($coupon->type == 'product')
                                <div class="col-lg-3">
                                    <p>{{ __('Coupon Code') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group">
                                        <input name="code" type="text" required class="form-control" value="{{ $coupon->code }}" placeholder="Alphabet & Number">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <p>{{ __('Product') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group">
                                        <select name="products[]" class="form-select select2 category form-control{{ $errors->has('faq_category_id') ? ' is-invalid' : '' }}" required multiple>
                                            <option value="">{{ __('Select Product') }}</option>
                                            @foreach($categories as $category)
                                                @foreach($category->subCategories as $subCategory)
                                                    @foreach($subCategory->subSubCategories as $subSubCategory)
                                                        @foreach($subSubCategory->products as $product)
                                                            <option value="{{ $product->id }}" {{ in_array($product->id,$details->product_id) ? 'selected' : '' }}>{{ $category->name.' >>> '.$subCategory->name .' >>> '.$subSubCategory->name.' >>> '.$product->name }}</span></option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <p>{{ __('Number of Coupon') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group">
                                        <input name="qty" type="number" required value="{{ $coupon->qty }}" class="form-control" placeholder="{{ __('Total coupon can be used') }}">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <p>{{__('Start')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group month overflow-visible">
                                        <input name="start" type="date" class="form-control" value="{{ date('Y-m-d',strtotime($coupon->start))??null }}">
                                        @error('start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('End')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group month overflow-visible">
                                        <input name="end" type="date" class="form-control" value="{{ date('Y-m-d',strtotime($coupon->end))??null }}">
                                        @error('end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('Discount')}}</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="input-group month overflow-visible">
                                        <input name="discount" type="number" class="form-control" value="{{ $coupon->discount }}">
                                        @error('discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input-group month overflow-visible">
                                        <select name="discount_type" class="form-select category form-control" required>
                                            <option value="">{{ __('Select Product') }}</option>
                                            <option value="currency" {{ $coupon->discount_type == 'currency' ? 'selected' : '' }}>{{ __('$') }}</option>
                                            <option value="percent" {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}>{{ __('%') }}</option>
                                        </select>
                                    </div>
                                </div>

                            @elseif($coupon->type == 'cart')
                                <div class="col-lg-3">
                                    <p>{{ __('Coupon Code') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group">
                                        <input name="code" type="text" required class="form-control" value="{{ $coupon->code }}" placeholder="Alphabet & Number">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <p>{{ __('Minimum Shopping') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group">
                                        <input name="min_buy" type="number" required class="form-control" value="{{ $details->min_buy }}" placeholder="{{ __('Minimum shopping amount to eligible for this coupon') }}">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <p>{{ __('Maximum Discount') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group">
                                        <input name="max_discount" type="number" value="{{ $details->max_discount }}" required class="form-control" placeholder="{{ __('Maximum amount to be discount') }}">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <p>{{ __('Number of Coupon') }} <span class="text-red">*</span></p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group">
                                        <input name="qty" type="number" value="{{ $coupon->qty }}" required class="form-control" placeholder="{{ __('Maximum amount to be discount') }}">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <p>{{__('Discount')}}</p>
                                </div>
                                <div class="col-lg-5">
                                    <div class="input-group month overflow-visible">
                                        <input name="discount" type="number" value="{{ $coupon->discount }}" class="form-control">
                                        @error('discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input-group month overflow-visible">
                                        <select name="discount_type" class="form-select category form-control" required>
                                            <option value="">{{ __('Select Product') }}</option>
                                            <option value="currency" {{ $coupon->discount_type == 'currency' ? 'selected' : '' }}>{{ __('$') }}</option>
                                            <option value="percent" {{ $coupon->discount_type == 'percent' ? 'selected' : '' }}>{{ __('%') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <p>{{__('Start')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group month overflow-visible">
                                        <input name="start" type="date" class="form-control" value="{{ date('Y-m-d',strtotime($coupon->start))??null }}">
                                        @error('start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <p>{{__('End')}}</p>
                                </div>
                                <div class="col-lg-7">
                                    <div class="input-group month overflow-visible">
                                        <input name="end" type="date" class="form-control" value="{{ date('Y-m-d',strtotime($coupon->end))??null }}">
                                        @error('end')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            @endif
                        </div>

                        <div class="col-lg-7 offset-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Tab Content End -->
    </div>
@endsection

@push('js')
    <script>
        $(".select2").select2(); // initialize select2

        $("#type").change(function(){
            var type = $(this).val();
            var csrf = "{{ @csrf_token() }}"
            $.ajax({
                url: "{{ route('backend.coupon.product') }}",
                data: {_token:csrf,type:type},
                type: "post",
                beforeSuccess: function(){
                    console.log('loading...')
                }
            }).done(function(e){
                $("#coupon-form").html(e);

                $(".select2").select2(); // initialize select2
            })
        })
    </script>
@endpush
