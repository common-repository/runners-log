<?php
//retrieve information from Yahoo Weather channel depending on selected WOEID

function runnerslog_retrieveWeather($woid,$unit,$thingToMeasure) {
	
	if (get_option('runnerslog_weather_yahoo') == 0) {
		return '';
	}

	$weather_feed = file_get_contents('http://weather.yahooapis.com/forecastrss?w='.$woid.'&u='.$unit.'');
	if(!$weather_feed) die('weather failed, check feed URL');
	$weather = simplexml_load_string($weather_feed);

	$channel_yweather = $weather->channel->children('http://xml.weather.yahoo.com/ns/rss/1.0');
		foreach($channel_yweather as $x => $channel_item)
			foreach($channel_item->attributes() as $k => $attr)
				$yw_channel[$x][$k] = $attr;
		
	$item_yweather = $weather->channel->item->children('http://xml.weather.yahoo.com/ns/rss/1.0');
		foreach($item_yweather as $x => $yw_item) {
			foreach($yw_item->attributes() as $k => $attr) {
				if($k == 'day') $day = $attr;
				if($x == 'forecast') { $yw_forecast[$x][$day . ''][$k] = $attr;	} 
				else { $yw_forecast[$x][$k] = $attr; }
			}
		}

	//depending on what data is requested the selected value is returned		
	switch($thingToMeasure){
		
		case 'humidity':
		$result = $yw_channel[atmosphere][humidity];
		break;
		
		case 'windchill':
		$result = $yw_channel[wind][chill];
		break;
		
		case 'temperature':
		$result = $yw_forecast[condition][temp];
		break;
		
		case 'description':
		$result = $yw_forecast[condition][text];
		break;
		
		case 'city':
		$result = $yw_channel[location][city];
		break;
		
		/*
		echo '<div id="weather">';
		echo 'city: '.$yw_channel[location][city].'<br />';
		echo 'humidity: '.$yw_channel[atmosphere][humidity].'%<br />';
		echo 'wind chill: '.$yw_channel[wind][chill].'<br />';
		echo 'wind direction: '.$yw_channel[wind][direction].'<br />';
		echo 'wind speed:  '.$yw_channel[wind][speed].'<br />';
		echo '</div>';
		*/
		
		
		/*
		echo '<div id="weather">';
		echo 'temperature: '.$yw_forecast[condition][temp].'<br />';
		echo 'weather: '.$yw_forecast[condition][text].'<br />';
		echo '</div>';
		return $yw_forecast[condition][temp];
		* */
	}
	return $result;
}
?>
