<div class="wrap">
<?php 

echo "<h2>" . __( 'Runners Log - HR Training Zones Calculator', RUNNERSLOG). "</h2>"; ?>
<?php 
//Get the hrrest and hrmax
$hrrest = get_option('runnerslog_hrrest');
$hrmax = get_option('runnerslog_hrmax');

//Let us calculate the HR limits
//We use the formular: Target Heart Rate = ((Maximum Heart Rate – Resting Heart Rate) × %Intensity) + Resting Heart Rate
$hrr50 = ROUND((($hrmax-$hrrest)*0.5)+$hrrest,0);  	// 50% of HRR
$hrr55 = ROUND((($hrmax-$hrrest)*0.55)+$hrrest,0);  // 55% of HRR
$hrr60 = ROUND((($hrmax-$hrrest)*0.6)+$hrrest,0);	// 60% of HRR
$hrr65 = ROUND((($hrmax-$hrrest)*0.65)+$hrrest,0);  // 65% of HRR
$hrr70 = ROUND((($hrmax-$hrrest)*0.7)+$hrrest,0);	// 70% of HRR
$hrr75 = ROUND((($hrmax-$hrrest)*0.75)+$hrrest,0);  // 75% of HRR
$hrr80 = ROUND((($hrmax-$hrrest)*0.8)+$hrrest,0);	// 80% of HRR
$hrr85 = ROUND((($hrmax-$hrrest)*0.85)+$hrrest,0);  // 85% of HRR
$hrr90 = ROUND((($hrmax-$hrrest)*0.9)+$hrrest,0);	// 90% of HRR
$hrr95 = ROUND((($hrmax-$hrrest)*0.95)+$hrrest,0);  // 95% of HRR
$hrr100 = ROUND((($hrmax-$hrrest)*1)+$hrrest,0);	// 100% of HRR

if ( $hrrest AND $hrmax ) {
echo '<p>'.__('Based on a Resting Heart Rate at <b>', RUNNERSLOG).$hrrest.'</b> '. __('and a Maximum Heart Rate at <b>', RUNNERSLOG) .$hrmax.'</b> '. __('the commanded training zones are:', RUNNERSLOG).'</p>';
echo '
<h2>
	'. __('Heart Rate Training Zones (Beginner)', RUNNERSLOG).'</h2>
<table cellpadding="0" cellspacing="0" class="cooper" style="width: 700px;">
	<tbody>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 70px; text-align: center;">
				<strong>'. __('Pulse Zone', RUNNERSLOG).'</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>'. __('Pulse', RUNNERSLOG).'</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 70px; text-align: center;">
				<strong>'. __('% of HRR', RUNNERSLOG).'<br />
				</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 120px; text-align: center;">
				<strong>'. __('Type', RUNNERSLOG).'</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 380px; text-align: center;">
				<strong>'. __('What it does', RUNNERSLOG).'<br />
				</strong></td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 255, 0); width: 70px; text-align: center;">
				<strong>1</strong></td>
			<td style="background-color: rgb(255, 255, 0); width: 60px; text-align: center;">
				'.$hrr50.'-'.$hrr60.'</td>
			<td style="background-color: rgb(255, 255, 0); width: 70px; text-align: center;">
				50-60%</td>
			<td style="background-color: rgb(255, 255, 0); width: 120px; text-align: center;">
				'. __('Moderate activity', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 255, 0); width: 380px; text-align: center;">
				'. __('Maintenance or warm up', RUNNERSLOG).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 204, 0); width: 70px; text-align: center;">
				<strong>2</strong></td>
			<td style="background-color: rgb(255, 204, 0); width: 60px; text-align: center;">
				'.$hrr60.'-'.$hrr70.'</td>
			<td style="background-color: rgb(255, 204, 0); width: 70px; text-align: center;">
				60-70%</td>
			<td style="background-color: rgb(255, 204, 0); width: 120px; text-align: center;">
				'. __('The Energy Efficient or Recovery Zone', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 204, 0); width: 380px; text-align: center;">
				'. __('Training within this zone develops basic endurance and aerobic capacity.', RUNNERSLOG).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 153, 0); width: 70px; text-align: center;">
				<strong>3</strong></td>
			<td style="background-color: rgb(255, 153, 0); width: 60px; text-align: center;">
				'.$hrr70.'-'.$hrr80.'</td>
			<td style="background-color: rgb(255, 153, 0); width: 70px; text-align: center;">
				70-80%</td>
			<td style="background-color: rgb(255, 153, 0); width: 120px; text-align: center;">
				'. __('The Aerobic Zone', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 153, 0); width: 380px; text-align: center;">
				'. __('Training in this zone will develop your cardiovascular system (Also Known As: cardio zone). Train the ability to transport oxygen to, and carbon dioxide away from, the working muscles.', RUNNERSLOG).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 51, 0); width: 70px; text-align: center;">
				<strong>4</strong></td>
			<td style="background-color: rgb(255, 51, 0); width: 60px; text-align: center;">
				'.$hrr80.'-'.$hrr90.'</td>
			<td style="background-color: rgb(255, 51, 0); width: 70px; text-align: center;">
				80-90%</td>
			<td style="background-color: rgb(255, 51, 0); width: 120px; text-align: center;">
				'.__('The Anaerobic Zone', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 51, 0); width: 380px; text-align: center;">
				'.__('Training in this zone will develop your lactic acid system. The point at which the body cannot remove lactic acid as quickly as it is produced is called the lactate threshold (LT) or anaerobic threshold (AT).', RUNNERSLOG).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 0, 0); width: 70px; text-align: center;">
				<strong>5</strong></td>
			<td style="background-color: rgb(255, 0, 0); width: 60px; text-align: center;">
				'.$hrr90.'-'.$hrr100.'</td>
			<td style="background-color: rgb(255, 0, 0); width: 60px; text-align: center;">
				90-100%</td>
			<td style="background-color: rgb(255, 0, 0); width: 60px; text-align: center;">
				VO<sub>2</sub>max or &quot;Red line zone&quot;</td>
			<td style="background-color: rgb(255, 0, 0); width: 380px; text-align: center;">
				'.__('It effectively trains your fast twitch muscle fibres and helps to develop speed. This zone is reserved for interval running.', RUNNERSLOG).'</td>
		</tr>
	</tbody>
</table>
<br />
<h2>
	Heart Rate Training Zones (Elite)</h2>
<table cellpadding="0" cellspacing="0" class="cooper" style="width: 700px;">
	<tbody>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 70px; text-align: center;">
				<strong>'.__('Pulse Zone', RUNNERSLOG).'</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>'.__('Pulse', RUNNERSLOG).'</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 70px; text-align: center;">
				<strong>'.__('% of HRR', RUNNERSLOG).'<br />
				</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 120px; text-align: center;">
				<strong>'.__('Type', RUNNERSLOG).'</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 380px; text-align: center;">
				<strong>'.__('What it does', RUNNERSLOG).'<br />
				</strong></td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 255, 0); width: 70px; text-align: center;">
				<strong>1</strong></td>
			<td style="background-color: rgb(255, 255, 0); width: 60px; text-align: center;">
				'.$hrr55.'-'.$hrr65.'</td>
			<td style="background-color: rgb(255, 255, 0); width: 70px; text-align: center;">
				55-65%</td>
			<td style="background-color: rgb(255, 255, 0); width: 120px; text-align: center;">
				'.__('Moderate activity', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 255, 0); width: 380px; text-align: center;">
				'.__('Maintenance or warm up', RUNNERSLOG).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 204, 0); width: 70px; text-align: center;">
				<strong>2</strong></td>
			<td style="background-color: rgb(255, 204, 0); width: 60px; text-align: center;">
				'.$hrr65.'-'.$hrr75.'</td>
			<td style="background-color: rgb(255, 204, 0); width: 70px; text-align: center;">
				65-75%</td>
			<td style="background-color: rgb(255, 204, 0); width: 120px; text-align: center;">
				'.__('The Energy Efficient or Recovery Zone', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 204, 0); width: 380px; text-align: center;">
				'.__('Training within this zone develops basic endurance and aerobic capacity.', RUNNERSLOG).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 153, 0); width: 70px; text-align: center;">
				<strong>3</strong></td>
			<td style="background-color: rgb(255, 153, 0); width: 60px; text-align: center;">
				'.$hrr75.'-'.$hrr85.'</td>
			<td style="background-color: rgb(255, 153, 0); width: 70px; text-align: center;">
				75-85%</td>
			<td style="background-color: rgb(255, 153, 0); width: 120px; text-align: center;">
				'.__('The Aerobic Zone', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 153, 0); width: 380px; text-align: center;">
				'.__('Training in this zone will develop your cardiovascular system (Also Known As: cardio zone). Train the ability to transport oxygen to, and carbon dioxide away from, the working muscles.', RUNNERSLOG).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 51, 0); width: 70px; text-align: center;">
				<strong>4</strong></td>
			<td style="background-color: rgb(255, 51, 0); width: 60px; text-align: center;">
				'.$hrr85.'-'.$hrr95.'</td>
			<td style="background-color: rgb(255, 51, 0); width: 70px; text-align: center;">
				85-95%</td>
			<td style="background-color: rgb(255, 51, 0); width: 120px; text-align: center;">
				'.__('The Anaerobic Zone', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 51, 0); width: 380px; text-align: center;">
				'.__('Training in this zone will develop your lactic acid system. The point at which the body cannot remove lactic acid as quickly as it is produced is called the lactate threshold (LT) or anaerobic threshold (AT).', RUNNERSLOG).'</td>
		</tr>
		<tr>
			<td style="background-color: rgb(255, 0, 0); width: 70px; text-align: center;">
				<strong>5</strong></td>
			<td style="background-color: rgb(255, 0, 0); width: 60px; text-align: center;">
				'.$hrr95.'-'.$hrr100.'</td>
			<td style="background-color: rgb(255, 0, 0); width: 60px; text-align: center;">
				95-100%</td>
			<td style="background-color: rgb(255, 0, 0); width: 60px; text-align: center;">
				'.__('VO<sub>2</sub>max or &quot;Red line zone&quot;', RUNNERSLOG).'</td>
			<td style="background-color: rgb(255, 0, 0); width: 380px; text-align: center;">
				'.__('It effectively trains your fast twitch muscle fibres and helps to develop speed. This zone is reserved for interval running.', RUNNERSLOG).'</td>
		</tr>
	</tbody>
</table>';
		} else {
	_e('<p>To calculate <b>YOUR</b> traing zones you have to type in your resting pulse and max pulse in Runners Log Settings.</p>', RUNNERSLOG);	
}
?>
</div>
