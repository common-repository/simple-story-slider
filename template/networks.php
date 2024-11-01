<?php $email = get_option('email', array() ); if( !empty( $email ) ) { ?>	
	<a title="<?php _e('Partager par e-mail', 'storyslider'); ?>" href="mailto:?subject=<?php _e('Un ami souhaite partager cet article avec vous :', 'storyslider'); ?> <?php the_title(); ?>&amp;body=<?php _e('Découvrez :', 'storyslider'); ?> <strong><?php the_title(); ?></strong>&nbsp;:&nbsp;<a href=<?php the_permalink() ?>><?php the_permalink() ?></a>" rel="nofollow"><span class="fa fa-envelope-o fa-lg"></span><span class="screen-reader-text"><?php _e('Partager par e-mail', 'storyslider'); ?></span></a>					
<?php } 

$twitter = get_option('twitter', array() ); if( !empty( $twitter ) ) { ?>	
	<a target="_blank" href="https://twitter.com/home?status=<?php the_title(); ?>+<?php the_permalink();  echo " via ";  $options = get_option('twitter_url', array() ); echo $options;?>"><span class="fa fa-twitter fa-lg"></span><span class="screen-reader-text"><?php _e('Partager cet article sur Twitter', 'storyslider'); ?></span></a>
<?php } 

$facebook = get_option('facebook', array() ); if( !empty( $facebook ) ) { ?>	
	<a href="https://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" target="blank"><span class="fa fa-facebook fa-lg" title="<?php _e('Partager sur Facebook', 'storyslider'); ?>"></span><span class="screen-reader-text"><?php _e('Partager cet article sur Facebook', 'storyslider'); ?></span></a>
<?php } 

$linkedin = get_option('linkedin', array() ); if( !empty( $linkedin ) ) { ?>	
	<a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&summary=&source=<?php get_home_url(); ?>" title="<?php _e('Partager sur LinkedIn', 'storyslider'); ?>"><span class="fa fa-linkedin fa-lg"></span><span class="screen-reader-text"><?php _e('Partager sur LinkedIn', 'storyslider'); ?></span></a>
<?php } ?> 