<?php  //Fonts
	$css = get_post_meta( get_the_ID(), 'custom-css', true );
	$meta_top = get_post_meta( get_the_ID(), 'meta-image-intro', true );
	$bg_color = get_post_meta( get_the_ID(), 'meta-bg', true );
	$titleinside = get_post_meta( get_the_ID(), 'section1_title_align', true );
	$theme = get_post_meta( get_the_ID(), 'theme-color', true );
	$meta_color = get_post_meta( get_the_ID(), 'meta-color', true );
	$link = get_post_meta( get_the_ID(), 'meta-link', true );
	$meta_font = get_post_meta( get_the_ID(), 'meta-font', true );
	$meta_font_title = get_post_meta( get_the_ID(), 'meta-font_title', true );
	$intro_title_color = get_post_meta( get_the_ID(), 'section_title_color', true );
	$intro_title_bg = get_post_meta( get_the_ID(), 'section_title_background', true );
	$arrow = get_post_meta( get_the_ID(), 'meta-arrow', true );
	$slide_bg = get_post_meta( get_the_ID(), 'meta-bg', true );
	$meta_loader_titre = get_post_meta( get_the_ID(), 'meta-loader-titre', true );
	$meta_loader_bg = get_post_meta( get_the_ID(), 'meta-loader', true );
	$font_size = get_post_meta( get_the_ID(), 'meta-font-size', true );
	$title_align = get_post_meta( get_the_ID(), 'section_title_align', true );
	$nav_bar = get_post_meta( get_the_ID(), 'netpos', true );
	$nav_bar_color = get_post_meta( get_the_ID(), 'top-bar', true );
	$reseaux = get_post_meta( get_the_ID(), 'reseaux', true );
	$border = get_post_meta( get_the_ID(), 'border', true );
	$modale_infos = get_post_meta( get_the_ID(), 'meta-txt-infos', true );
	$modale_bg = get_post_meta( get_the_ID(), 'meta-txt-bg', true );
		if( !empty( $meta_font)) {	
			if ($meta_font == "select-seven") { ?>	
				<link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>		
			<?php } else if ($meta_font == "select-eight") { ?>
					<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font == "select-six") { ?>
					<link href='https://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font == "select-nine") { ?>
					<link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font == "select-ten") { ?>
					<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font == "select-eleven") { ?>
					<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>	
			<?php } else if ($meta_font == "select-twelve") { ?>
					<link href='https://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font == "select-thirteen") { ?>
					<link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font == "select-fourteen") { ?>
					<link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
			<?php } 
		} 
			
		if( !empty( $meta_font_title) ) {
			if ($meta_font_title == "select-one") { ?>	
					<link href='https://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>		
			<?php } else if ($meta_font_title == "select-two") { ?>
					<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font_title  == "select-three") { ?>
					<link href='https://fonts.googleapis.com/css?family=Arvo:400,700' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font_title == "select-four") { ?>	
					<link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>	
			<?php } else if ($meta_font_title == "select-five") { ?>
					<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font_title == "select-six") { ?>
					<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>	
			<?php } else if ($meta_font_title == "select-seven" || $meta_font == "select-twelve") { ?>
					<link href='https://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font_title == "select-eight") { ?>
					<link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font_title == "select-nine") { ?>
					<link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
			<?php } else if ($meta_font_title == "select-ten") { ?>
					<link href='https://fonts.googleapis.com/css?family=Raleway:600' rel='stylesheet' type='text/css'>	
			<?php } 
		} 
?>