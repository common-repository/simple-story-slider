<?php
function storyslider_add_admin_menu() {
   add_submenu_page( 'edit.php?post_type=storyslider','Simple Story Slider', 'Options', 'manage_options', "storyslider-options", "settings_storyslider_page", null, 99);
}
add_action( 'admin_menu', 'storyslider_add_admin_menu' );

function settings_storyslider_page()
{
			if (!current_user_can('manage_options')) {
				wp_die(__('Vos droits ne sont pas suffisants pour accéder à cette page.', 'storyslider'));
			}
?>

	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
	    <h2><?php _e('Simple Story Slider - options', 'storyslider') ?></h2>
		<?php if( isset($_GET['settings-updated']) ) { ?>
			<div id="message" class="updated">
				<p><strong><?php _e('Options enregistrées', 'storyslider') ?></strong></p>
			</div>
		<?php } ?>

	<h2 class="nav-tab-wrapper">
	 <a href="#" class="nav-tab navtab1 active1">
	 <?php _e( 'Options générales', 'storyslider' ); ?>
	 </a>
	 
	 <a href="#" class="nav-tab navtab2 active2">
	 <?php _e( 'Typographie', 'storyslider' ); ?>       
	 </a>

	 <a href="#" class="nav-tab navtab3 active3">
	 <?php _e( 'Démo', 'storyslider' ); ?>       
	 </a>
 </h2>
		<div id="tab1" class="ui-sortable meta-box-sortables">
				<form method="post" action="options.php">
					<?php
						settings_fields("section");
						do_settings_sections("plugin-options");      
						submit_button(); 
					?>          
				</form>
		</div>
		
		<div id="tab2" class="ui-sortable meta-box-sortables" style="display:none;">
				<br/>
					<div class="postbox">
						<div class="inside" style="font-size:1.2em;">
						<?php _e('5 familles typographiques standards sont disponibles pour la mise en forme du texte, et 5 Google Fonts pour customiser les titres de chaque slider.','storyslider'); ?>
							<?php echo '<img style="max-width:80%;margin:30px 0;float:none;" src="' . plugins_url( 'images/fonts.jpg', __FILE__ ) . '" alt="fonts" /> '; ?>
							<hr/>
							<?php echo '<img style="max-width:100%;margin:30px 0;" src="' . plugins_url( 'images/googlefonts.jpg', __FILE__ ) . '" alt="fonts" /> '; ?>
						</div>
					</div>
			</div>


		<div id="tab3" class="ui-sortable meta-box-sortables" style="display:none;">
				<br/>
		
			<div style="width:50%;float:left;text-align:center;">
				<h3><?php _e('Accueil','storyslider'); ?></h3>
				<?php
				echo '<img style="max-width:96%;" src="' . plugins_url( 'images/storyslider2.png', __FILE__ ) . '" alt="storyslider Back to black" /> ';
				?>
				<br/>
				<a href="http://www.ohmybox.info/ohmytest/storyslider/simple-story-slider/" target="_blank"> 
				<?php _e('Démo', 'storyslider'); ?> </a>

			</div>	

			<div style="width:50%;float:right;text-align:center;">
				<h3>Story Slider</h3>
				<?php echo '<img style="max-width:96%;" src="' . plugins_url( 'images/storyslider.png', __FILE__ ) . '" alt="ssl Back to black" /> '; ?>
				<br/>
				<a href="http://www.ohmybox.info/ohmytest/storyslider/simple-story-slider/" target="_blank"> 
				<?php _e('Démo', 'storyslider'); ?> </a>
			</div>
		
		</div>


<?php  }


function display_storyslider_twitter_element()
{ ?>
	<input type="hidden" name="update_settings" value="Y" />
	<input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
<?php }

function display_storyslider_email() { 
	add_option( 'email', 'checked' );
	if ( get_option('email') == true ) { $display = 'checked'; }
	else { $display = ''; }
	update_option( 'email', $display );
?>
<input type="checkbox" name="email" id="email" <?php echo get_option('email'); ?> /> <?php _e('E-mail', 'storyslider') ?>
<?php }

//Social networks
	function display_storyslider_twitter() { 
		add_option( 'twitter', 'checked' );
		if ( get_option('twitter') == true ) { $display = 'checked'; }
		else { $display = ''; }
		update_option( 'twitter', $display );
	?>
	<input type="checkbox" name="twitter" id="twitter" <?php echo get_option('twitter'); ?> /> <?php _e('Twitter', 'storyslider') ?>
	<?php }

	function display_storyslider_fb() { 
	add_option( 'facebook', 'checked' );
		if ( get_option('facebook') == true ) { $display = 'checked'; }
		else { $display = ''; }
		update_option( 'facebook', $display );
	?>
	<input type="checkbox" name="facebook" id="facebook" <?php echo get_option('facebook'); ?> /> <?php _e('Facebook', 'storyslider') ?>
	<?php }

	function display_storyslider_linkedin() { 
	add_option( 'linkedin', 'checked' );
		if ( get_option('linkedin') == true ) { $display = 'checked'; }
		else { $display = ''; }
		update_option( 'linkedin', $display );
	?>
	<input type="checkbox" name="linkedin" id="linkedin" <?php echo get_option('linkedin'); ?> /> <?php _e('LinkedIn', 'storyslider') ?>
	<?php }
	
function display_ssl_linked() { 	
		add_option( 'ssl_linked', 'checked' );
		if ( get_option('ssl_linked') == true ) { 
		$display = 'checked'; 
		} else { $display = ''; }
		update_option( 'ssl_linked', $display );
	?>
	<input type="checkbox" name="ssl_linked" id="ssl_linked" <?php echo get_option('ssl_linked'); ?> /> 
<?php }

//Nextpage
	function display_storyslider_nextpage() { 
	add_option( 'nextpage', 'checked' );
	if ( get_option('nextpage') == true ) { $display = 'checked'; }
	else { $display = ''; }
	update_option( 'nextpage', $display );
	?>
	<input type="checkbox" name="nextpage" id="nextpage" <?php echo get_option('nextpage'); ?> /> 
	<?php }

//Analytics code
	function display_storyslider_ga_element() { ?>
		<textarea cols='40' rows='5' name="google_analytics" id="google_analytics"/><?php echo get_option('google_analytics'); ?></textarea>
	<?php }

//Metadata
	function display_ssl_metadata() { 	
		add_option( 'ssl_metadata', 'checked' );
		if ( get_option('ssl_metadata') == true ) { 
		$display = 'checked'; 
		} else { $display = ''; }
		update_option( 'ssl_metadata', $display );
	?>
	<input type="checkbox" name="ssl_metadata" id="ssl_metadata" <?php echo get_option('ssl_metadata'); ?> /> 
	<?php }

function display_storyslider_panel_fields() {
	add_settings_section("section", __( ' ', ' ' ), null, "plugin-options");
	add_settings_field("twitter_url", __( 'Ajouter votre identifiant Twitter (@monNom)', 'storyslider' ), "display_storyslider_twitter_element", "plugin-options", "section");
    add_settings_field("email", __( 'Boutons de partage', 'storyslider' ), "display_storyslider_email", "plugin-options", "section");
    add_settings_field("twitter", __( ' ', '' ), "display_storyslider_twitter", "plugin-options", "section");
	add_settings_field("facebook", __( ' ', ' ' ), "display_storyslider_fb", "plugin-options", "section");
	add_settings_field("linkedin", __( ' ', '' ), "display_storyslider_linkedin", "plugin-options", "section");
	add_settings_field("nextpage", __( 'Afficher le lien vers le storyslider suivant/précédent', 'storyslider' ), "display_storyslider_nextpage", "plugin-options", "section");
	add_settings_field("ssl_metadata", __( 'Afficher les métadonnées de partage (réseaux sociaux...), attention : risque de doublon si cela est déjà prévu dans votre architecture (thème ou plugins)', 'storyslider' ), "display_ssl_metadata", "plugin-options", "section");	
	add_settings_field("google_analytics", __( 'Ajouter votre code Google Analytics (<script>...</script>)', 'storyslider' ), "display_storyslider_ga_element", "plugin-options", "section");
	add_settings_field("ssl_linked", __( 'Lier à WP et aux plugins (peut causer des problèmes de compatibilité)', 'storyslider' ), "display_ssl_linked", "plugin-options", "section");	
	
	register_setting("section", "twitter_url");
    register_setting("section", "email");
	register_setting("section", "twitter");
	register_setting("section", "facebook");
	register_setting("section", "linkedin");
	register_setting("section", "nextpage");
	register_setting("section", "ssl_metadata");
	register_setting("section", "google_analytics");
	register_setting("section", "ssl_linked");

}
add_action("admin_init", "display_storyslider_panel_fields");
?>