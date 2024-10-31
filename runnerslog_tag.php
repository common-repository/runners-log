<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////
// Eg: [runners_log_gear id="2"] 																	//
// Id: You find the id in the gear manager list													    //
//////////////////////////////////////////////////////////////////////////////////////////////////////
function runners_log_gear_func($atts) {
	extract(shortcode_atts(array(
		'id' => '',
	), $atts));

	global $wpdb, $distancetype;
	
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
	FROM $table WHERE gear_id = $id;";
	$res = $wpdb->get_row($query);
	
	// is there something to do?
	if (sizeof($res) == '0')
	{
		echo "No data available. Did you specify an id like [runners_log_gear id=\"2\"]<br/>\n";
		return;
	}
		
	/*
	$day 		 = $res->day;	
	echo $day;
	*/
	
	print_r($res);
} //Here we end the function "runners_log_gear_func"
add_shortcode('runners_log_gear', 'runners_log_gear_func');

/* 
// Database snippet for local validation
SELECT wp_gear.gear_id AS Id, wp_gear.gear_brand as Brand, wp_gear.gear_name as Name, wp_gear.gear_desc as Description, wp_gear.gear_price as Price, wp_gear.gear_distance as Distance, wp_gear.gear_isDone as Active
FROM wp_gear
WHERE wp_gear.gear_isDone = '0'
ORDER BY wp_gear.gear_id ASC
*/
?>
