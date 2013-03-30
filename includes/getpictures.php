<?php
	require_once('constants.php');

	if(isset($_GET['venue'])) {
		$venue = $_GET['venue'];
		$url = 'https://api.foursquare.com/v2/venues/' 
			. $venue
			.'?photos'
			. '&client_id='
			. $clientID
			. '&client_secret=' 
			. $clientSecret
			. '&v='
			. $date;

		$json = file_get_contents($url);
		echo $json;
	}
?>
