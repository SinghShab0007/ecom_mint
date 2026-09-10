@extends('backend.layouts.app')

@section('title','Create Coupon | ')

@section('content')
    <div class="content-body">
        <div class="container">
            <div class="content-tab-title">
                <h4>{{ __('Create Coupon') }}</h4>
            </div>
        </div>
        <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-category" role="tabpanel" aria-labelledby="add-category-tab">
                <div class="container">
                    <form id="faqForm" method="post" action="{{route('backend.coupon.store')}}" class="add-brand-form">
                        @csrf()
                        @include('backend.pages.coupon.form')
                        <div class="col-lg-7 offset-3">
                            <div class="from-submit-btn">
                                <button class="submit-btn" type="submit">{{__('Save')}}</button>
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
