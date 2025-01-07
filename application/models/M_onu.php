<?php

class M_onu extends CI_Model {

    public function __construct() {
        $this->load->database();
		$this->load->helper(array('form', 'url'));
		$this->load->config('api_bot', true);
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_onu', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_onu');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function do_filter() {
		$olt = $this->input->post('olt');
		$qnq_vlan = $this->input->post('qnq_vlan');
		$query = $this->db->get_where('blip_onu', array('id_olt' => $olt,'qnq_vlan' => $qnq_vlan));
		$response = $query->result_array(); 
        return $response;
    }
	public function do_scan_sn() {
		$id_olt = $this->db->get('blip_olt')->result_array();
		foreach($id_olt as $olt){
		$hostname = $this->secure->decrypt_url($olt['olt_ip']);
		$username = $this->secure->decrypt_url($olt['olt_user']);
		$password = $this->secure->decrypt_url($olt['olt_pwd']);

			if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
				return print "$errstr ($errno)<br />\n";
			}else{
				$this->load->library('phptelnet');
				$telnet = new PHPTelnet();
				$result = $telnet->Connect($hostname,$username,$password);
				if ($result == 0)
				{
					$telnet->DoCommand('show gpon onu uncfg', $result);
					sleep(2);
					$skuList = preg_split('/\r\n|\r|\n/', $result);
						foreach($skuList as $key => $value )
						{
							$items_sn[] = $value;
	
						}
					//DC Telnet
					$telnet->Disconnect();	
					
				}
			}
   	 	}
		return print_r($items_sn);	
	}
	
	public function get_export($bsc = false) {
		$this->db->select('*');
		$this->db->from('blip_onu');
		if(!empty($bsc)){$this->db->where("id_olt",$bsc);}
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		$response = $query->result_array();
        return $response;
    }
	public function get_report_onu_tg_mtr() {		
	 date_default_timezone_set("Asia/Singapore"); 
	 $response = "<b>Update Preventive OLT BSC Nutana\nTanggal:".date("d/M/y H:i")." Wita</b>\n\n";
		
	 $online = $this->db->get_where('blip_onu', array('phase_state' => "working", 'id_olt' => "2"))->num_rows();
	 $offline = $this->db->get_where('blip_onu', array('phase_state' => "Offline", 'id_olt' => "2"))->num_rows();
	 $los = $this->db->get_where('blip_onu', array('phase_state' => "LOS", 'id_olt' => "2"))->num_rows();
	 $response .= "Online: ".$online."\nOffline: ".$offline."\nLOS: ".$los."\n\n";
	 $response .= "Regards,\n<b>Blippy Assistant</b>";
	 return $response;		
    }
	
	public function get_report_onu_tg_pmg() {		
	 date_default_timezone_set("Asia/Singapore"); 
	 $response = "<b>Update Preventive OLT BSC Pemenang\nTanggal:".date("d/M/y H:i")." Wita</b>\n\n";
		
	 $online = $this->db->get_where('blip_onu', array('phase_state' => "working", 'id_olt' => "1"))->num_rows();
	 $offline = $this->db->get_where('blip_onu', array('phase_state' => "Offline", 'id_olt' => "1"))->num_rows();
	 $los = $this->db->get_where('blip_onu', array('phase_state' => "LOS", 'id_olt' => "1"))->num_rows();
	 $response .= "Online: ".$online."\nOffline: ".$offline."\nLOS: ".$los."\n\n";
	 $response .= "Regards,\n<b>Blippy Assistant</b>";
	 return $response;		
    }
	
	
	public function simpan() {
		if(empty($this->input->post('port1'))){$port1 = "lock";}else{$port1 = "unlock";}
		if(empty($this->input->post('port2'))){$port2 = "lock";}else{$port2 = "unlock";}
		if(empty($this->input->post('port3'))){$port3 = "lock";}else{$port3 = "unlock";}
		if(empty($this->input->post('port4'))){$port4 = "lock";}else{$port4 = "unlock";}
		
		$data = array(
		'id_olt' => $this->input->post('olt'),
		'serial_number' => $this->input->post('serial_number'),
		'id_pelanggan' => $this->input->post('pelanggan'),
		'id_layanan1' => $this->input->post('layanan1'),
		'id_layanan2' => $this->input->post('layanan2'),
		'id_layanan3' => $this->input->post('layanan3'),
		'qnq_vlan' => $this->input->post('qnq_vlan'),
		'onu_index' => $this->input->post('onu_index'),
		'mgmt_ip' => $this->input->post('mgmt_ip'),
		'mgmt_gw' => $this->input->post('mgmt_gw'),
		'port1' => $port1,
		'port2' => $port2,
		'port3' => $port3,
		'port4' => $port4,
		'status' => "Unconfigured",
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$insert_db = $this->db->insert('blip_onu', $data);
		
		if($insert_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data ONU",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal menambah data.');
		}	
    }
	public function timpa($id) {
		if(empty($this->input->post('port1'))){$port1 = "lock";}else{$port1 = "unlock";}
		if(empty($this->input->post('port2'))){$port2 = "lock";}else{$port2 = "unlock";}
		if(empty($this->input->post('port3'))){$port3 = "lock";}else{$port3 = "unlock";}
		if(empty($this->input->post('port4'))){$port4 = "lock";}else{$port4 = "unlock";}
		
		$data = array(
		'id_olt' => $this->input->post('olt'),
		'serial_number' => $this->input->post('serial_number'),
		'id_pelanggan' => $this->input->post('pelanggan'),
		'id_layanan1' => $this->input->post('layanan1'),
		'id_layanan2' => $this->input->post('layanan2'),
		'id_layanan3' => $this->input->post('layanan3'),
		'qnq_vlan' => $this->input->post('qnq_vlan'),
		'onu_index' => $this->input->post('onu_index'),
		'mgmt_ip' => $this->input->post('mgmt_ip'),
		'mgmt_gw' => $this->input->post('mgmt_gw'),
		'port1' => $port1,
		'port2' => $port2,
		'port3' => $port3,
		'port4' => $port4,
		'status' => "Unconfigured",
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);	
		$this->db->where('id', $id);
		$set_db = $this->db->update('blip_onu', $data);			
		
		if($set_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data ONU",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal mengubah data.');
		}	
    }
	
	public function delete($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data Onu",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		//remoive Configuration
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_onu['id_pelanggan']))->row_array();

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);


		if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
			echo "$errstr ($errno)<br />\n";
		}else{
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect($hostname,$username,$password);
			if ($result == 0)
			{
				$telnet->DoCommand('configure terminal', $result);
				$telnet->DoCommand('interface gpon-olt_'.$id_layanan['pon'], $result);
				$telnet->DoCommand('no onu '.$id_onu['onu_index'], $result);
				sleep(2);
				$telnet->DoCommand('exit', $result);
				$telnet->DoCommand('exit', $result);
				$telnet->DoCommand('write', $result);
				sleep(3);
				
				//Update Status PON				
				$data = array(
				'status' => "Unconfigured",
				'history_waktu' => date("Y-m-d H:i"),
				'history_iduser' => $this->session->userdata('ses_id'),
				);	
				$this->db->where('id', $id);
				$set_db = $this->db->update('blip_onu', $data);	
				//DC Telnet
				$telnet->Disconnect();	
			}
		}
		
        return $this->db->delete('blip_onu', array('id' => $id));
    }
	
	public function generate($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Generate data Onu ID $id",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        
		//Generate Configuration
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		if(!empty($id_onu['id_layanan2'])){
		$id_layanan2 = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan2']))->row_array();
		}
		if(!empty($id_onu['id_layanan3'])){
		$id_layanan3 = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan3']))->row_array();
		};
		$id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_onu['id_pelanggan']))->row_array();
		
		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
			//Filter 1 Layanan
			if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
				echo "$errstr ($errno)<br />\n";
			}else{
				$this->load->library('phptelnet');
				$telnet = new PHPTelnet();
				$result = $telnet->Connect($hostname,$username,$password);
				if ($result == 0)
				{
					//Produk Filter BW
					if($id_layanan['id_produk'] == "1" || $id_layanan['id_produk'] == "6" || $id_layanan['id_produk'] == "7" || $id_layanan['id_produk'] == "8" || $id_layanan['id_produk'] == "13" || $id_layanan['id_produk'] == "14" || $id_layanan['id_produk'] == "21"){ 
					$bw_fix = $id_layanan['id_bandwidth']*2;
					}else{
					$bw_fix = $id_layanan['id_bandwidth']+5;
					}
					if(!empty($id_layanan2['id_produk'])){
					if($id_layanan2['id_produk'] == "1" || $id_layanan2['id_produk'] == "6" || $id_layanan2['id_produk'] == "7" || $id_layanan2['id_produk'] == "8" || $id_layanan2['id_produk'] == "13" || $id_layanan2['id_produk'] == "14" || $id_layanan['id_produk'] == "21"){ 
					$bw_fix2 = $id_layanan2['id_bandwidth']*2;
					}else{
					$bw_fix2 = $id_layanan2['id_bandwidth']+5;
					}
					}
					if(!empty($id_layanan3['id_produk'])){
					if($id_layanan3['id_produk'] == "1" || $id_layanan3['id_produk'] == "6" || $id_layanan3['id_produk'] == "7" || $id_layanan3['id_produk'] == "8" || $id_layanan3['id_produk'] == "13" || $id_layanan3['id_produk'] == "14" || $id_layanan['id_produk'] == "21"){ 
					$bw_fix3 = $id_layanan3['id_bandwidth']*2;
					}else{
					$bw_fix3 = $id_layanan3['id_bandwidth']+5;
					}
					}
					
					$telnet->DoCommand('configure terminal', $result);
					$telnet->DoCommand('interface gpon-olt_'.$id_layanan['pon'], $result);
					$telnet->DoCommand('onu '.$id_onu['onu_index'].' type ZXHN-F609 sn '.$id_onu['serial_number'], $result);
					sleep(2);
					$telnet->DoCommand('exit', $result);
					sleep(1);
					$telnet->DoCommand('interface gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
					$telnet->DoCommand('description "'.$id_pelanggan['cid'].' - '.$id_pelanggan['nama'].'"', $result);
					$telnet->DoCommand('tcont 1 profile GLOBAL-UPLOAD', $result);
					$telnet->DoCommand('gemport 1 name '.$id_pelanggan['cid'].' tcont 1', $result);
					$telnet->DoCommand('gemport 1 traffic-limit upstream '.$bw_fix.'M downstream '.$bw_fix.'M', $result);
					$telnet->DoCommand('service-port 1 vport 1 user-vlan '.$id_layanan['vlan'].' vlan '.$id_layanan['vlan'].' svlan '.$id_onu['qnq_vlan'], $result);
					if(!empty($id_onu['id_layanan2'])){
					$telnet->DoCommand('tcont 2 profile GLOBAL-UPLOAD', $result);
					$telnet->DoCommand('gemport 2 name '.$id_pelanggan['cid'].'-2 tcont 2', $result);
					$telnet->DoCommand('gemport 2 traffic-limit upstream '.$bw_fix2.'M downstream '.$bw_fix2.'M', $result);
					$telnet->DoCommand('service-port 4 vport 2 user-vlan '.$id_layanan2['vlan'].' vlan '.$id_layanan2['vlan'].' svlan '.$id_onu['qnq_vlan'], $result);
					}
					if(!empty($id_onu['id_layanan3'])){
					$telnet->DoCommand('tcont 3 profile GLOBAL-UPLOAD', $result);
					$telnet->DoCommand('gemport 3 name '.$id_pelanggan['cid'].'-3 tcont 3', $result);
					$telnet->DoCommand('gemport 3 traffic-limit upstream '.$bw_fix3.'M downstream '.$bw_fix3.'M', $result);
					$telnet->DoCommand('service-port 3 vport 3 user-vlan '.$id_layanan3['vlan'].' vlan '.$id_layanan3['vlan'].' svlan '.$id_onu['qnq_vlan'], $result);
					}									
					
					$telnet->DoCommand('service-port 2 vport 1 user-vlan 3991 vlan 3991 svlan '.$id_onu['qnq_vlan'], $result);
					$telnet->DoCommand('exit', $result);
					sleep(1);
					$telnet->DoCommand('pon-onu-mng gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
					$telnet->DoCommand('mgmt-ip '.$id_onu['mgmt_ip'].' 255.255.255.0 vlan 3991 priority 1 route 0.0.0.0 0.0.0.0 '.$id_onu['mgmt_gw'].' host 2', $result);
								
					$telnet->DoCommand('service MANAGEMENT gemport 1 vlan 3991', $result);
					$telnet->DoCommand('loop-detect ethuni eth_0/1 enable', $result);
					$telnet->DoCommand('broadcast-limit ethuni eth_0/1 20', $result);
					if(!empty($id_layanan['id_mode'])){
						if($id_layanan['id_mode'] == "Bridge"){
						$telnet->DoCommand('service "'.$id_pelanggan['cid'].'" gemport 1 vlan '.$id_layanan['vlan'], $result);
						$telnet->DoCommand('vlan port eth_0/1 mode hybrid def-vlan '.$id_layanan['vlan'], $result);
						}else{
						$telnet->DoCommand('service "'.$id_pelanggan['cid'].'" gemport 1 iphost 1 vlan '.$id_layanan['vlan'], $result);
						$telnet->DoCommand('pppoe 1 nat enable user '.$id_layanan['pppoe_user'].' password '.$id_layanan['pppoe_pass'], $result);			
						}
					}
					if(!empty($id_onu['id_layanan2'])){
					$telnet->DoCommand('service "'.$id_pelanggan['cid'].'-2" gemport 2 vlan '.$id_layanan2['vlan'], $result);
					$telnet->DoCommand('vlan port eth_0/4 mode hybrid def-vlan '.$id_layanan2['vlan'], $result);
					}
					if(!empty($id_onu['id_layanan3'])){
					$telnet->DoCommand('service "'.$id_pelanggan['cid'].'-3" gemport 3 vlan '.$id_layanan3['vlan'], $result);
					$telnet->DoCommand('vlan port eth_0/3 mode hybrid def-vlan '.$id_layanan3['vlan'], $result);	
					}
					
					$telnet->DoCommand('security-mgmt 1 state enable mode forward', $result);
					
					$telnet->DoCommand('interface eth eth_0/1 state '.$id_onu['port1'], $result);	
					$telnet->DoCommand('interface eth eth_0/2 state '.$id_onu['port2'], $result);	
					$telnet->DoCommand('interface eth eth_0/3 state '.$id_onu['port3'], $result);	
					$telnet->DoCommand('interface eth eth_0/4 state '.$id_onu['port4'], $result);	
					
					$telnet->DoCommand('exit', $result);
					$telnet->DoCommand('exit', $result);
					$telnet->DoCommand('write', $result);
					sleep(3);
					$telnet->DoCommand('exit', $result);
					
					//Update Status PON				
					$data = array(
					'status' => "Running",
					'history_waktu' => date("Y-m-d H:i"),
					'history_iduser' => $this->session->userdata('ses_id'),
					);	
					$this->db->where('id', $id);
					$set_db = $this->db->update('blip_onu', $data);	
					//DC Telnet
					$telnet->Disconnect();	
					return $this->session->set_flashdata('success', 'Berhasil generate data.');
				}
			}
    }
	
	public function unconfig($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Unconfig data Onu ID $id",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        
		//remoive Configuration
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_onu['id_pelanggan']))->row_array();

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);


		if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
			echo "$errstr ($errno)<br />\n";
		}else{
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect($hostname,$username,$password);
			if ($result == 0)
			{
				$telnet->DoCommand('configure terminal', $result);
				$telnet->DoCommand('interface gpon-olt_'.$id_layanan['pon'], $result);
				$telnet->DoCommand('no onu '.$id_onu['onu_index'], $result);
				sleep(2);
				$telnet->DoCommand('exit', $result);
				$telnet->DoCommand('exit', $result);
				$telnet->DoCommand('write', $result);
				sleep(3);
				
				//Update Status PON				
				$data = array(
				'status' => "Unconfigured",
				'history_waktu' => date("Y-m-d H:i"),
				'history_iduser' => $this->session->userdata('ses_id'),
				);	
				$this->db->where('id', $id);
				$set_db = $this->db->update('blip_onu', $data);	
				//DC Telnet
				$telnet->Disconnect();	
				return $this->session->set_flashdata('success', 'Berhasil remove konfigurasi.');
			}
		}
    }
	
	public function onu_profile($id) {	
        
		//Show Profile
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
			//Filter 1 Layanan
			if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
				echo "$errstr ($errno)<br />\n";
			}else{
				$this->load->library('phptelnet');
				$telnet = new PHPTelnet();
				$result = $telnet->Connect($hostname,$username,$password);
				if ($result == 0)
				{
					$telnet->DoCommand('show run interface gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);	
					$skuList = preg_split('/\r\n|\r|\n/', $result);
					foreach($skuList as $value )
					{
					$items_onu[] = $value;
					}
						$output="";
						foreach($items_onu as $onu )
						{
							$output.= $onu."<br>";
							
						}
						$response = $output;
						
				}
				//DC Telnet
				$telnet->Disconnect();
				return $response;
			}
    }
	
	public function onu_pon($id) {	
        
		//Show Profile
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
			//Filter 1 Layanan
			if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
				echo "$errstr ($errno)<br />\n";
			}else{
				$this->load->library('phptelnet');
				$telnet = new PHPTelnet();
				$result = $telnet->Connect($hostname,$username,$password);
				if ($result == 0)
				{
					$telnet->DoCommand('show onu running config gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);	
					$skuList = preg_split('/\r\n|\r|\n/', $result);
					foreach($skuList as $value )
					{
					$items_onu[] = $value;
					}
						$output="";
						foreach($items_onu as $onu )
						{
							$output.= $onu."<br>";
							
						}
						$response = $output;			
				}
				//DC Telnet
				$telnet->Disconnect();
				return $response;
			}
    }
	
	public function onu_detail_log($id) {	
        
		//Show Profile
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
			//Filter 1 Layanan
			if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
				echo "$errstr ($errno)<br />\n";
			}else{
				$this->load->library('phptelnet');
				$telnet = new PHPTelnet();
				$result = $telnet->Connect($hostname,$username,$password);
				if ($result == 0)
				{
					$telnet->DoCommand('show gpon onu detail-info gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);	
					$skuList = preg_split('/\r\n|\r|\n/', $result);
					foreach($skuList as $value )
					{
					$items_onu[] = $value;
					}
						$output="";
						foreach($items_onu as $onu )
						{
							$output.= $onu."<br>";		
						}
						$response = $output;
						
				}
				//DC Telnet
				$telnet->Disconnect();
				return $response;
			}
    }
	
	public function onu_reboot($id) {	
        
		//Show Profile
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_onu['id_pelanggan']))->row_array();

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
			//Filter 1 Layanan
			if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
				echo "$errstr ($errno)<br />\n";
			}else{
				$this->load->library('phptelnet');
				$telnet = new PHPTelnet();
				$result = $telnet->Connect($hostname,$username,$password);
				if ($result == 0)
				{
					$telnet->DoCommand('configure terminal', $result);
					$telnet->DoCommand('pon-onu-mng gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);	
					$telnet->DoCommand('reboot', $result);
					$telnet->DoCommand('yes', $result);
				}
				//DC Telnet
				$telnet->Disconnect();
				return "Proses Restart ONU <b>".$id_pelanggan['nama']."</b>. . .";
			}
    }
	public function onu_port($id,$port,$act) {	
        
		//Show Profile
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_onu['id_pelanggan']))->row_array();

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
			//Filter 1 Layanan
			if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
				echo "$errstr ($errno)<br />\n";
			}else{
				$this->load->library('phptelnet');
				$telnet = new PHPTelnet();
				$result = $telnet->Connect($hostname,$username,$password);
				if ($result == 0)
				{
					$telnet->DoCommand('configure terminal', $result);
					$telnet->DoCommand('pon-onu-mng gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);	
					$telnet->DoCommand('interface eth eth_0/'.$port.' state '.$act, $result);
					$telnet->DoCommand('exit', $result);
				}
				//DC Telnet
				$telnet->Disconnect();
				
				//Update DB
				$data = array(
				'port'.$port => $act,
				'history_waktu' => date("Y-m-d H:i"),
				'history_iduser' => $this->session->userdata('ses_id'),
				);	
				$this->db->where('id', $id);
				return $this->db->update('blip_onu', $data);	
			}
    }
	
	public function redaman($id) {	
        
		//Show Profile
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$identity_OLT = $id_olt['olt_nama']."#";

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
			//Filter 1 Layanan
			if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
				echo "$errstr ($errno)<br />\n";
			}else{
				$this->load->library('phptelnet');
				$telnet = new PHPTelnet();
				$result = $telnet->Connect($hostname,$username,$password);
				//Cek Redaman
				if ($result == 0)
				{
				$telnet->DoCommand('', $result);
				$telnet->DoCommand('show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
				$telnet->DoCommand('', $result);
				$skuList = preg_split('/\r\n|\r|\n/', $result);
					foreach($skuList as $key => $value2 )
					{
						if($value2 == 'show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'])
						{ echo""; }
						elseif($value2 == "           OLT                  ONU              Attenuation")
						{ echo""; }
						elseif($value2 == "--------------------------------------------------------------------------")
						{ echo""; }
						elseif($value2 == $identity_OLT)
						{ echo""; }
						else
						{
						$items_onu2[] = $value2;
						}
					}
				}
				//DC Telnet
				$telnet->Disconnect();			
				return print_r($items_onu2);
			}	

			
    }
	
	public function set_redaman_mtr($id){
		
		sleep(10);
		//Show Profile
		$this->load->helper(array('form', 'url'));
		$this->load->library('phptelnet');
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_onu['id_pelanggan']))->row_array();
		$identity_OLT = $id_olt['olt_nama']."#";
		
		/*if($id_pelanggan['status_pelanggan'] == "0"){
		$status_pelanggan =  "Tidak Aktif";
		}elseif($id_pelanggan['status_pelanggan'] == "1"){
	    $status_pelanggan =  "Aktif";
		}elseif($id_pelanggan['status_pelanggan'] == "2"){
	    $status_pelanggan =  "Isolir";
		}elseif($id_pelanggan['status_pelanggan'] == "3"){
	    $status_pelanggan =  "Dismantle";
		}*/

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);

		//Filter 1 Layanan
		if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
			echo "$errstr ($errno)<br />\n";
		}else{
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect($hostname,$username,$password);
			//Cek Redaman
			if ($result == "0")
			{			
			$telnet->DoCommand('', $result);
			$telnet->DoCommand('show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
			$telnet->DoCommand('', $result);
			
			
			$skuList1 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList1 as $key => $value2 )
				{
				
					if($value2 == 'show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'])
					{ echo""; }
					elseif($value2 == "           OLT                  ONU              Attenuation")
					{ echo""; }
					elseif($value2 == "--------------------------------------------------------------------------")
					{ echo""; }
					elseif($value2 == $identity_OLT)
					{ echo""; }
					else
					{
					$items_onu2[] = $value2;
					}
				}
				
			//$telnet->DoCommand('show gpon onu detail-info gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
			$telnet->DoCommand('show gpon onu sta gpon-olt_'.$id_layanan['pon'].' '.$id_onu['onu_index'], $result);
			$skuList2 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList2 as $key => $value1)
				{
				$items_onu[] = $value1;
				}				
			
			//$phase_state = explode(" ",$items_onu[9]);
			$phase_state = explode(" ",$items_onu[3]);
			$get_up_tx = explode(" ",$items_onu2[0]);
			$get_up_rx = explode(" ",$items_onu2[2]);
			
			
			
			$pesan_tg = "".json_decode('"\u2728"')."<b> REPORT FO ONNET ZTE </b>".json_decode('"\u2728"')."\n\n";
			//$pesan_tg .= "Pelanggan: <b>".$id_pelanggan['nama']."</b>\nSerial Number: ".$id_onu['serial_number']."\nRedaman TX: <b>".$up_tx."</b>\nRedaman RX: <b>".$down_rx."</b>\nPhase State: <b>".$state." ".$phase."</b>\n\n";
			$pesan_tg .= "Pelanggan: <b>".$id_pelanggan['nama']."</b>\nSerial Number: <b>".$id_onu['serial_number']."</b>\nONU Interface: <b>gpon-onu_".$id_layanan['pon'].":".$id_onu['onu_index']."</b>\nIP Address: <b>".$id_onu['mgmt_ip']."</b>\nPhase State: <b>".$phase_state[18]."</b>\nRedaman Tx".$get_up_tx[8]."\nRedaman ".$get_up_rx[14]."\n\n";
			$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
			//DC Telnet
			$telnet->Disconnect();
			
			/*
			if(isset($items_onu[9])){
			$phase_state = explode(" ",$items_onu[9]);
				if($phase_state[12] == "LOS"){
				$phase="LOS";
				}elseif($phase_state[12] == "working"){
				$phase="working";
				}else{
				$phase="Offline";
				}
			}else{
			$phase_state = "Unknown";
			$phase="Offline";
			}
			
			if(isset($items_onu2[0])){
			$get_up_tx = explode(" ",$items_onu2[0]);
				if(isset($get_up_tx[8])){
				$up_tx = str_replace(":","",$get_up_tx[8]);
				}else{
				$up_tx = "No Signal";
				}
			}else{
			$get_up_tx="";$up_tx = "No Signal";
			}
			
			if(isset($items_onu2[2])){
			$get_up_rx = explode(" ",$items_onu2[2]);
			
				if(isset($get_up_tx[8])){
				$down_rx = str_replace("Rx:","",$get_up_rx[14]);
				}else{
				$down_rx = "No Signal";
				}
			}else{
			$get_up_rx="";
			$down_rx = "No Signal";
			}
			
			if($phase == "working"){
				$state = json_decode('"\u2705"');
			}else{
				$state = json_decode('"\u274C"');
			}
			*/
			
			if(isset($get_up_tx[8])){
			$up_tx = str_replace(":","",$get_up_tx[8]);
			}
			if(isset($get_up_rx[14])){
			$down_rx = str_replace("Rx:","",$get_up_rx[14]);
			}
			
			$data = array(
			'up_tx' => $up_tx,
			'down_rx' => $down_rx,
			'phase_state' => $phase_state[18],
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
			);	
			$this->db->where('id', $id);
			$this->db->update('blip_onu', $data);		
			
			return $this->telegram_lib->sendblip("-1001406929911",$pesan_tg);
			//return $this->telegram_lib->sendblip("250170651",$pesan_tg);
			
			}else{
			return print_r($result);
			}
		}
	}
	
	public function set_redaman_pmg($id){
		
		sleep(10);
		//Show Profile
		$this->load->helper(array('form', 'url'));
		$this->load->library('phptelnet');
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_onu['id_pelanggan']))->row_array();
		$identity_OLT = $id_olt['olt_nama']."#";
		
		/*if($id_pelanggan['status_pelanggan'] == "0"){
		$status_pelanggan =  "Tidak Aktif";
		}elseif($id_pelanggan['status_pelanggan'] == "1"){
	    $status_pelanggan =  "Aktif";
		}elseif($id_pelanggan['status_pelanggan'] == "2"){
	    $status_pelanggan =  "Isolir";
		}elseif($id_pelanggan['status_pelanggan'] == "3"){
	    $status_pelanggan =  "Dismantle";
		}*/

		//$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		//$username = $this->secure->decrypt_url($id_olt['olt_user']);
		//$password = $this->secure->decrypt_url($id_olt['olt_pwd']);

		//Filter 1 Layanan
		if (fsockopen("10.247.0.22", 22, $errno, $errstr, 30) == NULL){
			echo "$errstr ($errno)<br />\n";
		}else{
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			//Cek Redaman
			if ($result == "0")
			{			
			$telnet->DoCommand('', $result);
			$telnet->DoCommand('show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
			$telnet->DoCommand('', $result);
			
			
			$skuList1 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList1 as $key => $value2 )
				{
				
					if($value2 == 'show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'])
					{ echo""; }
					elseif($value2 == "           OLT                  ONU              Attenuation")
					{ echo""; }
					elseif($value2 == "--------------------------------------------------------------------------")
					{ echo""; }
					elseif($value2 == $identity_OLT)
					{ echo""; }
					else
					{
					$items_onu2[] = $value2;
					}
				}
				
			//$telnet->DoCommand('show gpon onu detail-info gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
			$telnet->DoCommand('show gpon onu state gpon-olt_'.$id_layanan['pon'].' '.$id_onu['onu_index'], $result);
			$skuList2 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList2 as $key => $value1)
				{
				$items_onu[] = $value1;
				}				
			
			//$phase_state = explode(" ",$items_onu[9]);
			$phase_state = explode(" ",$items_onu[3]);
			$get_up_tx = explode(" ",$items_onu2[0]);
			$get_up_rx = explode(" ",$items_onu2[2]);
			/*
			if(isset($items_onu[9])){
			$phase_state = explode(" ",$items_onu[9]);
				if($phase_state[12] == "LOS"){
				$phase="LOS";
				}elseif($phase_state[12] == "working"){
				$phase="working";
				}else{
				$phase="Offline";
				}
			}else{
			$phase_state = "Unknown";
			$phase="Offline";
			}
			
			if(isset($items_onu2[0])){
			$get_up_tx = explode(" ",$items_onu2[0]);
				if(isset($get_up_tx[8])){
				$up_tx = str_replace(":","",$get_up_tx[8]);
				}else{
				$up_tx = "No Signal";
				}
			}else{
			$get_up_tx="";$up_tx = "No Signal";
			}
			
			if(isset($items_onu2[2])){
			$get_up_rx = explode(" ",$items_onu2[2]);
			
				if(isset($get_up_tx[8])){
				$down_rx = str_replace("Rx:","",$get_up_rx[14]);
				}else{
				$down_rx = "No Signal";
				}
			}else{
			$get_up_rx="";
			$down_rx = "No Signal";
			}

			
			
			$data = array(
			'up_tx' => $up_tx,
			'down_rx' => $down_rx,
			'phase_state' => $phase,
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
			);	
			$this->db->where('id', $id);
			$this->db->update('blip_onu', $data);
			
			if($phase == "working"){
				$state = json_decode('"\u2705"');
			}else{
				$state = json_decode('"\u274C"');
			}
			*/
			
			$pesan_tg = "".json_decode('"\u2728"')."<b> REPORT FO ONNET ZTE </b>".json_decode('"\u2728"')."\n\n";
			//$pesan_tg .= "Pelanggan: <b>".$id_pelanggan['nama']."</b>\nSerial Number: ".$id_onu['serial_number']."\nRedaman TX: ".$up_tx."\nRedaman RX: ".$down_rx."\nPhase State: <b>".$state." ".$phase."</b>\n\n";
			$pesan_tg .= "Pelanggan: <b>".$id_pelanggan['nama']."</b>\nSerial Number: <b>".$id_onu['serial_number']."</b>\nONU Interface: <b>gpon-onu_".$id_layanan['pon'].":".$id_onu['onu_index']."</b>\nIP Address: <b>".$id_onu['mgmt_ip']."</b>\nPhase State: <b>".$phase_state[18]."</b>\nRedaman Tx".$get_up_tx[8]."\nRedaman ".$get_up_rx[14]."\n\n";
			$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";

			//DC Telnet
			$telnet->Disconnect();
			
			if(isset($get_up_tx[8])){
			$up_tx = str_replace(":","",$get_up_tx[8]);
			}
			if(isset($get_up_rx[14])){
			$down_rx = str_replace("Rx:","",$get_up_rx[14]);
			}
			
			$data = array(
			'up_tx' => $up_tx,
			'down_rx' => $down_rx,
			'phase_state' => $phase_state[18],
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
			);	
			$this->db->where('id', $id);
			$this->db->update('blip_onu', $data);			
			
			return $this->telegram_lib->sendblip("-1001406929911",$pesan_tg);
			//return $this->telegram_lib->sendblip("250170651",$pesan_tg);
			}else{
			return print_r($result);
			}
		}
	}
	
//END	
}
