var $ = jQuery.noConflict();
$(document).ready(function($) {

      var meta_image_frame;

      $('#meta-image-button-slider-story').live('click', function(e){
            e.preventDefault();

            if( meta_image_frame ){
                meta_image_frame.open();
                return;
            }

            meta_image_frame = wp.media.frames.file_frame = wp.media({
                title: 'Simple Story Slider Image',
                library: { type: 'image'},
                  multiple: false
            });

            meta_image_frame.on('select', function(){
                var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

                   var url = '';

                $('#meta-image-intro').val(media_attachment.url);

            });

            meta_image_frame.open();

      });
	  
/*REPEATBLE IMAGE FIELDS*/
  
	  var meta_image_frame_story;
	  var target_input;
      
	  $("input[class^='meta-image-sider-story']").live('click', function(e){
            e.preventDefault();
			
			target_input = $(this).prev().attr('id');
            
			if( meta_image_frame_story ){
                meta_image_frame_story.open();
                return;
            }
		
            meta_image_frame_story = wp.media.frames.file_frame = wp.media({
                title: 'Simple Story Slider Image',
                library: { type: 'image'},
                  multiple: false
            });

			
            meta_image_frame_story.on('select', function(){
                
				target_input = '#' + target_input;
				var media_attachment = meta_image_frame_story.state().get('selection').first().toJSON();
				var url = '';
                $(target_input).val(media_attachment.url);
            });

            meta_image_frame_story.open();
			return;
      });

});