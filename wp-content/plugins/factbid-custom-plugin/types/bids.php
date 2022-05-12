<?php
add_action( 'init', 'create_custom_post4', 0 );
function create_custom_post4() {
    $labels = array(
        'name' => _x( 'Bids', 'Post Type General Name', 'Bids' ),
        'singular_name' => _x( 'Add', 'Post Type Singular Name', 'Bid' ),
        'menu_name' => _x( 'Bids', 'Admin Menu text', 'Bids' ),
        'name_admin_bar' => _x( 'Bids', 'Add New on Toolbar', 'Bids' ),
        'featured_image' => __( 'Bids Image', 'bids' ),
        'set_featured_image' => __( 'Add Image', 'bids' ),    
    );
    $args = array(
        'label' => __( 'Bids', 'Bids' ),
        'description' => __( 'Bids', 'Bids' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-nametag',
        'supports' => array('title', 'editor', 'thumbnail','comments'),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 7,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => true,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug'=>'bids', 'with_front' => false)
    );
    register_post_type( 'bids', $args );

}

/**
 * 
 * Delete bids on delete from backend
 */
add_action( 'admin_init', 'delete_bids_init' );
function delete_bids_init() {
    add_action( 'delete_post', 'delete_bids_sync', 10 );
}
function delete_bids_sync( $pid ) {
    $post_type = get_post_type( $pid );
    if ( $post_type != 'bids' ) 
    {
        return;
    }
    global $wpdb;
    $query = $wpdb->prepare( 'SELECT post_id FROM ct_bid WHERE post_id = %d', $pid );
    $var = $wpdb->get_var( $query );
    if ( $var ) {
        $query2 = $wpdb->prepare( 'DELETE FROM ct_bid WHERE post_id = %d', $pid );
        $wpdb->query( $query2 );
    }
}