<div class="wrap">
<p><?php 

echo "<h2>" . __( 'Runners Log - Body Mass Calculator' ) . "</h2>"; ?></p>

<?php 
$distancetype = get_option('runnerslog_distancetype');

//Get the values needed to calculate the BMI
if ($distancetype == meters) {
	$heightcm = get_option('runnerslog_cm');
		} else {
	$heightfeets = get_option('runnerslog_feets');
	$heightinches = get_option('runnerslog_inches');
}
$weight = get_option('runnerslog_weight');

if ( $distancetype == meters ) {
	if ( $weight && $heightcm) {
		$bmi = ROUND($weight/(($heightcm/100)*($heightcm/100)),2); 
		// For meters we use the formular: BMI kg/m^2 = weight in kilograms / height in meters^2
	}
		} else {
	if ( $weight && $heightfeets && $heightinches) {
		$bmi = ROUND(($weight*703)/((($heightfeets*12)+$heightinches)*(($heightfeets*12)+$heightinches)),2); 
		//formular: BMI = (weight in pounds * 703 ) / (height in inches)^2
	}
}
if ( $bmi < 18.5 ) {
	$weightstatus = 'Underweight';
}
if ($bmi >= 18.5 && $bmi < 25) {
	$weightstatus = 'Normal';
}
if ($bmi >= 25 && $bmi < 30) {
	$weightstatus = 'Overweight';
}
if ($bmi >= 30 && $bmi < 35) {
	$weightstatus = 'Obesity grade I';
}
if ($bmi >= 35 && $bmi < 40) {
	$weightstatus = 'Obesity grade II';
}
if ($bmi >= 40) {
	$weightstatus = 'Obesity grade III';
}	

//Print the heigt and weight
if ( $distancetype == meters ) {
	if ( $weight AND $heightcm ) {
		echo 'Your height is set to: ';
		echo '<b>' .$heightcm. '</b>';
		echo ' centimeters <br/>';
		echo 'And your weight to: ';
		echo '<b>' .$weight. '</b>';
		echo ' kg<br/>';
		echo '<p>Your Body Mass Index is <b>',$bmi,'</b> indicating your weight is <b>',$weightstatus,'</b> for adults of your height</p>';
	} else {
		echo '<p>To calculate <b>YOUR</b> BMI you have to type in your weight and height in Runners Log Settings</p>';
	}
 } else {
	if ( $heightfeets AND $heightinches ) {
		echo 'Your height is set to: ';
		echo '<b>' .$heightfeets. '</b>';
		echo ' feet ';
		echo '<b>' .$heightinches. '</b>';
		echo ' inch(es)<br/>';
		echo 'and your weight to: ';
		echo '<b>' .$weight. '</b>';
		echo ' pounds</br>';
		echo '<p>Your Body Mass Index is <b>',$bmi,'</b> indicating your weight is <b>',$weightstatus,'</b> for adults of your height</p>';
	} else {
		echo '<p>To calculate <b>YOUR</b> BMI you have to type in your weight and height in Runners Log Settings</p>';	
	}
}

?>

<p><b>BMI Categories: </b></p> 
<ul> 
  <li>Underweight = &lt;18.5</li> 
  <li>Normal weight = 18.5-25 </li> 
  <li>Overweight = 25-30 </li> 
  <li>Obesity = BMI of 30 or greater </li> 
</ul> 

</div>
