
/*
*
*   MISC FUNCTIONS
*   ------------------------------------------------
*   This file includes any additional functionality added to the site with javascript 
*   and does NOT include any integration with the API
*
*/

(function($){

	$(document).ready(function () {

		var templateDirectory = $("#sf-option-params").data("template-directory");
		var stylesheetDirectory = $("#sf-option-params").data("stylesheet-directory");

		if ( $(".hr-bars, .spb_divider").length > 0 ) {
			$(".hr-bars, .spb_divider").each(function () {
				$(this).append('<div class="hr-bars-icon"><img src="' + stylesheetDirectory + '/images/hr-bars@2x.png" height=58 width=58 /></div>');
			});
		}

        /* TESTING PRINT CHART RESIZE FUNCTIONALITY */
        $("#print-reportcard").click(function(e) {
            e.preventDefault();
            var chart = $('.highchart');
            //var origChartHeight = [];
            chart.each(function(){
                //origChartHeight.push($(this).find('.highcharts-container').height());
                var currentChart = $(this).highcharts();
                if( $(this).hasClass('full-width-chart') && !$(this).hasClass('race-pie-chart')){
                    currentChart.setSize(780, 300, false);
                } else if($(this).hasClass('race-pie-chart')){
                    currentChart.setSize(780, 350, false);
                } else {
                    currentChart.setSize(350, 300, false);
                    currentChart.container.parentNode.style.fontSize = '12px';
                }
            });
            window.print();
            setTimeout(function() {
                var chart = $('.highchart');
                chart.each(function(){
                var currentChart = $(this).highcharts();
                if( $(this).hasClass('full-width-chart')){
                    currentChart.setSize(780, 400, false);
                } else {
                    currentChart.setSize(555, 400, false);
                }
            });
            }, 1000);
        });

        /////////////////////////////////////

		// SWAP SOCIAL ICONS
		function swapSocialIcons() {
			if ( $("ul.social-icons").length > 0 && $("body:not(.remove-styles)").length > 0 ) {
				$("ul.social-icons").each(function () {
					$(this).find("li").each(function () {
						if ( $(this).hasClass("facebook") ) {
							$(this).find("a").html('<img class="inject-me" data-src="' + stylesheetDirectory + '/images/social-icons/social-icon-facebook.svg" data-fallback="' + stylesheetDirectory + '/images/social-icons/social-icon-facebook.png" />');
							$(this).addClass("has-svg");
						} else if ( $(this).hasClass("twitter") ) {
							$(this).find("a").html('<img class="inject-me" data-src="' + stylesheetDirectory + '/images/social-icons/social-icon-twitter.svg" data-fallback="' + stylesheetDirectory + '/images/social-icons/social-icon-twitter.png" />');
							$(this).addClass("has-svg");
						} else if ( $(this).hasClass("youtube") ) {
							$(this).find("a").html('<img class="inject-me" data-src="' + stylesheetDirectory + '/images/social-icons/social-icon-youtube.svg" data-fallback="' + stylesheetDirectory + '/images/social-icons/social-icon-youtube.png" />');
							$(this).addClass("has-svg");
						} else if ( $(this).hasClass("instagram") ) {
							$(this).find("a").html('<img class="inject-me" data-src="' + stylesheetDirectory + '/images/social-icons/social-icon-instagram.svg" data-fallback="' + stylesheetDirectory + '/images/social-icons/social-icon-instagram.png" />');
							$(this).addClass("has-svg");
						}
					});
				});
			}
		}
		swapSocialIcons();

      	// SPB ELEMENT CALC EXAMPLES TOGGLE
        if ( $(".spb_calc_examples").length > 0 ) {
        	$(".spb_calc_examples").each(function () {
        		var $container = $(this);
        		$container.find('select[name="calc-example-schools"]').on("change", function (e) {
        			e.preventDefault();
        			$container.find(".school-calc-type").hide();
        			$container.find(".school-type-" + $(this).val()).show();
        			return false;
        		});
        	});
        }

        // SCHOOL GRADE COMPONENT
        if ( $("#school-grade-components").length > 0 ) {
        	if ( $(".component-achievement .spb-asset-content h3").length > 0 ) {
        		$(".component-achievement .spb-asset-content h3").prepend('<div class="icon-component icon-component-achievement" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-component-achievement.svg" data-fallback"' + stylesheetDirectory + '/images/icon-component-achievement.png" /></div>')
        	}
        	if ( $(".component-learning-gains .spb-asset-content h3").length > 0 ) {
        		$(".component-learning-gains .spb-asset-content h3").prepend('<div class="icon-component icon-component-learning-gains" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-component-learning-gains.svg" data-fallback"' + stylesheetDirectory + '/images/icon-component-learning-gains.png" /></div>')
        	}
        	if ( $(".component-learning-gains-low25 .spb-asset-content h3").length > 0 ) {
        		$(".component-learning-gains-low25 .spb-asset-content h3").prepend('<div class="icon-component icon-component-learning-gains-low-25" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-component-learning-gains-low-25.svg" data-fallback"' + stylesheetDirectory + '/images/icon-component-learning-gains-low-25.png" /></div>')
        	}
        	if ( $(".component-middle-acceleration .spb-asset-content h3").length > 0 ) {
        		$(".component-middle-acceleration .spb-asset-content h3").prepend('<div class="icon-component icon-component-middle-acceleration" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-component-middle-acceleration.svg" data-fallback"' + stylesheetDirectory + '/images/icon-component-middle-acceleration.png" /></div>')
        	}
        	if ( $(".component-high-acceleration .spb-asset-content h3").length > 0 ) {
        		$(".component-high-acceleration .spb-asset-content h3").prepend('<div class="icon-component icon-component-high-acceleration" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-component-high-acceleration.svg" data-fallback"' + stylesheetDirectory + '/images/icon-component-high-acceleration.png" /></div>')
        	}
        	if ( $(".component-grad-rate .spb-asset-content h3").length > 0 ) {
        		$(".component-grad-rate .spb-asset-content h3").prepend('<div class="icon-component icon-component-grad-rate" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-component-grad-rate.svg" data-fallback"' + stylesheetDirectory + '/images/icon-component-grad-rate.png" /></div>')
        	}
        }

        /* START INJECT SVG IMAGES */
    		var mySVGsToInject = document.querySelectorAll('img.inject-me');
    		var injectorOptions = {};
    		SVGInjector(mySVGsToInject, injectorOptions, function (totalSVGsInjected) {

    			// AFTER SVGs HAVE BEEN CONVERTED

    		});
        /* END INJECT SVG IMAGES */

	});

})(jQuery);
