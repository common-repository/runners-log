<?php
#How to use the new Google Chart API: https://developers.google.com/chart/interactive/docs/

/*
[runnerslog type="pie" format="d" year="2010" month="May" color="224499" width="600" height="300"]

Type: area, bar, column, line, pie, 3dpie, donutpie, scatter, table
Format: d="distance", t="time", c="calories", p="pulse"
Year: 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019
Month: Jan, Feb, Marts, April, May, June, July, Aug, Sep, Oct, Nov, Dec	
*/

//First we need to add the js loader to the header
function add_googlechart_api_loader_to_header() {
    echo '
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    ';
}
add_action( 'admin_head', 'add_googlechart_api_loader_to_header' ); 	// Add hook for admin <head></head>
add_action( 'wp_head', 'add_googlechart_api_loader_to_header' );		// Add hook for front-end <head></head>

class RunnersLogGraph {

	/*--------------------------------------------*
	 * Constants
	 *--------------------------------------------*/
	const name = 'RunnersLogGraph';
	
	/**
	 * Constructor
	 */
	function __construct() {
		//register an activation hook for the plugin
		register_activation_hook( __FILE__, array( &$this, 'install_runnersloggraph' ) );

		//Hook up to the init action
		add_action( 'init', array( &$this, 'init_runnersloggraph' ) );
	}
  
	/**
	 * Runs when the plugin is initialized
	 */
	function init_runnersloggraph() {
		// Register the shortcode [runnerslog]
		add_shortcode( 'runnerslog', array( &$this, 'render_column' ) );
	}


    function render_column($atts, $content = null) {
         return $this->render_chart('runnerslog', $atts, $content);
    }

	function render_chart($type, $atts, $content) {

		//Set debug on or off
		$debug = "0"; // O = Off 1 = On

		$type == "";
		
		// Make $wpdb global
		global $wpdb, $distancetype;

		// Extract the attributes
		extract(shortcode_atts(array(
			'width' => '550px', 
			'height' => '400px',
			'title' => '',
			'legend' => "{position: 'bottom', maxLines: 3}",
			'vaxis' => "{title: '',  titleTextStyle: {color: 'blue'}}",
			'haxis' => "{title: '',  titleTextStyle: {color: 'blue'}}",
			'curvetype' => NULL,
			'chartarea' => NULL,
            'type' => NULL,
            'is3d' => 'false', //add support for 3dpie
            'piehole' => 'false', //add support for 3dpie
			'month' => '0', //If month not selected set it to 0
            'year' => NULL,
			'format' => 'd', 
			), $atts) 
		);

		//The settings for AreaChart
		if ($type === "area") {
			$type = 'AreaChart';
			$curvetype = 'function';
			$otheroptions = "lineWidth: 4,";
			if ($format == "d") {
				$vaxis = '{minValue: 0}';
			}
       	}

		//The settings for BarChart
		if ($type === "bar") {
			$type = 'BarChart';
       	}

		//The settings for ColumnChart
		if ($type === "column") {
			$type = 'ColumnChart';
       	}

		//The settings for LineChart
		if ($type === "line") {
			$type = 'LineChart';
			$curvetype = 'function';
			$otheroptions = "lineWidth: 4,";
       	}

		//The settings for PieChart
		if ($type === "pie") {
			$type = 'PieChart';
			$otheroptions = "pieSliceText: 'label', ";
       	}

		//The settings for PieChart subtype 3dpie
		if ($type === "3dpie") {
			$type = 'PieChart';
			$is3d = 'true';
			$otheroptions = "pieSliceText: 'label', ";
       	}

		//The settings for PieChart subtype donut
		if ($type === "donutpie") {
			$type = 'PieChart';
			$piehole = '0.4';
			$otheroptions = "pieSliceText: 'label', ";
       	}

		//The settings for ScatterChart
		if ($type === "scatter") {
			$type = 'ScatterChart';
			if ($format == "d") {
				$vaxis = '{minValue: 0}';
			}
       	}

		//The settings for Table
		if ($type === "table") {
			$type = 'Table';
       	}

       	//Let us support if month is set to: 9, or spelled Sep, September 
		if (ctype_alpha($month)) { // first check if the month is a text or number
			$month = strtolower(substr($month, 0, 3)); // convert the month 3 chars if month is text

			//Convert the month to a value eg jan -> 1, etc
			$month2value = Array (
				'' => 0,  //adds the value 0 if no month is specified in [runnerslog]
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
				'dec' => 12,
			);	
			$month = $month2value[$month];
		}

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

	  /* THE FORMAT SWITCH */
		switch ($format){
		
			/* default option */
			case "d" : //Distances per day in a month or per month in a year
				if ($month == '0') {
					$dbdata = $wpdb->get_results("
						SELECT DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' ) AS Runyearmonth, 
							MONTH( $wpdb->posts.post_date ) AS Month, 
							(SUM( $wpdb->postmeta.meta_value )/1000) AS Runkm,
							SUM( $wpdb->postmeta.meta_value ) AS Runmiles
						FROM $wpdb->postmeta
						INNER JOIN $wpdb->posts ON ( $wpdb->postmeta.post_id = $wpdb->posts.id )
						WHERE $wpdb->postmeta.meta_key = '_rl_distance_value'
						AND $wpdb->posts.post_status = 'publish'
						AND year($wpdb->posts.post_date)= '$year'
						GROUP BY DATE_FORMAT($wpdb->posts.post_date, '%Y-%m')
						");
							} else {
					$dbdata = $wpdb->get_results("
						SELECT $wpdb->posts.post_date AS Fulldate,
							DAY( $wpdb->posts.post_date ) AS Day,
							MONTH( $wpdb->posts.post_date ) AS Month,
							$wpdb->postmeta.meta_value AS Distance
						FROM $wpdb->postmeta, $wpdb->posts
						WHERE $wpdb->postmeta.meta_key = '_rl_distance_value'
						AND $wpdb->posts.post_status = 'publish'
						AND $wpdb->postmeta.post_id = $wpdb->posts.id
						AND year($wpdb->posts.post_date)= '$year'
						AND month($wpdb->posts.post_date)= '$month'
						ORDER BY `$wpdb->posts`.`post_date` ASC
						");
				}

				if ($month == '0') {
					$content .= "['Month',";
				} else {
					$content .= "['Day',";
				}

				$content .= "'Distance'],";

				if ($month == '0') {				
					foreach ( $dbdata as $value ) {
			   			$content .= "[";
			   			$content .= "'".$month2str[$value->Month]."',";
			   			if ($distancetype == 'meters') {
			   				$content .= "".$value->Runkm.",";
			   			} else {
			   				$content .= "".$value->Runmiles.",";
			   			}	
			   			$content .= "],";
					}
					$title = "This $type shows distance per month in $year";
				} else {
					foreach ( $dbdata as $value ) {
			   			$content .= "[";
			   			$content .= "'".$value->Day.".',";
			   			$content .= "".$value->Distance.",";
			   			$content .= "],";
					}
					$title = "This $type shows distance per day in $month2str[$month] $year";					
				}
			break;

			case "p" :  //Pulse pr day or pulse avg
				if ($month == '0') {
					$dbdata = $wpdb->get_results("
						SELECT DATE_FORMAT( $wpdb->posts.post_date, '%Y' ) AS Runyear, 
							MONTH( $wpdb->posts.post_date ) AS Month,
							SUM( $wpdb->postmeta.meta_value ) AS PulseSum,
							COUNT( $wpdb->postmeta.meta_value ) AS PulseNumbers,
							ROUND((SUM( $wpdb->postmeta.meta_value )/COUNT( $wpdb->postmeta.meta_value )),0) AS PulseAvg,
							MAX($wpdb->postmeta.meta_value) AS PulseMax,
							MIN($wpdb->postmeta.meta_value) AS PulseMin
						FROM $wpdb->postmeta
						INNER JOIN $wpdb->posts ON ( $wpdb->postmeta.post_id = $wpdb->posts.id )
						WHERE $wpdb->postmeta.meta_key = '_rl_pulsavg_value'
						AND $wpdb->posts.post_status = 'publish'
						AND $wpdb->postmeta.post_id = $wpdb->posts.id
						AND year($wpdb->posts.post_date)= '$year'
						GROUP BY DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' )
						");
				} else {
					$dbdata = $wpdb->get_results("
						SELECT $wpdb->posts.post_date AS Fulldate, 
							DAY( $wpdb->posts.post_date ) AS Day, 
							MONTH( $wpdb->posts.post_date ) AS Month,
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

				// here we play with intervals in the google chart graph in a given $year	
				if ($month == '0' AND $type == 'LineChart') {

				$content .= "[{label: 'Month', id: 'Month', type: 'string'},
         					{label: 'PulseAvg', id: 'PulseAvg', type: 'number'}, 
         					{label: 'PulseMin', id: 'PulseMin', type: 'number', role:'interval'},
         					{label: 'PulseMax', id: 'PulseMax', type: 'number', role:'interval'}],";

				foreach ( $dbdata as $value ) {
	   				$content .= "[";	
		   			$content .= "'".$month2str[$value->Month]."',";
		   			$content .= "".$value->PulseAvg.",";
		   			$content .= "".$value->PulseMin.",";
		   			$content .= "".$value->PulseMax."";
		   			$content .= "],";
				}
				$title = "This $type shows average pulse per month in $year with intervals";
				$otheroptions = $otheroptions."intervals: { 'style':'area' },";

				// pulse per a given $year
				} elseif ($month == '0') {	

				$content .= "['Month',";
				$content .= "'Pulse'],";

					foreach ( $dbdata as $value ) {
		   				$content .= "[";	
			   			$content .= "'".$month2str[$value->Month]."',";
			   			$content .= "".$value->PulseAvg.",";
			   			$content .= "],";
					}
					$title = "This $type shows average pulse per month in $year";		
				} else {
				
				// pulse per day in a given $month in a given $year
				$content .= "['Day',";
				$content .= "'Pulse'],";

					foreach ( $dbdata as $value ) {
			   			$content .= "[";
			   			$content .= "'".$value->Day.".',";
			   			$content .= "".$value->Pulse.",";
			   			$content .= "],";
					}
					$title = "This $type shows pulse per day in $month2str[$month] $year";					
				}
			break;

			case "t" : //time per day in a month or per month in a year
				if ($month == '0') {
					$dbdata = $wpdb->get_results("
					SELECT DATE_FORMAT( $wpdb->posts.post_date, '%Y' ) AS Runyear,
						MONTH( $wpdb->posts.post_date ) AS Month,
						sec_to_time( SUM( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) ) ) ) AS TotalRuntimeHHMMSS,
						SUM( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) ) ) AS TotalRuntimeSec,
						ROUND((SUM( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) ) )/60),2) AS TotalRuntimeMin,
						ROUND((SUM( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) ) )/3600),2) AS TotalRuntimeHours,
						COUNT( $wpdb->postmeta.meta_value ) AS NumberOfRuns,
						MAX($wpdb->postmeta.meta_value) AS LongestRuntime,
						MIN($wpdb->postmeta.meta_value) AS ShortestRuntime
					FROM $wpdb->postmeta
					INNER JOIN $wpdb->posts ON ( $wpdb->postmeta.post_id = $wpdb->posts.id )
					WHERE $wpdb->postmeta.meta_key = '_rl_time_value'
					AND $wpdb->posts.post_status = 'publish'
					AND $wpdb->postmeta.post_id = $wpdb->posts.id
					AND year($wpdb->posts.post_date)= '$year'
					GROUP BY DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' )
						");
							} else {
					$dbdata = $wpdb->get_results("
					SELECT $wpdb->posts.post_date AS Fulldate,
						DAY( $wpdb->posts.post_date ) AS Day,
						MONTH( $wpdb->posts.post_date ) AS Month,
						$wpdb->postmeta.meta_value AS Runtime,
						( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) ) )  AS RuntimeSec,
						ROUND(( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) )/60),0) AS RuntimeMin,
						ROUND(( time_to_sec( STR_TO_DATE( $wpdb->postmeta.meta_value, '%T' ) )/3600), 2) AS RuntimeHours
					FROM $wpdb->postmeta, $wpdb->posts
					WHERE $wpdb->postmeta.meta_key = '_rl_time_value'
					AND $wpdb->posts.post_status = 'publish'
					AND $wpdb->postmeta.post_id = $wpdb->posts.id
					AND year($wpdb->posts.post_date)= '$year'
					AND month($wpdb->posts.post_date)= '$month'
					ORDER BY `$wpdb->posts`.`post_date` ASC
						");
				}

				if ($month == '0') {
					$content .= "['Month',";
					$content .= "'Time in hours'],";
				} else {
					$content .= "['Day',";
					$content .= "'Time in minutes'],";
				}

				if ($month == '0') {				
					foreach ( $dbdata as $value ) {
			   			$content .= "[";
			   			$content .= "'".$month2str[$value->Month]."',";
			   			$content .= "".$value->TotalRuntimeHours.",";
			   			$content .= "],";
					}
					$title = "This $type shows running time per month in $year";
				} else {
					foreach ( $dbdata as $value ) {
			   			$content .= "[";
			   			$content .= "'".$value->Day.".',";
			   			$content .= "".$value->RuntimeMin.",";
			   			$content .= "],";
					}
					$title = "This $type shows running time per day in $month2str[$month] $year";					
				}
			break;

			case "c" : //calories per day in a month or per month in a year
				if ($month == '0') {
					$dbdata = $wpdb->get_results("
					SELECT DATE_FORMAT( $wpdb->posts.post_date, '%Y' ) AS Year, 
						MONTH( $wpdb->posts.post_date ) AS Month,
						SUM( $wpdb->postmeta.meta_value ) AS CaloriesSum,
						MAX($wpdb->postmeta.meta_value) AS CalMax,
						MIN($wpdb->postmeta.meta_value) AS CalMin
					FROM $wpdb->postmeta
					INNER JOIN $wpdb->posts ON ( $wpdb->postmeta.post_id = $wpdb->posts.id )
					WHERE $wpdb->postmeta.meta_key = '_rl_calories_value'
					AND $wpdb->posts.post_status = 'publish'
					AND $wpdb->postmeta.post_id = $wpdb->posts.id
					AND year($wpdb->posts.post_date)= '$year'
					GROUP BY DATE_FORMAT( $wpdb->posts.post_date, '%Y-%m' )
						");
							} else {
					$dbdata = $wpdb->get_results("
					SELECT $wpdb->posts.post_date AS Fulldate,
						DAY( $wpdb->posts.post_date ) AS Day,
						MONTH( $wpdb->posts.post_date ) AS Month,
						$wpdb->postmeta.meta_value AS Calories
					FROM $wpdb->postmeta, $wpdb->posts
					WHERE $wpdb->postmeta.meta_key = '_rl_calories_value'
					AND $wpdb->posts.post_status = 'publish'
					AND $wpdb->postmeta.post_id = $wpdb->posts.id
					AND year($wpdb->posts.post_date)= '$year'
					AND month($wpdb->posts.post_date)= '$month'
					ORDER BY `$wpdb->posts`.`post_date` ASC
						");
				}

				if ($month == '0') {
					$content .= "['Month',";
				} else {
					$content .= "['Day',";
				}
					$content .= "'Calories'],";

				if ($month == '0') {				
					foreach ( $dbdata as $value ) {
			   			$content .= "[";
			   			$content .= "'".$month2str[$value->Month]."',";
			   			$content .= "".$value->CaloriesSum.",";
			   			$content .= "],";
					}
					$title = "This $type shows use of calories per month in $year";
				} else {
					foreach ( $dbdata as $value ) {
			   			$content .= "[";
			   			$content .= "'".$value->Day.".',";
			   			$content .= "".$value->Calories.",";
			   			$content .= "],";
					}
					$title = "This $type shows use of calories per day in $month2str[$month] $year";					
				}
			break;

			default:
			break;
		}

/* 
// Database snippet for local validation
SELECT wp_posts.post_date AS Fulldate, DAY( wp_posts.post_date ) AS
Day , MONTH( wp_posts.post_date ) AS
Month , wp_postmeta.meta_value AS Distance
FROM wp_postmeta, wp_posts
WHERE wp_postmeta.meta_key = '_rl_distance_value'
AND wp_posts.post_status = 'publish'
AND wp_postmeta.post_id = wp_posts.id
AND year(wp_posts.post_date)='2010'
AND month(wp_posts.post_date)='2'
ORDER BY `wp_posts`.`post_date` DESC

Print
Fulldate 	Day 	Month 	Distance 	
2010-02-28 21:30:22 	28 	2 	6000
2010-02-24 21:52:20 	24 	2 	8500
2010-02-22 20:14:09 	22 	2 	10680
2010-02-21 10:54:31 	21 	2 	10000
2010-02-18 22:01:20 	18 	2 	9000
2010-02-15 20:46:44 	15 	2 	9990
2010-02-14 10:55:31 	14 	2 	10000
2010-02-12 21:04:35 	12 	2 	8500
2010-02-04 22:24:26 	4 	2 	8000
2010-02-02 22:18:41 	2 	2 	8000
*/

    global $item_id;
    $item_id++;  
	   
    // Remove HTML tags from the content of the shortcode
	$content = html_entity_decode($content, ENT_NOQUOTES, "UTF-8");
    $content = wp_strip_all_tags($content,true);

    //Set the $var if table or normal chart
    if ($type === "Table") {
        // Instantiate and draw our chart, passing in some options.
        $visualization = "var table = new google.visualization.$type(document.getElementById('chart_div_$item_id'));
        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'})";
    } else {
        // Instantiate and draw our chart, passing in some options.
        $visualization = "var chart = new google.visualization.$type(document.getElementById('chart_div_$item_id'));
        chart.draw(data, options)";        	        	
    };

	if ($debug == "1") {
		$debugtags = "$content <P></P>
		  Type: $type </br>
		  Other options: $otheroptions </br>
		  Month: $month </br>
		  Distancetype: $distancetype</br>
		  Format: $format</br>
		  $vaxis </br>
		  $height </br>
		  $width </br>";
	}

    $str = <<<EOT
    <div id="googlegraph_$item_id" class="log_runnersloggraph">	
    <div id="chart_div_$item_id" class="gc_$type" style="width: $width; height: $height;"></div>

	<script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart', 'table']});  //corechart for bar, column, line, area, stepped area, bubble, pie, donut, combo, candlestick, histogram, scatter

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it
      function drawChart() {

        // Create the data table.
        var data = google.visualization.arrayToDataTable([
			$content
        ]);

        // Set chart options
        var options = {
          $otheroptions
          title: '$title',
          vAxis: $vaxis,
          hAxis: $haxis,
		  curveType: '$curvetype',
          is3D: $is3d,
          pieHole: $piehole,
          legend: $legend
        };

        $visualization

      }
    </script>
    <p style="font-size: .5em;">Generated using <a href="https://wordpress.org/plugins/runners-log/" title="Runners Log a wordpress plugin">Runners Log a Wordpress plugin</a> by <a href="http://www.liljefred.dk">Frederik Liljefred, M.D.</a></p>
    <!-- debugging --!>
	$debugtags
	<!-- debugging --!>
    </div>
		
EOT;
		return $str;
	}
} // end class
new RunnersLogGraph();


// add more buttons to the html editor
function runnersloggraph_add_quicktags() {
    if (wp_script_is('quicktags')){
?>
    <script type="text/javascript">
    QTags.addButton( 'runnerslog', 'runnerslog', '[runnerslog format="d|t|p|c" type="area|bar|column|line|pie|3dpie|donutpie|scatter|table"] year="" month=""]', '[/runnerslog]', 200 );
    </script>
<?php
    }
}
add_action( 'admin_print_footer_scripts', 'runnersloggraph_add_quicktags' );