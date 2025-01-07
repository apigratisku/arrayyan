<?php

class Scheduler_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_scheduler', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_scheduler');
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	public function count() {
        if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get('gm_scheduler')->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_scheduler', array('idrouter' => $this->session->userdata('idrouter')))->num_rows();
		}
    }
	
	public function scheduler_up() {
		if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get_where('gm_scheduler', array('status' => "1"))->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_scheduler', array('idrouter' => $this->session->userdata('idrouter'),'status' => "1"))->num_rows();
		}
    }
	
	public function scheduler_down() {
		if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get_where('gm_scheduler', array('status' => "0"))->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_scheduler', array('idrouter' => $this->session->userdata('idrouter'),'status' => "0"))->num_rows();
		}
    }
	
	public function getALL($id) {
            $this->db->select('gm_scheduler.*, gm_router.id');
            $this->db->from('gm_scheduler');
            $this->db->join('gm_router', 'gm_scheduler.idrouter = gm_router.id');
            $this->db->where('gm_scheduler.idrouter', $id);
            $query = $this->db->get();
			$response = $query->result_array();

        return $response;
    }
	
	public function getPEL() {
           return $this->db->get_where('gm_router', array('id' => $this->input->post('idrouter')))->row_array();
    }

    public function simpan() {
		$routerid = $this->db->get_where('gm_router', array('id' => $this->input->post('idrouter')))->row_array();
		$serverid = $this->db->get('gm_server')->row_array();
		//ENKRIPSI PASSWORD ROUTER
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_user = $routerid['router_user'];
		$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $routerid['router_pass'];
		$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
		$hostname = $routerid['router_ip'];
		$username = $ar_dec_user;
		$password = $ar_dec_pass;
		$pelanggan= $routerid['nama'];
		$aplikasi = $serverid['ip_aplikasi'];
		$ex_mulai = explode(" " , $this->input->post('mulai'));
		date_default_timezone_set("Asia/Singapore"); 
		if($this->input->post('selesai'))
		{ 
		$ex_selesai = explode(" " , $this->input->post('selesai')); 
		$newDate2 = date("M/d/Y", strtotime($ex_selesai[0]));
		$newTime2 = date("H:i:s", strtotime($ex_selesai[1]));
		}
				
		$newDate = date("M/d/Y", strtotime($ex_mulai[0]));
		$newDate3 = date("M/d/Y H:i:s");
		$get_detik = date("s");
		$modif_detik = date("s")+5;
		$inTime = date("H:i:").$modif_detik;
		$newDate4 = date("M/d/Y");
		$newTime = date("H:i:s", strtotime($ex_mulai[1]));
		//Random Resource
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    	$passrand = array(); //remember to declare $pass as an array
    	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    	for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $passrand[] = $alphabet[$n];
    	}
    	$resource = implode($passrand);
		//Save to DB
		if($this->input->post('selesai') != NULL){ $selesai = "$newDate2 $newTime2";} else {$selesai="-";}
        $data = array(
			
            'idrouter' => $this->input->post('idrouter'),
			'pelanggan' => $pelanggan,
			'permintaan' => $this->input->post('permintaan'),
			'bw' => $this->input->post('bw'),
			'mulai' => "$newDate $newTime",
			'selesai' => $selesai,
			'status' => "0",
			'resource' => $resource,
        );				
		$this->db->insert('gm_scheduler', $data);
		$schname = $this->input->post('permintaan')."-".$pelanggan."-".$resource;
		$schname_now = $this->input->post('permintaan')."-".$pelanggan."-".$newDate;
		//UPGRADE DOWNGRADE
		if($this->input->post('permintaan') == "Upgrade" or $this->input->post('permintaan') == "Downgrade")
		{
				
					require_once APPPATH."third_party/addon.php";
					$kripto 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
					$xdark_rand  = "%^$%^&%*GMEDIA%^$%^&%*";
					$xdark_h 	 = $kripto->decrypt("Dkihc87sCnrjdUG9RF5LwA==", $xdark_rand);
					$xdark_u 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
					$xdark_p 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
					
				
				if ($this->routerosapi->connect("$xdark_h","$xdark_u","$xdark_p"))
				{
					//Convert BW to Kbps
					$bw_set_mbps	= $this->input->post('bw')*1024;
					$bw_convert		= $bw_set_mbps."k/".$bw_set_mbps."k";
					if($this->input->post('eksekusi') == "terjadwal")
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$this->input->post('bw')."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler set [find name=\"".$schname."\"] comment=\"script-done\" disabled=yes;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
					//Save to DB
					$data = array(
						'mulai' => $newDate3,
					);			
					$this->db->where('resource', $resource);
					$this->db->update('gm_scheduler', $data);
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_convert."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler set [find name=\"".$schname."\"] comment=\"script-done\" disabled=yes;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');	
					}
				}
				else
				{
				$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
				}
		}
		//ISOLIR
		elseif($this->input->post('permintaan') == "Isolir")
		{	
				require_once APPPATH."third_party/addon.php";
				$kripto 	 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
				$xdark_rand  	 = "%^$%^&%*GMEDIA%^$%^&%*";
				$xdark_h_NTN 	 = $kripto->decrypt("Dkihc87sCnp3KFXG0R37OQ==", $xdark_rand);
				$xdark_u_NTN 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
				$xdark_p_NTN 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				$xdark_h_PMG 	 = $kripto->decrypt("Dkihc87sCnolAhzhPRIAyw==", $xdark_rand);
				$xdark_u_PMG 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
				$xdark_p_PMG 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				$xdark_h_TRW 	 = $kripto->decrypt("Dkihc87sCnohrL1pae5n8A==", $xdark_rand);
				$xdark_u_TRW 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
				$xdark_p_TRW 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				$xdark_h_QMR 	 = $kripto->decrypt("Dkihc87sCnpZU2tKCrAMmQ==", $xdark_rand);
				$xdark_u_QMR 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
				$xdark_p_QMR 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				if($this->input->post('eksekusi') == "terjadwal")
				{
					if ($this->routerosapi->connect("$xdark_h_NTN","$xdark_u_NTN","$xdark_p_NTN"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);     				
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false);  
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ", false);						
					$this->routerosapi->write('=disabled=no');
					$this->routerosapi->read();					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_PMG","$xdark_u_PMG","$xdark_p_PMG"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);     				
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ", false);						
					$this->routerosapi->write('=disabled=no');	
					$this->routerosapi->read();				
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_TRW","$xdark_u_TRW","$xdark_p_TRW"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);     				
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ", false);					
					$this->routerosapi->write('=disabled=no');	
					$this->routerosapi->read();				
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_QMR","$xdark_u_QMR","$xdark_p_QMR"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);     				
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ", false);						
					$this->routerosapi->write('=disabled=no');	
					$this->routerosapi->read();				
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
				}
				else
				{
					if ($this->routerosapi->connect("$xdark_h_NTN","$xdark_u_NTN","$xdark_p_NTN"))
					{
					//Save to DB
					$data = array(
						'mulai' => $newDate3,
					);			
					$this->db->where('resource', $resource);
					$this->db->update('gm_scheduler', $data);
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ;", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();				
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_PMG","$xdark_u_PMG","$xdark_p_PMG"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();				
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_TRW","$xdark_u_TRW","$xdark_p_TRW"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ;", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();				
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_QMR","$xdark_u_QMR","$xdark_p_QMR"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();				
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}	
				}
		}
		
		//OPEN ISOLIR
		elseif($this->input->post('permintaan') == "Buka Isolir")
		{	
				require_once APPPATH."third_party/addon.php";
				$kripto 	 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
				$xdark_rand  	 = "%^$%^&%*GMEDIA%^$%^&%*";
				$xdark_h_NTN 	 = $kripto->decrypt("Dkihc87sCnp3KFXG0R37OQ==", $xdark_rand);
				$xdark_u_NTN 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
				$xdark_p_NTN 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				$xdark_h_PMG 	 = $kripto->decrypt("Dkihc87sCnolAhzhPRIAyw==", $xdark_rand);
				$xdark_u_PMG 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
				$xdark_p_PMG 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				$xdark_h_TRW 	 = $kripto->decrypt("Dkihc87sCnohrL1pae5n8A==", $xdark_rand);
				$xdark_u_TRW 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
				$xdark_p_TRW 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				$xdark_h_QMR 	 = $kripto->decrypt("Dkihc87sCnpZU2tKCrAMmQ==", $xdark_rand);
				$xdark_u_QMR 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
				$xdark_p_QMR 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				if($this->input->post('eksekusi') == "terjadwal")
				{
					if ($this->routerosapi->connect("$xdark_h_NTN","$xdark_u_NTN","$xdark_p_NTN"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false);  
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter set [find comment=\"".$routerid['network']." - ".$pelanggan."\"] comment=\"".$routerid['network']." - Open Isolir ".$pelanggan." - ".$newDate."\" disabled=yes; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_PMG","$xdark_u_PMG","$xdark_p_PMG"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter set [find comment=\"".$routerid['network']." - ".$pelanggan."\"] comment=\"".$routerid['network']." - Open Isolir ".$pelanggan." - ".$newDate."\" disabled=yes; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_TRW","$xdark_u_TRW","$xdark_p_TRW"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter set [find comment=\"".$routerid['network']." - ".$pelanggan."\"] comment=\"".$routerid['network']." - Open Isolir ".$pelanggan." - ".$newDate."\" disabled=yes; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_QMR","$xdark_u_QMR","$xdark_p_QMR"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter set [find comment=\"".$routerid['network']." - ".$pelanggan."\"] comment=\"".$routerid['network']." - Open Isolir ".$pelanggan." - ".$newDate."\" disabled=yes; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					
				}
				else
				{
					if ($this->routerosapi->connect("$xdark_h_NTN","$xdark_u_NTN","$xdark_p_NTN"))
					{
					//Save to DB
					$data = array(
						'mulai' => $newDate3,
					);			
					$this->db->where('resource', $resource);
					$this->db->update('gm_scheduler', $data);
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter set [find comment=\"".$routerid['network']." - ".$pelanggan."\"] comment=\"".$routerid['network']." - Open Isolir ".$pelanggan." - ".$newDate."\" disabled=yes; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_PMG","$xdark_u_PMG","$xdark_p_PMG"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter set [find comment=\"".$routerid['network']." - ".$pelanggan."\"] comment=\"".$routerid['network']." - Open Isolir ".$pelanggan." - ".$newDate."\" disabled=yes; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_TRW","$xdark_u_TRW","$xdark_p_TRW"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter set [find comment=\"".$routerid['network']." - ".$pelanggan."\"] comment=\"".$routerid['network']." - Open Isolir ".$pelanggan." - ".$newDate."\" disabled=yes; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					if ($this->routerosapi->connect("$xdark_h_QMR","$xdark_u_QMR","$xdark_p_QMR"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:01', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter set [find comment=\"".$routerid['network']." - ".$pelanggan."\"] comment=\"".$routerid['network']." - Open Isolir ".$pelanggan." - ".$newDate."\" disabled=yes; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
				}
		}
		elseif($this->input->post('permintaan') == "BOD Normal")
		{
		//BOD (Bandwidth On Demand)
					require_once APPPATH."third_party/addon.php";
					$kripto 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
					$xdark_rand  = "%^$%^&%*GMEDIA%^$%^&%*";
					$xdark_h 	 = $kripto->decrypt("Dkihc87sCnrjdUG9RF5LwA==", $xdark_rand);
					$xdark_u 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
					$xdark_p 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
				
				if ($this->routerosapi->connect("$xdark_h","$xdark_u","$xdark_p"))
				{
					//GET DATA BW BEFORE
					$this->routerosapi->write("/queue/simple/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);	
					$this->routerosapi->write("=.proplist=max-limit", false);	
					$this->routerosapi->write("?target=".$routerid['network']);				
					$API_BW_B4 = $this->routerosapi->read();
					foreach ($API_BW_B4 as $API_BW)
					{
						$bw_get		= $API_BW['max-limit']/1000;
						$bw_normal	= $bw_get."k/".$bw_get."k";
						$bw_set_bod = $bw_get/2+$bw_get;
						$bw_bod		= $bw_set_bod."k/".$bw_set_bod."k";
						$bw_inDB	= $bw_bod/1000;
						$bw_DB		= $bw_inDB."M/".$bw_inDB."M";
					}

					//Save to DB
					$data = array(
						'bw' => $bw_DB,
					);			
					$this->db->where('resource', $resource);
					$this->db->update('gm_scheduler', $data);
					
					if($this->input->post('eksekusi') == "terjadwal")
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-mulai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_bod."; /system scheduler set [find name=\"".$schname."-mulai\"] disabled=yes comment=\"script-done\"; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=start-time='.$newTime2, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_normal."; /system scheduler set [find name=\"".$schname."-selesai\"] disabled=yes comment=\"script-done\"; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-mulai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-time='.$inTime, false);    				
					$this->routerosapi->write('=start-date='.$newDate4, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler set [find name=\"".$schname."-mulai\"] comment=\"script-done\" disabled=yes;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=start-time='.$newTime2, false);								
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler set [find name=\"".$schname."-selesai\"] comment=\"script-done\" disabled=yes;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
				}
				else
				{
				$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
				}
		}
		elseif($this->input->post('permintaan') == "BOD Khusus")
		{
		//BOD (Bandwidth On Demand)
					require_once APPPATH."third_party/addon.php";
					$kripto 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
					$xdark_rand  = "%^$%^&%*GMEDIA%^$%^&%*";
					$xdark_h 	 = $kripto->decrypt("Dkihc87sCnrjdUG9RF5LwA==", $xdark_rand);
					$xdark_u 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
					$xdark_p 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);

				if ($this->routerosapi->connect("$xdark_h","$xdark_u","$xdark_p"))
				{
					//GET DATA BW BEFORE
					$this->routerosapi->write("/queue/simple/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);	
					$this->routerosapi->write("=.proplist=max-limit", false);	
					$this->routerosapi->write("?target=".$routerid['network']);				
					$API_BW_B4 = $this->routerosapi->read();
					foreach ($API_BW_B4 as $API_BW)
					{
						$bw_get		= $API_BW['max-limit']/1000;
						$bw_normal	= $bw_get."k/".$bw_get."k";
						$bw_set_bod = $bw_get*2;
						$bw_bod		= $bw_set_bod."k/".$bw_set_bod."k";
						$bw_inDB	= $bw_bod/1000;
						$bw_DB		= $bw_inDB."M/".$bw_inDB."M";
					}

					//Save to DB
					$data = array(
						'bw' => $bw_DB,
					);			
					$this->db->where('resource', $resource);
					$this->db->update('gm_scheduler', $data);
					
					if($this->input->post('eksekusi') == "terjadwal")
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-mulai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler set [find name=\"".$schname."-mulai\"] comment=\"script-done\" disabled=yes;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=start-time='.$newTime2, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler set [find name=\"".$schname."-selesai\"]  comment=\"script-done\" disabled=yes;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-mulai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-time='.$inTime, false);
					$this->routerosapi->write('=start-date='.$newDate4, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler set [find name=\"".$schname."-mulai\"] comment=\"script-done\" disabled=yes;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=start-time='.$newTime2, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler set [find name=\"".$schname."-selesai\"]  comment=\"script-done\" disabled=yes;", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
				}
				else
				{
				$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
				}
		}
			
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
    }

    public function delete($id) {
		$scheduler   	= $this->db->get_where('gm_scheduler', array('id' => $id))->row_array();	
		$schname 		= $scheduler['permintaan']."-".$scheduler['pelanggan']."-".$scheduler['resource'];
		require_once APPPATH."third_party/addon.php";
		$kripto 	 	= new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$xdark_rand  	= "%^$%^&%*GMEDIA%^$%^&%*";
		if($scheduler['permintaan'] == "Upgrade" or $scheduler['permintaan'] == "Downgrade")
		{		
		$xdark_h 	 	= $kripto->decrypt("Dkihc87sCnrjdUG9RF5LwA==", $xdark_rand);
		$xdark_u 	 	= $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
		$xdark_p 	 	= $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
			if ($this->routerosapi->connect("$xdark_h","$xdark_u","$xdark_p"))
				{
					$this->routerosapi->write("/system/scheduler/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);		
					$this->routerosapi->write("?name=".$schname);				
					$APIsch = $this->routerosapi->read();
					foreach ($APIsch as $sch)
					{
						$id_router = $sch['.id'];
					}
					if(isset($id_router))
					{
					$this->routerosapi->write('/system/scheduler/remove',false);
					$this->routerosapi->write('=.id='.$id_router);
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					}
				}
				else
				{
					$this->session->set_flashdata('message', 'Login gagal !');
				}
		}
		elseif($scheduler['permintaan'] == "BOD Normal")
		{		
		$xdark_h 	 = $kripto->decrypt("Dkihc87sCnrjdUG9RF5LwA==", $xdark_rand);
		$xdark_u 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
		$xdark_p 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
			if ($this->routerosapi->connect("$xdark_h","$xdark_u","$xdark_p"))
				{
					//HAPUS BOD MULAI
					$this->routerosapi->write("/system/scheduler/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);		
					$this->routerosapi->write("?name=".$schname."-mulai");				
					$APIsch = $this->routerosapi->read();
					foreach ($APIsch as $sch)
					{
						$id_router = $sch['.id'];
					}
					if(isset($id_router))
					{
					$this->routerosapi->write('/system/scheduler/remove',false);
					$this->routerosapi->write('=.id='.$id_router);
					$this->routerosapi->read();
					}
					
					//HAPUS BOD SELESAI
					$this->routerosapi->write("/system/scheduler/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);		
					$this->routerosapi->write("?name=".$schname."-selesai");				
					$APIsch = $this->routerosapi->read();
					foreach ($APIsch as $sch)
					{
						$id_router = $sch['.id'];
					}
					if(isset($id_router))
					{
					$this->routerosapi->write('/system/scheduler/remove',false);
					$this->routerosapi->write('=.id='.$id_router);
					$this->routerosapi->read();		
					$this->routerosapi->disconnect();	
					}
				}
				else
				{
					$this->session->set_flashdata('message', 'Login gagal !');
				}
		}
		elseif($scheduler['permintaan'] == "BOD Khusus")
		{		
		$xdark_h 	 = $kripto->decrypt("Dkihc87sCnrjdUG9RF5LwA==", $xdark_rand);
		$xdark_u 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
		$xdark_p 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
			if ($this->routerosapi->connect("$xdark_h","$xdark_u","$xdark_p"))
				{
					//HAPUS BOD MULAI
					$this->routerosapi->write("/system/scheduler/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);		
					$this->routerosapi->write("?name=".$schname."-mulai");				
					$APIsch = $this->routerosapi->read();
					foreach ($APIsch as $sch)
					{
						$id_router = $sch['.id'];
					}
					if(isset($id_router))
					{
					$this->routerosapi->write('/system/scheduler/remove',false);
					$this->routerosapi->write('=.id='.$id_router);
					$this->routerosapi->read();
					}
					
					//HAPUS BOD SELESAI
					$this->routerosapi->write("/system/scheduler/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);		
					$this->routerosapi->write("?name=".$schname."-selesai");				
					$APIsch = $this->routerosapi->read();
					foreach ($APIsch as $sch)
					{
						$id_router = $sch['.id'];
					}
					if(isset($id_router))
					{
					$this->routerosapi->write('/system/scheduler/remove',false);
					$this->routerosapi->write('=.id='.$id_router);
					$this->routerosapi->read();		
					$this->routerosapi->disconnect();	
					}
				}
				else
				{
					$this->session->set_flashdata('message', 'Login gagal !');
				}
		}
		elseif($scheduler['permintaan'] == "Isolir" or $scheduler['permintaan'] == "Buka Isolir")
		{
		$xdark_h1 	 = $kripto->decrypt("Dkihc87sCnp3KFXG0R37OQ==", $xdark_rand);
		$xdark_u1 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
		$xdark_p1 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
		
		$xdark_h2 	 = $kripto->decrypt("Dkihc87sCnolAhzhPRIAyw==", $xdark_rand);
		$xdark_u2 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
		$xdark_p2 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
		
		$xdark_h3 	 = $kripto->decrypt("Dkihc87sCnohrL1pae5n8A==", $xdark_rand);
		$xdark_u3 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
		$xdark_p3 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
		
		$xdark_h4 	 = $kripto->decrypt("Dkihc87sCnpZU2tKCrAMmQ==", $xdark_rand);
		$xdark_u4 	 = $kripto->decrypt("mfOYD/038oY=", $xdark_rand);
		$xdark_p4 	 = $kripto->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
		
			//TE-NUTANA
			if ($this->routerosapi->connect("$xdark_h1","$xdark_u1","$xdark_p1"))
			{
				$this->routerosapi->write("/system/scheduler/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=".$schname);				
				$APIsch = $this->routerosapi->read();
				foreach ($APIsch as $sch)
				{
					$id_router = $sch['.id'];
				}
				if(isset($id_router))
				{
				$this->routerosapi->write('/system/scheduler/remove',false);
				$this->routerosapi->write('=.id='.$id_router);
				$this->routerosapi->read();
				}
				$this->routerosapi->disconnect();
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal !');
			}
			
			//TE-PEMENANG
			if ($this->routerosapi->connect("$xdark_h2","$xdark_u2","$xdark_p2"))
			{
				$this->routerosapi->write("/system/scheduler/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=".$schname);				
				$APIsch = $this->routerosapi->read();
				foreach ($APIsch as $sch)
				{
					$id_router = $sch['.id'];
				}
				if(isset($id_router))
				{
				$this->routerosapi->write('/system/scheduler/remove',false);
				$this->routerosapi->write('=.id='.$id_router);
				$this->routerosapi->read();
				}
				$this->routerosapi->disconnect();
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal !');
			}
			
			//TE-TRAWANGAN
			if ($this->routerosapi->connect("$xdark_h3","$xdark_u3","$xdark_p3"))
			{
				$this->routerosapi->write("/system/scheduler/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=".$schname);				
				$APIsch = $this->routerosapi->read();
				foreach ($APIsch as $sch)
				{
					$id_router = $sch['.id'];
				}
				if(isset($id_router))
				{
				$this->routerosapi->write('/system/scheduler/remove',false);
				$this->routerosapi->write('=.id='.$id_router);
				$this->routerosapi->read();
				}
				$this->routerosapi->disconnect();
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal !');
			}
			
			//TE-QMR
			if ($this->routerosapi->connect("$xdark_h4","$xdark_u4","$xdark_p4"))
			{
				$this->routerosapi->write("/system/scheduler/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?name=".$schname);				
				$APIsch = $this->routerosapi->read();
				foreach ($APIsch as $sch)
				{
					$id_router = $sch['.id'];
				}
				if(isset($id_router))
				{
				$this->routerosapi->write('/system/scheduler/remove',false);
				$this->routerosapi->write('=.id='.$id_router);
				$this->routerosapi->read();
				}
				$this->routerosapi->disconnect();
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal !');
			}
			
			
		}
        return $this->db->delete('gm_scheduler', array('id' => $id));
        return false;
    }	
}