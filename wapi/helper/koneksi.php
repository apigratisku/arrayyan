<?php

$host = "localhost";
$username = "wapi";
$password = "masuk123";
$db = "wapi";
error_reporting(0);
$koneksi = mysqli_connect($host, $username, $password, $db) or die("GAGAL");

$base_url = "http://localhost/wagw-mpedia-v4/";
date_default_timezone_set('Asia/Jakarta');
