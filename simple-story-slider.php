<?php
/*
Plugin Name: Simple Story Slider
Plugin URI: http://www.ohmybox.info
Description: Réaliser des sliders dynamiques, le plugin facile pour des histoires qui slident.
Version: 1.3.2
Author: Laurence/OhMyBox.info
Author URI: http://www.ohmybox.info
Text domain: storyslider
Domain Path: /languages/
License: GPL2
Simple Story Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
Simple Story Slider  is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/

if ( ! defined( 'ABSPATH' ) ) exit; 

function storyslider_init() {
 load_plugin_textdomain( 'storyslider', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}
add_action('init', 'storyslider_init');

function storyslider_admin_styles(){
	
	global $typenow;
	
    if( $typenow == 'storyslider' && is_admin() ) :   
		wp_enqueue_style( 'storyslider_meta_box_styles', plugins_url( '/css/admin/admin.css', __FILE__ ) );
		wp_enqueue_style( 'jqueryte-css', plugins_url( '/css/admin/jquery-te-1.4.0.css', __FILE__ ) );
		wp_enqueue_style( 'wp-color-picker' );        
		wp_enqueue_script( 'jqueryte-js', plugin_dir_url( __FILE__ ) . 'js/admin/jquery-te-1.4.0.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'meta-box-color-js', plugin_dir_url( __FILE__ ) . 'js/admin/storyslider-box-color.js', array( 'wp-color-picker' ) );  
		wp_enqueue_script( 'storyslider-nav', plugin_dir_url( __FILE__ ) . 'js/admin/storyslider-nav.js', array( 'jquery' ) );
	endif;
}

add_action( 'admin_enqueue_scripts', 'storyslider_admin_styles' );
add_action( 'admin_print_styles-$hook', 'storyslider_admin_styles' );

//CPT Slidestory
function storyslider_create_post_type() {
  register_post_type( 'storyslider',
    array(
      'labels' => array(
        'name' => __( 'Story Sliders'),
        'singular_name' => __( 'Story Slider', 'storyslider' ),
		'add_new' => __( 'Créer', 'storyslider' ),
        'add_new_item' => __( 'Ajouter un Story Slider', 'storyslider' ),
        'edit_item' => __( 'Editer un Story Slider', 'storyslider' ),
        'new_item' => __( 'Nouveau Story Slider', 'storyslider' ),
        'view_item' => __( 'Voir le Story Slider', 'storyslider' ),
        'search_items' => __( 'Rechercher un Story Slider', 'storyslider' ),
        'not_found' => __( 'Aucun Story Slider trouvé', 'storyslider' ),
        'not_found_in_trash' => __( 'Aucun Story Slider dans la corbeille', 'storyslider' ),
        'parent_item_colon' => __( 'Story Slider (parent) :', 'storyslider' )
      ),
      'public' => true,
	  'publicly_queryable' => true,
      'has_archive' => true,
	  'menu_position' => 5,
	  'show_ui' => true,
	  'menu_icon' => 'dashicons-images-alt2',
	  'rewrite' => array('slug' => 'storyslider', 'with_front' => true),
	  'supports' => array( 'title', 'thumbnail', 'revisions', 'tags', 'excerpt' ),
	  'taxonomies' => array( 'post_tag', 'category' )
    )
  );
}
add_action( 'init', 'storyslider_create_post_type' );

//Flush
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'storyslider_flush_rewrites' );
function storyslider_flush_rewrites() {
	storyslider_create_post_type();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'flush_rewrite_rules' );

//Homepage
function themeprefix_show_cpt_archives( $query ) {
 if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
	 $query->set( 'post_type', array(
	 'post', 'nav_menu_item', 'storyslider', 'longform'
	 ));
	 return $query;
	 
		if ( !is_admin() && is_home() || is_front_page() && $query->is_main_query() ) {
			$query->set('post_type', array( 'post', 'storyslider', 'longform', 'nav_menu_item') );
		return $query; }		
	}
	if ( !is_admin() && is_search() && $query->is_main_query() ) {
		$query->set('post_type', array( 'post', 'storyslider', 'longform', 'nav_menu_item') );
	return $query; }
 }

add_filter( 'pre_get_posts', 'themeprefix_show_cpt_archives' );


//Preview (debug)
add_filter('_wp_post_revision_fields', 'add_storyslider_debug_preview');
function add_storyslider_debug_preview($fields){
   $fields["debug_preview"] = "debug_preview";
   return $fields;
}

add_action( 'edit_form_after_title', 'storyslider_input_debug_preview' );
function storyslider_input_debug_preview() {
   echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}

//Excerpt
add_filter( 'get_the_excerpt', 'storyslider_excerpt' );
function storyslider_excerpt($excerpt) {
global $post;
	$texte = get_post_meta( get_the_ID(), '_storyslider_editor_text', true );
		if( !empty( $texte )  ) { 
			$excerpt = wp_strip_all_tags($texte);
			return $excerpt;
		}
			else {
				return $excerpt;
			}
}

//Metaboxes
function add_storyslider_meta_box()
{
    add_meta_box("storyslider-meta-box", __("Configuration", "storyslider"), "storyslider_meta_callback", "storyslider", "side", "high", null);
}
add_action("add_meta_boxes", "add_storyslider_meta_box");

function storyslider_custom_meta() {
    add_meta_box( 'storyslider_meta', __( 'Configuration', 'storyslider' ), 'storyslider_meta_callback', 'storyslider' );
}

function storyslider_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'storyslider_nonce' );
    $storyslider_stored_meta = get_post_meta( $post->ID );
?>

<div id="wrap">

<h4 class="nav-tab-wrapper">	 
	<a href="#" class="nav-tab navtab1 active1"> <?php _e( 'Général', 'storyslider' ); ?> </a>
	<a href="#" class="nav-tab navtab2 active2"> <?php _e( 'Intro', 'storyslider' ); ?> </a>	
	<a href="#" class="nav-tab navtab3 active3"> <?php _e( 'Contenu', 'storyslider' ); ?> </a>	 
</h4> 
 
<div id="tab1" class="ui-sortable meta-box-sortables">	
	
	
	<p>
		 <label for="theme-color" class="storyslider-color"><?php _e( 'Couleur du thème', 'storyslider' )?></label>		
		 <br/>		
		 <input name="theme-color" type="text" value="<?php if ( isset ( $storyslider_stored_meta['theme-color'] ) ) echo $storyslider_stored_meta['theme-color'][0]; ?>" class="meta-color" />	
	</p>
	
	<p>
		 <label for="meta-bg" class="storyslider-color"><?php _e( 'Couleur de background (slides)', 'storyslider' )?></label>		
		 <br/>		
		 <input name="meta-bg" type="text" value="<?php if ( isset ( $storyslider_stored_meta['meta-bg'] ) ) echo $storyslider_stored_meta['meta-bg'][0]; ?>" class="meta-color" />	
	</p>
	
	<p>
		<label for="meta-font" class="storyslider-font"><?php _e( 'Police de caractères (textes)', 'storyslider' )?></label>
		<br/>
			<select name="meta-font" id="meta-font">
				<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-one' ); ?>><?php _e( 'Arial, Helvetica, sans-serif', 'storyslider' )?></option>';
				<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-two' ); ?>><?php _e( 'Georgia, serif', 'storyslider' )?></option>';
				<option value="select-three" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-three' ); ?>><?php _e( 'Tahoma, Geneva, sans-serif', 'storyslider' )?></option>';
				<option value="select-four" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-four' ); ?>><?php _e( 'Times New Roman, Times, serif', 'storyslider' )?></option>';
				<option value="select-five" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-five' ); ?>><?php _e( 'Verdana, Geneva, sans-serif', 'storyslider' )?></option>';
				<option value="select-six" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-six' ); ?>><?php _e( 'Arvo, serif', 'storyslider')?></option>';
				<option value="select-seven" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-seven' ); ?>><?php _e( 'Droid Sans, sans-serif', 'storyslider' )?></option>';
				<option value="select-eight" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-eight' ); ?>><?php _e( 'Open Sans, sans-serif', 'storyslider' )?></option>';
				<option value="select-nine" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-nine' ); ?>><?php _e( 'Roboto, sans-serif', 'storyslider' )?></option>';
				<option value="select-ten" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-ten' ); ?>><?php _e( 'Roboto Slab, serif', 'storyslider' )?></option>';
				<option value="select-eleven" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-eleven' ); ?>><?php _e( 'Lato, sans-serif', 'storyslider' )?></option>';
				<option value="select-twelve" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-twelve' ); ?>><?php _e( 'Ubuntu Condensed, sans-serif', 'storyslider' )?></option>';
				<option value="select-thirteen" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-thirteen' ); ?>><?php _e( 'Inconsolata, cursive', 'storyslider' )?></option>';
				<option value="select-fourteen" <?php if ( isset ( $storyslider_stored_meta['meta-font'] ) ) selected( $storyslider_stored_meta['meta-font'][0], 'select-fourteen' ); ?>><?php _e( 'Playfair Display, serif', 'storyslider' )?></option>';
			</select>
	</p>
	
	<p>
		<label for="meta-font_title" class="storyslider-font_title"><?php _e( 'Police de caractères (titres et légende des sections)', 'storyslider' )?></label>
		<br/>
			<select name="meta-font_title" id="meta-font_title">
				<option value="select-zero" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-zero' ); ?>><?php _e( 'Par défaut', 'storyslider' )?></option>';
				<option value="select-three" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-three' ); ?>><?php _e( 'Arvo, serif' )?></option>';
				<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-one' ); ?>><?php _e( 'Droid Sans, sans-serif' )?></option>';
				<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-two' ); ?>><?php _e( 'Open Sans, sans-serif' )?></option>';
				<option value="select-four" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-four' ); ?>><?php _e( 'Roboto, sans-serif' )?></option>';
				<option value="select-five" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-five' ); ?>><?php _e( 'Roboto Slab,serif' )?></option>';
				<option value="select-six" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-six' ); ?>><?php _e( 'Lato, sans-serif' )?></option>';
				<option value="select-seven" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-seven' ); ?>><?php _e( 'Ubuntu Condensed, sans-serif')?></option>';
				<option value="select-eight" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-eight' ); ?>><?php _e( 'Inconsolata, cursive' )?></option>';
				<option value="select-nine" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-nine' ); ?>><?php _e( 'Playfair Display, serif' )?></option>';
				<option value="select-ten" <?php if ( isset ( $storyslider_stored_meta['meta-font_title'] ) ) selected( $storyslider_stored_meta['meta-font_title'][0], 'select-ten' ); ?>><?php _e( 'Raleway, sans-serif' )?></option>';
			</select>
	</p>		
	
	<p>		
	<label for="meta-font-size" class="storyslider-font-size"><?php _e( 'Taille du texte', 'storyslider' )?></label>		
	<br/>
	<select name="meta-font-size" id="meta-font-size">
		<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['meta-font-size'] ) ) selected( $storyslider_stored_meta['meta-font-size'][0], 'select-one' ); ?>><?php _e( 'Medium', 'storyslider' )?></option>';
		<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['meta-font-size'] ) ) selected( $storyslider_stored_meta['meta-font-size'][0], 'select-two' ); ?>><?php _e( 'Large', 'storyslider' )?></option>';			
		<option value="select-three" <?php if ( isset ( $storyslider_stored_meta['meta-font-size'] ) ) selected( $storyslider_stored_meta['meta-font-size'][0], 'select-three' ); ?>><?php _e( 'Small', 'storyslider' )?></option>';			
	</select>
	</p>
	
	<p>		
	<label for="disposition" class="storyslider-font-size"><?php _e( 'Disposition de l\'image', 'storyslider' )?></label>		
	<br/>
	<select name="disposition" id="disposition">
		<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['disposition'] ) ) selected( $storyslider_stored_meta['disposition'][0], 'select-one' ); ?>><?php _e( 'Droite', 'storyslider' )?></option>';
		<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['disposition'] ) ) selected( $storyslider_stored_meta['disposition'][0], 'select-two' ); ?>><?php _e( 'Gauche', 'storyslider' )?></option>';			
	</select>
	</p>
</div>
	
<div id="tab2" class="ui-sortable meta-box-sortables" style="display:none;">
	
	<div class="introt">	
		<h3 class="storyslidertxt"><?php _e('Chargement de la page', 'storyslider');?></h3>
		
		<p>			
		<label for="meta-loader-titre" class="storyslider-loader"><?php _e( 'Couleur du titre', 'storyslider' )?></label>			
		<br/>		
		 <input name="meta-loader-titre" type="text" value="<?php if ( isset ( $storyslider_stored_meta['meta-loader-titre'] ) ) echo $storyslider_stored_meta['meta-loader-titre'][0]; ?>" class="meta-color" />	
		</p>
		
		<p>			
		<label for="meta-loader" class="storyslider-loader"><?php _e( 'Couleur de fond', 'storyslider' )?></label>			
		<br/>		
		 <input name="meta-loader" type="text" value="<?php if ( isset ( $storyslider_stored_meta['meta-loader'] ) ) echo $storyslider_stored_meta['meta-loader'][0]; ?>" class="meta-color" />	
		</p>	
	</div>
	
	<div id="bar">
		<h3 class="storyslidertxt"><?php _e('Barre fixe (icônes)', 'storyslider');?></h3>	
		
		<p>	
			<label for="netpos" class="netpos"><?php _e( 'Position de la barre', 'storyslider' )?></label>
		<br/>
			<select name="netpos" id="netpos">				
			<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['netpos'] ) ) selected( $storyslider_stored_meta['netpos'][0], 'select-one' ); ?>><?php _e( 'Haut', 'storyslider' )?></option>';				
			<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['netpos'] ) ) selected( $storyslider_stored_meta['netpos'][0], 'select-two' ); ?>><?php _e( 'Bas', 'storyslider' )?></option>';				
		</select>	
		</p>
		
		<p>	
		<label for="top-bar" class="top-bar"><?php _e( 'Couleur de fond', 'storyslider' )?></label>		
		<br/>
			<input name="top-bar" type="text" value="<?php if ( isset ( $storyslider_stored_meta['top-bar'] ) ) echo $storyslider_stored_meta['top-bar'][0]; ?>" class="meta-color" />		
		</p>		
		
		<p>	
		<label for="reseaux" class="reseaux"><?php _e( 'Couleur des icônes', 'storyslider' )?></label>		
		<br/>	
			<input name="reseaux" type="text" value="<?php if ( isset ( $storyslider_stored_meta['reseaux'] ) ) echo $storyslider_stored_meta['reseaux'][0]; ?>" class="meta-color" />		
		</p>	
			
		<p>	
			<label for="border" class="border"><?php _e( 'Bordure', 'storyslider' )?></label>
		<br/>
		<?php _e( '(couleur du thème)', 'storyslider' )?>
		<br/>
			<select name="border" id="border">				
			<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['border'] ) ) selected( $storyslider_stored_meta['border'][0], 'select-one' ); ?>><?php _e( 'Non', 'storyslider' )?></option>';				
			<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['border'] ) ) selected( $storyslider_stored_meta['border'][0], 'select-two' ); ?>><?php _e( 'Oui', 'storyslider' )?></option>';				
		</select>	
		</p>
		
	</div>

</div>
	
<div id="tab3" class="ui-sortable meta-box-sortables" style="display:none;">
	
	<p>
        <label for="meta-align_1" class="storyslider-align"><?php _e( 'Alignement du titre', 'storyslider' )?></label>
        <br/>
		<select name="section1_title_align" id="section1_title_align" class="options">
			<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['section1_title_align'] ) ) selected( $storyslider_stored_meta['section1_title_align'][0], 'select-one' ); ?>><?php _e( 'Centre',  'storyslider' )?></option>
			<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['section1_title_align'] ) ) selected( $storyslider_stored_meta['section1_title_align'][0], 'select-two' ); ?>><?php _e( 'Gauche', 'storyslider' )?></option>
			<option value="select-three" <?php if ( isset ( $storyslider_stored_meta['section1_title_align'] ) ) selected( $storyslider_stored_meta['section1_title_align'][0], 'select-three' ); ?>><?php _e( 'Droite', 'storyslider' )?></option>
		</select>
	</p>
	
	<p>
		 <label for="meta-color" class="storyslider-color"><?php _e( 'Couleur du texte', 'storyslider' )?></label>		
		 <br/>		
		 <input name="meta-color" type="text" value="<?php if ( isset ( $storyslider_stored_meta['meta-color'] ) ) echo $storyslider_stored_meta['meta-color'][0]; ?>" class="meta-color" />	
	</p>
	
	<p>
		 <label for="meta-link" class="storyslider-link"><?php _e( 'Couleur des liens', 'storyslider' )?></label>		
		 <br/>		
		 <input name="meta-link" type="text" value="<?php if ( isset ( $storyslider_stored_meta['meta-link'] ) ) echo $storyslider_stored_meta['meta-link'][0]; ?>" class="meta-color" />	
	</p>
	
	<p>
		 <label for="meta-arrow" class="storyslider-color"><?php _e( 'Couleur des flèches de navigation', 'storyslider' )?></label>		
		 <br/>		
		 <input name="meta-arrow" type="text" value="<?php if ( isset ( $storyslider_stored_meta['meta-arrow'] ) ) echo $storyslider_stored_meta['meta-arrow'][0]; ?>" class="meta-color" />	
	</p>
	
	<div class="introt">	
		<h3 class="storyslidertxt"><?php _e('Infos', 'storyslider');?></h3>
		<span class="ssstxt"><?php _e('Contenu de la fenêtre modale', 'storyslider'); ?></span>
		<p>
		 <label for="meta-txt-infos" class="meta-txt-infos"><?php _e( 'Couleur du texte', 'storyslider' )?></label>		
		 <br/>		
			<select name="meta-txt-infos" id="meta-txt-infos">				
					<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['meta-txt-infos'] ) ) selected( $storyslider_stored_meta['meta-txt-infos'][0], 'select-one' ); ?>><?php _e( 'Couleur du texte', 'storyslider' )?></option>';				
					<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['meta-txt-infos'] ) ) selected( $storyslider_stored_meta['meta-txt-infos'][0], 'select-two' ); ?>><?php _e( 'Blanc', 'storyslider' )?></option>';							
					<option value="select-three" <?php if ( isset ( $storyslider_stored_meta['meta-txt-infos'] ) ) selected( $storyslider_stored_meta['meta-txt-infos'][0], 'select-three' ); ?>><?php _e( 'Noir', 'storyslider' )?></option>';							
			</select>
		 </p>
		
		<p>
		 <label for="meta-txt-bg" class="storyslider-color"><?php _e( 'Couleur de background', 'storyslider' )?></label>		
		 <br/>		
			<select name="meta-txt-bg" id="meta-txt-bg">				
					<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['meta-txt-bg'] ) ) selected( $storyslider_stored_meta['meta-txt-bg'][0], 'select-one' ); ?>><?php _e( 'Couleur du thème', 'storyslider' )?></option>';				
					<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['meta-txt-bg'] ) ) selected( $storyslider_stored_meta['meta-txt-bg'][0], 'select-two' ); ?>><?php _e( 'Blanc', 'storyslider' )?></option>';							
			</select>
		 </p>
	</div>
	</div>
</div>
	<?php
}
//Save

function storyslider_meta_save( $post_id ) {     
	$is_autosave = wp_is_post_autosave( $post_id );    
	$is_revision = wp_is_post_revision( $post_id );    
	$is_valid_nonce = ( isset( $_POST[ 'storyslider_nonce' ] ) && wp_verify_nonce( $_POST[ 'storyslider_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		
		if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
			return;
		}		
		if( isset( $_POST[ 'theme-color' ] ) ) {
			update_post_meta( $post_id, 'theme-color', sanitize_text_field( $_POST[ 'theme-color' ] ) );
		}
		if( isset( $_POST[ 'layout' ] ) ) {
			update_post_meta( $post_id, 'layout', sanitize_text_field( $_POST[ 'layout' ] ) );
		}
		if( isset( $_POST[ 'meta-font' ] ) ) {
			update_post_meta( $post_id, 'meta-font', sanitize_text_field( $_POST[ 'meta-font' ] ) );
		}
		if( isset( $_POST[ 'mobile_align' ] ) ) {
			update_post_meta( $post_id, 'mobile_align', sanitize_text_field( $_POST[ 'mobile_align' ] ) );
		}
		if( isset( $_POST[ 'section1_title_align' ] ) ) {
			update_post_meta( $post_id, 'section1_title_align', sanitize_text_field( $_POST[ 'section1_title_align' ] ) );
		}
		if( isset( $_POST[ 'meta-font_title' ] ) ) {
			update_post_meta( $post_id, 'meta-font_title', sanitize_text_field( $_POST[ 'meta-font_title' ] ) );
		}
		if( isset( $_POST[ 'meta-color' ] ) ) {
			update_post_meta( $post_id, 'meta-color', sanitize_text_field ( $_POST[ 'meta-color' ] ) );
		}
		if( isset( $_POST[ 'meta-link' ] ) ) {
			update_post_meta( $post_id, 'meta-link', sanitize_text_field ( $_POST[ 'meta-link' ] ) );
		}
		if( isset( $_POST[ 'meta-bg' ] ) ) {
			update_post_meta( $post_id, 'meta-bg', sanitize_text_field ( $_POST[ 'meta-bg' ] ) );
		}	
		if( isset( $_POST[ 'meta-font-size' ] ) ) {			
			update_post_meta( $post_id, 'meta-font-size', sanitize_text_field( $_POST[ 'meta-font-size' ] ) );		
		}
		if( isset( $_POST[ 'disposition' ] ) ) {			
			update_post_meta( $post_id, 'disposition', sanitize_text_field( $_POST[ 'disposition' ] ) );		
		}
		if( isset( $_POST[ 'meta-bar' ] ) ) {			
			update_post_meta( $post_id, 'meta-bar', sanitize_text_field( $_POST[ 'meta-bar' ] ) );		
		}				
		if( isset( $_POST[ 'meta-animate' ] ) ) {			
			update_post_meta( $post_id, 'meta-animate', sanitize_text_field( $_POST[ 'meta-animate' ] ) );		
		}
		if( isset( $_POST[ 'meta-arrow' ] ) ) {			
			update_post_meta( $post_id, 'meta-arrow', sanitize_text_field( $_POST[ 'meta-arrow' ] ) );		
		}		
		if( isset( $_POST[ 'meta-loader' ] ) ) {			
			update_post_meta( $post_id, 'meta-loader', sanitize_text_field( $_POST[ 'meta-loader' ] ) );		
		}
		if( isset( $_POST[ 'meta-loader-titre' ] ) ) {			
			update_post_meta( $post_id, 'meta-loader-titre', sanitize_text_field( $_POST[ 'meta-loader-titre' ] ) );		
		}				
		if( isset( $_POST[ 'storyslider-title' ] ) ) {			
			update_post_meta( $post_id, 'storyslider-title', sanitize_text_field( $_POST[ 'storyslider-title' ] ) );		
		}
		if( isset( $_POST[ 'netpos' ] ) ) {			
			update_post_meta( $post_id, 'netpos', sanitize_text_field( $_POST[ 'netpos' ] ) );		
		}
		if( isset( $_POST[ 'top-bar' ] ) ) {			
			update_post_meta( $post_id, 'top-bar', sanitize_text_field ( $_POST[ 'top-bar' ] ) );		
		}		
		if( isset( $_POST[ 'reseaux' ] ) ) {			
			update_post_meta( $post_id, 'reseaux', sanitize_text_field( $_POST[ 'reseaux' ] ) );		
		}
		if( isset( $_POST[ 'border' ] ) ) {			
			update_post_meta( $post_id, 'border', sanitize_text_field( $_POST[ 'border' ] ) );		
		}	
		if( isset( $_POST[ 'meta-txt-infos' ] ) ) {			
			update_post_meta( $post_id, 'meta-txt-infos', sanitize_text_field( $_POST[ 'meta-txt-infos' ] ) );		
		}
		if( isset( $_POST[ 'meta-txt-bg' ] ) ) {			
			update_post_meta( $post_id, 'meta-txt-bg', sanitize_text_field( $_POST[ 'meta-txt-bg' ] ) );		
		}
		if( isset( $_POST[ 'infos-align' ] ) ) {			
			update_post_meta( $post_id, 'infos-align', sanitize_text_field( $_POST[ 'infos-align' ] ) );		
		}				
}
add_action( 'save_post', 'storyslider_meta_save' );

//Intro

function storyslider_add_custom_box() {
	global $typenow;
		if( $typenow == 'storyslider' ) {
		  add_meta_box( 'wp_editor_intro', 'Intro', 'wp_editor_intro' );
		}
}
add_action( 'add_meta_boxes', 'storyslider_add_custom_box' );

function wp_editor_intro( $post ) {wp_nonce_field( plugin_basename( __FILE__ ), 'sss_nonce' );$storyslider_stored_meta = get_post_meta( $post->ID );
?>		
	<h4><?php _e( 'Cette section s\'affiche uniquement lorsque le champ "image de fond" est rempli.', 'storyslider' )?></h4>
	
	<p>
		<label for="meta-image-intro" class="storyslider-title"><?php _e( 'Image de fond (intro)', 'storyslider' )?></label>
		<br/>
			<input type="text" class="meta-image-intro" name="meta-image-intro" id="meta-image-intro" value="<?php if ( isset ( $storyslider_stored_meta['meta-image-intro'] ) ) : $topimage = $storyslider_stored_meta['meta-image-intro'][0]; echo $topimage; endif; ?>" />
			<input type="button" id="meta-image-button-slider-story" class="meta-image-button-slider-story button-sss" value="<?php _e( 'Choisir votre image', 'storyslider' )?>" />
		<br/>			
		
			<?php if( !empty( $topimage ) ): ?>			
				<div class="img-story">
				 <img src="<?php echo $topimage; ?>" style="width:40%;height:auto;margin-top:10px;" id="imgtop" />
					 <p class="remove_slider_story">
						<a title="<?php _e('Supprimer', 'storyslider'); ?>" href="javascript:;" id="remove-footer-thumbnail"><?php _e('Supprimer l\'image', 'storyslider'); ?></a>
					</p>			
				</div>
			<?php endif; ?>
						
	</p>
	
	<p>
		<label for="section_title_color" class="storyslider-font_title"><?php _e( 'Couleur du titre', 'storyslider' )?></label>
		<br/>	
		 <input name="section_title_color" type="text" value="<?php if ( isset ( $storyslider_stored_meta['section_title_color'] ) ) echo $storyslider_stored_meta['section_title_color'][0]; ?>" class="meta-color" />	
	</p>
	
	<p>
		<label for="section_title_align" class="storyslider-font_title"><?php _e( 'Alignement du titre', 'storyslider' )?></label>
		<br/>
			<select name="section_title_align" id="section_title_align" class="options">
				<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['section_title_align'] ) ) selected( $storyslider_stored_meta['section_title_align'][0], 'select-one' ); ?>><?php _e( 'Centre',  'storyslider' )?></option>';
				<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['section_title_align'] ) ) selected( $storyslider_stored_meta['section_title_align'][0], 'select-two' ); ?>><?php _e( 'Gauche', 'storyslider' )?></option>';				
				<option value="select-three" <?php if ( isset ( $storyslider_stored_meta['section_title_align'] ) ) selected( $storyslider_stored_meta['section_title_align'][0], 'select-three' ); ?>><?php _e( 'Droite', 'storyslider' )?></option>';				
			</select>
	</p>

	<p>
		<label for="section_title_background" class="storyslider-font_title"><?php _e( 'Couleur d\'arrière-plan du titre', 'storyslider' )?></label>
		<br/>
			<select name="section_title_background" id="section_title_color" class="options">
				<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['section_title_background'] ) ) selected( $storyslider_stored_meta['section_title_background'][0], 'select-one' ); ?>><?php _e( 'Pas de background',  'storyslider' )?></option>';
				<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['section_title_background'] ) ) selected( $storyslider_stored_meta['section_title_background'][0], 'select-two' ); ?>><?php _e( 'Gris', 'storyslider' )?></option>';				
				<option value="select-three" <?php if ( isset ( $storyslider_stored_meta['section_title_background'] ) ) selected( $storyslider_stored_meta['section_title_background'][0], 'select-three' ); ?>><?php _e( 'Couleur du thème (intro)', 'storyslider' )?></option>';
			</select>
	</p>
	<?php }
	
function storyslider_save_postdata_intro( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sss_nonce' ] ) && wp_verify_nonce( $_POST[ 'sss_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {        return;    }
		if( isset( $_POST[ 'meta-image-intro' ] ) ) {
			update_post_meta( $post_id, 'meta-image-intro', sanitize_text_field( $_POST[ 'meta-image-intro' ] ) );
		}
		if( isset( $_POST[ 'section_title_color' ] ) ) {			
			update_post_meta( $post_id, 'section_title_color', sanitize_text_field( $_POST[ 'section_title_color' ] ) );		
		}
		if( isset( $_POST[ 'section_title_background' ] ) ) {			
			update_post_meta( $post_id, 'section_title_background', sanitize_text_field( $_POST[ 'section_title_background' ] ) );		
		}
		if( isset( $_POST[ 'section_title_align' ] ) ) {			
			update_post_meta( $post_id, 'section_title_align', sanitize_text_field( $_POST[ 'section_title_align' ] ) );		
			}   		
}
add_action( 'save_post', 'storyslider_save_postdata_intro' );

//Infos

function storyslider_add_custom_box_infos() {
	global $typenow;
		if( $typenow == 'storyslider' ) {
		  add_meta_box( 'wp_editor_infos', 'Infos', 'wp_editor_infos' );
		}
}
add_action( 'add_meta_boxes', 'storyslider_add_custom_box_infos' );

function wp_editor_infos( $post ) {wp_nonce_field( plugin_basename( __FILE__ ), 'sss_nonce' );$storyslider_stored_meta = get_post_meta( $post->ID );
?>
	<h4><?php _e( 'Cette section s\'affiche en cliquant sur l\'icône hamburger situé à droite de l\'écran (en haut ou en bas, selon votre réglage).', 'storyslider' )?></h4>
	
	</p>

	<p>
        <label for="meta-auteur" class="storyslider-auteur"><?php _e( 'Auteur(s)', 'storyslider' )?></label>
        <input type="text" name="meta-auteur" class="meta-text-title" id="meta-auteur" value="<?php if ( isset ( $storyslider_stored_meta['meta-auteur'] ) ) echo $storyslider_stored_meta['meta-auteur'][0]; ?>" />
    </p>

	<p>
        <label for="meta-subline" class="storyslider-subline"><?php _e( 'Sous-titre', 'storyslider' )?></label>
        <textarea type="text" name="meta-subline" class="meta-text-title" id="meta_subline" /><?php if ( isset ( $storyslider_stored_meta['meta-subline'] ) ) echo $storyslider_stored_meta['meta-subline'][0]; ?></textarea>
    </p>
	<p>	
		<label for="meta-date" class="storyslider-date"><?php _e( 'Afficher la date de publication', 'storyslider' )?></label>		
		<br/>
			<select name="meta-date" id="meta-date">				
				<option value="select-one" <?php if ( isset ( $storyslider_stored_meta['meta-date'] ) ) selected( $storyslider_stored_meta['meta-date'][0], 'select-one' ); ?>><?php _e( 'Oui', 'storyslider' )?></option>';				
				<option value="select-two" <?php if ( isset ( $storyslider_stored_meta['meta-date'] ) ) selected( $storyslider_stored_meta['meta-date'][0], 'select-two' ); ?>><?php _e( 'Non', 'storyslider' )?></option>';							
			</select>
	</p>
	<h3><?php _e( 'Code iframe (copier-coller)', 'storyslider' )?></h3> 	
	<?php $link = get_permalink(); ?>
	<textarea class="widefat">&lt;iframe src="<?php echo $link; ?>" width="600px" height="450px"&gt;&lt;/iframe&gt;</textarea>
	<em><?php _e( 'Vous pouvez modifier la largeur et la hauteur de l\'iframe selon vos besoins, une largeur de 100% permet d\'être responsive.', 'storyslider' )?></em>
	</p>
<?php }
	function storyslider_save_postdata_infos( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sss_nonce' ] ) && wp_verify_nonce( $_POST[ 'sss_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {        return;    }
		if( isset( $_POST[ 'meta-subline' ] ) ) {			
			update_post_meta( $post_id, 'meta-subline', sanitize_text_field($_POST[ 'meta-subline' ] ) );
		}
		if( isset( $_POST[ 'meta-auteur' ] ) ) {			
			update_post_meta( $post_id, 'meta-auteur', sanitize_text_field($_POST[ 'meta-auteur' ] ) );		}		
		if( isset( $_POST[ 'meta-date' ] ) ) {
			update_post_meta( $post_id, 'meta-date', sanitize_text_field ($_POST[ 'meta-date' ] ));
		}
}
add_action( 'save_post', 'storyslider_save_postdata_infos' );

//Slides

add_action( 'add_meta_boxes', 'dynamic_sstsory_box' );

    function dynamic_sstsory_box() {
	add_meta_box(
    'dynamic_sectionid',
    __( 'Racontez votre histoire', 'storyslider' ),
		'dynamic_inner_storyslider_box',
		'storyslider');
}

function dynamic_inner_storyslider_box() {
global $post;
wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );

$shortcode = get_post_meta($post->ID,'shortcode',true);

$c = 0;
$n = $c++;
if ( count( $shortcode ) > 0 ) {
    if(is_array($shortcode)){
    foreach( $shortcode as $story ) {
        if ( isset( $story['story_title'] ) || isset( $story['story_text'] ) || isset( $story['story_image'] ) || isset( $story['story_iframe'] ) ) {
            printf( '<div class="storyslider">
                <h1>Slide %7$s</h1><br/>
                <strong>%9$s</strong> <br/> <input class="in" type="text" name="shortcode[%1$s][story_title]" value="%2$s" /><br/>
                <strong>%10$s</strong> <br/> <textarea class="in theEditor" type="text" id="meta-image-text-%7$s" name="shortcode[%1$s][story_text]" value="%3$s">%3$s</textarea><br/>
				<strong>%11$s</strong> <br/> <input type="text" id="meta-image-story-%7$s" name="shortcode[%1$s][story_image]" value="%4$s" /> <input type="button" class="meta-image-sider-story button-sss" value="%8$s" /> <br/>
				<strong>%12$s</strong><br/> <input class="in" style="margin-bottom:20px;" type="text" name="shortcode[%1$s][story_iframe]" value="%5$s" /><br/> 
                <span class="remove" id="remove_shortcode">%6$s</span>', $c, $story['story_title'], htmlentities($story['story_text']), $story['story_image'], htmlentities($story['story_iframe']), __( 'Supprimer le slide', 'storyslider' ), $n, __('Ajouter une image', 'storyslider'),__('Titre', 'storyslider'),__('Texte', 'storyslider'),__('Image', 'storyslider'), __('OU code embed/iframe...', 'storyslider') );
			
			$story =  $story['story_image']; 
				if( !empty( $story ) ): ?>			
				<div class="img-story">
					 <img src="<?php echo $story; ?>" style="width:40%;height:auto;margin-top:10px;" id="imgtop" />
					 <p class="remove_slider_story" style="margin-top:-6px!important;">
						<a title="<?php _e('Supprimer', 'storyslider'); ?>" href="javascript:;" id="remove-footer-thumbnail"><?php _e('Supprimer l\'image', 'storyslider'); ?></a>
					</p>			
				</div>
			<?php endif; ?>
			</div>
			<?php
			$c = $c +1;
			$n = $n +1;			
		}
    }
   }
} 
?>

<div id="story"></div>
<div class="add"><?php _e('Ajouter un slide', 'storyslider'); ?></div>

<script>
    var $ =jQuery.noConflict();
		$(document).ready(function() {

			var count = <?php echo $c; ?>;
			$(".add").click(function() {
				count = count + 1;
					$('#story').append('<div class="storyslider">\n\
								   <h1>Nouveau slide</h1><br/>\n\
								   <b><?php _e( 'Titre', 'storyslider' )?></b><br/> <input type="text" class="in" name="shortcode['+count+'][story_title]" value="" /><br/>\n\
								   <b><?php _e( 'Texte', 'storyslider' )?></b><br/> <textarea class="in theEditor" id="meta-text-story-'+count+'" type="text" name="shortcode['+count+'][story_text]" value="" /> </textarea> <br/> \n\
								   <b><?php _e( 'Image', 'storyslider' )?></b><br/> <input type="text" id="meta-image-story-'+count+'" name="shortcode['+count+'][story_image]" value="" /> <input type="button" class="meta-image-sider-story button-sss" value="<?php _e( 'Ajouter une image', 'storyslider' )?>" /> <br/> \n\
								   <b><?php _e( 'OU code embed/iframe...', 'storyslider' )?></b><br/> <input type="text" class="in" style="margin-bottom:20px;" name="shortcode['+count+'][story_iframe]" value="" /><br/> \n\
								   <span class="remove" id="remove_shortcode">Supprimer le slide</span></div>' );
				return false;
			});
			
			 $(".remove").live('click', function() {
				$(this).parent().remove();
		});
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
	  
//Repeteable image field
  
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
</script>

<?php }

add_action( 'save_post', 'dynamic_save_postdata' );
function dynamic_save_postdata( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
		if ( !isset( $_POST['dynamicMeta_noncename'] ) )
		return;

	if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
		return;
		$shortcode = $_POST['shortcode'] ;
		update_post_meta($post_id,'shortcode', $shortcode);
}


//CSS
function storyslider_add_custom_box_css() {
	global $typenow;
		if( $typenow == 'storyslider' ) {
		  add_meta_box( 'wp_editor_css', 'Style', 'wp_editor_css' );
		}
}
add_action( 'add_meta_boxes', 'storyslider_add_custom_box_css' );

function wp_editor_css( $post ) {wp_nonce_field( plugin_basename( __FILE__ ), 'sss_nonce' );$storyslider_stored_meta = get_post_meta( $post->ID );
?>
	<h4><?php _e( 'CSS personnalisé (utilisateurs avancés)', 'storyslider' )?></h4>
	
		<?php if ( isset ( $storyslider_stored_meta['custom-css'] ) ) { ?><textarea type="text" name="custom-css" class="meta-text-css" id="custom_css" /><?php echo $storyslider_stored_meta['custom-css'][0]; ?></textarea>
		<?php } else { ?><textarea type="text" name="custom-css" class="meta-text-css" id="custom_css" /></textarea>
		<?php } ?>
<?php }
	function storyslider_save_postdata_css( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sss_nonce' ] ) && wp_verify_nonce( $_POST[ 'sss_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {        return;    }
		if( isset( $_POST[ 'custom-css' ] ) ) {			
			update_post_meta( $post_id, 'custom-css', sanitize_text_field($_POST[ 'custom-css' ] ) );
		}
}
add_action( 'save_post', 'storyslider_save_postdata_css' );

//RSS
function storyslider_request( $qv ) {    if ( isset( $qv['feed'] ) ) {        $qv['post_type'] = get_post_types();    }    return $qv;}add_filter( 'request', 'storyslider_request' );
//Add custom taxonomies and CPT counts to dashboard
function storyslider_sss_dashboard_view() {
?>
   <ul>
     <?php
          global $post;
		   $args = array( 'numberposts' => 5, 'post_type' => array( 'storyslider' ) );
           $myposts = get_posts( $args );
                foreach( $myposts as $post ) :  setup_postdata($post); ?>
                    <li><span style="padding-right:10px;width:150px;"><?php the_time('d M, G') ?> : <?php the_time('i'); ?></span>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <?php endforeach; ?>
   </ul>
<?php
}
function add_storyslider_sss_dashboard_view() {
       wp_add_dashboard_widget( 'storyslider_sss_dashboard_view', __( 'Activité des Story Slider', 'storyslider' ), 'storyslider_sss_dashboard_view' );
}
add_action('wp_dashboard_setup', 'add_storyslider_sss_dashboard_view' );

//Widget
include('sstory_widget.php');
include('sstory_options.php');
include('sstory_duplicate.php');

//Templates
function template_story_slider($template)
{
	global $wp_query;
	$post_type = get_query_var('post_type');
	$meta_theme = get_post_meta( get_the_ID(), 'meta-theme', true );
		if($post_type == 'storyslider' ) {		
		$template = plugin_dir_path( __FILE__ ) . '/template/sstory.php';
		}	
		return $template;
}
add_filter('template_include', 'template_story_slider');

//Load styles and scripts
function unhook_theme_style() {
	global $wp_query;
	$post_type = get_query_var('post_type');
	if($post_type == 'storyslider' ) {
		wp_dequeue_style( 'style' );
		wp_deregister_style( 'style' );
		wp_dequeue_style( 'screen' );
		wp_deregister_style( 'screen' );
		wp_dequeue_style( 'print' );
		wp_deregister_style( 'print' );
		wp_dequeue_style( 'all' );
		wp_deregister_style( 'all' );
		wp_dequeue_style( 'genericons' );
		wp_deregister_style( 'genericons' );
		wp_dequeue_style( 'twentysixteen-style' );
		wp_deregister_style( 'twentysixteen-style' );
		wp_dequeue_style( 'twentysixteen-fonts' );
		wp_deregister_style( 'twentysixteen-fonts' );
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_enqueue_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	}
}
add_action( 'wp_enqueue_scripts', 'unhook_theme_style', 20 );
	
function storyslider_styles() {
	global $wp_query;
	$post_type = get_query_var('post_type');
	if($post_type == 'storyslider' ) {
		wp_dequeue_style( 'style' );
		wp_deregister_style( 'style' );
		wp_dequeue_style( 'print' );
		wp_deregister_style( 'print' );
		wp_dequeue_style( 'normalize' );
		wp_deregister_style( 'normalize' );
		wp_dequeue_style( 'bootstrap' );
		wp_deregister_style( 'bootstrap' );
		wp_dequeue_style( 'font-awesome' );
		wp_deregister_style( 'font-awesome' );
		wp_dequeue_style( 'genericons' );
		wp_deregister_style( 'genericons' );
		wp_dequeue_style( 'twentysixteen-style' );
		wp_deregister_style( 'twentysixteen-style' );
		wp_dequeue_script( 'mainscript' );
		wp_deregister_script( 'main' );
		wp_dequeue_script( 'main' );
		wp_deregister_script( 'mainscript' );
		wp_dequeue_script( 'bootstrapmin' );
		wp_deregister_script( 'bootstrapmin' );
		wp_dequeue_script( 'menu' );
		wp_deregister_script( 'menu' );
		wp_dequeue_script( 'custom' );
		wp_deregister_script( 'custom' );
		wp_dequeue_script( 'custom.min' );
		wp_deregister_script( 'custom.min' );
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_enqueue_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			
			wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css' );
		wp_enqueue_style( 'normalize',  plugin_dir_url( __FILE__ ) . 'css/normalize.css' );
		wp_enqueue_style( 'style_story_slider',  plugin_dir_url( __FILE__ ) . 'css/template/style.css' );
		wp_enqueue_style( 'font-awesome',  plugin_dir_url( __FILE__ ) . 'fonts/font-awesome/css/font-awesome.min.css' );
		
			function load_story_jquery() {
				if ( ! wp_script_is( 'jquery', 'enqueued' )) {
					wp_enqueue_script( 'jquery' );
				}
				if ( ! wp_script_is( 'bootstrap', 'enqueued' )) {
					wp_enqueue_script('bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js','','1.0',true);
				}
			}
		add_action( 'wp_enqueue_scripts', 'load_story' );
		wp_enqueue_script( 'jquery-ui-core', '', '', '', true );
		wp_enqueue_script( 'jquery-ui-mouse', '', '', '', true );
		wp_enqueue_script( 'jquery-ui-slider', '', '', '', true );
		wp_enqueue_script( 'jquery-effects-core', '', '', '', true );
		wp_enqueue_script('full-page', plugin_dir_url( __FILE__ ) . 'js/jquery.fullPage.min.js','','1.0',true);
		wp_enqueue_script('slim-scroll', plugin_dir_url( __FILE__ ) . 'js/jquery.slimscroll.min.js','','1.0',true);
		wp_enqueue_script('loader', plugin_dir_url( __FILE__ ) . 'js/jquery.classyloader.min.js','','1.0',true);
		wp_enqueue_script('custom', plugin_dir_url( __FILE__ ) . 'js/custom.js','','1.0',true);
	}
}
add_action( 'wp_enqueue_scripts', 'storyslider_styles' );	
add_action( 'admin_print_scripts-$hook', 'storyslider_styles' );

?>