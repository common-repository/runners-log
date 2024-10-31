<?php
/*
[runners_log_gchart type="pie" format="d" year="2010" month="May" color="224499" width="600" height="300"]

Type: bar, graph, pie, 3dpie
Format: d="distance", ds="distance sum", ts="time sum",  cs="calories sum", p="pulse average"
Year: 2009, 2010, 2011, 2012, 2013
Month: Jan, Feb, Marts, April, May, June, July, Aug, Sep, Oct, Nov, Dec
Color: Is the color scheme used eg: "224499" for the html color #224499
Width: The width of the chart: Default: 475 pixel
Height: The height of the chart: Default: 250 pixel	
*/

function runners_log_gchart_get_percents($values) {
    $sum = array_sum($values);
    foreach ($values as $key => $value) {
        $values[$key] = round(($value / $sum) * 100, 0);
    }
    return $values;
}

function runners_log_gchart_func($atts) {
/* W I K I  --  T H E  G U I D E  T O  A L L  T H E  V A R I A B L E S

		**********************************************************************************
		**			RELATED TO THE [runners_log_gchart] TAG			**
		**********************************************************************************
		
$type	//store the type selected in [runners_log_gchart] it can be eather: bar, graph, pie, 3dpie. Default is: bar
$format	//store the kind of data that would be show; d for distance, c for calories, p for pulse average
$year	//store the year from witch data would like to be calculated. Default: 2010
$month 	//store the month specified in the [runners_log_gchart] tag. Default: 0 //The same as all month == a given year
$olor	//store the color scheme html-code used for the google-api to generate the graphs. Default depends of the type of graph
$width	//The width of the chart: Default: 475 pixel
$height	//The height of the chart: Default: 250 pixel

		**********************************************************************************
		**				RELATED TO THE DATABASE HANDLING		**
		**********************************************************************************

$month2value //Convert the month to a given equivalent value like "jan-->1", "feb-->2" etc. Default is 0 == all months, the same as a whole year
$month2str //Convert the month, if it is a value, back to its real name
$dbdata	//stores the database result as an array
$xaxislable	//The x-labels printed from the database

		**********************************************************************************
		**				RELATED TO THE GOOGLE API			**
		**********************************************************************************
$data['chf']	Gradient Fills http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_gradient_fills
$data['chxl']	Custom Axis Labels http://code.google.com/intl/da/apis/chart/docs/chart_params.html#axis_labels
$data['chxr']	Axis Range http://code.google.com/intl/da/apis/chart/docs/chart_params.html#axis_range
$data['chxp']	Axis Label Positions http://code.google.com/intl/da/apis/chart/docs/chart_params.html#axis_label_positions
$data['chxs']	Axis Label Styles http://code.google.com/intl/da/apis/chart/docs/chart_params.html#axis_label_styles
$data['chxtc'] 	Axis Tick Mark Styles http://code.google.com/intl/da/apis/chart/docs/chart_params.html#axis_tick_marks
$data['chxt']	Visible Axes http://code.google.com/intl/da/apis/chart/docs/chart_params.html#axis_type
$data['chbh']	Bar Width and Spacing http://code.google.com/intl/da/apis/chart/docs/gallery/bar_charts.html#chbh
$data['chs']	Chart Size http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_chs
$data['cht']	Chart Type http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_cht
$data['chco']	Series Colors http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_series_color
$data['chds']	Text Format with Custom Scaling http://code.google.com/intl/da/apis/chart/docs/data_formats.html#data_scaling
$data['chd']	Chart Data String http://code.google.com/intl/da/apis/chart/docs/data_formats.html
$data['chdl']	Chart Legend Text and Style http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_legend
$data['chl']	Chart Legend Text, when it is a pie
$data['chdlp'] 	Where the legand is placed. Top, right, left etc
$data['chg']	Grid Lines http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_grid_lines
$data['chls']	Line Styles http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_line_styles
$data['chm']	Shape Markers http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_shape_markers
$data['chtt']	Chart Title http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_chart_title

		**********************************************************************************
		**				SETTINGS VARIABLE				**
		**********************************************************************************
$distancetype	Could be either meters or miles

		**********************************************************************************
		**				LINKS						**
		**********************************************************************************

Code Playground
http://code.google.com/apis/ajax/playground/?type=visualization#toolbar

Dynamic Examples
http://code.google.com/intl/da/apis/visualization/documentation/examples.html

Chart Editor
http://imagecharteditor.appspot.com/
*/

	extract(shortcode_atts(array(
		'type' => 'bar',
		'format' => 'd',
		'year' => '2012',
		'month' => '',
		'width' => '470',
		'height' => '240',
		'color' => '623000|C92200|F78F01|5AB56E|B64245|D98962|F6CB6B|6F8069|E3E3D8|72B0B4|007C8F|14435D|270A2B',
	), $atts));

	global $wpdb, $distancetype;	

  /* T O O L  B O X */
	//Let us convert the month from [runners_log_gchart month="feBruarY"] to the value 2 etc
	$month = strtolower(substr($month, 0, 3));	//First rip the month value to 3 chars and then set all the chars to lower letters. 
	$month2value = Array (	//Convert the month to a given equivalent value
		'' => 0,  //adds the value 0 if no month is specified in [runners_log_gchart]
		'jan' => 1,
		'feb' => 2,
		'mar' => 3,
		'apr' => 4,
		'may' => 5,
		'jun' => 6,
		'jul' => 7,
		'aug' => 8,
		'sep' => 9,
		'oct' => 10,
		'nov' => 11,
		'dec' => 12
	);
	$month = $month2value[$month]; 	//Covert the 3 charts to a equivalent value using the array "month2value"
	
	//Let us convert the value to a the month name used in the X-axis in google chart API
	//Convert the Value 1 -> Jan, etc
	$month2str = Array (
		0 => '', //if no months is specified you get data for the whole year
		1 => 'January',
		2 => 'February',
		3 => 'Marts',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December'
	);
	
  /* T H E   F O R M A T  S W I T C H */
	switch ($format){
	
		case "d" : //Distances per day period - month or year
			if ($month == '0') {
				$dbdata = $wpdb->get_results("
					SELECT $wpdb->posts.post_date AS Fulldate, 
							DAY( $wpdb->posts.post_date ) AS Day , 
							MONTH( $wpdb->posts.post_date ) AS Month , 
							$wpdb->postmeta.meta_value AS Distance
					FROM $wpdb->postmeta, $wpdb->posts
					WHERE $wpdb->postmeta.meta_key = '_rl_distance_value'
					AND $wpdb->posts.post_status = 'publish'
					AND $wpdb->postmeta.post_id = $wpdb->posts.id
					AND year($wpdb->posts.post_date)= '$year'
					ORDER BY `$wpdb->posts`.`post_date` ASC");
			} else {
				$dbdata = $wpdb->get_results("
					SELECT $wpdb->posts.post_date AS Fulldate, 
							DAY( $wpdb->posts.post_date ) AS Day , 
							MONTH( $wpdb->posts.post_date ) AS Month ,				
							$wpdb->postmeta.meta_value AS Distance
					FROM $wpdb->postmeta, $wpdb->posts
					WHERE $wpdb->postmeta.meta_key = '_rl_distance_value'
					AND $wpdb->posts.post_status = 'publish'
					AND $wpdb->postmeta.post_id = $wpdb->posts.id
					AND year($wpdb->posts.post_date)= '$year'
					AND month($wpdb->posts.post_date)= '$month'
					ORDER BY `$wpdb->posts`.`post_date` ASC");
			}	
			if (sizeof($dbdata) == '0') // is there something to do?
			{
				echo "No data available.<br/>\n";
				return;
			}
			foreach ($dbdata as $row) {
				if ($distancetype == 'meters') {
					$monthsList[] = (($row->Distance)/1000);
					$maxvalue = max($monthsList); //We need the max-value to have the righ Y-axis
					$xaxislable[] = sprintf(__('%1$d %2$s'), $row->Day, substr( $month2str[$row->Month], 0, 3 ) );
					$sumvalue = array_sum($monthsList);
                    $valuepercents = runners_log_gchart_get_percents($monthsList);
				} else { //else it is miles
					$monthsList[] = $row->Distance;
					$maxvalue = max($monthsList); //We need the max-value to have the righ Y-axis
					$xaxislable[] = sprintf(__('%1$d %2$s'), $row->Day, substr( $month2str[$row->Month], 0, 3 ) );
					$sumvalue = array_sum($monthsList);
                    $valuepercents = runners_log_gchart_get_percents($monthsList);
                    }
			}
			//Google Chart API Varibles
			if ($distancetype == 'meters') {
				$data['chdl'] = 'Km';
			} else {
				$data['chdl'] = 'Miles';
			}
			if ($month == '0') {
				$data['chtt'] = 'Distances  in ' .$year. '';
			} else { 
				$data['chtt'] = 'Distances per day in '. $month2str[$row->Month] .' ' .$year. '';
			}
		break;
		
		case "ds" : //Distance Sum preveous year. This part doesnt support year. It is always the previous year from today.
			$dbdata = $wpdb->get_results("
				SELECT DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' ) AS Runyearmonth,
					MONTH( $wpdb->posts.post_date ) AS Runmonth,
					DATE_FORMAT( $wpdb->posts.post_date, '%y' ) AS Runyear,
					(SUM( $wpdb->postmeta.meta_value )/1000) AS Runkm,
					SUM( $wpdb->postmeta.meta_value ) AS Runmiles
				FROM $wpdb->postmeta
				INNER JOIN $wpdb->posts ON ( $wpdb->postmeta.post_id = $wpdb->posts.id )
				WHERE $wpdb->postmeta.meta_key = '_rl_distance_value'
				AND $wpdb->posts.post_status = 'publish'
				AND $wpdb->posts.post_date >= DATE_ADD( NOW(), INTERVAL -1 YEAR)
				GROUP BY DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' )
			");
			if (sizeof($dbdata) == '0') { // is there something to do?
				echo "No data available.<br/>\n";
				return;
			}
			foreach ($dbdata as $row) {
				if ($distancetype == 'meters') {
					$monthsList[] = $row->Runkm;
					$maxvalue = max($monthsList); //We need the max-value to have the righ Y-axis
					$xaxislable[] = sprintf(__('%1$s'), substr( $month2str[$row->Runmonth], 0, 3 ) );
					$sumvalue = array_sum($monthsList);
                    $valuepercents = runners_log_gchart_get_percents($monthsList);
                } else { //else it is miles
					$monthsList[] = $row->Runmiles;
					$maxvalue = max($monthsList); //We need the max-value to have the righ Y-axis
					$xaxislable[] = sprintf(__('%1$s'), substr( $month2str[$row->Runmonth], 0, 3 ) );
					$sumvalue = array_sum($monthsList);
                    $valuepercents = runners_log_gchart_get_percents($monthsList);
                }
			}
			//Google Chart API Varibles
			if ($distancetype == 'meters') {
				$data['chdl'] = 'Km';
			} else {
				$data['chdl'] = 'Miles';
			}
			$data['chtt'] = 'Distances per Month the Previous Year';
		break;

		case "ts" :	//Time Sum per Month
			$dbdata = $wpdb->get_results("
				SELECT DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' ) AS Runyearmonth, 
					MONTH( $wpdb->posts.post_date ) AS Runmonth,
					DATE_FORMAT( $wpdb->posts.post_date, '%y' ) AS Runyear,
					ROUND((SUM( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) ) )/3600), 2) AS Runhours,
					sec_to_time( SUM( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) ) ) ) AS Runtime
				FROM $wpdb->postmeta
				INNER JOIN $wpdb->posts ON ( $wpdb->postmeta.post_id = $wpdb->posts.id )
				WHERE $wpdb->postmeta.meta_key = '_rl_time_value'
				AND $wpdb->posts.post_status = 'publish'
				AND $wpdb->postmeta.post_id = $wpdb->posts.id
				AND $wpdb->posts.post_date >= DATE_ADD( NOW(), INTERVAL -1 YEAR)
				GROUP BY DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' )	
			");
			if (sizeof($dbdata) == '0') { // is there something to do?
				echo "No data available.<br/>\n";
				return;
			}
			foreach ($dbdata as $row) {
				$monthsList[] = $row->Runhours;
				$maxvalue = max($monthsList); //We need the max-value to have the righ Y-axis
				$xaxislable[] = sprintf(__('%1$s'), substr( $month2str[$row->Runmonth], 0, 3 ) );
				$sumvalue = array_sum($monthsList);
                $valuepercents = runners_log_gchart_get_percents($monthsList);
            }
			//Google Chart API Varibles
			$data['chdl'] = 'Hours';
			$data['chtt'] = 'Time per Month the Previous Year';
		break;
		
		case "cs" : //Calories Sum per Month
			$dbdata = $wpdb->get_results("
				SELECT DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' ) AS Runyearmonth, 
					MONTH( $wpdb->posts.post_date ) AS Runmonth,
					DATE_FORMAT( $wpdb->posts.post_date, '%y' ) AS Runyear,
					SUM( $wpdb->postmeta.meta_value ) AS Runcalories
				FROM $wpdb->postmeta
				INNER JOIN $wpdb->posts ON ( $wpdb->postmeta.post_id = $wpdb->posts.id )
				WHERE $wpdb->postmeta.meta_key = '_rl_calories_value'
				AND $wpdb->posts.post_status = 'publish'
				AND $wpdb->postmeta.post_id = $wpdb->posts.id
				AND $wpdb->posts.post_date >= DATE_ADD( NOW(), INTERVAL -1 YEAR)
				GROUP BY DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' )	
			");
			if (sizeof($dbdata) == '0') { // is there something to do?
				echo "No data available.<br/>\n";
				return;
			}
			foreach ($dbdata as $row) {
				$monthsList[] = $row->Runcalories;
				$maxvalue = max($monthsList); //We need the max-value to have the righ Y-axis
				$xaxislable[] = sprintf(__('%1$s'), substr( $month2str[$row->Runmonth], 0, 3 ) );
				$sumvalue = array_sum($monthsList);
                $valuepercents = runners_log_gchart_get_percents($monthsList);
            }
			//Google Chart API Varibles
			$data['chdl'] = 'Cal.';
			$data['chtt'] = 'Calories per Month the Previous Year';
		break;
		
		case "p" :  //Pulse avg
			if ($month == '0') {
				$dbdata = $wpdb->get_results("
					SELECT $wpdb->posts.post_date AS Fulldate, 
							DAY( $wpdb->posts.post_date ) AS Day , 
							MONTH( $wpdb->posts.post_date ) AS Month , 
							$wpdb->postmeta.meta_value AS Pulse
					FROM $wpdb->postmeta, $wpdb->posts
					WHERE $wpdb->postmeta.meta_key = '_rl_pulsavg_value'
					AND $wpdb->posts.post_status = 'publish'
					AND $wpdb->postmeta.post_id = $wpdb->posts.id
					AND year($wpdb->posts.post_date)= '$year'
					ORDER BY `$wpdb->posts`.`post_date` ASC
					");
			} else {
				$dbdata = $wpdb->get_results("
					SELECT $wpdb->posts.post_date AS Fulldate, 
							DAY( $wpdb->posts.post_date ) AS Day , 
							MONTH( $wpdb->posts.post_date ) AS Month ,				
							$wpdb->postmeta.meta_value AS Pulse
					FROM $wpdb->postmeta, $wpdb->posts
					WHERE $wpdb->postmeta.meta_key = '_rl_pulsavg_value'
					AND $wpdb->posts.post_status = 'publish'
					AND $wpdb->postmeta.post_id = $wpdb->posts.id
					AND year($wpdb->posts.post_date)= '$year'
					AND month($wpdb->posts.post_date)= '$month'
					ORDER BY `$wpdb->posts`.`post_date` ASC
					");
			}	
			if (sizeof($dbdata) == '0') // is there something to do?
			{
				echo "No data available.<br/>\n";
				return;
			}
			foreach ($dbdata as $row) {
				if ($distancetype == 'meters') {
					$monthsList[] = (($row->Pulse)/1000);
					$maxvalue = max($monthsList); //We need the max-value to have the righ Y-axis
					$minvalue = min($monthsList); //We need the min-value to have the righ x-axis
					$sumvalue = array_sum($monthsList);
                    $valuepercents = runners_log_gchart_get_percents($monthsList);
                    $xaxislable[] = sprintf(__('%1$d %2$s'), $row->Day, substr( $month2str[$row->Month], 0, 3 ) );
				} else { //else it is miles
					$monthsList[] = $row->Pulse;
					$maxvalue = max($monthsList); //We need the max-value to have the righ Y-axis
					$minvalue = min($monthsList); //We need the min-value to have the righ x-axis
					$sumvalue = array_sum($monthsList);
                    $valuepercents = runners_log_gchart_get_percents($monthsList);
					$xaxislable[] = sprintf(__('%1$d %2$s'), $row->Day, substr( $month2str[$row->Month], 0, 3 ) );
				}
			}
			//Google Chart API Varibles
			$data['chdl'] = 'Bpm';
			if ($month == '0') {
				$data['chtt'] = 'Pulse Average  in ' .$year. '';
			} else { 
				$data['chtt'] = 'Pulse Average per day in '. $month2str[$row->Month] .' ' .$year. '';
			}
		break;
		
		default :
		break;
   }
	
  /* T H E   T Y P E  S W I T C H */	
	//Do what ever wanted based on the type - the type could be set to: bar, graph, pie */
	switch ($type){
		//Google Chart API can be found here: http://code.google.com/apis/chart/docs/making_charts.html
		//Chart Parameters: http://code.google.com/intl/da/apis/chart/docs/chart_params.html#gcharts_cht
		//Image Chart Editor: http://imagecharteditor.appspot.com/
		case "bar" :
			$data['chf'] = 'a,s,000000CD|bg,lg,0,EFEFEF,0,BBBBBB,1|c,lg,0,EFEFEF,0,BBBBBB,1';
			$data['chxl'] = '1:|'. join( '|', $xaxislable ) .'';
			$data['chxr'] = '0,0,'. ($maxvalue + 1) .'';
			$data['chxp'] = '';
			$data['chxs'] = '';
			$data['chxtc'] = '';
			$data['chxt'] = 'y,x';
			$data['chbh'] = 'a,2,0';
			$data['chs'] = '' . esc_attr( $width ) . 'x' . esc_attr( $height ) .'';
			$data['cht'] = 'bvs';	//http://code.google.com/intl/da/apis/chart/docs/gallery/bar_charts.html#bar_types eg. "bvg"
			$data['chco'] = $color;
			$data['chds'] = '0,'. ($maxvalue + 1) .'';
			$data['chd'] = 't:'.implode(',',  $monthsList);
			$data['chdlp'] = 't';
			$data['chg'] = '14.3,-1,1,1';
			$data['chls'] = '2,4,0';
            $data['chm'] = 'N,000000,0,-1,11';
		break;

		case "graph" :
			$data['chf'] = 'a,s,000000CD|bg,lg,0,EFEFEF,0,BBBBBB,1|c,lg,0,EFEFEF,0,BBBBBB,1';
			$data['chxl'] = '1:|'. join( '|', $xaxislable ) .'';
			$data['chxp'] = '';
			$data['chxr'] =	'0,'. ($minvalue -1) .','. ($maxvalue + 1) .'';
			$data['chxs'] = '';
			$data['chxtc'] = '';
			$data['chxt'] = 'y,x';
			$data['chbh'] = '';
			$data['chs'] = '' . esc_attr( $width ) . 'x' . esc_attr( $height ) .'';
			$data['cht'] = 'lc';	//http://code.google.com/intl/da/apis/chart/docs/gallery/line_charts.html
			$data['chco'] = $color;
			$data['chds'] = ($minvalue -5) .','. ($maxvalue + 1) .'';
			$data['chd'] = 't:'.implode(',',  $monthsList);
			$data['chdlp'] = 't';
			$data['chg'] = '14.3,-1,1,1';
			$data['chls'] = '2,4,0';
			$data['chm'] = 'B,C5D4B5BB,0,0,0';
		break;
		
		case "pie" :
			$data['chf'] = 'a,s,000000CD|bg,lg,0,EFEFEF,0,BBBBBB,1';
			$data['chxl'] = '';
			$data['chxp'] = '';
			$data['chxr'] =	'';
			$data['chxs'] = '';
			$data['chxtc'] = '';
			$data['chxt'] = '';
			$data['chbh'] = '';
			$data['chs'] = '' . esc_attr( $width ) . 'x' . esc_attr( $height ) .'';
			$data['cht'] = 'p';	//http://code.google.com/intl/da/apis/chart/docs/gallery/pie_charts.html#chart_types
			$data['chco'] = $color;
			$data['chds'] = '0,'. ($maxvalue + 1) .'';
			$data['chd'] = 't:'.implode(',',  $monthsList);
			foreach ($valuepercents as $key=>$val) $valuepercents[$key] = sprintf("%d%%", $val); //We need to have a percent (%=%25) char after each value
			$data['chl'] = implode("|", $valuepercents); //We need to list the values like 
			$data['chdl'] = join( '|', $xaxislable ); //Date like: 31 dec
			$data['chg'] = '';
			$data['chls'] = '';
			$data['chm'] = '';
		break;
		
		case "3dpie" :
			$data['chf'] = 'a,s,000000CD|bg,lg,0,EFEFEF,0,BBBBBB,1';
			$data['chxl'] = '';
			$data['chxp'] = '';
			$data['chxr'] =	'';
			$data['chxs'] = '';
			$data['chxtc'] = '';
			$data['chxt'] = '';
			$data['chbh'] = '';
			$data['chs'] = '' . esc_attr( $width ) . 'x' . esc_attr( $height ) .'';
			$data['cht'] = 'p3';	//http://code.google.com/intl/da/apis/chart/docs/gallery/pie_charts.html#chart_types
			$data['chco'] = $color;
			$data['chds'] = '0,'. ($maxvalue + 1) .'';
			$data['chd'] = 't:'.implode(',',  $monthsList);
			foreach ($valuepercents as $key=>$val) $valuepercents[$key] = sprintf("%d%%", $val); //We need to have a percent (%=%25) char after each value
			$data['chl'] = implode("|", $valuepercents); //We need to list the values like 
			$data['chdl'] = join( '|', $xaxislable ); //Date like: 31 dec
			$data['chg'] = '';
			$data['chls'] = '';
			$data['chm'] = '';
		break;

		default : //same as "bar"
		break;
   }	
	
    $charturl = "http://chart.apis.google.com/chart?" . http_build_query($data);
    $charturl = htmlspecialchars($charturl);
                
	return "<img src='".$charturl."' />"
/* // Debugging start	
			.$month."<<-month<br />"
			.$maxvalue."<<-maxvalue<br />"
			.$minvalue."<<-minvalue<br />"
			.$year."<<-year<br />"
			.$width."<<-width<br />"
			.$height."<<-height<br />"
			.$type."<<-type<br />"
			.$color."<<-color<br />"
			.$xaxislable."<<-xaxislable<br />"
			.$monthsList."<<-monthsList<br />"
			.$format."<<-format<br />"
			.$sumvalue = array_sum($monthsList)."<br />"
			.print_r($valuepercents)."<<-valuepercents<br />"
			.$distancetype."<<-distancetype<br />"
//debugging end */
			;
	
	/* Debuging 
	print_r($distance_per_month) ;
	
	foreach($distance_per_month as $item) { $monthsList[] = $item->Runkm; } echo implode(',',  $monthsList); // or $list[0]->Runmonth
	*/
	
	//http://chart.apis.google.com/chart?cht=p3&chs=250x100&chd=t:60,40&chl=Hello|World
	/*
	echo '<img src="http://chart.apis.google.com/chart?chxl=0:|Jan|Feb|Mar|Jun|Jul|Aug|1:|100|50|0&chxt=x,y&chs=300x150&cht=lc&chds=0,106.49&chd=t:'?><?php foreach($distance_per_month as $item) { $monthsList[] = $item->Runkm; } echo implode(',',  $monthsList); ?><?php echo '&chg=25,50&chls=1" width="300" height="150" alt="" />';
	*/
// }
	
}
add_shortcode('runners_log_gchart', 'runners_log_gchart_func');
?>
