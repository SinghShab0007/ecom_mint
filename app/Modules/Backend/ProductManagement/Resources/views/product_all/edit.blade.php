@extends('backend.layouts.app')
@section('title','Product Update - ')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/css/image-uploader.min.css')}}">
@endpush
@section('content')
    <div class="content-body">
    @include('productmanagement::includes.product_management')
    <!-- Tab Content Start -->
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="add-product" aria-labelledby="add-product-tab">
                <form id="productForm" class="add-brand-form" action="@auth('admin'){{route('backend.products.update',$product->id)}}@elseauth('seller'){{route('seller.products.update',$product->id)}}@endauth" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('productmanagement::products.form')

                </form>
            </div>
        </div>
        @endsection
        @push('js')
            <script src="{{asset('backend/js/image-uploader.min.js')}}"></script>
            <script>
                $(function() {
                    "use strict";
                    $(document).ready(function(){
                        let preloaded = [];

                        var product_images = <?php echo json_encode($product->images); ?>;
                        product_images.forEach(image => {
                            preloaded.push({id:image.id,src: public_path+'/uploads/products/galleries/'+ image.image});
                        });

                        $('.input-images').imageUploader({
                            preloaded: preloaded,
                            imagesInputName: 'images',
                            preloadedInputName: 'old_images',
                            maxSize: 1024 * 10240,
                            maxFiles: 4,
                            mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
                            extensions: undefined
                        });
                    });
                });
            </script>
    @endpush
