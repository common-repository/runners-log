<div class="wrap">
<?php echo "<h2>" . __( 'Runners Log - Predicted effect of change in weight', RUNNERSLOG) . "</h2>"; ?>

<?php

//We have to be sure that we have the variables needed for the calculations
$vdot_distance = get_option('runnerslog_vdot_distance');
$vdot_time = get_option('runnerslog_vdot_time');
$distancetype = get_option('runnerslog_distancetype');
$gender = get_option('runnerslog_gender');
$weight = get_option('runnerslog_weight');
$age = get_option('runnerslog_age');
$heightcm = get_option('runnerslog_cm');
$heightfeets = get_option('runnerslog_feets');
$heightinches = get_option('runnerslog_inches');
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
						echo '<span class="description"> Meters (eg 2500)</span>';
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

<h3>
	The calculation assumes that everything else is held constant.&nbsp; In real life, however, everything else would not be constant. A reduction in weight might be accompanied by:</h3>
<ul>
	<li>
		A higher background level of training</li>
	<li>
		Lower muscle mass</li>
	<li>
		Reduced immunity</li>
	<li>
		Reduced glycogen stores</li>
	<li>
		Lower levels of hydration</li>
</ul>

<?php

//First we convert the time to second
$hms = $vdot_time;

function hms2secv4($hms) {
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
$seconds = hms2secv4($hms);

// This function for use in paces - where hours not an option
function sec2hmsv4($sec, $padHours = false) {
    $hms = "";
    $minutes = intval(($sec / 60) % 60); 
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ':';
    $seconds = intval($sec % 60); 
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;  
}

// This function is used when hours is an option and we need the full time in hh:mm:ss there for $useColon is set to true
function sec2hmsfull($sec, $useColon = true)
{
	// holds formatted string
	$hms = "";
	
	// there are 3600 seconds in an hour, so if we
	// divide total seconds by 3600 and throw away
	// the remainder, we've got the number of hours
	$hours = intval(intval($sec) / 3600); 
	
	// add to $hms, with a leading 0 if asked for
	if ($hours > 0){
		$hms .= ($useColon) 
		      ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
		      : $hours. ' tim ';
	}elseif ($useColon){
		$hms .= '00:';	
	}
	 
	// dividing the total seconds by 60 will give us
	// the number of minutes, but we're interested in 
	// minutes past the hour: to get that, we need to 
	// divide by 60 again and keep the remainder
	$minutes = intval(($sec / 60) % 60); 
	
	// then add to $hms (with a leading 0 if needed)
	if ($minutes > 0)
	$hms .= ($useColon) 
		      ? str_pad($minutes, 2, "0", STR_PAD_LEFT). ':'
		      : $minutes. ' min ';
	
	// seconds are simple - just divide the total
	// seconds by 60 and keep the remainder
	$seconds = intval($sec % 60); 
	
	// add to $hms, again with a leading 0 if needed
	$hms .= ($useColon) 
		      ? str_pad($seconds, 2, "0", STR_PAD_LEFT)
		      : $seconds. ' sek ';
	
	return $hms;
}

// This function is used when hours is an option and we need the time as min-sec
function sec2hmsdiff($sec, $useColon = false)
{
	// holds formatted string
	$hms = "";
	
	// there are 3600 seconds in an hour, so if we
	// divide total seconds by 3600 and throw away
	// the remainder, we've got the number of hours
	$hours = intval(intval($sec) / 3600); 
	
	// add to $hms, with a leading 0 if asked for
	if ($hours > 0){
		$hms .= ($useColon) 
		      ? str_pad($hours, 2, "0", STR_PAD_LEFT). ':'
		      : $hours. ' hours ';
	}elseif ($useColon){
		$hms .= '00:';	
	}
	 
	// dividing the total seconds by 60 will give us
	// the number of minutes, but we're interested in 
	// minutes past the hour: to get that, we need to 
	// divide by 60 again and keep the remainder
	$minutes = intval(($sec / 60) % 60); 
	
	// then add to $hms (with a leading 0 if needed)
	if ($minutes > 0)
	$hms .= ($useColon) 
		      ? str_pad($minutes, 2, "0", STR_PAD_LEFT). ':'
		      : $minutes. 'min ';
	
	// seconds are simple - just divide the total
	// seconds by 60 and keep the remainder
	$seconds = intval($sec % 60); 
	
	// add to $hms, again with a leading 0 if needed
	$hms .= ($useColon) 
		      ? str_pad($seconds, 2, "0", STR_PAD_LEFT)
		      : $seconds. 'sec ';
	
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
	$pacelang = 'min/km';
		} else {
	$vdot = ROUND((-4.60+(0.182258*($velocity*1609.344))+(0.000104*(($velocity*1609.344)*($velocity*1609.344))))/(0.8+(0.1894393*exp(-0.012778*($seconds/60)))+(0.2989558*exp(-0.1932605*($seconds/60)))),1);
	$roundvdot = ROUND($vdot,0);
	$pacelang = 'min/mile';
}

if ( $distancetype == meters ) {
	$height = $heightcm;
	$heightlang = 'cm';
	$weight = $weight;
	$weightlang = 'kg';
	$weightminus12 = $weight-12;
	$weightminus10 = $weight-10;
	$weightminus8 = $weight-8;
	$weightminus6 = $weight-6;
	$weightminus4 = $weight-4;
	$weightminus2 = $weight-2;
	$weightplus2 = $weight+2;
	$weightplus5 = $weight+5;
		} else {
	$height = $heightfeets*12+$heightinches;
	$heightlang = 'inches';
	$weight = $weight;
	$weightlang = 'pounds';
	$weightminus12 = $weight-12;
	$weightminus10 = $weight-10;
	$weightminus8 = $weight-8;
	$weightminus6 = $weight-6;
	$weightminus4 = $weight-4;
	$weightminus2 = $weight-2;
	$weightplus2 = $weight+2;
	$weightplus5 = $weight+5;
}

if ( $vdot_time &&  $weight) {
	$vdot_timeplus5 = sec2hmsfull(hms2secv4($vdot_time)*($weight+5*0.83)/$weight);
	$vdot_timeplus2 = sec2hmsfull(hms2secv4($vdot_time)*($weight+2*0.83)/$weight);
	$vdot_timeminus2 = sec2hmsfull(hms2secv4($vdot_time)*($weight-2*0.83)/$weight);
	$vdot_timeminus4 = sec2hmsfull(hms2secv4($vdot_time)*($weight-4*0.83)/$weight);
	$vdot_timeminus6 = sec2hmsfull(hms2secv4($vdot_time)*($weight-6*0.83)/$weight);
	$vdot_timeminus8 = sec2hmsfull(hms2secv4($vdot_time)*($weight-8*0.83)/$weight);
	$vdot_timeminus10 = sec2hmsfull(hms2secv4($vdot_time)*($weight-10*0.83)/$weight);
	$vdot_timeminus12 = sec2hmsfull(hms2secv4($vdot_time)*($weight-12*0.83)/$weight);
}
	
if ( $vdot < 30 or $vdot >85 ) {
	echo 'Sorry, but this calculator only supports a VDOT value between 30 and 85. The calculated VDOT is: <b>'.$vdot.'</b>';
		} else {
	echo '<p>The calculated VDOT is: <b>'.$vdot.'</b> and the predicted effect of change in weight is:</p>';
	echo'<table border="0" cellpadding="0" cellspacing="0" style="width: 750px;">
	<thead>
		<tr>
			<th colspan="10" scope="col" style="background-color: rgb(204, 204, 204);">
				Projected Impact of Weight on distance</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="3" rowspan="1" style="background-color: rgb(204, 204, 204);">
				Gender: '.$gender.'</td>
			<td colspan="3" rowspan="1" style="background-color: rgb(204, 204, 204);">
				Weight: '.$weight.' '.$weightlang.'</td>
			<td colspan="3" rowspan="1" style="background-color: rgb(204, 204, 204);">
				Height: '.$height.' '.$heightlang.'</td>
			<td colspan="3" rowspan="1" style="background-color: rgb(204, 204, 204);">
				Age: '.$age.'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(204, 204, 204);">
				Weight</td>
			<td style="background-color: rgb(102, 102, 153);">
				<b>'.$weightplus5.'</b></td>
			<td style="background-color: rgb(102, 153, 255);">
				<b>'.$weightplus2.'</b></td>
			<td style="background-color: rgb(255, 255, 0);">
				<b>'.$weight.'</b></td>
			<td style="background-color: rgb(255, 204, 0);">
				<b>'.$weightminus2.'</b></td>
			<td style="background-color: rgb(255, 153, 0);">
				<b>'.$weightminus4.'</b></td>
			<td style="background-color: rgb(255, 102, 0);">
				<b>'.$weightminus6.'</b></td>
			<td style="background-color: rgb(255, 102, 0);">
				<b>'.$weightminus8.'</b></td>
			<td style="background-color: rgb(255, 102, 0);">
				<b>'.$weightminus10.'</b></td>
			<td style="background-color: rgb(255, 0, 0);">
				<b>'.$weightminus12.'</b></td>
		</tr>
		<tr>
			<td style="background-color: rgb(204, 204, 204);">
				Time</td>
			<td style="background-color: rgb(102, 102, 153);">
				'.$vdot_timeplus5.'</td>
			<td style="background-color: rgb(102, 153, 255);">
				'.$vdot_timeplus2.'</td>
			<td style="background-color: rgb(255, 255, 0);">
				'.$vdot_time.'</td>
			<td style="background-color: rgb(255, 204, 0);">
				'.$vdot_timeminus2.'</td>
			<td style="background-color: rgb(255, 153, 0);">
				'.$vdot_timeminus4.'</td>
			<td style="background-color: rgb(255, 102, 0);">
				'.$vdot_timeminus6.'</td>
			<td style="background-color: rgb(255, 102, 0);">
				'.$vdot_timeminus8.'</td>
			<td style="background-color: rgb(255, 102, 0);">
				'.$vdot_timeminus10.'</td>
			<td style="background-color: rgb(255, 0, 0);">
				'.$vdot_timeminus12.'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(204, 204, 204);">
				Pace</td>
			<td style="background-color: rgb(102, 102, 153);">
				'.sec2hmsv4(hms2secv4($vdot_timeplus5)/($vdot_distance/1000)).'</td>
			<td style="background-color: rgb(102, 153, 255);">
				'.sec2hmsv4(hms2secv4($vdot_timeplus2)/($vdot_distance/1000)).'</td>
			<td style="background-color: rgb(255, 255, 0);">
				'.sec2hmsv4(hms2secv4($vdot_time)/($vdot_distance/1000)).'</td>
			<td style="background-color: rgb(255, 204, 0);">
				'.sec2hmsv4(hms2secv4($vdot_timeminus2)/($vdot_distance/1000)).'</td>
			<td style="background-color: rgb(255, 153, 0);">
				'.sec2hmsv4(hms2secv4($vdot_timeminus4)/($vdot_distance/1000)).'</td>
			<td style="background-color: rgb(255, 102, 0);">
				'.sec2hmsv4(hms2secv4($vdot_timeminus6)/($vdot_distance/1000)).'</td>
			<td style="background-color: rgb(255, 102, 0);">
				'.sec2hmsv4(hms2secv4($vdot_timeminus8)/($vdot_distance/1000)).'</td>
			<td style="background-color: rgb(255, 102, 0);">
				'.sec2hmsv4(hms2secv4($vdot_timeminus10)/($vdot_distance/1000)).'</td>
			<td style="background-color: rgb(255, 0, 0);">
				'.sec2hmsv4(hms2secv4($vdot_timeminus12)/($vdot_distance/1000)).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(204, 204, 204);">
				Time diff</td>
			<td style="background-color: rgb(102, 102, 153);">
				'.sec2hmsdiff(hms2secv4($vdot_timeplus5)-hms2secv4($vdot_time)).'</td>
			<td style="background-color: rgb(102, 153, 255);">
				'.sec2hmsdiff(hms2secv4($vdot_timeplus2)-hms2secv4($vdot_time)).'</td>
			<td style="background-color: rgb(255, 255, 0);">
				0</td>
			<td style="background-color: rgb(255, 204, 0);">
				-'.sec2hmsdiff(hms2secv4($vdot_time)-hms2secv4($vdot_timeminus2)).'</td>
			<td style="background-color: rgb(255, 153, 0);">
				-'.sec2hmsdiff(hms2secv4($vdot_time)-hms2secv4($vdot_timeminus4)).'</td>
			<td style="background-color: rgb(255, 102, 0);">
				-'.sec2hmsdiff(hms2secv4($vdot_time)-hms2secv4($vdot_timeminus6)).'</td>
			<td style="background-color: rgb(255, 102, 0);">
				-'.sec2hmsdiff(hms2secv4($vdot_time)-hms2secv4($vdot_timeminus8)).'</td>
			<td style="background-color: rgb(255, 102, 0);">
				-'.sec2hmsdiff(hms2secv4($vdot_time)-hms2secv4($vdot_timeminus10)).'</td>
			<td style="background-color: rgb(255, 0, 0);">
				-'.sec2hmsdiff(hms2secv4($vdot_time)-hms2secv4($vdot_timeminus12)).'</td>
		</tr>
	</tbody>
</table>
';
}
?>
</div>
