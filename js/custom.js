var $ = jQuery.noConflict();

$(document).ready(function() {

	$('#fullpage').fullpage({
		autoScrolling: false
	});
			
	$('.loader').ClassyLoader({
		percentage: 100,
		speed: 20,
		fontSize: '20px',
		diameter: 40,
		lineColor: 'rgba(31, 31, 31, 0.78)',
		remainingLineColor: 'rgba(232, 232, 232, 0.6)',
		lineWidth: 10       
	});
	
	 if ($(window).width() > 1024) { 
		var taille = $('#section0').height()/1.6;
		$('.slide img').height(taille).width('auto');
	 }

//Scroll
	$('.scrollTo').click( function() { 
		$("html, body").animate({scrollTop: 0}, 1000);
	});
	
	$(window).scroll(function(){
		if ($(this).scrollTop() > 5) {
			$('.navbar-fixed-top').slideDown();
			$('.navbar-fixed-bottom').show();
			$('#edit').show();
			$('#edit_left').show();
			$('.burger').fadeIn();
			$('#nextpage').fadeIn();
		} 
			else {
				$('.navbar-fixed-top').hide();
				$('.navbar-fixed-bottom').hide();
				$('.burger').hide();
				$('#edit').hide();
				$('#edit_left').hide();
				$('#nextpage').hide();
			}
	});
	
	$('.fa-share-alt').click(function(){
		$('#search_bar').slideUp();
		$('#navtop_networks').slideToggle();
		$('.networks_nav').slideToggle();
		$('.networks_nav').css('z-index', '8000');
		$('.networks_nav').css('opacity', '1');
		$('.intro-effect-jam3.modify #navtop_networks').css('display','block');
	});

//Bootstrap JS
	$('[data-toggle="tooltip"]').tooltip(); 
	$('[data-toggle="popover"]').popover();
	
});

$(window).load(function() {
	$(".load_page").animate({top:-1600},1200);
});
