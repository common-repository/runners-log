<div class="wrap">
<?php echo "<h2>" . __( 'Runners Log V0<sub>2</sub>maxulator Calculator', 'RUNNERSLOG' ) . "</h2>"; ?>
<?php
$distancetype = get_option('runnerslog_distancetype');
$coopers = get_option('runnerslog_coopers');
$gender = get_option('runnerslog_gender');
$weight = get_option('runnerslog_weight');
$age = get_option('runnerslog_age');
?>

<?php 
	if($_POST['runnerslog_op_hidden'] == 'Y') {
		//Form data sent
		$coopers = $_POST['runnerslog_coopers'];
		update_option('runnerslog_coopers', $coopers);
		?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
		<?php
	} else {
		//Normal page display
		$coopers = get_option('runnerslog_coopers');
	}
?>

<h3>The Cooper test is a test of physical fitness. It was designed by Kenneth H. Cooper in 1968 for US military use. In the original form, the point of the test is to run as far as possible within 12 minutes.</h3>

<form name="RUNNERSLOG_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="runnerslog_op_hidden" value="Y" />
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row"><label for="runnerslog_coopers"><?php _e('Distance in 12 min:') ?></label></th>
				<td><?php
					if ( $distancetype == meters ) {
						echo '<input name="runnerslog_coopers" type="text" id="runnerslog_coopers"  value="', form_option('runnerslog_coopers'), '" class="small-text" />';
						echo '<span class="description"> Meters (eg 2500)</span>';
							} else {
						echo '<input name="runnerslog_coopers" type="text" id="runnerslog_coopers"  value="', form_option('runnerslog_coopers'), '" class="small-text" />';
						echo '<span class="description"> Miles (eg. 1.58)</span>';
					}
					?>
				</td>
			</tr>			
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Calculate Vo2-max', 'RUNNERSLOG' ) ?>" />
	</p>
</form>
</div>

<?php
//VO2 max = (gender*0.05 + 1) * (meters_12_minutes - 504.9) / 44.73
//1mile in km = 1.609344
//1 pound in kg = 0.45359237

if ( $gender == male ) {
	$gendervalue = '0';
		} else {
	$gendervalue = '1';
}

if ($distancetype == meters) {
	$v02max = ($gendervalue*0.05 + 1)*($coopers - 504.9)/44.73; 
	$distancelang = 'meters';
		} else {
	$v02max = ($gendervalue*0.05 + 1)*(($coopers*1609.344) - 504.9)/44.73;
	$distancelang = 'miles';
}

if ($distancetype == meters) {
	$weight = $weight;
	$weightlang = 'kg';
	$weightinkg = $weight*1;
	$absorption02 = $v02max*$weightinkg/1000;
		} else {
	$weight = $weight;
	$weightlang = 'pounds';
	$weightinkg = $weight*0.45359237;
	$absorption02 = $v02max*$weightinkg/1000;
}
 
if ( $coopers && $gender && $weight ) {
	echo 'Based on your gender <b>',$gender,'</b> and your weight <b>',$weight,'</b> <b>',$weightlang,'</b> and the distance <b>',$coopers,'</b> <b>',$distancelang,'</b> in 12min gives you the following "V0<sub>2</sub>max" and "absorption of oxygen value".';
	echo '<p>V0<sub>2</sub>max <b>',ROUND($v02max,1),'</b> ml/kg/min</p>';
	echo '<p>Absorption of oxygen <b>',ROUND($absorption02,1),'</b> l/min</p>';
	echo '<p>Below you can compare the V0<sub>2</sub>max with your age. You find a chart for men, women and elite.</p>';
		} else {
	echo 'To calculate your "V0<sub>2</sub>max" and "Absorption of oxygen value" you need to specify your weight and gender in the settings. And a distance above.';
}
?>

<h2>Male - Beginner</h2>
<table cellpadding="0" cellspacing="0" style="width: 510px;">
	<tbody>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>Age</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 70px; text-align: center;">
				<strong>Very Low</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>Low</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>Fair</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>Average</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>High</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 80px; text-align: center;">
				<strong>Very High</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>Excellent</strong></td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>20-24</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 32</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				32-37</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				38-43</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				44-50</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				51-56</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				57-62</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 62</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>25-29</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 31</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				31-35</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				36-42</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				43-48</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				49-53</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				54-59</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 59</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>30-34</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 29</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				29-34</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				35-40</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				41-45</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				46-51</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				52-56</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 56</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>35-39</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 28</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				28-32</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				33-38</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				39-43</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				44-48</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				49-54</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 54</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>40-44</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 26</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				26-31</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				32-35</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				36-41</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				42-46</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				47-51</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 51</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>45-49</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 25</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				25-29</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				30-34</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				35-39</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				40-43</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				44-48</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 48</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>50-54</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 24</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				24-27</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				28-32</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				33-46</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				37-41</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				42-46</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 46</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>55-59</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 22</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				22-26</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				27-30</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				31-34</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				35-39</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				40-43</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 43</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>60-65</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 21</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				21-24</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				25-28</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				29-32</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				33-36</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				37-40</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 40</td>
		</tr>
	</tbody>
</table>

<h2>Female - Beginner</h2>
<table cellpadding="0" cellspacing="0" style="width: 510px;">
	<tbody>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>Age</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 70px; text-align: center;">
				<strong>Very Low</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>Low</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>Fair</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>Average</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>High</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 80px; text-align: center;">
				<strong>Very High</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 60px; text-align: center;">
				<strong>Excellent</strong></td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>20-24</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 27</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				27-31</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				32-36</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				37-41</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				42-46</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				47-51</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 51</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>25-29</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 26</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				26-30</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				31-35</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				36-40</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				41-44</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				45-49</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 49</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>30-34</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 25</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				25-29</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				30-33</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				34-37</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				38-42</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				43-46</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 46</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>35-39</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 24</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				24-27</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				28-31</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				32-35</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				36-40</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				41-44</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 44</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>40-44</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 22</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				22-25</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				26-29</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				30-33</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				34-37</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				38-41</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 41</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>45-49</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 21</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				21-23</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				24-27</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				28-31</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				32-35</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				36-38</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 38</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>50-54</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 19</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				19-22</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				23-25</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				26-29</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				30-32</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				33-36</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 36</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>55-59</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 18</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				18-20</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				21-23</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				24-27</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				28-30</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				31-33</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 33</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 60px;">
				<strong>60-65</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 70px; text-align: center;">
				&lt; 16</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				16-18</td>
			<td style="background-color: rgb(255, 255, 153); width: 60px; text-align: center;">
				19-21</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				22-24</td>
			<td style="background-color: rgb(153, 255, 204); width: 60px; text-align: center;">
				25-27</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px; text-align: center;">
				28-30</td>
			<td style="background-color: rgb(119, 170, 255); width: 60px; text-align: center;">
				&gt; 30</td>
		</tr>
	</tbody>
</table>

<h2>Elite</h2>
<table cellpadding="0" cellspacing="0" style="width: 480px;">
	<tbody>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 80px;">
				&nbsp;</td>
			<td style="background-color: rgb(128, 128, 128); width: 80px;">
				<strong>Very Low</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 80px;">
				<strong>Low</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 80px;">
				<strong>Average</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 80px;">
				<strong>High</strong></td>
			<td style="background-color: rgb(128, 128, 128); width: 80px;">
				<strong>Very High</strong></td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 80px;">
				<strong>Men</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 80px;">
				&lt; 60</td>
			<td style="background-color: rgb(255, 255, 153); width: 80px;">
				60-70</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px;">
				70-80</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px;">
				80-90</td>
			<td style="background-color: rgb(119, 170, 255); width: 80px;">
				&gt; 90</td>
		</tr>
		<tr>
			<td style="background-color: rgb(128, 128, 128); width: 80px;">
				<strong>Women</strong></td>
			<td style="background-color: rgb(255, 102, 102); width: 80px;">
				&lt; 50</td>
			<td style="background-color: rgb(255, 255, 153); width: 80px;">
				50-58</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px;">
				58-64</td>
			<td style="background-color: rgb(153, 255, 204); width: 80px;">
				64-72</td>
			<td style="background-color: rgb(119, 170, 255); width: 80px;">
				&gt; 72</td>
		</tr>
	</tbody>
</table>
