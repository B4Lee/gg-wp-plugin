<?php

//https://developer.wordpress.org/plugins/

/**
 * Plugin Name:       GG WP Plugin
 * Description:       mrb4le Private Wordpress Plugin.
 * Version:           0.0.1
 * Author:            Iqbal Anggoro
 * Author URI:        https://b4le.my.id/
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 */

 //Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');


//Protect Site from Malicious Requests
global $user_ID; if($user_ID) {
    if(!current_user_can('administrator')) {
        if (strlen($_SERVER['REQUEST_URI']) > 255 ||
            stripos($_SERVER['REQUEST_URI'], "eval(") ||
            stripos($_SERVER['REQUEST_URI'], "CONCAT") ||
            stripos($_SERVER['REQUEST_URI'], "UNION+SELECT") ||
            stripos($_SERVER['REQUEST_URI'], "base64")) {
                @header("HTTP/1.1 414 Request-URI Too Long");
                @header("Status: 414 Request-URI Too Long");
                @header("Connection: Close");
                @exit;
        }
    }
}


//Replace the “Howdy, User Name” with Logged in as
function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy,', 'You’re being watched', $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );

//Displaying Last Updated Date in WordPress
function wpb_last_updated_date( $content ) {
    $u_time = get_the_time('U'); 
    $u_modified_time = get_the_modified_time('U'); 
    if ($u_modified_time >= $u_time + 86400) { 
    $updated_date = get_the_modified_time('F jS, Y');
    $updated_time = get_the_modified_time('h:i a'); 
    $custom_content .= '<p class="last-updated">Last updated on '. $updated_date . ' at '. $updated_time .'</p>';  
    } 
     
        $custom_content .= $content;
        return $custom_content;
    }
add_filter( 'the_content', 'wpb_last_updated_date' );


// https://smartwp.com/code-snippets-for-wordpress/
// https://www.wpkube.com/code-snippets-wordpress/
// https://www.wpbeginner.com/wp-tutorials/display-the-last-updated-date-of-your-posts-in-wordpress/
// $u_time = get_the_time('U'); 
// $u_modified_time = get_the_modified_time('U'); 
// if ($u_modified_time >= $u_time + 86400) { 
// echo "<p>Last modified on "; 
// the_modified_time('F jS, Y'); 
// echo " at "; 
// the_modified_time(); 
// echo "</p> "; } 



