<?php

class Bts_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	public function serverROW() {
        $response = false;

            $query = $this->db->get('gm_server');
            $response = $query->row_array();

        return $response;
    }
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_bts', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_bts');
			//$this->db->limit(1, 1);
			$this->db->order_by("nama_bts", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	public function count() {
        if($this->session->userdata('ses_admin') == "1" || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5')
		{
        return $this->db->get('gm_bts')->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_bts')->num_rows();
		}
    }

	
	public function getALL($id) {
            $this->db->select('gm_bts');
            $this->db->from('gm_bts');
            $this->db->where('gm_bts.id', $id);
            $query = $this->db->get();
			$response = $query->result_array();

        return $response;
    }
	
	public function getEXPORT() {
            $this->db->select('*');
            $this->db->from('gm_bts');
			$this->db->order_by("nama_bts", "asc");
            return $this->db->get();
    }
	
    public function simpan() {
		//ENKRIPSI PASSWORD ROUTER
		$serverid = $this->db->get('gm_server')->row_array();
		$ip = $this->secure->encrypt_url($this->input->post('ip'));
		$user = $this->secure->encrypt_url($this->input->post('password'));
		$pass = $this->secure->encrypt_url($this->input->post('password'));
		$hostname = $this->input->post('ip');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$port = $this->input->post('port');
		$aplikasi = $serverid['ip_aplikasi'];			
		if ($this->routerosapi->connect($hostname, $username, $password, $port))
			{
				$this->routerosapi->write('/system/identity/getall');
				$API_ident = $this->routerosapi->read();
				foreach ($API_ident as $data_getall_1)
				{
					$data_identity 	= $data_getall_1['name'];	
				}
				$this->routerosapi->write('/ip/dns/set',false);
				$this->routerosapi->write('=servers=8.8.8.8,8.8.4.4');
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_CEKLOG', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/tool fetch url=\"https://".$aplikasi."/xdark/NOC_RADIO_CEK_LOG.rsc\" mode=https keep-result=yes; /system scheduler remove [find name=\"GmediaNOC_CEKLOG\"];", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_CEKREALTIME', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/tool fetch url=\"https://".$aplikasi."/xdark/NOC_RADIO_CEK_REALTIME.rsc\" mode=https keep-result=yes; /system scheduler remove [find name=\"GmediaNOC_CEKREALTIME\"];", false);								
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
				
				//Cek Frek Wireless
				$this->routerosapi->write('/interface/wireless/print', false);
				$this->routerosapi->write("=count-only=");
				$API_WE = $this->routerosapi->read();
				//$COUNT = strlen($API_WE);
				if($API_WE > 1)
				{
				$this->routerosapi->write('/interface/wireless/getall');
				$API_WE_1 = $this->routerosapi->read();
				$we_frek = "";
				$we_protocol= "";
				$ssid = "";
				$band = "";
				foreach ($API_WE_1 as $WE)
					{
						$we_frek .= $WE['frequency']."<br>";	
						$we_protocol .= $WE['wireless-protocol']."<br>";	
						$ssid .= $WE['ssid']."<br>";	
						$band .= $WE['band']."<br>";
						$we_status .= $WE['disabled']."<br>";
						$mac_we .= $WE['mac-address']."<br>";
					} 
				}
				else
				{
				$this->routerosapi->write('/interface/wireless/getall');
				$API_WE_1 = $this->routerosapi->read();
				foreach ($API_WE_1 as $WE)
					{
						$we_frek = $WE['frequency'];
						$we_protocol= $WE['wireless-protocol'];		
						$ssid= $WE['ssid'];
						$band= $WE['band'];
						$we_status= $WE['disabled'];
						$mac_we= $WE['mac-address'];
					}  
				}
				
				
				//Cek Ethernet
				$this->routerosapi->write('/interface/ethernet/print', false);
				$this->routerosapi->write("=count-only=");
				$API_ETHER = $this->routerosapi->read();
				$COUNT_ETH = strlen($API_ETHER);
				if($COUNT_ETH > 1)
				{
				$this->routerosapi->write('/interface/ethernet/getall');
				$API_ETH = $this->routerosapi->read();
				$mac_eth = "";
				foreach ($API_ETH as $ETH)
					{
						$mac_eth .= $ETH['address'].",";
					}  
				}
				else
				{
				$this->routerosapi->write('/interface/ethernet/getall');
				$API_ETH = $this->routerosapi->read();
				foreach ($API_ETH as $ETH)
					{
						$mac_eth = $ETH['mac-address'];
					} 
				}
				
				//Cek SN			
				$this->routerosapi->write('/system/routerboard/getall');
				$API_SN = $this->routerosapi->read();
				foreach ($API_SN as $SN)
					{
						$serial_number = $SN['serial-number'];
						$model = $SN['model'];
					} 
				
				$data = array(
				'nama_bts' => $this->input->post('nama_bts'),
				'sektor_bts' => $data_identity,
				'mac_we' => $mac_we,
				'mac_eth' => $mac_eth,
				'serial_number' => $serial_number,
				'model' => $model,
				'ip' => $this->input->post('ip'),
				'user' => $user,
				'password' => $pass,
				'port' => $this->input->post('port'),
				'status' => "0",
				'frek' => $we_frek,
				'band' => $band,
				'frek' => $we_frek,
				'protocol' => $we_protocol,
				'ssid' => $ssid,
				'station' => $API_WE,
				'b4_protocol' => $this->input->post('b4_protocol'),
				'b4_frek' => $this->input->post('b4_frek'),
				'we_status' => $we_status,
				);				
				$this->db->insert('gm_bts', $data);
				
				
				$this->routerosapi->disconnect();	
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
			}	
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
    }

    public function timpa($id) {
        
        $data = array(
				'nama_bts' => $this->input->post('nama_bts'),
				'ip' => $this->input->post('ip'),
				'port' => $this->input->post('port'),
				'b4_protocol' => $this->input->post('b4_protocol'),
				'b4_frek' => $this->input->post('b4_frek'),
				);						
		$this->db->where('id', $id);
		$this->db->update('gm_bts', $data);
        return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
    }
	
    public function delete($id) {	
		$router = $this->get($id);
		
		$hostname = $router['ip'];
		$username = $this->secure->decrypt_url($router['user']);
		$password = $this->secure->decrypt_url($router['password']);
		$port = $router['port'];
			
		if ($this->routerosapi->connect($hostname, $username, $password, $port))
			{
				//REMOVE ALL
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
				$this->routerosapi->disconnect();
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal !');
			}
		$this->db->delete('gm_log_radio_realtime', array('sektor' => $router['sektor_bts']));
        return $this->db->delete('gm_bts', array('id' => $id));

        return false;
    }
	
	public function reload() {
        
        $btsdata = $this->get();
		foreach($btsdata as $btsid)
		{
		
		$hostname = $btsid['ip'];
		$username = $this->secure->decrypt_url($btsid['user']);
		$password = $this->secure->decrypt_url($btsid['password']);
		$port = $btsid['port'];
		
		$cek_script = "OK";
		//Cek Status Login
		if ($this->routerosapi->connect($hostname, $username, $password, $port))
		{
			$cek_login = "OK";
			$this->routerosapi->write('/system/resource/getall');
			$API_CEK0 = $this->routerosapi->read();
				foreach ($API_CEK0 as $CEK0)
				{
					$cek_os = $CEK0['version'];
				}
		}
		else
		{
			$cek_login = "NOK";
			$cek_os = "-";
			$cek_user = "-";
			$cek_script = "-";
			$cek_addrlist = "-";
			$cek_port_ssh = "-";
		}
		
		//Jika Login Sukses
		if($cek_login == "OK")
		{
		//Cek User Lain
			$this->routerosapi->write('/user/print',false);				
			$this->routerosapi->write("=count-only=");													
			$API_CEK1 = $this->routerosapi->read();
			if($API_CEK1 > 2) {
			$cek_user = "NOK";
			} else { 
			$cek_user = "OK"; 
			}
			//Cek Script Mencurigakan
			$this->routerosapi->write('/system/scheduler/print',false);				
			$this->routerosapi->write("=.proplist=name", false);		
			$this->routerosapi->write("?name=U6");													
			$API_CEK2 = $this->routerosapi->read();
				foreach ($API_CEK2 as $CEK2){
					$PENGECEKAN2 = $CEK2['name'];
				}
			//Cek Script Mencurigakan
			$this->routerosapi->write('/system/scheduler/print',false);				
			$this->routerosapi->write("=.proplist=name", false);		
			$this->routerosapi->write("?name=U7");													
			$API_CEK3 = $this->routerosapi->read();
				foreach ($API_CEK3 as $CEK3){
					$PENGECEKAN3 = $CEK3['name'];
				}
			if(!empty($PENGECEKAN2) || !empty($PENGECEKAN3)){
				if($PENGECEKAN2 == "U6" || $PENGECEKAN3 == "U7") {
				$cek_script = "NOK";
				}
			} else {
			$cek_script = "OK";
			}
			//Cek Address List
			$this->routerosapi->write('/ip/firewall/address-list/print',false);				
			$this->routerosapi->write("=.proplist=list", false);		
			$this->routerosapi->write("?list=WL");													
			$API_CEK4 = $this->routerosapi->read();
				foreach ($API_CEK4 as $CEK4){
					$PENGECEKAN4 = $CEK4['name'];
				}
			if(!empty($PENGECEKAN4)) {
			$cek_addrlist = "NOK";
			} else { 
			$cek_addrlist = "OK"; 
			}
			//Cek Service Port SSH
			$this->routerosapi->write('/ip/service/print',false);				
			$this->routerosapi->write("=.proplist=name", false);
			$this->routerosapi->write("=.proplist=port", false);
			$this->routerosapi->write("=.proplist=disabled", false);		
			$this->routerosapi->write("?name=ssh");													
			$API_CEK5 = $this->routerosapi->read();
				foreach ($API_CEK5 as $CEK5){
					$PENGECEKAN5 = $CEK5['port'];
					$SERVICE_SSH = $CEK5['disabled'];
				}
			if($SERVICE_SSH != "true"){
				if($PENGECEKAN5 == "22" || $PENGECEKAN5 == "2292") {
				$cek_port_ssh = "$PENGECEKAN5 - OK";
				} else { 
				$cek_port_ssh = "NOK"; 
				}
			} else {
			$cek_port_ssh = "OK (Tidak Aktif)";
			}
			
		//Cek Frek Wireless
		$this->routerosapi->write('/interface/wireless/print', false);
		$this->routerosapi->write("=count-only=");
		$API_WE = $this->routerosapi->read();
		$COUNT = strlen($API_WE);
		if($API_WE > 1)
		{
		$this->routerosapi->write('/interface/wireless/getall');
		$API_WE_1 = $this->routerosapi->read();
		$we_frek = "";
		$we_protocol= "";
		$ssid = "";
		$band = "";
		foreach ($API_WE_1 as $WE)
			{
				$we_frek .= $WE['frequency']."<br>";	
				$we_protocol .= $WE['wireless-protocol']."<br>";	
				$ssid .= $WE['ssid']."<br>";	
				$band .= $WE['band']."<br>";
				$we_status .= $WE['disabled']."<br>";
				$mac_we .= $WE['mac-address']."<br>";
			} 
		}
		else
		{
		$this->routerosapi->write('/interface/wireless/getall');
		$API_WE_1 = $this->routerosapi->read();
		foreach ($API_WE_1 as $WE)
			{
				$we_frek = $WE['frequency'];
				$we_protocol= $WE['wireless-protocol'];		
				$ssid= $WE['ssid'];
				$band= $WE['band'];
				$we_status= $WE['disabled'];
				$mac_we= $WE['mac-address'];
			}  
		}
		
		
		//Cek Ethernet
		$this->routerosapi->write('/interface/ethernet/print', false);
		$this->routerosapi->write("=count-only=");
		$API_ETHER = $this->routerosapi->read();
		$COUNT_ETH = strlen($API_ETHER);
		if($COUNT_ETH > 1)
		{
		$this->routerosapi->write('/interface/ethernet/getall');
		$API_ETH = $this->routerosapi->read();
		$mac_eth = "";
		foreach ($API_ETH as $ETH)
			{
				$mac_eth .= $ETH['address'].",";
			}  
		}
		else
		{
		$this->routerosapi->write('/interface/ethernet/getall');
		$API_ETH = $this->routerosapi->read();
		foreach ($API_ETH as $ETH)
			{
				$mac_eth = $ETH['mac-address'];
			} 
		}
		
		//Cek SN			
		$this->routerosapi->write('/system/routerboard/getall');
		$API_SN = $this->routerosapi->read();
		foreach ($API_SN as $SN)
			{
				$serial_number = $SN['serial-number'];
				$model = $SN['model'];
			} 	
			
			
		//Update Database
		$newDate = date("M/d/Y H:i:s");
		$data = array(
		'cek_login' => $cek_login,
		'cek_os' => $cek_os,
		'cek_user' => $cek_user,
		'cek_script' => $cek_script,
		'cek_addrlist' => $cek_addrlist,
		'cek_port_ssh' => $cek_port_ssh,
		'band' => $band,
		'frek' => $we_frek,
		'protocol' => $we_protocol,
		'we_status' => $we_status,
		'ssid' => $ssid,
		'station' => $API_WE,
		'waktu' => $newDate,
		'mac_we' => $mac_we,
		'mac_eth' => $mac_eth,
		'serial_number' => $serial_number,
		'model' => $model,
		);						
		$this->db->where('id', $btsid['id']);
		$this->db->update('gm_bts', $data);
	  }
    }
	return $this->session->set_flashdata('success', 'Reload Done');
	}
	
	
	public function maintenance() {
        
        $btsdata = $this->get();
		foreach($btsdata as $btsid)
		{
	
		
		$hostname = $btsid['ip'];
		$username = $this->secure->decrypt_url($btsid['user']);
		$password = $this->secure->decrypt_url($btsid['password']);
		$port = $btsid['port'];
		
		$cek_script = "OK";
		//Cek Status Login
		if ($this->routerosapi->connect($hostname, $username, $password, $port))
		{
			$cek_login = "OK";
			$this->routerosapi->write('/system/resource/getall');
			$API_CEK0 = $this->routerosapi->read();
				foreach ($API_CEK0 as $CEK0)
				{
					$cek_os = $CEK0['version'];
				}
		}
		else
		{
			$cek_login = "NOK";
			$cek_os = "-";
			$cek_user = "-";
			$cek_script = "-";
			$cek_addrlist = "-";
			$cek_port_ssh = "-";
		}
		
		//Jika Login Sukses
		if($cek_login == "OK")
		{
		//Cek User Lain
			$this->routerosapi->write('/user/print',false);				
			$this->routerosapi->write("=count-only=");													
			$API_CEK1 = $this->routerosapi->read();
			if($API_CEK1 > 2) {
			$cek_user = "NOK";
			} else { 
			$cek_user = "OK"; 
			}
			//Cek Script Mencurigakan
			$this->routerosapi->write('/system/scheduler/print',false);				
			$this->routerosapi->write("=.proplist=name", false);		
			$this->routerosapi->write("?name=U6");													
			$API_CEK2 = $this->routerosapi->read();
				foreach ($API_CEK2 as $CEK2){
					$PENGECEKAN2 = $CEK2['name'];
				}
			//Cek Script Mencurigakan
			$this->routerosapi->write('/system/scheduler/print',false);				
			$this->routerosapi->write("=.proplist=name", false);		
			$this->routerosapi->write("?name=U7");													
			$API_CEK3 = $this->routerosapi->read();
				foreach ($API_CEK3 as $CEK3){
					$PENGECEKAN3 = $CEK3['name'];
				}
			if(!empty($PENGECEKAN2) || !empty($PENGECEKAN3)){
				if($PENGECEKAN2 == "U6" || $PENGECEKAN3 == "U7") {
				$cek_script = "NOK";
				}
			} else {
			$cek_script = "OK";
			}
			//Cek Address List
			$this->routerosapi->write('/ip/firewall/address-list/print',false);				
			$this->routerosapi->write("=.proplist=list", false);		
			$this->routerosapi->write("?list=WL");													
			$API_CEK4 = $this->routerosapi->read();
				foreach ($API_CEK4 as $CEK4){
					$PENGECEKAN4 = $CEK4['name'];
				}
			if(!empty($PENGECEKAN4)) {
			$cek_addrlist = "NOK";
			} else { 
			$cek_addrlist = "OK"; 
			}
			//Cek Service Port SSH
			$this->routerosapi->write('/ip/service/print',false);				
			$this->routerosapi->write("=.proplist=name", false);
			$this->routerosapi->write("=.proplist=port", false);
			$this->routerosapi->write("=.proplist=disabled", false);		
			$this->routerosapi->write("?name=ssh");													
			$API_CEK5 = $this->routerosapi->read();
				foreach ($API_CEK5 as $CEK5){
					$PENGECEKAN5 = $CEK5['port'];
					$SERVICE_SSH = $CEK5['disabled'];
				}
			if($SERVICE_SSH != "true"){
				if($PENGECEKAN5 == "22" || $PENGECEKAN5 == "2292") {
				$cek_port_ssh = "$PENGECEKAN5 - OK";
				} else { 
				$cek_port_ssh = "NOK"; 
				}
			} else {
			$cek_port_ssh = "OK (Tidak Aktif)";
			}
			
		//Cek Frek Wireless
		$this->routerosapi->write('/interface/wireless/print', false);
		$this->routerosapi->write("=count-only=");
		$API_WE = $this->routerosapi->read();
		$COUNT = strlen($API_WE);
		if($API_WE > 1)
		{
		$this->routerosapi->write('/interface/wireless/getall');
		$API_WE_1 = $this->routerosapi->read();
		$we_frek = "";
		$we_protocol= "";
		$ssid = "";
		$band = "";
		foreach ($API_WE_1 as $WE)
			{
				$we_frek .= $WE['frequency']."<br>";	
				$we_protocol .= $WE['wireless-protocol']."<br>";	
				$ssid .= $WE['ssid']."<br>";	
				$band .= $WE['band']."<br>";
				$we_status .= $WE['disabled']."<br>";
				$mac_we .= $WE['mac-address']."<br>";
			} 
		}
		else
		{
		$this->routerosapi->write('/interface/wireless/getall');
		$API_WE_1 = $this->routerosapi->read();
		foreach ($API_WE_1 as $WE)
			{
				$we_frek = $WE['frequency'];
				$we_protocol= $WE['wireless-protocol'];		
				$ssid= $WE['ssid'];
				$band= $WE['band'];
				$we_status= $WE['disabled'];
				$mac_we= $WE['mac-address'];
			}  
		}
		
		
		//Cek Ethernet
		$this->routerosapi->write('/interface/ethernet/print', false);
		$this->routerosapi->write("=count-only=");
		$API_ETHER = $this->routerosapi->read();
		$COUNT_ETH = strlen($API_ETHER);
		if($COUNT_ETH > 1)
		{
		$this->routerosapi->write('/interface/ethernet/getall');
		$API_ETH = $this->routerosapi->read();
		$mac_eth = "";
		foreach ($API_ETH as $ETH)
			{
				$mac_eth .= $ETH['address'].",";
			}  
		}
		else
		{
		$this->routerosapi->write('/interface/ethernet/getall');
		$API_ETH = $this->routerosapi->read();
		foreach ($API_ETH as $ETH)
			{
				$mac_eth = $ETH['mac-address'];
			} 
		}
		
		//Cek SN			
		$this->routerosapi->write('/system/routerboard/getall');
		$API_SN = $this->routerosapi->read();
		foreach ($API_SN as $SN)
			{
				$serial_number = $SN['serial-number'];
				$model = $SN['model'];
			} 	
			
			
		//Update Database
		$newDate = date("M/d/Y H:i:s");
		$data = array(
		'cek_login' => $cek_login,
		'cek_os' => $cek_os,
		'cek_user' => $cek_user,
		'cek_script' => $cek_script,
		'cek_addrlist' => $cek_addrlist,
		'cek_port_ssh' => $cek_port_ssh,
		'band' => $band,
		'frek' => $we_frek,
		'protocol' => $we_protocol,
		'we_status' => $we_status,
		'ssid' => $ssid,
		'station' => $API_WE,
		'waktu' => $newDate,
		'mac_we' => $mac_we,
		'mac_eth' => $mac_eth,
		'serial_number' => $serial_number,
		'model' => $model,
		);						
		$this->db->where('id', $btsid['id']);
		$this->db->update('gm_bts', $data);
	  }
    }
	return $this->session->set_flashdata('success', 'Maintenance Sukses.');
	}
	
	public function backup() {
		$this->load->database();
        $btsdata = $this->get();
		$routerid = $this->db->get('gm_server')->row_array();
		
		//Burst Backup RSC
		foreach($btsdata as $btsid)
		{
		$hostname = $btsid['ip'];
		$username = $this->secure->decrypt_url($btsid['user']);
		$password = $this->secure->decrypt_url($btsid['password']);
		$port = $btsid['port'];
		$aplikasi = $routerid['ip_aplikasi'];
			//Cek Status Login
			if ($this->routerosapi->connect($hostname, $username, $password, $port))
			{			
			$this->routerosapi->write('/system/scheduler/add',false);				
			$this->routerosapi->write('=name=BLiP_backup_file', false);							
			$this->routerosapi->write('=interval=00:00:01', false);     				
			$this->routerosapi->write('=start-time=startup', false); 
			$this->routerosapi->write('=on-event='
			."/tool fetch url=\"https://".$aplikasi."/xdark/BLiP_BACKUP.rsc\" mode=https keep-result=yes;", false);								
			$this->routerosapi->write('=disabled=no');				
			$this->routerosapi->read();
			sleep(2);
			
			$this->routerosapi->write('/system/scheduler/add',false);				
			$this->routerosapi->write('=name=BLiP_backup_import', false);							
			$this->routerosapi->write('=interval=00:00:03', false);     				
			$this->routerosapi->write('=start-time=startup', false); 
			$this->routerosapi->write('=on-event='
			."/import file-name=BLiP_BACKUP.rsc;");											
			$this->routerosapi->read();
			sleep(2);
			
			$this->routerosapi->write('/system/scheduler/add',false);				
			$this->routerosapi->write('=name=BLiP_backup_remove', false);							
			$this->routerosapi->write('=interval=00:00:05', false);     				
			$this->routerosapi->write('=start-time=startup', false); 
			$this->routerosapi->write('=on-event='
			."/system scheduler remove [find name=\"BLiP_backup_file\"]; /system scheduler remove [find name=\"BLiP_backup_import\"]; /system scheduler remove [find name=\"BLiP_backup_remove\"]");											
			$this->routerosapi->read();
			sleep(2);
			
			//PROSES RUN SCRIPT BACKUP
			$this->routerosapi->write("/system/script/print",false);			
			$this->routerosapi->write("=.proplist=.id", false);		
			$this->routerosapi->write("?name=BLiP_BACKUP");				
			$API_SC = $this->routerosapi->read();
			foreach ($API_SC as $script)
			{
				$id_script = $script['.id'];
			}
			$this->routerosapi->write('/system/script/run',false);
			$this->routerosapi->write("=number=".$id_script);
			$this->routerosapi->read();
			
			}
			else
			{
				return $this->session->set_flashdata('error', 'Backup Gagal. Error IP '.$btsid_ip.' gagal terkoneksi API !');
			}	
		}	
		return $this->session->set_flashdata('success', 'Berhasil backup data.');
    }

}
