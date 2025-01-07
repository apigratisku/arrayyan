<?php
$dbhost = "db.arrayyan.web.id";
$dbuser = "admin_bankdata";
$dbpass = "1nd0s4tm2";
$dbname = "admin_bankdata";
$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(isset($_GET['IPclient']))
{
	$query1 	= mysqli_query($link,"SELECT * from gm_server where ip='$_GET[IPclient]'");
	$cek1 	= mysqli_num_rows($query1);
	if($cek1 > 0)
	{
		if(isset($_GET['status']))
		{
			mysqli_query($link,"UPDATE gm_server set up_down='$_GET[status]' where ip='$_GET[IPclient]'");
			echo"Update data router sukses.";
		}
		else
		{
		echo"Maaf data tidak tersedia.";
		}
	}
	else
	{
	echo"Maaf data tidak tersedia.";
	}
}
else
{
echo"Maaf data tidak tersedia.";
}



?>