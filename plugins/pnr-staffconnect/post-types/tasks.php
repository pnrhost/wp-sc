<?php

function tasks_init() {
	register_post_type( 'tasks', array(
		'labels'            => array(
			'name'                => __( 'Tasks', 'pnr-staffconnect' ),
			'singular_name'       => __( 'Task', 'pnr-staffconnect' ),
			'all_items'           => __( 'All Tasks', 'pnr-staffconnect' ),
			'new_item'            => __( 'New Task', 'pnr-staffconnect' ),
			'add_new'             => __( 'Add New', 'pnr-staffconnect' ),
			'add_new_item'        => __( 'Add New Task', 'pnr-staffconnect' ),
			'edit_item'           => __( 'Edit Task', 'pnr-staffconnect' ),
			'view_item'           => __( 'View Task', 'pnr-staffconnect' ),
			'search_items'        => __( 'Search Tasks', 'pnr-staffconnect' ),
			'not_found'           => __( 'No Tasks found', 'pnr-staffconnect' ),
			'not_found_in_trash'  => __( 'No Tasks found in trash', 'pnr-staffconnect' ),
			'parent_item_colon'   => __( 'Parent Task', 'pnr-staffconnect' ),
			'menu_name'           => __( 'Tasks', 'pnr-staffconnect' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-admin-post',
		'show_in_rest'      => true,
		'rest_base'         => 'tasks',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'tasks_init' );

function tasks_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['tasks'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Task updated. <a target="_blank" href="%s">View Task</a>', 'pnr-staffconnect'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'pnr-staffconnect'),
		3 => __('Custom field deleted.', 'pnr-staffconnect'),
		4 => __('Task updated.', 'pnr-staffconnect'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Task restored to revision from %s', 'pnr-staffconnect'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Task published. <a href="%s">View Task</a>', 'pnr-staffconnect'), esc_url( $permalink ) ),
		7 => __('Task saved.', 'pnr-staffconnect'),
		8 => sprintf( __('Task submitted. <a target="_blank" href="%s">Preview Task</a>', 'pnr-staffconnect'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Task scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Task</a>', 'pnr-staffconnect'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Task draft updated. <a target="_blank" href="%s">Preview Task</a>', 'pnr-staffconnect'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'tasks_updated_messages' );
