<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Oprekbot extends CI_Controller {
    function __construct(){
        parent::__construct();
    }
 
    function index(){
		//include APPPATH.'libraries/telegram/Telegram.php';
		$telegram = new Telegram('642869890:AAFM4kdy8JS7LUb57lrlqdzGy44asONyBg8');
		$private = $telegram->getData();
		$chat_id = $telegram->ChatID();
		$msg_id = $telegram->MessageID();
        $TOKEN = "642869890:AAFM4kdy8JS7LUb57lrlqdzGy44asONyBg8";
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
	}
	//END SYNTAX DENGAN AKSES TERDAFTAR


}  




