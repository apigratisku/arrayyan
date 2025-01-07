<?php
//ENKRIPSI PASSWORD ROUTER
include"../application/third_party/addon.php";
$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
$ar_str_ip = "4";
$ar_dec_ip = $ar_chip->encrypt($ar_str_ip, $ar_rand);
$ar_str_user = "noc-mtr";
$ar_dec_user = $ar_chip->encrypt($ar_str_user, $ar_rand);
$ar_str_pass = "103.255.242.252";
$ar_dec_pass = $ar_chip->encrypt($ar_str_pass, $ar_rand);
$hostname = $ar_dec_ip;
$username = $ar_dec_user;
$password = $ar_dec_pass;

echo $ar_dec_pass."<br>";
?>