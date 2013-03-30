<?php
	// File: photos.php
	// Description: This page allows users to search for specific foursquare 
	// 		venues (by ID), and displays the pictures on the page.
	// 		The only real FourSquare specific concept to notice is the structure of the
	//		URL request, which returns a JSON object with result of search

	require_once('./includes/constants.php');

	if(isset($_GET['venue']))
	{
		$url = 'https://api.foursquare.com/v2/venues/';
		$url .= $_GET['venue'];
		$url .= '/photos?';
		$url .= "client_id={$clientID}";
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
		<h1>Get Photos From FourSquare!</h1>
		<p>
			Example IDs: 
			<ul>
				<li>Wide World Sports, Ann Arbor: 4b4a135af964a520d57926e3</li>
				<li>Tios Restaurant, Ann Arbor: 4a4e4460f964a52039ae1fe3</li>
			</ul>
		</p>
		<form action="">
			<p>Enter Venue ID:</p>
			<input type="text" name="venue" />
			<input type="submit">
		</form>
		
		<?php
			if(!empty($data)) {
				//Note that the FourSquare API returns an image suffix and prefix. 
				//In between, you specify what size width you want the image.
				foreach ($data['response']['photos']['items'] as $pictureID => $picture) {
					echo '<img src="' . $picture['prefix'] . 'width540' . $picture['suffix'] .'" />';
				}
			}
		?>
		
	</body>
</html>