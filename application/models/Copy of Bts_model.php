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
			$this->db->order_by("nama_bts", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	public function count() {
        if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get('gm_bts')->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_bts')->num_rows();
		}
    }
	
	/*
	public function bts_up() {
		if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get_where('gm_lokalan', array('status' => "1"))->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_lokalan', array('idrouter' => $this->session->userdata('idrouter'),'status' => "1"))->num_rows();
		}
    }
	
	public function bts_down() {
		if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get_where('gm_lokalan', array('status' => "0"))->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_lokalan', array('idrouter' => $this->session->userdata('idrouter'),'status' => "0"))->num_rows();
		}
    }
	*/
	
	public function getALL($id) {
            $this->db->select('gm_bts');
            $this->db->from('gm_bts');
            $this->db->where('gm_bts.id', $id);
            $query = $this->db->get();
			$response = $query->result_array();

        return $response;
    }

    public function simpan() {
		//ENKRIPSI PASSWORD ROUTER
		$serverid = $this->db->get('gm_server')->row_array();
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_user = $this->input->post('username');
		$ar_enc_user = $ar_chip->encrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $this->input->post('password');
		$ar_enc_pass = $ar_chip->encrypt($ar_str_pass, $ar_rand);
		$hostname = $this->input->post('ip');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$aplikasi = $serverid['ip_aplikasi'];			
		if ($this->routerosapi->connect($hostname, $username, $password))
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
				."/tool fetch url=\"https://103.255.242.18/xdark/NOC_RADIO_CEK_LOG.rsc\" mode=https keep-result=yes; /system scheduler remove GmediaNOC_CEKLOG;", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_CEKREALTIME', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/tool fetch url=\"https://103.255.242.18/xdark/NOC_RADIO_CEK_REALTIME.rsc\" mode=https keep-result=yes; /system scheduler remove GmediaNOC_CEKREALTIME;", false);								
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
				."/file remove NOC_RADIO_CEK_LOG.rsc; /file remove NOC_RADIO_CEK_REALTIME.rsc; /system scheduler remove GmediaNOC_RSC_LOG;/system scheduler remove GmediaNOC_RSC_REALTIME; /system scheduler remove GmediaNOC_History;", false);								
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
				
				$data = array(
				'nama_bts' => $this->input->post('nama_bts'),
				'sektor_bts' => $data_identity,
				'ip' => $this->input->post('ip'),
				'user' => $ar_enc_user,
				'password' => $ar_enc_pass,
				'status' => "0",
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
        $routerid = $this->db->get_where('gm_router', array('id' => $this->input->post('idrouter')))->row_array();
		$serverid = $this->db->get('gm_server')->row_array();
		$query3 = $this->get($id);
		//ENKRIPSI PASSWORD ROUTER
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$old_user = $routerid['user'];
		$old_dec_user = $ar_chip->decrypt($old_user, $ar_rand);
		$old_str_pass = $routerid['password'];
		$old_dec_pass = $ar_chip->decrypt($old_pass, $ar_rand);
		$old_hostname = $routerid['ip'];
		$old_username = $old_dec_user;
		$old_password = $old_dec_pass;
		$new_str_user = $this->input->post('username');
		$new_enc_user = $ar_chip->encrypt($new_str_user, $ar_rand);
		$new_str_pass = $this->input->post('password');
		$new_enc_pass = $ar_chip->encrypt($new_str_pass, $ar_rand);
		$new_hostname = $this->input->post('ip');
		$new_username = $this->input->post('username');
		$new_password = $this->input->post('password');
		$aplikasi = $serverid['ip_aplikasi'];
        $data = array(
				'nama_bts' => $this->input->post('nama_bts'),
				'ip' => $this->input->post('ip'),
				'user' => $new_enc_user,
				'password' => $new_enc_pass,
				);						
		$this->db->where('id', $id);
		$this->db->update('gm_bts', $data);
		
		if ($this->routerosapi->connect($new_hostname, $new_username, $new_password))
			{
				//REMOVE ALL
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_History', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/system script remove NOC_RADIO_CEK_LOG; /system script remove NOC_RADIO_CEK_REALTIME; /system scheduler remove GmediaNOC_LOG; /system scheduler remove GmediaNOC_REALTIME; /system script remove NOC_RADIO_CEK_LOG; /system script remove NOC_RADIO_CEK_REALTIME; /system scheduler remove GmediaNOC_History;", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_CEKLOG', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/tool fetch url=\"https://103.255.242.18/xdark/NOC_RADIO_CEK_LOG.rsc\" mode=https keep-result=yes; /system scheduler remove GmediaNOC_CEKLOG;", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_CEKREALTIME', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/tool fetch url=\"https://103.255.242.18/xdark/NOC_RADIO_CEK_REALTIME.rsc\" mode=https keep-result=yes; /system scheduler remove GmediaNOC_CEKREALTIME;", false);								
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
				."/file remove NOC_RADIO_CEK_LOG.rsc; /file remove NOC_RADIO_CEK_REALTIME.rsc; /system script remove NOC_RADIO_CEK_LOG; /system script remove NOC_RADIO_CEK_REALTIME; /system scheduler remove GmediaNOC_RSC_LOG;/system scheduler remove GmediaNOC_RSC_REALTIME; /system scheduler remove GmediaNOC_History;", false);								
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
				
				$this->routerosapi->disconnect();
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
			}
		
        return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
    }
	
    public function delete($id) {	
		$router = $this->get($id);
		//ENKRIPSI PASSWORD ROUTER
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_user = $router['user'];
		$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $router['password'];
		$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
		
		$hostname = $router['ip'];
		$username = $ar_dec_user;
		$password = $ar_dec_pass;
			
		if ($this->routerosapi->connect($hostname, $username, $password))
			{
				//REMOVE ALL
				$this->routerosapi->write('/system/scheduler/add',false);				
				$this->routerosapi->write('=name=GmediaNOC_History', false);							
				$this->routerosapi->write('=interval=00:00:01', false);     				
				$this->routerosapi->write('=start-time=startup', false); 
				$this->routerosapi->write('=on-event='
				."/system script remove NOC_RADIO_CEK_LOG; /system script remove NOC_RADIO_CEK_REALTIME; /system scheduler remove GmediaNOC_LOG; /system scheduler remove GmediaNOC_REALTIME; /system script remove NOC_RADIO_CEK_LOG; /system script remove NOC_RADIO_CEK_REALTIME; /system scheduler remove GmediaNOC_History;", false);								
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal !');
			}
		$this->db->delete('gm_log_radio_realtime', array('pelanggan' => $router['pelanggan']));
        return $this->db->delete('gm_bts', array('id' => $id));

        return false;
    }
	
	
}
