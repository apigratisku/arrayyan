<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Blip_monitor extends CI_Controller {
	public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('TCPDF');
		$this->load->library('user_agent');	
		$this->load->model('bts_model');
        $this->load->model('operator_model');
		$this->load->model('station_model');
		$this->load->model('lokalan_model');	
		$this->load->model('router_model');
		$this->load->model('scheduler_model');
		$this->load->model('mikrotik_model');
		$this->load->model('lokalan_model');
		$this->load->model('mapping_model');
		$this->load->model('fiberstream_model');
		$this->load->model('maintenance_model');
		$this->load->model('telegram_model');
		$this->load->model('m_baddebt');
		$this->load->model('m_wo');
		$this->load->model('m_kpi');
		$this->load->model('m_media');
		$this->load->model('m_sales');
		$this->load->model('m_level');
		$this->load->model('m_produk');
		$this->load->model('m_layanan');
		$this->load->model('m_data_pelanggan');
		$this->load->model('bts_model');
		$this->load->model('m_vas_data');
		$this->load->model('m_vas_spec');
		$this->load->model('m_olt');
		$this->load->model('m_onu');
    }
	
   public function index() {
   		redirect('login');
	}
	public function get_status($id) {
		$this->load->helper(array('form', 'url'));
   		$this->load->model('fiberstream_model');
		$this->load->model('m_onu');
		$db_onu  = $this->db->get_where('blip_onu', array('mgmt_ip' => $id))->row_array();
		$this->fiberstream_model->get_status($id);
		
	}
	
	public function fo_onnet_mtr($id) {
		$this->load->helper(array('form', 'url'));
		$this->load->library('phptelnet');		
		$this->load->model('m_onu');
		$db_onu  = $this->db->get_where('blip_onu', array('mgmt_ip' => $id))->row_array();
		$this->m_onu->set_redaman_mtr($db_onu['id']);
		
	}
	public function fo_onnet_pmg($id) {
		$this->load->helper(array('form', 'url'));
		$this->load->library('phptelnet');		
		$this->load->model('m_onu');
		$db_layanan  = $this->db->get_where('blip_layanan', array('router_ip' => $id))->row_array();
		$db_onu  = $this->db->get_where('blip_onu', array('id_layanan1' => $db_layanan['id']))->row_array();
		$this->m_onu->set_redaman_pmg($db_onu['id']);
		
	}
	public function we_check($ip,$nama) {
		date_default_timezone_set("Asia/Singapore");
		$this->load->helper(array('form', 'url'));
		$n_device = str_replace("%20"," ",$nama);
		if ($this->routerosapi->connect($ip, "noc-mtr", "mtr2021","8728"))
		{
				$this->routerosapi->write('/interface/wireless/registration-table/getall');
				$API_data = $this->routerosapi->read();
				foreach ($API_data as $data)
				{
					$d1 	= $data['tx-ccq'];	
					$d2 	= $data['rx-ccq'];
					$d3 	= $data['tx-signal-strength'];
					$d4 	= $data['signal-strength-ch0'];
				}
				$this->routerosapi->write('/system/resource/getall');
				$API_resource = $this->routerosapi->read();
				foreach ($API_resource as $data_res)
				{
					$d5 	= $data_res['uptime'];	
				}
				
		$this->telegram_lib_noc->sendmsg("".json_decode('"\u2728\u2728\u2728"')." <b>REPORT RADIO</b> ".json_decode('"\u2728\u2728\u2728"')."\n<pre>".json_decode('"\u27a1"')." Radio: <b>".$n_device."</b>\n".json_decode('"\u27a1"')." Tanggal: ".date("M/d/Y")."\n".json_decode('"\u27a1"')." Jam: ".date("H:i:s")." WITA\n".json_decode('"\u27a1"')." IP: <b>".$ip."</b>\n".json_decode('"\u27a1"')." CCQ: <b>".$d1."/".$d2."%</b>\n".json_decode('"\u27a1"')." Signal: <b>".$d3."/".$d4."</b>\n".json_decode('"\u27a1"')." Uptime: <b>".$d5."</b></pre>\n\nRegards,\n<b>Blippy Assistant</b>");		
		}
	}
	
	public function fo_raisecom_check_ntb($ip) {
		//Get Data from table Router
 		$this->db->select('*');
		$this->db->from('gm_router');
		$this->db->where("router_ip",$ip);
		$get_query = $this->db->get();
		$get_data = $get_query->row_array();
		
		if($get_data['TE'] == "1" && $get_data['media'] == "Fiber Optic (Onnet)")
		{
			$pon_str = $get_data['pon'];
			//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
			$this->load->library('phptelnet');
			$telnet1 = new PHPTelnet();
			$result1 = $telnet1->Connect('10.247.0.50','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			//$telnet2 = new PHPTelnet();
			//$result2 = $telnet2->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			if ($result1 == 0)
			{
			$telnet1->DoCommand('enable', $result1);
			$telnet1->DoCommand('raisecom', $result1);
			$telnet1->DoCommand('show interface epon-onu '.$pon_str.' online-information', $result1);
			$skuList = preg_split('/\r\n|\r|\n/', $result1);
				foreach($skuList as $key => $value )
				{
				$items_onu[] = $value;
				}
				//print_r($items_onu);
				//print_r($items_onu[4]);
				$ONU_Result = explode(" ",$items_onu[4]);
				//return print_r($ONU_Result);
				if($ONU_Result[7] == "offline"){
					if(isset($ONU_Result[32]) && isset($ONU_Result[33]) && isset($ONU_Result[34]))
					{
					$status_fo = "$ONU_Result[32] $ONU_Result[33] $ONU_Result[34]";
					$date_login = "$ONU_Result[28]";
					$date_logout = "$ONU_Result[30]";
					}
					else
					{
					$status_fo = "$ONU_Result[32] $ONU_Result[33]";
					$date_login = "$ONU_Result[28]";
					$date_logout = "$ONU_Result[30]";
					}
					$onu_status = $ONU_Result[7]." ".json_decode('"\u2757\u2757\u2757"');
				}else{
					if(isset($ONU_Result[32]) && isset($ONU_Result[33]) && isset($ONU_Result[34]))
					{
					$status_fo = "$ONU_Result[32] $ONU_Result[33] $ONU_Result[34]";
					$date_login = "$ONU_Result[28]";
					$date_logout = "$ONU_Result[30]";
					}
					else
					{
					$status_fo = "$ONU_Result[30] $ONU_Result[31]";
					$date_login = "$ONU_Result[26]";
					$date_logout = "$ONU_Result[28]";
					}
					$onu_status = $ONU_Result[7]." ".json_decode('"\u2705"');
				}
				//return print_r($ONU_Result);
				return $this->telegram_lib_noc->sendmsg("".json_decode('"\u2728"')."<b> REPORT FO ONNET RAISECOM </b>".json_decode('"\u2728"')."\n\n<pre><b>".$get_data['nama']."</b></pre>\n\nState: <b>".$onu_status."</b>\n<pre>".json_decode('"\u27a1"')."ONU ID: ".$ONU_Result[0]."\n".json_decode('"\u27a1"')."Login Date: ".$date_login."\n".json_decode('"\u27a1"')."Logout Date: ".$date_logout."\n".json_decode('"\u27a1"')."Logout Reason: <b>".$status_fo."</b>\n</pre>");
				//DC Telnet
				$telnet->Disconnect();
			}
		}
	}
	public function fo_raisecom_check_teknis($ip) {
		//Get Data from table Router
 		$this->db->select('*');
		$this->db->from('gm_router');
		$this->db->where("router_ip",$ip);
		$get_query = $this->db->get();
		$get_data = $get_query->row_array();
		
		if($get_data['TE'] == "1" && $get_data['media'] == "Fiber Optic (Onnet)")
		{
			$pon_str = $get_data['pon'];
			//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
			$this->load->library('phptelnet');
			$telnet1 = new PHPTelnet();
			$result1 = $telnet1->Connect('10.247.0.50','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			//$telnet2 = new PHPTelnet();
			//$result2 = $telnet2->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			if ($result1 == 0)
			{
			$telnet1->DoCommand('enable', $result1);
			$telnet1->DoCommand('raisecom', $result1);
			$telnet1->DoCommand('show interface epon-onu '.$pon_str.' online-information', $result1);
			$skuList = preg_split('/\r\n|\r|\n/', $result1);
				foreach($skuList as $key => $value )
				{
				$items_onu[] = $value;
				}
				//print_r($items_onu);
				//print_r($items_onu[4]);
				$ONU_Result = explode(" ",$items_onu[4]);
				//return print_r($ONU_Result);
				if(isset($ONU_Result[6])){
					if($ONU_Result[6] == "offline" && $ONU_Result[30] == "cut"){
						$status_fo = "$ONU_Result[32] $ONU_Result[33] $ONU_Result[34]";
						$date_login = "$ONU_Result[28]";
						$date_logout = "$ONU_Result[30]";
						$onu_status = $ONU_Result[6]." ".json_decode('"\u2757\u2757\u2757"');				
					}else{
						if($ONU_Result[6] == "online" && $ONU_Result[30] == "cut"){
						$status_fo = "$ONU_Result[28] $ONU_Result[29] $ONU_Result[30]";
						$date_login = "$ONU_Result[24]";
						$date_logout = "$ONU_Result[26]";
						$onu_status = $ONU_Result[6]." ".json_decode('"\u2705"');
						}
						if($ONU_Result[6] == "online" && $ONU_Result[30] == "Power"){
						$status_fo = "$ONU_Result[30] $ONU_Result[31]";
						$date_login = "$ONU_Result[26]";
						$date_logout = "$ONU_Result[28]";
						$onu_status = $ONU_Result[6]." ".json_decode('"\u2705"');
						}
						
					}
				}
				
				if(isset($ONU_Result[7])){
					if($ONU_Result[7] == "offline" && $ONU_Result[30] == "cut"){
						$status_fo = "$ONU_Result[32] $ONU_Result[33] $ONU_Result[34]";
						$date_login = "$ONU_Result[28]";
						$date_logout = "$ONU_Result[30]";
						$onu_status = $ONU_Result[7]." ".json_decode('"\u2757\u2757\u2757"');				
					}else{
						if($ONU_Result[7] == "online" && $ONU_Result[30] == "cut"){
						$status_fo = "$ONU_Result[28] $ONU_Result[29] $ONU_Result[30]";
						$date_login = "$ONU_Result[24]";
						$date_logout = "$ONU_Result[26]";
						$onu_status = $ONU_Result[7]." ".json_decode('"\u2705"');
						}
						if($ONU_Result[7] == "online" && $ONU_Result[30] == "Power"){
						$status_fo = "$ONU_Result[30] $ONU_Result[31]";
						$date_login = "$ONU_Result[26]";
						$date_logout = "$ONU_Result[28]";
						$onu_status = $ONU_Result[7]." ".json_decode('"\u2705"');
						}
						
					}
				}
				
				
				
				//print_r($ONU_Result);
				return $this->telegram_lib_noc->sendmsg("".json_decode('"\u2728"')."<b> REPORT FO ONNET RAISECOM </b>".json_decode('"\u2728"')."\n\n<pre><b>".$get_data['nama']."</b></pre>\n\nState: <b>".$onu_status."</b>\n<pre>".json_decode('"\u27a1"')."ONU ID: ".$ONU_Result[0]."\n".json_decode('"\u27a1"')."Login Date: ".$date_login."\n".json_decode('"\u27a1"')."Logout Date: ".$date_logout."\n".json_decode('"\u27a1"')."Logout Reason: <b>".$status_fo."</b>\n</pre>");
				//DC Telnet
				$telnet->Disconnect();
			}
		}
	}
	
	
	public function mondevices($ip,$name,$servicestatus) {
		date_default_timezone_set("Asia/Singapore");
		$this->load->helper(array('form', 'url'));
		$devicename = str_replace("%20"," ",$name);
		if($servicestatus == "up"){
		$this->telegram_lib_noc->sendmsg("".json_decode('"\u2705"')." <b>".$devicename."</b> is now <b>".$servicestatus."</b>");
		$Date = date("M/d/Y H:i:s");
			$data1 = array(
				'ip' => $ip,			
				'waktu_up' => $Date,
				'status' => "up",
			);
			$data2 = array(
				'status' => "1",
			);
		$array1 = array('device' => $devicename, 'status' => "down", 'ip' => $ip);
		$array2 = array('ip' => $ip);
		$this->db->where($array1);	
		$this->db->update('blip_mondevice', $data1);
		//$this->db->where($array2);	
		//$this->db->update('gm_router', $data2);		*
		}else{
		$this->telegram_lib_noc->sendmsg("".json_decode('"\u274C"')." <b>".$devicename."</b> is now <b>".$servicestatus."</b> ".json_decode('"\u2757\u2757\u2757"'));
		
		if($ip != "10.240.244.2"){
			$Date = date("M/d/Y H:i:s");
			$data1 = array(		
				'ip' => $ip,	
				'device' => $devicename,
				'waktu_down' => $Date,
				'status' => $servicestatus,
				'suspect' => "",
			);		
			$data2 = array(
				'status' => "1",
			);		
			$this->db->insert('blip_mondevice', $data1);
			
			$array2 = array('ip' => $ip);
			//$this->db->where($array2);	
			//$this->db->update('gm_router', $data2);	
			}
		}			
	}
	
	public function mondevices_ntb($ip,$name,$servicestatus) {
		date_default_timezone_set("Asia/Singapore");
		$this->load->helper(array('form', 'url'));
		$devicename = str_replace("%20"," ",$name);
		if($servicestatus == "up"){
		$this->telegram_lib->sendmsg("".json_decode('"\u2705"')." <b>".$devicename."</b> is now <b>".$servicestatus."</b>");
		$Date = date("M/d/Y H:i:s");
			$data1 = array(
				'ip' => $ip,			
				'waktu_up' => $Date,
				'status' => "up",
			);
			$data2 = array(
				'status' => "1",
			);
		$array1 = array('device' => $devicename, 'status' => "down", 'ip' => $ip);
		$array2 = array('ip' => $ip);
		$this->db->where($array1);	
		$this->db->update('blip_mon_dude', $data1);
		$this->db->where($array2);	
		$this->db->update('gm_router', $data2);			
		}else{
		$this->telegram_lib->sendmsg("".json_decode('"\u274C"')." <b>".$devicename."</b> is now <b>".$servicestatus."</b> ".json_decode('"\u2757\u2757\u2757"'));
		
		if($ip != "10.240.244.2"){
			$Date = date("M/d/Y H:i:s");
			$data1 = array(		
				'ip' => $ip,	
				'device' => $devicename,
				'waktu_down' => $Date,
				'status' => $servicestatus,
				'suspect' => "",
			);		
			$data2 = array(
				'status' => "1",
			);		
			$this->db->insert('blip_mon_dude', $data1);
			
			$array2 = array('ip' => $ip);
			$this->db->where($array2);	
			$this->db->update('gm_router', $data2);	
			}
		}			
	}
	
	public function dailyreport() {
		date_default_timezone_set("Asia/Singapore");
		$this->load->helper(array('form', 'url'));
		$daily  = $this->db->get_where('blip_mon_dude', array('status' => "down"))->result_array();
		$message_report = "";
		foreach($daily as $repdaily){
		$message_report .= json_decode('"\u27a1"')." Device: <b>".$repdaily['device']."</b>\n".json_decode('"\u27a1"')." Waktu Down: ".$repdaily['waktu_down']."\n".json_decode('"\u27a1"')." Status: <b>".$repdaily['status']."</b>\n\n";
		}
		
		if($message_report == NULL){
		$message = "<b>Tidak ada data down</b>";
		}else{
		$message = $message_report;
		}
		$this->telegram_lib_noc->sendmsg("".json_decode('"\u270F\u270F\u270F"')." <b>DAILY REPORT</b> ".json_decode('"\u270F\u270F\u270F"')."\n<pre>".$message."</pre>".json_decode('"\u270F\u270F\u270F"')." <b>DAILY REPORT</b> ".json_decode('"\u270F\u270F\u270F"')."\n\nRegards,\n<b>Blippy Assistant</b>");		
	}
	
	
}