<?php

function payments_init() {
	register_post_type( 'payments', array(
		'labels'            => array(
			'name'                => __( 'Payments', 'pnr-staffconnect' ),
			'singular_name'       => __( 'Payment', 'pnr-staffconnect' ),
			'all_items'           => __( 'All Payments', 'pnr-staffconnect' ),
			'new_item'            => __( 'New Payment', 'pnr-staffconnect' ),
			'add_new'             => __( 'Add New', 'pnr-staffconnect' ),
			'add_new_item'        => __( 'Add New Payment', 'pnr-staffconnect' ),
			'edit_item'           => __( 'Edit Payment', 'pnr-staffconnect' ),
			'view_item'           => __( 'View Payment', 'pnr-staffconnect' ),
			'search_items'        => __( 'Search Payments', 'pnr-staffconnect' ),
			'not_found'           => __( 'No Payments found', 'pnr-staffconnect' ),
			'not_found_in_trash'  => __( 'No Payments found in trash', 'pnr-staffconnect' ),
			'parent_item_colon'   => __( 'Parent Payment', 'pnr-staffconnect' ),
			'menu_name'           => __( 'Payments', 'pnr-staffconnect' ),
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
		'rest_base'         => 'payments',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'payments_init' );

function payments_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['payments'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Payment updated. <a target="_blank" href="%s">View Payment</a>', 'pnr-staffconnect'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'pnr-staffconnect'),
		3 => __('Custom field deleted.', 'pnr-staffconnect'),
		4 => __('Payment updated.', 'pnr-staffconnect'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Payment restored to revision from %s', 'pnr-staffconnect'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Payment published. <a href="%s">View Payment</a>', 'pnr-staffconnect'), esc_url( $permalink ) ),
		7 => __('Payment saved.', 'pnr-staffconnect'),
		8 => sprintf( __('Payment submitted. <a target="_blank" href="%s">Preview Payment</a>', 'pnr-staffconnect'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Payment scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Payment</a>', 'pnr-staffconnect'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Payment draft updated. <a target="_blank" href="%s">Preview Payment</a>', 'pnr-staffconnect'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'payments_updated_messages' );
