<div class="wrap">
<?php echo "<h2>" . __( 'Runners Log - VDOT Training Pace Calculator', RUNNERSLOG) . "</h2>"; ?>

<?php

//We have to be sure that we have the variables needed for the calculations
$vdot_distance = get_option('runnerslog_vdot_distance');
$vdot_time = get_option('runnerslog_vdot_time');
$distancetype = get_option('runnerslog_distancetype');

//First we make the arrays for the VDOTs 
//				0		1					2				3		4				5				6			7					8				9				10			11					12				13			14				15			16
$pace = array("VDOT", "E/L Pace km", "E/L Pace mile", "MP mile", "T Pace 400", "T Pace 800", "T Pace 1000", "T Pace .68 mile", "T Pace mile", "I Pace 400", "I Pace 1000", "I Pace .68 mile", "I Pace 1200", "I Pace mile", "R Pace 200", "R Pace 400", "R Pace 800", "");
$pace30 = array("30", "7:52", "12:40", "11:01", "02:33", "05:07", "06:24", "07:00", "10:18", "02:22", "-", " -", " -", " -", "67", "2:16", " -", "");
$pace31 = array("31", "7:41", "12:22", "10:45", "02:30", "04:59", "06:14", "06:49", "10:02", "02:18", "-", " -", " -", "", "65", "2:12", "", "");
$pace32 = array("32", "7:30", "12:04", "10:29", "02:26", "04:52", "06:05", "06:39", "09:47", "02:14", "-", " -", " -", " -", "63", "2:08", " -", "");
$pace33 = array("33", "7:20", "11:48", "10:14", "02:23", "04:45", "05:56", "06:30", "09:33", "02:11", "-", " -", " -", "", "62", "2:05", "", "");
$pace34 = array("34", "7:10", "11:32", "10:00", "02:19", "04:38", "05:48", "06:21", "09:20", "02:08", "-", " -", " -", " -", "60", "2:02", " -", "");
$pace35 = array("35", "7:01", "11:17", "9:46", "02:16", "04:32", "05:40", "06:12", "09:07", "02:05", "-", " -", " -", "", "59", "1:59", "", "");
$pace36 = array("36", "6:52", "11:02", "9:33", "02:13", "04:26", "05:33", "06:04", "08:55", "02:02", "-", " -", " -", " -", "57", "1:55", " -", "");
$pace37 = array("37", "6:43", "10:49", "9:20", "02:10", "04:20", "05:25", "05:56", "08:44", "01:59", "05:00", " -", " -", "", "56", "1:53", " -", "");
$pace38 = array("38", "6:35", "10:35", "9:08", "02:07", "04:15", "05:19", "05:49", "08:33", "01:56", "04:54", " -", " -", " -", "54", "1:50", " -", "");
$pace39 = array("39", "6:27", "10:23", "8:57", "02:05", "04:10", "05:12", "05:41", "08:22", "01:54", "04:48", " -", " -", "", "53", "1:48", " -", "");
$pace40 = array("40", "6:19", "10:11", "8:46", "02:02", "04:05", "05:06", "05:35", "08:12", "01:52", "04:42", " -", " -", " -", "52", "1:46", " -", "");
$pace41 = array("41", "6:12", "9:59", "8:35", "02:00", "04:00", "05:00", "05:28", "08:02", "01:50", "04:36", "05:00", " -", "", "51", "1:44", " -", "");
$pace42 = array("42", "6:05", "9:48", "8:25", "01:57", "03:55", "04:54", "05:22", "07:52", "01:48", "04:31", "04:55", " -", " -", "50", "1:42", " -", "");
$pace43 = array("43", "5:58", "9:37", "8:15", "01:55", "03:51", "04:49", "05:16", "07:42", "01:46", "04:26", "04:50", " -", "", "49", "1:40", " -", "");
$pace44 = array("44", "5:52", "9:27", "8:06", "01:53", "03:46", "04:43", "05:09", "07:33", "01:44", "04:21", "04:45", " -", " -", "48", "98", " -", "");
$pace45 = array("45", "5:46", "9:17", "7:57", "01:51", "03:42", "04:38", "05:04", "07:25", "01:42", "04:16", "04:40", " -", " -", "47", "96", " -", "");
$pace46 = array("46", "5:40", "9:07", "7:48", "01:49", "03:38", "04:33", "04:58", "07:17", "01:40", "04:12", "04:35", "05:00", " -", "46", "94", " -", "");
$pace47 = array("47", "5:34", "8:58", "7:40", "01:47", "03:35", "04:29", "04:54", "07:10", "01:38", "04:07", "04:29", "04:54", " -", "45", "92", " -", "");
$pace48 = array("48", "5:28", "8:49", "7:32", "01:45", "03:31", "04:24", "04:48", "07:02", "01:36", "04:03", "04:25", "04:49", " -", "44", "90", " -", "");
$pace49 = array("49", "5:23", "8:40", "7:24", "01:43", "03:28", "04:20", "04:44", "06:55", "01:35", "03:59", "04:21", "04:45", " -", "44", "89", " -", "");
$pace50 = array("50", "5:18", "8:32", "7:17", "01:42", "03:24", "04:15", "04:39", "06:51", "01:33", "03:55", "04:17", "04:41", " -", "43", "87", " -", "");
$pace51 = array("51", "5:13", "8:24", "7:09", "01:40", "03:21", "04:11", "04:35", "06:44", "01:32", "03:51", "04:12", "04:36", " -", "42", "86", " -", "");
$pace52 = array("52", "5:08", "8:16", "7:02", "01:38", "03:17", "04:07", "04:30", "06:38", "01:31", "03:48", "04:09", "04:33", " -", "42", "85", " -", "");
$pace53 = array("53", "5:04", "8:09", "6:56", "01:37", "03:15", "04:04", "04:27", "06:32", "01:30", "03:44", "04:05", "04:29", " -", "41", "84", " -", "");
$pace54 = array("54", "4:59", "8:01", "6:49", "01:35", "03:12", "04:00", "04:23", "06:26", "01:28", "03:41", "04:02", "04:25", " -", "40", "82", " -", "");
$pace55 = array("55", "4:55", "7:54", "6:43", "01:34", "03:09", "03:56", "04:18", "06:20", "01:27", "03:37", "03:58", "04:21", " -", "40", "81", " -", "");
$pace56 = array("56", "4:50", "7:48", "6:37", "01:33", "03:06", "03:53", "04:15", "06:15", "01:26", "03:34", "03:55", "04:18", " -", "39", "80", " -", "");
$pace57 = array("57", "4:46", "7:41", "6:31", "01:31", "03:04", "03:50", "04:12", "06:09", "01:25", "03:31", "03:52", "04:15", " -", "39", "79", " -", "");
$pace58 = array("58", "4:42", "7:34", "6:25", "01:30", "03:00", "03:45", "04:07", "06:04", "01:23", "03:28", "03:48", "04:10", " -", "38", "77", " -", "");
$pace59 = array("59", "4:38", "7:28", "6:19", "01:29", "02:58", "03:43", "04:04", "05:59", "01:22", "03:25", "03:45", "04:07", " -", "37", "76", " -", "");
$pace60 = array("60", "4:35", "7:22", "6:14", "01:28", "02:56", "03:40", "04:01", "05:54", "01:21", "03:23", "03:42", "04:03", " -", "37", "75", "2:30", "");
$pace61 = array("61", "4:31", "7:16", "6:09", "01:26", "02:53", "03:37", "03:58", "05:50", "01:20", "03:20", "03:39", "04:00", " -", "36", "74", "2:28", "");
$pace62 = array("62", "4:27", "7:11", "6:04", "01:25", "02:51", "03:34", "03:54", "05:45", "01:19", "03:17", "03:36", "03:57", " -", "36", "73", "2:26", "");
$pace63 = array("63", "4:24", "7:05", "5:59", "01:24", "02:49", "03:32", "03:52", "05:41", "01:18", "03:15", "03:33", "03:54", " -", "35", "72", "2:24", "");
$pace64 = array("64", "4:21", "7:00", "5:54", "01:23", "02:47", "03:29", "03:49", "05:36", "01:17", "03:12", "03:30", "03:51", " -", "35", "71", "2:22", "");
$pace65 = array("65", "4:18", "6:54", "5:49", "01:22", "02:45", "03:26", "03:46", "05:32", "01:16", "03:10", "03:28", "03:48", " -", "34", "70", "2:20", "");
$pace66 = array("66", "4:14", "6:49", "5:45", "01:21", "02:43", "03:24", "03:43", "05:28", "01:15", "03:08", "03:25", "03:45", "5:00", "34", "69", "2:18", "");
$pace67 = array("67", "4:11", "6:44", "5:40", "01:20", "02:41", "03:21", "03:40", "05:24", "01:14", "03:05", "03:22", "03:42", "4.57", "33", "68", "2:16", "");
$pace68 = array("68", "4:08", "6:39", "5:36", "01:19", "02:39", "03:19", "03:38", "05:20", "01:13", "03:03", "03:20", "03:39", "4.53", "33", "67", "2:14", "");
$pace69 = array("69", "4:05", "6:35", "5:32", "01:18", "02:37", "03:16", "03:35", "05:16", "01:12", "03:01", "03:18", "03:36", "4.50", "32", "66", "2:12", "");
$pace70 = array("70", "4:02", "6:30", "5:28", "01:17", "02:35", "03:14", "03:32", "05:13", "01:11", "02:59", "03:16", "03:34", "4.46", "32", "65", "2:10", "");
$pace71 = array("71", "4:00", "6:26", "5:24", "01:16", "02:33", "03:12", "03:30", "05:09", "01:10", "02:57", "03:13", "03:31", "4.43", "31", "64", "2:08", "");
$pace72 = array("72", "3:57", "6:21", "5:20", "01:16", "02:32", "03:10", "03:28", "05:05", "01:09", "02:55", "03:11", "03:29", "4.40", "31", "63", "2:06", "");
$pace73 = array("73", "3:54", "6:17", "5:16", "01:15", "02:30", "03:08", "03:26", "05:02", "01:09", "02:53", "03:09", "03:27", "4.37", "31", "62", "2:05", "");
$pace74 = array("74", "3:52", "6:l3", "5:12", "01:14", "02:29", "03:06", "03:23", "04:59", "01:08", "02:51", "03:07", "03:25", "4.34", "30", "62", "2:04", "");
$pace75 = array("75", "3:49", "6:09", "5:09", "01:14", "02:27", "03:04", "03:21", "04:56", "01:07", "02:49", "03:05", "03:22", "4.31", "30", "61", "2:03", "");
$pace76 = array("76", "3:47", "6:05", "5:05", "01:13", "02:26", "03:02", "03:19", "04:52", "01:06", "02:48", "03:03", "03:20", "4.28", "29", "60", "2:02", "");
$pace77 = array("77", "3:44", "6:01", "5:01", "01:12", "02:24", "03:00", "03:17", "04:49", "01:05", "02:46", "03:01", "03:18", "4.25", "29", "59", "2:00", "");
$pace78 = array("78", "3:42", "5:57", "4:58", "01:11", "02:22", "02:58", "03:15", "04:46", "01:05", "02:44", "02:59", "03:16", "4.23", "29", "59", "1:59", "");
$pace79 = array("79", "3:40", "5:54", "4:55", "01:10", "02:21", "02:56", "03:13", "04:43", "01:04", "02:42", "02:57", "03:14", "4.20", "28", "58", "1:58", "");
$pace80 = array("80", "3:38", "5:50", "4:52", "01:10", "02:19", "02:54", "03:11", "04:41", "01:04", "02:41", "02:56", "03:12", "4.17", "28", "58", "1:56", "");
$pace81 = array("81", "3:35", "5:46", "4:49", "01:09", "02:18", "02:53", "03:09", "04:38", "01:03", "02:39", "02:54", "03:10", "4.15", "28", "57", "1:55", "");
$pace82 = array("82", "3:33", "5:43", "4:46", "01:08", "02:17", "02:51", "03:07", "04:35", "01:02", "02:38", "02:52", "03:08", "4.12", "27", "56", "1:54", "");
$pace83 = array("83", "3:31", "5:40", "4:43", "01:08", "02:15", "02:49", "03:05", "04:32", "01:02", "02:36", "02:51", "03:07", "4.10", "27", "56", "1:53", "");
$pace84 = array("84", "3:29", "5:36", "4:40", "01:07", "02:14", "02:48", "03:04", "04:30", "01:01", "02:35", "02:49", "03:05", "4.08", "27", "55", "1:52", "");
$pace85 = array("85", "3:27", "5:33", "4:37", "01:06", "02:13", "02:46", "03:02", "04:27", "01:01", "02:33", "02:47", "03:03", "4:05", "27", "55", "1:51", ""); 
?>

<?php 
	if($_POST['runnerslog_op_hidden'] == 'Y') {
		//Form data sent
		$vdot_distance = $_POST['runnerslog_vdot_distance'];
		$vdot_time = $_POST['runnerslog_vdot_time'];
		update_option('runnerslog_vdot_distance', $vdot_distance);
		update_option('runnerslog_vdot_time', $vdot_time);
		?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
		<?php
	} else {
		//Normal page display
		$vdot_distance = get_option('runnerslog_vdot_distance');
		$vdot_time = get_option('runnerslog_vdot_time');
	}
?>

<form name="runnerslog_ops_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="runnerslog_op_hidden" value="Y" />
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="runnerslog_vdot_distance"><?php _e('Distance:') ?></label></th>
				<td><?php
					if ( $distancetype == meters ) {
						echo '<input name="runnerslog_vdot_distance" type="text" id="runnerslog_vdot_distance"  value="', form_option('runnerslog_vdot_distance'), '" class="small-text" />';
						echo '<span class="description"> Meters (eg. 2500)</span>';
							} else {
						echo '<input name="runnerslog_vdot_distance" type="text" id="runnerslog_vdot_distance"  value="', form_option('runnerslog_vdot_distance'), '" class="small-text" />';
						echo '<span class="description"> Miles (eg. 1.58)</span>';
					}
					?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="runnerslog_vdot_time"><?php _e('Time:') ?></label></th>
				<td><?php
						echo '<input name="runnerslog_vdot_time" type="text" id="runnerslog_vdot_time"  value="', form_option('runnerslog_vdot_time'), '" size="7" maxlength="8" />';
						echo '<span class="description"> Must be formated as hh:mm:ss like 01:37:45 for 1 hour 37min and 45sec</span>';
					?>
				</td>
			</tr>				
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Calculate VDOT-value', RUNNERSLOG) ?>" />
	</p>
</form>

<?php

//First we convert the time to second
$hms = $vdot_time;

function hms2secv3($hms) {
	list($h, $m, $s) = explode (":", $hms);
  if (strlen($hms) <= 5) {
	$seconds = 0;
	$seconds += (intval($h) * 60);
	$seconds += (intval($m));
	$seconds += (intval($s));
	return $seconds;
		} else {
	$seconds = 0;
	$seconds += (intval($h) * 3600);
	$seconds += (intval($m) * 60);
	$seconds += (intval($s));
	return $seconds;
	}
}
// Call the function
$seconds = hms2secv3($hms);

function sec2hmsv3($sec, $padHours = false) {
    $hms = "";
    $minutes = intval(($sec / 60) % 60); 
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
    $seconds = intval($sec % 60); 
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;  
}

//we now calculate the velocity based on the time in seconds
if ($vdot_distance && $seconds) {
	$velocity = $vdot_distance/($seconds/60);
}

//Let us calculate the VDOT
if ($distancetype == meters) {
	$vdot = ROUND((-4.60+(0.182258*$velocity)+(0.000104*($velocity*$velocity)))/(0.8+(0.1894393*exp(-0.012778*($seconds/60)))+(0.2989558*exp(-0.1932605*($seconds/60)))),1);
	$roundvdot = ROUND($vdot,0);
		} else {
	$vdot = ROUND((-4.60+(0.182258*($velocity*1609.344))+(0.000104*(($velocity*1609.344)*($velocity*1609.344))))/(0.8+(0.1894393*exp(-0.012778*($seconds/60)))+(0.2989558*exp(-0.1932605*($seconds/60)))),1);
	$roundvdot = ROUND($vdot,0);
}
	
if ( $vdot < 30 or $vdot >85 ) {
	echo 'Sorry, but this calculator only supports a VDOT value between 30 and 85. The calculated VDOT is: <b>',$vdot,'</b>';
  } else {
	echo '<p>The calculated VDOT is: <b>',$vdot, '</b> and the equivalent training zones are:</p>';
	echo'<table border="0" cellpadding="2" cellspacing="0" style="width: 250px;">
	<thead>
		<tr>
			<th style="background-color: rgb(169, 169, 169);" width="150"><b>Training Zone</b></th>
			<th colspan="2" style="background-color: rgb(169, 169, 169);"><b>Pace</b></th>
		</tr>
	</thead>
	<tbody>
		<tr style="background-color: rgb(252, 208, 195);">
			<td rowspan="2"><b><font size="+2">E </font>Easy Pace</b></td>
			<td>km</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[1].'</td>
		</tr>
		<tr style="background-color: rgb(252, 208, 195);">
			<td>mile</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[2].'</td>
		</tr>
		<tr style="background-color: rgb(244, 248, 203);">
			<td rowspan="2"><b><font size="+2">M </font>Marathon Pace</b></td>
			<td>km</td>
			<td style="text-align: center;">'.sec2hmsv3((hms2secv3(${"pace$roundvdot"}[3])/1.609344)).'</td>
		</tr>
		<tr style="background-color: rgb(244, 248, 203);">
			<td>mile</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[3].'</td>
		</tr>
		<tr style="background-color: rgb(194, 237, 253);">
			<td rowspan="5"><b><font size="+2">T </font>Threshold Pace</b></td>
			<td>400m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[4].'</td>
		</tr>
		<tr style="background-color: rgb(194, 237, 253);">
			<td>800m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[5].'</td>
		</tr>
		<tr style="background-color: rgb(194, 237, 253);">
			<td>1000m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[6].'</td>
		</tr>
		<tr style="background-color: rgb(194, 237, 253);">
			<td>.68 mile</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[7].'</td>
		</tr>
		<tr style="background-color: rgb(194, 237, 253);">
			<td>mile</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[8].'</td>
		</tr>
		<tr style="background-color: rgb(200, 201, 247);">
			<td rowspan="5"><b><font size="+2">I </font>Interval Pace</b></td>
			<td>400m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[9].'</td>
		</tr>
		<tr style="background-color: rgb(200, 201, 247);">
			<td>1000m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[10].'</td>
		</tr>
		<tr style="background-color: rgb(200, 201, 247);">
			<td>.68 mile</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[11].'</td>
		</tr>
		<tr style="background-color: rgb(200, 201, 247);">
			<td>1200m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[12].'</td>
		</tr>
		<tr style="background-color: rgb(200, 201, 247);">
			<td>mile</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[13].'</td>
		</tr>
		<tr style="background-color: rgb(209, 195, 238);">
			<td rowspan="5"><b><font size="+2">R </font>Repetition Pace</b></td>
			<td>200m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[14].'</td>
		</tr>
		<tr style="background-color: rgb(209, 195, 238);">
			<td>400m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[15].'</td>
		</tr>
		<tr style="background-color: rgb(209, 195, 238);">
			<td>8000m</td>
			<td style="text-align: center;">'.${"pace$roundvdot"}[16].'</td>
		</tr>
	</tbody>
</table>';
}
?>
<p>
<ul>
	<li>
		<b>Easy / Long (E/L) pace</b><br />
		At 65-79% of maximum heart rate (HR<sub>max</sub>), this non-straining intensity is used for recovery runs, warm-up, cool-down and long runs. The primary purpose is to build a base for more intense workouts by strengthening the heart and increasing the muscles&#39; ability to use oxygen, and to recover between hard workouts. Daniels recommends that most training miles are performed in <strong>E</strong> pace.Typical <strong>E</strong> runs include continuous runs up to about an hour.</li>
	<li>
		<b>Marathon (M) pace</b><br />
		At 80-90% HR<sub>max</sub>, this intensity is primarily aimed towards runners training for the marathon. The pace is one at which the runner hopes to complete. The pace can be included in other programs for a more intense workout, especially if the runner feels fresh and there is enough time to recover afterwards. <strong>M</strong>-runs are performed as continuous runs up to several hours, or as long interval training.</li>
	<li>
		<b>Threshold (T) pace<br />
		</b>At 88-92% HR<sub>max</sub>, this intensity is aimed to raise the lactate threshold. The runner should be able to sustain this pace for up to 60 minutes during racing. Daniels describe this intensity as &quot;comfortably hard&quot;. In elite runners, the pace matches the half marathon one, while less trained runners will run at around 10k pace. Daniels points out the importance of keeping the given pace to reap the benefits of the training. <strong>T</strong> runs are typically performed as continuous &quot;tempo&quot; runs for 20 minutes or more, or as &quot;cruise&quot; interval training with 3 to 10 of 3 to 15 minutes long work bouts, having 20%-25% rest intervals in between. No more than 10% of the weekly miles should be run in <strong>T</strong> pace.</li>
	<li>
		<b>Interval (I) pace<br />
		</b>Intensity at 98-100 % HR<sub>max</sub>. This intensity stresses the VO<sub>2</sub>max to raise the maximum oxygen uptake capacity. Since the pace is very intense, it can only be sustained for up to 12 minutes during racing. To cope with the intensity, and to train for longer periods of time, this training is performed as interval training, hence the name. The interval between each work bout should be a little less than the time of the work bout. For example, an <strong>I</strong> session can be 6 x 800 m at <strong>I</strong> pace with intervals as long as the time a 400 m recovery jog takes. At most 8% of the weekly training miles should be <strong>I</strong> pace.</li>
	<li>
		<b>Repetition (R) pace</b><br />
		<strong>R</strong> pace is very fast training aimed to improve speed and running economy. The training is performed as short interval training, with typically 200 m work outs, with full recovery intervals in between. No more than 5% of the weekly miles should be <strong>R</strong> pace.</li>
</ul>
	<p>
		Source: <a href="http://en.wikipedia.org/wiki/Jack_Daniels_%28coach%29#Easy_.2F_Long_.28E.2FL.29_pace">http://en.wikipedia.org/wiki/Jack_Daniels_%28coach%29#Easy_.2F_Long_.28E.2FL.29_pace</a>
	</p>
</p>

</div>
