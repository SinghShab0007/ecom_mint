/*
Theme Name: POROSKART Ecommerce HTML5 Template
Developed by: Abdullah Al Numan 
Version: 2.0
License: 
Tags: 
*/


(function($) {
    "use strict";
    manuBtn()
    bgImg()
    stickyManu()
    bannerSlider()
    brandLogo()
    shopDetails()
    quantity()
    niceSelectOption()
    formAnimation()
    countDown()
    bottomTop()

    /*====== Active Plugins ======

        1 Manu Btn

        3 Bg Img

        4 Sticky Manu

        5 Banner Slider

        6 Brand Logo

        7 Shop Details

        8 Quantity
        
        9 Nice Select Option

        10 Form Animation

        11 Count Down

        12 Bottom Top

    =============================*/

    /*=====================
        1 Manu
    =======================*/
    function manuBtn() {
        let storFile = $(".manu-bar").html();
        $(".manu-bar").html(storFile + "<span class='overlay'></span>")
        $(".main-header .menu-btn").on("click", function() {
            $(this).addClass("active");
            $(".manu-bar").addClass("active");
            $(".manu-bar .overlay").addClass("active");
        });

        $(".manu-bar .close-btn ,.manu-bar .overlay").on("click", function() {
            $(".manu-bar .overlay").removeClass("active");
            $(".main-header .menu-btn").removeClass("active");
            $(".manu-bar").removeClass("active");
        });

    }


    /*=====================
        2 Bg Img
    =======================*/

    function bgImg() {
        $("[data-background]").each(function() {
            $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
        });
    }
    /*=====================
        3 Sticky Manu
    =======================*/

    function stickyManu() {
        let yourHeader = $(".top-bar").height();
        let yourNavigation = $(".main-header ,.top-bar");
        let stickyDiv = "sticky";
        $(window).scroll(function() {
            if ($(this).scrollTop() > yourHeader) {
                yourNavigation.addClass(stickyDiv);
            } else {
                yourNavigation.removeClass(stickyDiv);
            }
        });
        let storFile = $(".manu-bar .category-manu .category-list").html();
        $(".banner .side-mega-manu").html(storFile)
    }

    /*======================
        4 Banner Slider
    ======================*/
    function bannerSlider() {
        let menu = ["Power Thursday", "Prime Mall", "Best Deal", "Mobile & Tab", "Happy Shop"]
        let mySwiper = new Swiper(".banner-slider", {
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 0,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                renderBullet: function(index, className) {
                    return '<div class="' + className + '">' + (menu[index]) + '</div>';
                },
            },
        });

        $('.swiper-pagination-bullet').hover(function() {
            $(this).trigger("click");
        });
    }
    /*======================
        5 Brand Logo
    ======================*/
    function brandLogo() {
        $(".brand-logo .all-logos").slick({
            autoplay: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplaySpeed: 4000,
            speed: 800,
            centerMode: true,
            centerPadding: '0px',
            infinite: true,
            pauseOnFocus: false,
            pauseOnHover: false,
            dots: false,
            arrows: false,
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 5,
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 2,
                    }
                }
            ]
        });
    }

    /*======================
        6 Shop Details
    ======================*/
    function shopDetails() {
        $(".shop-details .product-big-img").slick({
            autoplay: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplaySpeed: 4000,
            speed: 800,
            infinite: true,
            pauseOnFocus: false,
            pauseOnHover: false,
            dots: false,
            arrows: false,
            asNavFor: ".shop-details .product-small-img, .multivendor-sm-img"
        });
        $(".shop-details .product-small-img").slick({
            autoplay: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplaySpeed: 4000,
            speed: 800,
            centerMode: true,
            centerPadding: '0px',
            infinite: true,
            vertical: true,
            focusOnSelect: true,
            pauseOnFocus: false,
            pauseOnHover: false,
            dots: false,
            arrows: false,
            asNavFor: ".shop-details .product-big-img, .multivendor-sm-img",
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        vertical: true,
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        vertical: false,
                        slidesToShow: 3,
                    }
                }
            ]
        });
        $(".shop-details .multivendor-sm-img").slick({
            autoplay: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplaySpeed: 4000,
            speed: 800,
            centerMode: true,
            centerPadding: '0px',
            infinite: true,
            vertical: false,
            focusOnSelect: true,
            pauseOnFocus: false,
            pauseOnHover: false,
            dots: false,
            arrows: false,
            asNavFor: ".shop-details .product-big-img",
            responsive: [{
                    breakpoint: 1200,
                    settings: {
                        vertical: false,
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        vertical: false,
                        slidesToShow: 4,
                    }
                }
            ]
        });
    }

    /*=====================
        7 Quantity
    =======================*/

    function quantity() {
        let incrementPlus = $(".plus").click(function() {
            let $n = $(this)
                .parent(".quantity")
                .parent(".table-quantity form ,.product-quantity form")
                .find(".input-number");

            $n.val(Number($n.val()) + 1);
        });

        let incrementMinus = $(".minus").click(function() {
            let $n = $(this)
                .parent(".quantity")
                .parent(".table-quantity form ,.product-quantity form")
                .find(".input-number");
            let amount = Number($n.val());
            if (amount > 1) {
                $n.val(amount - 1);
            }
        });
    }

    /*==========================
        8 Nice Select Option
    ============================*/

    function niceSelectOption() {
        $("select").niceSelect();
    }


    /*=======================
        9 Form Animation
    =======================*/
    function formAnimation() {

        function checkForInput(element) {
            let $label = $(element).siblings(".input-group span.label");

            if ($(element).val().length > 0) {
                $label.addClass("valu-push");
            } else {
                $label.removeClass("valu-push");
            }
        }
        $(".input-group input, .input-group textarea").each(function() {
            checkForInput(this);
        });
        $(".input-group input, .input-group textarea").on('change keyup', function() {
            checkForInput(this);
        });

        $(".mypass .show-pass").click(function() {
            $(this).toggleClass("eye-open");
            let myPass = document.getElementById("myPass");
            if (myPass.type === "password") {
                myPass.type = "text";
            } else {
                myPass.type = "password";
            }
        });
        
        $(".newpass .show-pass").click(function() {
            $(this).toggleClass("eye-open");
            let myPass = document.getElementById("newPass");
            if (newPass.type === "password") {
                newPass.type = "text";
            } else {
                newPass.type = "password";
            }
        });
    }

    /*==================
        10 Count Down
    ==================*/
    function countDown() {
        $(".countdown").countdown({
            year: 2021,
            month: 9,
            day: 27,
            hour: 1,
            minute: 0,
            second: 0,
        });
    }

    /*=====================
        13 Bottom Top
    =====================*/
    function bottomTop() {
        let backtoTop = $('.back-to-top')
        $(window).on("scroll", function() {
            if ($(window).scrollTop() > 800) {
                backtoTop.fadeIn(800);
            } else {
                backtoTop.fadeOut(800);
            }
        });
        backtoTop.fadeOut();

        $(".back-to-top").on("click", function() {
            $("html,body").animate({
                scrollTop: 0
            }, 600);
        })
    }


})(jQuery);