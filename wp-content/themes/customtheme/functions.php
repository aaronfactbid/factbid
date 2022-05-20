<?php 
function custom_theme_assets() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/assets/css/bootstrap.css', array(), '1.0.0' );
    wp_enqueue_style( 'custom-css', get_template_directory_uri().'/assets/css/custom.css', array(), '1.0.1' );
    wp_enqueue_style( 'responsive-css', get_template_directory_uri().'/assets/css/responsive.css', array(), '1.0.1' );
}

add_action( 'wp_enqueue_scripts', 'custom_theme_assets' );

function customjs_enqueue() {
    wp_enqueue_script( 'bootstrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.js',array('jquery'),'1.0.0',true);
    wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/assets/js/jquery.js',array(),'1.0.0',true);
    wp_enqueue_script( 'filter', get_stylesheet_directory_uri() . '/assets/js/filter.js',array(),'',true);
    wp_localize_script( 'filter', 'my_ajax_object',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'customjs_enqueue' );

function my_theme_setup(){
    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'my_theme_setup');

add_action( 'widgets_init', 'factbid_widgets_init' );
function factbid_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'News Sidebar', 'factbid' ),
        'id'            => 'news-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
 
    register_sidebar( array(
        'name'          => __( 'Secondary Sidebar', 'factbid' ),
        'id'            => 'sidebar-2',
        'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li></ul>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer W1', 'factbid' ),
        'id'            => 'footer-1',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer W2', 'factbid' ),
        'id'            => 'footer-2',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer W3', 'factbid' ),
        'id'            => 'footer-3',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );
}

/**
 * Add Menu Locations
 */
if ( ! function_exists( 'factbid_register_nav_menu' ) ) {
 
    function factbid_register_nav_menu(){
        register_nav_menus( array(
            'header_menu' => __( 'Header Menu', 'text_domain' ),
            'header_second_menu' => __( 'Header Second Menu', 'text_domain' ),
            'footer_menu'  => __( 'Footer Menu', 'text_domain' ),
        ) );
    }
    add_action( 'after_setup_theme', 'factbid_register_nav_menu', 0 );
}

/**
 * Disable Gutenberg Editor
 */
add_filter('use_block_editor_for_post', '__return_false', 10);

// Add Favicon with WordPress Hook 
add_action( 'wp_head', 'ilc_favicon');
function ilc_favicon(){
    $favicon = get_option('favicon');
	if($favicon):
		echo '<link rel="icon" href="'.$favicon.'" type="image/x-icon">' . "\n";
		echo "<link rel='shortcut icon' href='" . $favicon . "' />" . "\n";
	else:
        echo "<link rel='shortcut icon' href='" . get_stylesheet_directory_uri() . "/images/favicon.ico' />" . "\n";
    endif;
}


add_filter('wp_nav_menu_objects', 'ad_filter_menu', 10, 2);

function ad_filter_menu($sorted_menu_objects, $args) {
    // check for the right menu to rename the menu item from
    // here we check for theme location of 'primary-menu'
    // alternatively you can check for menu name ($args->menu == 'menu_name')

    if ($args->theme_location != 'header_second_menu')  
        return $sorted_menu_objects;

    // rename the menu item that has a title of 'Sign in'

    $user_id = get_current_user_id();
    $avatar = get_avatar($user_id, 30);

    if( isset($user_id) && $user_id !=0 ) {

        foreach ($sorted_menu_objects as $key => $menu_object) {
            if ($menu_object->title == "Log in") {
                $current_user = wp_get_current_user();

                $menu_object->title = $avatar . " Profile";
                $menu_object->url = esc_url(home_url('/profile'));
            }
        }
    }
    return $sorted_menu_objects;
}

include_once(get_stylesheet_directory().'/functions/redirect-rules.php');
include_once(get_stylesheet_directory().'/functions/registration-functions.php');

/**
 * Add additional Meta Fields to User Profile
 */
function extra_profile_fields( $user ) { ?>
   
    <h3><?php _e('Extra User Details'); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="facebook">Facebook Page</label></th>
            <td>
            <input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Enter your Facebook Page ID.</span>
            </td>
        </tr>
        <tr>
            <th><label for="twitter">Twitter</label></th>
            <td>
            <input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Enter Twitter handle.</span>
            </td>
        </tr>
        <tr>
            <th><label for="substack">Substack</label></th>
            <td>
            <input type="text" name="substack" id="substack" value="<?php echo esc_attr( get_the_author_meta( 'substack', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Enter your Substack.</span>
            </td>
        </tr>
        <tr>
            <th><label for="youtube">Youtube</label></th>
            <td>
            <input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Enter your Youtube.</span>
            </td>
        </tr>
        <tr>
            <th><label for="languages">Languages</label></th>
            <td>
            <input type="text" name="languages" id="languages" value="<?php echo esc_attr( get_the_author_meta( 'languages', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Enter your Languages known separated by comma.</span>
            </td>
        </tr>
        <tr>
            <th><label for="country">Country</label></th>
            <td>
            <input type="text" name="country" id="country" value="<?php echo esc_attr( get_the_author_meta( 'country', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <tr>
            <th><label for="phone">Phone</label></th>
            <td>
            <input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
            </td>
        </tr>
    </table>
<?php

}

// Then we hook the function to "show_user_profile" and "edit_user_profile"
add_action( 'show_user_profile', 'extra_profile_fields', 10 );
add_action( 'edit_user_profile', 'extra_profile_fields', 10 );

function save_extra_profile_fields( $user_id ) {

    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;

    /* Edit the following lines according to your set fields */
    update_usermeta( $user_id, 'facebook', $_POST['facebook'] );
    update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
    update_usermeta( $user_id, 'substack', $_POST['substack'] );
    update_usermeta( $user_id, 'youtube', $_POST['youtube'] );

    update_usermeta( $user_id, 'languages', $_POST['languages'] );
    update_usermeta( $user_id, 'country', $_POST['country'] );
    update_usermeta( $user_id, 'phone', $_POST['phone'] );
}

add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );

function create_custom_post() {
    $labels = array(
        'name' => _x( 'Faq', 'Post Type General Name', 'Faq' ),
        'singular_name' => _x( 'Add', 'Post Type Singular Name', 'Faq' ),
        'menu_name' => _x( 'Faq', 'Admin Menu text', 'Faq' ),
        'name_admin_bar' => _x( 'Faq', 'Add New on Toolbar', 'Faq' ),
        'featured_image' => __( 'Faq Image', 'faq' ),
        'set_featured_image' => __( 'Add Image', 'faq' ),    
    );
    $args = array(
        'label' => __( 'Faq', 'Faq' ),
        'description' => __( 'Faq', 'Faq' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type( 'faq', $args );

}
add_action( 'init', 'create_custom_post', 0 );

/**
 * Post Views
 */
function gt_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
    if($count == ''){
        $count = 0;
    }
    return "$count views";
}
function gt_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}
function gt_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';
    return $columns;
}
function gt_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo gt_get_post_view();
    }
}
add_filter( 'manage_posts_columns', 'gt_posts_column_views' );
add_action( 'manage_posts_custom_column', 'gt_posts_custom_column_views' );

function wpdocs_custom_excerpt_length( $length ) {
    return 22;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );
function wpdocs_excerpt_more( $more ) {
    if(is_front_page() || is_archive('facts')){
        return '...';
    }
    return '<a href="'.get_the_permalink().'" rel="nofollow">  Read More...</a>';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

/**
 * Add HTML5 theme support.
 */
function wpdocs_after_setup_theme() {
    add_theme_support( 'html5', array( 'search-form' ) );
}
add_action( 'after_setup_theme', 'wpdocs_after_setup_theme' );


/**
 * Footer Newsletter widget
 */
add_shortcode( 'newsletter', 'wp_newsletter_shortcode' );
function wp_newsletter_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'button_class' => 'btn btn-dark',
        'button_text' => 'Submit',
        'form_class' => 'search-area-footer',
        'input_class' => '',
        'input_id' => 'footer-search'
    ), $atts, 'newsletter' );
    
    // return "foo = {$atts['foo']}";
    $a= $atts['form_class'];
    $b= $atts['input_id'];
    $c= $atts['button_class'];
    $d = $atts['button_text'];

    $html = "<form class='".$a."' action='/' method='POST'>";
    $html .= '<input type="hidden" name="newsletter_form" value="1">';
    $html .= '<input type="text" placeholder=""  id="'.$b.'" name="newsletter">';
    $html .= '<button class="'.$c.'">'.$d.'</button>';
    $html .= '</form>';

    return $html;
}
add_action('template_redirect', 'add_to_newsletter');
function add_to_newsletter(){
    if(isset($_POST['newsletter']) && !empty($_POST['newsletter'])){
        global $wpdb, $factbid_messages;
        $factbid_messages = new WP_Error;

        $email_id = $_POST["newsletter"];
        if($email_id == ""){
            $factbid_messages->add('newsletter', 'No Email found.');
            return;
        }
        $email_add = $wpdb->get_var("SELECT COUNT(*) FROM ct_newsletter WHERE email='$email_id'");
        if($email_add < 1){
            $wpdb->insert('ct_newsletter',array('email'=>$_POST['newsletter'],'created'=> wp_date('Y-m-d H:i:s')));
            $factbid_messages->add('newsletter', 'Successfully added to subscription.');
        } else {
            $factbid_messages->add('newsletter', 'Email already Exists with us.');
        }
        
    }
}


add_filter( 'login_redirect', function() { return esc_url(home_url('/profile')); exit(); } );
add_filter( 'logout_redirect', function() { return esc_url(home_url()); exit();} );

add_action('template_redirect', 'redirect_if_loggedin_register');
function redirect_if_loggedin_register() {
    if(is_page('register')){
        if(is_user_logged_in()){
            wp_redirect( home_url() ); exit;
        }
    }
}
/**
 * AJAX call for home page filter
 * **/
add_action( 'wp_ajax_filter_facts', 'filter_facts' );
add_action( 'wp_ajax_nopriv_filter_facts', 'filter_facts' );
function filter_facts (){

    $status_filter = $_REQUEST['status_filter'];
    $sort_filter = $_REQUEST['sort_filter'];
    $topic_filter = $_REQUEST['topic_filter'];
    $language_filter = $_REQUEST['language_filter'];
    $author_filter = $_REQUEST['author_filter'];

        global $wpdb;
        $tablename='ct_factbid';
        // $sql = "SELECT post_id,bids_count,bids_total,bids_paid,claims_total,view_count,thumbs_up,thumbs_down,comment_count FROM ct_factbid ";
        $sql = "SELECT c.id_factbid,c.post_id,c.bids_count,c.bids_total,c.bids_paid,c.claims_total,c.view_count,c.thumbs_up,c.thumbs_down,c.comment_count FROM ct_factbid as c JOIN wp_posts as p WHERE c.post_id=p.ID AND c.status=5";
        if($status_filter != ''){
            if (str_contains($sql, 'WHERE')) { 
                $sql .= " AND c.claims_total='".$status_filter."'";
            }
            else{
                $sql .= "WHERE c.claims_total='".$status_filter."'";
            }
        }
        if($topic_filter != ''){
            if (str_contains($sql, 'WHERE')) { 
                $sql .= " AND c.topics='".$topic_filter."'";
            }
            else{
                $sql .= "WHERE c.topics='".$topic_filter."'";
            }
        }
        if($language_filter != ''){
            if (str_contains($sql, 'WHERE')) { 
                $sql .= " AND c.language='".$language_filter."'";
            }
            else{
                $sql .= "WHERE c.language='".$language_filter."'";
            }
        }
        if($author_filter != ''){
            if (str_contains($sql, 'WHERE')) { 
                $sql .= " AND p.post_author='".$author_filter."'";
            }
            else{
                $sql .= "WHERE p.post_author='".$author_filter."'";
            }
        }
        if($sort_filter == 'commented'){
            $sql .= " ORDER BY c.comment_count DESC";
        }
        elseif($sort_filter == 'viewed'){
            $sql .= " ORDER BY c.view_count DESC";
        }
        elseif($sort_filter == 'liked'){
            $sql .= " ORDER BY c.thumbs_up DESC";
        }

        $results = $wpdb->get_results($wpdb->prepare($sql));

        $html = '';
        foreach($results as $result){
            $post_image = wp_get_attachment_url( get_post_thumbnail_id($result->post_id), 'thumbnail' );
            if($post_image){
                $post_image = $post_image;
            } else {
                $post_image = catch_that_image($result->post_id);
            }
            if($result->claims_total != 0){
              $claimed = "Claimed";
            }
            else{
              $claimed = "Unclaimed";  
            }
            $content_post = get_post($result->post_id);
            // $content = $content_post->post_content;
            $content = get_the_excerpt($result->post_id);
            $link = get_permalink($result->post_id);
            $title = get_the_title($result->post_id);
            $author = $content_post->post_author;
            $date = get_the_date('d-M-Y', $result->post_id);
            $author_name = factbid_get_author_link($author);

            // $bids_count = $result->bids_count;
            // $bids_total = $result->bids_total;
            // $claims_total = $result->claims_total;
            // $bids_paid = $result->bids_paid;

            $bc = get_bid_count($result->id_factbid);
            $bids_count = $bc['bid_count'];
            $bids_total = $bc['bid_amount'];
            $claims_total = get_claims_count($result->id_factbid);
            $bids_paid = $result->bids_paid;

            $html .= '<div class="col-sm-4">
        <div class="card-flyer">
          <div class="text-box">
            <div class="card card-text-bottom card-gradient-bottom card-inverse text-bottom">
                <a href="'.$link.'"><img class="card-img-top"  src="'.$post_image.'" alt="" /></a>
              <div class="card-image-overlay">
                <span class="card-title">'.$claimed.'</span>
              </div>
            </div>
            <div class="text-container">
              <h6><a href="'.$link.'">'.$title.'</a></h6>
              <div class="meta-content"><p><small>'.$date. ' - ' . $author_name . ' </small></p>
                '.display_rating($author).'</div>
              <p class="w3-opacity">'.$content.'</p>
            </div>
            <div class="bid_count">
              <div class="row">
                <div class="col-4"><strong>Bids:'.$bids_count.'<span>$</span>'.$bids_total.'</strong></div>
                <div class="col-3"><strong>Claims:'.$claims_total.'</strong></div>
                <div class="col-4 ms-auto text-end"><strong>Payments:'.$bids_paid.'</strong></div>
              </div>
            </div>
            <div class="bottom-content">
              <span class="block_view_count"> '.$result->view_count.'</span>
              <span class="block_accept_count"> '.$result->thumbs_up.'</span>
              <span class="block_reject_count"> '.$result->thumbs_down.'</span>
              <span class="content-right block_response_count"> '.$result->comment_count.'</span>
            </div>
          </div>
        </div>
      </div>';
        }       
    

       
        echo json_encode($html);

        
    // }
    wp_die();
}

add_action( 'wp_ajax_factbid_add_thumbs_up', 'factbid_add_thumbs_up' );
add_action( 'wp_ajax_nopriv_factbid_add_thumbs_up', 'factbid_add_thumbs_up' );
function factbid_add_thumbs_up (){
    global $wpdb;
    $tablename='ct_factbid';
    $status_filter = $_REQUEST['status_filter'];
    $post_id = $_REQUEST['post_id'];
    $user_id = $_REQUEST['user_id'];
    $results = $wpdb->get_results($wpdb->prepare("SELECT thumbs FROM ct_fact_thumbs WHERE post_id=%d AND id_user=%d",$post_id,$user_id));

    if(empty($results)){
        $res = $wpdb->query($wpdb->prepare("UPDATE ct_factbid SET thumbs_up=thumbs_up+1 WHERE post_id=%d",$post_id));
        $wpdb->insert('ct_fact_thumbs',array('id_user'=>$user_id,'post_id'=>$post_id,'thumbs'=>1));
        echo "success";
    }
    else{
        echo "failed";
    }
    

    wp_die();
}

add_action( 'wp_ajax_factbid_add_thumbs_down', 'factbid_add_thumbs_down' );
add_action( 'wp_ajax_nopriv_factbid_add_thumbs_down', 'factbid_add_thumbs_down' );
function factbid_add_thumbs_down (){
    global $wpdb;
    $tablename='ct_factbid';
    $status_filter = $_REQUEST['status_filter'];
    $post_id = $_REQUEST['post_id'];
    $user_id = $_REQUEST['user_id'];
    $results = $wpdb->get_results($wpdb->prepare("SELECT thumbs FROM ct_fact_thumbs WHERE post_id=%d AND id_user=%d",$post_id,$user_id));
    if(empty($results)){
    $res = $wpdb->query($wpdb->prepare("UPDATE ct_factbid SET thumbs_down=thumbs_down+1 WHERE post_id=%d",$post_id));
    $wpdb->insert('ct_fact_thumbs',array('id_user'=>$user_id,'post_id'=>$post_id,'thumbs'=>1));
        echo "success";
    }
    else{
        echo "failed";
    }
    wp_die();
}
/**
 * 
 * Show all posts if archive page is FAQ
 */
function cdxn_faq_post_type( $query ) {
    if ( is_post_type_archive( 'faq' ) ) {
        $query->set( 'posts_per_page', -1 );
        return;
    }
}
add_action( 'pre_get_posts', 'cdxn_faq_post_type', 1 );
/**
 * 
 * Redirect to Register page if not logged in - Create Factbid
 */
function create_factbid_redirect() {
    if ( is_page( array('create-factbid', 'create-claim', 'edit-factbid', 'edit-claim', 'edit-profile', 'approve-users') )) {
        $user_id = get_current_user_id();
        if(is_page('approve-users') && !current_user_can( 'administrator' )){
            wp_redirect( home_url() ); exit;
        }
        if($user_id < 1 || $user_id =="" ){
            wp_redirect( home_url('/sign-in') ); exit;
        }
        return;
    }
}
add_action( 'template_redirect', 'create_factbid_redirect', 1 );

/**
 * 
 * Send email on Reset Password
 */
function send_password_reset_email($email){
    $message = "Your Password has been successfully reset.";
    $blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    $wp_password_change_notification_email = array(
        'to'      => $email,
        'subject' => __( '[%s] Password Changed' ),
        'message' => $message,
        'headers' => '',
    );
    wp_mail(
        $wp_password_change_notification_email['to'],
        wp_specialchars_decode( sprintf( $wp_password_change_notification_email['subject'], $blogname ) ),
        $wp_password_change_notification_email['message'],
        $wp_password_change_notification_email['headers']
    );
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'factbid/v1', '/update-languages', array(
      'methods' => 'POST',
      'callback' => 'update_languages',
      'permission_callback' => '__return_true',
    ) );
  } );

function update_languages($request) {
    $data = $request->get_params();
    update_option("languages", $data['data']);
    $c = get_option("languages", true);

    return new WP_REST_Response( $c, 200 );
}

add_action( 'wp_ajax_add_bid', 'add_bid' );
add_action( 'wp_ajax_nopriv_add_bid', 'add_bid' );
function add_bid (){
    global $wpdb, $factbid_messages;
    $factbid_messages = new WP_Error;

    $tablename='ct_bid';
    $bidid = $_REQUEST['bidid'];


    $visibility = $_REQUEST['visibility'];
    $pfactbid = $_REQUEST['pfactbid'];
    $user_id = $_REQUEST['user_id'];
    $amount = $_REQUEST['amount'];
    $bid_comments = $_REQUEST['bid_comments'];
    $bid_conditions = $_REQUEST['bid_conditions'];
    $date = current_time('mysql');

    

    $results = $wpdb->get_results($wpdb->prepare("SELECT id_bid FROM ct_bid WHERE id_factbid=%f AND id_user=%d",$pfactbid,$user_id));
    if(empty($results)){
        $res = $wpdb->insert('ct_bid',array('id_factbid'=>$pfactbid,'id_user'=>$user_id, 'date'=>$date,'amount'=>$amount,'comments'=>$bid_comments,'status'=>1,'visibility'=>$visibility,'conditions'=>$bid_conditions));
    } else {
        $res1 = $wpdb->get_results($wpdb->prepare("SELECT MAX(id_bid) as max_id FROM ct_bid WHERE id_factbid=%f AND id_user=%d",$pfactbid,$user_id));
        $prev = $res1[0]->max_id;
        $res2 = $wpdb->insert('ct_bid',array('id_factbid'=>$pfactbid,'id_user'=>$user_id, 'date'=>$date,'amount'=>$amount,'comments'=>$bid_comments,'status'=>1,'visibility'=>$visibility,'conditions'=>$bid_conditions,'id_bid_prev' => $prev));
        $last_id = $wpdb->insert_id;
        $res3 = $wpdb->query($wpdb->prepare("UPDATE ct_bid SET id_bid_next=$last_id WHERE id_bid=%d",$prev));
    }
    
    echo $wpdb->last_error;
    if($res3==1){
        $factbid_messages->add('Add Bid', 'Your Bid added Successfully.');
        echo "success";
    }
    else{
        echo "failed";
    }
    wp_die();
}

add_action( 'wp_ajax_create_claim', 'create_claim' );
add_action( 'wp_ajax_nopriv_create_claim', 'create_claim' );
function create_claim (){
    global $wpdb, $factbid_messages;
    $factbid_messages = new WP_Error;
    $user_id = $_REQUEST['user_id'];
    $selectedFacts = $_REQUEST['selectedFacts'];
    $visibility = $_REQUEST['visibility'];
    $selectedPayments = $_REQUEST['selectedPayments'];

    $payment_data = [];

    foreach ($selectedPayments as $selectedPayment ) {
        if($selectedPayment == 'bitcoin'){
            $wallet = $_REQUEST['wallet'];
            $data = [$selectedPayment=>$wallet];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'swift'){
            $swift = $_REQUEST['swift'];
            $data = [$selectedPayment=>$swift];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'paypal'){
            $paypalEmail = $_REQUEST['paypalEmail'];
            $data = [$selectedPayment=>$paypalEmail];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'account'){
            $bankName = $_REQUEST['bankName'];
            $beneficiaryName = $_REQUEST['beneficiaryName'];
            $beneficiaryAddress = $_REQUEST['beneficiaryAddress'];
            $bank_data= $bankName.', '.$beneficiaryName.', '.$beneficiaryAddress;
            $data = [$selectedPayment=>$bank_data];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'zelle'){
            $zelleAddress = $_REQUEST['zelleAddress'];
            $data = [$selectedPayment=>$zelleAddress];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'aba'){
            $aba = $_REQUEST['aba'];
            $data = [$selectedPayment=>$aba];
            array_push($payment_data, $data);
        }
    }
 
    if(isset($_POST['description'])){
        $description = wp_specialchars_decode( $_POST['description'], $quote_style = ENT_QUOTES );
    } else {
        $description = "";
    }




    $json_payment = json_encode($payment_data);
    $i = 1;
    foreach($selectedFacts as $selectedFact){
        $claim_num = $wpdb->get_results( 
            $wpdb->prepare(
              "SELECT * FROM ct_claim 
              WHERE id_factbid=%01.2f",
                $selectedFact
            )
          );
          $total_claims = count($claim_num);
          $nextc = $total_claims + 1;
        $new_post = array(
          'post_type' => 'claims',
          'post_status' => 'publish',
          'post_title' => $_POST['title'],
          'post_content' => $description
        );        

        $post_id = wp_insert_post($new_post);
        $link_to_claim = get_permalink($post_id);
        update_post_meta($post_id, "claim_comments", $_POST['comments']);
        $res = $wpdb->insert('ct_claim',array(
            'id_user'=>$user_id,
            'id_factbid'=>$selectedFact,
            'post_id'=>$post_id,
            'status'=>'Creating',
            'verify_url'=>1,
            'verified'=>'Unverified',
            'visibility'=>$visibility,
            'payment_method'=>$json_payment,
            'bidders_accepted'=>0,
            'bidders_paid'=>0,
            'total_paid'=>0,
            'bidders_rejected'=>0,
            'bidders_pending'=>0,
            'view_count'=> 0,
            'comment_count'=>0,
            'thumbs_up'=> 0,
            'thumbs_down'=> 0,
            'title'=>$_POST['title'],
            'subtitle'=>sanitize_textarea_field($_POST['subtitle'])
        ));
        $i++;
        echo $link_to_claim;
    }
    
    $factbid_messages->add('Add Claim', 'Your Claims added Successfully.');
    wp_die();
}

add_action( 'wp_ajax_update_claim', 'update_claim' );
add_action( 'wp_ajax_nopriv_update_claim', 'update_claim' );
function update_claim (){
    global $wpdb, $factbid_messages;
    $factbid_messages = new WP_Error;
    $user_id = $_REQUEST['user_id'];
    $selectedFacts = $_REQUEST['selectedFacts'];
    $visibility = $_REQUEST['visibility'];
    $selectedPayments = $_REQUEST['selectedPayments'];

    $payment_data = [];
    foreach ($selectedPayments as $selectedPayment ) {
        if($selectedPayment == 'bitcoin'){
            $wallet = $_REQUEST['wallet'];
            $data = [$selectedPayment=>$wallet];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'swift'){
            $swift = $_REQUEST['swift'];
            $data = [$selectedPayment=>$swift];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'paypal'){
            $paypalEmail = $_REQUEST['paypalEmail'];
            $data = [$selectedPayment=>$paypalEmail];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'account'){
            $bankName = $_REQUEST['bankName'];
            $beneficiaryName = $_REQUEST['beneficiaryName'];
            $beneficiaryAddress = $_REQUEST['beneficiaryAddress'];
            $bank_data= $bankName.', '.$beneficiaryName.', '.$beneficiaryAddress;
            $data = [$selectedPayment=>$bank_data];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'zelle'){
            $zelleAddress = $_REQUEST['zelleAddress'];
            $data = [$selectedPayment=>$zelleAddress];
            array_push($payment_data, $data);
        }
        if($selectedPayment == 'aba'){
            $aba = $_REQUEST['aba'];
            $data = [$selectedPayment=>$aba];
            array_push($payment_data, $data);
        }
    }
    
    if(isset($_POST['description'])){
        $description = wp_specialchars_decode( $_POST['description'], $quote_style = ENT_QUOTES );
    } else {
        $description = "";
    }




    $json_payment = json_encode($payment_data);
    $i = 1;
    foreach($selectedFacts as $selectedFact){

        $claim_num = $wpdb->get_results( 
            $wpdb->prepare(
              "SELECT * FROM ct_claim 
              WHERE id_factbid=%01.2f",
                $selectedFact
            )
          );
          $total_claims = count($claim_num);
          $nextc = $total_claims + 1;
        $new_post = array(
            'ID' => $_POST['claim_id'],
            'post_type' => 'claims',
            'post_status' => 'publish',
            'post_title' => $_POST['title'],
            'post_content' => $description
        );        

        $post_id = wp_update_post($new_post);
        update_post_meta($post_id, "claim_comments", $_POST['comments']);
        $tablename = 'ct_claim';
        $data=array(
            'id_user'=>(int)$user_id,
            'id_factbid'=>$selectedFact,
            'post_id'=>(int)$post_id,
            'status'=>'Creating',
            'verify_url'=>1,
            'verified'=>'Unverified',
            'visibility'=>(int)$visibility,
            'payment_method'=>$json_payment,
            'bidders_accepted'=>0,
            'bidders_paid'=>0,
            'total_paid'=>0,
            'bidders_rejected'=>0,
            'bidders_pending'=>0,
            'view_count'=> 0,
            'comment_count'=>0,
            'thumbs_up'=> 0,
            'thumbs_down'=> 0,
            'title'=>$_POST['title'],
            'subtitle'=>sanitize_textarea_field($_POST['subtitle'])
        );
        $old_post_id= $_POST['claim_id'];
        $where = [ 'post_id' => $old_post_id ];
        $res = $wpdb->update( $tablename, $data, $where);
        $i++;
        echo $wpdb->last_error;
    }

    $factbid_messages->add('Add Claim', 'Your Claims Updated Successfully.');
    wp_die();
}


function get_bid_status($status_id){
    switch ($status_id){
        case 1:
            return 'Open';
            break;
        case 2:
            return 'Pending payment';
            break;
        case 3:
            return 'Paid';
            break;
        default:
            return 'Open';
    }
}
add_action( 'wp_ajax_add_response', 'add_response' );
add_action( 'wp_ajax_nopriv_add_response', 'add_response' );
function add_response (){
    global $wpdb, $factbid_messages;
    $factbid_messages = new WP_Error;
    $user_id = $_REQUEST['user_id'];
    $status_explain = $_REQUEST['status_explain'];
    $status = $_REQUEST['status'];
    $selectedPayments = $_REQUEST['selectedPayments'];
    $amount = $_REQUEST['amount'];
    $payment_data = [];

    foreach ($selectedPayments as $selectedPayment ) {
        if($selectedPayment == 'bitcoin'){
            $wallet = $_REQUEST['wallet'];
            $data = [$selectedPayment=>$wallet];
            array_push($payment_data, $data);
            $amount = $amount+$wallet;
        }
        if($selectedPayment == 'swift'){
            $swift = $_REQUEST['swift'];
            $data = [$selectedPayment=>$swift];
            array_push($payment_data, $data);
            $amount = $amount+$swift;
        }
        if($selectedPayment == 'paypal'){
            $paypalEmail = $_REQUEST['paypalEmail'];
            $data = [$selectedPayment=>$paypalEmail];
            array_push($payment_data, $data);
            $amount = $amount+$paypalEmail;
        }
        if($selectedPayment == 'account'){
            $account = $_REQUEST['account'];
            $data = [$selectedPayment=>$account];
            array_push($payment_data, $data);
            $amount = $amount+$account;
        }
        if($selectedPayment == 'zelle'){
            $zelleAddress = $_REQUEST['zelleAddress'];
            $data = [$selectedPayment=>$zelleAddress];
            array_push($payment_data, $data);
            $amount = $amount+$zelleAddress;
        }
        if($selectedPayment == 'aba'){
            $aba = $_REQUEST['aba'];
            $data = [$selectedPayment=>$aba];
            array_push($payment_data, $data);
            $amount = $amount+$aba;
        }
    }
    $bid_factbid_id = (int)$_REQUEST['id_factbid'];
    $bid = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT id_bid FROM ct_bid WHERE id_factbid = %d AND id_user = %d AND id_bid_next IS NULL",
            $bid_factbid_id,$user_id
        )
    );

    $json_payment = json_encode($payment_data);
    $results = $wpdb->get_results($wpdb->prepare("SELECT id_response FROM ct_response WHERE id_claim=%d AND id_user=%d",$_REQUEST['id_claim'],$user_id));
    if(empty($results)){
         $res = $wpdb->insert('ct_response',array(
            'id_response_next'=>NULL,
            'id_response_prev'=>NUll,
            'id_bid'=>$bid[0]->id_bid,
            'id_claim'=>$_REQUEST['id_claim'],
            'id_factbid'=>$_REQUEST['id_factbid'],
            'id_user'=>$user_id,
            'status'=>$status,
            'comments'=>$status_explain,
            'payment_method'=>$json_payment,
            'amount_paid'=>$amount
        
        ));
    }
    else{
        $res1 = $wpdb->get_results($wpdb->prepare("SELECT MAX(id_response) as max_id FROM ct_response WHERE id_claim=%d AND id_user=%d",$_REQUEST['id_claim'],$user_id));
        $prev = $res1[0]->max_id;
        $res = $wpdb->insert('ct_response',array(
            'id_response_prev'=>$prev,
            'id_bid'=>$bid[0]->id_bid,
            'id_claim'=>$_REQUEST['id_claim'],
            'id_factbid'=>$_REQUEST['id_factbid'],
            'id_user'=>$user_id,
            'status'=>$status,
            'comments'=>$status_explain,
            'payment_method'=>$json_payment,
            'amount_paid'=>$amount,
        
        ));
        $last_id = $wpdb->insert_id;
        $res3 = $wpdb->query($wpdb->prepare("UPDATE ct_response SET id_response_next=$last_id WHERE id_response=%d",$prev));
    }
    $count_resp1 = $wpdb->get_results($wpdb->prepare("SELECT COUNT(id_response) AS bidders_accepted FROM `ct_response` WHERE status = 'Accepted' AND id_factbid=%d AND id_response_next IS NULL",$_REQUEST['id_factbid']));
       ;
    $bidders_accepted = $count_resp1[0]->bidders_accepted;
    $count_resp2 = $wpdb->get_results($wpdb->prepare("SELECT COUNT(id_response) AS bidders_rejected FROM `ct_response` WHERE status = 'Rejected' AND id_response_next IS NULL"));
       ;
     $bidders_rejected = $count_resp2[0]->bidders_rejected;
    $count_resp3 = $wpdb->get_results($wpdb->prepare("SELECT COUNT(id_response) AS bidders_pending FROM `ct_response` WHERE status = 'Pending' AND id_response_next IS NULL"));
       ;
    $bidders_pending = $count_resp3[0]->bidders_pending;
    $count_resp4 = $wpdb->get_results($wpdb->prepare("SELECT COUNT(id_response) AS bidders_paid FROM `ct_response` WHERE status = 'Paid' AND id_response_next IS NULL"));
       ;
    $bidders_paid = $count_resp4[0]->bidders_paid;

$res4 = $wpdb->query($wpdb->prepare("UPDATE ct_claim SET bidders_accepted=$bidders_accepted,bidders_rejected=$bidders_rejected,bidders_pending=$bidders_pending,bidders_paid=$bidders_paid WHERE id_claim=%d",$_REQUEST['id_claim']));
    
        echo $wpdb->last_error;

    $factbid_messages->add('Add Response', 'Your Response added Successfully.');
    wp_die();
}
/**
 * 
 * Get the first image of the FactBid
 */
function catch_that_image($post_id) {
    $post = get_post($post_id);
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if(empty($matches[1])){
        $first_img = get_template_directory_uri().'/assets/images/download.png';
    } else {
        $first_img = $matches[1][0];
    }
    return $first_img;
  }


add_action( 'user_register', 'factbid_registration_save', 32, 1 );
 
function factbid_registration_save( $user_id ) {
    global $wpdb;
    $post_status = 'None';
    $verify_status = 'Unverified';
    $profile_data = json_encode(array());
    $res = $wpdb->insert('ct_profile',array(
        'id_user'=> $user_id,
        'profile'=> $profile_data,
        'post_status'=>$post_status, // None, Pending, Approved
        'post_date'=> wp_date('Y-m-d H:i:s'),
        'post_request'=>'',
        'verify_url'=>'',
        'verified'=>$verify_status //Unverified, Link posted, Link Valid, Link Verified
    ));
    update_user_meta($user_id, "show_email", 'hide');
}
function factbid_delete_user( $user_id ) {
    global $wpdb;

    $query = $wpdb->prepare( 'SELECT id_user FROM ct_profile WHERE id_user = %d', $user_id );
    $var = $wpdb->get_var( $query );
    if ( $var ) {
        $query2 = $wpdb->prepare( 'DELETE FROM ct_profile WHERE id_user = %d', $user_id );
        $wpdb->query( $query2 );
    }
    
 
    $user_obj = get_userdata( $user_id );
    $email = $user_obj->user_email;
    $subject = "FactBid - Account is being Deleted";
    $headers = 'From: ' . get_bloginfo( "name" ) . ' <' . get_bloginfo( "admin_email" ) . '>' . "\r\n";
    wp_mail( $email, $subject, 'Your account is being deleted.', 'Your account at ' . get_bloginfo("name") . ' is being deleted right now.', $headers );
}
add_action( 'delete_user', 'factbid_delete_user' );

add_action('template_redirect', 'report_factbid');
function report_factbid(){
    if(isset($_POST['report_content']) && !empty($_POST['report_content'])){
        global $wpdb, $factbid_messages;
        $factbid_messages = new WP_Error;

        $user_id = $_POST["current_user_id"];
        $content = $_POST["report_content"];
        $factbid_id = $_POST["factbid_id"];
        $factbid_post_id = $_POST["factbid_post_id"];
        if($user_id == "" || $user_id == 0){
            $factbid_messages->add('reporting', 'You should be logged in to Report.');
            $url = get_the_permalink($_POST["factbid_post_id"]);
            wp_redirect($url); 
            exit;
        }


        $wpdb->insert('ct_factbidreporting',array(
            'id_user'=>$user_id,
            'id_factbid' => $factbid_id,
            'content' => $content,
            'created'=> wp_date('Y-m-d H:i:s')
        ));
        $factbid_messages->add('reporting', 'Reporting Submitted.');

        $user = get_user_by( 'id', $user_id );
        $username = $user->user_login;
        $headers = 'From: ' . get_bloginfo( "name" ) . ' <' . get_bloginfo( "admin_email" ) . '>' . "\r\n";
        
        $subject = "FactBid - User Reported a Factbid";
        $text = 'The User - ' . $username . ' has reported the factbid.';
        $text .= get_permalink($factbid_post_id);
        add_filter('wp_mail_content_type', function( $content_type ) {
            return 'text/html';
        });
        wp_mail( $email, $subject, $text, $headers );
        
    }
}
add_action('template_redirect', 'redirect_if_loggedin_edit_factbid');
function redirect_if_loggedin_edit_factbid() {
    if(is_page('edit-factbid')){

        $user_id = get_current_user_id();
        if(isset($_GET['id'])){
            $factbid = $_GET['id'];
        } else {
            $factbid = "";
        }
        if($user_id < 1 || $user_id =="" || $factbid == ""){
            wp_redirect( home_url() ); exit;
        }
    }
}

/**
 * 
 * Delete Factbid on delete from backend
 */
add_action( 'admin_init', 'delete_factbid_init' );
function delete_factbid_init() {
    add_action( 'delete_post', 'delete_factbid_sync', 10 );
}
function delete_factbid_sync( $pid ) {
    $post_type = get_post_type( $pid );
    if ( $post_type != 'facts' ) 
    {
        return;
    }
    global $wpdb;
    $query = $wpdb->prepare( 'SELECT post_id FROM ct_factbid WHERE post_id = %d', $pid );
    $var = $wpdb->get_var( $query );
    if ( $var ) {
        $query2 = $wpdb->prepare( 'DELETE FROM ct_factbid WHERE post_id = %d', $pid );
        $wpdb->query( $query2 );
    }
}
/**
 * 
 * Delete claims on delete from backend
 */
add_action( 'admin_init', 'delete_claims_init' );
function delete_claims_init() {
    add_action( 'delete_post', 'delete_claims_sync', 10 );
}
function delete_claims_sync( $pid ) {
    $post_type = get_post_type( $pid );
    if ( $post_type != 'claims' ) 
    {
        return;
    }
    global $wpdb;
    $query = $wpdb->prepare( 'SELECT post_id FROM ct_claim WHERE post_id = %d', $pid );
    $var = $wpdb->get_var( $query );
    if ( $var ) {
        $query2 = $wpdb->prepare( 'DELETE FROM ct_claim WHERE post_id = %d', $pid );
        $wpdb->query( $query2 );
    }
}
/**
 * 
 * change url atructure for factbid
 */
function change_facts_post_types_slug( $args, $post_type ) {
   
    /* item post type slug */   
    
    if ( 'facts' === $post_type ) {
       $args['rewrite']['slug'] = 'browse';
       $args['rewrite']['with_front'] = false;
    }
    return $args;
 }
add_filter( 'register_post_type_args', 'change_facts_post_types_slug', 10, 2 );


/**
 * Remove the slug from published post permalinks. Only affect our custom post type, though.
 */
function gp_remove_cpt_slug( $post_link, $post ) {

    if ( 'facts' === $post->post_type && 'publish' === $post->post_status ) {
        // $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
        $post_link = str_replace( '/' . "browse" . '/', '/', $post_link );
    }

    return $post_link;
}
add_filter( 'post_type_link', 'gp_remove_cpt_slug', 10, 2 );

/**
 * Have WordPress match postname to any of our public post types (post, page, race).
 * All of our public post types can have /post-name/ as the slug, so they need to be unique across all posts.
 * By default, WordPress only accounts for posts and pages where the slug is /post-name/.
 *
 * @param $query The current query.
 */
function gp_add_cpt_post_names_to_main_query( $query ) {

	// Bail if this is not the main query.
	if ( ! $query->is_main_query() ) {
		return;
	}

	// Bail if this query doesn't match our very specific rewrite rule.
	if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
		return;
	}

	// Bail if we're not querying based on the post name.
	if ( empty( $query->query['name'] ) ) {
		return;
	}

	// Add CPT to the list of post types WP will include when it queries based on the post name.
	$query->set( 'post_type', array( 'post', 'page', 'facts' ) );
}
add_action( 'pre_get_posts', 'gp_add_cpt_post_names_to_main_query' );






function add_my_forms( $forms ) {
    $forms['sign-in'] = "Sign in Form";
    $forms['register'] = "Custom Register Form";
    return $forms;
}
add_filter( 'cptch_add_form', 'add_my_forms' );

add_filter('wp_authenticate_user', 'factbid_auth_login',2,2);

function factbid_auth_login ($user, $password) {
    global $factbid_messages;
    $factbid_messages = new WP_Error;
    //do any extra validation stuff here
    $user_activation_status = get_user_meta($user->ID, 'user_activation_status', true);

    if ($user_activation_status == 0 && $user->ID != 1) {
        $error = "Please Verify Your Email First";
        wp_redirect( home_url("/sign-in?errordata=" . $error) ); 
        exit;
        $user_verification_settings = get_option('user_verification_settings');

        $email_verification_enable = isset($user_verification_settings['email_verification']['enable']) ? $user_verification_settings['email_verification']['enable'] : 'yes';

        if ($email_verification_enable != 'yes') {
            $error = "Please Verify Your Email First";
            wp_redirect( home_url("/sign-in?errordata=" . $error) ); 
            exit;
        }
        
    }


    $error = apply_filters( 'cptch_verify', true, 'string', 'sign-in' );
    if ( true === $error ) { /* the CAPTCHA answer is right */
        return $user;
    } else { /* the CAPTCHA answer is wrong or there are some other errors */
        $factbid_messages->add('Captcha', $error);
        $errordata = $error;
        wp_redirect( home_url("/sign-in?errordata=" . $errordata) ); 
        exit;
    }
    
}

add_action('template_redirect', 'user_register_function');
function user_register_function (){

    if (isset($_POST['user_registeration']))
    {
        //registration_validation($_POST['username'], $_POST['useremail']);
        global $reg_errors;
        $reg_errors = new WP_Error;
        $username=$_POST['username'];
        $useremail=$_POST['useremail'];
        $password=$_POST['password'];
        $password_confirmation=$_POST['password_confirmation'];
        
        $error = apply_filters( 'cptch_verify', true, 'string', 'sign-in' );
        if ( true === $error ) {

            if(empty( $username ) || empty( $useremail ) || empty($password))
            {
                $reg_errors->add('field', 'Required form field is missing');
            }    
            if ( 6 > strlen( $username ) )
            {
                $reg_errors->add('username_length', 'Username too short. At least 6 characters is required' );
            }
            if ( username_exists( $username ) )
            {
                $reg_errors->add('user_name', 'The username you entered already exists!');
            }
            if ( ! validate_username( $username ) )
            {
                $reg_errors->add( 'username_invalid', 'The username you entered is not valid!' );
            }
            if ( !is_email( $useremail ) )
            {
                $reg_errors->add( 'email_invalid', 'Email id is not valid!' );
            }
            
            if ( email_exists( $useremail ) )
            {
                $reg_errors->add( 'email', 'Email Already exist!' );
            }
            if ( 8 > strlen( $password ) ) {
                $reg_errors->add( 'password', 'Password length must be greater than 8!' );
            }
            if(!preg_match('/[A-Z]/', $password)){
                $reg_errors->add( 'password', 'Password must contain atleast one Uppercase letter!' );
            }
            if(!preg_match('/[a-z]/', $password)){
                $reg_errors->add( 'password', 'Password must contain atleast one Lowerrcase letter!' );
            }
            if(!preg_match('/[^\w]/', $password)){
                $reg_errors->add( 'password', 'Password must contain atleast one Special Character!' );
            }
            if(!preg_match('/[0-9]/', $password)){
                $reg_errors->add( 'password', 'Password must contain atleast one number!' );
            }
            // Check password confirmation_matches  
            if(0 !== strcmp($password, $password_confirmation))
            {  
                $reg_errors->add( 'password', 'Passwords do not match!' );
            }  
            
        } else {
            $reg_errors->add('captcha', $error);
        }

        if (is_wp_error( $reg_errors ))
        { 
            foreach ( $reg_errors->get_error_messages() as $error )
            {
                $signUpError=$error;
            }
        wp_redirect( home_url("/register?errordata=" . $signUpError) ); 
        }
        
        
        if ( 1 > count( $reg_errors->get_error_messages() ) )
        {
            // sanitize user form input
            global $username, $useremail;
            $username   =   sanitize_user( $_POST['username'] );
            $useremail  =   sanitize_email( $_POST['useremail'] );
            $password   =   esc_attr( $_POST['password'] );
            
            $userdata = array(
                'user_login'    =>   $username,
                'user_email'    =>   $useremail,
                'user_pass'     =>   $password,
                );
            $user = wp_insert_user( $userdata );
            
            $errordata = "You are successfully Registered with us. You will recieve a confirmation email soon";
            wp_redirect( home_url("/sign-in?errordata=" . $errordata) ); 
            exit;
        }
        

    }


}

add_action( 'wp_ajax_edit_bid', 'edit_bid' );
add_action( 'wp_ajax_nopriv_edit_bid', 'edit_bid' );
function edit_bid (){
    global $wpdb, $factbid_messages;
    $factbid_messages = new WP_Error;
    $id_bid = $_REQUEST['id_bid'];

    $results = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM ct_bid WHERE id_bid = %d",
        $id_bid
    ));

    $html = "";
    if(!empty($results)){
        foreach($results as $result){
        
            $html .= "<h3>Test Data</h3>";
        }
    }

    echo $html;
    wp_die();
}

add_action( 'wp_ajax_view_bid', 'view_bid' );
add_action( 'wp_ajax_nopriv_view_bid', 'view_bid' );
function view_bid (){
    global $wpdb, $factbid_messages;
    $factbid_messages = new WP_Error;
    $id_bid = $_REQUEST['id_bid'];
    $results = $wpdb->prepare(
        "SELECT * FROM ct_bid WHERE id_bid = %f",
        $id_bid
    );
    $html = "";
    if(!empty($results)){
        foreach($results as $result){
        
            $html .= "<h3>Test Data</h3>";
        }
    }
    

    echo $html;
    wp_die();
}

add_action( 'wp_ajax_factbid_add_profile_rating', 'factbid_add_profile_rating' );
add_action( 'wp_ajax_nopriv_factbid_add_profile_rating', 'factbid_add_profile_rating' );
function factbid_add_profile_rating (){
    global $wpdb;
    $tablename='ct_profilerating';
    $profile_id = $_REQUEST['profile_id'];
    $rating = $_REQUEST['rating'];
    $user_id = $_REQUEST['user_id'];
    $results = $wpdb->get_results($wpdb->prepare("SELECT rating FROM ct_profilerating WHERE id_profile=%d AND id_user=%d",$profile_id,$user_id));
    if(empty($results)){
        $wpdb->insert('ct_profilerating',array('id_user'=>$user_id,'id_profile'=>$profile_id,'rating'=>$rating, 'date' => wp_date('Y-m-d H:i:s')));
        echo "success";
    }
    else{
        echo "failed";
    }
    wp_die();
}

function display_rating($profile_id = '') {
    global $wpdb;
    $results = $wpdb->get_results($wpdb->prepare("SELECT rating FROM ct_profilerating WHERE id_profile=%d",$profile_id));
    $count = count($results);
    
    $rating_array = [];
    $rating = 0;
    if(!empty($results)){
        foreach($results as $ratings){
            $rating_array[] = $ratings->rating;
        }
        $total_rating = array_sum($rating_array);
        if($total_rating == 0 || $count == 0){
            $avg_rating = 0;
        } else {
            $avg_rating = $total_rating/$count;
        }
        
        $rating = round($avg_rating);
    }
    

    $user_id =  get_current_user_id();
    $html = "<ul class='rating_block'>";
    for($i=1; $i<=5; $i++){
        $class = '';
        if($i <= $rating){
            $class = "starred";
        }
        $html .= "<li class='rating ".$class."' data-id='".$profile_id."' data-user='".$user_id."' data-rating='".$i."'>";
        $html .= "</li>";
        unset($class);
    }
    $html .= "</ul>";
    return $html;
}

function factbid_get_author_name($user_id) {
    $fname = get_the_author_meta('first_name', $user_id);
    $lname = get_the_author_meta('last_name', $user_id);
    $full_name = '';

    if( empty($fname) && empty($lname)){
        $full_name = get_the_author_meta('display_name', $user_id);
    } else if( empty($fname)){
        $full_name = $lname;
    } elseif( empty( $lname )){
        $full_name = $fname;
    } else {
        //both first name and last name are present
        $full_name = "{$fname} {$lname}";
    }

    return $full_name;
}
function factbid_get_author_link($user_id) {
    $fname = get_the_author_meta('first_name', $user_id);
    $lname = get_the_author_meta('last_name', $user_id);
    $full_name = '';

    if( empty($fname) && empty($lname)){
        $full_name = get_the_author_meta('display_name', $user_id);
    } else if( empty($fname)){
        $full_name = $lname;
    } elseif( empty( $lname )){
        $full_name = $fname;
    } else {
        //both first name and last name are present
        $full_name = "{$fname} {$lname}";
    }
    $link = get_author_posts_url( $user_id );
    $html = "<a href='".esc_url($link)."' class='author_link'>".$full_name."</a>";

    return $html;
}
function show_all_authors(){
    $authors = wp_list_authors('html=0&style=none&echo=0&exclude_admin=0&optioncount=0&show_fullname=1&hide_empty=1&orderby=name&order=ASC&includeauthorid=1');
    print_r($authors);
}

function show_language_from_id ($id){
    $languages = get_option("languages", true);
    $return = "";
    if($languages && !empty($languages)){
        foreach($languages as $key => $language){
            if($id == $key){
                $return = $language["name"];
            }
        }
    }
    return $return;
}

function show_create_factbid_button() {
    global $wpdb;
    $html = '';
    $user_id = get_current_user_id();
    if($user_id == '' || $user_id == 0) {
        $html .= '<a class="btn btn-primary" href="' . esc_url(home_url('/create-factbid')) . '">Create Factbid</a>';
        
    } else {
        $results = $wpdb->get_results($wpdb->prepare("SELECT post_status FROM ct_profile WHERE id_user=%d",$user_id));
        $post_status = $results[0]->post_status;
        if($post_status == "Approved"){
            $html .= '<a class="btn btn-primary" href="' . esc_url(home_url('/create-factbid')) . '">Create Factbid</a>';
        } else {
            $html .= '<a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#factBidPermission" href="' . esc_url(home_url('/create-factbid')) . '">Create Factbid</a>';
            $rp = file_get_contents(locate_template( "popups/ask-permission.php", false, true, $args = array('user_id' => $user_id) ));
            $rpl = str_replace("{{ user_id }}", $user_id, $rp);
            $html .= $rpl;
        }
    }
    return $html;
}
function show_create_claim_button($post_id) {
    global $wpdb;
    $html = '';
    $user_id = get_current_user_id();
    if($user_id == '' || $user_id == 0) {
        $html .= '<a class="btn btn-primary create-claim-page" href="' . esc_url(home_url('/create-claim?id=')) .$post_id. '">Create Claim</a>';
        
    } else {
        $results = $wpdb->get_results($wpdb->prepare("SELECT post_status FROM ct_profile WHERE id_user=%d",$user_id));
        $post_status = $results[0]->post_status;
        if($post_status == "Approved"){
            $html .= '<a class="btn btn-primary create-claim-page" href="' . esc_url(home_url('/create-claim?id=')) .$post_id. '">Create Claim</a>';
        } else {
            $html .= '<a class="btn btn-primary create-claim-page" data-bs-toggle="modal" data-bs-target="#factBidPermission" href="' . esc_url(home_url('/create-claim?id=')) .$post_id. '">Create Claim</a>';
            $rp = file_get_contents(locate_template( "popups/ask-permission.php", false, true, $args = array('user_id' => $user_id) ));
            $rpl = str_replace("{{ user_id }}", $user_id, $rp);
            $html .= $rpl;
        }
    }
    return $html;
}
add_action( 'wp_ajax_factbid_update_post_request', 'factbid_update_post_request' );
add_action( 'wp_ajax_nopriv_factbid_update_post_request', 'factbid_update_post_request' );
function factbid_update_post_request() {
    global $wpdb, $factbid_messages;
    $factbid_messages = new WP_Error;
    $user_id = $_REQUEST['user_id'];
    $content = $_REQUEST['content'];
    $results = $wpdb->get_results($wpdb->prepare("SELECT post_request FROM ct_profile WHERE id_user=%d",$user_id));
    if(!empty($results)){
        
        $tablename = 'ct_profile';
        $data = array(
            'post_request'=>$content,
            'post_status'=>"Pending",
        );
        $where = [ 'id_user' => $user_id ];
        $res = $wpdb->update( $tablename, $data, $where);


        $email = get_bloginfo( "admin_email" );
        $user = get_user_by("ID", $user_id);
        $fname = $lname = '';
        if($user){
            $fname = $user->first_name;
            $lname = $user->last_name;
        }
        $username = $fname . ' ' . $lname;
        $headers = 'From: ' . get_bloginfo( "name" ) . ' <' . get_bloginfo( "admin_email" ) . '>' . "\r\n";
        
        $subject = "FactBid - Request for access";
        $text = 'The User - ' . $username . ' has requested to allow him to create Factbid.';
        $text .= 'You can Approve the request from the following link.';
        $text .= esc_url(home_url('/approve-users'));
        add_filter('wp_mail_content_type', function( $content_type ) {
            return 'text/html';
        });
        wp_mail( $email, $subject, $text, $headers );
        $factbid_messages->add('Pending', 'Your Request is send for Admin approval.');
        echo $wpdb->last_error;
    }
    wp_die();
}

add_action( 'wp_ajax_factbid_approve_post_request', 'factbid_approve_post_request' );
add_action( 'wp_ajax_nopriv_factbid_approve_post_request', 'factbid_approve_post_request' );
function factbid_approve_post_request() {
    global $wpdb, $factbid_messages;
    $factbid_messages = new WP_Error;
    $user_id = $_REQUEST['user_id'];
    $results = $wpdb->get_results($wpdb->prepare("SELECT post_request FROM ct_profile WHERE id_user=%d",$user_id));
    if(!empty($results)){
        
        $tablename = 'ct_profile';
        $data = array(
            'post_status'=>"Approved",
        );
        $where = [ 'id_user' => $user_id ];
        $res = $wpdb->update( $tablename, $data, $where);
        $factbid_messages->add('Approved', 'User is able to post Factbid now.');
        echo $wpdb->last_error;
    }
    wp_die();
}


/**
 * @param  int $user_id User ID.
 *
 * @return bool Whether the user exists.
 */
function does_user_exist( int $user_id ) : bool {
    return (bool) get_users( [ 'include' => $user_id, 'fields' => 'ID' ] );
}

add_action('template_redirect', 'profile_redirect');
function profile_redirect(){
    if(is_page('profile')){
        if(isset($_GET['id'])){
            $id_user = $_GET['id'];
            if(!does_user_exist($id_user)){
               wp_redirect( home_url('/profile') ); exit;
            }
        }
    }
}
/* Disable WordPress Admin Bar for all users */
add_filter( 'show_admin_bar', '__return_false' );

function wpse_11244_restrict_admin() {

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_redirect( home_url('/profile') );
        exit;
    }
}

add_action( 'admin_init', 'wpse_11244_restrict_admin', 1 );

/**
 * Function Name: front_end_login_fail.
 * Description: This redirects the failed login to the custom login page instead of default login page with a modified url
**/
add_action( 'wp_login_failed', 'front_end_login_fail' );
function front_end_login_fail( $username ) {

// Getting URL of the login page
$referrer = $_SERVER['HTTP_REFERER'];    
// if there's a valid referrer, and it's not the default log-in screen
if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) {
    wp_redirect( esc_url(home_url("/sign-in")) . "?login=failed" ); 
    exit;
}

}

/**
 * Function Name: check_username_password.
 * Description: This redirects to the custom login page if user name or password is   empty with a modified url
**/
add_action( 'authenticate', 'check_username_password', 1, 3);
function check_username_password( $login, $username, $password ) {

// Getting URL of the login page
$referrer = $_SERVER['HTTP_REFERER'];

// if there's a valid referrer, and it's not the default log-in screen
if( !empty( $referrer ) && !strstr( $referrer,'wp-login' ) && !strstr( $referrer,'wp-admin' ) ) { 
    if( $username == "" || $password == "" ){
        wp_redirect( esc_url(home_url("/sign-in")) . "?login=empty" ); 
        exit;
    }
}

}
function my_comment_time_ago_function() {
    return sprintf( esc_html__( '%s ago', 'textdomain' ), human_time_diff(get_comment_time ( 'U' ), current_time( 'timestamp' ) ) );
}
add_filter( 'get_comment_date', 'my_comment_time_ago_function' );

function get_bid_count($factbid_id){
    global $wpdb;
    $bid_data = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT * FROM ct_bid WHERE id_factbid = %f",
            $factbid_id
        )
    );
    
    
    $total_bids = 0;
    $total_bid_amount = 0;
    $total_bids = count($bid_data);
    foreach($bid_data as $bid){
      $total_bid_amount += $bid->amount;
    }
    $return_array = array(
        "bid_count" => $total_bids,
        "bid_amount" => $total_bid_amount,
    );
    return $return_array;
}
function get_claims_count($factbid_id){
    global $wpdb;
    $claims_data = $wpdb->get_results( 
        $wpdb->prepare(
            "SELECT * FROM ct_claim WHERE id_factbid = %f",
            $factbid_id
        )
    );
    $total_claims = count($claims_data);
    return $total_claims;
}



add_action( 'wp_footer', 'monitor_jquery_ajax_requests' );
function monitor_jquery_ajax_requests() {
    
    echo "<script>
    jQuery(document).ajaxSend( function( event, xhr, options ) {
        jQuery('.loader').show();
    }).ajaxComplete( function( event, xhr, options ) {
        jQuery('.loader').hide();
    });
    </script>";

}
// add_action('init', function(){
//     global $wpdb;
//     $delete = $wpdb->query("TRUNCATE TABLE `ct_bid`");
//     $delete1 = $wpdb->query("TRUNCATE TABLE `ct_claim`");
//     $delete2 = $wpdb->query("TRUNCATE TABLE `ct_factbid`");
//     $delete3 = $wpdb->query("TRUNCATE TABLE `ct_fact_thumbs`");
//     $delete4 = $wpdb->query("TRUNCATE TABLE `ct_response`");
//     $delete5 = $wpdb->query("TRUNCATE TABLE `ct_votes`");
//     $delete6 = $wpdb->query("TRUNCATE TABLE `ct_newsletter`");
//     $delete7 = $wpdb->query("TRUNCATE TABLE `ct_factbidreporting`");
//     // $delete8 = $wpdb->query("TRUNCATE TABLE `ct_profilerating`");
// });


function factbid_rename_permalink($url, $post) {
    
    if ( 'facts' == get_post_type( $post ) ) {
        $nwurl = esc_url(home_url('/')) . $post->post_name;
        return $nwurl;
    }
    return $url;

}

add_filter( 'post_type_link', 'factbid_rename_permalink', 10, 2 );
add_filter( 'page_link', 'factbid_rename_permalink', 10, 2 );
add_filter( 'post_link', 'factbid_rename_permalink', 10, 2 );

/**
 * Change Usernames if Social Login
 */
add_filter('nsl_registration_user_data', function($userData, $provider){
    $sanitized_user_login = $provider->getAuthUserData('first_name') . $provider->getAuthUserData('last_name');
    if ($sanitized_user_login === false) {
        $sanitized_user_login = $provider->getAuthUserData('username');
        if ($sanitized_user_login === false) {
            $sanitized_user_login = $provider->getAuthUserData('name');
        }
    }
    $userData['username'] = $sanitized_user_login.md5(uniqid(rand()));
            
    return $userData;
},10,2);


add_action( 'admin_enqueue_scripts', 'misha_include_js' );

function misha_include_js() {

	// I recommend to add additional conditions just to not to load the scipts on each page
	
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
 
 	wp_enqueue_script( 'myuploadscript', get_stylesheet_directory_uri() . '/assets/js/adminscript.js', array( 'jquery' ) );
}

add_action('admin_menu', 'factbid_settings_page');
function factbid_settings_page() {
    add_menu_page(
       __( 'Site Settings', 'textdomain' ),
       __( 'Site Settings','textdomain' ),
       'manage_options',
       'factbid-site-settings',
       'factbid_site_settings_callback',
       ''
   );
}

function factbid_site_settings_callback() {
    $image_id = 0;

    $html = "<h1>Site Settings</h1><hr/>";
    $html .= "<h4>Slider Settings</h4><hr/>";
    $html .= "<form method='POST' action='/'>";
    for($i=1; $i<=3; $i++){
        $html .= "<fieldset>";
        $html .= "<div class='form-group'><label for='slider_img$i'>Slider $i Image: </label>";
        if( $image = wp_get_attachment_image_src( $image_id ) ) {

            $html .= '<a href="#" class="misha-upl"><img src="' . $image[0] . '" /></a>
                  <a href="#" class="misha-rmv">Remove image</a><br/>
                  <input type="hidden" name="misha-img'.$i.'" value="' . $image_id . '">';
        
        } else {
        
            $html .= '<a href="#" class="misha-upl">Upload image</a>
                  <a href="#" class="misha-rmv" style="display:none">Remove image</a><br/>
                  <input type="hidden" name="misha-img'.$i.'" value="">';
        
        } 



        // $html .= "<input type='file' name='slider_img$i' id='slider_img$i'><br/>";
        $html .= "</div>";
        $html .= "<div class='form-group'><label for='slider_video$i'>Slider $i Video: </label>";
        $html .= "<input type='text' name='slider_video$i' id='slider_video$i'></div><br/>";
        $html .= "<div class='form-group'><label for='slider_text$i'>Slider $i Text: </label>";
        $html .= "<textarea name='slider_text$i' id='slider_text$i'></textarea></div><br/>";
        $html .= "</fieldset><hr/>";
    }
    
    
    $html .= "</form>";
    echo $html;
}
add_action( 'wp_ajax_verify_website', 'verify_website' );
add_action( 'wp_ajax_nopriv_verify_website', 'verify_website' );
function verify_website() {
    global $wpdb;
    $factbid_messages = new WP_Error;
    $id_user = $_POST['id_user'];
    $res = $wpdb->update('ct_profile',array(
                            'verified'=> 'Link Verified'
                        ),array('id_user' => $id_user)); 
    if($res == 1){
        echo "success";
    }
    else{
        echo $wpdb->last_error;
    }
    wp_die();
}

