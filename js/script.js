
$(document).ready(function() {
	var url = './includes/getdata.php?query=';
	var datacache = "";
	var reset;

	//read keyboard with jquery
	$('#search').keyup(function() {
		var output;
		//reset var is set to true when old data doesn't match new, and we need to overwrite
		if(reset) { 
			output = ""; 
			$('#update').html(output); 
		}

		//build query from #search div as user types
		var query = $('#search').val(); 
		if (query.length >= 3) { 
			$.getJSON(url+query, function(data) {
				//create output from json object
				for(var i = 0; i <  data['response']['minivenues'].length; i++) 
			 	{
			 		// wrap li with foursquare link
			 		output	+= '<a href="https://foursquare.com/v/' 
			 				+ data['response']['minivenues'][i].id 
			 				+ '"><li>';

			 		//create unique div for associated image to be written
			 		output += '<div class="ajaxSearchImage' 
			 				+ (data['response']['minivenues'][i].id) 
			 				+ '"></div>';

			 		output += (data['response']['minivenues'][i].name);
			 		output += '<br />';

			 		//some venues do not have address
			 		var address = (data['response']['minivenues'][i]['location'].address);
			 		var city = (data['response']['minivenues'][i]['location'].city);
			 		var state = (data['response']['minivenues'][i]['location'].state);

					if(address.length > 0) {
						output += address +  "<br />";
					}
					if(city.length > 0) {
						output += city + ", ";
					}
					if(state.length>0) {
						output += state;
					}
			 		output += "</li></a>";
			 	}

			 	//Insert list into DOM if it has not changed
			 	if(datacache != output) {
			 		var newOutput = output.replace("undefined",""); //hack. need to figure out where undefined is coming from
					$('#update').html("<ul>" + newOutput + "</ul>"); 
				}
				else reset = false;

				//if empty reponse is returned, need to reload as empty div
				if(data['response']['minivenues'].length <1) {
					reset = true;
				}
				datacache = output;

				//Iterate through json response again to set images. Must occur afterward to match class names
				for(var i = 0; i <  data['response']['minivenues'].length; i++) 
			 	{
					var picRequestURL = './includes/getpictures.php?venue='
									  + data['response']['minivenues'][i].id;
					
					$.getJSON(picRequestURL, function(data) {
						getImage(data);
					});
				} 
			}); 
		} 
	});

	function getImage(data) {
		var imageHTML;
		if(data['response']['venue']['photos']['groups'].length > 0)
		{
			//just need the first image from each venue:
			var pictureObject = data['response']['venue']['photos']['groups'][0].items[0];
			var img = pictureObject.prefix;
			img += "width80";
			img += pictureObject.suffix;
			imageHTML = '<img height="60" width="60" src="' + img + '" />';
		}
		else imageHTML = '<img src="./images/default-icon.png" />';

		//locate affiliated image div, and write image
		var div = '.ajaxSearchImage' + data['response']['venue']['id'];
		$(div).html(imageHTML);
	}
});