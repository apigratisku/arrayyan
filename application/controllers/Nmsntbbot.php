<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Nmsntbbot extends CI_Controller {
    function __construct(){
        parent::__construct();
		$this->load->model('bot_tg_user_model');
		$this->load->model('router_model');
    }
 
    function index(){
        $TOKEN = "2065883202:AAEg2ftZ6RFo3kbQgKVnzaX3LrJDsj5CWho";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
		$fname = $update["chat"]["first_name"];
		$lname = $update["chat"]["last_name"];
        $message = $update["message"]["text"];
        $kordinat = explode(" ", $message);
        if (strpos($message, "/id") === 0) {
        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID."&parse_mode=HTML");
        }
		elseif (strpos($message, "/register") === 0) {
		$register_id = $this->bot_tg_user_model->register($chatID,$fname,$lname);
        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Registrasi berhasil. Data akan di validasi oleh admin.&parse_mode=HTML");
        }
		else
		{
		//Limit Access ChatID
		$cekid_existing = $this->bot_tg_user_model->get_existing($chatID);
		if($chatID == $cekid_existing)
		{
		if (strpos($message, "/hotspot") === 0) {
			if ($this->routerosapi->connect("112.78.38.187","noc-mtr","RFd3d76890"))
			{
				$this->routerosapi->write("/system/script/print",false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=msg_HotspotActive");				
				$API_SC = $this->routerosapi->read();
				foreach ($API_SC as $script)
				{
					$id_script = $script['.id'];
				}
				$this->routerosapi->write('/system/script/run',false);
				$this->routerosapi->write("=number=".$id_script);
				$this->routerosapi->read();
			}	
        //file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID.".&parse_mode=HTML");
        }
		elseif (strpos($message, "/server") === 0) {
			if ($this->routerosapi->connect("112.78.38.187","noc-mtr","RFd3d76890"))
			{
				$this->routerosapi->write("/tool/netwatch/print",false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?host=172.10.101.2");				
				$API_SC1 = $this->routerosapi->read();
				foreach ($API_SC1 as $script1)
				{
					$id_script1 = $script1['.id'];
				}
				$this->routerosapi->write('/tool/netwatch/set',false);
				$this->routerosapi->write("=disabled=yes",false);
				$this->routerosapi->write("=.id=".$id_script1);
				$this->routerosapi->read();
				$this->routerosapi->write('/tool/netwatch/set',false);
				$this->routerosapi->write("=disabled=no",false);
				$this->routerosapi->write("=.id=".$id_script1);
				$this->routerosapi->read();
				
				
				
				$this->routerosapi->write("/tool/netwatch/print",false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?host=172.10.102.2");				
				$API_SC2 = $this->routerosapi->read();
				foreach ($API_SC2 as $script2)
				{
					$id_script2 = $script2['.id'];
				}
				$this->routerosapi->write('/tool/netwatch/set',false);
				$this->routerosapi->write("=disabled=yes",false);
				$this->routerosapi->write("=.id=".$id_script2);
				$this->routerosapi->read();
				$this->routerosapi->write('/tool/netwatch/set',false);
				$this->routerosapi->write("=disabled=no",false);
				$this->routerosapi->write("=.id=".$id_script2);
				$this->routerosapi->read();
				
				
				
				$this->routerosapi->write("/tool/netwatch/print",false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?host=172.10.103.2");				
				$API_SC3 = $this->routerosapi->read();
				foreach ($API_SC3 as $script3)
				{
					$id_script3 = $script3['.id'];
				}
				$this->routerosapi->write('/tool/netwatch/set',false);
				$this->routerosapi->write("=disabled=yes",false);
				$this->routerosapi->write("=.id=".$id_script3);
				$this->routerosapi->read();
				$this->routerosapi->write('/tool/netwatch/set',false);
				$this->routerosapi->write("=disabled=no",false);
				$this->routerosapi->write("=.id=".$id_script3);
				$this->routerosapi->read();
			}	
        //file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID.".&parse_mode=HTML");
        }
		elseif (strpos($message, "/ujian_on") === 0) {
			if ($this->routerosapi->connect("112.78.38.187","noc-mtr","RFd3d76890"))
			{
				$this->routerosapi->write("/system/script/print",false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=msg_ujian_on");				
				$API_SC = $this->routerosapi->read();
				foreach ($API_SC as $script)
				{
					$id_script = $script['.id'];
				}
				$this->routerosapi->write('/system/script/run',false);
				$this->routerosapi->write("=number=".$id_script);
				$this->routerosapi->read();
			}	
        //file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID.".&parse_mode=HTML");
        }
		elseif (strpos($message, "/ujian_off") === 0) {
			if ($this->routerosapi->connect("112.78.38.187","noc-mtr","RFd3d76890"))
			{
				$this->routerosapi->write("/system/script/print",false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=msg_ujian_off");				
				$API_SC = $this->routerosapi->read();
				foreach ($API_SC as $script)
				{
					$id_script = $script['.id'];
				}
				$this->routerosapi->write('/system/script/run',false);
				$this->routerosapi->write("=number=".$id_script);
				$this->routerosapi->read();
			}	
        //file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID.".&parse_mode=HTML");
        }
		elseif (strpos($message, "/bandwidth") === 0) {
			if ($this->routerosapi->connect("112.78.38.187","noc-mtr","RFd3d76890"))
			{
				$this->routerosapi->write("/interface/monitor-traffic",false);			
				$this->routerosapi->write("=interface=ether1-to-GMEDIA",false);	
				$this->routerosapi->write("=once=",true);
				$ARRAY1 = $this->routerosapi->read();
				$this->routerosapi->write("/interface/monitor-traffic",false);			
				$this->routerosapi->write("=interface=ether2-to-INDIHOME",false);	
				$this->routerosapi->write("=once=",true);
				$ARRAY2 = $this->routerosapi->read();
				if(count($ARRAY1)>0){  
				  $rxK = number_format($ARRAY1[0]["rx-bits-per-second"]/1024,1);
				  $txK = number_format($ARRAY1[0]["tx-bits-per-second"]/1024,1);
				  $rxM = number_format($ARRAY1[0]["rx-bits-per-second"]/1024/1024,1);
				  $txM = number_format($ARRAY1[0]["tx-bits-per-second"]/1024/1024,1);
				  if(strlen($rxK) >= 5) {$DL1="Download: $rxM Mbps";} else {$DL1="Download: $rxK Kbps";}
				  if(strlen($txK) >= 5) {$UP1="\r\nUpload: $txM Mbps\r\n";} else {$UP1="\r\nUpload: $txK Kbps\r\n";}		  
				  $response1 = "[GMEDIA] $UP1$DL1\r\n\r\n";
				}	
				else
				{
					$response1 = "-";
				}
				if(count($ARRAY2)>0){  
				  $rxK = number_format($ARRAY2[0]["rx-bits-per-second"]/1024,1);
				  $txK = number_format($ARRAY2[0]["tx-bits-per-second"]/1024,1);
				  $rxM = number_format($ARRAY2[0]["rx-bits-per-second"]/1024/1024,1);
				  $txM = number_format($ARRAY2[0]["tx-bits-per-second"]/1024/1024,1);
				  if(strlen($rxK) >= 5) {$DL2="Download: <b>$rxM</b> Mbps";} else {$DL2="Download: <b>$rxK</b> Kbps";}
				  if(strlen($txK) >= 5) {$UP2="\r\nUpload: <b>$txM</b> Mbps\r\n";} else {$UP2="\r\nUpload: <b>$txK</b> Kbps\r\n";}		  
				  $response2 = "[TELKOM] $UP2$DL2";
				}	
				else
				{
					$response2 = "-";
				}
				$resp = urlencode("$response1$response2");
				file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=$resp&parse_mode=HTML");
			}	
        //file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID.".&parse_mode=HTML");
        }
		elseif (strpos($message, "/reboot") === 0) {
			if ($this->routerosapi->connect("112.78.38.187","noc-mtr","RFd3d76890"))
			{
				$this->routerosapi->write("/system/script/print",false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=msg_reboot");				
				$API_SC = $this->routerosapi->read();
				foreach ($API_SC as $script)
				{
					$id_script = $script['.id'];
				}
				$this->routerosapi->write('/system/script/run',false);
				$this->routerosapi->write("=number=".$id_script);
				$this->routerosapi->read();
			}	
        //file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID.".&parse_mode=HTML");
        }
	}
	else
	{
		file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Akses ditolak. Silahkan lakukan registrasi terlebih dahulu. Ketik /register untuk registrasi.&parse_mode=HTML");
	}
	}
	//End 
}
}  