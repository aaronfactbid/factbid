<?php
add_action( 'wp_ajax_checking_username', 'checking_username' );
add_action( 'wp_ajax_nopriv_checking_username', 'checking_username' );
function checking_username(){
    $username=$_REQUEST['username'];
    $return = array();
    if ( 6 > strlen( $username ) ){
        $return[] = 'Username too short. At least 6 characters is required';
    }
    if ( username_exists( $username ) ){
        $return[] = 'The username you entered already exists!';
    }
    if ( ! validate_username( $username ) ){
        $return[] = "The username you entered is not valid!";
    }
    echo json_encode($return);
    wp_die();
}
add_action( 'wp_ajax_checking_email', 'checking_email' );
add_action( 'wp_ajax_nopriv_checking_email', 'checking_email' );
function checking_email(){
    $useremail=$_REQUEST['useremail'];
    $return = array();
    if ( !is_email( $useremail ) ){
        $return[] = "The username you entered is not valid!";
    }
    if ( email_exists( $useremail ) ){
        $return[] = 'The email you entered already exists!';
    }
    echo json_encode($return);
    wp_die();
}

add_action( 'wp_ajax_checking_password', 'checking_password' );
add_action( 'wp_ajax_nopriv_checking_password', 'checking_password' );
function checking_password(){
    $password=$_POST['password'];
    $return = array();
    if ( 8 > strlen( $password ) ) {
        $return[] = 'Password length must be greater than 8!';
    }
    if(!preg_match('/[A-Z]/', $password)){
        $return[] = 'Password must contain atleast one Uppercase letter!';
    }
    if(!preg_match('/[a-z]/', $password)){
        $return[] = 'Password must contain atleast one Lowercase letter!';
    }
    if(!preg_match('/[^\w]/', $password)){
        $return[] = 'Password must contain atleast one Special Character!';
    }
    if(!preg_match('/[0-9]/', $password)){
        $return[] = 'Password must contain atleast one number!';
    }
    echo $return;
    wp_die();
}

add_action( 'wp_ajax_checking_confirm_password', 'checking_confirm_password' );
add_action( 'wp_ajax_nopriv_checking_confirm_password', 'checking_confirm_password' );
function checking_confirm_password(){
    $password=$_POST['password'];
    $password_confirmation=$_POST['password_confirmation'];
    $return = array();
    if(0 !== strcmp($password, $password_confirmation)){
        $return[] = 'Passwords do not match!';
    }
    echo $return;
    wp_die();
}