"use strict";

/*
* ----------------------------------------------------------------------------------------
    Template Name: mr stater
    Template URI: https://spellbit.com/
    Description: 
    Author: mahedi amin
    Author URI: https://mahediamin.com
    Version: 1.0.0



    -------------INDEX----------------
   01.Paralx Int
   02.Mobile Menu
   03.Sticky Menu
   04.All Owl Slider
   05.Counter
   06.scroll up
   07.Image Filter Acitve
   08.Magnify active
    09.slider range and date picker
    10. PROGRESSBAR ACTIVATION
    11.WOW Active1
    12.team Testimonilas
    13.Multitab active

* ----------------------------------------------------------------------------------------
*/
jQuery(document).ready(function ($) {
  "use strict";
  /*---------------====================
  01.Paralx Int
  ================-------------------*/

  function initparallax() {
    var a = {
      Android: function Android() {
        return navigator.userAgent.match(/Android/i);
      },
      BlackBerry: function BlackBerry() {
        return navigator.userAgent.match(/BlackBerry/i);
      },
      iOS: function iOS() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
      },
      Opera: function Opera() {
        return navigator.userAgent.match(/Opera Mini/i);
      },
      Windows: function Windows() {
        return navigator.userAgent.match(/IEMobile/i);
      },
      any: function any() {
        return a.Android() || a.BlackBerry() || a.iOS() || a.Opera() || a.Windows();
      }
    };
    var trueMobile = a.any();

    if (null == trueMobile) {
      var b = new Scrollax();
      b.reload();
      b.init();
    }
  }

  initparallax();
  /*---------------====================
  02.Mobile Menu 
  ================-------------------*/

  $(".menu-item-has-children > a").on("click", function () {
    var element = $(this).parent("li");

    if (element.hasClass("open")) {
      element.removeClass("open");
      element.find("li").removeClass("open");
      element.find("ul").slideUp(500, "linear");
    } else {
      element.addClass("open");
      element.children("ul").slideDown();
      element.siblings("li").children("ul").slideUp();
      element.siblings("li").removeClass("open");
      element.siblings("li").find("li").removeClass("open");
      element.siblings("li").find("ul").slideUp();
    }
  }); // menu menu active link

  $(".main-menu ul li").on("click", function () {
    $(".main-menu ul li").removeClass("active");
    $(this).addClass("active");
  }); // mobile menu click

  $(".menu-click").on("click", function () {
    $(".main-menu > ul").toggleClass('show');
    return false;
  });
  $('a.smooth-scroll').on("click", function (e) {
    var anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: $(anchor.attr('href')).offset().top - 70
    }, 1200, 'easeInOutExpo');
    e.preventDefault();
  });
  $('body').scrollspy({
    target: '.navbar-collapse',
    offset: 195
  });
  $(".navbar-toggler").on('click', function () {
    $(".navbar-toggler").toggleClass("cg");
  });
  $(".rt-one-page-menu ul > li.nav-item > a.nav-link").on('click', function () {
    $(".navbar-collapse").removeClass("show");
    $(".navbar-toggler").removeClass("cg");
  });
  /*---------------====================
  03.Sticky Menu
  ================-------------------*/

  $(window).on('scroll', function () {
    var scroll = $(window).scrollTop();

    if (scroll < 200) {
      $(".rt-sticky").removeClass("rt-sticky-active fadeInDown animated");
    } else {
      $(".rt-sticky").addClass("rt-sticky-active fadeInDown animated");
    }
  });
  $(".rt-search-open").on("click", function () {
    $(".rt-hidden-search").addClass("rt-search-active");
  });
  $(".rt-search-close").on("click", function () {
    $(".rt-hidden-search").removeClass("rt-search-active");
  });
  /*---------------====================
  04.All Owl Slider
  ================-------------------*/

  if (document.getElementById("instragramslider_active")) {
    var getInstraDtata = document.getElementById("instragramslider_active");
    var getuserid = getInstraDtata.getAttribute("data-instra-id");
    var gettoken = getInstraDtata.getAttribute("data-instra-token");
    var feedFooter = new Instafeed({
      get: 'user',
      userId: getuserid,
      // your user id
      accessToken: gettoken,
      // your access token
      sortBy: 'most-liked',
      template: '<a class="instra-item" href="{{link}}" target="_blank"><img  src="{{image}}" /> <div class="instra-hover"><i class="icofont-link"></i></div></a>',
      target: getInstraDtata,
      limit: 9,
      resolution: 'low_resolution',
      after: function after() {
        $(getInstraDtata).owlCarousel({
          loop: true,
          margin: 0,
          nav: false,
          autoplay: true,
          autoplayTimeout: 3000,
          responsive: {
            210: {
              items: 1
            },
            320: {
              items: 1
            },
            479: {
              items: 1
            },
            768: {
              items: 1
            },
            980: {
              items: 1
            },
            1199: {
              items: 1
            }
          }
        });
      }
    });
    feedFooter.run();
  } // slider active 


  if ($('.rt-slider-active').length > 0) {
    $('.rt-slider-active').owlCarousel({
      margin: 0,
      loop: true,
      nav: true,
      //autoplay: true,
      navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
      animateOut: 'fadeOut',
      animateIn: 'fadeIn',
      autoplayTimeout: 9000,
      //mouseDrag: false,
      responsive: {
        0: {
          items: 1
        }
      }
    });
  }

  if ($('.deal-carosel-active').length > 0) {
    $('.deal-carosel-active').owlCarousel({
      margin: 0,
      loop: true,
      nav: true,
      //autoplay: true,
      dots: false,
      navText: ['<i class="icofont-long-arrow-left"></i>', '<i class="icofont-long-arrow-right"></i>'],
      autoplayTimeout: 9000,
      mouseDrag: false,
      responsive: {
        0: {
          items: 1
        }
      }
    });
  }

  if ($('.tour-carosel-active').length > 0) {
    $('.tour-carosel-active').owlCarousel({
      margin: 0,
      loop: true,
      nav: true,
      //autoplay: true,
      dots: false,
      autoplayTimeout: 9000,
      navText: ['<i class="icofont-long-arrow-left"></i>', '<i class="icofont-long-arrow-right"></i>'],
      mouseDrag: true,
      responsive: {
        210: {
          items: 1
        },
        320: {
          items: 2
        },
        479: {
          items: 2
        },
        768: {
          items: 3
        },
        980: {
          items: 3
        },
        1199: {
          items: 4
        }
      }
    });
  }

  $('.rt-duel-slider-main').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.rt-duel-slider-thumb'
  });
  $('.rt-duel-slider-thumb').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.rt-duel-slider-main',
    dots: false,
    focusOnSelect: true,
    arrows: true,
    prevArrow: "<span  class='arrow_left'><i class='icofont-thin-double-left'></i></span>",
    nextArrow: "<span  class='arrow_right'><i class='icofont-thin-double-right'></i></span>",
    responsive: [{
      breakpoint: 1199.98,
      settings: {
        slidesToShow: 3
      }
    }, {
      breakpoint: 767.98,
      settings: {
        slidesToShow: 2
      }
    }]
  }); // slider animation

  if ($(".rt-slider-active").length > 0 || $(".deal-carosel-active").length > 0) {
    //Owl-Carousel Translate Function
    var heroSlider = $(".rt-slider-active, .deal-carosel-active");
    heroSlider.on('translate.owl.carousel', function () {
      var layer = $("[data-animation]");
      layer.each(function () {
        var animation_name = $(this).data('animation');
        $(this).removeClass('animated ' + animation_name).css('opacity', '1');
      });
    }); //Owl-Carousel Delay Function

    $("[data-delay]").each(function () {
      var animation_delay = $(this).data('delay');
      $(this).css('animation-delay', animation_delay);
    }); //Owl-Carousel Duration Function

    $("[data-duration]").each(function () {
      var animation_duration = $(this).data('duration');
      $(this).css('animation-duration', animation_duration);
    }); //Owl-Carousel Translated Function

    heroSlider.on('translated.owl.carousel', function () {
      var layer = heroSlider.find('.owl-item.active').find("[data-animation]");
      layer.each(function () {
        var animation_name = $(this).data('animation');
        $(this).addClass('animated ' + animation_name).css('opacity', '1');
      });
    });
  }
  /*---------------====================
    05.Counter
    ================-------------------*/


  $('.counter').counterUp({
    delay: 10,
    time: 1000
  });
  /*---------------====================
    06.scroll up
    ================-------------------*/

  $.scrollUp({
    scrollText: '<i class="fa fa-angle-up"></i>'
  });
  /*---------------====================
  07.Image Filter Acitve
  ================-------------------*/

  $('.grid').imagesLoaded(function () {
    var $grid = $('.grid').isotope({
      itemSelector: '.grid-item',
      percentPosition: true,
      masonry: {
        // use outer width of grid-sizer for columnWidth
        columnWidth: 1
      }
    });
  });
  $('.filter-list').on('click', 'li', function () {
    $('.filter-list li').removeClass('active');
    $(this).addClass('active');
    var filterValue = $(this).attr('data-filter');
    $('.grid').isotope({
      filter: filterValue
    });
    $(window).trigger('resize');
  });
  /*---------------====================
     08.Magnify active
     ================-------------------*/

  $('.playVideo').magnificPopup({
    type: 'iframe',
    removalDelay: 300,
    mainClass: 'mfp-fade'
  });
  $('.img-popup').magnificPopup({
    type: 'image',
    gallery: {
      enabled: true
    }
  });
  /*---------------====================
  09.slider range and date picker
  ================-------------------*/

  $('.open-creatac').on("click", function () {
    $(".rt-modal-input.two , .rt-modal-headr.two").addClass("show-cac");
    $(".rt-modal-input.one, .rt-modal-headr.one").addClass("hide-cac");
  });
  $('.rt-selectactive').select2({
    minimumResultsForSearch: Infinity
  });
  $(".rt-date-picker").datepicker();
  $(".slider-range").slider({
    range: true,
    min: 40,
    max: 600,
    values: [160, 500],
    slide: function slide(event, ui) {
      $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
    }
  });
  $(".amount").val("$" + $(".slider-range").slider("values", 0) + " - $" + $(".slider-range").slider("values", 1));
  $('[data-toggle="tooltip"]').tooltip();
  tippy.setDefaults({
    arrow: true,
    delay: 40,
    placement: 'top',
    animation: 'perspective'
  });
  /*
    ==========================================
   10. PROGRESSBAR ACTIVATION
    ==========================================
    */

  $(".progress").each(function () {
    var e = $(this).attr("data-percent"),
        t = $(this).prev(".progress-title"),
        a = $(this).children(".progress-title");
    t.length > 0 ? t.css("width", e) : a.length > 0 && a.css("width", e), $(this).appear(function () {
      $(this).find(".progress-bar").animate({
        width: e
      }, 500);
    });
  });
  /*---------------====================
     11.WOW Active
  ================-------------------*/

  if ($('.wow').length) {
    var wow = new WOW({
      boxClass: 'wow',
      // animated element css class (default is wow)
      animateClass: 'animated',
      // animation css class (default is animated)
      offset: 0,
      // distance to the element when triggering the animation (default is 0)
      mobile: false,
      // trigger animations on mobile devices (default is true)
      live: true // act on asynchronously loaded content (default is true)

    });
    wow.init();
  }
  /*---------------====================
         12.team Testimonilas
   ================-------------------*/


  $('.singleTbox-1').on('click', function (event) {
    event.preventDefault();
    var active = $(this).hasClass('active');
    var parent = $(this).parents('.testimoninal-active-1');

    if (!active) {
      var activeBlock = parent.find('.singleTbox-1.active');
      var currentPos = $(this).attr('data-position');
      var newPos = activeBlock.attr('data-position');
      activeBlock.removeClass('active').removeClass(newPos).addClass('inactive').addClass(currentPos);
      activeBlock.attr('data-position', currentPos);
      $(this).addClass('active').removeClass('inactive').removeClass(currentPos).addClass(newPos);
      $(this).attr('data-position', newPos);
    }
  });
  /*---------------====================
         13.Multitab active
   ================-------------------*/

  $(document).on('click', '#rtMultiTab a', function (e) {
    var otherTabs = $(this).attr('data-secondary').split(',');

    for (var i = 0; i < otherTabs.length; i++) {
      var nav = $('<ul class="nav d-none" id="tmpNav"></ul>');
      nav.append('<li class="nav-item"><a href="#" data-toggle="tab" data-target="' + otherTabs[i] + '">nav</a></li>"');
      nav.find('a').tab('show');
    }
  });
  jQuery(window).load(function () {
    jQuery(".rt-preloder").fadeOut(300);
  });
}); // end ready function