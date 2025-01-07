<?php
$dbhost = "db.arrayyan.web.id";
$dbuser = "admin_bankdata";
$dbpass = "1nd0s4tm2";
$dbname = "admin_bankdata";
$link   = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
date_default_timezone_set("Asia/Singapore"); 
$tanggal= date("Y-m-d");
$jam  	= date("H:i:s");

if(isset($_GET['IPclient']))
{
	$query1 	= mysqli_query($link,"SELECT * from gm_router where router_ip='$_GET[IPclient]'");
	$cek1 		= mysqli_num_rows($query1);
	$info 		= mysqli_fetch_array($query1);
	if($cek1 > 0)
	{
		if(isset($_GET['status']))
		{
			if($_GET['status'] == "1")
			{			
			$exe1 = mysqli_query($link,"UPDATE gm_router set status='1' where router_ip='$_GET[IPclient]'");
			$exe2 = mysqli_query($link,"INSERT into gm_log values ('','$info[id]','$info[nama]','$tanggal','$jam','Router','Mikrotik','$_GET[IPclient]','UP')");	
				if($exe1 && $exe2)
				{
				echo"Update data sukses.";
				}
				else
				{
				echo"Update data gagal.";
				}		
			}
			elseif($_GET['status'] == "0")
			{
			$exe1 = mysqli_query($link,"UPDATE gm_router set status='0' where router_ip='$_GET[IPclient]'");
			$exe2 = mysqli_query($link,"INSERT into gm_log values ('','$info[id]','$info[nama]','$tanggal','$jam','Router','Mikrotik','$_GET[IPclient]','DOWN')");	
			if($exe1 && $exe2)
				{
				echo"Update data sukses.";
				}
				else
				{
				echo"Update data gagal.";
				}
			}
			else
			{
			echo"Maaf data tidak valid.";
			}
		}
		else
		{
		echo"Maaf data tidak valid.";
		}
	}
	else
	{
	echo"Maaf data tidak tersedia.";
	}
}
elseif(isset($_GET['IPbts']))
{
	$query1 	= mysqli_query($link,"SELECT * from gm_bts where ip='$_GET[IPbts]'");
	$cek1 		= mysqli_num_rows($query1);
	$info 		= mysqli_fetch_array($query1);
	if($cek1 > 0)
	{
		if(isset($_GET['status']))
		{
			if($_GET['status'] == "1")
			{			
			$exe1 = mysqli_query($link,"UPDATE gm_bts set status='1' where ip='$_GET[IPbts]'");
				if($exe1 && $exe2)
				{
				echo"Update data sukses.";
				}
				else
				{
				echo"Update data gagal.";
				}		
			}
			elseif($_GET['status'] == "0")
			{
			$exe1 = mysqli_query($link,"UPDATE gm_router set status='0' where ip='$_GET[IPbts]'");
			if($exe1)
				{
				echo"Update data sukses.";
				}
				else
				{
				echo"Update data gagal.";
				}
			}
			else
			{
			echo"Maaf data tidak valid.";
			}
		}
		else
		{
		echo"Maaf data tidak valid.";
		}
	}
	else
	{
	echo"Maaf data tidak tersedia.";
	}
}
elseif(isset($_GET['IPlastmile']))
{
	$query1 	= mysqli_query($link,"SELECT * from gm_lastmile where ip='$_GET[IPlastmile]'");
	$cek1 		= mysqli_num_rows($query1);
	$info 		= mysqli_fetch_array($query1);
	if($cek1 > 0)
	{
		if(isset($_GET['status']))
		{
			if($_GET['status'] == "1")
			{			
			$exe1 = mysqli_query($link,"UPDATE gm_lastmile set status='1' where ip='$_GET[IPlastmile]'");
				if($exe1)
				{
				echo"Update data sukses.";
				}
				else
				{
				echo"Update data gagal.";
				}		
			}
			elseif($_GET['status'] == "0")
			{
			$exe1 = mysqli_query($link,"UPDATE gm_lastmile set status='0' where ip='$_GET[IPlastmile]'");
			if($exe1)
				{
				echo"Update data sukses.";
				}
				else
				{
				echo"Update data gagal.";
				}
			}
			else
			{
			echo"Maaf data tidak valid.";
			}
		}
		else
		{
		echo"Maaf data tidak valid.";
		}
	}
	else
	{
	echo"Maaf data tidak tersedia.";
	}
}
elseif(isset($_GET['IDrouter']))
{
	if(isset($_GET['IPlokalan']))
	{
		$query2 	= mysqli_query($link,"SELECT * from gm_lokalan where idrouter='$_GET[IDrouter]' && ip='$_GET[IPlokalan]'");
		$query3 	= mysqli_query($link,"SELECT * from gm_router where id='$_GET[IDrouter]'");
		$cek2 		= mysqli_num_rows($query2);
		$info 		= mysqli_fetch_array($query3);
		$info_lokal	= mysqli_fetch_array($query2);
		if($cek2 > 0)
		{
			if(isset($_GET['status']))
			{
				if($_GET['status'] == "1")
				{
					$exe1 = mysqli_query($link,"UPDATE gm_lokalan set status='$_GET[status]' where idrouter='$_GET[IDrouter]' && ip='$_GET[IPlokalan]'");
					$exe2 = mysqli_query($link,"INSERT into gm_log values ('','$info[id]','$info[nama]','$tanggal','$jam','Access Point','$info_lokal[area]','$_GET[IPlokalan]','UP')");	
					if($exe1 && $exe2)
					{
					echo"Update data sukses.";
					}
					else
					{
					echo"Update data gagal.";
					}
				}
				elseif($_GET['status'] == "0")
				{
					$exe1 = mysqli_query($link,"UPDATE gm_lokalan set status='$_GET[status]' where idrouter='$_GET[IDrouter]' && ip='$_GET[IPlokalan]'");
					$exe2 = mysqli_query($link,"INSERT into gm_log values ('','$info[id]','$info[nama]','$tanggal','$jam','Access Point','$info_lokal[area]','$_GET[IPlokalan]','DOWN')");	
					if($exe1 && $exe2)
					{
					echo"Update data sukses.";
					}
					else
					{
					echo"Update data gagal.";
					}
				}
				else
				{
				echo"Maaf data tidak valid.";
				}
			}
			else
			{
			echo"Maaf data tidak valid.";
			}
		}
		else
		{
		echo"Maaf data tidak valid.";
		}
	}
	else
	{
	echo"Maaf data tidak tersedia.";
	}
}
elseif(isset($_GET['Scheduler']))
{
	if(isset($_GET['status']))
	{
		$query4 	= mysqli_query($link,"SELECT * from blip_pelanggan where id='$_GET[Scheduler]'");
		$cek4 		= mysqli_num_rows($query4);
		$info 		= mysqli_fetch_array($query4);
		if($cek4 > 0)
		{
			if(isset($_GET['status']))
			{
				if($_GET['status'] == "1")
				{
					$exe1 = mysqli_query($link,"UPDATE blip_scheduler set status='1' where resource='$_GET[Res]'");
					if($exe1)
					{
					echo"Update data sukses.";
					}
					else
					{
					echo"Update data gagal.";
					}
				}
				elseif($_GET['status'] == "2")
				{
					$exe1 = mysqli_query($link,"UPDATE blip_scheduler set status='2' where resource='$_GET[Res]'");
					if($exe1)
					{
					echo"Update data sukses.";
					}
					else
					{
					echo"Update data gagal.";
					}
				}
				else
				{
				echo"Maaf data tidak valid.";
				}
			}
			else
			{
			echo"Maaf data tidak valid.";
			}
		}
		else
		{
		echo"Maaf data tidak valid.";
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