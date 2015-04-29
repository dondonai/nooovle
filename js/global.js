jQuery(document).ready(function($) {

	$('.site-header').backstretch([ dd_global.template_url + '/images/bg-header.jpg' ], {duration: 5000, fade: 750});
	$('.ready-to-help').backstretch([ dd_global.template_url + '/images/bg-ready.jpg' ], {duration: 5000, fade: 750});

	var home_url = $('.site-title a').attr('href');
	// $('.nav-primary').before('<div class="wrap"><div class="navicon"><span class="dashicons dashicons-menu"></span></div></div>');
	// $('.navicon').on('click', function() {
	// 	$('.nav-primary').slideToggle();
	// });
    $('.awesome-works section:last-child() .widget-wrap').addClass('screenshots');

	$('.trusted .entry a').removeAttr('href'); // remove href on featured image :)
	$('.widget-area').attr("data-sr", "enter bottom hustle move 24px "); // add animation to widget-area class
	$('.site-container').attr('id', 'home'); // add id to site-content to navigate to top
	// $('.nav-primary').addClass('sticky-navigation'); // sticky menu
	$('.menu-primary').before('<div class="site-title"><a href="' + home_url + '"></a></div>');
	$('.widget-area .widget-wrap > .widget-title, .entry-content > .widget-title ').append('<div class="blue-line"></div>');
	$('.nav-primary .site-title').addClass('sticky-navigation'); // sticky menu

	var config = {
        easing: 'hustle',
        vFactor: 0.25,
        mobile: true,
        enter: 'bottom',
        reset: true
      };

    window.sr = new scrollReveal();

    // Owl Carousel

    var owl = jQuery(".screenshots");
	owl.owlCarousel({
	    items:3,
	    loop:true,
	    margin:10,
	    autoplay:true,
	    autoplayTimeout:2000,
	    autoplayHoverPause:true,
	    dots: true,
	    responsiveClass:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:1
	        },
	        1000:{
	            items:3
	        }
	    }
	});

	$('.home .site-inner').remove();

	$('.watch-video').fitVids();

	// $('.alignleft img').addClass('animation bounceInLeft');
	$('.featured-content').addClass('animation bounceInRight');

    $('.menu-primary').onePageNav({
    	currentClass: 'current-menu-item',
        scrollThreshold: 0.2, // Adjust if Navigation highlights too early or too late
        scrollOffset: 10, //Height of Navigation Bar
        filter: ':not(.external)',
        changeHash: true
    });

	mainNav();
	$(window).on('scroll', function() {
		var site_wide = $(document).innerWidth();
		if( site_wide > 768 ) mainNav();

	});

    function mainNav() {
        var top = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
        if (top > 40) {
            jQuery('.sticky-navigation').stop().animate({
                "opacity": '1',
                // "top": '0'
            }, 'fast');
        }
        else{
            jQuery('.sticky-navigation').stop().animate({
                "opacity": '0',
                // "top": '-75'
            }, 'fast');
        }

    }



});