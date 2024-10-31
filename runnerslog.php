<?php
/*
Plugin Name: Runners Log
Plugin URI: http://wordpress.org/extend/plugins/runners-log/
Description: This plugin let you convert your blog into a training log and let you track your activities. You get advance statistics and running related calculators. See screenshots.
Author: Frederik Liljefred
Author URI: http://www.liljefred.dk
Contributors: frold, TheRealEyeless, michaellasmanis
Version: 3.9.2
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Requires WordPress 2.7 or later.

/*  
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Version check */
global $wp_version;	

$exit_msg='Runners Log requires WordPress 2.7 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';

if (version_compare($wp_version,"2.7","<")) {
	exit ($exit_msg);
}

include('runnerslog_chart.php');
include('runnerslog_tag.php');
include('runnerslog_gchart.php');
include('runnerslog_gear.php');

/* Get the plugin-base-url for use of the gear-list */
$gear_plugIn_base_url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?page=runners-log-gear';

// Do this when user activates the plugin (Update Script)
register_activation_hook(__FILE__, 'runners_log_update');
register_activation_hook(__FILE__, 'wp_gear_manager_install');

// Update the old custom fields to match the new one used from version 1.5.0
function runners_log_update()
{ 
	global $wpdb;
	//Meters
	$sql = $wpdb->get_results("
		UPDATE $wpdb->postmeta
		SET $wpdb->postmeta.meta_key = '_rl_distance_value'
		WHERE $wpdb->postmeta.meta_key = 'Meters'");	
	//Time
	$sql = $wpdb->get_results("
		UPDATE $wpdb->postmeta
		SET $wpdb->postmeta.meta_key = '_rl_time_value'
		WHERE $wpdb->postmeta.meta_key = 'Time'	");	
	//GarminConnectLink
	$sql = $wpdb->get_results("
		UPDATE $wpdb->postmeta
		SET $wpdb->postmeta.meta_key = '_rl_garminconnectlink_value'
		WHERE $wpdb->postmeta.meta_key = 'GarminConnectLink'");	
	//Pulsavg
	$sql = $wpdb->get_results("
		UPDATE $wpdb->postmeta
		SET $wpdb->postmeta.meta_key = '_rl_pulsavg_value'
		WHERE $wpdb->postmeta.meta_key = 'Pulsavg'");
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}

//Add a new table in the DB for the gear manager
function wp_gear_manager_install()
{
	global $wpdb;
    $table = $wpdb->prefix."gear";
    $structure = "CREATE TABLE $table (
		`gear_id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`gear_brand` VARCHAR( 100 ) NOT NULL ,
		`gear_name` VARCHAR( 100 ) NOT NULL ,
		`gear_price` VARCHAR( 100 ) NOT NULL ,
		`gear_distance` VARCHAR( 100 ) NOT NULL ,
		`gear_distance_calc` VARCHAR( 100 ) NOT NULL ,
		`gear_desc` TEXT NOT NULL ,
		`gear_dateTo` DATE NOT NULL ,
		`gear_isDone` TINYINT NOT NULL ,
		`gear_image` VARCHAR( 255 ) NOT NULL 
		) ENGINE = MYISAM";
    $wpdb->query( $structure );
    update_option( OPTION_DATE_FORMAT, 'd/m/Y' ); //Standart date format for the use of the gear manager
}

// Add a settings option in wp-admin/plugins.php
function rl_filter_plugin_actions($links) 
{
	$new_links = array();
	$new_links[] = '<a href="admin.php?page=runners-log">' . __('Settings', 'runners-log') . '</a>';
	return array_merge($new_links, $links);
}
add_action('plugin_action_links_' . plugin_basename(__FILE__), 'rl_filter_plugin_actions');

// Add FAQ and support information and a little more in wp-admin/plugins.php
function rl_filter_plugin_links($links, $file)
{
	if ( $file == plugin_basename(__FILE__) )
	{
		$links[] = '<a href="http://wordpress.org/extend/plugins/runners-log/faq/">' . __('FAQ', 'runners-log') . '</a>';
		$links[] = '<a href="http://wordpress.org/tags/runners-log?forum_id=10">' . __('Support', 'runners-log') . '</a>';
		#$links[] = '<a href="http://wordpress.org/support/topic/358411">' . __('Share where you use it', 'runners-log') . '</a>';
	}
return $links;
}
add_filter('plugin_row_meta', 'rl_filter_plugin_links', 10, 2);

/* Let us create the functions */
//[runners_log_basic]
function runners_log_basic() 
{
	global $wpdb, $post;

	$hms = get_post_meta($post->ID, "_rl_time_value", $single = true); // Get the running time
	$distance = get_post_meta($post->ID, "_rl_distance_value", $single = true); // Get the distance
	$url = get_post_meta($post->ID, "_rl_garminconnectlink_value", $single = true); // Get the Garmin Connect Link
	$pulsavg = get_post_meta($post->ID, "_rl_pulsavg_value", $single = true); // Get pulsavg.
	$calories = get_post_meta($post->ID, "_rl_calories_value", $single = true); // Get calories.
	$cadence = get_post_meta($post->ID, "_rl_cadence_value", $single = true); // Get cadence.

	// Get [runners_log_basic] settings
	$show_distance = get_option('runnerslog_show_distance');
	$show_time = get_option('runnerslog_show_time');
	$show_speed = get_option('runnerslog_show_speed');
	$show_speedperdistance = get_option('runnerslog_show_speedperdistance');
	$show_pulse = get_option('runnerslog_show_pulse');
	$show_calories = get_option('runnerslog_show_calories');
	$show_cadence = get_option('runnerslog_show_cadence');
	$show_garminconnect = get_option('runnerslog_show_garminconnect');
	$show_distance2009 = get_option('runnerslog_show_distance2009');
	$show_distance2010 = get_option('runnerslog_show_distance2010');
	$show_distance2011 = get_option('runnerslog_show_distance2011');
	$show_distance2012 = get_option('runnerslog_show_distance2012');
	$show_distance2013 = get_option('runnerslog_show_distance2013');
	$show_distance2014 = get_option('runnerslog_show_distance2014');
	$show_distance2015 = get_option('runnerslog_show_distance2015');
	$show_distance2016 = get_option('runnerslog_show_distance2016');
	$show_distance2017 = get_option('runnerslog_show_distance2017');
	$show_distance2018 = get_option('runnerslog_show_distance2018');
	$show_distance2019 = get_option('runnerslog_show_distance2019');
	$show_distance_sum = get_option('runnerslog_show_distance_sum');
	$show_garminmap = get_option('runnerslog_show_garminmap');

	// We want to calculate the %of Max HR and the %of HRR
	$hrrest = get_option('runnerslog_hrrest');
	$hrmax = get_option('runnerslog_hrmax');
	if ($hrmax && $hrrest) 
	{
		$procofmaxhr = ROUND(($pulsavg/$hrmax)*100,0); 	//Calculate %of Max HR
		$procofhrr = ROUND((($pulsavg-$hrrest)/($hrmax-$hrrest)*100),0);	//Calculate %of Heart Rate Reserve
	}

	$seconds = hms2sec($hms); // Use the hms2sec function on $hms (the running time)

	$distancetype = get_option('runnerslog_distancetype'); // Let us get the distancetype for further calculations
	
	if ($distance) // Calculate the avg running speed per hour
	{
		$km_per_hour = Round((($distance/1000) / ($seconds/3600)),2); //First we calculate it per km and round it to 2 decimals
		$miles_per_hour = Round((($distance) / ($seconds/3600)),2); //Here we calculate it per miles and round it to 2 decimals
	}
	
	if ($distance) // Calculate number of minutes per km
	{
		$min_per_km= ($seconds) / ($distance/1000);
		$minutes = floor($min_per_km/60);
		$secondsleft = $min_per_km%60;
		if($minutes<10) {
			$minutes = "0" . $minutes;
		}
		if($secondsleft<10) {
			$secondsleft = "0" . $secondsleft;
		}
	}		

	if ($distance) // Calculate number of minutes per miles
	{ 
		$min_per_miles= ($seconds) / ($distance);
		$minutes_miles = floor($min_per_miles/60);
		$secondsleft_miles = $min_per_miles%60;
		if($minutes_miles<10) {
			$minutes_miles = "0" . $minutes_miles;
		}
		if($secondsleft_miles<10) {
			$secondsleft_miles = "0" . $secondsleft_miles;
		}
	}

/* 2 0 0 9 */
	// Connect to DB and calculate the sum of distance runned in 2009
	$distance_sum_2009 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2009'",0,0));
	$km_sum_2009 = round($distance_sum_2009/1000, 1); // Convert distance to km when the user use "meters"

	// Connect to DB and calculate the number of runs in 2009
	$number_of_runs_2009 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2009'",0,0));

	if ($distance_sum_2009) // Calculate the avg per run in 2009
	{
		$avg_km_per_run_2009 = ROUND(($distance_sum_2009/1000) / $number_of_runs_2009, 2);
		$avg_miles_per_run_2009 = ROUND(($distance_sum_2009) / $number_of_runs_2009, 2);
	}

/* 2 0 1 0 */	
	// Connect to DB and calculate the sum of distance runned in 2010
	$distance_sum_2010 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2010
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2010'",0,0));
	$km_sum_2010 = round($distance_sum_2010/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2010
	$number_of_runs_2010 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2010'",0,0));

	if ( $distance_sum_2010 ) // Calculate the avg per run in 2010
	{
		$avg_km_per_run_2010 = ROUND(($distance_sum_2010/1000) / $number_of_runs_2010, 2);
		$avg_miles_per_run_2010 = ROUND(($distance_sum_2010) / $number_of_runs_2010, 2);
	}
    
/* 2 0 1 1 */	
	// Connect to DB and calculate the sum of distance runned in 2011
	$distance_sum_2011 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2011
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2011'",0,0));
	$km_sum_2011 = round($distance_sum_2011/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2011
	$number_of_runs_2011 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2011'",0,0));

	if ( $distance_sum_2011 ) // Calculate the avg per run in 2011
	{
		$avg_km_per_run_2011 = ROUND(($distance_sum_2011/1000) / $number_of_runs_2011, 2);
		$avg_miles_per_run_2011 = ROUND(($distance_sum_2011) / $number_of_runs_2011, 2);
	}

/* 2 0 1 2 */	
	// Connect to DB and calculate the sum of distance runned in 2012
	$distance_sum_2012 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2012
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2012'",0,0));
	$km_sum_2012 = round($distance_sum_2012/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2012
	$number_of_runs_2012 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2012'",0,0));

	if ( $distance_sum_2012 ) // Calculate the avg per run in 2012
	{
		$avg_km_per_run_2012 = ROUND(($distance_sum_2012/1000) / $number_of_runs_2012, 2);
		$avg_miles_per_run_2012 = ROUND(($distance_sum_2012) / $number_of_runs_2012, 2);
	}

/* 2 0 1 3 */	
	// Connect to DB and calculate the sum of distance runned in 2013
	$distance_sum_2013 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2013
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2013'",0,0));
	$km_sum_2013 = round($distance_sum_2013/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2013
	$number_of_runs_2013 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2013'",0,0));

	if ( $distance_sum_2013 ) // Calculate the avg per run in 2013
	{
		$avg_km_per_run_2013 = ROUND(($distance_sum_2013/1000) / $number_of_runs_2013, 2);
		$avg_miles_per_run_2013 = ROUND(($distance_sum_2013) / $number_of_runs_2013, 2);
	}

/* 2 0 1 4 */	
	// Connect to DB and calculate the sum of distance runned in 2014
	$distance_sum_2014 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2014
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2014'",0,0));
	$km_sum_2014 = round($distance_sum_2014/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2014
	$number_of_runs_2014 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2014'",0,0));

	if ( $distance_sum_2014 ) // Calculate the avg per run in 2014
	{
		$avg_km_per_run_2014 = ROUND(($distance_sum_2014/1000) / $number_of_runs_2014, 2);
		$avg_miles_per_run_2014 = ROUND(($distance_sum_2014) / $number_of_runs_2014, 2);
	}

/* 2 0 1 5 */	
	// Connect to DB and calculate the sum of distance runned in 2015
	$distance_sum_2015 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2015
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2015'",0,0));
	$km_sum_2015 = round($distance_sum_2015/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2015
	$number_of_runs_2015 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2015'",0,0));

	if ( $distance_sum_2015 ) // Calculate the avg per run in 2015
	{
		$avg_km_per_run_2015 = ROUND(($distance_sum_2015/1000) / $number_of_runs_2015, 2);
		$avg_miles_per_run_2015 = ROUND(($distance_sum_2015) / $number_of_runs_2015, 2);
	}

/* 2 0 1 6 */	
	// Connect to DB and calculate the sum of distance runned in 2016
	$distance_sum_2016 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2016
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2016'",0,0));
	$km_sum_2016 = round($distance_sum_2016/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2016
	$number_of_runs_2016 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2016'",0,0));

	if ( $distance_sum_2016 ) // Calculate the avg per run in 2016
	{
		$avg_km_per_run_2016 = ROUND(($distance_sum_2016/1000) / $number_of_runs_2016, 2);
		$avg_miles_per_run_2016 = ROUND(($distance_sum_2016) / $number_of_runs_2016, 2);
	}

/* 2 0 1 7 */	
	// Connect to DB and calculate the sum of distance runned in 2017
	$distance_sum_2017 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2017
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2017'",0,0));
	$km_sum_2017 = round($distance_sum_2017/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2017
	$number_of_runs_2017 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2017'",0,0));

	if ( $distance_sum_2017 ) // Calculate the avg per run in 2017
	{
		$avg_km_per_run_2017 = ROUND(($distance_sum_2017/1000) / $number_of_runs_2017, 2);
		$avg_miles_per_run_2017 = ROUND(($distance_sum_2017) / $number_of_runs_2017, 2);
	}

/* 2 0 1 8 */	
	// Connect to DB and calculate the sum of distance runned in 2018
	$distance_sum_2018 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2018
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2018'",0,0));
	$km_sum_2018 = round($distance_sum_2018/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2018
	$number_of_runs_2018 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2018'",0,0));

	if ( $distance_sum_2018 ) // Calculate the avg per run in 2018
	{
		$avg_km_per_run_2018 = ROUND(($distance_sum_2018/1000) / $number_of_runs_2018, 2);
		$avg_miles_per_run_2018 = ROUND(($distance_sum_2018) / $number_of_runs_2018, 2);
	}

/* 2 0 1 9 */	
	// Connect to DB and calculate the sum of distance runned in 2019
	$distance_sum_2019 = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun2019
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2019'",0,0));
	$km_sum_2019 = round($distance_sum_2019/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs in 2019
	$number_of_runs_2019 = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id  
		AND year($wpdb->posts.post_date)='2019'",0,0));

	if ( $distance_sum_2019 ) // Calculate the avg per run in 2019
	{
		$avg_km_per_run_2019 = ROUND(($distance_sum_2019/1000) / $number_of_runs_2019, 2);
		$avg_miles_per_run_2019 = ROUND(($distance_sum_2019) / $number_of_runs_2019, 2);
	}

/* S U M  A T  A L L */	
	// Connect to DB and calculate the sum of distance runned at all
	$distance_sum = $wpdb->get_var($wpdb->prepare("
		SELECT SUM($wpdb->postmeta.meta_value), COUNT($wpdb->postmeta.meta_value) as numberofrun
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->postmeta.post_id=$wpdb->posts.id",0,0));
	$km_sum = round($distance_sum/1000, 1); // Convert distance to km when the user use "meters"

	//Connect to DB and calculate the number of runs at all
	$number_of_runs = $wpdb->get_var($wpdb->prepare("
		SELECT COUNT($wpdb->postmeta.meta_value)
		FROM $wpdb->postmeta, $wpdb->posts 
		WHERE $wpdb->postmeta.meta_key='_rl_distance_value'
		AND $wpdb->posts.post_status = 'publish'	
		AND $wpdb->postmeta.post_id=$wpdb->posts.id",0,0));

	if ( $distance_sum ) // Calculate the avg per run at all
	{
		$avg_km_per_run = ROUND(($distance_sum/1000) / $number_of_runs, 2);
		$avg_miles_per_run = ROUND(($distance_sum) / $number_of_runs, 2);
	}

echo "<ul class='post-meta'>"; //Print it all

if ($show_distance == '1') // Distance
{
	if ($distancetype == 'meters') 
	{
		if ($distance > '0') //..let us print the distance in meters but only if distance is greather then 0...
		{
			echo "<li><span class='post-meta-key'>Meters:</span> $distance</li>";
		}
	} else {
		if ($distance > '0') //..else it must be miles and therefore print the distance in miles but only if distance is greather then 0...
		{
			echo "<li><span class='post-meta-key'>Miles:</span> $distance</li>";
		}
	}
}
if ($show_time == '1') // Time
{
	if ($hms) 
	{
		echo "<li><span class='post-meta-key'>Time:</span> $hms</li>";
	}
}
if ($show_speed == '1') // Distance per hours
{
	if ($distancetype == 'meters') //..let us get the speed in km/hours. (But only if km/hour is greather then 0...)
	{
		if ( $km_per_hour > '0') 
		{
			echo "<li><span class='post-meta-key'>Km/hour:</span> $km_per_hour</li>";
		}
	} else {
		if ( $miles_per_hour > '0') //..else it must be miles/hours. (But only if miles/hour is greather then 0...)
		{
			echo "<li><span class='post-meta-key'>Miles/hour:</span> $miles_per_hour</li>";
		}
	}
}
if ($show_speedperdistance == '1') // Min per distance
{
	if ($distancetype == 'meters') //..let us get the speed in min per km... (But only if minutes is greather then 0...)
	{
		if ($minutes > '0') 
		{
			echo "<li><span class='post-meta-key'>Min/km:</span> $minutes:$secondsleft minutes</li>";
		}
	} else {
		if ($minutes_miles > '0') //..else it must be min per miles. (But only if minutes_miles is greather then 0...)
		{
			echo "<li><span class='post-meta-key'>Min/miles:</span> $minutes_miles:$secondsleft_miles minutes</li>";
		}
	}
}
if ($show_pulse == '1') // Pulsavg
{
	if ($pulsavg) 
	{
		echo "<li><span class='post-meta-key'>Pulse average:</span> $pulsavg bpm"; 
		if ($procofmaxhr && $procofhrr) 
		{ 
			echo " is $procofmaxhr% of Max HR and $procofhrr% of HRR"; 
		} 
		echo "</li>";
	}
}
if ($show_calories == '1') // Calories
{	
	if ($calories) 
	{
		echo "<li><span class='post-meta-key'>Calories:</span> $calories C</li>";
	}
}
if ($show_cadence == '1') // Cadence
{	
	if ($cadence) 
	{
		echo "<li><span class='post-meta-key'>Cadence:</span> $cadence</li>";
	}
}
if ($show_garminconnect == '1') //Garmin Connect Link
{
	if ($url) 
	{
		echo "<li><span class='post-meta-key'>Garmin Link:</span> <a href='$url' target='_blank'>$url</a></li>";
	}
}
if ($show_distance2009 == '1') // Totals 2009
{
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2009 == '1')
		{
			echo "<li><span class='post-meta-key'>2009:</span> <strong>$km_sum_2009</strong> km based on <strong>$number_of_runs_2009</strong> run with an avg of <strong>$avg_km_per_run_2009</strong> km</li>";
		}
		if ($number_of_runs_2009 > '1') 
		{
			echo "<li><span class='post-meta-key'>2009:</span> <strong>$km_sum_2009</strong> km based on <strong>$number_of_runs_2009</strong> runs with an avg of <strong>$avg_km_per_run_2009</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2009 == '1') 
		{
			echo "<li><span class='post-meta-key'>2009:</span> <strong>$distance_sum_2009</strong> miles based on <strong>$number_of_runs_2009</strong> run with an avg of <strong>$avg_miles_per_run_2009</strong> mi</li>";
		} 
		if ($number_of_runs_2009 > '1') 
		{
			echo "<li><span class='post-meta-key'>2009:</span> <strong>$distance_sum_2009</strong> miles based on <strong>$number_of_runs_2009</strong> runs with an avg of <strong>$avg_miles_per_run_2009</strong> mi</li>";
		}
	}
}
if ($show_distance2010 == '1') // Totals 2010
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2010 == '1') 
		{
			echo "<li><span class='post-meta-key'>2010:</span> <strong>$km_sum_2010</strong> km based on <strong>$number_of_runs_2010</strong> run with an avg of <strong>$avg_km_per_run_2010</strong> km</li>";
		} 
		if ($number_of_runs_2010 > '1') 
		{
			echo "<li><span class='post-meta-key'>2010:</span> <strong>$km_sum_2010</strong> km based on <strong>$number_of_runs_2010</strong> runs with an avg of <strong>$avg_km_per_run_2010</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2010 == '1') 
		{
			echo "<li><span class='post-meta-key'>2010:</span> <strong>$distance_sum_2010</strong> miles based on <strong>$number_of_runs_2010</strong> run with an avg of <strong>$avg_miles_per_run_2010</strong> mi</li>";
		} 
		if ($number_of_runs_2010 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2010:</span> <strong>$distance_sum_2010</strong> miles based on <strong>$number_of_runs_2010</strong> runs with an avg of <strong>$avg_miles_per_run_2010</strong> mi</li>";
		}
	}
}
if ($show_distance2011 == '1') // Totals 2011
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2011 == '1') 
		{
			echo "<li><span class='post-meta-key'>2011:</span> <strong>$km_sum_2011</strong> km based on <strong>$number_of_runs_2011</strong> run with an avg of <strong>$avg_km_per_run_2011</strong> km</li>";
		} 
		if ($number_of_runs_2011 > '1') 
		{
			echo "<li><span class='post-meta-key'>2011:</span> <strong>$km_sum_2011</strong> km based on <strong>$number_of_runs_2011</strong> runs with an avg of <strong>$avg_km_per_run_2011</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2011 == '1') 
		{
			echo "<li><span class='post-meta-key'>2011:</span> <strong>$distance_sum_2011</strong> miles based on <strong>$number_of_runs_2011</strong> run with an avg of <strong>$avg_miles_per_run_2011</strong> mi</li>";
		} 
		if ($number_of_runs_2011 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2011:</span> <strong>$distance_sum_2011</strong> miles based on <strong>$number_of_runs_2011</strong> runs with an avg of <strong>$avg_miles_per_run_2011</strong> mi</li>";
		}
	}
}
if ($show_distance2012 == '1') // Totals 2012
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2012 == '1') 
		{
			echo "<li><span class='post-meta-key'>2012:</span> <strong>$km_sum_2012</strong> km based on <strong>$number_of_runs_2012</strong> run with an avg of <strong>$avg_km_per_run_2012</strong> km</li>";
		} 
		if ($number_of_runs_2012 > '1') 
		{
			echo "<li><span class='post-meta-key'>2012:</span> <strong>$km_sum_2012</strong> km based on <strong>$number_of_runs_2012</strong> runs with an avg of <strong>$avg_km_per_run_2012</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2012 == '1') 
		{
			echo "<li><span class='post-meta-key'>2012:</span> <strong>$distance_sum_2012</strong> miles based on <strong>$number_of_runs_2012</strong> run with an avg of <strong>$avg_miles_per_run_2012</strong> mi</li>";
		} 
		if ($number_of_runs_2012 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2012:</span> <strong>$distance_sum_2012</strong> miles based on <strong>$number_of_runs_2012</strong> runs with an avg of <strong>$avg_miles_per_run_2012</strong> mi</li>";
		}
	}
}
if ($show_distance2013 == '1') // Totals 2013
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2013 == '1') 
		{
			echo "<li><span class='post-meta-key'>2013:</span> <strong>$km_sum_2013</strong> km based on <strong>$number_of_runs_2013</strong> run with an avg of <strong>$avg_km_per_run_2013</strong> km</li>";
		} 
		if ($number_of_runs_2013 > '1') 
		{
			echo "<li><span class='post-meta-key'>2013:</span> <strong>$km_sum_2013</strong> km based on <strong>$number_of_runs_2013</strong> runs with an avg of <strong>$avg_km_per_run_2013</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2013 == '1') 
		{
			echo "<li><span class='post-meta-key'>2013:</span> <strong>$distance_sum_2013</strong> miles based on <strong>$number_of_runs_2013</strong> run with an avg of <strong>$avg_miles_per_run_2013</strong> mi</li>";
		} 
		if ($number_of_runs_2013 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2013:</span> <strong>$distance_sum_2013</strong> miles based on <strong>$number_of_runs_2013</strong> runs with an avg of <strong>$avg_miles_per_run_2013</strong> mi</li>";
		}
	}
}
if ($show_distance2014 == '1') // Totals 2014
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2014 == '1') 
		{
			echo "<li><span class='post-meta-key'>2014:</span> <strong>$km_sum_2014</strong> km based on <strong>$number_of_runs_2014</strong> run with an avg of <strong>$avg_km_per_run_2014</strong> km</li>";
		} 
		if ($number_of_runs_2014 > '1') 
		{
			echo "<li><span class='post-meta-key'>2014:</span> <strong>$km_sum_2014</strong> km based on <strong>$number_of_runs_2014</strong> runs with an avg of <strong>$avg_km_per_run_2014</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2014 == '1') 
		{
			echo "<li><span class='post-meta-key'>2014:</span> <strong>$distance_sum_2014</strong> miles based on <strong>$number_of_runs_2014</strong> run with an avg of <strong>$avg_miles_per_run_2014</strong> mi</li>";
		} 
		if ($number_of_runs_2014 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2014:</span> <strong>$distance_sum_2014</strong> miles based on <strong>$number_of_runs_2014</strong> runs with an avg of <strong>$avg_miles_per_run_2014</strong> mi</li>";
		}
	}
}
if ($show_distance2015 == '1') // Totals 2015
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2015 == '1') 
		{
			echo "<li><span class='post-meta-key'>2015:</span> <strong>$km_sum_2015</strong> km based on <strong>$number_of_runs_2015</strong> run with an avg of <strong>$avg_km_per_run_2015</strong> km</li>";
		} 
		if ($number_of_runs_2015 > '1') 
		{
			echo "<li><span class='post-meta-key'>2015:</span> <strong>$km_sum_2015</strong> km based on <strong>$number_of_runs_2015</strong> runs with an avg of <strong>$avg_km_per_run_2015</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2015 == '1') 
		{
			echo "<li><span class='post-meta-key'>2015:</span> <strong>$distance_sum_2015</strong> miles based on <strong>$number_of_runs_2015</strong> run with an avg of <strong>$avg_miles_per_run_2015</strong> mi</li>";
		} 
		if ($number_of_runs_2015 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2015:</span> <strong>$distance_sum_2015</strong> miles based on <strong>$number_of_runs_2015</strong> runs with an avg of <strong>$avg_miles_per_run_2015</strong> mi</li>";
		}
	}
}
if ($show_distance2016 == '1') // Totals 2016
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2016 == '1') 
		{
			echo "<li><span class='post-meta-key'>2016:</span> <strong>$km_sum_2016</strong> km based on <strong>$number_of_runs_2016</strong> run with an avg of <strong>$avg_km_per_run_2016</strong> km</li>";
		} 
		if ($number_of_runs_2016 > '1') 
		{
			echo "<li><span class='post-meta-key'>2016:</span> <strong>$km_sum_2016</strong> km based on <strong>$number_of_runs_2016</strong> runs with an avg of <strong>$avg_km_per_run_2016</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2016 == '1') 
		{
			echo "<li><span class='post-meta-key'>2016:</span> <strong>$distance_sum_2016</strong> miles based on <strong>$number_of_runs_2016</strong> run with an avg of <strong>$avg_miles_per_run_2016</strong> mi</li>";
		} 
		if ($number_of_runs_2016 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2016:</span> <strong>$distance_sum_2016</strong> miles based on <strong>$number_of_runs_2016</strong> runs with an avg of <strong>$avg_miles_per_run_2016</strong> mi</li>";
		}
	}
}
if ($show_distance2017 == '1') // Totals 2017
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2017 == '1') 
		{
			echo "<li><span class='post-meta-key'>2017:</span> <strong>$km_sum_2017</strong> km based on <strong>$number_of_runs_2017</strong> run with an avg of <strong>$avg_km_per_run_2017</strong> km</li>";
		} 
		if ($number_of_runs_2017 > '1') 
		{
			echo "<li><span class='post-meta-key'>2017:</span> <strong>$km_sum_2017</strong> km based on <strong>$number_of_runs_2017</strong> runs with an avg of <strong>$avg_km_per_run_2017</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2017 == '1') 
		{
			echo "<li><span class='post-meta-key'>2017:</span> <strong>$distance_sum_2017</strong> miles based on <strong>$number_of_runs_2017</strong> run with an avg of <strong>$avg_miles_per_run_2017</strong> mi</li>";
		} 
		if ($number_of_runs_2017 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2017:</span> <strong>$distance_sum_2017</strong> miles based on <strong>$number_of_runs_2017</strong> runs with an avg of <strong>$avg_miles_per_run_2017</strong> mi</li>";
		}
	}
}
if ($show_distance2018 == '1') // Totals 2018
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2018 == '1') 
		{
			echo "<li><span class='post-meta-key'>2018:</span> <strong>$km_sum_2018</strong> km based on <strong>$number_of_runs_2018</strong> run with an avg of <strong>$avg_km_per_run_2018</strong> km</li>";
		} 
		if ($number_of_runs_2018 > '1') 
		{
			echo "<li><span class='post-meta-key'>2018:</span> <strong>$km_sum_2018</strong> km based on <strong>$number_of_runs_2018</strong> runs with an avg of <strong>$avg_km_per_run_2018</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2018 == '1') 
		{
			echo "<li><span class='post-meta-key'>2018:</span> <strong>$distance_sum_2018</strong> miles based on <strong>$number_of_runs_2018</strong> run with an avg of <strong>$avg_miles_per_run_2018</strong> mi</li>";
		} 
		if ($number_of_runs_2018 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2018:</span> <strong>$distance_sum_2018</strong> miles based on <strong>$number_of_runs_2018</strong> runs with an avg of <strong>$avg_miles_per_run_2018</strong> mi</li>";
		}
	}
}
if ($show_distance2019 == '1') // Totals 2019
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs_2019 == '1') 
		{
			echo "<li><span class='post-meta-key'>2019:</span> <strong>$km_sum_2019</strong> km based on <strong>$number_of_runs_2019</strong> run with an avg of <strong>$avg_km_per_run_2019</strong> km</li>";
		} 
		if ($number_of_runs_2019 > '1') 
		{
			echo "<li><span class='post-meta-key'>2019:</span> <strong>$km_sum_2019</strong> km based on <strong>$number_of_runs_2019</strong> runs with an avg of <strong>$avg_km_per_run_2019</strong> km</li>";
		}
	} else {
		if ($number_of_runs_2019 == '1') 
		{
			echo "<li><span class='post-meta-key'>2019:</span> <strong>$distance_sum_2019</strong> miles based on <strong>$number_of_runs_2019</strong> run with an avg of <strong>$avg_miles_per_run_2019</strong> mi</li>";
		} 
		if ($number_of_runs_2019 > '1') 
		{		
			echo "<li><span class='post-meta-key'>2019:</span> <strong>$distance_sum_2019</strong> miles based on <strong>$number_of_runs_2019</strong> runs with an avg of <strong>$avg_miles_per_run_2019</strong> mi</li>";
		}
	}
}
if ($show_distance_sum == '1') // Total at all
{	
	if ($distancetype == 'meters') 
	{
		if ($number_of_runs == '1') 
		{
			echo "<li><span class='post-meta-key'>At all:</span> <strong>$km_sum</strong> km based on <strong>$number_of_runs</strong> run with an avg of <strong>$avg_km_per_run</strong> km</li>";
		} 
		if ($number_of_runs > '1') 
		{
			echo "<li><span class='post-meta-key'>At all:</span> <strong>$km_sum</strong> km based on <strong>$number_of_runs</strong> runs with an avg of <strong>$avg_km_per_run</strong> km</li>";
		}
	} else {
		if ($number_of_runs == '1') 
		{
			echo "<li><span class='post-meta-key'>At all:</span> <strong>$distance_sum</strong> miles based on <strong>$number_of_runs</strong> run with an avg of <strong>$avg_miles_per_run</strong> mi</li>";
		} 
		if ($number_of_runs > '1') 
		{		
			echo "<li><span class='post-meta-key'>At all:</span> <strong>$distance_sum</strong> miles based on <strong>$number_of_runs</strong> runs with an avg of <strong>$avg_miles_per_run</strong> mi</li>";
		}
	}
}
if ($show_garminmap == '1') // Insert embed Garmin Connnect Map based on the used Garmin Connect Link
{
	if ($url) 
	{
		$mapurl = substr($url, strrpos($url, '/') + 1);
		echo "<iframe width='465' height='548' frameborder='0' src='http://connect.garmin.com:80/activity/embed/".$mapurl."'></iframe>";
	}
}
echo "</ul>"; // End function runners_log_basic()
}
add_shortcode('runners_log_basic', 'runners_log_basic');

//[runners_log_garminmap]
function runners_log_garminmap() {
	
	// Make $wpdb and $post global
	global $wpdb, $post;

	// Get the Garmin Connect Link
	$url = get_post_meta($post->ID, "_rl_garminconnectlink_value", $single = true);

	// Insert embed Garmin Connnect Map based on the used Garmin Connect Link
	if ($url) {
		$mapurl = substr($url, strrpos($url, '/') + 1);
		echo "<iframe width='465' height='548' frameborder='0' src='http://connect.garmin.com:80/activity/embed/".$mapurl."'></iframe>";
	}
}
add_shortcode('runners_log_garminmap', 'runners_log_garminmap');

// Let us convert the total running time into seconds
function hms2sec ($hms)	{
		list($h, $m, $s) = explode (":", $hms);
		$seconds = 0;
		$seconds += (intval($h) * 3600);
		$seconds += (intval($m) * 60);
		$seconds += (intval($s));
		return $seconds;
}

/*  Some admin stuff  */
// Post Write Panel (Meta box)
include('runnerslog_metabox.php');

// Admin Options - Start adding the admin menu
function runnerslog_admin() {  
	include('runnerslog_admin.php');
}

function runnerslog_training_zones() {  
	include('Includes/runnerslog_training_zones.php');
}

function runnerslog_v02max() {  
	include('Includes/runnerslog_v02max.php');
} 

function runnerslog_vdot_race_time() {  
	include('Includes/runnerslog_vdot_race_time.php');
}

function runnerslog_vdot_training_pace() {  
	include('Includes/runnerslog_vdot_training_pace.php');
} 

function runnerslog_body_mass_index() {  
	include('Includes/runnerslog_body_mass_index.php');
} 

function runnerslog_weight_change_effect() {  
	include('Includes/runnerslog_weight_change_effect.php');
}

function runnerslog_converter_toolbox() {  
	include('Includes/runnerslog_converter_toolbox.php');
}

function runnerslog_admin_menu() {
	// Add a new top-level menu: Runners Log with Submenus
	add_menu_page('Runners Log', 'Runners Log', 'administrator', 'runners-log', 'runnerslog_admin', 'dashicons-chart-bar');
	add_submenu_page('runners-log', 'HR Training Zones', 'HR Training Zones', 'administrator', 'runners-log-training-zones', 'runnerslog_training_zones');
	add_submenu_page('runners-log', 'V0<sub>2</sub>max Calculator', 'V0<sub>2</sub>max Calculator', 'administrator', 'runners-log-v02max', 'runnerslog_v02max');
	add_submenu_page('runners-log', 'Race Time Calc.', 'Race Time Calc.', 'administrator', 'runners-log-vdot-race-time', 'runnerslog_vdot_race_time');
	add_submenu_page('runners-log', 'Training Pace Calc.', 'Training Pace Calc.', 'administrator', 'runners-log-vdot-training-pace', 'runnerslog_vdot_training_pace');
	add_submenu_page('runners-log', 'Body Mass Index', 'Body Mass Index', 'administrator', 'runners-log-body-mass-index', 'runnerslog_body_mass_index');	
	add_submenu_page('runners-log', 'Weight Change Effect', 'Weight Change Effect', 'administrator', 'runners-log-weight-change-effect', 'runnerslog_weight_change_effect');	
	add_submenu_page('runners-log', 'Coverter Toolbox', 'Coverter Toolbox', 'administrator', 'runners-log-converter-toolbox', 'runnerslog_converter_toolbox');	
}
// Hook for adding admin menus
add_action('admin_menu', 'runnerslog_admin_menu');

// Set a few default options on plugin activation
register_activation_hook( __FILE__, 'runnerslog_activate' );

function runnerslog_activate() 
{
	update_option('runnerslog_distancetype', 'meters');
	update_option('runnerslog_gender', 'male');
	update_option('runnerslog_pulsavg', '1');
	update_option('runnerslog_caloriescount', '1');
	update_option('runnerslog_cadence', '1');
	update_option('runnerslog_garminconnectlink', '1');
	update_option('runnerslog_show_distance', '1');
	//Settings for [runners_log_basic]
	update_option('runnerslog_show_time', '1');
	update_option('runnerslog_show_speed', '1');
	update_option('runnerslog_show_speedperdistance', '1');
	update_option('runnerslog_show_pulse', '1');
	update_option('runnerslog_show_calories', '1');
	update_option('runnerslog_show_cadence', '1');
	update_option('runnerslog_show_garminconnect', '1');
	update_option('runnerslog_show_distance2009', '1');
	update_option('runnerslog_show_distance2010', '1');
	update_option('runnerslog_show_distance2011', '1');
	update_option('runnerslog_show_distance2012', '1');
	update_option('runnerslog_show_distance2013', '1');
	update_option('runnerslog_show_distance2014', '1');
	update_option('runnerslog_show_distance2015', '1');
	update_option('runnerslog_show_distance2016', '1');
	update_option('runnerslog_show_distance2017', '1');
	update_option('runnerslog_show_distance2018', '1');
	update_option('runnerslog_show_distance2019', '0'); //disabled as we are in 2018
	update_option('runnerslog_show_distance_sum', '1');
	update_option('runnerslog_show_garminmap', '1');
}
	
//Create the gear-list menu-box
add_action('admin_menu', 'wp_gear_manager_create_menu');

	function wp_gear_manager_create_menu() {
		$show_gearmanager = get_option('runnerslog_show_gearmanager');

		if($show_gearmanager == '1'){
			add_menu_page( 'Gear Manager', 'Gear Manager', 1, 'runners-log-gear', 'wp_gear_manager_page_dispatcher', IMG_DIRECTORY.'ico16.png');
			add_submenu_page( 'runners-log-gear', 'New Gear', 'Add new gear', 1, 'runners-log-gear&amp;gear=new', 'wp_gear_manager_page_dispatcher' );
		}
	}
?>
