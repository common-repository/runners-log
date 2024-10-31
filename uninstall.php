<?php
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();

if ( current_user_can('delete_plugins') ) {

	delete_option( OPTION_DATE_FORMAT );

  	global $wpdb;
  	$thetable = $wpdb->prefix."gear";
  	$wpdb->query("DROP TABLE IF EXISTS $thetable");
	
}
?>