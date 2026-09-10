<!DOCTYPE html>
<html dir="<?php echo e(lang('direction')); ?>" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="<?php echo e(maanAppearance('keywords')); ?>" />
    <meta name="description" content="<?php echo e(maanAppearance('meta_desc')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Twitter Card Data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="<?php echo $__env->yieldContent('meta_url'); ?>">
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('meta_title','BillMintMall'); ?>">
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('meta_description',maanAppearance('meta_desc')); ?>">
    <meta name="twitter:creator" content="Maan Theme">
    <meta name="twitter:image" content="<?php echo e(asset('uploads/products/meta_image')); ?>/<?php echo $__env->yieldContent('meta_image'); ?>">
    <meta name="twitter:data1" content="<?php echo $__env->yieldContent('meta_price'); ?>">
    <meta name="twitter:label1" content="Price">
    <meta name="twitter:data2" content="<?php echo $__env->yieldContent('meta_color'); ?>">
    <meta name="twitter:label2" content="Color">

    <!-- Open Graph Data -->
    <meta property="og:title" content="<?php echo $__env->yieldContent('meta_title','BillMintMall'); ?>"/>
    <meta property="og:type" content="eCommerce"/>
    <meta property="og:image" content="<?php echo e(asset('uploads/products/meta_image')); ?>/<?php echo $__env->yieldContent('meta_image'); ?>"/>
    <meta property="og:site_name" content="<?php echo e(config('app.name')); ?>"/>
    <meta property="og:url" content="<?php echo $__env->yieldContent('meta_url'); ?>"/>
    <meta property="og:description" content="<?php echo $__env->yieldContent('meta_description',maanAppearance('meta_desc')); ?>"/>

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Apple Favicon -->
    <link rel="apple-touch-icon" href="<?php echo e(asset('uploads')); ?>/<?php echo e(maanAppearance('favicon')); ?>">
    <!-- All Device Favicon -->
    <link rel="icon" href="<?php echo e(asset('uploads')); ?>/<?php echo e(maanAppearance('favicon')); ?>">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.rtl.min.css" integrity="sha384-dc2NSrAXbAkjrdm9IYrX10fQq9SDG6Vjz7nQVKdKcJl3pC+k37e7qJR5MVSCS+wR" crossorigin="anonymous">
    <!-- Swiper -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/swiper.min.css')); ?>">
    <!-- Slick -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/slick.css')); ?>">
    <!-- Nice Select -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/nice-select.css')); ?>">
    <!-- RateIt -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/rateit/rateit.css')); ?>">
    <!-- Normalize -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/normalize.css')); ?>">
    <!-- Default -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/default.css')); ?>">
    <!-- uniBox -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/uniBox/css/unibox.min.css')); ?>">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/jquery-ui/jquery-ui.css')); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/fontawesome-free-6.1.1-web/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/fontawesome/css/fontawesome-all.min.css')); ?>">
    <!-- notifications css -->
    <link rel="stylesheet" href="<?php echo e(asset('backend/assets/notifications/css/lobibox.min.css')); ?>"/>
    <!-- Style -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/blog.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/style.rtl.css')); ?>">
    <!-- Responsive -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/responsive.css')); ?>">
    <!-- My Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/my-custom.css')); ?>">

    <!-- product zoom css -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/zoom-images-carousel/zoom-custom.css')); ?>">
</head>

<body>

<div id="main-wrapper">
    <!-- Facebook share button SDK -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v11.0" nonce="iH4fRLBO"></script>
    <!-- Facebook share button SDK -->
    <header>
        <?php echo $__env->make('frontend.includes.top-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Main Header Start -->
        <div class="main-header">
            <?php echo $__env->make('frontend.includes.mid-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('frontend.includes.menu-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- Main Header End -->
    </header>
    <main>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->yieldPushContent('modal'); ?>
    </main>
    <footer>
        <?php echo $__env->make('frontend.includes.info-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend.includes.main-footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </footer>
</div>

<!-- jQuery -->
<script src="<?php echo e(asset('frontend/js/vendor/jquery-3.6.0.min.js')); ?>"></script>
<!-- jQuery UI -->
<script src="<?php echo e(asset('frontend/jquery-ui/jquery-ui.min.js')); ?>"></script>
<!-- Touch Punch -->
<script src="<?php echo e(asset('frontend/jquery-ui/jquery.ui.touch-punch.min.js')); ?>"></script>
<!-- Bootstrap -->
<script src="<?php echo e(asset('frontend/js/vendor/bootstrap.min.js')); ?>"></script>
<!-- Popper -->
<script src="<?php echo e(asset('frontend/js/vendor/popper.min.js')); ?>"></script>
<!-- Swiper -->
<script src="<?php echo e(asset('frontend/js/vendor/swiper.min.js')); ?>"></script>
<!-- Slick -->
<script src="<?php echo e(asset('frontend/js/vendor/slick.min.js')); ?>"></script>
<!-- Counter Up -->
<script src="<?php echo e(asset('frontend/js/vendor/countdown.js')); ?>"></script>
<!-- uniBox -->
<script src="<?php echo e(asset('frontend/uniBox/js/unibox.min.js')); ?>"></script>
<!-- SweetAlert -->
<script src="<?php echo e(asset('frontend/js/vendor/sweetalert.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/assets/notifications/js/lobibox.min.js')); ?>"></script>
<script src="<?php echo e(asset('backend/assets/plugins/jquery-validation/js/jquery.validate.min.js')); ?>"></script>

<script src="<?php echo e(asset('plugins/validation-setup/validation-setup.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/custom/notification.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/custom/form.js')); ?>"></script>
<!-- Nice Select -->
<script src="<?php echo e(asset('frontend/js/vendor/nice-select.min.js')); ?>"></script>
<!-- RateIt -->
<script src="<?php echo e(asset('frontend/rateit/jquery.rateit.min.js')); ?>"></script>
<!-- Index -->

<!-- product zoom js -->
<script src="<?php echo e(asset('frontend/zoom-images-carousel/zoom-image.js')); ?>"></script>
<script src="<?php echo e(asset('frontend/zoom-images-carousel/zoom-custom.js')); ?>"></script>
<!-- product zoom js -->
<script src="<?php echo e(asset('frontend/js/index.js')); ?>"></script>
<script>
    "use strict";

    var xhr = new XMLHttpRequest();

    function validateProductVariants() {
        var $scope = $('#product-detail-page[data-requires-variant="1"]');
        if (!$scope.length) {
            return true;
        }
        if ($scope.find('input[name="size"]').length && !$scope.find('input[name="size"]:checked').length) {
            swal("<?php echo e(__('Please select a size.')); ?>", "", "warning");
            return false;
        }
        if ($scope.find('input[name="color"]').length && !$scope.find('input[name="color"]:checked').length) {
            swal("<?php echo e(__('Please select a color.')); ?>", "", "warning");
            return false;
        }
        return true;
    }

    function getProductVariantSelection() {
        var $scope = $('#product-detail-page');
        var sizeEl = $scope.length ? $scope.find('input[name="size"]:checked') : $('input[name="size"]:checked');
        var colorEl = $scope.length ? $scope.find('input[name="color"]:checked') : $('input[name="color"]:checked');
        return {
            size: sizeEl.val(),
            color: colorEl.val(),
            size_id: sizeEl.attr('data-size-id') || sizeEl.attr('data-size_id'),
            color_id: colorEl.attr('data-color-id') || colorEl.attr('data-color_id')
        };
    }

    function buyNow(id){
        if (!validateProductVariants()) {
            return;
        }
        var csrf = "<?php echo e(csrf_token()); ?>";
        var courier = $('#courier').val();
        var qty = $('#product-detail-page .input-number').length ? $('#product-detail-page .input-number').val() : $('.input-number').val();
        var total_price = $('#total_price').text();
        var v = getProductVariantSelection();
        var shipping_area = $('input[name="delivery_charge"]:checked').val();

        $.ajax({
            url: "<?php echo e(route('customer.addToCart')); ?>",
            data: { _token:csrf, id:id, qty:qty, total_price:total_price, color:v.color, size:v.size, courier:courier, size_id:v.size_id, color_id:v.color_id, shipping_area:shipping_area, buynow: true },
            method: "POST"
        }).done(function(e){
            if (e.status === 'success') {
                $("#cart-count").text(e.count);
                swal("<?php echo e(__('Good Choice!')); ?>", e.name+" <?php echo e(__('is added to cart')); ?>", "success");
                $(location).attr("href","<?php echo e(url('cart')); ?>");
            } else {
                swal("<?php echo e(__('Sorry!')); ?>", e.message || e, "error");
            }
        }).fail(function(xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : "<?php echo e(__('Something went wrong.')); ?>";
            swal("<?php echo e(__('Sorry!')); ?>", msg, "error");
        });
    }

    function addToCart(id) {
        if (!validateProductVariants()) {
            return;
        }
        var csrf = "<?php echo e(csrf_token()); ?>";
        var courier = $('#courier').val();
        var qty = $('#product-detail-page .input-number').length ? $('#product-detail-page .input-number').val() : $('.input-number').val();
        var total_price = $('#total_price').text();
        var v = getProductVariantSelection();
        var shipping_area = $('input[name="delivery_charge"]:checked').val();

        $.ajax({
            url: "<?php echo e(route('customer.addToCart')); ?>",
            data: {_token:csrf, id:id, qty:qty, total_price:total_price, color:v.color, size:v.size, courier:courier, size_id:v.size_id, color_id:v.color_id, shipping_area:shipping_area},
            method: "POST"
        }).done(function(e) {
            if (e.status == 'success') {
                $("#cart-count").text(e.count);
                swal("<?php echo e(__('Good Choice!')); ?>", e.name+" <?php echo e(__('is added to cart')); ?>", "success");
            } else {
                swal("<?php echo e(__('Sorry!')); ?>", (e && e.message) ? e.message : e, "error");
            }
        }).fail(function(xhr) {
            var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : "<?php echo e(__('Something went wrong.')); ?>";
            swal("<?php echo e(__('Sorry!')); ?>", msg, "error");
        });
    }

    /* wholesale */
    $('.input-number,#whole_minus,#whole_plus').on('keyup click', function () {
        hollCal();

    })

    function hollCal() {
        $('.input-number').data('id')
        let quty = parseInt($('input[name="quantity"]').val());
        let p_price = $('#current_price').text();
        //console.log(quty);

        let product_min_qty = $('.product-min-qty').text().trim().split(' ');
        let product_max_qty = $('.product-max-qty').text().trim().split(' ');
        let product_price_all = $('.product-price-all').text().trim().split(' ');
        let product_stoke_quantity = $('.multivendor-price').data('product-quantity');
        if(product_stoke_quantity==quty ||product_stoke_quantity<=quty){
            $('#whole_plus').attr("disabled", true);
            parseInt($('input[name="quantity"]').val(product_stoke_quantity));
            quty= product_stoke_quantity
        }else {
            $('#whole_plus').attr("disabled", false);
        }

        if (product_min_qty!=''){
            let lenth= product_min_qty.length;
            $(product_max_qty).each(function( index, value ) {

                if(index==0 && quty<parseInt(product_min_qty[index])){
                    $('#total_price').text((quty*p_price).toFixed(2));
                }else{
                    if (parseInt(quty)>=parseInt(product_min_qty[index]) && parseInt(quty)<=parseInt(value)){
                        $('#total_price').text((quty*product_price_all[index]).toFixed(2));
                        return;
                    }else{
                        if (index===lenth-1 && quty>parseInt(value)){
                            $('#total_price').text((quty*product_price_all[index]).toFixed(2));
                        }

                    }
                }


            });
        }else {
            $('#total_price').text((quty*p_price).toFixed(2));
        }


    }

    function addToWishlist(id){
        if("<?php echo e(auth()->guard('customer')->check()); ?>"){
            var csrf = "<?php echo e(csrf_token()); ?>"
            var size_id = $('input[name="size"]:checked').data('size_id');
            var color_id = $('input[name="color"]:checked').data('color_id');
            $.ajax({
                url: "<?php echo e(route('customer.addToWishlist')); ?>",
                data: {_token:csrf,id:id, size_id:size_id, color_id:color_id},
                method: "POST"
            }).done(function(e){
                if(e.status === 'exists'){
                    $("#wishlist-count").text(e.count);
                    swal("<?php echo e(__('Hey!')); ?>", e.name+" <?php echo e(__('is already in your wishlist')); ?>","warning");
                }else{
                    $("#wishlist-count").text(e.count);
                    swal("<?php echo e(__('Great!')); ?>", e.name+" <?php echo e(__('added to your wishlist')); ?>",e.status);
                }
            });
        }else{
            swal("<?php echo e(__('Please!')); ?>","<?php echo e(__('Login to add product to your wishlist')); ?>","warning");
        }
    }

    function wishToCart(id){
        var csrf = "<?php echo e(@csrf_token()); ?>";
        $.ajax({
            url: "<?php echo e(route('customer.wishToCart')); ?>",
            data: {_token:csrf,id:id},
            type: "POST",
        }).done(function(e){
            $("#cart-count").text(e.count);
            $("#wishlist-count").text(e.wishCount);
            $("#wish-"+id).remove();
            swal("<?php echo e(__('Good Choice!')); ?>", e.name+" <?php echo e(__('is added to cart')); ?>", "success");
        })
    }

    function removeFromWishlist(id){
        var csrf = "<?php echo e(csrf_token()); ?>";
        $.ajax({
            url: "<?php echo e(route('customer.removeFromWishlist')); ?>",
            data: {_token:csrf,id:id},
            type: "POST"
        }).done(function(e){
            console.log($(this));
            $("#wish-"+id).remove();
            $("#wishlist-count").text(e.count);
            swal("<?php echo e(__('Hash!')); ?>",e.name+"<?php echo e(__(' is removed from your wishlist!')); ?>","warning");
        });
    }

    function changeCurrency(id){
        var csrf = "<?php echo e(csrf_token()); ?>";
        $.ajax({
            url: "<?php echo e(route('frontend.change-currency')); ?>",
            data: {_token:csrf,id:id},
            type: "POST",
        }).done(function(e){
            $("#cur-symbol").text(e.symbol);
            $("#cur-title").text(e.name);
            location.reload();
        })
    }

    function changeLanguage(id){
        var csrf = "<?php echo e(csrf_token()); ?>";
        $.ajax({
            url: "<?php echo e(route('frontend.change-language')); ?>",
            data: {_token:csrf,id:id},
            type: "POST",
        }).done(function(e){
            console.log(e);
            location.reload();
        })
    }

    function ajaxFilter(page,selector,id){
        page = parseInt(page, 10) || 1;
        var csrf = "<?php echo e(csrf_token()); ?>";
        var category = $('input[name="category"]:checked').val() || '';
        var slug = "<?php echo e(Request::segment(2)); ?>";
        var brand = [];
        var seller = [];
        var color = [];
        var size = [];
        var sorting = $("#sorting").val();
        var min = $("#price-check-b").val();
        var max = $("#price-check-c").val();

        $('.brand-check:checked').each(function(){
            brand.push($(this).val())
        })
        $('.color-check:checked').each(function(){
            color.push($(this).val())
        })
        $('.size-check:checked').each(function(){
            size.push($(this).val())
        })
        $('.seller-check:checked').each(function(){
            seller.push($(this).val())
        })

        if(xhr !== 'undefined'){
            xhr.abort(); //stop existing ajax request if new request has been sent to server
        }

        xhr = $.ajax({
            url: "<?php echo e(route('frontend.ajax-filter')); ?>",
            data: {_token:csrf,category:category,slug:slug,color:color,size:size,brand:brand,seller:seller,min:min,max:max,sorting:sorting,page:page},
            type: 'post',
            beforeSend: function(){
                $("#product-loader").show();
            },
        }).done(function(e){
            $(".breadcrumb-manu h3").text($('input[name="category"]:checked').data('name'));
            $("#product-area").html(e);
            var url = "<?php echo e(url()->current()); ?>" + (page > 1 ? "?page=" + page : "");
            window.history.pushState("", "", url);
            $("#product-loader").hide()
            $("#sorting").change(function(){
                ajaxFilter();
            })
        })
    }

    $(document).on('click','#pagination a',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var page = parseInt((url.split('page=')[1] || '1'), 10) || 1;
        window.history.pushState("", "", url);
        ajaxFilter(page);
    })

    function dealOfTheWeek(tab){
        $.ajax({
            url: "<?php echo e(route('deal-of-the-week')); ?>",
            data: {_token:"<?php echo e(csrf_token()); ?>",tab:tab},
            type: "POST"
        }).done(function(e){
            $("#"+tab).html(e);
        })
    }

    $(".brand-check").change(function(){
        ajaxFilter();
    })

    $(".seller-check").change(function(){
        ajaxFilter();
    });

    $(".category-check").change(function(){
        ajaxFilter();
    });

    $(".color-check").change(function(){
        ajaxFilter();
    });

    $(".size-check").change(function(){
        ajaxFilter();
    });

    $(".price-check").change(function(){
        ajaxFilter();
    });

    $("#sorting").change(function(){
        ajaxFilter();
    })

</script>
<script>
    "use strict";

    var boxes = [];

    sxQuery(document).ready(function() {

        var settings = {
            // REQUIRED
            suggestUrl: '<?php echo e(route('frontend.suggest',['query'=>''])); ?>', // the URL that provides the data for the suggest
            ivfImagePath: 'https://yourserver.com/images/ivf/', // the base path for instant visual feedback images

            // OPTIONAL
            instantVisualFeedback: 'all', // where the instant visual feedback should be shown, 'top', 'bottom', 'all', or 'none', default: 'all'
            throttleTime: 100, // the number of milliseconds before the suggest is triggered after finished input, default: 300ms
            extraHtml: undefined, // extra HTML code that is shown in each search suggest
            highlight: true, // whether matched words should be highlighted, default: true
            queryVisualizationHeadline: '', // A headline for the image visualization, default: empty
            animationSpeed: 200, // speed of the animations, default: 300ms
            callbacks: {
                enter: function(text,link){console.log('enter callback: '+text);}, // callback on what should happen when enter is pressed, default: undefined, meaning the link will be followed
                enterResult: function(text,link){window.location.replace(link);}, // callback on what should happen when enter is pressed on a result or a suggest is clicked
            },
            placeholder: 'Search for something',
            minChars: 3, // minimum number of characters before the suggests shows, default: 3
            suggestOrder: [], // the order of the suggests
            suggestSelectionOrder: [], // the order of how they should be selected
            noSuggests: '<b><?php echo e(__('We haven\'t found anything for you')); ?>, <u><?php echo e(__('sooorrryyy')); ?></u></b>',
            emptyQuerySuggests: {
                "suggests":{
                    "Products":[
                            <?php $__currentLoopData = uniBoxSuggestions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        {"name":"<?php echo e($suggestion->name); ?>","image":"<?php echo e(asset('uploads/products/galleries').'/'.$suggestion->images->first()->image); ?>","id":"<?php echo e($suggestion->id); ?>}","link":"<?php echo e(route('product',$suggestion->slug)); ?>"},
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    ]
                }
            },
            //maxWidth: 400 // the maximum width of the suggest box, default: as wide as the input box
        };

        // apply the settings to an input that should get the unibox
        // apply to multiple boxes
        boxes = sxQuery(".s1").unibox(settings);
    });
</script>

<script>
    // $("#editable-div").on('input',function(){
    //     $("#chat-box").val($(this).html())
    // })
    function sendToSeller(seller,customer)
    {
        var msg = $("#editable-div").html();
        var csrf = "<?php echo e(csrf_token()); ?>";
        $.ajax({
            url: "<?php echo e(route('frontend.send-to-seller')); ?>",
            data: {_token:csrf,seller_id:seller,user_id:customer,message:msg},
            type: "post"
        }).done(function(e){
            console.log(e);
            loadMessage(seller,customer);
        })
    }
    function loadMessage(seller,customer)
    {
        var csrf = "<?php echo e(csrf_token()); ?>";
        $.ajax({
            url: "<?php echo e(route('frontend.message.load')); ?>",
            data: {_token:csrf,seller_id:seller,user_id:customer},
            type: "post"
        }).done(function(e){
            $("#messages").html(e);
            $("#editable-div").text('');
        })
    }
</script>
<script>
    $(document).ready(function () {

        var suggestUrl   = "<?php echo e(route('frontend.suggest-new')); ?>";
        var shopUrl      = "<?php echo e(url('shop')); ?>";
        var productBase  = "<?php echo e(url('p')); ?>";
        var galleryBase  = "<?php echo e(asset('uploads/products/galleries')); ?>";
        var symbol       = "<?php echo e(bdtSymble()); ?>";
        var suggestTimer = null;
        var suggestXhr   = null;

        function escapeHtml(value) {
            return $('<div>').text(value == null ? '' : value).html();
        }

        function hideSuggestions() {
            $('.suggestion-wrap ul').empty();
            $('.suggestion-wrap').hide();
        }

        function discountHtml(element) {
            var promos = element.promotions_active || [];

            for (var i = 0; i < promos.length; i++) {
                if (promos[i] && promos[i].promotion_price) {
                    return '<del>' + symbol + element.unit_price + '</del><b> -' +
                        Math.round(((element.unit_price - promos[i].promotion_price) / element.unit_price) * 100) + '%</b>';
                }
            }

            if (element.discount > 0 && element.unit_price > 0) {
                var pct = element.discount_type === 'fixed'
                    ? Math.round((element.discount / element.unit_price) * 100)
                    : Math.round(element.discount);
                return '<del>' + symbol + element.unit_price + '</del><b> -' + pct + '%</b>';
            }

            return '';
        }

        function renderSuggestions(data, search) {
            var $list = $('.suggestion-wrap ul');
            $list.empty();

            if (!$.isArray(data) || data.length === 0) {
                $list.append('<li class="unibox-selectable row"><span class="search-items-content" style="padding:10px 12px;display:block;"><?php echo e(__('No products found')); ?></span></li>');
                $('.suggestion-wrap').show();
                return;
            }

            $.each(data, function (index, element) {
                if (index > 4) {
                    return false;
                }

                var images = element.images || [];
                var image  = images.length && images[0].image
                    ? galleryBase + '/' + images[0].image
                    : '';

                var imgTag = image
                    ? '<img src="' + image + '" alt="" height="50" width="50" style="padding-right:2px;padding-bottom:2px;"/>'
                    : '';

                $list.append(
                    '<li class="unibox-selectable row">' +
                        '<a href="' + productBase + '/' + element.slug + '">' + imgTag +
                            '<div class="search-items-content">' +
                                '<p>' + escapeHtml(element.name) + '</p>' +
                                '<b>' + symbol + element.sale_price + '</b>' +
                                '<div class="sess-discount">' + discountHtml(element) + '</div>' +
                            '</div>' +
                        '</a>' +
                    '</li>'
                );
            });

            $list.append(
                '<li class="unibox-selectable row">' +
                    '<form action="' + shopUrl + '" method="get">' +
                        '<div class="input-group">' +
                            '<input type="hidden" name="q" value="' + escapeHtml(search) + '">' +
                            '<button type="submit" class="product-serarch-btn"><?php echo e(__('See all results')); ?></button>' +
                        '</div>' +
                    '</form>' +
                '</li>'
            );

            $('.suggestion-wrap').show();
        }

        $(document).on('keyup', '.s', function () {
            var search = $(this).val();

            clearTimeout(suggestTimer);

            if ($.trim(search).length < 2) {
                hideSuggestions();
                return;
            }

            // Debounce so we fire one request per pause, not one per keystroke.
            suggestTimer = setTimeout(function () {
                if (suggestXhr && suggestXhr.readyState !== 4) {
                    suggestXhr.abort();
                }

                suggestXhr = $.ajax({
                    type: 'GET',
                    url: suggestUrl,
                    dataType: 'json',
                    data: {search: search}
                }).done(function (data) {
                    renderSuggestions(data, search);
                }).fail(function (jqXhr, textStatus) {
                    if (textStatus !== 'abort') {
                        hideSuggestions();
                    }
                });
            }, 250);
        });

        // Close the dropdown when clicking outside of the search area.
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.suggestion-wrap, .s').length) {
                hideSuggestions();
            }
        });
    });
</script>

<?php if(Session::has('status')): ?>
    <script>
        swal("<?php echo e(__('Success')); ?>","<?php echo e(Session::get('status')); ?>","success");
    </script>
<?php endif; ?>

<?php if(Session::has('success')): ?>
    <script>
        swal("<?php echo e(__('Subscribed!')); ?>","<?php echo e(Session::get('success')); ?>","success");
    </script>
<?php endif; ?>

<?php if(Session::has('error')): ?>
    <script>
        swal('✘' +"  "+ "<?php echo e(Session::get('error')); ?>","error");
    </script>
<?php endif; ?>

<?php if($errors->has('email')): ?>
    <script>
        swal("Error","<?php echo e($errors->first('email')); ?>","error");
    </script>
<?php endif; ?>

<?php echo $__env->yieldPushContent('script'); ?>
<?php echo $__env->yieldContent('script'); ?>

</body>

</html>
<?php /**PATH /Users/himank/Developer/Development/Office_projects/Ecom_project/pays_ecom/billmint/resources/views/frontend/layouts/front.blade.php ENDPATH**/ ?>