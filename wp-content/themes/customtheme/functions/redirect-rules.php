<?php
// add_action('template_redirect', 'show_bids');
// function show_bids() {
//     global $post, $wp;
//     if(preg_match( '#^bids(/.+)?$#', $wp->request)){
//         echo "Hello";
//         die;
//     }
// }


/**
 * Add rewrite tags and rules
 */
// add_action( 'init', 'add_author_rules' );
// function add_author_rules() { 
//     add_rewrite_rule(
//         "user/([^/]+)/?",
//         "index.php?author_name=$matches[1]",
//         "top");
   
//     add_rewrite_rule(
//     "user/([^/]+)/page/?([0-9]{1,})/?",
//     "index.php?author_name=$matches[1]&paged=$matches[2]",
//     "top");
   
//     add_rewrite_rule(
//     "user/([^/]+)/(feed|rdf|rss|rss2|atom)/?",
//     "index.php?author_name=$matches[1]&feed=$matches[2]",
//     "top");
     
//     add_rewrite_rule(
//     "user/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?",
//     "index.php?author_name=$matches[1]&feed=$matches[2]",
//     "top");
// }

// add_filter( 'author_link', 'modify_author_link', 10, 1 );        
// function modify_author_link( $link ) {
//     $link = str_replace( '/' . "author" . '/', '/', $link );       
//     return $link;
// }


// add_filter('template_include', 'market_include_template', 1000, 1);
// function market_include_template($template){
//     if(get_query_var('is_sidebar_page')){
//     $new_template = (theme or plugin path).'/pages/yourpage.php'; // change this path to your file 
//     if(file_exists($new_template))
//         $template = $new_template;
//     } 
//     return $template;
// }

function rewrite_bids(){
    add_rewrite_rule('^bids/([^/]*)?$','index.php?page_id=182&bid_id=$matches[1]','top');
    add_rewrite_rule('^responses/([^/]*)?$','index.php?page_id=267&response_id=$matches[1]','top');
    // add_rewrite_rule("author/([^/]+)/?", "index.php?author_name=$matches[1]", "top");
    flush_rewrite_rules();
}
add_action( 'init', 'rewrite_bids' );

function add_query_vars_bids($aVars) {
    $aVars[] = "bid_id";
    $aVars[] = "response_id";
    return $aVars;
}

add_filter('query_vars', 'add_query_vars_bids');