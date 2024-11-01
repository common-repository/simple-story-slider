<?php
/*
Template : Simple Story Slider
*/
?>
<!DOCTYPE html>
<?php $metadatas = get_option('ssl_metadata', array() ); ?>
<html xmlns="https://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta name="msapplication-config" content="none"/>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title><?php the_title(); ?></title>
<?php $option_wp = get_option('ssl_linked', array() );	
if( !empty( $option_wp ) ) :
	wp_head(); ?>
	<style>.logged-in .navbar-fixed-top{margin-top:28px;}</style>
<?php
	else :
	$bootstrap = plugin_dir_url( __FILE__ ) . '../css/bootstrap.min.css'; 
	$css = plugin_dir_url( __FILE__ ) . '../css/template/style.css'; 
	$normalize = plugin_dir_url( __FILE__ ) . '../css/normalize.css'; 
	$print = plugin_dir_url( __FILE__ ) . '../css/print.css'; ?>
		<title><?php the_title(); ?></title>	
		<link rel="stylesheet" href="<?php echo $bootstrap; ?>" media="all" />
		<link rel="stylesheet" href="<?php echo $normalize; ?>" media="screen" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" media="all" />
		<link rel="stylesheet" href="<?php echo $print; ?>" media="print" />
		<link rel="stylesheet" href="<?php echo $css; ?>" media="all" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<?php endif;  
include("head.php"); ?>
<style type="text/css">
	<?php if( !empty( $meta_top ) ) { ?>
		#section0{background: <?php echo $bg_color; ?> url('<?php echo $meta_top; ?>') no-repeat center center fixed!important; -webkit-background-size: cover!important;-moz-background-size: cover!important;-o-background-size: cover!important;background-size: cover!important;
		min-width: 100%; min-height: 100%;}
	<?php } 
	if( !empty( $font_size ) ) { 
		if ($font_size == "select-one") { ?>
			body,html{font-size:1.1em;}
		<?php } else if ($font_size == "select-two") { ?>
			body,html{font-size:1.2em;}
		<?php } else if ($font_size == "select-three") { ?>
			body,html{font-size:1em;}
		<?php } 
	} 
	if( !empty( $meta_color ) ) { ?>
		body,html{color: <?php echo $meta_color; ?>}
	<?php }
	if( !empty( $link ) ) { ?>
		a, a:link, a:visited{color: <?php echo $link; ?>}
	<?php }
	if( !empty( $slide_bg ) ) { ?>
		.section{background: <?php echo $slide_bg; ?>;}
	<?php } 
	if( !empty( $intro_title_color ) ) { ?>
		.intro h1 {color:<?php echo $intro_title_color; ?>;}
	<?php } 
	if( !empty( $intro_title_bg ) ) { 
		if ($intro_title_bg == "select-two") { ?>
		.intro h1 {background: #666666; opacity:0.8;padding:1.4em;}
		<?php } else if ($intro_title_bg == "select-three") { ?>
		.intro h1 {background:<?php echo $theme; ?>; opacity:0.8;padding:1.4em;}
		<?php } 
	} 
	
	if( !empty( $title_align ) ) { 
		if ($title_align == "select-one") { ?>
		.intro h1 {text-align:center;margin: 0 auto!important;width:80%;} 
		<?php } else if ($title_align == "select-two") { ?>
		.intro h1 {text-align:center;margin-right:20%!important;width:80%;}
		<?php } else if ($title_align == "select-three") { ?>
		.intro h1 {text-align:center;margin-left:20%!important;width:80%;}
		<?php } 
	}
	
	if( !empty( $meta_loader_titre ) ) { ?>
		.load_page h1 {color:<?php echo $meta_loader_titre; ?>;}
	<?php }

	if( !empty( $meta_loader_bg ) ) { ?>
		.load_page {background:<?php echo $meta_loader_bg; ?>;}
	<?php }
	
	if( !empty( $theme ) ) { ?>
		.burger,#fullpage a,#nextpage a,#nextpage{color:<?php echo $theme; ?>;}.number{background:<?php echo $theme; ?>;color:<? echo $reseaux; ?>;}
	<?php }
	
	if( !empty( $arrow ) ) { ?>
		.fp-controlArrow.fp-prev {border-color: transparent <?php echo $arrow; ?> transparent transparent;}.fp-controlArrow.fp-next {border-color: transparent transparent transparent <?php echo $arrow; ?>;}
	<?php }
	
	if( !empty( $modale_infos ) ) { 
		if ($modale_infos == "select-one") { ?>
			.modal-content,.modal-body{color: <?php echo $meta_color; ?>;}
		<?php } else if ($modale_infos == "select-two") { ?>
			.modal-content{color: #FFFFFF;}
		<?php } else { ?>
			.modal-content,.modal-body,.modal-title{color: #222222;}
		<?php }
	 }
	
	if( !empty( $modale_bg ) ) { 
		if ($modale_bg == "select-one") { ?>
			.modal-content{background: <?php echo $theme; ?>;}
		<?php } else { ?>
			.modal-content{background: #FFFFFF;}
		<?php }
	 }
	
	if( !empty( $nav_bar_color ) ) { ?>
		.navbar-fixed-top, .navbar-fixed-bottom, #sidebar {background:<?php echo $nav_bar_color; ?>;}
	<?php }

	if( !empty( $reseaux ) ) { ?>
		.navbar-fixed-top, .navbar-fixed-top a,.navbar-fixed-bottom, .navbar-fixed-bottom a, #sidebar {color:<?php echo $reseaux; ?>;}
	<?php }
		
	if( !empty( $border ) ) { 
			if ($border == "select-two") { ?>
				.navbar-fixed-top {border-bottom:1px solid <?php echo $arrow ?>;}.navbar-fixed-bottom {border-top:1px solid <?php echo $arrow ?>;}
	<?php } 
	}
	if( !empty( $meta_font ) ) {
		if ($meta_font == "select-one") { ?>
			html, body {font-family: Arial, Helvetica, sans-serif;}
		<?php } else if ($meta_font == "select-two") { ?>
			html, body {font-family: Georgia, serif;}
		<?php } else if ($meta_font == "select-three") { ?>
			html, body {font-family: Tahoma, Geneva, sans-serif;}
		<?php } else if ($meta_font == "select-four") { ?>
			html, body {font-family: "Times New Roman", Times, serif;}
		<?php } else if ($meta_font == "select-five") { ?>
			html, body {font-family: Verdana, Geneva, sans-serif;}
		<?php } else if ($meta_font == "select-six") { ?>
			html, body {font-family: 'Arvo', serif;}
		<?php } else if ($meta_font == "select-seven") { ?>
			html, body {font-family: 'Droid Sans', sans-serif;}
		<?php } else if ($meta_font == "select-eight") { ?>
			html, body {font-family: 'Open Sans', sans-serif;}
		<?php } else if ($meta_font == "select-nine") { ?>
			html, body {font-family: 'Roboto', sans-serif;}
		<?php } else if ($meta_font == "select-ten") { ?>
			html, body {font-family:'Roboto Slab', serif;}
		<?php } else if ($meta_font == "select-eleven") { ?>	
			html, body {font-family: 'Lato', sans-serif;}
		<?php } else if ($meta_font == "select-twelve") { ?>
			html, body {font-family: 'Ubuntu Condensed', sans-serif;}
		<?php } else if ($meta_font == "select-thirteen") { ?>
			html, body {font-family: 'Inconsolata', cursive;}
		<?php } else if ($meta_font == "select-fourteen") { ?>
			html, body {font-family: 'Playfair Display', serif;}
		<?php }
	} 
		if( !empty( $meta_font_title ) ) {
			if ($meta_font_title == "select-one") { ?>
			h1,h2,h3,h4,h5,h6 {font-family: 'Droid Sans', sans-serif;}
			<?php } else if ($meta_font_title == "select-two") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Open Sans', sans-serif;}
			<?php } else if ($meta_font_title  == "select-three") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Arvo', serif;}
			<?php } else if ($meta_font_title == "select-four") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Roboto', sans-serif;}
			<?php } else if ($meta_font_title == "select-five") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Roboto Slab', serif;}
			<?php } else if ($meta_font_title == "select-six") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Lato', sans-serif;}
			<?php } else if ($meta_font_title == "select-seven") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Ubuntu Condensed', sans-serif;}
			<?php } else if ($meta_font_title == "select-eight") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Inconsolata', cursive;}
			<?php } else if ($meta_font_title == "select-nine") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Playfair Display', serif;}
			<?php } else if ($meta_font_title == "select-ten") { ?>
				h1,h2,h3,h4,h5,h6 {font-family: 'Raleway', sans-serif;}
			<?php } 
		} 
		if( !empty( $titleinside ) ) { 
			if ($titleinside == "select-two") {?>	
				.title{text-align:left;}	
		<?php } elseif ($titleinside == "select-three") { ?>		
				.title{text-align:right;}
		<?php }
		}
		if( !empty( $css ) ) { 
			echo $css;
		}
		if( !empty( $nav_bar ) ) { 
			if ($nav_bar == "select-one") { ?>
				.burger{bottom:10px;right:10px;}#nextpage{bottom:10px;right:70px;}
			<?php } else { 
				if( !empty( $option_wp ) ) : ?>
				.logged-in .burger{top:40px;}.logged-in #nextpage{top:40px;}
				<?php endif; ?>
				.burger{top:10px;right:10px;}#nextpage{top:10px;right:70px;}
			<?php } 
		} 
		if( !empty( $nav_bar ) ) { 
			if ($nav_bar == "select-one") { ?>
				.section1{margin-top:40px!important;}.number{float:left;bottom:15px;}
			<?php } else { ?>
				.section1{margin-top:-40px!important;}.number{float:left;top:15px;}.logged-in .number{top:30px;}
		<?php }
		} ?>
	</style>
<?php if( !empty( $metadatas ) ) :	
			 
		$twitter_url    = get_permalink();
		$twitter_title  = get_the_title();
		$meta_subline = get_post_meta( get_the_ID(), 'meta-subline', true );
		$category = get_the_category(); 
		$cat = $category[0]->cat_name;
		$fname = get_the_author_meta('first_name');
		$lname = get_the_author_meta('last_name');
		$author = trim( "$fname $lname" );
		$site_lang = get_bloginfo('language');
		
	?>
	<meta property="og:title" content="<?php the_title(); ?>"/>
	<meta property="og:description" content="<?php echo $meta_subline; ?>"/>
	<meta property="og:url" content="<?php the_permalink(); ?>"/>
	<meta property="og:image" content="<?php $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); echo $thumb_url[0]; ?>" />
	<meta property="og:type" content="<?php echo "article"; ?>"/>
	<meta name="twitter:card" value="summary_large_image" />
	<meta name="twitter:url" value="<?php echo $twitter_url; ?>" />
	<meta name="twitter:title" value="<?php echo $twitter_title; ?>" />
	<meta name="twitter:description" value="<?php echo $meta_subline; ?>" />
	<meta name="twitter:image" value="<?php  $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); echo $thumb_url[0]; ?>" />
	<meta name="twitter:site" value="<?php echo  $options = get_option('twitter_url', array() ); ?>" />
	<meta name="twitter:creator" value="<?php echo  $options = get_option('twitter_url', array() ); ?>" />
	<meta name="DC.Title" content="<?php the_title(); ?>">
	<meta name="DC.Publisher" content="<?php echo get_bloginfo('name'); ?>">
	<meta name="DC.Language" scheme="UTF-8" content="<?php echo $site_lang; ?>">
	<?php if ( !empty($author) ) { ?>
	<meta name="DC.Creator" content="<?php echo $author; ?>">
<?php } if (!empty($cat)) { ?><meta name="DC.Subject" content="<?php echo $cat; ?>"> <?php } ?>
	<meta name="DC.Description" content="<?php echo $meta_subline; ?>">
	<meta name="DC.Identifier" content="<?php the_permalink(); ?>">
	<meta name="DC.Date" content="<?php the_time('Y-m-d'); ?>">
	<meta name="DC.Title" content="<?php the_title(); ?>">
	<meta name="DC.Publisher" content="<?php echo get_bloginfo('name'); ?>">
	<meta name="DC.Language" scheme="UTF-8" content="<?php echo $site_lang; ?>">
<?php endif; ?>			
</head>

<body id="top" <?php body_class(); ?>>

	<div class="load_page"> 
		<div class="inner">
			<h1><?php the_title(); ?></h1>
			<canvas class="loader"></canvas>
		</div>
	</div>
	
<!--FIXED BAR-->
<?php if( !empty( $nav_bar ) ) { 
		if ($nav_bar == "select-one") { ?>

			<nav class="navbar navbar-fixed-top">
				  <div class="col-md-12 navbar-brand">
					  <a id="home" href="<?php echo get_site_url(); ?>" target="_blank"><span class="glyphicon glyphicon-home"></span></a>
					
					  <span id="top_title">
						<?php the_title(); ?>
					  </span>
					  
					  <div id="networks">
						<?php require_once('networks.php'); ?>
					  </div>
				</div>
			</nav>
				<?php require_once('next.php'); ?> 
				<div class="burger"> <span class="glyphicon glyphicon-menu-hamburger" data-toggle="modal" data-target="#storySlider"></span></div>
<?php } else { ?>
	<nav class="navbar navbar-fixed-bottom">
		  <div class="col-md-12 navbar-brand">
			   <a id="home" href="<?php echo get_site_url(); ?>" target="_blank"><span class="glyphicon glyphicon-home"></span></a>
				<span id="top_title">
					<a href="#section0" class="scrollTo"><?php the_title(); ?></a>
		    	</span>
					  
					  <div id="networks">
					  <?php require_once('networks.php'); ?>
					  </div>
		</div>
	</nav>
		<?php require_once('next.php'); ?> 
		<div class="burger"> <span class="glyphicon glyphicon-menu-hamburger" data-toggle="modal" data-target="#storySlider"></span></div>
<?php }
} ?>

<div id="fullpage">
	<?php if( !empty( $meta_top ) ) { ?>
	<div class="section" id="section0">
		<div class="intro">
			<h1><?php the_title(); ?></h1>
		
			<div id="navigate">
				<a class="scrollTo" href="#section1">
				<svg  version="1.1" id="Layer_1" xmlns="&ns_svg;" xmlns:xlink="&ns_xlink;" width="90" height="100" viewBox="0 0 90 100"
						 overflow="visible" enable-background="new 0 0 90 100" xml:space="preserve">
					<rect x="25.25" y="33.542" fill="none" stroke="<?php echo $arrow  ?>" stroke-width="2" stroke-miterlimit="10" width="39.5" height="32.916"/>
					<path fill="none" stroke="<?php echo $arrow  ?>" stroke-miterlimit="10" d="M85.27,33.542H64.75v32.916h20.52C87.346,61.38,88.5,55.826,88.5,50
						S87.346,38.62,85.27,33.542z"/>
					<path fill="none" stroke="<?php echo $arrow  ?>" stroke-miterlimit="10" d="M25.25,33.542H4.731C2.654,38.62,1.5,44.174,1.5,50
						s1.154,11.38,3.231,16.458H25.25V33.542z"/>
					<g>
						<line fill="none" stroke="<?php echo $arrow  ?>" stroke-width="2" stroke-miterlimit="10" x1="45" y1="74.584" x2="45" y2="86"/>
						<g>
							<polygon fill="<?php echo $arrow  ?>" points="40.91,77.898 41.643,78.58 44.999,74.969 48.355,78.58 49.089,77.898 44.999,73.5 		"/>
						</g>
					</g>
					<g>
						<line fill="none" stroke="<?php echo $arrow  ?>" stroke-width="2" stroke-miterlimit="10" x1="45" y1="13" x2="45" y2="24.416"/>
						<g>
							<polygon fill="<?php echo $arrow  ?>" points="40.91,21.102 41.643,20.42 44.999,24.032 48.355,20.42 49.089,21.102 44.999,25.5 		"/>
						</g>
					</g>
					<circle fill="none" stroke="<?php echo $arrow  ?>" stroke-width="2" stroke-miterlimit="10" cx="45" cy="50" r="43.5"/>
					<g>
						<line fill="none" stroke="<?php echo $arrow  ?>" stroke-width="2" stroke-miterlimit="10" x1="81.666" y1="50.5" x2="70.25" y2="50.5"/>
						<g>
							<polygon fill="<?php echo $arrow  ?>" points="78.352,46.41 77.67,47.143 81.281,50.499 77.67,53.855 78.352,54.589 82.75,50.499 		"/>
						</g>
					</g>
					<g>
						<line fill="none" stroke="<?php echo $arrow  ?>" stroke-width="2" stroke-miterlimit="10" x1="19.75" y1="50.5" x2="8.334" y2="50.5"/>
						<g>
							<polygon fill="<?php echo $arrow  ?>" points="11.648,46.41 12.33,47.142 8.718,50.499 12.33,53.855 11.648,54.589 7.25,50.499 		"/>
						</g>
					</g>
					</svg>
				</a>
			</div>
		</div>
		
	</div>
	<?php } 
	$disposition = get_post_meta( get_the_ID(), 'disposition', true );
	
	if ($disposition == "select-one") : ?>	

		<div class="section col-md-12 left" id="section1">

			<?php 
			$n = 1;	
			$shortcode = get_post_meta($post->ID,'shortcode',true);		
				if ( count( $shortcode ) > 0 ) {
					if(is_array($shortcode)){
						foreach( $shortcode as $story ) {
						?>
						<div class="slide" id="slide<?php echo $n;?>">
							<?php
								$title = $story['story_title'];
								$text =  $story['story_text'];
								$image = $story['story_image'];
								$story_embed = $story['story_iframe'];
							?> 
						
						<div class="number">
							<?php echo $n; ?>
						</div>
								<div class="bloc-story col-md-12"> 
									<p class="title"><?php echo $title; ?></p>
								</div>
					
					<?php if( !empty ( $text ) && !empty( $image ) || !empty( $story_embed ) ){ 	
							
							if( !empty( $text ) ): ?>
									<div class="bloc-story col-md-5"> 
									<?php echo $text; ?> 
									</div> 
							<?php endif; 
							
								if( !empty( $image ) ): ?>			
									<div class="img-story col-md-7">
										 <img src="<?php echo $image; ?>" style="margin-top:10px;" class="imgtop" />			
									</div>
								<?php endif; 						
								
								if( !empty( $story_embed ) ): ?>			
									<div class="img-story col-md-7">
										 <?php echo $story_embed; ?>
									</div>
								<?php endif; 
					} else { ?>
							<div class="bloc-story-full col-md-12"> 
								<?php if (!empty($image) ) { ?> 
									<img src="<?php echo $image; ?>" />			
								<?php }
									elseif (!empty( $story_embed ) ) { echo $story_embed; }
									else { echo $text; }
								?> 
							</div>			
					<?php }
							$n = $n+1; ?> 
							<div style="clear:both;"></div>
						</div>
							<?php
							}
					}
				} 
				//Modal Window (infos) 
				?>
				
		</div>

		<?php endif; 
		
		if ($disposition == "select-two") : ?>

		<div class="section col-md-12 right" id="section1">

			<?php 
			$n = 1;	
			$shortcode = get_post_meta($post->ID,'shortcode',true);		
				if ( count( $shortcode ) > 0 ) {
					if(is_array($shortcode)){
						foreach( $shortcode as $story ) {
						?>
						<div class="slide" id="slide<?php echo $n;?>">
							<?php
								$title = $story['story_title'];
								$text =  $story['story_text'];
								$image = $story['story_image'];
								$story_embed = $story['story_iframe'];
							?> 
						
						<div class="number">
							<?php echo $n; ?>
						</div>
								<div class="bloc-story col-md-12"> 
									<p class="title"><?php echo $title; ?></p>
								</div>
					
					<?php if( !empty ( $text ) && !empty( $image ) || !empty( $story_embed ) ){ 
								if( !empty( $image ) ): ?>			
									<div class="img-story col-md-7">
										 <img src="<?php echo $image; ?>" style="margin-top:10px;" class="imgtop" />			
									</div>
								<?php endif; 
									if( !empty( $story_embed ) ): ?>			
									<div class="img-story col-md-7">
										 <?php echo $story_embed; ?>
									</div>
								<?php endif; 
								if( !empty( $text ) ): ?>
									<div class="bloc-story col-md-5"> 
									<?php echo $text; ?> 
									</div> 
							<?php endif;
				} 
					else { ?>
							<div class="bloc-story-full col-md-12"> 
								<?php 
									if (!empty($image) ) { ?> <img src="<?php echo $image; ?>" />			
									<?php }
									elseif (!empty( $story_embed ) ) { echo $story_embed; }
									else { echo $text; }
								?> 
							</div>		
					<?php }
							$n = $n+1; ?> 
							<div style="clear:both;"></div>
						</div>
							<?php
							}
					}
				} 
				//Modal Window (infos) 
				?>
				
		</div>


		<?php endif; ?>
	
	<div class="modal fade" id="storySlider" tabindex="-1" role="dialog" aria-labelledby="storyslider">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true"><span class="glyphicon glyphicon-remove"> </span></span>
			</button>
			<h2 class="modal-title" id="storyslider"><?php the_title(); ?></h2>
		  </div>
		  <div class="modal-body">
			<?php 
			$meta_auteur = get_post_meta( get_the_ID(), 'meta-auteur', true );
			if( !empty( $meta_auteur ) ) { ?>
				<div class="auteur">
					<span class="glyphicon glyphicon-user"> </span> <?php echo $meta_auteur; ?>
				</div>
			<?php } 
			$meta_date = get_post_meta( get_the_ID(), 'meta-date', true );
			if( !empty( $meta_date ) ) { 
				if ($meta_date == "select-one") { ?> 
				<div class="date">
					<span class="glyphicon glyphicon-time"></span> 
					<?php the_time(__('j-m-Y','storyslider')); ?>
				</div>
			<?php } 
			} ?>
			<?php 
			$meta_subline = get_post_meta( get_the_ID(), 'meta-subline', true );
			if( !empty( $meta_subline ) ) { ?>
			<div class="subline">
				<?php echo $meta_subline; ?>
			</div>
			<?php } ?>
		  </div>
		  <div class="modal-footer">
			
		  </div>
		</div>
	  </div>
	</div>
</div>
<!-- /fullpage -->
	<?php 
		if( !empty( $option_wp ) ) : 
		wp_footer();  
		else:
			$ui = plugin_dir_url( __FILE__ ) . '../js/jquery-ui.min.js'; 
			$bootstrap = plugin_dir_url( __FILE__ ) . '../js/bootstrap.min.js'; 
			$classie = plugin_dir_url( __FILE__ ) . '../js/jquery.fullPage.min.js'; 
			$loader = plugin_dir_url( __FILE__ ) . '../js/jquery.classyloader.min.js'; 
			$parallax = plugin_dir_url( __FILE__ ) . '../js/jquery.slimscroll.min.js'; 
			$back = plugin_dir_url( __FILE__ ) . '../js/custom.js'; ?>
				<script type="text/javascript" src="<?php echo $ui; ?>" defer></script>
				<script type="text/javascript" src="<?php echo $bootstrap; ?>" defer></script>
				<script type="text/javascript" src="<?php echo $classie; ?>" defer></script>
				<script type="text/javascript" src="<?php echo $loader; ?>" defer></script>
				<script type="text/javascript" src="<?php echo $parallax; ?>" defer></script>
				<script type="text/javascript" src="<?php echo $back; ?>" defer></script>
			<?php endif;
		$options = get_option('google_analytics', array() );
		if( !empty( $options ) ) { 
			echo $options;
		} 
	?> 
</body>
</html>