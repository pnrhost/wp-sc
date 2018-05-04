<?php

function quotes_init() {
	register_post_type( 'quotes', array(
		'labels'            => array(
			'name'                => __( 'Quotes', 'pnr-staffconnect' ),
			'singular_name'       => __( 'Quote', 'pnr-staffconnect' ),
			'all_items'           => __( 'All Quotes', 'pnr-staffconnect' ),
			'new_item'            => __( 'New Quote', 'pnr-staffconnect' ),
			'add_new'             => __( 'Add New', 'pnr-staffconnect' ),
			'add_new_item'        => __( 'Add New Quote', 'pnr-staffconnect' ),
			'edit_item'           => __( 'Edit Quote', 'pnr-staffconnect' ),
			'view_item'           => __( 'View Quote', 'pnr-staffconnect' ),
			'search_items'        => __( 'Search Quotes', 'pnr-staffconnect' ),
			'not_found'           => __( 'No Quotes found', 'pnr-staffconnect' ),
			'not_found_in_trash'  => __( 'No Quotes found in trash', 'pnr-staffconnect' ),
			'parent_item_colon'   => __( 'Parent Quote', 'pnr-staffconnect' ),
			'menu_name'           => __( 'Quotes', 'pnr-staffconnect' ),
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
		'rest_base'         => 'quotes',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'quotes_init' );

function quotes_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['quotes'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Quote updated. <a target="_blank" href="%s">View Quote</a>', 'pnr-staffconnect'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'pnr-staffconnect'),
		3 => __('Custom field deleted.', 'pnr-staffconnect'),
		4 => __('Quote updated.', 'pnr-staffconnect'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Quote restored to revision from %s', 'pnr-staffconnect'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Quote published. <a href="%s">View Quote</a>', 'pnr-staffconnect'), esc_url( $permalink ) ),
		7 => __('Quote saved.', 'pnr-staffconnect'),
		8 => sprintf( __('Quote submitted. <a target="_blank" href="%s">Preview Quote</a>', 'pnr-staffconnect'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Quote scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Quote</a>', 'pnr-staffconnect'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Quote draft updated. <a target="_blank" href="%s">Preview Quote</a>', 'pnr-staffconnect'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'quotes_updated_messages' );
