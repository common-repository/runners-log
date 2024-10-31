<?php

$distancetype = ucfirst(get_option('runnerslog_distancetype'));
$pulsavg = get_option('runnerslog_pulsavg');
$garminconnect = get_option('runnerslog_garminconnectlink');
$calories = get_option('runnerslog_caloriescount');
$cadence = get_option('runnerslog_cadence');
$show_gearmanager = get_option('runnerslog_show_gearmanager');

global $wpdb;
 
$table = $wpdb->prefix."gear";
     
$query = "SELECT
	gear_id AS `Id`,
	gear_brand as `Brand`,
	gear_name as `Name`,
	gear_desc as `Description`,
	gear_price as `Price`,
	gear_distance as `Distance`,
	gear_isDone as `Active`,
	DAY(gear_dateTo) as `day`,
	MONTH(gear_dateTo) as `month`,
	YEAR(gear_dateTo) as `year`
	FROM $table
	WHERE gear_isDone = '0';";
	
	//print_r($res); // Print the whole Array
	
	//echo $res[0]->Id;  // Gives you the id for Array 0
/*
	foreach($res as $gear) { // Gives you a list of all the Ids
		echo $gear->Id; 
	};
*/

	
$res = $wpdb->get_results($query);
        
$post_custom_fields =
array(
	"_rl_time" => array(
		"name" => "_rl_time",
		"std" => "",
		"title" => "Time:",
		"description" => "hh:mm:ss eg 01:37:27",
		"show" => "1"
	),
	"_rl_distance" => array(
		"name" => "_rl_distance",
		"std" => "",
		"title" => "$distancetype:",
		"description" => "Choose Meters or Miles in the Settings",
		"show" => "1"
	),
	"_rl_pulsavg" => array(
		"name" => "_rl_pulsavg",
		"std" => "",
		"title" => "Pulse Average:",
		"description" => "The avg. pulse for your course",
		"show" => "$pulsavg"
	),
	"_rl_calories" => array(
		"name" => "_rl_calories",
		"std" => "",
		"title" => "Calories:",
		"description" => "Type in your calories",
		"show" => "$calories"
	),
	"_rl_cadence" => array(
		"name" => "_rl_cadence",
		"std" => "",
		"title" => "Cadence:",
		"description" => "Type in your cadence",
		"show" => "$cadence"
	),
	"_rl_garminconnectlink" => array(
		"name" => "_rl_garminconnectlink",
		"std" => "",
		"title" => "Garmin Link:",
		"description" => "http://connect.garmin.com/activity/3789",
		"show" => "$garminconnect"
	)
);

//runs trough the gear table and adds an option for each one
$runner_log_gears = array();
foreach ($res as $result) {
	$runner_log_gears[]=array(
		"name" => $result->Id,
		"std" => "",
		"title" => $result->Brand." ".$result->Name,
		"description" => $result->Desc,
		"show" => "1"
	);
}

function post_custom_fields() {
	global $post, $post_custom_fields, $runner_log_gears, $show_gearmanager;
	echo '<ul>';
	foreach($post_custom_fields as $meta_box) {
		$meta_box_value = stripslashes(get_post_meta($post->ID, $meta_box['name'].'_value', true));

		if($meta_box_value == "")
			$meta_box_value = $meta_box['std'];
			
			if($meta_box['show'] == '1') {
				echo '<li style="float: left; width: 49%; height: 40px;">';
				echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
				echo'<div class="label" style="width: 35%; text-align: right; font-weight: bold; float: left; padding:4px 10px 0 0;">'.$meta_box['title'].'</div>';
				echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.attribute_escape($meta_box_value).'" style="width:60%;" /><br />';
				if($meta_box['description'] != "") {
					echo '<div class="description" style="padding-left: 38%; font-style: italic;"><small>' . $meta_box['description'] . '</small></div>';
				}
				echo '</li>';
			}
	}
	foreach($runner_log_gears as $meta_box) {
		$meta_box_value = stripslashes(get_post_meta($post->ID, $meta_box['name'].'_value', true));

		if($meta_box_value == "")
			$meta_box_value = $meta_box['std'];
			
			if($show_gearmanager == '1') {
				echo '<li style="float: left; width: 32%; height: 20px;">';
				echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
				echo'<div class="label" style="font-weight: bold; float: left; padding:4px 10px 0 0;">'.$meta_box['title'].'</div>';
				echo'<input type="checkbox" name="'.$meta_box['name'].'_value" value="'.attribute_escape($meta_box_value).'" style="" align="TOP" /><br />';
				if($meta_box['description'] != "") {
					echo '<div class="description" style="padding-left: 38%; font-style: italic;"><small>' . $meta_box['description'] . '</small></div>';
				}
				echo '</li>';
			}
	}
	echo '</ul>';
	echo '<br style="clear: both;">';
}

function create_meta_box() {
	global $theme_name;
		if ( function_exists('add_meta_box') ) {
			add_meta_box( 'new-meta-boxes', 'Runners Log', 'post_custom_fields', 'post', 'normal', 'high' );
	}
}

function save_postdata( $post_id ) {
	global $post, $post_custom_fields, $runner_log_gears; 

	foreach($post_custom_fields as $meta_box) {
		// Verify
		if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
			return $post_id;
	}

	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ))
			return $post_id;
		} else {
		if ( !current_user_can( 'edit_post', $post_id ))
			return $post_id;
	}

	$data = $_POST[$meta_box['name'].'_value'];

	if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
		add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
	elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
		update_post_meta($post_id, $meta_box['name'].'_value', $data);
	elseif($data == "")
		delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
	}
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata'); 
?>
