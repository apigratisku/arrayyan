<?php
//Fungsi CEK ID
 	function showID($iduser,$fname,$lname) 
	{
		$dbhost = "localhost";
		$dbuser	= 'admin_xdark';
		$dbpass	= '1nd0s4tm2';
		$dbname	= 'admin_xdark';
		$link 	= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
		$sql_botAPI = mysqli_fetch_row(mysqli_query($link,"select * from gm_telegram where status='1'"));
		$TOKEN  = $sql_botAPI[2];  
		$chpmatid = "250170651"; 
		$pesan 	= "Hai admin. \nID $iduser ($fname $lname) telah sukses request cek ID.";
		// ----------- code -------------
		$method	= "sendMessage";
		$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
		$post 	= "chat_id=$chpmatid&text=$pesan";
		$header = [
					"X-Requested-With: XMLHttpRequest",
					"User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
					];
		$chpm = curl_init();
		curl_setopt($chpm, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($chpm, CURLOPT_URL, $url);
		//curl_setopt($chpm, CURLOPT_REFERER, $refer);
		curl_setopt($chpm, CURLOPT_HTTPHEADER, $header);
		curl_setopt($chpm, CURLOPT_POSTFIELDS, $post );   
		curl_setopt($chpm, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($chpm);
		print curl_error($chpm);
		$status = curl_getinfo($chpm, CURLINFO_HTTP_CODE);
		curl_close($chpm);
	}
	
//Fungsi Send ID ke Super Admin
 	function newreg($iduser,$fname,$lname) 
	{
	
		//Get ID from SQL
		$dbhost = "localhost";
		$dbuser	= 'admin_xdark';
		$dbpass	= '1nd0s4tm2';
		$dbname	= 'admin_xdark';
		$link 	= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
		$sql_botAPI = mysqli_fetch_row(mysqli_query($link,"select * from gm_telegram where status='1'"));
		$sqld = mysqli_query($link,"select * from tbl_telegram where level='1' && id_user='250170651'");
		while($getid = mysqli_fetch_array($sqld)) {
		$TOKEN  = $sql_botAPI[2];   
		$chpmatid = $getid['id_user']; 
		$pesan 	= "Hai admin. \nID $iduser ($fname $lname) request untuk join.";
		// ----------- code -------------
		$method	= "sendMessage";
		$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
		$post 	= "chat_id=$chpmatid&text=$pesan";
		$header = [
					"X-Requested-With: XMLHttpRequest",
					"User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
					];
		$chpm = curl_init();
		curl_setopt($chpm, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($chpm, CURLOPT_URL, $url);
		//curl_setopt($chpm, CURLOPT_REFERER, $refer);
		curl_setopt($chpm, CURLOPT_HTTPHEADER, $header);
		curl_setopt($chpm, CURLOPT_POSTFIELDS, $post );   
		curl_setopt($chpm, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($chpm);
		print curl_error($chpm);
		$status = curl_getinfo($chpm, CURLINFO_HTTP_CODE);
		curl_close($chpm);
		}
	}
	
	//Fungsi Pesan aktivasi ID
	function activemessage($iduser) 
	{
		$dbhost = "localhost";
		$dbuser	= 'admin_xdark';
		$dbpass	= '1nd0s4tm2';
		$dbname	= 'admin_xdark';
		$link 	= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
		$sql_botAPI = mysqli_fetch_row(mysqli_query($link,"select * from gm_telegram where status='1'"));
		$TOKEN  = $sql_botAPI[2]; 
		$chpmatid = $iduser; 
		$pesan 	= "Selamat ID anda telah aktif. \nAnda dapat berpartisipasi pada grup Team GMedia NTB BISA!!!";
		// ----------- code -------------
		$method	= "sendMessage";
		$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
		$post 	= "chat_id=$chpmatid&text=$pesan";
		$header = [
					"X-Requested-With: XMLHttpRequest",
					"User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
					];
		$chpm = curl_init();
		curl_setopt($chpm, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($chpm, CURLOPT_URL, $url);
		//curl_setopt($chpm, CURLOPT_REFERER, $refer);
		curl_setopt($chpm, CURLOPT_HTTPHEADER, $header);
		curl_setopt($chpm, CURLOPT_POSTFIELDS, $post );   
		curl_setopt($chpm, CURLOPT_SSL_VERIFYPEER, false);
		curl_exec($chpm);
		print curl_error($chpm);
		$status = curl_getinfo($chpm, CURLINFO_HTTP_CODE);
		curl_close($chpm);
	}
	
	

?>