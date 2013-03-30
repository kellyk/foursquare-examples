<?php
	require_once('constants.php');

	if(isset($_GET['query'])) {

		$query = $_GET['query'];
		$url = 'https://api.foursquare.com/v2/venues/' 
			. 'suggestCompletion?'
			. 'near=48103'
			. '&radius=12000'
			. '&limit=5' 
			. '&client_id='
			. $clientID
			. '&client_secret=' 
			. $clientSecret
			. '&v='
			. $date
			. '&query='
			. $query;

		$json = file_get_contents($url);
		echo $json;
	}
?>
