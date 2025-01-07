<?php
defined('BASEPATH') or exit('No direct script access allowed');
class DudeWE extends CI_Controller {

   public function index() {
   		$this->load->database();
		$this->db->select('*');
        $this->db->from('gm_bts');
		$this->db->order_by("id", "asc");
		$this->db->limit(20,61);
		//$this->db->limit(1);
		$query = $this->db->get();
        $routerid = $query->result_array();
		$aplikasi = $this->db->get_where('gm_server', array('ip' => "103.255.242.22"))->row_array();
		
		//$routerid = $this->db->get('gm_bts')->order_by("id", "asc")->limit(1)->result_array();
		foreach($routerid as $radio)
			{
			//$LL = $this->db->get_where('gm_bts', array('id' => $radio['bts']))->row_array();
			//DECRYPT AKSES
			require_once APPPATH."third_party/addon.php";
			$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
			$ar_str_user = $radio['user'];
			$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
			$ar_str_pass = $radio['password'];
			$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
			$hostname = $radio['ip'];
			$username = $ar_dec_user;
			$password = $ar_dec_pass;
			
				//PROSES LOGIN			
				if ($this->routerosapi->connect($hostname,$username,$password))
				{	
				print("$radio[ip] LOGIN OK <br>");
				/*$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_History', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/file remove NOC_RADIO_CEK_LOG.rsc; /file remove NOC_RADIO_CEK_REALTIME.rsc; /system scheduler remove [find name=\"GmediaNOC_RSC_LOG\"]; /system scheduler remove [find name=\"GmediaNOC_RSC_REALTIME\"]; /system script remove [find name=\"NOC_RADIO_CEK_LOG\"]; /system script remove [find name=\"NOC_RADIO_CEK_REALTIME\"]; /system scheduler remove [find name=\"GmediaNOC_History\"]; ", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();*/
				
				$this->routerosapi->write('/system/scheduler/getall');								
				$list_scheduler = $this->routerosapi->read();
				foreach($list_scheduler as $scheduler)
				{
						$this->routerosapi->write('/system/scheduler/remove',false);
						$this->routerosapi->write('=.id='.$scheduler['.id']);
						$this->routerosapi->read();
				}
				
				$this->routerosapi->write('/system/script/getall');								
				$list_script = $this->routerosapi->read();
				foreach($list_script as $script)
				{
						$this->routerosapi->write('/system/script/remove',false);
						$this->routerosapi->write('=.id='.$script['.id']);
						$this->routerosapi->read();
				}
				
				$this->routerosapi->write('/ip/dns/set',false);
				$this->routerosapi->write('=servers=8.8.8.8,8.8.4.4');
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_CEKLOG', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/tool fetch url=\"https://".$aplikasi['ip_aplikasi']."/xdark/NOC_RADIO_CEK_LOG.rsc\" mode=https keep-result=yes; /system scheduler remove [find name=\"GmediaNOC_CEKLOG\"];", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_CEKREALTIME', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/tool fetch url=\"https://".$aplikasi['ip_aplikasi']."/xdark/NOC_RADIO_CEK_REALTIME.rsc\" mode=https keep-result=yes; /system scheduler remove [find name=\"GmediaNOC_CEKREALTIME\"];", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_RSC_LOG', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/import file-name=NOC_RADIO_CEK_LOG.rsc;");											
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_RSC_REALTIME', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/import file-name=NOC_RADIO_CEK_REALTIME.rsc;");											
				$this->routerosapi->read();
				
				//REMOVE ALL
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_History', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/file remove NOC_RADIO_CEK_LOG.rsc; /file remove NOC_RADIO_CEK_REALTIME.rsc; /system scheduler remove [find name=\"GmediaNOC_RSC_LOG\"]; /system scheduler remove [find name=\"GmediaNOC_RSC_REALTIME\"]; /system scheduler remove [find name=\"GmediaNOC_History\"]; ", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_LOG', false);							
				$this->routerosapi->write('=interval=00:00:10', false);   				
				$this->routerosapi->write('=start-time=startup', false);  
				$this->routerosapi->write('=on-event=NOC_RADIO_CEK_LOG', false);					
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_REALTIME', false);							
				$this->routerosapi->write('=interval=00:00:10', false);   				
				$this->routerosapi->write('=start-time=startup', false);  
				$this->routerosapi->write('=on-event=NOC_RADIO_CEK_REALTIME', false);					
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				print("$radio[ip] OK <br>");
			
				}
				else
				{
					print("$radio[ip] LOGIN GAGAL <br>");
					print("$radio[ip] GAGAL <br>");
				}	
			}
			return $this->session->set_flashdata('message','Data berhasil ditambahkan!');
	}
}