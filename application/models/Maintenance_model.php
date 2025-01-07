<?php

class Maintenance_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	public function get_akses($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_maintenance_akses', array('id' => $id));
            $response = $query->row_array();
        } else {
            $query = $this->db->get('blip_maintenance_akses');
            $response = $query->result_array();
        }

        return $response;
    }
	public function get_history() {
        $query = $this->db->get('blip_maintenance_akses_history');
        $response = $query->result_array();
        return $response;
    }
	
	public function user_akses_simpan() {
		date_default_timezone_set("Asia/Singapore");
		
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_user = $this->input->post('user');
		$ar_en_user = $ar_chip->encrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $this->input->post('password');
		$ar_en_pass = $ar_chip->encrypt($ar_str_pass, $ar_rand);
		$username = $ar_en_user;
		$password = $ar_en_pass;
		
        $data = array(
			'role' => $this->input->post('role'),
			'user' => $username,
			'password' => $password,
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
        );
		if($this->db->insert('blip_maintenance_akses', $data)){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menyimpan data Akses User",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success','Penambahan data berhasil.');
		}else{
		return $this->session->set_flashdata('error','Penambahan data gagal.');
		}
    }
	public function user_akses_timpa($id) {
		date_default_timezone_set("Asia/Singapore");
		
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_user = $this->input->post('user');
		$ar_en_user = $ar_chip->encrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $this->input->post('password');
		$ar_en_pass = $ar_chip->encrypt($ar_str_pass, $ar_rand);
		$username = $ar_en_user;
		$password = $ar_en_pass;
		
        $data = array(
			'user' => $username,
			'password' => $password,
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
        );
		$this->db->where('id',$id);
		$set_update = $this->db->update('blip_maintenance_akses', $data);
		if(isset($set_update)){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Perubahan data Akses User",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success','Perubahan data berhasil.');
		}else{
		return $this->session->set_flashdata('error','Perubahan data gagal.');
		}
    }
	
	
	public function user_akses_hapus($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data User Akses",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->db->delete('blip_maintenance_akses', array('id' => $id));
    }

	public function user_akses_sync($id) {	
		//Clear Tables
		$this->db->truncate('blip_maintenance_akses_history');
		
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Sync data User Akses",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		$id_sync = $this->db->get_where('blip_maintenance_akses', array('id' => $id))->row_array();
		//$data_ap_bts = $this->db->get('gm_bts', 3, 0)->result_array();
		$data_ap_bts = $this->db->get('gm_bts')->result_array();
		
		if($id_sync['role'] == "Radio AP BTS"){
			foreach($data_ap_bts as $ap_bts){
			//Decrypt Password
			require_once APPPATH."third_party/addon.php";
			$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
			//Akses Existing
			$ar_dec_user = $ar_chip->decrypt($ap_bts['user'], $ar_rand);
			$ar_dec_pass = $ar_chip->decrypt($ap_bts['password'], $ar_rand);
			$hostname = $ap_bts['ip'];
			$username = $ar_dec_user;
			$password = $ar_dec_pass;
			
			//Akses New
			$new_user = $ar_chip->decrypt($id_sync['user'], $ar_rand);
			$new_pass = $ar_chip->decrypt($id_sync['password'], $ar_rand);
			
				if ($this->routerosapi->connect($hostname, $username, $password)){
				//Get ID User
				$this->routerosapi->write("/user/print",false);	
				$this->routerosapi->write("=.proplist=.id",false);															
				$this->routerosapi->write("=.proplist=name",false);		
				$this->routerosapi->write("?name=".$username);		
				$cek_user = $this->routerosapi->read();
				foreach($cek_user as $idusr){
					$iduser = $idusr['.id'];
				}
				//Set New Password
				$this->routerosapi->write("/user/set",false);	
				$this->routerosapi->write("=name=".$new_user,false);															
				$this->routerosapi->write("=password=".$new_pass,false);		
				$this->routerosapi->write("=.id=".$iduser);		
				$set_api = $this->routerosapi->read();
					if(isset($set_api)){
					$result = array(
						'role' => $id_sync['role'],
						'id_ap' => $ap_bts['id'],
						'status' => "1",
					);
					$update_db = array(
						'user' => $id_sync['user'],
						'password' => $id_sync['password'],
					);
						$set_result = $this->db->insert('blip_maintenance_akses_history', $result);
							if(isset($set_result)){
							$this->db->where('id', $ap_bts['id']);
							$set_db = $this->db->update('gm_bts', $update_db);
							/*if($set_db){
								return $this->session->set_flashdata('success','Upload konfigurasi berhasil');
								}else{
								return $this->session->set_flashdata('error','Upload konfigurasi gagal');
								}*/
							}
					}else{
						$result = array(
							'role' => $id_sync['role'],
							'id_ap' => $ap_bts['id'],
							'status' => "0",
						);
						$set_result = $this->db->insert('blip_maintenance_akses_history', $result);
					}
				}
			}
			return $this->session->set_flashdata('success','Upload konfigurasi selesai');
		}
    }
	
	
	
	
	
	
	public function get_device() {
       
			$this->db->select('*');
            $this->db->from('gm_bts');
			$this->db->order_by("id", "asc");
			$query = $this->db->get()->result_array();
            return $query;
    }
	
    //public function start_maintenance($media,$tipe) {
	public function start_maintenance($media,$tipe,$limit) {
		//BC USER & PASSWORD MIKROTIK
		if($tipe == "router_client")
		{
			//START RULE IF PERTAMA
			if($this->input->post('pass1') != $this->input->post('pass2'))
			{
			return $this->session->set_flashdata('error', 'GAGAL melakukan perubahan data!!! <br>Passsword baru dan konfirmasi harus sama !');
			}
			else
			{
				$this->db->select('*');
				$this->db->from('gm_router');
				$this->db->where('produk',"MAXI");
				$this->db->order_by("id", "asc");
				$this->db->limit(50,$limit);
				$query = $this->db->get();
				$routerid = $query->result_array();
				
				$message_return = "";
				
				foreach($routerid as $device)
				{
					
					require_once APPPATH."third_party/addon.php";
					$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
					$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
					$ar_str_user = $device['router_user'];
					$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
					$ar_str_pass = $device['router_pass'];
					$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
					$hostname = $device['router_ip'];
					$username = $ar_dec_user;
					$password = $ar_dec_pass;
					
					$input_user = $this->input->post('user1');
					$new_user = $ar_chip->encrypt($input_user, $ar_rand);
					$input_pass = $this->input->post('pass1');
					$new_pass = $ar_chip->encrypt($input_pass, $ar_rand);
								
						$message_return_error = "";
						if ($this->routerosapi->connect($hostname, $username, $password))
						{	
						//TAMBAH USER BARU
						$this->routerosapi->write("/user/add",false);										
						$this->routerosapi->write("=group=full", false);     
						$this->routerosapi->write("=name=".$this->input->post('user1'), false);  				
						$this->routerosapi->write("=password=".$this->input->post('pass1'), false); 	
						$this->routerosapi->write("=address=112.78.38.135,103.255.242.22,103.255.242.18,192.168.10.0/24", false); 					
						$this->routerosapi->write("=disabled=no");				
						$step1 = $this->routerosapi->read();
						
						//CEK USER BARU	
						$this->routerosapi->write("/user/print",false);	
						$this->routerosapi->write("=.proplist=.id",false);															
						$this->routerosapi->write("=.proplist=name",false);		
						$this->routerosapi->write("?name=".$this->input->post('user1'));		
						$step2 = $this->routerosapi->read();
						foreach($step2 as $datastep2){ $iduser_new = $datastep2['.id']; if($iduser_new != NULL) {$message_user_new = "User baru [OK]";}}
						
						//CEK USER LAMA	
						$this->routerosapi->write("/user/print",false);	
						$this->routerosapi->write("=.proplist=.id",false);															
						$this->routerosapi->write("=.proplist=name",false);		
						$this->routerosapi->write("?name=".$username);		
						$step3 = $this->routerosapi->read();
						foreach($step3 as $datastep3){ $iduser_old = $datastep3['.id']; if($iduser_old != NULL) {$message_user_old = "User lama [OK]";}}
						
						/*//HAPUS USER LAMA
						foreach($step3 as $dataiduser){ $iduser = $dataiduser['.id'];}
						$this->routerosapi->write("/user/remove",false);															
						$this->routerosapi->write("=.id=".$iduser);				
						$step4 = $this->routerosapi->read();*/
						
						$this->routerosapi->disconnect();
						
						
						//FINAL PROSES
						$data = array(
								'router_user' => $new_user,
								'router_pass' => $new_pass,
							);			
							$this->db->where('id', $device['id']);
							$this->db->update('gm_router', $data);		
									
						}
						else
						{
							$message_return_error .= $this->session->set_flashdata("error", "GAGAL melakukan perubahan data ID ".$device['router_ip']."-".$device['nama']." ".$message_user_new." ".$message_user_old."<br>");
							return $message_return_error;
						}	
				}
				$message_return .= $this->session->set_flashdata("success", "Berhasil melakukan perubahan data".$device['router_ip']."-".$device['nama']." - ".$message_user_new." ".$message_user_old."<br>");
				return $message_return;
			}
			//END RULE IF PERTAMA
		}
		elseif($tipe == "radio_bts")
		{
			//START RULE IF PERTAMA
			if($this->input->post('pass1') != $this->input->post('pass2'))
			{
			return $this->session->set_flashdata('error', 'GAGAL melakukan perubahan data!!! <br>Passsword baru dan konfirmasi harus sama !');
			}
			else
			{
				$this->db->select('*');
				$this->db->from('gm_bts');
				$this->db->order_by("id", "asc");
				$query = $this->db->get();
				$routerid = $query->result_array();
				foreach($routerid as $radio)
				{
					$this->load->database();
					$this->db->reconnect();
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
					
					$input_user = $this->input->post('user1');
					$new_user = $ar_chip->encrypt($input_user, $ar_rand);
					$input_pass = $this->input->post('pass1');
					$new_pass = $ar_chip->encrypt($input_pass, $ar_rand);
								
						if ($this->routerosapi->connect($hostname, $username, $password))
						{	
						//CEK USER LAMA	
						$this->routerosapi->write("/user/print",false);	
						$this->routerosapi->write("=.proplist=.id",false);															
						$this->routerosapi->write("=.proplist=name",false);		
						$this->routerosapi->write("?name=".$username);		
						$step2 = $this->routerosapi->read();
						//HAPUS USER LAMA
						foreach($step2 as $dataiduser){ $iduser = $dataiduser['.id'];}
						$this->routerosapi->write("/user/remove",false);															
						$this->routerosapi->write("=.id=".$iduser);				
						$step3 = $this->routerosapi->read();
						//TAMBAH USER BARU
						$this->routerosapi->write("/user/add",false);										
						$this->routerosapi->write("=group=full", false);     
						$this->routerosapi->write("=name=".$this->input->post('user1'), false);  				
						$this->routerosapi->write("=password=".$this->input->post('pass1'), false); 						
						$this->routerosapi->write("=disabled=no");				
						$step1 = $this->routerosapi->read();
						$this->routerosapi->disconnect();
						
						
						//FINAL PROSES
						$data = array(
								'user' => $new_user,
								'password' => $new_pass,
							);			
							$this->db->where('id', $radio['id']);
							$this->db->update('gm_bts', $data);		
									
						}
						else
						{
							return $this->session->set_flashdata('error', 'GAGAL melakukan perubahan data ID '.$radio['id'].'');
						}	
				}
				return $this->session->set_flashdata('success', 'Berhasil melakukan perubahan data');	
			}
			//END RULE IF PERTAMA
		}
    }


	
	public function maintenance() {
        $this->load->database();
        $btsdata = $this->get();
		foreach($btsdata as $btsid)
		{
		//Decrypt BTS
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$btsid_ip = $btsid['ip'];
		$btsid_user = $btsid['user'];
		$btsid_dec_user = $ar_chip->decrypt($btsid_user, $ar_rand);
		$btsid_pass = $btsid['password'];
		$btsid_dec_pass = $ar_chip->decrypt($btsid_pass, $ar_rand);
		
		//Cek Status Login
		if ($this->routerosapi->connect($btsid_ip, $btsid_dec_user, $btsid_dec_pass))
		{
			$cek_login = "OK";
			$cek_api = "Aktif";
			$this->routerosapi->write('/system/resource/getall');
			$API_CEK0 = $this->routerosapi->read();
				foreach ($API_CEK0 as $CEK0)
				{
					$cek_os = $CEK0['version'];
				}
		}
		else
		{
			$cek_api = "Tidak Aktif";
			$cek_login = "Gagal";
			$cek_os = "-";
			$cek_user = "-";
			$cek_script = "-";
			$cek_addrlist = "-";
			$cek_port_ssh = "-";
		    return $this->session->set_flashdata('error', 'Maintenance Gagal. Error IP '.$btsid_ip.' gagal terkoneksi API !');
		}
		
		//Jika Login Sukses
		if($cek_login == "OK" && $cek_api == "Aktif")
		{
		//Cek User Lain
			$this->routerosapi->write('/user/print',false);				
			$this->routerosapi->write("=count-only=");													
			$API_CEK1 = $this->routerosapi->read();
			if($API_CEK1 > 1) {$cek_user = "Terdeteksi Penyusup";} else { $cek_user = "OK"; }
			//Cek Script Mencurigakan
			$this->routerosapi->write('/system/script/print',false);				
			$this->routerosapi->write("=.proplist=name", false);		
			$this->routerosapi->write("?name=U6");													
			$API_CEK2 = $this->routerosapi->read();
				foreach ($API_CEK2 as $CEK2)
				{
					$PENGECEKAN2 = $CEK2['name'];
				}
			//Cek Script Mencurigakan
			$this->routerosapi->write('/system/script/print',false);				
			$this->routerosapi->write("=.proplist=name", false);		
			$this->routerosapi->write("?name=U7");													
			$API_CEK3 = $this->routerosapi->read();
				foreach ($API_CEK3 as $CEK3)
				{
					$PENGECEKAN3 = $CEK3['name'];
				}
			if(!empty($PENGECEKAN2) || !empty($PENGECEKAN3))
			{if($PENGECEKAN2 == "U6" || $PENGECEKAN3 == "U7") {$cek_script = "Terdeteksi Penyusup";}} else {$cek_script = "OK";}
			//Cek Address List
			$this->routerosapi->write('/ip/firewall/address-list/print',false);				
			$this->routerosapi->write("=.proplist=list", false);		
			$this->routerosapi->write("?list=WL");													
			$API_CEK4 = $this->routerosapi->read();
				foreach ($API_CEK4 as $CEK4)
				{
					$PENGECEKAN4 = $CEK4['name'];
				}
			if(!empty($PENGECEKAN4)) {$cek_addrlist = "Terdeteksi Penyusup";} else { $cek_addrlist = "OK"; }
			//Cek Service Port SSH
			$this->routerosapi->write('/ip/service/print',false);				
			$this->routerosapi->write("=.proplist=name", false);
			$this->routerosapi->write("=.proplist=port", false);
			$this->routerosapi->write("=.proplist=disabled", false);		
			$this->routerosapi->write("?name=ssh");													
			$API_CEK5 = $this->routerosapi->read();
				foreach ($API_CEK5 as $CEK5)
				{
					$PENGECEKAN5 = $CEK5['port'];
					$SERVICE_SSH = $CEK5['disabled'];
				}
			if($SERVICE_SSH != "true")
			{if($PENGECEKAN5 == "22" || $PENGECEKAN5 == "2292") {$cek_port_ssh = "$PENGECEKAN5 - OK";} else { $cek_port_ssh = "Terdeteksi Penyusup"; }}
			else {$cek_port_ssh = "OK (Tidak Aktif)";}
			
			//Cek Frek Wireless
			$this->routerosapi->write('/interface/wireless/print', false);
			$this->routerosapi->write("=count-only=");
			$API_WE = $this->routerosapi->read();
			$COUNT = strlen($API_WE);
			if($COUNT > 1)
			{
			$this->routerosapi->write('/interface/wireless/getall');
			$API_WE_1 = $this->routerosapi->read();
			foreach ($API_WE_1 as $WE)
				{
					$we_frek.= $WE['frequency'].",";
					$we_protocol= $WE['wireless-protocol'];	
					$ssid= $WE['ssid'];		
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
				}  
			}
		//Update Database
		$newDate = date("M/d/Y H:i:s");
		$data = array(
		'cek_api' => $cek_api,
		'cek_login' => $cek_login,
		'cek_os' => $cek_os,
		'cek_user' => $cek_user,
		'cek_script' => $cek_script,
		'cek_addrlist' => $cek_addrlist,
		'cek_port_ssh' => $cek_port_ssh,
		'frek' => $we_frek,
		'protocol' => $we_protocol,
		'ssid' => $ssid,
		'waktu' => $newDate,
		);						
		$this->db->where('id', $btsid['id']);
		$this->db->update('gm_bts', $data);
		$this->load->database();
		//echo"$we_protocol <br> $ssid <br><br>";
	  }
    }
	return $this->session->set_flashdata('success', 'Maintenance Sukses.');
	}

}
