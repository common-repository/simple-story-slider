<?php //WIDGET SIMPLE STORY SLIDER
class storyslider_widget extends WP_Widget {
    public function __construct() {
        parent::__construct(false, $name = 'Simple Story Slider', array('description' => 'Liste des derniers slides publiés. Latest slides.'));
    }
function widget($args, $instance) { 
        extract( $args );
		$storyslider_widget_title = isset( $instance['storyslider_widget_title'] ) ? esc_attr( $instance['storyslider_widget_title'] ) : '';
	    $nr = isset( $instance['nr'] ) ? esc_attr( $instance['nr'] ) : '';
		?>
<div class="widget">
	<h3><?php echo $storyslider_widget_title; ?></h3>
		<div class="txtwidget">
			<ul>
				<?php
				  global $post;
				  $args = array( 'numberposts' => $nr, 'post_type' => array( 'storyslider' ) );
				  $myposts = get_posts( $args );
						foreach( $myposts as $post ) :  setup_postdata($post); ?>
							<li> <a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a> </li>
				 <?php endforeach; ?>
			</ul>
		</div>
</div>
<?php
    }
    function update($new_instance, $old_instance) {
        return $new_instance;
    }
    function form($instance) {
		$storyslider_widget_title = isset( $instance['storyslider_widget_title'] ) ? esc_attr( $instance['storyslider_widget_title'] ) : '';
	    $nr = isset( $instance['nr'] ) ? esc_attr( $instance['nr'] ) : '';
?>
            <p>              <label for="<?php echo $this->get_field_id('storyslider_widget_title'); ?>"><?php _e('Titre :', 'storyslider'); ?> </label>
                <input class="widefat" id="<?php echo $this->get_field_id('storyslider_widget_title'); ?>" name="<?php echo $this->get_field_name('storyslider_widget_title'); ?>" type="text" value="<?php echo esc_attr($storyslider_widget_title); ?>" />
            </p>
			<p>
              <label for="<?php echo $this->get_field_id('nr'); ?>"><?php _e('Nbre de sliders à afficher :', 'storyslider'); ?> </label>
                <input class="widefat" id="<?php echo $this->get_field_id('nr'); ?>" name="<?php echo $this->get_field_name('nr'); ?>" type="text" value="<?php echo esc_attr($nr); ?>" />
            </p><?php       
    }
}
add_action('widgets_init', 'register_storyslider_widget');function register_storyslider_widget() {
    register_widget('storyslider_widget');
}
?>