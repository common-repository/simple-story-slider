jQuery(document).ready(function($){

			$(".theEditor").jqte({color: false});
			
			$('#tab2').css('display','none');
			$('#tab2').hide();
			$('#tab3').css('display','none');
			$('#tab3').hide();
			
			$('.navtab1').click(function() {
				$('#tab1').css('display','block');
				$('#tab2').css('display','none');
				$('#tab3').css('display','none');
				$('.active1').css('background','#FFFFFF').css('color', '#07bac4');
				$('.active2').css('background','#E4E4E4').css('color', '#686868');
				$('.active3').css('background','#E4E4E4').css('color', '#686868');
			});
			
			$('.navtab2').click(function() {
				$('#tab2').css('display','block');
				$('#tab1').css('display','none');
				$('#tab3').css('display','none');
				$('.active2').css('background','#FFFFFF').css('color', '#07bac4');
				$('.active3').css('background','#E4E4E4').css('color', '#686868');
				$('.active1').css('background','#E4E4E4').css('color', '#686868');
			});
			
			$('.navtab3').click(function() {
				$('#tab3').css('display','block');
				$('#tab1').css('display','none');
				$('#tab2').css('display','none');
				$('.active3').css('background','#FFFFFF').css('color', '#07bac4');
				$('.active2').css('background','#E4E4E4').css('color', '#686868');
				$('.active1').css('background','#E4E4E4').css('color', '#686868');
			});
			
			$('.remove_slider_story').click(function() {
				$('.img-story').hide();
				$('input[type=text].meta-image-intro').val(" ");
			});

});