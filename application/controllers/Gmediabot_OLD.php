<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Gmediabot extends CI_Controller {
    function __construct(){
        parent::__construct();
		
    }
 
    function index(){
		$this->load->model('mapping_model');
        $TOKEN = "1117257670:AAHlAgCIfzL3DTe4xnI8ygVdVVpr2z9JDls";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        $kordinat = explode(" ", $message);
        if (strpos($message, "!start") === 0) {
        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Siap melayani kakak semua :)</b>.&parse_mode=HTML");
        }
		elseif (strpos($message, "!help") === 0) {
		$reply = urlencode("<b>GMEDIA BOT</b>\n=================================\n\n<b>!id</b> => Perintah cek id telegram \n\n<b>!mapping</b> => Perintah mapping capel FS \n(Contoh !mapping -8.408632 116.101056) \n\n<b>!olt_cek</b> => Perintah cek ONU yang teregistrasi pada OLT \n(Contoh !olt_cek 1/1/1 \n\n<b>!onu_cek</b> => Perintah cek konfigurasi ONU \n(Contoh !onu_cek 1/1/1:10)"); 
        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply."&parse_mode=HTML");
        }
		elseif (strpos($message, "!id") === 0) {
        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=ID Telegram: ".$chatID.".&parse_mode=HTML");
        }
		elseif (strpos($message, "!mapping") === 0) {
        $mapping = $this->mapping_model->mapping_fs($kordinat[1],$kordinat[2]);
		$result_mapping = explode(" ", $mapping);
        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=<b>Hasil Mapping:</b> Tercover ODP <b>".$result_mapping[0]."</b> dengan jarak perkiraan <b>".$result_mapping[1]."</b> Meter.&parse_mode=HTML");
        }
		elseif (strpos($message, "!olt_cek2") === 0) {	
		$this->load->library('phptelnet');
		$telnet = new PHPTelnet();
		$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
		
			if ($result == 0) 
			{
				$telnet->DoCommand('show gpon onu state gpon-olt_'.$kordinat[1].'', $result);
				$skuList = preg_split('/\r\n|\r|\n/', $result);
				//Array value
				foreach($skuList as $key => $value )
				{
					if($value == "show gpon onu state gpon-olt_".$kordinat[1]."")
					{ echo""; }
					elseif(strpos($value,'OMCC'))
					{ echo""; }
					elseif($value == "--------------------------------------------------------------")
					{ echo""; }
					elseif($value == "OLT-ZTE-GMEDIA-PMG#")
					{ echo""; }
					elseif(strpos($value,'Number:'))
					{ echo""; }
					else
					{
						//$find = strpos($value,'1(GPON)');
						$modifstr = str_replace("1(GPON)", "",$value);
						$items_onu[] = $modifstr;
					//echo $value. '<br />';
					}
				} 
			}	
		//DC Telnet	
		$telnet->Disconnect();	
		//Output ONU ke Telegram
					$output="";
					foreach($items_onu as $onu )
					{
						$output.= $onu."\n";
					}
					
					//Manipulasi string total ONU Aktif/Offline/DyingGasp/LOS
					foreach($items_onu as $onustr )
					{
						if(strpos($onustr,'DyingGasp'))
						{ $items_onu_poweroff[] = urlencode($onustr."\n"); }
						elseif(strpos($onustr,'LOS'))
						{ $items_onu_los[] = urlencode($onustr."\n"); }
						elseif(strpos($onustr,'OffLine'))
						{ $items_onu_OffLine[] = urlencode($onustr."\n"); }
					}
					//Hitung total ONU
					$len_aktif = count($items_onu);
					$len_poweroff = count($items_onu_poweroff);
					$len_los = count($items_onu_los);
					$len_offline= count($items_onu_OffLine);
					//Reply to Telegram
					$reply = urlencode($output."\nTotal: ".$len_aktif."\nOffline: ".$len_offline."\nPower Off: ".$len_poweroff."\nLOS: ".$len_los);
		//Syntax kirim pesan ke telegram
		file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply."&parse_mode=HTML");
		
		}
		elseif (strpos($message, "!onu_cek") === 0) {	
		$this->load->library('phptelnet');
		$telnet = new PHPTelnet();
		$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
		
			if ($result == 0) 
			{
				$telnet->DoCommand('sh run interface gpon-onu_'.$kordinat[1].'', $result);
				$skuList = preg_split('/\r\n|\r|\n/', $result);
				
				foreach($skuList as $key => $value )
				{
					//if($value == "interface gpon-onu_".$kordinat[1]."")
					//{ $items_pon[] = $value; }
					//elseif(strpos($value,'description'))
					//{ $items_pon[] = $value; }
					//elseif(strpos($value,"tcont 1 profile"))
					//{ $items_pon[] = $value; }
					$items_pon[] = $value;
				}
					$output="";
					foreach($items_pon as $pon )
					{
					 $output.= $pon."\n";
					}
					$len_aktif = count($items_onu);
					$len_poweroff = count($items_onu_poweroff);
					$len_los = count($items_onu_los);
					$reply = urlencode($output);
					 
			}	
		file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=".$reply."&parse_mode=HTML");
		$telnet->Disconnect();
		}
}

 public function web_gpon_olt($id) {
 		
 		$this->load->library('phptelnet');
		$telnet = new PHPTelnet();
		$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
        if ($result == 0)
		{
		$telnet->DoCommand('show gpon onu state gpon-olt_1/1/'.$id, $result);
		$skuList = preg_split('/\r\n|\r|\n/', $result);
			foreach($skuList as $key => $value )
			{
			if($value == "show gpon onu state gpon-olt_1/1/".$id."")
			{ echo""; }
			elseif(strpos($value,'OMCC'))
			{ echo""; }
			elseif($value == "--------------------------------------------------------------")
			{ echo""; }
			elseif($value == "OLT-ZTE-GMEDIA-PMG#")
			{ echo""; }
			elseif(strpos($value,'Number:'))
			{ echo""; }
			else
			{
			//$find = strpos($value,'1(GPON)');
			$modifstr = str_replace("1(GPON)", "",$value);
			$items_onu[] = $modifstr;
			}
		}
		//DC Telnet
		$telnet->Disconnect();
		//Output ONU ke Telegram
		$output="";
		foreach($items_onu as $onu )
		{
			$output.= $onu."<br>";
			
			//Manipulasi string
			$str_olt = explode(" ", $onu);
			print_r($str_olt);
			if(!empty($str_olt[16])) {$status = $str_olt[16];}elseif(!empty($str_olt[17])) {$status = $str_olt[17];} elseif(!empty($str_olt[18])) {$status = $str_olt[18];} elseif($str_olt[0] == "%Code") {$status = "KOSONG";} else{$status = "KOSONG";}
			if($str_olt[0] != "%Code") {$onuvalue = $str_olt[0];} else {$onuvalue = "KOSONG";}
			
				
			$this->load->database();
			$this->db->reconnect();	
			$data = array(
				'onu' => $onuvalue,
				'rx_olt' => "",
				'rx_onu' => "",
				'status' => $status,
				);
			if(!empty($onuvalue) && $onuvalue != "KOSONG")
			{
			$query1 = $this->db->get_where('gm_olt', array('onu' => $str_olt[0]));
			$query = $this->db->escape($query1);
        	$count = $query->num_rows();
				if ($count == 0) {
				$this->db->insert('gm_olt', $data);
				}
				else
				{
				$this->db->where('onu', $str_olt[0]); $this->db->update('gm_olt', $data);
				}
			}
		}
		
		//Manipulasi string total ONU Aktif/Offline/DyingGasp/LOS
		foreach($items_onu as $onustr )
		{
			if(strpos($onustr,'DyingGasp'))
			{ $items_onu_poweroff[] = $onustr."<br>"; }
			elseif(strpos($onustr,'LOS'))
			{ $items_onu_los[] = $onustr."<br>"; }
			elseif(strpos($onustr,'OffLine'))
			{ $items_onu_OffLine[] = $onustr."<br>"; }
		}
		//Hitung total ONU
		$len_aktif = count($items_onu);
		if(!empty($items_onu_poweroff)) {$len_poweroff = count($items_onu_poweroff);} else {$len_poweroff = 0;}
		if(!empty($items_onu_los)) {$len_los = count($items_onu_los);} else {$len_los = 0;}
		if(!empty($items_onu_OffLine)) {$len_offline = count($items_onu_OffLine);} else {$len_offline = 0;}
		//Reply to Telegram
		echo $output."<br>Total: ".$len_aktif."<br>Offline: ".$len_offline."<br>Power Off: ".$len_poweroff."<br>LOS: ".$len_los;
		$this->load->database();
		$this->db->reconnect();
		}

    }
	
}  