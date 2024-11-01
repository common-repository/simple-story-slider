<?php 

function storyslider_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'storyslider_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}
 
	$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );

	$post = get_post( $post_id );
 
	if (isset( $post ) && $post != null) {
 
		$args = array(
			'post_type'      => $post->post_type,
			'post_status'    => 'draft',
			'menu_order'     => $post->menu_order
		);
 

		$new_post_id = wp_insert_post( $args );
 
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}

		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_storyslider_post_as_draft', 'storyslider_post_as_draft' );
 
function storyslider_post_link( $actions, $post ) {
	if ($post->post_type=='storyslider' && current_user_can('edit_posts')) {
		$actions['duplicate'] = '<a href="admin.php?action=storyslider_post_as_draft&amp;post=' . $post->ID . '" title="Clone" rel="permalink">'.__('Dupliquer le template','storyslider').'</a>';
	}
	return $actions;
}
 
add_filter( 'post_row_actions', 'storyslider_post_link', 10, 2 );
?>