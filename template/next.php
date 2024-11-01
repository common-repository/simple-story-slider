<?php 
//Display next or previous page if exists
	$nextpage = get_option('nextpage', array() );
		if( !empty( $nextpage ) ) { ?>
			<div id="nextpage"> <?php 	
				$prev_post = get_previous_post();
					if($prev_post) { ?>
						<span class="prevlf">	<?php				
						   $prev_title = strip_tags(str_replace('"', '', $prev_post->post_title)); ?>
						   <span class="fa fa-angle-left"></span><span class="fa fa-angle-left"></span> 
						  <?php echo "\t" . '<a rel="prev" href="' . get_permalink($prev_post->ID) . '" title="' . $prev_title. '" class=" ">' . $prev_title . '</a>' . "\n"; ?> 
						</span> <?php
					}
	
				$next_post = get_next_post();
					if($next_post) {  ?>
						<span class="nextlf">	<?php
						   $next_title = strip_tags(str_replace('"', '', $next_post->post_title));
						   echo "\t" . '<a rel="next" href="' . get_permalink($next_post->ID) . '" title="' . $next_title. '" class=" ">' . $next_title . '</a> <span class="fa fa-angle-right"></span><span class="fa fa-angle-right"></span>' . "\n"; ?> 
						</span> <?php
					} ?>
			</div>
			
			<div style="clear:both;"></div>
	<?php } ?> 