<?php
/*
Plugin Name: Fact Bid
Plugin URI: #
Description: Custom Plugin for Bidding
Version: 1.0
Author: Abacies
Author URI: #
*/




// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'FACTBID__PLUGIN_URL', plugins_url().'/factbid-custom-plugin' );
define( 'FACTBID__PLUGIN_DIR', plugin_dir_path( __FILE__ ));

require_once( FACTBID__PLUGIN_DIR . '/class.fact.php' );
require_once( FACTBID__PLUGIN_DIR . '/class.country.php' );
register_activation_hook( __FILE__, array( 'Fact', 'plugin_activation' ) );
register_activation_hook( __FILE__, array( 'Fact', 'update_optionfields' ) );
register_activation_hook( __FILE__, array( 'Country', 'create_countries_table' ) );
register_deactivation_hook( __FILE__, array( 'Fact', 'plugin_deactivation' ) );
function factbid_frontend_assets() {
    
    wp_enqueue_script('factbid-submiting-form',FACTBID__PLUGIN_URL.'/assets/js/factbid.js','','',true);
    wp_localize_script( 'factbid-submiting-form', 'my_ajax_object',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'factbid_frontend_assets');

add_action( 'admin_enqueue_scripts', 'factbid_include_js' );
add_action( 'wp_enqueue_scripts', 'factbid_include_js' );
function factbid_include_js() {
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
    // wp_enqueue_script( 'myuploadscript', get_stylesheet_directory_uri() . '/customscript.js', array( 'jquery' ) );
}


add_action( 'init', 'create_custom_post2', 0 );
function create_custom_post2() {
    $labels = array(
        'name' => _x( 'Facts', 'Post Type General Name', 'Facts' ),
        'singular_name' => _x( 'Add', 'Post Type Singular Name', 'Facts' ),
        'menu_name' => _x( 'Facts', 'Admin Menu text', 'Facts' ),
        'name_admin_bar' => _x( 'Facts', 'Add New on Toolbar', 'Facts' ),
        'featured_image' => __( 'Facts Image', 'facts' ),
        'set_featured_image' => __( 'Add Image', 'facts' ),    
    );
    $args = array(
        'label' => __( 'Facts', 'Facts' ),
        'description' => __( 'Facts', 'Facts' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-nametag',
        'supports' => array('title', 'editor', 'thumbnail','comments'),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => true,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug'=>'browse', 'with_front' => false)
    );
    register_post_type( 'facts', $args );

}


add_action( 'init', 'create_custom_post3', 0 );
function create_custom_post3() {
    $labels = array(
        'name' => _x( 'Claims', 'Post Type General Name', 'Claims' ),
        'singular_name' => _x( 'Add', 'Post Type Singular Name', 'Claims' ),
        'menu_name' => _x( 'Claims', 'Admin Menu text', 'Claims' ),
        'name_admin_bar' => _x( 'Claims', 'Add New on Toolbar', 'Claims' ),
        'featured_image' => __( 'Claims Image', 'facts' ),
        'set_featured_image' => __( 'Add Image', 'facts' ),    
    );
    $args = array(
        'label' => __( 'Claims', 'Claims' ),
        'description' => __( 'Claims', 'Claims' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-image-filter',
        'supports' => array('title', 'editor', 'thumbnail', 'comments'),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => true,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type( 'claims', $args );

}


function remove_trailing_decimals($n){
    $s = floor($n);
    $i = $t-$s;
    $f = $t -$i;
    $x = $f*1000;
    $a = number_format($x/1000, 2);
    return $a;
}
/**
 *Creating Fact Bid
 **/
add_action( 'wp_ajax_create_factbid', 'create_factbid' );
add_action( 'wp_ajax_nopriv_create_factbid', 'create_factbid' );
function create_factbid (){
    global $wpdb;
    $id_parent = (int)$_POST['parent'];

    if(isset($_POST['description'])){
        $description = wp_specialchars_decode( $_POST['description'], $quote_style = ENT_QUOTES );
    } else {
        $description = "";
    }
    if(isset($_POST['acceptable_claim'])){
        $acceptable_claim = wp_specialchars_decode( $_POST['acceptable_claim'], $quote_style = ENT_QUOTES );
    } else {
        $acceptable_claim = "";
    }
    if(isset($_POST['social_media'])){
        $social_media = wp_specialchars_decode( $_POST['social_media'], $quote_style = ENT_QUOTES );
    } else {
        $social_media = "";
    }
    if(isset($_POST['footnote'])){
        $footnote = wp_specialchars_decode( $_POST['footnote'], $quote_style = ENT_QUOTES );
    } else {
        $footnote = "";
    }
    if($_POST['user_id'] == 0 || $_POST['user_id'] == ''){
        $user_id = get_current_user_id();
    } else {
        $user_id = $_POST['user_id'];
    }
    
    $new_post = array(
          'ID' => '',
          'post_type' => 'facts',
          'post_status' => 'publish',
          'post_title' => $_POST['title'], 
          'post_content' => $description,
          'post_author' => $user_id
        );        
    $attachment_id = $_POST['image'];
    $post_id = wp_insert_post($new_post);
    $link_to_claim = get_permalink($post_id);
    update_post_meta($post_id, "acceptable_claim", $acceptable_claim);
    update_post_meta($post_id, "social_media", $social_media);
    update_post_meta($post_id, "footnote", $footnote);
    set_post_thumbnail( $post_id, $attachment_id );
    $post = get_post($post_id);
    $id_parent = (int)$_POST['parent'];
    if($id_parent == 0){
        $res = $wpdb->get_results($wpdb->prepare("SELECT MAX(id_factbid) as max_id FROM ct_factbid WHERE id_factbid_parent=%d",0));
        $id_facs = remove_trailing_decimals($res[0]->max_id);
        $id_factbid = $res[0]->max_id+1;
    }
    else{
        $res = $wpdb->get_results($wpdb->prepare("SELECT MAX(id_factbid) as max_id FROM ct_factbid WHERE id_factbid_parent=%d",$id_parent));
        
        if($res[0]->max_id == ''){
            $id_factbid = $id_parent+$res[0]->max_id+0.01;
        }
        else{
            $id_factbid = $res[0]->max_id+0.01;
        }
        
    }
    
    $wpdb->query($wpdb->prepare("UPDATE wp_posts SET post_name = %01.2f WHERE id = %d",$id_factbid,$post_id));
    
    
    $tablename='ct_factbid';
    $data=array(
    'id' => '',    
    'id_factbid' => $id_factbid, 
    'id_factbid_parent' => (int)$_POST['parent'],
    'id_user' => $user_id,
    'post_id' => $post_id,
    'type' => (int)$_POST['type'],
    'nobid' => (int)$_POST['nobid'],
    'visibility' => (int)$_POST['visibility'],
    'status' => (int)$_POST['status'],
    'topics' => (int)$_POST['topics'],
    'country' => $_POST['country'],
    'language' => $_POST['language'],
    'priority' => $_POST['priority'],
    'bids_count' => '',
    'bids_total' => '',
    'bids_accepted' => '',
    'bids_paid' => '',
    'claims_total' => '',
    'view_count' => '',
    'comment_count' => '',
    'thumbs_up' => '',
    'thumbs_down' => '',
    'title' => $_POST['title'],
    'subtitle' => '',
    'result_claimed' => '',
    'result_unclaimed' => '',
    'claims_acceptable' => ''

    
    
     );
    $res = $wpdb->insert( $tablename, $data);

    if($res == 1){
        echo esc_url(home_url('/'. strval(number_format($id_factbid, 2))));
    }
    else{
        echo $wpdb->last_error;
    }
    wp_die();
}


/**
 *Editing Fact Bid
 **/
add_action( 'wp_ajax_edit_factbid', 'edit_factbid' );
add_action( 'wp_ajax_nopriv_edit_factbid', 'edit_factbid' );
function edit_factbid (){
    global $wpdb;
    $old_post_id = $_POST['old_post_id'];
    if(isset($_POST['description'])){
        $description = wp_specialchars_decode( $_POST['description'], $quote_style = ENT_QUOTES );
    } else {
        $description = "";
    }
    if(isset($_POST['acceptable_claim'])){
        $acceptable_claim = wp_specialchars_decode( $_POST['acceptable_claim'], $quote_style = ENT_QUOTES );
    } else {
        $acceptable_claim = "";
    }
    if(isset($_POST['social_media'])){
        $social_media = wp_specialchars_decode( $_POST['social_media'], $quote_style = ENT_QUOTES );
    } else {
        $social_media = "";
    }
    if(isset($_POST['footnote'])){
        $footnote = wp_specialchars_decode( $_POST['footnote'], $quote_style = ENT_QUOTES );
    } else {
        $footnote = "";
    }
    
    if($_POST['user_id'] == 0 || $_POST['user_id'] == ''){
        $user_id = get_current_user_id();
    } else {
        $user_id = $_POST['user_id'];
    }
    $new_post = array(
          'ID' => $old_post_id,
          'post_type' => 'facts',
          'post_title' => $_POST['title'], 
          'post_content' => $description,
        );        

    $post_id = wp_update_post($new_post);
    $link_to_claim = get_permalink($post_id);
    $attachment_id = $_POST['image'];
    update_post_meta($post_id, "acceptable_claim", $acceptable_claim);
    update_post_meta($post_id, "social_media", $social_media);
    update_post_meta($post_id, "footnote", $footnote);
    set_post_thumbnail( $post_id, $attachment_id );
    $post = get_post($post_id);
    $id_parent = (int)$_POST['parent'];
    if($id_parent == 0){
        $res = $wpdb->get_results($wpdb->prepare("SELECT MAX(id_factbid) as max_id FROM ct_factbid WHERE id_factbid_parent=%d",0));
        $id_factbid = $res[0]->max_id+1;
        $id_facs = remove_trailing_decimals($res[0]->max_id);
        $id_factbid = $id_facs+1;
    }
    else{
        $res = $wpdb->get_results($wpdb->prepare("SELECT MAX(id_factbid) as max_id FROM ct_factbid WHERE id_factbid_parent=%d",$id_parent));
        
        $id_factbid = $res[0]->max_id+0.01;
    }
    
    
    $tablename='ct_factbid';
    $data=array(
    'id_factbid_parent' => (int)$_POST['parent'],
    'id_user' => $user_id,
    'post_id' => $post_id,
    'type' => (int)$_POST['type'],
    'nobid' => (int)$_POST['nobid'],
    'visibility' => (int)$_POST['visibility'],
    'status' => (int)$_POST['status'],
    'topics' => (int)$_POST['topics'],
    'country' => $_POST['country'],
    'language' => $_POST['language'],
    'priority' => $_POST['priority'],
    // 'bids_count' => '',
    // 'bids_total' => '',
    // 'bids_accepted' => '',
    // 'bids_paid' => '',
    // 'claims_total' => '',
    // 'view_count' => '',
    // 'comment_count' => '',
    // 'thumbs_up' => '',
    // 'thumbs_down' => '',
    'title' => $_POST['title'],
    // 'subtitle' => '',
    // 'result_claimed' => '',
    // 'result_unclaimed' => '',
    // 'claims_acceptable' => ''

    
    
     );
    $where = [ 'post_id' => $old_post_id ];
    $res = $wpdb->update( $tablename, $data, $where);

    $res_fact = $wpdb->get_results($wpdb->prepare("SELECT id_factbid FROM ct_factbid WHERE post_id=%d",$post_id));
    $wpdb->query($wpdb->prepare("UPDATE wp_posts SET post_name = %01.2f WHERE id = %d",$res_fact[0]->id_factbid,$post_id));
    echo esc_url(home_url('/'. strval(number_format($res_fact[0]->id_factbid, 2))));
    wp_die();

    // if($res == 1){
    //     // echo 1;
    //     $res_fact = $wpdb->get_results($wpdb->prepare("SELECT id_factbid FROM ct_factbid WHERE post_id=%d",$post_id));
    //     echo esc_url(home_url('/'. strval(number_format($res_fact[0]->id_factbid, 2))));
    // }
    // else{
    //     echo $wpdb->last_error;
    // }
    wp_die();
}

/**
 *Post a Fact Bid
 **/
add_action( 'wp_ajax_post_factbid', 'post_factbid' );
add_action( 'wp_ajax_nopriv_post_factbid', 'post_factbid' );
function post_factbid (){
    global $wpdb;
    $tablename='ct_factbid';
    $factbid_id = $_POST['factbid_id'];
    $post_id = $wpdb->get_results($wpdb->prepare("SELECT post_id FROM ct_factbid WHERE id_factbid=%f",$factbid_id));
    $where = [ 'id_factbid' => $factbid_id ];
    $data = array(
        'status'=> 5
    );
    $res = $wpdb->update( $tablename, $data, $where);

    $wpdb->query($wpdb->prepare("UPDATE wp_posts SET post_name = %01.2f WHERE id = %d",$factbid_id,$post_id));
    // $new_post = array(
    //     'ID' => $post_id[0]->post_id,
    //     'post_type' => 'facts',
    //     'post_status' => 'publish'
    //   );     
    // $nwpost_id = wp_update_post($new_post);

    if($res == 1){
        echo 1;
    }
    else{
        echo $wpdb->last_error;
    }
    wp_die();
}

/**
 *Post a Fact Bid
 **/
add_action( 'wp_ajax_post_claim', 'post_claim' );
add_action( 'wp_ajax_nopriv_post_claim', 'post_claim' );
function post_claim (){
    global $wpdb;
    $tablename='ct_claim';
    $claim_id = $_POST['claim_id'];
    $where = [ 'id_claim' => $claim_id ];
    $data = array(
        'status'=> 'Completed'
    );
    $res = $wpdb->update( $tablename, $data, $where);
    if($res == 1){
        echo 1;
    }
    else{
        echo $wpdb->last_error;
    }
    wp_die();
}
