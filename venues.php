<?php
	require_once('constants.php');

	if(isset($_GET['city']) && isset($_GET['store']))
	{
		$url = 'https://api.foursquare.com/v2/venues/';
		$url .= 'suggestCompletion?near=';
		$url .= urlencode($_GET['city']);
		$url .= '&query=';
		$url .= urlencode($_GET['store']);
		$url .= '&limit=5';
		$url .= "&client_id={$clientID}";
		$url .= "&client_secret={$clientSecret}";
		$url .= "&v={$date}";
		$json = file_get_contents($url);
		$data = json_decode($json, TRUE);
	}
?>

<html>
	<head>
		<title>FourSquare API Test</title>
	</head>
	<body>
		<h1>Get Venues From FourSquare!</h1>
		<p>Enter name and city/state to find venues on FourSquare. </p>
		
		<form action="">
			<p>
				Store name (ex. Tios)<br />
				<input type="text" name="store" /> <br />
				City, State (ex. Ann Arbor, MI):<br />
				<input type="text" name="city" /> <br />
				<input type="submit">
			</p>
		</form>
		<?php
			if(isset($url) && !empty($data)) {
				
				foreach ($data['response'] as $venues) {
					foreach($venues as $venue) {
						echo '<p>';
						echo $venue['name'];
						echo '<br />';
						echo $venue['location']['address'] . '<br />';
						echo $venue['location']['city'] . ', ' . $venue['location']['state'] . '<br />';
						echo 'ID: ' . $venue['id'] . '<br />';
						echo '</p>';
					}
					echo '<br />';
				}
			}
			
		?>
	</body>
</html>