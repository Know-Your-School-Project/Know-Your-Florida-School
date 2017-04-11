
/*
*
*   SEARCH FUNCTIONS
*   ------------------------------------------------
*   This file includes aspects of search that are powered by javascript 
*
*/

(function($){

	$(document).ready(function () {

	  	var templateDirectory = $("#sf-option-params").data("template-directory");
	  	var stylesheetDirectory = $("#sf-option-params").data("stylesheet-directory");
	  	var pagePermalink = $("#sf-option-params").data('permalink');
	  	var map;
	  	var service;
	  	var geocoder;
	  	var reqJaxPEF = false;
	  	var reqGoogle = false;
	  	var reqResults = false;
	  	var home = $("#sf-option-params").data("home");
		var maxAutoCompleteResults = 3;
		var apiKey = "API_SECURITY_KEY";
		var districts = [];
		
		function getURLParameters(paramName) {

		    var sURL = window.document.URL.toString();
		    if (sURL.indexOf("?") > 0)
		    {
		        var arrParams = sURL.split("?");
		        var arrURLParams = arrParams[1].split("&");
		        var arrParamNames = new Array(arrURLParams.length);
		        var arrParamValues = new Array(arrURLParams.length);

		        var i = 0;
		        for (i = 0; i<arrURLParams.length; i++)
		        {
		            var sParam =  arrURLParams[i].split("=");
		            arrParamNames[i] = sParam[0];
		            if (sParam[1] != "")
		                arrParamValues[i] = unescape(sParam[1]);
		            else
		                arrParamValues[i] = "";
		        }

		        for (i=0; i<arrURLParams.length; i++)
		        {
		            if (arrParamNames[i] == paramName)
		            {
						if ( arrParamValues[i] == undefined  ) {
							arrParamValues[i] = "";
						}
		                return arrParamValues[i];
		            }
		        }
		        return "";
		    } else {
		        return "";
		    }
		}

		/* START RECOMMENDATIONS */

      	function initAutocomplete($form) {
	      	if ( $("body").find("#autocomplete-suggestions-container").length <= 0 ) {
	      		$("body").append('<div id="autocomplete-suggestions-container" style="display:none;"><div class="autocomplete-right-offset"><div class="autocomplete-suggestions"></div><div id="map" style="display:none;"></div></div></div>');
	  			geocoder = new google.maps.Geocoder();
	      	}
      	}

	  	function requestFullURL($form, format, geo) {

		  	if ( format == "api" ) {
		  		var requestURL = "https://api.jaxpef.org/schoolsearch/search/1/3/?APIKey=" + apiKey;
		  		var keyword = $form.find("input").val();
			  	if ( keyword && keyword != "" ) {
			  		requestURL = requestURL + "&kWord=" + keyword;
			  	}
		  	} else {
		  		var requestURL = home + "/";
			  	if ( geo != null ) {
				  	requestURL = requestURL + "?search=geo&s=";
				  	requestURL = requestURL + "&address=" + geo[0];
				  	requestURL = requestURL + "&lat=" + geo[1];
				  	requestURL = requestURL + "&long=" + geo[2];
				  	requestURL = requestURL + "&sradius=20";
			  	} else {
				  	requestURL = requestURL + "?search=" + $form.find('select[name="search"]').val() + "&s=" + $form.find("input.input-large").val();
				  	if ($('.spb_search_widget input[name="address"]').length > 0 && $('.spb_search_widget input[name="address"]').val() != "" && 
			  				$('.spb_search_widget input[name="lat"]').length > 0 && $('.spb_search_widget input[name="lat"]').val() != "" && 
			  				$('.spb_search_widget input[name="long"]').length > 0 && $('.spb_search_widget input[name="long"]').val() != "" && 
			  				$('.spb_search_widget input[name="sradius"]').length > 0 && $('.spb_search_widget input[name="sradius"]').val() != "" ) {
				  		requestURL = requestURL + "&address=" + $('.spb_search_widget input[name="address"]').val();
					  	requestURL = requestURL + "&lat=" + $('.spb_search_widget input[name="lat"]').val();
					  	requestURL = requestURL + "&long=" + $('.spb_search_widget input[name="long"]').val();
					  	requestURL = requestURL + "&sradius=" + $('.spb_search_widget input[name="sradius"]').val();
					}
			  	}
			  	if ( $(".wrap-filters").length > 0 ) {
			  		var districtid = $(".wrap-filters .filter-districtid select").val();
				  	if ( districtid && districtid != "" && districtid != "District" && districtid != "Select a District" ) {
				  		requestURL = requestURL + "&districtid=" + districtid;
				  	}
			  		var zip = $(".wrap-filters .filter-zip select").val();
				  	if ( zip && zip != "" && zip != "Zipcode" && zip != "Zip Code" && zip != "Select a Zip Code" ) {
				  		requestURL = requestURL + "&zip=" + zip;
				  	}
			  		var type = $(".wrap-filters .filter-type select").val();
				  	if ( type && type != "" && type != "Type of School" ) {
				  		requestURL = requestURL + "&type=" + type;
				  	}
			  		var schoolgrade = $(".wrap-filters .filter-schoolgrade select").val();
				  	if ( schoolgrade && schoolgrade != "" && schoolgrade != "School Grade" ) {
				  		requestURL = requestURL + "&schoolgrade=" + schoolgrade;
				  	}
			  		var charterschool = $(".wrap-filters .filter-charterschool select").val();
				  	if ( charterschool && charterschool != "" && charterschool != "Type of Charter School" ) {
				  		requestURL = requestURL + "&charterschool=" + charterschool;
				  	}
			  		var magnetstatus = $(".wrap-filters .filter-magnetstatus select").val();
				  	if ( magnetstatus && magnetstatus != "" && magnetstatus != "Magnet Status" ) {
				  		requestURL = requestURL + "&magnetstatus=" + magnetstatus;
				  	}
			  		var sradius = $('.wrap-filters input[name="sradius"]').val();
				  	if ( sradius && sradius != "" ) {
				  		requestURL = requestURL + "&sradius=" + sradius;
				  	}
			  		var lat = $('.wrap-filters input[name="lat"]').val();
				  	if ( lat && lat != "" ) {
				  		requestURL = requestURL + "&lat=" + lat;
				  	}
			  		var long = $('.wrap-filters input[name="long"]').val();
				  	if ( long && long != "" ) {
				  		requestURL = requestURL + "&long=" + long;
				  	}
			  		var address = $('.wrap-filters input[name="address"]').val();
				  	if ( address && address != "" ) {
				  		requestURL = requestURL + "&address=" + address;
				  	}
			  		var hitsPerPage = $('.wrap-filters input[name="hitsPerPage"]').val();
				  	if ( hitsPerPage && hitsPerPage != "" ) {
				  		requestURL = requestURL + "&hitsPerPage=" + hitsPerPage;
				  	}
			  		var sortBy = $('.sortby-wrap input[name="sortBy"]').val();
				  	if ( sortBy && sortBy != "" && sortBy != "School Name" && sortBy != "Distance" ) {
				  		requestURL = requestURL + "&sortBy=" + sortBy + "";
				  	}
				}
		  	}

		  	return requestURL;
	  
	  	}

	  	var $autocompleteForm;

      	function getSchoolNameSuggestions($form) {
	      	var keyword = $form.find("input").val();
	      	if ( keyword != "" ) {

	      		$("#autocomplete-suggestions-container").find(".autocomplete-suggestions").html("");

				var requestURL = requestFullURL($form, "api", null);

				reqJaxPEF = $.get(requestURL, function (data) {
					var suggestions = "";
					$.each(data.SearchData, function( index, school ) {
						suggestions = suggestions + '<div class="suggested-school"><a href="/school-report-card/?schoolid=' + school.SCHOOLID + '&districtid=' + school.DISTRICTID + '"><div class="icon-search-school-name" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-search-school-name.svg" data-fallback"' + stylesheetDirectory + '/images/icon-search-school-name.png" /></div><h5>' + school.SCHOOL_NAME_LONG.toLowerCase() + '<div id="search-district">'+ school.DISTRICT_NAME.toLowerCase() +'</div></h5></a></div>'
					});
					if ( suggestions != "" ) {
						$autocompleteForm = $form;
						$("#autocomplete-suggestions-container").css("top", $form.offset().top + $form.height() );
						$("#autocomplete-suggestions-container").css("left", $form.offset().left - 15);
						$("#autocomplete-suggestions-container").width($form.width());
						$("#autocomplete-suggestions-container").show();
						$("#autocomplete-suggestions-container").find(".autocomplete-suggestions").html(suggestions);
						// Elements to inject
						var mySVGsToInject = document.querySelectorAll('img.inject-me');
						var injectorOptions = {};
						SVGInjector(mySVGsToInject, injectorOptions, function (totalSVGsInjected) {  

						});
					}
				}, "json");

				if ( $("#autocomplete-suggestions-container").find(".autocomplete-suggestions").html() == "" ) {
					$("#autocomplete-suggestions-container").hide();
				}

			} else {
				$("#autocomplete-suggestions-container").hide();
			}
      	}

	  	function getAddressSuggestions($form, keyword) {
	
			if ( keyword != '' && geocoder ) {

				$("form.search-form").find('input[name="recommended_address"]').val("");
				$("form.search-form").find('input[name="lat"]').val("");
				$("form.search-form").find('input[name="long"]').val("");
				$("form.search-form").find('input[name="sradius"]').val("");
	      		$("#autocomplete-suggestions-container").find(".autocomplete-suggestions").html("");

			    reqGoogle = geocoder.geocode({
			        address: keyword,
			        country: "US"
			    }, function(results, status) {
			      if (status == google.maps.GeocoderStatus.OK) {
			        if (status = google.maps.GeocoderStatus.ZERO_RESULTS) {
						var suggestions = "";
						$.each(results, function( index, location ) {
							var address = location.formatted_address.replace("null, ", "");
							if ( ( address.indexOf(", FL ") >= 0 || address.indexOf(", FL,") >= 0 ) && suggestions.indexOf(address) == -1 ) {
								if ( suggestions == "" ) {
									$("form.search-form").find('input[name="recommended_address"]').val(location.formatted_address.replace("null, ", ""));
									$("form.search-form").find('input[name="lat"]').val(location.geometry.location.lat());
									$("form.search-form").find('input[name="long"]').val(location.geometry.location.lng());
									$("form.search-form").find('input[name="sradius"]').val(20);
								}
								suggestions = suggestions + '<div class="suggested-school"><a href="' + requestFullURL($form, null, [address, location.geometry.location.lat(), location.geometry.location.lng()]) + '"><div class="icon-search-address" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-search-address.svg" data-fallback"' + stylesheetDirectory + '/images/icon-search-address.png" /></div><h5>' + address + '</h5></a></div>';
							}
						});
						if ( suggestions != "" ) {
							$autocompleteForm = $form;
							$("#autocomplete-suggestions-container").css("top", $form.offset().top + $form.height() );
							$("#autocomplete-suggestions-container").css("left", $form.offset().left - 15);
							$("#autocomplete-suggestions-container").width($form.width());
							$("#autocomplete-suggestions-container").show();
							$("#autocomplete-suggestions-container").find(".autocomplete-suggestions").html(suggestions);
							// Elements to inject
							var mySVGsToInject = document.querySelectorAll('img.inject-me');
							var injectorOptions = {};
							SVGInjector(mySVGsToInject, injectorOptions, function (totalSVGsInjected) {  

							});
						}
			        }
			      }
			    });
			}
	  	}

	  	function getDistrictSuggestions($form, keyword) {
	
			if ( keyword != '' ) {

				$("form.search-form").find('input[name="recommended_district"]').val("");
	      		$("#autocomplete-suggestions-container").find(".autocomplete-suggestions").html("");
    			
    			reqJaxPEF = $.get( "https://api.jaxpef.org/districts/districtdistinct/?APIKey=" + apiKey, function(data) {
    				districts = data.DistrictDistinct;
					var suggestions = "";
					$.each(districts, function (index, district) {
						if ( district.DISTRICT_NAME.toLowerCase().indexOf(keyword.toLowerCase()) > -1 && district.DISTRICTID != 99 ) {
							if ( suggestions == "" ) {
								$("form.search-form").find('input[name="recommended_district"]').val(district.DISTRICTID);
							}
							suggestions = suggestions + '<div class="suggested-school"><a href="/?search=district&s=&districtid=' + district.DISTRICTID + '"><div class="icon-search-district" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-search-district.svg" data-fallback"' + stylesheetDirectory + '/images/icon-search-district.png" /></div><h5>' + district.DISTRICT_NAME.toLowerCase() + '</h5></a></div>';
						}
						if ( suggestions != "" ) {
							$autocompleteForm = $form;
							$("#autocomplete-suggestions-container").css("top", $form.offset().top + $form.height() );
							$("#autocomplete-suggestions-container").css("left", $form.offset().left - 15);
							$("#autocomplete-suggestions-container").width($form.width());
							$("#autocomplete-suggestions-container").show();
							$("#autocomplete-suggestions-container").find(".autocomplete-suggestions").html(suggestions);
							// Elements to inject
							var mySVGsToInject = document.querySelectorAll('img.inject-me');
							var injectorOptions = {};
							SVGInjector(mySVGsToInject, injectorOptions, function (totalSVGsInjected) {  

							});
						}
		      		});
    			});	      		

			}

	  	}

      	if ( $(".search-widget").length > 0 ) {

	      	initAutocomplete($(this));

	      	$(".search-widget").each(function () {
	      		$(this).on("keyup", function (e) {
	      			$(".view-my-schools-link.open-compare-dropdown").removeClass("open-compare-dropdown");
	      			if ( reqJaxPEF ) { reqJaxPEF.abort(); }
	      			if ( reqGoogle ) { reqGoogle.abort(); }
	      			if (e.which != 13) {
		      			if ( $(this).find('select[name="search"]').val() == "keyword" ) {
			      			getSchoolNameSuggestions($(this));
			      		} else if ( $(this).find('select[name="search"]').val() == "geo" ) {
			      			getAddressSuggestions($(this), $(this).find('input[name="address"]').val());
			      		} else if ( $(this).find('select[name="search"]').val() == "district" ) {
			      			getDistrictSuggestions($(this), $(this).find('input[name="districtid"]').val());
			      		}
			      	} else {
			      		$(this).blur();
	      				$("#autocomplete-suggestions-container").hide();
			      	}
	      		});
	      		$(this).on("focus", function () {
	      			$(".view-my-schools-link.open-compare-dropdown").removeClass("open-compare-dropdown");
	      			if ( reqJaxPEF ) { reqJaxPEF.abort(); }
	      			if ( reqGoogle ) { reqGoogle.abort(); }
	      			if ( $(this).find('select[name="search"]').val() == "keyword" ) {
		      			getSchoolNameSuggestions($(this));
		      		} else if ( $(this).find('select[name="search"]').val() == "geo" ) {
		      			getAddressSuggestions($(this), $(this).find('input[name="address"]').val());
		      		} else if ( $(this).find('select[name="search"]').val() == "district" ) {
		      			getDistrictSuggestions($(this), $(this).find('input[name="districtid"]').val());
		      		}
	      		});
	      		$(this).on("blur", function () {
	      			$("#autocomplete-suggestions-container").hide();
	      		});
	      	});

	      	$(window).resize(function () {
	      		if ( $autocompleteForm ) {
					$("#autocomplete-suggestions-container").css("top", $autocompleteForm.offset().top + $autocompleteForm.height() );
					$("#autocomplete-suggestions-container").css("left", $autocompleteForm.offset().left - 15);
				}
	      	});

      	}

		/* END RECOMMENDATIONS */

		/* START COMPARE  */

		var schoolsToCompare = getCookie("compare-schools");
		var keyword = getURLParameters("s");

		function setCookie(c_name, value, exdays) {
		    var exdate = new Date();
		    exdate.setDate(exdate.getDate() + exdays);
		    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
		    c_value = c_value + "; path=/";
		    document.cookie = c_name + "=" + c_value;
		}

		function getCookie(c_name) {
		    var i, x, y, ARRcookies = document.cookie.split(";");
		    for (i = 0; i < ARRcookies.length; i++) {
		        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
		        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
		        x = x.replace(/^\s+|\s+$/g, "");
		        if (x == c_name) {
		            return unescape(y);
		        }
		    }
		}
/*
		function removeSchool($input) {
			if ( $input.hasClass("enabled") ) {
				$input.removeClass("enabled");
				$input.addClass("disabled");
				if ( $input.parents(".row.school-comparison-schools").next("section").find('div[data-schoolid="' + $input.data("schoolid") + '"]').length > 0 ) {
					$input.parents(".row.school-comparison-schools").next("section").find('div[data-schoolid="' + $input.data("schoolid") + '"]').addClass("hide-school");
				}
			} else if ( $input.hasClass("disabled") ) {
				$input.removeClass("disabled");
				$input.addClass("enabled");
				if ( $input.parents(".row.school-comparison-schools").next("section").find('div[data-schoolid="' + $input.data("schoolid") + '"]').length > 0 ) {
					$input.parents(".row.school-comparison-schools").next("section").find('div[data-schoolid="' + $input.data("schoolid") + '"]').removeClass("hide-school");
				}
			}
		}
*/
		if ( $(".school-comparison-schools .compare-school-link").length > 0 ) {
			$(".school-comparison-schools .compare-school-link").click(function (e) {
				e.preventDefault();
				removeSchool($(this));
				return false;
			});
		}

		if ( $(".accordion-chart-wrapper").length > 0 ) {
			$(".accordion-chart-wrapper").each(function () {
				if ( $(this).parent(".accordion-chart-link").next(".accordion-chart-yoy-data").length > 0 ) {
					$(this).parent(".accordion-chart-link").next(".accordion-chart-yoy-data").slideUp("fast");
					$(this).parent(".accordion-chart-link").addClass("active-accordion");
				} else {
					$(this).parent(".accordion-chart-link").addClass("inactive-accordion");
				}
				if ( $(this).find(".accordion-chart-fill").length > 0 ) {
					$(this).find(".accordion-chart-fill").css('width',$(this).find(".accordion-chart-fill").data("fill"));
				}
				$(this).parent(".accordion-chart-link").click(function (e) {
					e.preventDefault();
					if ( $(this).next(".accordion-chart-yoy-data").length > 0 ) {
						if ( $(this).next(".accordion-chart-yoy-data").css('display') == 'none' ) {
							$(this).next(".accordion-chart-yoy-data").slideDown("fast");
							$(this).addClass("accordion-chart-open");
						} else {
							$(this).next(".accordion-chart-yoy-data").slideUp("fast");
							$(this).removeClass("accordion-chart-open");
						}
					}
					return false;
				});
			});
		}

		/* END COMPARE SCHOOLS */

		/* START COMPARE SCHOOLS */

		var schoolsToCompare = getCookie("compare-schools");
		var keyword = getURLParameters("s");

		function updateCompareHeader() {
			if ( getCookie("compare-schools") != undefined && getCookie("compare-schools").length > 0 ) {
				if ( getCookie("compare-schools") != undefined ) {
					schoolsToCompare = JSON.parse(getCookie("compare-schools"));
					keyword = getURLParameters("s");
					if ( $("#compare-header-wrap .compare-inner").length > 0 ) {
						var output = '<div class="compare-padding">';
						if ( schoolsToCompare.length > 0 ) {
							output = output + '<div id="school-comparisons">';
							var firstSchool = true;
							$.each(schoolsToCompare, function (key, school) {
								var schoolId = school.schoolid;
								var districtId = school.districtid;
								var schoolName = school.schoolname;
								output = output + '<a href="#" class="compare-school-link" data-schoolid="' + schoolId + '" data-districtid="' + districtId + '" data-schoolname="' + schoolName + '"><div class="icon-search-school-name" aria-hidden="true"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-search-school-name.svg" data-fallback"' + stylesheetDirectory + '/images/icon-search-school-name.png" /></div> ' + schoolName + ' <i class="compare-icon-close"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-compare-close.svg" data-fallback="' + stylesheetDirectory + '/images/icon-compare-close-white.png" /></i></a>';
								firstSchool = false;
							});
							if ( schoolsToCompare.length > 1 ) {
								output = output + '<a class="compare-link" href="/my-schools/?schools=' + encodeURIComponent(getCookie("compare-schools")) + '">Compare Schools</a>';
							}
							output = output + '</div>';
							$(".view-my-schools-link").removeClass("no-schools");
						} else {
							$(".view-my-schools-link").addClass("no-schools");
						}
						output = output + '</div>';
						$("#compare-header-wrap .compare-inner").html(output);
						$(".view-my-schools-link .compare-count").html("(" + schoolsToCompare.length + ")");
						if ( schoolsToCompare.length <= 0 ) {
							$("#compare-header-wrap").css("opacity",0);
						} else {
							$("#compare-header-wrap").css("opacity",1);
						}

						/* START EVENT TRACKING - IF SELECTS TO COMPARE SCHOOLS */
						if ( $("#school-comparisons .compare-link").length > 0 ) {
							$("#school-comparisons .compare-link").on("click", function(e) {
								ga('send', 'event', 'My Schools', 'Clicked Compare My School');
								return;
							});
						}
						/* END EVENT TRACKING */

						// Elements to inject
						var mySVGsToInject = document.querySelectorAll('img.inject-me');
						var injectorOptions = {};
						SVGInjector(mySVGsToInject, injectorOptions, function (totalSVGsInjected) {  

						});
						$("body #school-comparisons .compare-school-link").click(function (e) {
							e.preventDefault();
							removeSchool($(this));
							return false;
						});
					} else {
						$(".view-my-schools-link").addClass("no-schools");
					}
				} else {
					$(".view-my-schools-link").addClass("no-schools");
				}
			} else {
				$(".view-my-schools-link").addClass("no-schools");
			}
		}

		function removeSchool($input) {
			/* REMOVE SCHOOLS FOR SEARCH PAGE */
			if ( $("#compare-school-" + $input.data("schoolid")).length > 0 ) {
				$("#compare-school-" + $input.data("schoolid")).checked = false;
			}
			if ( getCookie("compare-schools") != undefined && getCookie("compare-schools").length > 0 ) {
				var schoolToRemove = {"schoolid":$input.data("schoolid")}
				var schoolsToCompare = JSON.parse(getCookie("compare-schools"));
				var schoolsToCompareNew = [];
				$.each(schoolsToCompare, function (key, school) {
					if ( school.schoolid != schoolToRemove.schoolid ) {
						schoolsToCompareNew.push(school);
					}
				});
				setCookie("compare-schools", JSON.stringify(schoolsToCompareNew));
				schoolsToCompare = schoolsToCompareNew;
				if ( $("#compare-school-" + $input.data("schoolid")).length > 0 ) {
					$("#compare-school-" + $input.data("schoolid")).iCheck('uncheck');
				}
				if ( schoolsToCompare.length < 1 ) {
					$("#school-comparisons").html("");
				}
			}
			$('.compare-school-link[data-schoolid="' + $input.data("schoolid") +'"]').remove();
			$(".view-my-schools-link .compare-count").html("(" + schoolsToCompare.length + ")");
			if ( schoolsToCompare.length <= 0 ) {
				$(".view-my-schools-link").addClass("no-schools");
			} else if ( schoolsToCompare.length == 1 ) {
				$("#compare-header-wrap .compare-link").remove();
			}
			/* START EVENT TRACKING - SELECTED TO REMOVE A SCHOOL FROM "MY SCHOOLS" */
			ga('send', 'event', 'My Schools', 'Clicked Remove School', 'School ID: ' + $input.data("schoolid"));
			/* END EVENT TRACKING */
		}

		if ( $("body #school-comparisons .compare-school-link").length > 0 ) {
			$("body #school-comparisons .compare-school-link").click(function (e) {
				e.preventDefault();
				removeSchool($(this));
				return false;
			});
		}

		if ( $(".menu-main-menu-container ul.menu .compare-header").length <= 0 ) {
			$(".menu-main-menu-container ul.menu").append('<li class="menu-item menu-item-type-post_type menu-item-object-page sf-std-menu view-my-schools-link no-schools"><a title="View My Schools" href="#compare-header-wrap"><span class="menu-item-text">View My Schools <span class="compare-count"></span> <i class="compare-icon-arrow"><img class="inject-me" data-src="' + stylesheetDirectory + '/images/icon-compare-arrow-down.svg" data-fallback="' + stylesheetDirectory + '/images/icon-compare-arrow-down-purple.png" /></i></span></a><div id="compare-header-wrap"><div class="compare-inner"></div></div></li>');
			$('a[href="#compare-header-wrap"]').click(function (e) {
				e.preventDefault();
				$(this).parent(".view-my-schools-link").toggleClass("open-compare-dropdown");
				/* START EVENT TRACKING - IF SELECTED TO VIEW "MY SCHOOLS" IS CHECKED */
				ga('send', 'event', 'My Schools', 'Clicked View My Schools');
				/* END EVENT TRACKING */
				return false;
			});
			updateCompareHeader();
		}

		function compareInputAction() {
			$('.blog-items-wrap input[name="compare-school"]').each(function () {
		      	$(this).iCheck({
		                checkboxClass: 'icheckbox',
		                radioClass: 'iradio'
		                    //increaseArea: '20%'
		            }); 
		      	$(this).on('ifChecked', function(event){
					$(this).parents(".blog-item").addClass("selected-to-compare");
					if ( getCookie("compare-schools") != undefined ) {
						schoolsToCompare = JSON.parse(getCookie("compare-schools"));
					} else {
						schoolsToCompare = [];
					}
					$('.blog-items-wrap input[name="compare-school"]:checked').each(function(){
						var schoolObject = {"districtid":$(this).data("districtid"),"schoolid":$(this).data("schoolid"),"schoolname":$(this).data("schoolname")};
					    if ( schoolsToCompare.indexOf(schoolObject) < 0 ) {
					    	schoolsToCompare.push(schoolObject);
						}
					});
					schoolsToCompare = _.uniq(schoolsToCompare, function (item, key, a) { return item.schoolid.toString(); });
					/* SETTING A COOKIE TO USE IN THE COMPARE SECION */
					setCookie("compare-schools", JSON.stringify(schoolsToCompare));
					updateCompareHeader();

					/* START EVENT TRACKING - IF "ADD TO MY SCHOOL" IS CHECKED */
					ga('send', 'event', 'My Schools', 'Clicked Add To My Schools', 'School ID: ' + $(this).val());
					/* END EVENT TRACKING */

				});
		      	$(this).on('ifUnchecked', function(event){
					removeSchool($(this));
					$(this).parents(".blog-item").removeClass("selected-to-compare");
					if ( getCookie("compare-schools") != undefined ) {
						schoolsToCompare = JSON.parse(getCookie("compare-schools"));
					} else {
						schoolsToCompare = [];
					}
					$('.blog-items-wrap input[name="compare-school"]:checked').each(function(){
						var schoolObject = {"districtid":$(this).data("districtid"),"schoolid":$(this).data("schoolid"),"schoolname":$(this).data("schoolname")};
					    if ( schoolsToCompare.indexOf(schoolObject) < 0 ) {
					    	schoolsToCompare.push(schoolObject);
						}
					});
					schoolsToCompare = _.uniq(schoolsToCompare, function (item, key, a) { return item.schoolid.toString(); });
					/* SETTING A COOKIE TO USE IN THE COMPARE SECION */
					setCookie("compare-schools", JSON.stringify(schoolsToCompare));
					updateCompareHeader();
				});
			});
			if ( $(".page-id-42 .add-school-compare-link").length > 0 ) {
				$(".page-id-42 .add-school-compare-link").on("click", function (e) {
					e.preventDefault();
					if ( getCookie("compare-schools") != undefined ) {
						schoolsToCompare = JSON.parse(getCookie("compare-schools"));
					} else {
						schoolsToCompare = [];
					}
					var schoolObject = {"districtid":$(this).data("districtid"),"schoolid":$(this).data("schoolid"),"schoolname":$(this).data("schoolname")};
				    if ( schoolsToCompare.indexOf(schoolObject) < 0 ) {
				    	schoolsToCompare.push(schoolObject);
					}
					schoolsToCompare = _.uniq(schoolsToCompare, function (item, key, a) { return item.schoolid.toString(); });
					/* SETTING A COOKIE TO USE IN THE COMPARE SECION */
					setCookie("compare-schools", JSON.stringify(schoolsToCompare));
					updateCompareHeader();
					/* START EVENT TRACKING - SELECTED TO ADD A SCHOOL FROM A REPORT CARD */
					ga('send', 'event', 'My Schools', 'Clicked Add To My Schools', 'School ID: ' + $input.data("schoolid"));
					/* END EVENT TRACKING */
					return false;
				});
			}
		}
		compareInputAction();

		if ( $("#compare-feed").length > 0 ) {
			$("#compare-feed").find(".blog-items.masonry-items").equalHeights();
		}

		/* END COMPARE  */

		/* START ADVANCED OPTIONS */

	  	if ( $(".wrap-filter").length > 0 ) {
	  		function inputChanged($input) {

      			if ( reqResults ) { reqResults.abort(); }

				var inputName = $input.prop("name");
				if ($input.is('input[type=checkbox]')) {
					var inputValue = $input.closest("form").find('input[name=' + inputName + ']:checked').map(function () {return this.value;}).get().join(",");
				} else {
					var inputValue = $input.val();
				}
				if ( inputValue == "Select a District" ||
				     inputValue == "Select a Zip Code" ||
				     inputValue == "Type of School" ||
				     inputValue == "School Grade" ||
				     inputValue == "Type of Charter School" ||
				     inputValue == "Magnet Status" ||
				     inputValue == "School Name" ||
				     inputValue == "Distance" ) {
					inputValue = "";
				}
				var blogWrap = jQuery('.blog-wrap');
				var blogItems = jQuery('.blog-wrap').find('.blog-items');
				var blogInstance = $input.parents(".blog-wrap").find(".blog-items");
				var blogAtts = $input.parents(".blog-wrap").find(".blog-items").data("atts");
				var blogPaged = $input.parents(".blog-wrap").find(".blog-items").data("paged");
				var template = "florida_schools_feed";

				/* CHANGE URL TO MATCH CONTENT */
				blogAtts = JSON.parse(decodeURIComponent(blogAtts));
				currentUrl = document.location.href;
				parsedUrl = jQuery.url(currentUrl);
				params = parsedUrl.param();
				delete blogAtts[inputName];
				blogAtts["pageNum"] = params["pageNum"] = 1;
				if ( inputValue != "" ) {
					blogAtts[inputName] = inputValue;
					params[inputName] = inputValue;
				} else {
					delete blogAtts[inputName];
					delete params[inputName];
				}
				$('.wrap-filter select').each(function () {
					selectvalue = $(this).val();
					selectname = $(this).prop("name");
					if ( selectname == "zip" && $.isArray(selectvalue) ) {
						selectvalue = selectvalue.join(",");
					}
					if ( selectvalue == "Select a District" ||
					     selectvalue == "Select a Zip Code" ||
					     selectvalue == "Type of School" ||
					     selectvalue == "School Grade" ||
					     selectvalue == "Type of Charter School" ||
					     selectvalue == "Magnet Status" ||
					     selectvalue == "School Name" ||
					     selectvalue == "Distance" ) {
						selectvalue = "";
					}
					if ( selectvalue != "" ) {
						blogAtts[selectname] = selectvalue;
						params[selectname] = selectvalue;
					} else {
						delete blogAtts[selectname];
						delete params[selectname];
					}
				});
				newUrl = "?" + jQuery.param(params);
				window.history.replaceState('', '', pagePermalink + newUrl);
				blogAtts = encodeURIComponent(JSON.stringify(blogAtts));

				var requestURL = stylesheetDirectory + "/api/" + template + ".php?atts=" + blogAtts + "&paged=" + blogPaged + "&permalinkURL=" + pagePermalink;

				jQuery(".post-filter-tabs").each(function () {
					jQuery(this).find('li').removeClass('selected');
					jQuery(this).find('li a.'+term).parent().addClass('selected');
				});

				blogInstance.append('<div id="infscr-loading" class="first-page-loading" style="position:absolute;top:0px;left:0px;"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>');

				blogInstance.find(".blog-item").stop().animate({
					'opacity' : 0,
				}, 800, 'easeOutExpo', function() {
				
				});

				reqResults = jQuery.get( requestURL, function( data ) {

					jQuery("body").append('<div id="filteringHTML" style="display:none;"></div>');
					data = jQuery("#filteringHTML").html(data).find(".blog-items-wrap").html();
					jQuery("#filteringHTML").remove();

					if ( blogItems.hasClass("blog-inf-scroll") || blogItems.hasClass("blog-load-more") ) {
						blogItems.infinitescroll("destroy");
					}
					blogInstance.closest(".blog-items-wrap").html(data);

					blogInstance.stop().animate({
						'opacity' : 1,
					}, 400, function() {
						/* INITIALIZE CONTENT */
						blogInstance = $input.closest(".blog-wrap").find('.blog-items');
						blogItems = $input.closest(".blog-wrap").find('.blog-items');
						SWIFT.blog.init();
						SWIFT.page.injectsvgs();
						compareInputAction();
						if ( blogItems.hasClass("blog-inf-scroll") || blogItems.hasClass("blog-load-more") ) {
							SWIFT.blog.infiniteScroll();
						}
					});

				});

				/* START EVENT TRACKING - IF FILTERS ARE USED */
				if ( $input.prop("name") == "arrange" ) {
					ga('send', 'event', 'Arrange', 'Sort Results', 'Sort: ' + $input.val());
				} else if ( $input.prop("name") == "sortBy" ) {
					ga('send', 'event', 'Arranged by', 'Arrange Results', 'Arrange: ' + $input.val());
				} else if ( $input.prop("name") == "schoolgrade" ) {
					ga('send', 'event', 'Filter', 'Filter By Performance', 'Filter: ' + $input.val());
				} else if ( $input.prop("name") == "type" ) {
					ga('send', 'event', 'Filter', 'Filter By School Level', 'Filter: ' + $input.val());
				} else if ( $input.prop("name") == "districtid" ) {
					ga('send', 'event', 'Filter', 'Filter By District', 'Filter: ' + $input.val());
				} else if ( $input.prop("name") == "zip" ) {
					ga('send', 'event', 'Filter', 'Filter By Zipcode', 'Filter: ' + $input.val());
				}
				/* END EVENT TRACKING */

	  		}
	  		$('.wrap-filter input[type="checkbox"]').each(function () {
		      	$(this).iCheck({
		                checkboxClass: 'icheckbox',
		                radioClass: 'iradio'
		                    //increaseArea: '20%'
		            }); 
		      	$(this).on('ifChecked', function(event){
		      		inputChanged($(this));
				});
		      	$(this).on('ifUnchecked', function(event){
		      		inputChanged($(this));
				});
			});
			$('.wrap-filter select[name="zip"]').each(function () {
				$(this).chosen();
			});
			$('.wrap-filter select').each(function () {
				$(this).on("change", function () {
					inputChanged($(this));
				});
			});
			if ( $(".toggle-advanced-options").length > 0 ) {
				$(".toggle-advanced-options").each(function () {
					$(this).click(function (e) {
						e.preventDefault();
						if ( $(this).parents(".title-wrap").find(".wrap-filters").css("display") == "none" ) {
							$(this).parents(".title-wrap").find(".wrap-filters").stop().slideDown("fast", function () {
								$(this).parents(".title-wrap").find(".wrap-filters form").stop().fadeIn("fast");
								$(this).parents(".title-wrap").addClass("advanced-options-open");
								$(this).blur();
							});
						} else {
							$(this).parents(".title-wrap").find(".wrap-filters form").stop().fadeOut("fast", function () {
								$(this).parents(".title-wrap").find(".wrap-filters").stop().slideUp("fast");
								$(this).parents(".title-wrap").removeClass("advanced-options-open");
								$(this).blur();
							});
						}
						return false;
					});
				});
			}
	  	}

		/* END ADVANCED OPTIONS */

		/* START SEARCH DROPDOWN FUNCTIONALITY */

		if ( $("form.search-form").length > 0 ) {
			$("form.search-form").each(function () {
				var $form = $(this);
				$form.closest("section.row.fw-row").addClass("searchbar-row");
				$form.find('select[name="districtid"]').chosen({max_selected_options: 1});
				if ( districts.length <= 0 ) {
					$.get( "https://api.jaxpef.org/districts/districtdistinct/?APIKey=" + apiKey, function(data) { 
						districts = data.DistrictDistinct;
						var districtid = $form.find('input[name="districtid"]').val();
						$.each(districts, function (index, district) {
							if ( district.DISTRICTID == districtid ) {
								$form.find('input[name="districtid"]').val(district.DISTRICT_NAME);
							}
			      		}); 
					});
				} else {
					var districtid = $form.find('input[name="districtid"]').val();
					$.each(districts, function (index, district) {
						if ( district.DISTRICTID == districtid ) {
							$form.find('input[name="districtid"]').val(district.DISTRICT_NAME);
						}
		      		});
				}
				$form.find('select[name="search"]').on("change", function () {
					var search = $(this).val();
					$form.closest("form.search-form").find("input.input-large").hide();
					$form.closest("form.search-form").find("input.input-large").val("");
					$("#autocomplete-suggestions-container").hide();
					if ( search == "keyword" ) {
						$form.closest("form.search-form").find('input[name="s"]').show();
						$form.closest("form.search-form").find('input[name="s"]').focus();
					} else if ( search == "geo" ) {
						$form.closest("form.search-form").find('input[name="address"]').show();
						$form.closest("form.search-form").find('input[name="address"]').focus();
					} else if ( search == "district" ) {
						$form.closest("form.search-form").find('input[name="districtid"]').show();
						$form.closest("form.search-form").find('input[name="districtid"]').focus();
					}
				});
				$form.on("submit", function (e) {
					$("#autocomplete-suggestions-container").hide();
					$form.animate({ opacity: 0 }, 0, function() { $("#autocomplete-suggestions-container").hide(); });
					var search = $(this).find('select[name="search"]').val();
					var val = "";
					if ( search == "keyword" ) {
						$form.find('input[name="address"]').remove();
						$form.find('input[name="districtid"]').remove();
						$form.find('input[name="recommended_address"]').remove();
						$form.find('input[name="sradius"]').remove();
						$form.find('input[name="lat"]').remove();
						$form.find('input[name="long"]').remove();
						$form.find('input[name="recommended_district"]').remove();
						val = $form.find('input[name="s"]').val();
					} else if ( search == "geo" ) {
						if ( $form.find('input[name="recommended_address"]').val() != "" ) {
							$form.find('input[name="address"]').val($form.find('input[name="recommended_address"]').val());
						}
						$form.find('input[name="recommended_address"]').remove();
						$form.find('input[name="s"]').val("");
						$form.find('input[name="districtid"]').remove();
						$form.find('input[name="recommended_district"]').remove();
						val = $form.find('input[name="address"]').val();
					} else if ( search == "district" ) {
						if ( $form.find('input[name="recommended_district"]').val() != "" ) {
							$form.find('input[name="districtid"]').val($form.find('input[name="recommended_district"]').val());
						}
						$form.find('input[name="recommended_district"]').remove();
						$form.find('input[name="s"]').val("");
						$form.find('input[name="address"]').remove();
						$form.find('input[name="recommended_address"]').remove();
						$form.find('input[name="sradius"]').remove();
						$form.find('input[name="lat"]').remove();
						$form.find('input[name="long"]').remove();
						val = $form.find('input[name="districtid"]').val();
					}
					$("#autocomplete-suggestions-container").hide();

					/* EVENT TRACKING - IF SEARCH BOX IS USED */
					if ( $("body").hasClass("home") ) {
						ga('send', 'event', 'Search', 'Search From Home Page', 'Search: "' + val + '"');
					} else if ( $("body").hasClass("search") ) {
						ga('send', 'event', 'Search', 'Search From Search Page', 'Search: "' + val + '"');
					}
					/* EVENT TRACKING */

					return;
				});
		  		$form.find(".search-icon-position").click(function (e) {
	  				e.preventDefault();
					$("#autocomplete-suggestions-container").hide();
	  				$form.closest("form.search-form").submit();
	  				return false;
		  		});
		  		$form.find(".input-large").keypress(function (e) {
				  if (e.which == 13) {
					$("#autocomplete-suggestions-container").hide();
				    $form.closest("form.search-form").submit();
				  }
				});
			});
		}

		/* END SEARCH DROPDOWN FUNCTIONALITY */
	  
	});

})(jQuery);
