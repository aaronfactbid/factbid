<!DOCTYPE html>
<html <?php language_attributes(); header('Access-Control-Allow-Origin: *'); ?>>
  <head>
    <title>
    <?php if(is_front_page() || is_home()){
        echo get_bloginfo('name');
    } else{
        echo wp_title('');
    }?>
    </title>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
  
  <?php
    global $factbid_messages;
    
    if (is_wp_error( $factbid_messages )){
      echo '<div class="toast-container">';
      foreach ( $factbid_messages->get_error_messages() as $message ) {
    ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
          <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="me-auto">Success..!!</strong>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
              <?php echo $message; ?>
            </div>
          </div>
        </div>
        <?php
            }
          echo "</div>";
        }
      ?>


  <!--Navbar-->
  <nav class="navbar navbar-expand-lg navbar-dark  p-3">
    <div class="container">
      <a class="logo" href="<?php echo esc_url(home_url()); ?>"><img alt="<?php wp_title(); ?>" src="<?php echo get_stylesheet_directory_uri() .'/assets/images/logo.png'; ?>"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class=" collapse navbar-collapse" id="navbarNavDropdown">
        <?php if ( has_nav_menu( 'header_menu' ) ) : ?>
          <?php
          wp_nav_menu( array(
            'theme_location' => 'header_menu',
            'depth'          => '1',
            'menu_class'     => 'header-nav navbar-nav ms-auto',
            'container'      => '',
            'fallback_cb'    => '',
          ) );
        ?>
        <?php endif; ?>

        <?php if ( has_nav_menu( 'header_second_menu' ) ) : ?>
          <?php
          wp_nav_menu( array(
            'theme_location' => 'header_second_menu',
            'depth'          => '1',
            'menu_class'     => 'header-nav navbar-nav ms-auto',
            'container'      => '',
            'fallback_cb'    => '',
          ) );
        ?>
        <?php endif; ?>
      </div>
    </div>
  </nav>
<!--/.Navbar-->

<div class="main-section">
  
