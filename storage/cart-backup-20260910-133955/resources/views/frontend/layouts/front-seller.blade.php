<!DOCTYPE html>
<html dir="{{ lang('direction') }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="BillMintMall Ecommerce HTML5 Template"/>
    <meta name="description" content="BillMintMall Ecommerce HTML5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>BillMintMall Ecommerce HTML5 Template</title>

    <!-- Apple Favicon -->
    <link rel="apple-touch-icon" href="{{ asset('public/storage/favicon.png') }}">

    <!-- All Device Favicon -->
    <link rel="icon" href="{{ asset('public/storage/favicon.png') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('frontend/css-seller/bootstrap.min.css') }}">

    <!-- Swiper -->
    <link rel="stylesheet" href="{{ asset('frontend/css-seller/swiper.min.css') }}">

    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('frontend/css-seller/slick.css') }}">

    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('frontend/css-seller/nice-select.css') }}">

    <!-- Normalize -->
    <link rel="stylesheet" href="{{ asset('frontend/css-seller/normalize.css') }}">

    <!-- Line Awesome -->
    <link rel="stylesheet" href="{{ asset('public/frontend/css/line-awesome.min.css') }}">

    <!-- RateIt -->
    <link rel="stylesheet" href="{{ asset('frontend/rateit/rateit.css') }}">

    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('frontend/css-seller/default.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('frontend/css-seller/style.css') }}">

    <!-- Responsive -->
    <link rel="stylesheet" href="{{ asset('frontend/css-seller/responsive.css') }}">
</head>

<body>

<div id="main-wrapper">
    <header>
        <!-- Top Bar Start -->
        <div class="top-bar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-7">
                        <div class="top-bar-left">
                            <ul>
                                <li>
                                    <a href="#">
                                            <span class="icon">
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 473.806 473.806"><path d="M374.456,293.506c-9.7-10.1-21.4-15.5-33.8-15.5c-12.3,0-24.1,5.3-34.2,15.4l-31.6,31.5c-2.6-1.4-5.2-2.7-7.7-4
			c-3.6-1.8-7-3.5-9.9-5.3c-29.6-18.8-56.5-43.3-82.3-75c-12.5-15.8-20.9-29.1-27-42.6c8.2-7.5,15.8-15.3,23.2-22.8
			c2.8-2.8,5.6-5.7,8.4-8.5c21-21,21-48.2,0-69.2l-27.3-27.3c-3.1-3.1-6.3-6.3-9.3-9.5c-6-6.2-12.3-12.6-18.8-18.6
			c-9.7-9.6-21.3-14.7-33.5-14.7s-24,5.1-34,14.7c-0.1,0.1-0.1,0.1-0.2,0.2l-34,34.3c-12.8,12.8-20.1,28.4-21.7,46.5
			c-2.4,29.2,6.2,56.4,12.8,74.2c16.2,43.7,40.4,84.2,76.5,127.6c43.8,52.3,96.5,93.6,156.7,122.7c23,10.9,53.7,23.8,88,26
			c2.1,0.1,4.3,0.2,6.3,0.2c23.1,0,42.5-8.3,57.7-24.8c0.1-0.2,0.3-0.3,0.4-0.5c5.2-6.3,11.2-12,17.5-18.1c4.3-4.1,8.7-8.4,13-12.9
			c9.9-10.3,15.1-22.3,15.1-34.6c0-12.4-5.3-24.3-15.4-34.3L374.456,293.506z M410.256,398.806
			C410.156,398.806,410.156,398.906,410.256,398.806c-3.9,4.2-7.9,8-12.2,12.2c-6.5,6.2-13.1,12.7-19.3,20
			c-10.1,10.8-22,15.9-37.6,15.9c-1.5,0-3.1,0-4.6-0.1c-29.7-1.9-57.3-13.5-78-23.4c-56.6-27.4-106.3-66.3-147.6-115.6
			c-34.1-41.1-56.9-79.1-72-119.9c-9.3-24.9-12.7-44.3-11.2-62.6c1-11.7,5.5-21.4,13.8-29.7l34.1-34.1c4.9-4.6,10.1-7.1,15.2-7.1
			c6.3,0,11.4,3.8,14.6,7c0.1,0.1,0.2,0.2,0.3,0.3c6.1,5.7,11.9,11.6,18,17.9c3.1,3.2,6.3,6.4,9.5,9.7l27.3,27.3
			c10.6,10.6,10.6,20.4,0,31c-2.9,2.9-5.7,5.8-8.6,8.6c-8.4,8.6-16.4,16.6-25.1,24.4c-0.2,0.2-0.4,0.3-0.5,0.5
			c-8.6,8.6-7,17-5.2,22.7c0.1,0.3,0.2,0.6,0.3,0.9c7.1,17.2,17.1,33.4,32.3,52.7l0.1,0.1c27.6,34,56.7,60.5,88.8,80.8
			c4.1,2.6,8.3,4.7,12.3,6.7c3.6,1.8,7,3.5,9.9,5.3c0.4,0.2,0.8,0.5,1.2,0.7c3.4,1.7,6.6,2.5,9.9,2.5c8.3,0,13.5-5.2,15.2-6.9
			l34.2-34.2c3.4-3.4,8.8-7.5,15.1-7.5c6.2,0,11.3,3.9,14.4,7.3c0.1,0.1,0.1,0.1,0.2,0.2l55.1,55.1
			C420.456,377.706,420.456,388.206,410.256,398.806z"/><path d="M256.056,112.706c26.2,4.4,50,16.8,69,35.8s31.3,42.8,35.8,69c1.1,6.6,6.8,11.2,13.3,11.2c0.8,0,1.5-0.1,2.3-0.2
			c7.4-1.2,12.3-8.2,11.1-15.6c-5.4-31.7-20.4-60.6-43.3-83.5s-51.8-37.9-83.5-43.3c-7.4-1.2-14.3,3.7-15.6,11
			S248.656,111.506,256.056,112.706z"/><path d="M473.256,209.006c-8.9-52.2-33.5-99.7-71.3-137.5s-85.3-62.4-137.5-71.3c-7.3-1.3-14.2,3.7-15.5,11
			c-1.2,7.4,3.7,14.3,11.1,15.6c46.6,7.9,89.1,30,122.9,63.7c33.8,33.8,55.8,76.3,63.7,122.9c1.1,6.6,6.8,11.2,13.3,11.2
			c0.8,0,1.5-0.1,2.3-0.2C469.556,223.306,474.556,216.306,473.256,209.006z"/>
											</svg>
										</span>
                                        <span class="text">+123 456 8910</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                            <span class="icon">
											<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M386.689,304.403c-35.587,0-64.538,28.951-64.538,64.538s28.951,64.538,64.538,64.538
			c35.593,0,64.538-28.951,64.538-64.538S422.276,304.403,386.689,304.403z M386.689,401.21c-17.796,0-32.269-14.473-32.269-32.269
			c0-17.796,14.473-32.269,32.269-32.269c17.796,0,32.269,14.473,32.269,32.269C418.958,386.738,404.485,401.21,386.689,401.21z"/><path d="M166.185,304.403c-35.587,0-64.538,28.951-64.538,64.538s28.951,64.538,64.538,64.538s64.538-28.951,64.538-64.538
			S201.772,304.403,166.185,304.403z M166.185,401.21c-17.796,0-32.269-14.473-32.269-32.269c0-17.796,14.473-32.269,32.269-32.269
			c17.791,0,32.269,14.473,32.269,32.269C198.454,386.738,183.981,401.21,166.185,401.21z"/><path d="M430.15,119.675c-2.743-5.448-8.32-8.885-14.419-8.885h-84.975v32.269h75.025l43.934,87.384l28.838-14.5L430.15,119.675z"/><rect x="216.202" y="353.345" width="122.084" height="32.269"/><path d="M117.781,353.345H61.849c-8.912,0-16.134,7.223-16.134,16.134c0,8.912,7.223,16.134,16.134,16.134h55.933
			c8.912,0,16.134-7.223,16.134-16.134C133.916,360.567,126.693,353.345,117.781,353.345z"/><path d="M508.612,254.709l-31.736-40.874c-3.049-3.937-7.755-6.239-12.741-6.239H346.891V94.655
			c0-8.912-7.223-16.134-16.134-16.134H61.849c-8.912,0-16.134,7.223-16.134,16.134s7.223,16.134,16.134,16.134h252.773v112.941
			c0,8.912,7.223,16.134,16.134,16.134h125.478l23.497,30.268v83.211h-44.639c-8.912,0-16.134,7.223-16.134,16.134
			c0,8.912,7.223,16.134,16.134,16.134h60.773c8.912,0,16.134-7.223,16.135-16.134V264.605
			C512,261.023,510.806,257.538,508.612,254.709z"/><path d="M116.706,271.597H42.487c-8.912,0-16.134,7.223-16.134,16.134c0,8.912,7.223,16.134,16.134,16.134h74.218
			c8.912,0,16.134-7.223,16.134-16.134C132.84,278.82,125.617,271.597,116.706,271.597z"/><path d="M153.815,208.134H16.134C7.223,208.134,0,215.357,0,224.269s7.223,16.134,16.134,16.134h137.681
			c8.912,0,16.134-7.223,16.134-16.134S162.727,208.134,153.815,208.134z"/><path d="M180.168,144.672H42.487c-8.912,0-16.134,7.223-16.134,16.134c0,8.912,7.223,16.134,16.134,16.134h137.681
			c8.912,0,16.134-7.223,16.134-16.134C196.303,151.895,189.08,144.672,180.168,144.672z"/></svg>
										</span>
                                        <span class="text">Track Your Order</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="top-bar-right">
                            <ul>
                                <li>
                                    <div class="dropdown currency-manu">
                                        <button class="dropdown-toggle" type="button" id="dropdownCurrency" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="flag"><img src="assets/img/flag/uk-flag.png" alt="flag"></span>
                                            <span class="flag-title">USD</span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownCurrency">
                                            <li>
                                                <a href="#">
                                                    <span class="flag"><img src="assets/img/flag/bd-flag.png" alt="flag"></span>
                                                    <span class="flag-title">Taka</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="flag"><img src="assets/img/flag/sa-flag.png" alt="flag"></span>
                                                    <span class="flag-title">Riyal</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <span class="flag"><img src="assets/img/flag/india-flag.png" alt="flag"></span>
                                                    <span class="flag-title">Rupee</span>
                                                </a>
                                            </li>
                                            <li class="active">
                                                <a href="#">
                                                    <span class="flag"><img src="assets/img/flag/uk-flag.png" alt="flag"></span>
                                                    <span class="flag-title">USD</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown help-manu">
                                        <button class="dropdown-toggle" type="button" id="dropdownHelpManu" data-bs-toggle="dropdown" aria-expanded="false">Help</button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownHelpManu">
                                            <li><a href="#">Help 1</a></li>
                                            <li><a href="#">Help 2</a></li>
                                            <li><a href="#">Help 3</a></li>
                                            <li><a href="#">Help 4</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Bar End -->
        <!-- Main Header Start -->
        <div class="main-header">
            <!-- Mid Bar Start -->
            <div class="mid-bar">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-5 col-sm-3">
                            <div class="logo">
                                <a href="{{ url('/') }}"><img src="{{ asset('uploads') }}/{{ maanAppearance('logo') }}" alt="logo"></a>
                            </div>
                        </div>
                        <div class="d-none d-lg-block col-lg-6">
                            <div class="mid-search">
                                <form>
                                    <div class="input-group">
                                        <input type="text" placeholder="Search product...">
                                        <button><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.999 511.999"><path d="M508.874,478.708L360.142,329.976c28.21-34.827,45.191-79.103,45.191-127.309c0-111.75-90.917-202.667-202.667-202.667 S0,90.917,0,202.667s90.917,202.667,202.667,202.667c48.206,0,92.482-16.982,127.309-45.191l148.732,148.732 c4.167,4.165,10.919,4.165,15.086,0l15.081-15.082C513.04,489.627,513.04,482.873,508.874,478.708z M202.667,362.667 c-88.229,0-160-71.771-160-160s71.771-160,160-160s160,71.771,160,160S290.896,362.667,202.667,362.667z"/></svg></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-7 col-sm-9 col-lg-3">
                            <div class="mair-right">
                                <ul>
                                    <li>
                                        <div class="popup-search">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#searchPopup"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.999 511.999"><path d="M508.874,478.708L360.142,329.976c28.21-34.827,45.191-79.103,45.191-127.309c0-111.75-90.917-202.667-202.667-202.667 S0,90.917,0,202.667s90.917,202.667,202.667,202.667c48.206,0,92.482-16.982,127.309-45.191l148.732,148.732 c4.167,4.165,10.919,4.165,15.086,0l15.081-15.082C513.04,489.627,513.04,482.873,508.874,478.708z M202.667,362.667 c-88.229,0-160-71.771-160-160s71.771-160,160-160s160,71.771,160,160S290.896,362.667,202.667,362.667z"/></svg></button>
                                            <div class="modal fade" id="searchPopup" tabindex="-1" aria-labelledby="searchPopup" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="input-group">
                                                                    <input type="text" placeholder="Search product...">
                                                                    <button><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 511.999 511.999"><path d="M508.874,478.708L360.142,329.976c28.21-34.827,45.191-79.103,45.191-127.309c0-111.75-90.917-202.667-202.667-202.667 S0,90.917,0,202.667s90.917,202.667,202.667,202.667c48.206,0,92.482-16.982,127.309-45.191l148.732,148.732 c4.167,4.165,10.919,4.165,15.086,0l15.081-15.082C513.04,489.627,513.04,482.873,508.874,478.708z M202.667,362.667 c-88.229,0-160-71.771-160-160s71.771-160,160-160s160,71.771,160,160S290.896,362.667,202.667,362.667z"/></svg></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown login-manu">
                                            <button class="dropdown-toggle" type="button" id="dropdownLogin" data-bs-toggle="dropdown" aria-expanded="false"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256,288.389c-153.837,0-238.56,72.776-238.56,204.925c0,10.321,8.365,18.686,18.686,18.686h439.747
			c10.321,0,18.686-8.365,18.686-18.686C494.56,361.172,409.837,288.389,256,288.389z M55.492,474.628
			c7.35-98.806,74.713-148.866,200.508-148.866s193.159,50.06,200.515,148.866H55.492z"/><path d="M256,0c-70.665,0-123.951,54.358-123.951,126.437c0,74.19,55.604,134.54,123.951,134.54s123.951-60.35,123.951-134.534
			C379.951,54.358,326.665,0,256,0z M256,223.611c-47.743,0-86.579-43.589-86.579-97.168c0-51.611,36.413-89.071,86.579-89.071
			c49.363,0,86.579,38.288,86.579,89.071C342.579,180.022,303.743,223.611,256,223.611z"/></svg>
												</span></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownLogin">
                                                <li><a href="profile.html">My Profile</a></li>
                                                <li><a href="card.html">My Orders</a></li>
                                                <li><a href="wishlist.html">Wish List</a></li>
                                                <li><a href="wishlist.html">My Favorite</a></li>
                                                <li><a href="#">My Coupon</a></li>
                                                <li><a href="user-panel/announcements.html">Announcements</a></li>
                                                <li><a href="user-panel/faq.html">FAQ</a></li>
                                                <li><a href="login.html">Log Out</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{ url('wishlist') }}"><i class="la la-heart-o"></i>
                                            <span class="number">{{ session('cart') ? count(session('cart')) : 0 }}</span></a>
                                    </li>
                                    <li>
                                        <a href="card.html">
                                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001"><path d="M503.142,79.784c-7.303-8.857-18.128-13.933-29.696-13.933H176.37c-6.085,0-11.023,4.938-11.023,11.023 c0,6.085,4.938,11.023,11.023,11.023h297.07c5.032,0,9.541,2.1,12.688,5.914c3.197,3.88,4.475,8.995,3.511,13.972l-44.054,220.282 c-1.709,7.871-8.383,13.366-16.232,13.366H184.323L83.158,36.854C77.69,21.234,62.886,10.74,45.932,10.74 c-0.005,0-0.011,0-0.017,0c-14.38,0.496-28.963,0.491-32.535,0.248c-3.555-0.772-7.397,0.22-10.152,2.976 c-4.305,4.305-4.305,11.282,0,15.587c3.412,3.412,4.564,4.564,43.068,3.23c7.22,0,13.674,4.564,15.995,11.188l103.618,311.962 c1.499,4.503,5.71,7.545,10.461,7.545h252.982c18.31,0,33.841-12.638,37.815-30.909l44.109-220.525 C513.503,100.513,510.544,88.757,503.142,79.784z"/><path d="M424.392,424.11H223.77c-6.785,0-13.162-4.674-15.46-11.233l-21.495-63.935c-1.94-5.771-8.207-8.885-13.961-6.934 c-5.771,1.935-8.874,8.19-6.934,13.961l21.539,64.061c5.473,15.625,20.062,26.119,36.31,26.119h200.622 c6.085,0,11.023-4.933,11.023-11.018S430.477,424.11,424.392,424.11z"/><path d="M231.486,424.104c-21.275,0-38.581,17.312-38.581,38.581s17.306,38.581,38.581,38.581s38.581-17.312,38.581-38.581 S252.761,424.104,231.486,424.104z M231.486,479.22c-9.116,0-16.535-7.419-16.535-16.535c0-9.116,7.419-16.535,16.535-16.535 c9.116,0,16.535,7.419,16.535,16.535C248.021,471.802,240.602,479.22,231.486,479.22z"/><path d="M424.392,424.104c-21.269,0-38.581,17.312-38.581,38.581s17.312,38.581,38.581,38.581 c21.269,0,38.581-17.312,38.581-38.581S445.661,424.104,424.392,424.104z M424.392,479.22c-9.116,0-16.535-7.419-16.535-16.535 c0-9.116,7.419-16.535,16.535-16.535c9.116,0,16.535,7.419,16.535,16.535C440.927,471.802,433.508,479.22,424.392,479.22z"/></svg></span>
                                            <span class="number">5</span>
                                        </a>
                                    </li>
                                </ul>
                                <button class="menu-btn">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mid Bar End -->
            <!-- Manu Bar Start -->
            <div class="manu-bar">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <div class="dropdown category-manu">
                                <button class="dropdown-toggle" type="button" id="category-manu-btn" data-bs-toggle="dropdown" aria-expanded="false"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 385 385"><path d="M371,122.3H14c-7.7,0-14-6.3-14-14v0c0-7.7,6.3-14,14-14H371c7.7,0,14,6.3,14,14v0C385,116,378.7,122.3,371,122.3z"/><path d="M243,206.2H12.6c-6.8,0-12.3-5.5-12.3-12.3v0c0-8.7,7-15.7,15.7-15.7h227c6.8,0,12.3,5.5,12.3,12.3v3.4 C255.3,200.7,249.8,206.2,243,206.2z"/><path d="M141,290.7H14c-7.7,0-14-6.3-14-14v0c0-7.7,6.3-14,14-14h127c7.7,0,14,6.3,14,14v0C155,284.4,148.7,290.7,141,290.7z"/></svg></span>
                                    <span class="text">All Category</span>
                                </button>
                                <div class="dropdown-menu category-list" aria-labelledby="category-manu-btn">
                                    <ul>
                                        <li>
                                            <a href="#"> <span class="icon"><svg viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg"><path d="m126.25 87.75h-7.622v-60a6.758 6.758 0 0 0 -6.75-6.75h-95.75a6.758 6.758 0 0 0 -6.75 6.75v60h-7.628a1.75 1.75 0 0 0 -1.75 1.75v7.75a9.761 9.761 0 0 0 9.75 9.75h108.5a9.761 9.761 0 0 0 9.75-9.75v-7.75a1.75 1.75 0 0 0 -1.75-1.75zm-113.372-60a3.254 3.254 0 0 1 3.25-3.25h95.75a3.254 3.254 0 0 1 3.25 3.25v60h-102.25zm30.622 63.5h41v1.125a3.254 3.254 0 0 1 -3.25 3.25h-34.5a3.254 3.254 0 0 1 -3.25-3.25zm81 6a6.257 6.257 0 0 1 -6.25 6.25h-108.5a6.257 6.257 0 0 1 -6.25-6.25v-6h36.5v1.125a6.758 6.758 0 0 0 6.75 6.75h34.5a6.758 6.758 0 0 0 6.75-6.75v-1.125h36.5z"/><path d="m108.628 79.5v-46.75a1.75 1.75 0 0 0 -1.75-1.75h-85.75a1.75 1.75 0 0 0 -1.75 1.75v46.75a1.75 1.75 0 0 0 1.75 1.75h85.75a1.75 1.75 0 0 0 1.75-1.75zm-3.5-1.75h-82.25v-43.25h82.25z"/><path d="m53.825 66.3a1.749 1.749 0 0 0 2.475 0l17.875-17.875a1.75 1.75 0 0 0 -2.475-2.475l-17.875 17.875a1.751 1.751 0 0 0 0 2.475z"/><path d="m67.793 62.343a1.752 1.752 0 0 0 2.475 0l9.961-9.961a1.75 1.75 0 1 0 -2.475-2.475l-9.961 9.961a1.751 1.751 0 0 0 0 2.475z"/><path d="m49.015 62.855a1.742 1.742 0 0 0 1.237-.512l9.96-9.961a1.75 1.75 0 1 0 -2.474-2.475l-9.961 9.961a1.75 1.75 0 0 0 1.238 2.987z"/></svg></span>
                                                <span class="text">Computer & Offices</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"/></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M370,213.8c-7.5,1.3-15,2.4-22.3,3.4l-6.5-68.3c43.9-28,56.9-77.3,60.4-111c1.1-10.9-3.3-21.6-11.7-28.5
	c-10.1-8.5-23.8-11.5-36.6-8c-31.6,8.2-64,12.8-96.6,13.7c-32.6-0.9-65-5.5-96.6-13.7c-12.8-3.5-26.4-0.5-36.6,8.1
	c-8.4,7-12.8,17.6-11.7,28.5c3.5,33.7,16.5,82.9,60.3,111l-6.5,68.3c-7.3-1-14.8-2.1-22.3-3.4c-13-2.3-26.1,3-33.8,13.6
	c-7.5,10.2-8.4,23.7-2.5,34.9c10.7,18.2,26.8,32.8,46.1,41.6l-38,182c-2.3,11.3,4.6,22.4,15.7,25.3c11.1,2.9,22.6-3.5,26-14.5
	l30.5-95.8H326l30.5,95.8c3.4,11,14.9,17.4,26.1,14.5c11.2-2.9,18.1-14.1,15.7-25.4l-38-182c19.2-8.8,35.3-23.3,46.1-41.6
	c5.9-11.1,5-24.7-2.5-34.9C396.1,216.8,383,211.5,370,213.8z M330.7,219.3c-5.9,0.6-11.5,1.2-17,1.7l-5.4-57.3
	c5.6-1.7,11.2-3.7,16.5-6L330.7,219.3z M256.7,170.7c11.7,0,23.4-1,34.9-3l5.2,54.6c-23.7,1.6-39.8,1.6-40.1,1.6
	c-0.3,0-16.4-0.1-40.1-1.6l5.2-54.6C233.3,169.7,244.9,170.7,256.7,170.7z M128.8,36.2c-0.5-5.3,1.7-10.5,5.9-13.8
	c4.1-3.5,9.4-5.4,14.8-5.3c2.1,0,4.3,0.3,6.4,0.9c33,8.6,66.8,13.4,100.9,14.2c34.1-0.8,67.9-5.6,100.9-14.2
	c7.4-2,15.3-0.4,21.2,4.5c4.1,3.3,6.3,8.5,5.8,13.8c-5.5,53.5-32.2,117.4-127.9,117.4c-24.9,0.9-49.7-5-71.6-16.9
	c-0.1-0.1-0.2-0.2-0.3-0.2C146.2,113.9,132.5,72.7,128.8,36.2z M188.5,157.7c5.4,2.4,10.9,4.4,16.5,6l-5.4,57.3
	c-5.5-0.5-11.1-1-17-1.7L188.5,157.7z M140.5,491.7c-0.6,1.9-2.3,3.2-4.3,3.1c-1.3,0-2.6-0.6-3.5-1.6c-0.9-1-1.2-2.4-1-3.8
	l37.2-178.2c8.6,3.5,17.3,6.5,26.1,9L140.5,491.7z M301.7,324.4l8.1,25.4H203.6l8.1-25.4C241.3,330.7,272,330.7,301.7,324.4z
	 M192.7,383.9l5.4-17.1h117.1l5.4,17.1H192.7z M381.5,489.3c0.3,1.4-0.1,2.8-1,3.8c-0.8,1.1-2.1,1.7-3.5,1.6c-2,0-3.7-1.3-4.3-3.2
	l-54.6-171.5c8.9-2.6,17.6-5.6,26.1-9L381.5,489.3z M391.2,254.4c-11.3,21.3-38.9,38.6-80,50.2c-35.7,10-73.4,10-109.1,0
	c-41.1-11.6-68.8-28.9-80-50.2c-2.9-5.4-2.4-12,1.2-16.9c3.9-5.4,10.5-8.1,17.1-6.8c38.4,6.4,77.3,9.9,116.3,10.3
	c39-0.5,77.8-3.9,116.3-10.3c6.5-1.2,13.2,1.4,17.1,6.8C393.6,242.4,394.1,249,391.2,254.4z"/></svg></span>
                                                <span class="text">Home & Furniture</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"/></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m352 8h-192a40.045 40.045 0 0 0 -40 40v416a40.045 40.045 0 0 0 40 40h192a40.045 40.045 0 0 0 40-40v-416a40.045 40.045 0 0 0 -40-40zm-41.758 16-4.8 24h-98.883l-4.8-24zm65.758 440a24.027 24.027 0 0 1 -24 24h-192a24.027 24.027 0 0 1 -24-24v-416a24.027 24.027 0 0 1 24-24h25.441l6.714 33.569a8 8 0 0 0 7.845 6.431h112a8 8 0 0 0 7.845-6.431l6.714-33.569h25.441a24.027 24.027 0 0 1 24 24z"/><path d="m208 456h-48a8 8 0 0 0 0 16h48a8 8 0 0 0 0-16z"/><path d="m240 456h-8a8 8 0 0 0 0 16h8a8 8 0 0 0 0-16z"/></svg></span>
                                                <span class="text">Mobile & Tablets</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"/></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 72.371 72.372"><path d="M22.57,2.648c-4.489,1.82-8.517,4.496-11.971,7.949C7.144,14.051,4.471,18.08,2.65,22.568C0.892,26.904,0,31.486,0,36.186 c0,4.699,0.892,9.281,2.65,13.615c1.821,4.489,4.495,8.518,7.949,11.971c3.454,3.455,7.481,6.129,11.971,7.949 c4.336,1.76,8.917,2.649,13.617,2.649c4.7,0,9.28-0.892,13.616-2.649c4.488-1.82,8.518-4.494,11.971-7.949 c3.455-3.453,6.129-7.48,7.949-11.971c1.758-4.334,2.648-8.916,2.648-13.615c0-4.7-0.891-9.282-2.648-13.618 c-1.82-4.488-4.496-8.518-7.949-11.971s-7.479-6.129-11.971-7.949C45.467,0.891,40.887,0,36.187,0 C31.487,0,26.906,0.891,22.57,2.648z M9.044,51.419c-1.743-1.094-3.349-2.354-4.771-3.838c-2.172-6.112-2.54-12.729-1.101-19.01c0.677-1.335,1.447-2.617,2.318-3.845c0.269-0.379,0.518-0.774,0.806-1.142l8.166,4.832c0,0.064,0,0.134,0,0.205c-0.021,4.392,0.425,8.752,1.313,13.049c0.003,0.02,0.006,0.031,0.01,0.049l-6.333,9.93C9.314,51.579,9.177,51.503,9.044,51.419z M33.324,68.206c1.409,0.719,2.858,1.326,4.347,1.82c-6.325,0.275-12.713-1.207-18.36-4.447L33,68.018C33.105,68.085,33.212,68.149,33.324,68.206z M33.274,65.735L17.12,62.856c-1.89-2.295-3.59-4.723-5.051-7.318c-0.372-0.66-0.787-1.301-1.102-1.99l6.327-9.92c0.14,0.035,0.296,0.072,0.473,0.119c3.958,1.059,7.986,1.812,12.042,2.402c0.237,0.033,0.435,0.062,0.604,0.08l7.584,13.113c-1.316,1.85-2.647,3.69-4.007,5.51C33.764,65.155,33.524,65.446,33.274,65.735z M60.15,60.149c-1.286,1.287-2.651,2.447-4.08,3.481c-0.237-1.894-0.646-3.75-1.223-5.563l8.092-15.096c2.229-1.015,4.379-2.166,6.375-3.593c0.261-0.185,0.478-0.392,0.646-0.618C69.374,46.561,66.104,54.196,60.15,60.149z M59.791,40.571c0.301,0.574,0.598,1.154,0.896,1.742l-7.816,14.58c-0.045,0.01-0.088,0.02-0.133,0.026c-4.225,0.789-8.484,1.209-12.779,1.229l-7.8-13.487c1.214-2.254,2.417-4.517,3.61-6.781c0.81-1.536,1.606-3.082,2.401-4.627l16.143-1.658C56.29,34.495,58.163,37.457,59.791,40.571z M56.516,23.277c-0.766,2.023-1.586,4.025-2.401,6.031l-15.726,1.615c-0.188-0.248-0.383-0.492-0.588-0.725c-1.857-2.103-3.726-4.193-5.592-6.289c0.017-0.021,0.034-0.037,0.051-0.056c-0.753-0.752-1.508-1.504-2.261-2.258l4.378-13.181c0.302-0.08,0.606-0.147,0.913-0.18c2.38-0.242,4.763-0.516,7.149-0.654c1.461-0.082,2.93-0.129,4.416-0.024l10.832,12.209C57.314,20.943,56.95,22.124,56.516,23.277z M60.15,12.221c2.988,2.99,5.302,6.402,6.938,10.047c-2.024-1.393-4.188-2.539-6.463-3.473c-0.354-0.146-0.717-0.275-1.086-0.402L48.877,6.376c0.074-0.519,0.113-1.039,0.129-1.563C53.062,6.464,56.864,8.936,60.15,12.221z M25.334,4.182c0.042,0.031,0.062,0.057,0.086,0.064c2.437,0.842,4.654,2.082,6.744,3.553l-4.09,12.317c-0.021,0.006-0.041,0.012-0.061,0.021c-0.837,0.346-1.69,0.656-2.514,1.031c-3.395,1.543-6.705,3.252-9.823,5.301l-8.071-4.775c0.012-0.252,0.055-0.508,0.141-0.736c0.542-1.444,1.075-2.896,1.688-4.311c0.472-1.09,1.01-2.143,1.597-3.172c0.384-0.424,0.782-0.844,1.192-1.254c3.833-3.832,8.363-6.553,13.186-8.162C25.384,4.098,25.358,4.139,25.334,4.182z"/></svg></span>
                                                <span class="text">Sports & Outdoors</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"/></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Football Acc</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Cricket</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Baseball</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 420.8 420.8"><path d="M413.6,204H378c14.8-33.6,13.2-60.8,7.6-79.2c-9.6-32.8-42-68.4-90-68.4c-12.8,0-25.6,2.4-38.8,7.2
			C234,72,218.8,81.2,212,86c-6.8-4.8-21.6-14-44.8-22.4c-13.2-4.8-26.4-7.2-38.8-7.2c-48,0-80.4,35.6-90,68.4
			c-5.6,19.6-7.6,49.2,11.2,86.4H6.4c-3.6,0-6.4,2.8-6.4,6.4c0,3.6,2.8,6.4,6.4,6.4h50.8c2,3.6,4.4,7.2,7.2,10.8
			c41.6,60,132,125.2,148.4,129.2v0.4c0,0,0.4,0,0.8-0.4c0.4,0,0.8,0,1.2,0v-0.4c14-6.8,100.8-62.8,146.4-129.2c4.4-6,8-12,11.2-18
			h42c3.6,0,6.4-2.8,6.4-6.4C420.8,206.4,417.2,204,413.6,204z M349.6,227.6c-42.4,62-120.4,112-137.2,122.8
			c-17.2-10.8-94.8-61.2-137.6-122.8c-0.8-1.2-1.6-2.4-2.4-3.6h58.8c2.4,0,4.8-1.2,6-3.6l26.8-52.8l42,107.6c0.8,2.4,3.6,4,6,4
			c0,0,0,0,0.4,0c2.8,0,5.2-2,6-4.8l36.8-126l19.6,63.6c0.8,2.4,2.8,4,5.2,4.4c2.4,0.4,4.8-0.8,6.4-2.8l15.6-22.8l13.2,22.4
			c1.2,2,3.2,3.2,5.6,3.2h36C354.4,220.4,352,224,349.6,227.6z M364,204h-39.2l-16.4-28c-1.2-2-3.2-3.2-5.6-3.2
			c-2.4,0-4.4,0.8-5.6,2.8l-13.6,20l-22-71.6c-0.8-2.8-3.6-4.4-6.4-4.8c-2.8,0-5.6,2-6.4,4.8l-37.2,128.4l-40.4-103.2
			c-0.8-2.4-3.2-4-5.6-4c-2.8,0-4.8,1.2-6,3.6l-31.6,62H64.4c-16-29.2-20.4-57.2-13.2-82.4c8.4-28.4,36-58.8,77.6-58.8
			c11.2,0,22.8,2.4,34.4,6.4c29.2,10.8,44.8,23.2,45.2,23.2c2.4,2,5.6,2,8,0c0,0,15.6-12.4,45.2-23.2c11.6-4.4,23.2-6.4,34.4-6.4
			c41.2,0,69.2,30.4,77.6,58.8C380.4,151.6,376.8,177.2,364,204z"/></svg></span>
                                                <span class="text">Health</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"/></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 480"><path d="M480,368V64H0v304h184v32h-56v16h240v-16h-72v-32H480z M280,400h-80v-32h80V400z M16,352V80h448v272H16z"/></svg></span>
                                                <span class="text">Radio & TV</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"/></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m352 8h-192a40.045 40.045 0 0 0 -40 40v416a40.045 40.045 0 0 0 40 40h192a40.045 40.045 0 0 0 40-40v-416a40.045 40.045 0 0 0 -40-40zm-41.758 16-4.8 24h-98.883l-4.8-24zm65.758 440a24.027 24.027 0 0 1 -24 24h-192a24.027 24.027 0 0 1 -24-24v-416a24.027 24.027 0 0 1 24-24h25.441l6.714 33.569a8 8 0 0 0 7.845 6.431h112a8 8 0 0 0 7.845-6.431l6.714-33.569h25.441a24.027 24.027 0 0 1 24 24z"></path><path d="m208 456h-48a8 8 0 0 0 0 16h48a8 8 0 0 0 0-16z"></path><path d="m240 456h-8a8 8 0 0 0 0 16h8a8 8 0 0 0 0-16z"></path></svg></span>
                                                <span class="text">Mobile &amp; Tablets</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"></path></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m352 8h-192a40.045 40.045 0 0 0 -40 40v416a40.045 40.045 0 0 0 40 40h192a40.045 40.045 0 0 0 40-40v-416a40.045 40.045 0 0 0 -40-40zm-41.758 16-4.8 24h-98.883l-4.8-24zm65.758 440a24.027 24.027 0 0 1 -24 24h-192a24.027 24.027 0 0 1 -24-24v-416a24.027 24.027 0 0 1 24-24h25.441l6.714 33.569a8 8 0 0 0 7.845 6.431h112a8 8 0 0 0 7.845-6.431l6.714-33.569h25.441a24.027 24.027 0 0 1 24 24z"></path><path d="m208 456h-48a8 8 0 0 0 0 16h48a8 8 0 0 0 0-16z"></path><path d="m240 456h-8a8 8 0 0 0 0 16h8a8 8 0 0 0 0-16z"></path></svg></span>
                                                <span class="text">Mobile &amp; Tablets</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"></path></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m352 8h-192a40.045 40.045 0 0 0 -40 40v416a40.045 40.045 0 0 0 40 40h192a40.045 40.045 0 0 0 40-40v-416a40.045 40.045 0 0 0 -40-40zm-41.758 16-4.8 24h-98.883l-4.8-24zm65.758 440a24.027 24.027 0 0 1 -24 24h-192a24.027 24.027 0 0 1 -24-24v-416a24.027 24.027 0 0 1 24-24h25.441l6.714 33.569a8 8 0 0 0 7.845 6.431h112a8 8 0 0 0 7.845-6.431l6.714-33.569h25.441a24.027 24.027 0 0 1 24 24z"></path><path d="m208 456h-48a8 8 0 0 0 0 16h48a8 8 0 0 0 0-16z"></path><path d="m240 456h-8a8 8 0 0 0 0 16h8a8 8 0 0 0 0-16z"></path></svg></span>
                                                <span class="text">Mobile &amp; Tablets</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"></path></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <a href="#"> <span class="icon"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m352 8h-192a40.045 40.045 0 0 0 -40 40v416a40.045 40.045 0 0 0 40 40h192a40.045 40.045 0 0 0 40-40v-416a40.045 40.045 0 0 0 -40-40zm-41.758 16-4.8 24h-98.883l-4.8-24zm65.758 440a24.027 24.027 0 0 1 -24 24h-192a24.027 24.027 0 0 1 -24-24v-416a24.027 24.027 0 0 1 24-24h25.441l6.714 33.569a8 8 0 0 0 7.845 6.431h112a8 8 0 0 0 7.845-6.431l6.714-33.569h25.441a24.027 24.027 0 0 1 24 24z"></path><path d="m208 456h-48a8 8 0 0 0 0 16h48a8 8 0 0 0 0-16z"></path><path d="m240 456h-8a8 8 0 0 0 0 16h8a8 8 0 0 0 0-16z"></path></svg></span>
                                                <span class="text">Mobile &amp; Tablets</span>
                                                <span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 451.8 451.8"><path d="M354.7,225.9c0,8.1-3.1,16.2-9.3,22.4L151.2,442.6c-12.4,12.4-32.4,12.4-44.8,0c-12.4-12.4-12.4-32.4,0-44.7l171.9-171.9 L106.4,54c-12.4-12.4-12.4-32.4,0-44.7c12.4-12.4,32.4-12.4,44.7,0l194.3,194.3C351.6,209.7,354.7,217.8,354.7,225.9z"></path></svg></span></a>
                                            <div class="mega-manu">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Storage Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Laptop</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">New Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Model</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <ul>
                                                            <li>
                                                                <h6 class="title">Best Computer</h6>
                                                            </li>
                                                            <li><a href="#">Easy chairs</a></li>
                                                            <li><a href="#">Small Sofas</a></li>
                                                            <li><a href="#">Day Beds</a></li>
                                                            <li><a href="#">Footstools</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <nav class="main-manu">
                                <button class="close-btn">
                                    <span></span>
                                    <span></span>
                                </button>
                                <ul>
                                    <li>
                                        <a href="#">Best Selling</a>
                                    </li>
                                    <li>
                                        <a href="#">New Arrivals</a>
                                    </li>
                                    <li>
                                        <a href="#">Trends</a>
                                    </li>
                                    <li>
                                        <a href="#">All Brand</a>
                                    </li>
                                    <li>
                                        <a href="#">All Shop</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Manu Bar End -->
        </div>
        <!-- Main Header End -->
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <!-- Info Footer Start -->
        <div class="info-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-lg-3">
                        <div class="footer-left">
                            <h6>About us</h6>
                            <p>The new hero pieces bring instant fashion credibility. Bright florals clash with camouflage.</p>
                            <h6>Follow us</h6>
                            <ul>
                                <li>
                                    <a href="#"><svg viewBox="0 0 7.611 15.612"><path d="M182.157,756.25v-1.366c0-.683.1-1.073,1.171-1.073h1.366v-2.634H182.45c-2.732,0-3.61,1.268-3.61,3.513v1.659h-1.756v2.634h1.659v7.806h3.415v-7.806H184.4l.293-2.732Z" transform="translate(-177.083 -751.176)"></path></svg></a>
                                </li>
                                <li>
                                    <a href="#"><svg viewBox="0 0 16.438 12.506"><path d="M260.322,753.734a6.3,6.3,0,0,1-1.922.481,3.152,3.152,0,0,0,1.442-1.73,7.937,7.937,0,0,1-2.115.769,3.649,3.649,0,0,0-2.5-.961,3.308,3.308,0,0,0-3.364,3.172,1.436,1.436,0,0,0,.1.673,9.507,9.507,0,0,1-6.921-3.268,2.987,2.987,0,0,0-.481,1.634,3.033,3.033,0,0,0,1.538,2.6,4.036,4.036,0,0,1-1.538-.384h0a3.183,3.183,0,0,0,2.691,3.076,2.676,2.676,0,0,1-.865.1,1.883,1.883,0,0,1-.673-.1A3.269,3.269,0,0,0,248.883,762a6.949,6.949,0,0,1-4.23,1.346h-.769a10.5,10.5,0,0,0,5.191,1.442,9.2,9.2,0,0,0,9.607-8.769c0-.057,0-.113.006-.17v-.385A9.388,9.388,0,0,0,260.322,753.734Z" transform="translate(-243.884 -752.292)"></path></svg></a>
                                </li>
                                <li>
                                    <a href="#"><svg viewBox="0 0 10.802 13.892"><path d="M468.8,905.325a3.953,3.953,0,0,1-1.816-.865c-.346,1.9-.778,3.719-2.162,4.671-.432-2.854.605-5.017,1.038-7.352-.779-1.3.086-3.979,1.73-3.374,2.076.779-1.816,4.93.779,5.449,2.681.519,3.806-4.671,2.162-6.4-2.422-2.422-7.006-.087-6.487,3.46.173.865,1.038,1.125.346,2.336-1.557-.346-1.99-1.557-1.9-3.2a5.178,5.178,0,0,1,4.671-4.757c2.941-.346,5.622,1.038,6.055,3.806.433,3.114-1.3,6.487-4.411,6.228Z" transform="translate(-462.474 -895.239)"></path></svg></a>
                                </li>
                                <li>
                                    <a href="#"><svg viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-2 offset-md-1">
                        <h6>Information</h6>
                        <ul>
                            <li><a href="#">Profile</a></li>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Address</a></li>
                            <li><a href="{{ url('page/cancellation-policy') }}">Cancellation Policy</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <h6>Returns</h6>
                        <ul>
                            <li><a href="#">FAQs</a></li>
                            <li><a href="#">Size Guide</a></li>
                            <li><a href="#">Contact us</a></li>
                            <li><a href="#">Sell with Us</a></li>
                            <li><a href="#">Sitemap</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="footer-right">
                            <h6>Get In Touch</h6>
                            <p>Street addresses: 445 Mount Eden Road, Mount Eden, Auckland - Postcodes: 5022 </p>
                            <div class="payment-gateway">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#"><img src="{{ asset('frontend/img/footer/payment/logo-1.png') }}" alt="img"></a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#"><img src="{{ asset('frontend/img/footer/payment/logo-2.png') }}" alt="img"></a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#"><img src="{{ asset('frontend/img/footer/payment/logo-3.png') }}" alt="img"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Info Footer End -->
        <!-- Main Footer Start -->
        <div class="main-footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="left-link">
                            <ul>
                                <li><a href="#">Status</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="right-text">
                            <p>Copyright © 2021, Template</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="back-to-top" style="display: block;">
                    <span class="icon"><svg viewBox="0 0 451.8 451.8"><path d="M225.8,97.1c8.1,0,16.2,3.1,22.4,9.3l194.3,194.2c12.4,12.4,12.4,32.4,0,44.8c-12.4,12.4-32.4,12.4-44.7,0L225.9,173.6
	L54,345.4c-12.4,12.4-32.4,12.4-44.7,0C-3.1,333-3.1,313,9.3,300.8l194.3-194.3C209.6,100.2,217.8,97.1,225.8,97.1z"></path></svg>
</span>
            </div>
        </div>
        <!-- Main Footer End -->
    </footer>
</div>

<!-- jQuery -->
<script src="{{ asset('frontend/js/vendor/jquery-3.6.0.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }}"></script>

<!-- Popper -->
<script src="{{ asset('frontend/js/vendor/popper.min.js') }}"></script>

<!-- Swiper -->
<script src="{{ asset('frontend/js/vendor/swiper.min.js') }}"></script>

<!-- Slick -->
<script src="{{ asset('frontend/js/vendor/slick.min.js') }}"></script>

<!-- Counter Up -->
<script src="{{ asset('frontend/js/vendor/countdown.js') }}"></script>

<!-- Nice Select -->
<script src="{{ asset('frontend/js/vendor/nice-select.min.js') }}"></script>

<!-- RateIt -->
<script src="{{ asset('frontend/rateit/jquery.rateit.min.js') }}"></script>

<!-- SweetAlert -->
<script src="{{ asset('frontend/js/vendor/sweetalert.min.js') }}"></script>

<!-- Index -->
<script src="{{ asset('frontend/js-seller/index.js') }}"></script>

<script>
    "use strict";

    var xhr = new XMLHttpRequest();

    function buyNow(id){
        var csrf = "{{ csrf_token() }}";
        var qty = $('.input-number').val();
        var color = $('input[name="color"]:checked').val();
        var size = $('input[name="size"]:checked').val();
        $.ajax({
            url: "{{ route('customer.addToCart') }}",
            data: {_token:csrf,id:id,qty:qty,color:color,size:size},
            method: "POST"
        }).done(function(e){
            $("#cart-count").text(e.count);
            swal("{{ __('Good Choice!') }}", e.name+" {{ __('is added to cart') }}", "success");
            $(location).attr("href","{{ url('cart') }}");
        })
    }

    function addToCart(id){
        var csrf = "{{ csrf_token() }}";
        var qty = $('.input-number').val();
        var color = $('input[name="color"]:checked').val();
        var size = $('input[name="size"]:checked').val();
        $.ajax({
            url: "{{ route('customer.addToCart') }}",
            data: {_token:csrf,id:id,qty:qty,color:color,size:size},
            method: "POST"
        }).done(function(e){
            $("#cart-count").text(e.count);
            swal("{{ __('Good Choice!') }}", e.name+" {{ __('is added to cart') }}", "success");
        })
    }

    function removeFromCart(key,id){
        swal({
            title: "{{ __('Really!?') }}",
            text: "{{ __('Are you sure you want remove this form cart?') }}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((whileDelete)=>{
            if(whileDelete){
                var csrf = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ route('customer.removeFromCart') }}",
                    data: {_token:csrf,key:key,id:id},
                    type: "POST"
                }).done(function(e){
                    swal("{{ __('Poof! Your item has been removed!') }}", {
                        icon: "success",
                    }).then(value => {
                        $("#grand-total").text(e.subTotal);
                        $("#cart-count").text(e.count);
                        $("#cart-row-"+key).remove();
                    });
                })
            }else{
                swal("{{ __('Bravo! Your item is safe.') }}");
            }
        })
    }

    function updateCart(elem){
        var key = elem.data('key');
        var id = elem.data('id');
        var qty = elem.val();

        if(qty == 0){
            xhr.abort();
        }

        if(isNaN(qty)){
            qty = elem.closest('tr').find('.qty').val();
            if(elem.val() === '+'){
                qty = parseInt(qty) + 1;
            }else{
                qty = parseInt(qty) - 1;
            }
        }
        var csrf = "{{ csrf_token() }}";

        if(xhr !== 'undefined'){
            xhr.abort(); //stop existing ajax request if new request has been sent to server
        }
        if(qty > 0){
            xhr = $.ajax({
                url: "{{ route('customer.updateCart') }}",
                data: {_token:csrf,key:key,id:id,qty:qty},
                method: "POST",
                beforeSend:function(){
                    $(".checkout-btn a").css('pointer-events','none');
                }
            }).done(function(e){
                console.log(e.subTotal);
                $("#grand-total").text(e.subTotal);
                console.log(elem.closest('tr').find('.total'));
                elem.closest('tr').find('.total').text(e.productTotal);
                $("#cart-count").text(e.count);
                $(".checkout-btn a").css('pointer-events','all');
            })
        }
    }

    function addToWishlist(id){
        if("{{auth()->guard('customer')->check()}}"){
            var csrf = "{{ csrf_token() }}"
            $.ajax({
                url: "{{ route('customer.addToWishlist') }}",
                data: {_token:csrf,id:id},
                method: "POST"
            }).done(function(e){
                if(e.status === 'exists'){
                    $("#wishlist-count").text(e.count);
                    swal("{{ __('Hey!') }}", e.name+" {{ __('is already in your wishlist') }}","warning");
                }else{
                    $("#wishlist-count").text(e.count);
                    swal("{{ __('Great!') }}", e.name+" {{ __('added to your wishlist') }}",e.status);
                }
            });
        }else{
            swal("{{ __('Please!') }}","{{ __('Login to add product to your wishlist') }}","warning");
        }
    }

    function wishToCart(id){
        var csrf = "{{ @csrf_token() }}";
        $.ajax({
            url: "{{ route('customer.wishToCart') }}",
            data: {_token:csrf,id:id},
            type: "POST",
        }).done(function(e){
            $("#cart-count").text(e.count);
            $("#wishlist-count").text(e.wishCount);
            $("#wish-"+id).remove();
            swal("{{ __('Good Choice!') }}", e.name+" {{ __('is added to cart') }}", "success");
        })
    }

    function removeFromWishlist(id){
        var csrf = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('customer.removeFromWishlist') }}",
            data: {_token:csrf,id:id},
            type: "POST"
        }).done(function(e){
            console.log($(this));
            $("#wish-"+id).remove();
            $("#wishlist-count").text(e.count);
            swal("{{ __('Hash!') }}",e.name+"{{ __(' is removed from your wishlist!') }}","warning");
        });
    }

    function changeCurrency(id){
        var csrf = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('frontend.change-currency') }}",
            data: {_token:csrf,id:id},
            type: "POST",
        }).done(function(e){
            $("#cur-symbol").text(e.symbol);
            $("#cur-title").text(e.name);
            location.reload();
        })
    }

    function changeLanguage(id){
        var csrf = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('frontend.change-language') }}",
            data: {_token:csrf,id:id},
            type: "POST",
        }).done(function(e){
            console.log(e);
            location.reload();
        })
    }

    function ajaxFilter(page,selector,id){
        var csrf = "{{ csrf_token() }}";
        var category = $('input[name="category"]:checked').val();
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
            url: "{{ route('frontend.ajax-filter') }}",
            data: {_token:csrf,category:category,color:color,size:size,brand:brand,seller:seller,min:min,max:max,sorting:sorting,page:page},
            type: 'post',
            beforeSend: function(){
                $("#product-loader").show();
            },
        }).done(function(e){
            $(".breadcrumb-manu h3").text($('input[name="category"]:checked').data('name'));
            $("#product-area").html(e);
            var url = "{{url()->current()}}"+"?page="+page;
            window.history.pushState("", "", url);
            $("#product-loader").hide()
            $("#sorting").change(function(){
                ajaxFilter();
            })
        })
    }

    $(document).on('click','.pagination a',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var page = url.split('page=')[1];
        window.history.pushState("", "", url);
        ajaxFilter(page);
    })

    function dealOfTheWeek(tab){
        $.ajax({
            url: "{{ route('deal-of-the-week') }}",
            data: {_token:"{{csrf_token()}}",tab:tab},
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
            suggestUrl: '{{ route('frontend.suggest',['query'=>'']) }}', // the URL that provides the data for the suggest
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
            noSuggests: '<b>{{ __('We haven\'t found anything for you') }}, <u>{{ __('sooorrryyy') }}</u></b>',
            emptyQuerySuggests: {
                "suggests":{
                    "Products":[
                            @foreach(uniBoxSuggestions() as $suggestion)
                        {"name":"{{$suggestion->name}}","image":"{{ asset('uploads/products/galleries').'/'.$suggestion->images->first()->image }}","id":"{{ $suggestion->id }}}","link":"{{ route('product',$suggestion->slug) }}"},
                        @endforeach
                    ]
                }
            },
            //maxWidth: 400 // the maximum width of the suggest box, default: as wide as the input box
        };

        // apply the settings to an input that should get the unibox
        // apply to multiple boxes
        boxes = sxQuery(".s").unibox(settings);
    });
</script>
</body>

</html>
