<?php
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

defined('BASEPATH') OR exit('No direct script access allowed');

class PTAMbot extends CI_Controller {
    function __construct(){
        parent::__construct();
		//$this->load->model('mapping_model');
		//$this->load->model('fiberstream_model');
		//$this->load->model('mikrotik_model');
		//$this->load->model('OLT_model');
		//$this->load->model('telegram_model');
    }
 
    function index(){
		//include APPPATH.'libraries/telegram/Telegram.php';
		$telegram = new Telegram('6562265381:AAFFnYju4xyxJ6O5foeqpdYTXAffPuHjXrM');
		$private = $telegram->getData();
		$chat_id = $telegram->ChatID();
		$msg_id = $telegram->MessageID();
        $TOKEN = "6562265381:AAFFnYju4xyxJ6O5foeqpdYTXAffPuHjXrM";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $up = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $up["message"]["chat"]["id"];
		$fname = $up["message"]["chat"]["first_name"];
		$lname = $up["message"]["chat"]["last_name"];
        $message = $up["message"]["text"];
        $msgdata = explode(" ", $message);
		$msgcount = count($msgdata);
		$fullname = "$fname $lname";
		//$telegram_user = $this->telegram_model->get($chatID);
			
		if (strpos($message, "/start") === 0) 
		{
		file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai kak <b>".$fname." ".$lname."</b>. Kenalin aku PTAM Giri Menang Assistant.&parse_mode=HTML");
		}
		else
		{
			if($chatID == "250170651" || $chatID == "-4147369438" || $chatID == "-4136143981")
			{
				if (strpos($message, "/emote") === 0) 
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=TESTTTTT".json_decode('"\u2714\u2714\u2705"')."Tanggal ".date("d-M-Y H:i:s")." WITA\n\n&parse_mode=HTML");
				}	
				elseif (strpos($message, "/id") === 0) 
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai bosqu. ID Telegram: <b>".$chatID."</b>.&parse_mode=HTML");
				}		
					
			}
			else
			{
				if (strpos($message, "/id") === 0) 
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Hai kak ".$fname." ".$lname.". ID Telegram: <b>".$chatID."</b>.&parse_mode=HTML");
				}	
				else
				{
					file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Anda tidak memiliki akses !!!&parse_mode=HTML");
				}
			}
		}
	}
//END SCRIPT

public function satpam_ptam_enginer($ipaddr,$status) {

		date_default_timezone_set("Asia/Singapore");
		if($ipaddr == "10.254.254.2"){
		$pesan_tg = "<b>Laporan Komendan</b>\n";
		$pesan_tg .= "Waktu: <b>".date("Y-m-d H:i")."</b> Wita\nStatus PLN : <b>".$status."</b>\n\n";
		$pesan_tg .= "Regards,\n<b>Satpam IT PTAMGM</b>";
		}elseif($ipaddr == "10.254.254.3"){
		$pesan_tg = "<b>Laporan Komendan</b>\n";
		$pesan_tg .= "Waktu: <b>".date("Y-m-d H:i")."</b> Wita\nStatus Genset: <b>".$status."</b>\n\n";
		$pesan_tg .= "Regards,\n<b>Satpam IT PTAMGM</b>";
		}
		
		$this->telegram_lib->sendptam("-4136143981",$pesan_tg);
		  
    }

//Whatsapp

public function satpam_ptam_status($site,$status,$ipaddr) {
		date_default_timezone_set("Asia/Singapore");
		$pesan_wa = "*Laporan Komendan*\n";
		$pesan_wa .= "Perangkat: *".$site."*\nIP Address: *".$ipaddr."*\nWaktu: *".date("Y-m-d H:i")."* Wita\nStatus: *".$status."*\n\n";
		$pesan_wa .= "Regards,\n*Satpam PTAMGM*";
		
		$headers = array(
				'Content-Type:application/json'
		);
		$fields = [
				'id'  => '120363260178640748@g.us',
				'message' => $pesan_wa,
			];
		/////////////////////get jobs/////////////////
		//$api_path="http://103.255.242.7:7000/send-group-message";
		$api_path="http://112.78.38.233:7000/send-group-message";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_path);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
		$featuredJobs = curl_exec($ch);

		  if(curl_errno($ch)) {    
			  echo 'Curl error: ' . curl_error($ch);  

			  exit();  
		  } else {    
			  // check the HTTP status code of the request
				$resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if ($resultStatus != 200) {
					echo stripslashes($featuredJobs);
					die('Request failed: HTTP status code: ' . $resultStatus);

				}
			
			 $featured_jobs_array=(array)json_decode($featuredJobs);
		  }
		  
    }

	


	

}  