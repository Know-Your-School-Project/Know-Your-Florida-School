
/*
*
*	SCHOOL REPORT CARD FUNCTIONS
*	------------------------------------------------
*	This file includes all additional functionality added to school report cards with javascript
*	and does NOT include any integration with the API
*
*/

(function($){

	$(document).ready(function () {

		var templateDirectory = $("#sf-option-params").data("template-directory");
		var stylesheetDirectory = $("#sf-option-params").data("stylesheet-directory");

		/* START GRAPH TOGGLE AND ANCHORING FUNCTIONALITY */
			if ( $("body.page-id-42 select.data-toggle").length > 0 ) {
				$("body.page-id-42 select.data-toggle").each(function () {
					$(this).on("change",function () {
						$(this).closest("section.row").find(".exhibit-group").hide();
						var exhibit = $(this).prop("name");
						var group = $(this).prop("value");
						if ( $("#exhibit-" + exhibit + "-" + group).length > 0 ) {
							$(".exhibit-group#exhibit-" + exhibit + "-" + group).show();
						}
					});
				});
			}

			if ( $("body.page-id-42 select.data-toggle-subgroup").length > 0 ) {
				$("body.page-id-42 select.data-toggle-subgroup").each(function () {
					$(this).on("change",function () {
						$(this).closest(".spb-asset-content").find(".exhibit-group").hide();
						var exhibit = $(this).prop("name");
						var group = $(this).prop("value");
						if ( $("#exhibit-performance-" + group).length > 0 ) {
							$(".exhibit-group#exhibit-performance-" + group).show();
						}
						/* START EVENT TRACKING - CHANGED SUBGROUP */
						if ( $(this).val().indexOf("ela-aggregate-") > -1 ) {
							ga('send', 'event', 'School Report Card', 'Selected English Language Arts Aggregate - ' + $(this).val().replace('ela-aggregate-', '') + '', 'School ID: ' + $(".page.type-page").data("schoolid"));
						} else if ( $(this).val().indexOf("math-aggregate-") > -1 ) {
							ga('send', 'event', 'School Report Card', 'Selected Mathematics Aggregate - ' + $(this).val().replace('math-aggregate-', '') + '', 'School ID: ' + $(".page.type-page").data("schoolid"));
						} else if ( $(this).val().indexOf("sci-aggregate-") > -1 ) {
							ga('send', 'event', 'School Report Card', 'Selected Science Aggregate - ' + $(this).val().replace('sci-aggregate-', '') + '', 'School ID: ' + $(".page.type-page").data("schoolid"));
						} else if ( $(this).val().indexOf("ela-subgroup-") > -1 ) {
							ga('send', 'event', 'School Report Card', 'Selected English Language Arts Subgroup - ' + $(this).val().replace('ela-subgroup-', '') + '', 'School ID: ' + $(".page.type-page").data("schoolid"));
						} else if ( $(this).val().indexOf("math-subgroup-") > -1 ) {
							ga('send', 'event', 'School Report Card', 'Selected Mathematics Subgroup - ' + $(this).val().replace('math-subgroup-', '') + '', 'School ID: ' + $(".page.type-page").data("schoolid"));
						} else if ( $(this).val().indexOf("sci-subgroup-") > -1 ) {
							ga('send', 'event', 'School Report Card', 'Selected Science Subgroup - ' + $(this).val().replace('sci-subgroup-', '') + '', 'School ID: ' + $(".page.type-page").data("schoolid"));
						}
						/* END EVENT TRACKING */
					});
				});
			}

			if ( $("body.page-id-42 .spb_button_element.view-grade-history .sf-button").length > 0 && $("#school-reportcard-school-grade-history").length > 0 ) {
				$("#school-reportcard-school-grade-history").hide();
			}

			if ( $("body.page-id-42 .data-anchor").length > 0 ) {
				$("body.page-id-42 .data-anchor").each(function () {
					$(this).click(function (e) {
						var anchor = $(this).prop("href").split('#')[1];
						if ( $('#school-reportcard-about-school select[name="exhibits"]').length > 0 && anchor.indexOf("exhibit-exhibits-") > -1 ) {
							e.preventDefault();
							anchor = anchor.replace("exhibit-exhibits-", "");
							$('#school-reportcard-about-school select[name="exhibits"]').val(anchor).trigger('change');
					        $('html, body').stop().animate({
								scrollTop: ( Number( $('#school-reportcard-about-school select[name="exhibits"]').offset().top ) - $("#header-sticky-wrapper.sticky-wrapper").height() - $("#wpadminbar").height() - 30 ) + "px"
							}, 1000, 'easeInOutExpo', function() {
								SWIFT.isScrolling = false;
							});
							return false;
						}
						/* START EVENT TRACKING - VIEW HISTORICAL GRADE BUTTON CLICKED */
						if ( $(".toggle-content-school-grades").hasClass("active") ) {
							ga('send', 'event', 'My Schools', 'Clicked View Historical School Grades Data', "School ID: " + $(".page.type-page").data("schoolid"));
						} else if ( $(".toggle-content-student-characteristics").hasClass("active") ) {
							ga('send', 'event', 'My Schools', 'Clicked View Historical Student Characteristics Data', "School ID: " + $(".page.type-page").data("schoolid"));
						}
						/* END EVENT TRACKING */
					});
				});
			}
				
			var windowOffset = $(window).scrollTop();

			if ( $(".view-grade-history a.sf-button, a.view-grade-history").length > 0 ) {
				$(".view-grade-history a.sf-button, a.view-grade-history").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						windowOffset = $(window).scrollTop();
						$("html, body").animate({ scrollTop: 0 }, 0);
						if ( $("body").find(".sd-modal-content-grade-history").length > 0 ) {
							$("body").find(".sd-modal-content-grade-history").fadeIn("fast");
						}
						$("body").removeClass("mobile-menu-open");
						$("body").addClass("page-modal-open");
						$(".sd-modal-header").hide();
						return false;
					});
				});
			}

			if ( $(".view-ela-performance-data a.sf-button, a.view-ela-performance-data").length > 0 ) {
				$(".view-ela-performance-data a.sf-button, a.view-ela-performance-data").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						windowOffset = $(window).scrollTop();
						$("html, body").animate({ scrollTop: 0 }, 0);
						if ( $("body").find(".sd-modal-content-spar-ela-table").length > 0 ) {
							$("body").find(".sd-modal-content-spar-ela-table").fadeIn("fast");
						}
						$("body").removeClass("mobile-menu-open");
						$("body").addClass("page-modal-open");
						$(".sd-modal-header").hide();
						return false;
					});
				});
			}

			if ( $(".view-reading-performance-data a.sf-button, a.view-reading-performance-data").length > 0 ) {
				$(".view-reading-performance-data a.sf-button, a.view-reading-performance-data").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						windowOffset = $(window).scrollTop();
						$("html, body").animate({ scrollTop: 0 }, 0);
						if ( $("body").find(".sd-modal-content-spar-reading-table").length > 0 ) {
							$("body").find(".sd-modal-content-spar-reading-table").fadeIn("fast");
						}
						$("body").removeClass("mobile-menu-open");
						$("body").addClass("page-modal-open");
						$(".sd-modal-header").hide();
						return false;
					});
				});
			}

			if ( $(".view-math-performance-data a.sf-button, a.view-math-performance-data").length > 0 ) {
				$(".view-math-performance-data a.sf-button, a.view-math-performance-data").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						windowOffset = $(window).scrollTop();
						$("html, body").animate({ scrollTop: 0 }, 0);
						if ( $("body").find(".sd-modal-content-spar-math-table").length > 0 ) {
							$("body").find(".sd-modal-content-spar-math-table").fadeIn("fast");
						}
						$("body").removeClass("mobile-menu-open");
						$("body").addClass("page-modal-open");
						$(".sd-modal-header").hide();
						return false;
					});
				});
			}

			if ( $(".view-science-performance-data a.sf-button, a.view-science-performance-data").length > 0 ) {
				$(".view-science-performance-data a.sf-button, a.view-science-performance-data").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						windowOffset = $(window).scrollTop();
						$("html, body").animate({ scrollTop: 0 }, 0);
						if ( $("body").find(".sd-modal-content-spar-science-table").length > 0 ) {
							$("body").find(".sd-modal-content-spar-science-table").fadeIn("fast");
						}
						$("body").removeClass("mobile-menu-open");
						$("body").addClass("page-modal-open");
						$(".sd-modal-header").hide();
						return false;
					});
				});
			}

			$("#modal-container a.close-modal-link").each(function () {
				$(this).click(function (e) {
					e.preventDefault();
					if ( $("body").find(".sd-modal-content-42").length > 0 ) {
						$("body").find(".sd-modal-content-42").fadeOut("fast");
					}
					$("body").removeClass("page-modal-open");
					$("html, body").animate({ scrollTop: windowOffset + "px" }, 0);
					return false;
				});
			});

			if ( $("#school-reportcard-about-school .spb_gmaps_widget").length > 0 ) {
				var address = $("#school-reportcard-about-school .spb_gmaps_widget").find(".pin_location").data("address");
				if ( address != "undefined" ) {
					$("#school-reportcard-about-school .spb_gmaps_widget").find(".spb_map_wrapper").append('<div class="map-address">' + address + '</div>');
				}
			}

			if ( $("body.page-id-42 .understanding-grade a.understanding-grade-link").length > 0 ) {
				$("body.page-id-42 .understanding-grade a.understanding-grade-link").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						if ( $(this).closest(".school-calc").length > 0 ) {
							$(this).closest(".school-calc").addClass("open-understanding");
						}
						return false;
					});
				});
			}

			if ( $("body.page-id-42 a.understanding-grade-close").length > 0 ) {
				$("body.page-id-42 a.understanding-grade-close").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						if ( $(this).closest(".school-calc").length > 0 ) {
							$(this).closest(".school-calc").removeClass("open-understanding");
						}
						return false;
					});
				});
			}
		/* END GRAPH TOGGLE AND ANCHORING FUNCTIONALITY */

		/* START SCHOOL GRADES, STUDENT PERFORMANCE DETAILS, AND STUDENT CHARACTERISTICS TAB FUNCTIONALITY */
			if ( $("body.page-id-42 #school-reportcard-toggle").length > 0 ) {
				$("#main-container > .page > .container > section.row.fw-row:not(#school-reportcard-toggle):not(#school-reportcard-school-grade-data)").hide();
				$("a.toggle-content-link.toggle-content-school-grades").addClass("active");
				$("body.page-id-42 #school-reportcard-toggle").find(".toggle-content a.toggle-content-link").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						var hash = "#" + $(this).data("hash");
						$("a.toggle-content-link").removeClass("active");
						$("#main-container > .page > .container > section.row.fw-row:not(#school-reportcard-toggle)").hide();
						$("#main-container > .page > .container > section.row.fw-row:not(#school-reportcard-toggle)" + hash + "-data").show();
						$("#main-container > .page > .container > section.row.fw-row:not(#school-reportcard-toggle)" + hash + "-description").show();
						$(this).addClass("active");
						/* START EVENT TRACKING - TAB SELECTED */
						if ( $(this).hasClass("toggle-content-school-grades") ) {
							ga('send', 'event', 'School Report Card', 'Clicked School Grades Tab', 'School ID: ' + $(".page.type-page").data("schoolid"));
						} else if ( $(this).hasClass("toggle-content-performance-details") ) {
							ga('send', 'event', 'School Report Card', 'Clicked Student Performance Details Tab', 'School ID: ' + $(".page.type-page").data("schoolid"));
						} else if ( $(this).hasClass("toggle-content-student-characteristics") ) {
							ga('send', 'event', 'School Report Card', 'Clicked Student Characteristics Tab', 'School ID: ' + $(".page.type-page").data("schoolid"));
						}
						/* END EVENT TRACKING */
						return false;
					});
				});
			}
		/* END SCHOOL GRADES, STUDENT PERFORMANCE DETAILS, AND STUDENT CHARACTERISTICS TAB FUNCTIONALITY */

		/* START PARENT EMPOWERMENT STATMENT ACCORDION FUNCTIONALITY */
			if ( $(".pe-component").length > 0 ) {
				$(".pe-component").each(function () {
					if ( $(this).next(".pe-statement").length > 0 ) {
						if ( $(this).next(".pe-statement").hasClass("highest") || $(this).next(".pe-statement").hasClass("lowest") || $(this).next(".pe-statement").hasClass("grad-rate") ) {
							$(this).addClass("component-open");
						} else {
							$(this).addClass("component-closed");
						}
					}
					$(this).click(function (e) {
						e.preventDefault();
						var $component = $(this);
						var $statement = $(this).next(".pe-statement");
						if ( $statement.length > 0 ) {
							if ( $statement.css("display") == "none" ) {
								$component.removeClass("component-close");
								$component.addClass("component-open");
								$statement.css("display", "block");
							} else {
								$component.removeClass("component-open");
								$component.addClass("component-close");
								$statement.css("display", "none");
							}
						}
						/* START EVENT TRACKING - IF REPORT CARD PE STATEMENT DROPDOWNS ARE SELECTED */
						if ( $(".page.type-page").length > 0 ) {
							if ( $statement.prop("id") == "ela-achievement-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Achievement - English Language Arts', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "math-achievement-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Achievement - Mathematics', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "science-achievement-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Achievement - Science', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "socialstudies-achievement-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Achievement - Social Studies', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "ela-learning-gains-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Learning Gains - English Language Arts', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "math-learning-gains-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Learning Gains - Mathematics', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "ela-learning-gains-low25-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Learning Gains of Lowest Performing Students - English Language Arts', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "math-learning-gains-low25-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Learning Gains of Lowest Performing Students - Mathematics', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "middle-acceleration-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Acceleration - Middle School', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "high-acceleration-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Acceleration - High School', 'School ID: ' + $(".page.type-page").data("schoolid"));
							} else if ( $statement.prop("id") == "graduation-rate-pe-statement" ) {
								ga('send', 'event', 'School Report Card', 'Clicked Graduation Rate - Graduation Rate', 'School ID: ' + $(".page.type-page").data("schoolid"));
							}
						}
						/* END EVENT TRACKING */
						return false;
					});
				});
			}
		/* END PARENT EMPOWERMENT STATMENT ACCORDION FUNCTIONALITY */

		/* START ADDITIONAL GOOGLE ANALYTICS EVENT TRACKING */
			if ( $(".stat-website a").length > 0 && $(".page.type-page").length > 0 ) {
				/* START EVENT TRACKING - CLICKED TO VIEW SCHOOLS WEBSITE */
				$(".stat-website a").on("click", function () {
					ga('send', 'event', 'School Report Card', 'Clicked School Website Link', 'School ID: ' + $(".page.type-page").data("schoolid"));
				});
				/* END EVENT TRACKING */
			}

			if ( $(".view-ela-performance-data .sf-button").length > 0 ) {
				/* START EVENT TRACKING - CLICKED TO VIEW ENGLISH LANGUAGE ARTS TABLE */
				$(".view-ela-performance-data .sf-button").click(function () {
					ga('send', 'event', 'School Report Card', 'Clicked English Language Arts View Table', 'School ID: ' + $(".page.type-page").data("schoolid"));
				});
				/* END EVENT TRACKING */
			}

			if ( $(".view-math-performance-data .sf-button").length > 0 ) {
				/* START EVENT TRACKING - CLICKED TO VIEW MATHEMATICS TABLE */
				$(".view-math-performance-data .sf-button").click(function () {
					ga('send', 'event', 'School Report Card', 'Clicked Mathematics View Table', 'School ID: ' + $(".page.type-page").data("schoolid"));
				});
				/* END EVENT TRACKING */
			}

			if ( $(".view-science-performance-data .sf-button").length > 0 ) {
				/* START EVENT TRACKING - CLICKED TO VIEW SCIENCE TABLE */
				$(".view-science-performance-data .sf-button").click(function () {
					ga('send', 'event', 'School Report Card', 'Clicked Science View Table', 'School ID: ' + $(".page.type-page").data("schoolid"));
				});
				/* END EVENT TRACKING */
			}
		/* END ADDITIONAL GOOGLE ANALYTICS EVENT TRACKING */
	  
	});

})(jQuery);
