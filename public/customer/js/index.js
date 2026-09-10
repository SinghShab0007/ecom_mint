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

    //* nice select.js
    function nice_Select() {
        if ($('.nice-select').length) {
            $('.nice-select').niceSelect();
        }
    }

    // char js start


    mtChart();
    function mtChart(){
        if ($('#timeline-chart').length){
            let statiStics = $("#timeline-chart");
            let statiSticsValu = new Chart(statiStics, {
                type: 'line',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '1', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'],
                    datasets: [{
                        borderWidth: 1,
                        label: "#3190FF",
                        backgroundColor: "#3190FF",
                        borderColor: "#3190FF",
                        // blue color
                        // data: [1, 2, 3, 4, 3, 2, 5, 4, 3, 1, 3, 2, 5, 6, 6, 7, 5, 3, 4, 2, 4, 5, 8, 6, 4, 6, 2, 4, 5, 2],
                        data: [10, 12, 13, 12, 15, 13, 15, 19, 18, 23, 26, 28, 33, 34, 36, 40, 37, 33, 34, 35, 36, 35, 36, 37, 35, 34, 35, 32, 31, 30],
                    }, {
                        label: "#FE4F4F",
                        backgroundColor: "#FE4F4F",
                        borderWidth: 1,
                        borderColor: "#FE4F4F",
                        // red color
                        // data: [3, 3, 2, 3, 2, 3, 4, 3, 4, 3, 4, 5, 6, 5, 7, 8, 7, 6, 5, 4, 3, 2, 3, 2, 4, 5, 6, 7, 8, 8],
                        data: [11, 12, 14, 16, 19, 18, 20, 25, 28, 30, 28, 26, 24, 25, 22, 20, 22, 24, 25, 26, 25, 27, 28, 30, 32, 31, 30, 32, 35, 38],
                    }, {
                        borderWidth: 1,
                        label: "#FFDB1D",
                        backgroundColor: "#FFDB1D",
                        borderColor: "#FFDB1D",
                        // yellowColor
                        // data: [1, 2, 3, 4, 3, 2, 5, 4, 3, 1, 3, 2, 5, 6, 6, 7, 5, 3, 4, 2, 4, 5, 8, 6, 4, 6, 2, 4, 5, 2],
                        data: [7, 6, 5, 8, 6, 8, 6, 7, 7, 8, 10, 9, 8, 8, 9, 11, 9, 10, 12, 11, 10, 9, 11, 9, 11, 10,13, 12, 14, 15],
                    }],
                },
                options: {
                    responsive: true,
                    interaction: {
                        // mode: 'index',
                        intersect: false,
                    },
                    elements: {
                        point:{
                            radius: 0,
                        }
                    },
                    tooltips: {
                        displayColors: true,
                    },
                    plugins: {
                        legend: {
                            display: false,
                            //   position: 'bottom',
                        },
                        title: {
                            display: true,
                        }
                    },
                    scales: {

                        x: {
                            display: false,
                            stacked: true,
                        },
                        // y: {
                        // 	stacked: true
                        // }
                        y: {
                            beginAtZero: true
                        },
                    },
                }
            });




            // in inMonths round canvas start

            Chart.defaults.elements.arc.roundedCornersFor = {
                "start": [0,1,2,3],
                "end": 3
            };
            Chart.defaults.datasets.doughnut.cutout = '65%';
            let inMonths = $("#ShareProfit");
            let inMonthsValu = new Chart(inMonths, {
                type: 'doughnut',
                data: {
                    labels: ["MONEY", "INCOME", "SPECIALTY", "STOCK"],
                    datasets: [{
                        label: "Test",
                        borderWidth: 0,
                        data: [47, 19, 71, 51],
                        backgroundColor: [
                            "#FFDB1D",
                            "#2CE78D",
                            "#3190FF",
                            "#FE4F4F",
                        ],
                        // borderColor: [
                        //     "rgba(250, 139, 12, 1)",
                        //     "rgba(19, 142, 255, 1)",
                        //     "rgba(62, 187, 3, 1)",
                        //     "rgba(95, 99, 242, 1)",
                        // ],
                    }]
                },



                plugins: [{
                    afterUpdate: function(chart) {
                        if (chart.options.elements.arc.roundedCornersFor !== undefined) {
                            var arcValues = Object.values(chart.options.elements.arc.roundedCornersFor);

                            arcValues.forEach(function(arcs) {
                                arcs = Array.isArray(arcs) ? arcs : [arcs];
                                arcs.forEach(function(i) {
                                    var arc = chart.getDatasetMeta(0).data[i];
                                    arc.round = {
                                        x: (chart.chartArea.left + chart.chartArea.right) / 2,
                                        y: (chart.chartArea.top + chart.chartArea.bottom) / 2,
                                        radius: (arc.outerRadius + arc.innerRadius) / 2,
                                        thickness: (arc.outerRadius - arc.innerRadius) / 2,
                                        backgroundColor: arc.options.backgroundColor
                                    }
                                });
                            });
                        }
                    },
                    afterDraw: (chart) => {

                        if (chart.options.elements.arc.roundedCornersFor !== undefined) {
                            var {
                                ctx,
                                canvas
                            } = chart;
                            var arc,
                                roundedCornersFor = chart.options.elements.arc.roundedCornersFor;
                            for (var position in roundedCornersFor) {
                                var values = Array.isArray(roundedCornersFor[position]) ? roundedCornersFor[position] : [roundedCornersFor[position]];
                                values.forEach(p => {
                                    arc = chart.getDatasetMeta(0).data[p];
                                    var startAngle = Math.PI / 2 - arc.startAngle;
                                    var endAngle = Math.PI / 2 - arc.endAngle;
                                    ctx.save();
                                    ctx.translate(arc.round.x, arc.round.y);
                                    ctx.fillStyle = arc.options.backgroundColor;
                                    ctx.beginPath();
                                    if (position == "start") {
                                        ctx.arc(arc.round.radius * Math.sin(startAngle), arc.round.radius * Math.cos(startAngle), arc.round.thickness, 0, 2 * Math.PI);
                                    } else {
                                        ctx.arc(arc.round.radius * Math.sin(endAngle), arc.round.radius * Math.cos(endAngle), arc.round.thickness, 0, 2 * Math.PI);
                                    }
                                    ctx.closePath();
                                    ctx.fill();
                                    ctx.restore();
                                });

                            }
                        }
                    }
                }],


                options: {
                    responsive: true,
                    tooltips: {
                        displayColors: true,
                        zIndex: 999999,
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            display: false,
                            stacked: true,
                        },
                        y: {
                            display: false,
                            stacked: true,
                        }
                    },
                },

            });
        }
    }

    sideManu();
    productItemSearch();
    counterUp();
	nice_Select();

})(jQuery);



