


(function ($) {
    "use strict";


    // Sticky Js
    (function () {
        var nav = $('.maan-menu-nav-sec');
        var scrolled = false;
        $(window).on('scroll', function () {
            if (120 < $(window).scrollTop() && !scrolled) {
                nav.addClass('sticky_menu animated fadeInDown').animate({ 'margin-top': '0px' });
                scrolled = true;
            }
            if (90 > $(window).scrollTop() && scrolled) {
                nav.removeClass('sticky_menu animated fadeInDown').css('margin-top', '0px');
                scrolled = false
            }
        });
    }());


    // Appointments edit modal js
    function AppointmentsModal(){
        $('.action .edit').on('click', function () {
            $('.maan-modal-form').toggleClass('active');

            $(".modal-close").on('click',function(){
                $(".maan-modal-form").removeClass("active");
            });
        });
    };
    AppointmentsModal();


    // sidebar
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
            $(".sidebar-close").on('click',function(){
                $("#sidebar").removeClass("active");
                $("#content").removeClass("active");
            });
        });

        $('.more-button,.body-overlay').on('click', function () {
            $('#sidebar,.body-overlay').toggleClass('show-nav');
        });

    });

    // niceSelect start
    $(document).ready(function () {
        $('select').niceSelect();
    });
    // niceSelect end



    // counter start
    var counter = $('.timer');
    if(counter.length) {
        $('.timer').counterUp({
            delay: 20,
            time: 1500
        });
    }
    // counter end

})(jQuery);
