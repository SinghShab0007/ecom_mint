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
    productItemSearch()
    counterUp()
    countDown()

    /*====== Active Plugins ======

        1 Side Manu

        2 Product Item Search

        3 Counter Up

        4 Count Down

    =============================*/


    /*=====================
        1 Side Manu
    =======================*/

    function sideManu() {

        let manuStor = $(".side-bar").html();

        $(".side-bar").html("<div class='overlay'></div>" + manuStor);
        $(".content-heaader .side-btn").on("click ", function() {
            $(".side-bar,main,footer").toggleClass("active");
        });
        $(".side-bar .close-btn, .side-bar .overlay").on("click ", function() {
            $(".side-bar,main,footer").toggleClass("active");
        });

        $("li>ul").toggleClass("side-bar-submenu");

        let animationSpeed = 300;

        let subMenuSelector = ".side-bar-submenu";

        $('.side-bar-manu > ul').on('click', 'li a', function(e) {
            let $this = $(this);
            let checkElement = $this.next();

            if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
                checkElement.slideUp(animationSpeed, function() {
                    checkElement.removeClass('menu-open');
                });
                checkElement.parent("li").removeClass("active");
            }

            //If the menu is not visible
            else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
                //Get the parent menu
                let parent = $this.parents('ul').first();
                //Close all open menus within the parent
                let ul = parent.find('ul:visible').slideUp(animationSpeed);
                //Remove the menu-open class from the parent
                ul.removeClass('menu-open');
                //Get the parent li
                let parent_li = $this.parent("li");

                //Open the target menu and add the menu-open class
                checkElement.slideDown(animationSpeed, function() {
                    //Add the class active to the parent li
                    checkElement.addClass('menu-open');
                    parent.find('li.active').removeClass('active');
                    parent_li.addClass('active');
                });
            }
            //if this isn't a link, prevent the page from being redirected
            if (checkElement.is(subMenuSelector)) {
                e.preventDefault();
            }
        });
    }

    /*==========================
        2 Product Item Search
    ============================*/
    function productItemSearch() {
        $(".pro-items .hover-btn .items-search .search-open").on("click ", function() {
            $(".pro-items .hover-btn").addClass("active");
        });
        $(".pro-items .hover-btn .close-from").on("click ", function() {
            $(".pro-items .hover-btn").removeClass("active");
        });
    }

    /*=====================
        3 Counter Up
    =======================*/
    function counterUp() {
        $(".counter").counterUp({
            delay: 10,
            time: 1000
        });
    }
    /*=====================
        4 Count Down
    =======================*/
    function countDown() {
        $(".countdown").countdown({
            year: 2021,
            month: 7,
            day: 6,
            hour: 4,
            minute: 45,
            second: 23,

        });
    }

})(jQuery);