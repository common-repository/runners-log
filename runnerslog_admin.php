<?php 
	if($_POST['runnerslog_op_hidden'] == 'Y') {
		//Form data sent
		$distancetype = $_POST['runnerslog_distancetype'];
		$gender = $_POST['runnerslog_gender'];
		$pulsavg = $_POST['runnerslog_pulsavg'];
		$garminconnect = $_POST['runnerslog_garminconnectlink'];
		$calories = $_POST['runnerslog_caloriescount'];
		$cadence = $_POST['runnerslog_cadence'];
		$heightcm = $_POST['runnerslog_cm'];
		$heightfeets = $_POST['runnerslog_feets'];
		$heightinches = $_POST['runnerslog_inches'];
		$weight = $_POST['runnerslog_weight'];
		$age = $_POST['runnerslog_age'];
		$hrrest = $_POST['runnerslog_hrrest'];
		$hrmax = $_POST['runnerslog_hrmax'];
		$show_gearmanager = $_POST['runnerslog_show_gearmanager'];
		$show_distance = $_POST['runnerslog_show_distance'];
		$show_time = $_POST['runnerslog_show_time'];
		$show_speed = $_POST['runnerslog_show_speed'];
		$show_speedperdistance = $_POST['runnerslog_show_speedperdistance'];
		$show_pulse = $_POST['runnerslog_show_pulse'];
		$show_calories = $_POST['runnerslog_show_calories'];
		$show_cadence = $_POST['runnerslog_show_cadence'];
		$show_garminconnect = $_POST['runnerslog_show_garminconnect'];
		$show_distance2009 = $_POST['runnerslog_show_distance2009'];
		$show_distance2010 = $_POST['runnerslog_show_distance2010'];
		$show_distance2011 = $_POST['runnerslog_show_distance2011'];
		$show_distance2012 = $_POST['runnerslog_show_distance2012'];
		$show_distance2013 = $_POST['runnerslog_show_distance2013'];
		$show_distance2014 = $_POST['runnerslog_show_distance2014'];
		$show_distance2015 = $_POST['runnerslog_show_distance2015'];
		$show_distance2016 = $_POST['runnerslog_show_distance2016'];
		$show_distance2017 = $_POST['runnerslog_show_distance2017'];
		$show_distance2018 = $_POST['runnerslog_show_distance2018'];
		$show_distance2019 = $_POST['runnerslog_show_distance2019'];
		$show_distance_sum = $_POST['runnerslog_show_distance_sum'];
		$show_garminmap = $_POST['runnerslog_show_garminmap'];
		update_option('runnerslog_distancetype', $distancetype);
		update_option('runnerslog_gender', $gender);
		update_option('runnerslog_pulsavg', $pulsavg);		
		update_option('runnerslog_garminconnectlink', $garminconnect);		
		update_option('runnerslog_caloriescount', $calories);
		update_option('runnerslog_cadence', $cadence);
		update_option('runnerslog_cm', $heightcm);
		update_option('runnerslog_feets', $heightfeets);
		update_option('runnerslog_inches', $heightinches);
		update_option('runnerslog_weight', $weight);
		update_option('runnerslog_age', $age);
		update_option('runnerslog_show_gearmanager', $show_gearmanager);
		update_option('runnerslog_hrrest', $hrrest);
		update_option('runnerslog_hrmax', $hrmax);
		update_option('runnerslog_show_distance', $show_distance);
		update_option('runnerslog_show_time', $show_time);
		update_option('runnerslog_show_speed', $show_speed);
		update_option('runnerslog_show_speedperdistance', $show_speedperdistance);
		update_option('runnerslog_show_pulse', $show_pulse);
		update_option('runnerslog_show_calories', $show_calories);
		update_option('runnerslog_show_cadence', $show_cadence);
		update_option('runnerslog_show_garminconnect', $show_garminconnect);
		update_option('runnerslog_show_distance2009', $show_distance2009);
		update_option('runnerslog_show_distance2010', $show_distance2010);
		update_option('runnerslog_show_distance2011', $show_distance2011);
		update_option('runnerslog_show_distance2012', $show_distance2012);
		update_option('runnerslog_show_distance2013', $show_distance2013);
		update_option('runnerslog_show_distance2014', $show_distance2014);
		update_option('runnerslog_show_distance2015', $show_distance2015);
		update_option('runnerslog_show_distance2016', $show_distance2016);
		update_option('runnerslog_show_distance2017', $show_distance2017);
		update_option('runnerslog_show_distance2018', $show_distance2018);
		update_option('runnerslog_show_distance2019', $show_distance2019);
		update_option('runnerslog_show_distance_sum', $show_distance_sum);
		update_option('runnerslog_show_garminmap', $show_garminmap);
		?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
		<?php
	} else {
		//Normal page display
		$distancetype = get_option('runnerslog_distancetype');
		$gender = get_option('runnerslog_gender');
		$pulsavg = get_option('runnerslog_pulsavg');
		$garminconnect = get_option('runnerslog_garminconnectlink');
		$calories = get_option('runnerslog_caloriescount');
		$cadence = get_option('runnerslog_cadence');
		$heightcm = get_option('runnerslog_cm');
		$heightfeets = get_option('runnerslog_feets');
		$heightinches = get_option('runnerslog_inches');
		$weight = get_option('runnerslog_weight');
		$age = get_option('runnerslog_age');
		$show_gearmanager = get_option('runnerslog_show_gearmanager');
		$hrrest = get_option('runnerslog_hrrest');
		$hrmax = get_option('runnerslog_hrmax');
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
	}
?>

<div class="wrap">
<?php echo "<h2>" . __( 'Runners Log Options', 'runnerslog_ops' ) . "</h2>"; ?>
<p>Set the options below.</p>

<div class="tool-box">
<h3 class="title">Standard Options</h3>
<form name="runnerslog_ops_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="runnerslog_op_hidden" value="Y" />
	<table class="form-table">
		<tbody>
			<!-- Distance type: runnerslog_distancetype -->
			<tr valign="top">
				<th scope="row"><label for="runnerslog_distancetype"><?php _e('Distance type') ?></label></th>
				<td>
				<?php
				$type = '<select name="runnerslog_distancetype" id="runnerslog_distancetype" style="width: 100px;"><option value="meters"';
				if ( 'meters' == get_option('runnerslog_distancetype') ) $type .= ' selected="selected"';
				$type .= '>' . __('Meters') . '</option><option value="miles"';
				if ( 'miles' == get_option('runnerslog_distancetype') ) $type .= ' selected="selected"';
				$type .= '>' . __('Miles') . '</option></select>';
				echo $type;
				?>
				<span class="description"><u>Meters</u>, kg and cm Versus <u>Miles</u>, pounds, feets and inces</span>
				</td>
			</tr>
			
			<!-- Gender: runnerslog_gender -->	
			<tr valign="top">
				<th scope="row"><label for="runnerslog_gender"><?php _e('Gender') ?></label></th>
				<td>
				<?php
				$type = '<select name="runnerslog_gender" id="runnerslog_gender" style="width: 100px;"><option value="male"';
				if ( 'male' == get_option('runnerslog_gender') ) $type .= ' selected="selected"';
				$type .= '>' . __('Male') . '</option><option value="female"';
				if ( 'female' == get_option('runnerslog_gender') ) $type .= ' selected="selected"';
				$type .= '>' . __('Female') . '</option></select>';
				echo $type;
				?>
				<span class="description">Choose your gender</span>
				</td>
				</td>
			</tr>
			
			<!-- Your Height: If metric: runnerslog_cm  If english: runnerslog_feets AND runnerslog_inches-->
			<tr valign="top">
				<th scope="row"><label for="runnerslog_height"><?php _e('Your Height') ?></label></th>
				<td><?php
					if ( $distancetype == "meters" ) {
						echo '<input name="runnerslog_cm" type="text" id="runnerslog_cm"  value="', form_option('runnerslog_cm'), '" class="small-text" />';
						echo '<span class="description"> Centimeters</span>';
							} else {
						echo '<input name="runnerslog_feets" type="text" id="runnerslog_feets"  value="', form_option('runnerslog_feets'), '" class="small-text" />';
						echo '<span class="description"> Feet </span>';
						echo '<input name="runnerslog_inches" type="text" id="runnerslog_inches"  value="', form_option('runnerslog_inches'), '" class="small-text" />';
						echo '<span class="description"> Inc(es)</span>';
					}
					?>
				</td>
			</tr>
			
			<!-- Your Weight: runnerslog_weight -->
			<tr valign="top">
				<th scope="row"><label for="runnerslog_weight"><?php _e('Your Weight') ?></label></th>
				<td>
					<input name="runnerslog_weight" type="text" id="runnerslog_weight"  value="<?php form_option('runnerslog_weight'); ?>" class="small-text" />
					<span class="description"><?php 
													// print descript as either kg or pounds based on distancetype
													if ($distancetype == "meters") {
														_e('Kilograms') ;														;
													} else {
														_e('Pounds. Note: 8 ounces = 0.5 pounds') ; 
													}
											  ?></span>
				</td>
			</tr>
			
			<!-- Your age: runnerslog_age -->
			<tr valign="top">
				<th scope="row"><label for="runnerslog_age"><?php _e('Your age') ?></label></th>
				<td>
					<input name="runnerslog_age" type="text" id="runnerslog_age"  value="<?php form_option('runnerslog_age'); ?>" class="small-text" />
					<span class="description"><?php _e('Years') ?></span>
				</td>
			</tr>
			
			<!-- Resting Heart Rate: runnerslog_hrrest -->
			<tr valign="top">
				<th scope="row"><label for="runnerslog_hrrest"><?php _e('Resting Heart Rate') ?></label></th>
				<td>
					<input name="runnerslog_hrrest" type="text" id="runnerslog_hrrest"  value="<?php form_option('runnerslog_hrrest'); ?>" class="small-text" />
					<span class="description"><?php _e('"Resting Heart Rate" is the number of times our heart beats when we are at completely at rest.') ?></span>
				</td>
			</tr>
			
			<!-- Maximum Heart Rate: runnerslog_hrmax -->
			<tr valign="top">
				<th scope="row"><label for="runnerslog_hrmax"><?php _e('Maximum Heart Rate') ?></label></th>
				<td>
					<input name="runnerslog_hrmax" type="text" id="runnerslog_hrmax"  value="<?php form_option('runnerslog_hrmax'); ?>" class="small-text" />
					<span class="description"><?php _e('"Maximum Heart Rate" is the highest number of times your heart can contract in one minute.') ?></span>
				</td>
			</tr>

			<!-- Enable Pulse Average: runnerslog_pulsavg -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_pulsavg">
				<input name="runnerslog_pulsavg" id="runnerslog_pulsavg" value="1"<?php checked('1', get_option('runnerslog_pulsavg')); ?> type="checkbox">
				<?php _e('Enable Pulse Average') ?></label>
				</th>
			</tr>

			<!-- Enable Link to Garmin Connect: runnerslog_garminconnectlink -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_garminconnectlink">
				<input name="runnerslog_garminconnectlink" id="runnerslog_garminconnectlink" value="1"<?php checked('1', get_option('runnerslog_garminconnectlink')); ?> type="checkbox">
				<?php _e('Enable Link to Garmin Connect') ?></label>
				</th>
			</tr>
			
			<!-- Enable Calories Count: runnerslog_caloriescount -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_caloriescount">
				<input name="runnerslog_caloriescount" id="runnerslog_caloriescount" value="1"<?php checked('1', get_option('runnerslog_caloriescount')); ?> type="checkbox">
				<?php _e('Enable Calories Count') ?></label>
				</th>
			</tr>
			
			<!-- Enable Cadence: runnerslog_cadence -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_cadence">
				<input name="runnerslog_cadence" id="runnerslog_cadence" value="1"<?php checked('1', get_option('runnerslog_cadence')); ?> type="checkbox">
				<?php _e('Enable Cadence') ?></label>
				</th>
			</tr>
			
		</tbody>
	</table>
</div>
<div class="tool-box">
    <h3 class="title">Options for Gear Manager</h3>
	<table class="form-table">
		<tbody>
			<!-- Show Gear Manager -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_gearmanager">
				<input name="runnerslog_show_gearmanager" id="runnerslog_show_gearmanager" value="1"<?php checked('1', get_option('runnerslog_show_gearmanager')); ?> type="checkbox">
				<?php _e('Enable Gear Manager') ?></label>
				<span class="description"><?php _e('Your must reload the page eg. press F5 after changing this setting') ?></span>
				</th>
			</tr>
		</tbody>
	</table>
</div>
<div class="tool-box">
    <h3 class="title">Options for [runners_log_basic]</h3>
	<table class="form-table">
		<tbody>
			<!-- Show distance: runnerslog_show_distance -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance">
				<input name="runnerslog_show_distance" id="runnerslog_show_distance" value="1"<?php checked('1', get_option('runnerslog_show_distance')); ?> type="checkbox">
				<?php _e('Show Distance') ?></label>
				</th>
			</tr>

			<!-- Show time: runnerslog_show_time -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_time">
				<input name="runnerslog_show_time" id="runnerslog_show_time" value="1"<?php checked('1', get_option('runnerslog_show_time')); ?> type="checkbox">
				<?php _e('Show Time') ?></label>
				</th>
			</tr>

			<!-- Show speed: runnerslog_show_speed -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_speed">
				<input name="runnerslog_show_speed" id="runnerslog_show_speed" value="1"<?php checked('1', get_option('runnerslog_show_speed')); ?> type="checkbox">
				<?php _e('Show Speed') ?></label>
				</th>
			</tr>

			<!-- Show speedperdistance: runnerslog_show_speedperdistance -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_speedperdistance">
				<input name="runnerslog_show_speedperdistance" id="runnerslog_show_speedperdistance" value="1"<?php checked('1', get_option('runnerslog_show_speedperdistance')); ?> type="checkbox">
				<?php _e('Show Speed per Distance') ?></label>
				</th>
			</tr>

			<!-- Show pulse: runnerslog_show_pulse -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_pulse">
				<input name="runnerslog_show_pulse" id="runnerslog_show_pulse" value="1"<?php checked('1', get_option('runnerslog_show_pulse')); ?> type="checkbox">
				<?php _e('Show Pulse Average') ?></label>
				</th>
			</tr>

			<!-- Show calories: runnerslog_show_calories -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_calories">
				<input name="runnerslog_show_calories" id="runnerslog_show_calories" value="1"<?php checked('1', get_option('runnerslog_show_calories')); ?> type="checkbox">
				<?php _e('Show Calories') ?></label>
				</th>
			</tr>
			
			<!-- Show cadence: runnerslog_show_cadence -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_cadence">
				<input name="runnerslog_show_cadence" id="runnerslog_show_cadence" value="1"<?php checked('1', get_option('runnerslog_show_cadence')); ?> type="checkbox">
				<?php _e('Show Cadence') ?></label>
				</th>
			</tr>

			<!-- Show link to garmin connect: runnerslog_show_garminconnect -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_garminconnect">
				<input name="runnerslog_show_garminconnect" id="runnerslog_show_garminconnect" value="1"<?php checked('1', get_option('runnerslog_show_garminconnect')); ?> type="checkbox">
				<?php _e('Show link to Garmin Connect') ?></label>
				</th>
			</tr>

			<!-- Show distance 2009: runnerslog_show_distance2009 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2009">

				<input name="runnerslog_show_distance2009" id="runnerslog_show_distance2009" value="1"<?php checked('1', get_option('runnerslog_show_distance2009')); ?> type="checkbox">
				<?php _e('Show Distance in 2009') ?></label>
				</th>
			</tr>

			<!-- Show distance 2010: runnerslog_show_distance2010 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2010">
				<input name="runnerslog_show_distance2010" id="runnerslog_show_distance2010" value="1"<?php checked('1', get_option('runnerslog_show_distance2010')); ?> type="checkbox">
				<?php _e('Show Distance in 2010') ?></label>
				</th>
			</tr>
            
			<!-- Show distance 2011: runnerslog_show_distance2011 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2011">
				<input name="runnerslog_show_distance2011" id="runnerslog_show_distance2011" value="1"<?php checked('1', get_option('runnerslog_show_distance2011')); ?> type="checkbox">
				<?php _e('Show Distance in 2011') ?></label>
				</th>
			</tr>

			<!-- Show distance 2012: runnerslog_show_distance2012 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2012">
				<input name="runnerslog_show_distance2012" id="runnerslog_show_distance2012" value="1"<?php checked('1', get_option('runnerslog_show_distance2012')); ?> type="checkbox">
				<?php _e('Show Distance in 2012') ?></label>
				</th>
			</tr>

			<!-- Show distance 2013: runnerslog_show_distance2013 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2013">
				<input name="runnerslog_show_distance2013" id="runnerslog_show_distance2013" value="1"<?php checked('1', get_option('runnerslog_show_distance2013')); ?> type="checkbox">
				<?php _e('Show Distance in 2013') ?></label>
				</th>
			</tr>

			<!-- Show distance 2014: runnerslog_show_distance2014 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2014">
				<input name="runnerslog_show_distance2014" id="runnerslog_show_distance2014" value="1"<?php checked('1', get_option('runnerslog_show_distance2014')); ?> type="checkbox">
				<?php _e('Show Distance in 2014') ?></label>
				</th>
			</tr>

			<!-- Show distance 2015: runnerslog_show_distance2015 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2015">
				<input name="runnerslog_show_distance2015" id="runnerslog_show_distance2015" value="1"<?php checked('1', get_option('runnerslog_show_distance2015')); ?> type="checkbox">
				<?php _e('Show Distance in 2015') ?></label>
				</th>
			</tr>

			<!-- Show distance 2016: runnerslog_show_distance2016 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2016">
				<input name="runnerslog_show_distance2016" id="runnerslog_show_distance2016" value="1"<?php checked('1', get_option('runnerslog_show_distance2016')); ?> type="checkbox">
				<?php _e('Show Distance in 2016') ?></label>
				</th>
			</tr>

			<!-- Show distance 2017: runnerslog_show_distance2017 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2017">
				<input name="runnerslog_show_distance2017" id="runnerslog_show_distance2017" value="1"<?php checked('1', get_option('runnerslog_show_distance2017')); ?> type="checkbox">
				<?php _e('Show Distance in 2017') ?></label>
				</th>
			</tr>

			<!-- Show distance 2018: runnerslog_show_distance2018 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2018">
				<input name="runnerslog_show_distance2018" id="runnerslog_show_distance2018" value="1"<?php checked('1', get_option('runnerslog_show_distance2018')); ?> type="checkbox">
				<?php _e('Show Distance in 2018') ?></label>
				</th>
			</tr>

			<!-- Show distance 2019: runnerslog_show_distance2019 -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance2019">
				<input name="runnerslog_show_distance2019" id="runnerslog_show_distance2019" value="1"<?php checked('1', get_option('runnerslog_show_distance2019')); ?> type="checkbox">
				<?php _e('Show Distance in 2019') ?></label>
				</th>
			</tr>

			<!-- Show distance at all: runnerslog_show_distance_sum -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_distance_sum">
				<input name="runnerslog_show_distance_sum" id="runnerslog_show_distance_sum" value="1"<?php checked('1', get_option('runnerslog_show_distance_sum')); ?> type="checkbox">
				<?php _e('Show Distance at All') ?></label>
				</th>
			</tr>

			<!-- Show embed garmin map: runnerslog_show_garminmap -->
			<tr>
				<th scope="row" colspan="2" class="th-full">
				<label for="runnerslog_show_garminmap">
				<input name="runnerslog_show_garminmap" id="runnerslog_show_garminmap" value="1"<?php checked('1', get_option('runnerslog_show_garminmap')); ?> type="checkbox">
				<?php _e('Show embed Garmin Map') ?></label>
				</th>
			</tr>			
		</tbody>
	</table>
</div>
	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Save and update options', 'runnerslog_ops' ) ?>" />
	</p>
</form>
</div>
