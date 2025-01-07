<?php

//GET DATA FROM SQL
$dbhost = "localhost";
$dbuser	= 'admin_xdark';
$dbpass	= '1nd0s4tm2';
$dbname	= 'admin_xdark';
$link 	= mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
//AMBIL PARAMETER PERINTAH
$pecah = explode(' ', $text);
if(!empty($pecah[0])){$data1 = $pecah[0];}
if(!empty($pecah[1])){ $data2 = $pecah[1];}

//CEK ID USER
if($text != NULL)
{
$queryid = mysqli_query($link,"select * from gm_telegram_user where id_user='$chatid'");
$rowquery = mysqli_fetch_array($queryid);
$cekid	 = mysqli_num_rows($queryid);
	//Fungsi /start
	if($text == "!start")
	{
		$reply = "*Siap melayani kakak semua :)*";
	}
	//Fungsi Lihat ID
	elseif($text == "!id")
	{
		//showID($chatid,$fname,$lname);
		$reply = "ID Telegram anda: *$chatid*";
	}
	elseif($text == "!respon")
	{
			$reply = "*GMediaBOT Siap Kak :)*";
	}			
	else
	{
		if($data1 == "!pelanggan")
					{
						if($data2 != NULL)
						{
						$sqlcek = mysqli_query($link,"SELECT * from gm_router where nama LIKE '%$data2%'");
						$cek	= mysqli_num_rows($sqlcek);
						$sqldata = mysqli_fetch_row($sqlcek);
							if($cek > 0)
							{
								//ENKRIPSI PASSWORD ROUTER
								include_once "addon.php";
								$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
								$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
								
								$ar_str_user = $sqldata[3];
								$dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
								$ar_str_pass = $sqldata[4];
								$dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
								
								$hostname = $sqldata[2];
								$username = $dec_user;
								$password = $dec_pass;
								
								if ($this->routerosapi->connect($hostname, $username, $password))
								{
									$balasan ="Sukses terhubung ke pelanggan kak.";		
								}
								else
								{
									$balasan ="Maaf kak tidak dapat terhubung ke Pelanggan *$data2*";
								}
							}
							else
							{
								$balasan ="Maaf kak Pelanggan *$data2* tidak ditemukan.";
							}
								$reply = $balasan;
						}				
					} 

	}
}











?>