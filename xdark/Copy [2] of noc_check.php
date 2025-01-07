<?php
$dbhost = "localhost";
$dbuser = "admin_xdark";
$dbpass = "1nd0s4tm2";
$dbname = "admin_xdark";
$link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
date_default_timezone_set("Asia/Singapore");
$date = date("M/d/Y H:i:s");
if(isset($_POST['MODEL']))
{
	if($_POST['MODEL'] == "LOG")
	{
	$query 		= mysqli_query($link,"SELECT * from gm_log_radio where pelanggan='$_POST[PELANGGAN]'");
	$cek_data	= mysqli_num_rows($query);
	$info 		= mysqli_fetch_array($query);
	
	$SIGNAL 	= "$_POST[SIGNALTX]/$_POST[SIGNALRX]"; 
	$CCQ 		= "$_POST[CCQTX]/$_POST[CCQRX]";
	$JARAK 		= "$_POST[JARAK]";
		if($_POST['CCQTX'] < 50 || $_POST['CCQRX'] < 50){ $kualitas_CCQ = "Buruk"; }
		elseif($_POST['CCQTX'] <= 75 || $_POST['CCQRX'] <= 75){ $kualitas_CCQ = "Diperlukan Optimasi"; }
		else {$kualitas_CCQ = "Baik";}
		if($cek_data > 0)
		{
		
		mysqli_query($link,"UPDATE gm_log_radio set sinyal='$SIGNAL', ccq='$CCQ', waktu='$date' where pelanggan='$_POST[PELANGGAN]'");
		mysqli_query($link,"UPDATE gm_log_radio_realtime set kualitas='$kualitas_CCQ' where pelanggan='$_POST[PELANGGAN]'");
		}
		else
		{
		mysqli_query($link,"INSERT into gm_log_radio VALUES ('','$date','$_POST[SEKTOR]','$_POST[PELANGGAN]','$_POST[IP]','$JARAK','$SIGNAL','$CCQ')");
		mysqli_query($link,"UPDATE gm_log_radio_realtime set kualitas='$kualitas_CCQ' where pelanggan='$_POST[PELANGGAN]'");
		}
	}
	elseif($_POST['MODEL'] == "REALTIME")
	{
	$query 		= mysqli_query($link,"SELECT * from gm_log_radio_realtime where pelanggan='$_POST[PELANGGAN]' && sektor='$_POST[SEKTOR]'");
	$cek_data	= mysqli_num_rows($query);
	$info 		= mysqli_fetch_array($query);
		
	$SIGNAL 	= "$_POST[SIGNALTX]/$_POST[SIGNALRX]"; 
	$CCQ 		= "$_POST[CCQTX]/$_POST[CCQRX]";
	$JARAK 		= "$_POST[JARAK]";
	if($_POST['CCQTX'] < 50 || $_POST['CCQRX'] < 50){ $kualitas_CCQ = "Buruk"; }
		elseif($_POST['CCQTX'] <= 75 || $_POST['CCQRX'] <= 75){ $kualitas_CCQ = "Diperlukan Optimasi"; }
		else {$kualitas_CCQ = "Baik";}
		if($cek_data > 0)
		{
		mysqli_query($link,"UPDATE gm_log_radio_realtime set sektor='$_POST[SEKTOR]', sinyal='$SIGNAL', ccq='$CCQ', waktu='$date' where pelanggan='$_POST[PELANGGAN]'");
		}
		else
		{
			if($_POST['PELANGGAN'] != NULL)
			{
			mysqli_query($link,"INSERT into gm_log_radio_realtime VALUES ('','$date','$_POST[SEKTOR]','$_POST[PELANGGAN]','$_POST[IP]','$JARAK','$SIGNAL','$CCQ','$kualitas_CCQ')");
			}
		}
	}
	elseif($_POST['MODEL'] == "LASTMILE")
	{
	$query 		= mysqli_query($link,"SELECT * from gm_lastmile where id='$_POST[IP]'");
	$cek_data	= mysqli_num_rows($query);
		if($cek_data > 0)
		{
		mysqli_query($link,"UPDATE gm_lastmile set status='$_POST[STATUS]' where IP='$_POST[IP]'");
		}
	}
	else
	{
	$query 		= mysqli_query($link,"SELECT * from gm_log_radio where pelanggan='$_POST[PELANGGAN]'");
	$cek_data	= mysqli_num_rows($query);
		if($cek_data > 0)
		{
		mysqli_query($link,"DELETE from gm_log_radio where pelanggan='$_POST[PELANGGAN]'");
		mysqli_query($link,"UPDATE gm_log_radio_realtime set kualitas='Baik' where pelanggan='$_POST[PELANGGAN]'");
		}
	}
}
else
{
echo"Data tidak valid !";
}
?>