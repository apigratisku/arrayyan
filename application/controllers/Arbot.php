<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Arbot extends CI_Controller {
    function __construct(){
        parent::__construct();
    }
 
    function index(){
		//include APPPATH.'libraries/telegram/Telegram.php';
		$telegram = new Telegram('5021272940:AAFgMRgViMKxCeYG4jbo1IZmgabz07-7vWY');
		$private = $telegram->getData();
		$chat_id = $telegram->ChatID();
		$msg_id = $telegram->MessageID();
        $TOKEN = "5021272940:AAFgMRgViMKxCeYG4jbo1IZmgabz07-7vWY";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
		$fname = $update["message"]["chat"]["first_name"];
		$lname = $update["message"]["chat"]["last_name"];
        $message = $update["message"]["text"];
        $msgdata = explode(" ", $message);
		$msgcount = count($msgdata);
		$fullname = "$fname $lname";
			
		if (strpos($message, "/start") === 0) 
		{
		file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai kak <b>".$fname." ".$lname."</b>. Selamat datang Bosqu. &parse_mode=HTML");
		}
		elseif (strpos($message, "/id") === 0) 
		{
			file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai kak ".$fname." ".$lname.". ID Telegram: ".$chatID.".&parse_mode=HTML");
		}
		elseif (strpos($message, "/lampu_garasi_on") === 0) 
		{	
			exec("sudo python /home/pi/on_garasi.py");
		}
		elseif (strpos($message, "/lampu_garasi_off") === 0) 
		{	
			exec("sudo python /home/pi/off_garasi.py");
		}
	}
	//END SYNTAX DENGAN AKSES TERDAFTAR


}  




