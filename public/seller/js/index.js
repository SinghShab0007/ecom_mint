/*
Theme Name: Mshop Dashboard Teamplate
Theme URI:
Developed by: Abdullah Al Numan
Version: 1.0
License:
Tags:
*/


(function($) {
    "use strict";
    sideManu()
    counterUp()

    /*====== Active Plugins ======

        1 Side Manu

        2 Counter Up

    =============================*/



    /*=====================
        1 Side Manu
    =======================*/

    function sideManu() {
        $(".content-heaader .side-btn").on("click ", function() {
            $(".side-bar,main,footer").toggleClass("active");
        });
        $(".side-bar .close-btn").on("click ", function() {
            $(".side-bar,main,footer").toggleClass("active");
        });

        $("li>ul").toggleClass("side-bar-submenu");
        $("ul>li>a").click(function() {
            $(".side-bar-submenu").slideUp(200);
            if (
                $(this)
                    .parent()
                    .hasClass("active")
            ) {
                $("ul>li").removeClass("active");
                $(this)
                    .parent()
                    .removeClass("active");
            } else {
                $("ul>li").removeClass("active");
                $(this)
                    .next(".side-bar-submenu")
                    .slideDown(200);
                $(this)
                    .parent()
                    .addClass("active");
            }
        });

    }


    /*=====================
        2 Counter Up
    =======================*/
    function counterUp() {
        $(".counter").counterUp({
            delay: 10,
            time: 1000
        });
    }



})(jQuery);
