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
	
	public function sch_total() {
		return $this->db->get_where('gm_scheduler', array('status' => "1"))->num_rows();
    }
	public function sch_run() {
		return $this->db->get_where('gm_scheduler', array('status' => "2"))->num_rows();
    }
	public function sch_wait() {
		return $this->db->get_where('gm_scheduler', array('status' => "0"))->num_rows();
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
		$teid = $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();
		$drid = $this->db->get_where('gm_dr', array('id' => $routerid['DR']))->row_array();
		//ENKRIPSI PASSWORD ROUTER
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_user = $routerid['router_user'];
		$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $routerid['router_pass'];
		$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
		
		$te_str_ip = $teid['ip'];
		$te_ip = $ar_chip->decrypt($te_str_ip, $ar_rand);
		$te_str_user = $teid['user'];
		$te_user = $ar_chip->decrypt($te_str_user, $ar_rand);
		$te_str_pass = $teid['pass'];
		$te_pass = $ar_chip->decrypt($te_str_pass, $ar_rand);
		
		$dr_str_ip = $drid['ip'];
		$dr_ip = $ar_chip->decrypt($dr_str_ip, $ar_rand);
		$dr_str_user = $drid['user'];
		$dr_user = $ar_chip->decrypt($dr_str_user, $ar_rand);
		$dr_str_pass = $teid['pass'];
		$dr_pass = $ar_chip->decrypt($dr_str_pass, $ar_rand);
		
		$hostname = $routerid['router_ip'];
		$username = $ar_dec_user;
		$password = $ar_dec_pass;
		$pelanggan= $routerid['nama'];
		$aplikasi = $serverid['ip_aplikasi'];
		$ex_mulai = explode(" " , $this->input->post('mulai'));
		date_default_timezone_set("Asia/Singapore");
				
		$newDate = date("M/d/Y", strtotime($ex_mulai[0]));
		$newTime = date("H:i:s", strtotime($ex_mulai[1]));
		
		if($this->input->post('selesai'))
		{ 
		$ex_selesai = explode(" " , $this->input->post('selesai')); 
		$newDate2 = date("M/d/Y", strtotime($ex_selesai[0]));
		$newTime2 = date("H:i:s", strtotime($ex_selesai[1]));
		}
		
		$newDate3 = date("M/d/Y H:i:s");
		$newTime3 = date("H:i:s");
		
		$get_detik = date("s");
		$modif_detik = date("s")+5;
		$inTime = date("H:i:").$modif_detik;
		$newDate4 = date("M/d/Y");
		
		
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
		if($this->input->post('permintaan') == "Free BOD +50% Bandwidth") { $BOD_ket = "Free BOD +50% Bandwidth"; } elseif($this->input->post('permintaan') == "Free BOD +100% Bandwidth") { $BOD_ket = "Free BOD +100% Bandwidth"; }elseif($this->input->post('permintaan') == "BOD Berbayar") { $BOD_ket = "BOD Berbayar"; } else {$BOD_ket = $this->input->post('permintaan');}
        $data = array(
			
            'idrouter' => $this->input->post('idrouter'),
			'pelanggan' => $pelanggan,
			'permintaan' => $BOD_ket,
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
				
				if ($this->routerosapi->connect($dr_ip,$dr_user,$dr_pass))
				{
					//GET DATA BW BEFORE
					$this->routerosapi->write("/queue/simple/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);	
					$this->routerosapi->write("=.proplist=max-limit", false);	
					$this->routerosapi->write("?target=".$routerid['router_network']);				
					$API_BW_B4 = $this->routerosapi->read();
					foreach ($API_BW_B4 as $API_BW)
					{
						$bw_get1	= $API_BW['max-limit']/1000;
						$bw_get2	= $bw_get1/1000;
						$bw_normal	= $bw_get2."M/".$bw_get2."M";
					}
					
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
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_convert."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg($this->input->post('permintaan')." pelanggan <b>".$pelanggan."</b> telah dijadwalkan tanggal <b>".$newDate."</b> pukul <b>".$newTime."</b> secara otomatis. \n\nBerikut Detail Teknis: \nBW Sebelum: <b>".$bw_normal."</b> \nBW Sesudah: <b>".$this->input->post('bw')."</b>\n\nTerima kasih.");
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
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_convert."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');	
					$data = $this->telegram_lib->sendmsg($this->input->post('permintaan')." <b>".$pelanggan."</b> telah di proses tanggal <b>".$newDate3."</b> secara otomatis. \n\nBerikut Detail Teknis: \nBW Sebelum: <b>".$bw_normal."</b> \nBW Sesudah: <b>".$this->input->post('bw')."</b>\n\nTerima kasih.");
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
				
				if($this->input->post('eksekusi') == "terjadwal")
				{
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);     				
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false);  
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['router_network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['router_network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"]; ", false);						
					$this->routerosapi->write('=disabled=no');
					$this->routerosapi->read();					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg("Isolir pelanggan <b>".$pelanggan."</b> telah dijadwalkan tanggal <b>".$newDate."</b> pukul <b>".$newTime."</b> secara otomatis.\n\nTerima kasih.");
					
						//Cek Jika layanan FIBERSTREAM
						if($routerid['produk'] == "FIBERSTREAM")
						{
						$data_fs = array(
						'status_layanan' => "0",
						'status_bayar' => "0",
						);
						$this->db->where('cid', $routerid['cid']);
						$this->db->update('gm_fiberstream', $data_fs);
						}
						//
					
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
				}
				else
				{
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass))
					{
					//Save to DB
					$data = array(
						'mulai' => $newDate3,
					);			
					$this->db->where('resource', $resource);
					$this->db->update('gm_scheduler', $data);
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:03', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['router_network']." - ".$pelanggan."\" chain=forward action=drop disabled=no src-address=".$routerid['router_network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();				
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg("Isolir pelanggan <b>".$pelanggan."</b> telah di proses tanggal <b>".$newDate3."</b> secara otomatis.\n\nTerima kasih.");	
					
					//Cek Jika layanan FIBERSTREAM
						if($routerid['produk'] == "FIBERSTREAM")
						{
						$data_fs = array(
						'status_layanan' => "0",
						'status_bayar' => "0",
						);
						$this->db->where('cid', $routerid['cid']);
						$this->db->update('gm_fiberstream', $data_fs);
						}
						//
						
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
				
				if($this->input->post('eksekusi') == "terjadwal")
				{
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time='.$newTime, false);  
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter remove [find comment=\"".$routerid['router_network']." - ".$pelanggan."\"]; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg("Open isolir pelanggan <b>".$pelanggan."</b> telah dijadwalkan tanggal <b>".$newDate."</b> pukul <b>".$newTime."</b> secara otomatis.\n\nTerima kasih.");
					
					
					//Cek Jika layanan FIBERSTREAM
						if($routerid['produk'] == "FIBERSTREAM")
						{
						$data_fs = array(
						'status_layanan' => "1",
						'status_bayar' => "1",
						);
						$this->db->where('cid', $routerid['cid']);
						$this->db->update('gm_fiberstream', $data_fs);
						}
						//
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
				}
				else
				{
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass))
					{
					//Save to DB
					$data = array(
						'mulai' => $newDate3,
					);			
					$this->db->where('resource', $resource);
					$this->db->update('gm_scheduler', $data);
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=00:00:03', false);     				
					$this->routerosapi->write('=start-time=startup', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter remove [find comment=\"".$routerid['router_network']." - ".$pelanggan."\"]; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);						
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg("Open isolir pelanggan <b>".$pelanggan."</b> telah di proses tanggal <b>".$newDate3."</b> secara otomatis.\n\nTerima kasih.");
					
					//Cek Jika layanan FIBERSTREAM
						if($routerid['produk'] == "FIBERSTREAM")
						{
						$data_fs = array(
						'status_layanan' => "1",
						'status_bayar' => "1",
						);
						$this->db->where('cid', $routerid['cid']);
						$this->db->update('gm_fiberstream', $data_fs);
						}
						//
							
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					
				}
		}
		elseif($this->input->post('permintaan') == "Free BOD +50% Bandwidth")
		{
			//BOD (Free BOD +50%)
					if ($this->routerosapi->connect($dr_ip,$dr_user,$dr_pass))
					{
					//GET DATA BW BEFORE
					$this->routerosapi->write("/queue/simple/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);	
					$this->routerosapi->write("=.proplist=max-limit", false);	
					$this->routerosapi->write("?target=".$routerid['router_network']);				
					$API_BW_B4 = $this->routerosapi->read();
					foreach ($API_BW_B4 as $API_BW)
					{
						$bw_get		= $API_BW['max-limit']/1000;
						$bw_normal	= $bw_get."k/".$bw_get."k";
						$bw_set_bod = $bw_get/2+$bw_get;
						$bw_bod		= $bw_set_bod."k/".$bw_set_bod."k";
						$bw_inDB	= $bw_bod/1000;
						$bw_DB		= $bw_inDB."M/".$bw_inDB."M";
						
						$bw_get1	= $API_BW['max-limit']/1000;
						$bw_get2	= $bw_get1/1000;
						$bw_awal	= $bw_get2."M/".$bw_get2."M";
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
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler remove [find name=\"".$schname."-mulai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=start-time='.$newTime2, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."-selesai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg($BOD_ket." pelanggan <b>".$pelanggan."</b> telah dijadwalkan tanggal <b>".$newDate3."</b> secara otomatis. \n\nBerikut Detail Teknis: \nStart BOD: <b>".$newDate." ".$newTime."</b> \nFinish BOD: <b>".$newDate2." ".$newTime2."</b> \nBW Sebelum: <b>".$bw_awal."</b> \nBW Sesudah: <b>".$bw_DB."</b>\n\nTerima kasih.");
					}
					else
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-mulai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-time='.$inTime, false);    				
					$this->routerosapi->write('=start-date='.$newDate4, false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler remove [find name=\"".$schname."-mulai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=start-time='.$newTime2, false);								
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."-selesai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg($BOD_ket." pelanggan <b>".$pelanggan."</b> telah di proses tanggal <b>".$newDate3."</b> secara otomatis. \n\nBerikut Detail Teknis: \nStart BOD: <b>".$newDate3."</b> \nFinish BOD: <b>".$newDate2." ".$newTime2."</b> \nBW Sebelum: <b>".$bw_awal."</b> \nBW Sesudah: <b>".$bw_DB."</b>\n\nTerima kasih.");
					}
				}
				else
				{
				$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
				}
		}
		elseif($this->input->post('permintaan') == "Free BOD +100% Bandwidth")
		{
		//BOD (Bandwidth On Demand)
				if ($this->routerosapi->connect($dr_ip,$dr_user,$dr_pass))
				{
					//GET DATA BW BEFORE
					$this->routerosapi->write("/queue/simple/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);	
					$this->routerosapi->write("=.proplist=max-limit", false);	
					$this->routerosapi->write("?target=".$routerid['router_network']);				
					$API_BW_B4 = $this->routerosapi->read();
					foreach ($API_BW_B4 as $API_BW)
					{
						$bw_get		= $API_BW['max-limit']/1000;
						$bw_normal	= $bw_get."k/".$bw_get."k";
						$bw_set_bod = $bw_get*2;
						$bw_bod		= $bw_set_bod."k/".$bw_set_bod."k";
						$bw_inDB	= $bw_bod/1000;
						$bw_DB		= $bw_inDB."M/".$bw_inDB."M";
						
						$bw_get1	= $API_BW['max-limit']/1000;
						$bw_get2	= $bw_get1/1000;
						$bw_awal	= $bw_get2."M/".$bw_get2."M";
						
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
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler remove [find name=\"".$schname."-mulai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=start-time='.$newTime2, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."-selesai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg($BOD_ket." pelanggan <b>".$pelanggan."</b> telah dijadwalkan tanggal <b>".$newDate3."</b> secara otomatis. \n\nBerikut Detail Teknis: \nStart BOD: <b>".$newDate." ".$newTime."</b> \nFinish BOD: <b>".$newDate2." ".$newTime2."</b> \nBW Sebelum: <b>".$bw_awal."</b> \nBW Sesudah: <b>".$bw_DB."</b>\n\nTerima kasih.");
					}
					else
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-mulai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-time='.$inTime, false);
					$this->routerosapi->write('=start-date='.$newDate4, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler remove [find name=\"".$schname."-mulai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-time='.$newTime2, false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."-selesai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg($BOD_ket." pelanggan <b>".$pelanggan."</b> telah di proses tanggal <b>".$newDate3."</b> secara otomatis. \n\nBerikut Detail Teknis: \nStart BOD: <b>".$newDate3."</b> \nFinish BOD: <b>".$newDate2." ".$newTime2."</b> \nBW Sebelum: <b>".$bw_awal."</b> \nBW Sesudah: <b>".$bw_DB."</b>\n\nTerima kasih.");
					}
				}
				else
				{
				$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
				}
		}
		elseif($this->input->post('permintaan') == "BOD Berbayar")
		{
		//BOD (Bandwidth On Demand Berbayar)
				if ($this->routerosapi->connect($dr_ip,$dr_user,$dr_pass))
				{
					//GET DATA BW BEFORE
					$this->routerosapi->write("/queue/simple/print", false);			
					$this->routerosapi->write("=.proplist=.id", false);	
					$this->routerosapi->write("=.proplist=max-limit", false);	
					$this->routerosapi->write("?target=".$routerid['router_network']);				
					$API_BW_B4 = $this->routerosapi->read();
					foreach ($API_BW_B4 as $API_BW)
					{
						$bw_get		= $API_BW['max-limit']/1000;
						$bw_normal	= $bw_get."k/".$bw_get."k";
						$bw_set_bod = $bw_get*2;
						$bw_bod		= $this->input->post('bw');
						$bw_inDB	= $bw_bod;
						$bw_DB		= $bw_inDB;
						
						$bw_get1	= $API_BW['max-limit']/1000;
						$bw_get2	= $bw_get1/1000;
						$bw_awal	= $bw_get2."M/".$bw_get2."M";
						
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
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler remove [find name=\"".$schname."-mulai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=start-time='.$newTime2, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."-selesai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg($BOD_ket." pelanggan <b>".$pelanggan."</b> telah dijadwalkan tanggal <b>".$newDate3."</b> secara otomatis. \n\nBerikut Detail Teknis: \nStart BOD: <b>".$newDate." ".$newTime."</b> \nFinish BOD: <b>".$newDate2." ".$newTime2."</b> \nBW Sebelum: <b>".$bw_awal."</b> \nBW Sesudah: <b>".$bw_DB."</b>\n\nTerima kasih.");
					}
					else
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-mulai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-time='.$inTime, false);
					$this->routerosapi->write('=start-date='.$newDate4, false);
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_bod."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=2\" keep-result=no; /system scheduler remove [find name=\"".$schname."-mulai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname."-selesai", false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-time='.$newTime2, false);
					$this->routerosapi->write('=start-date='.$newDate2, false);     				
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$routerid['router_network']."] max-limit=".$bw_normal."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."-selesai\"];", false);					
					$this->routerosapi->write('=disabled=no');				
					$this->routerosapi->read();
					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					$data = $this->telegram_lib->sendmsg($BOD_ket." pelanggan <b>".$pelanggan."</b> telah di proses tanggal <b>".$newDate3."</b> secara otomatis. \n\nBerikut Detail Teknis: \nStart BOD: <b>".$newDate3."</b> \nFinish BOD: <b>".$newDate2." ".$newTime2."</b> \nBW Sebelum: <b>".$bw_awal."</b> \nBW Sesudah: <b>".$bw_DB."</b>\n\nTerima kasih.");
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
		$scheduler  = $this->db->get_where('gm_scheduler', array('id' => $id))->row_array();
		$routerid 	= $this->db->get_where('gm_router', array('id' => $scheduler['idrouter']))->row_array();
		$teid 		= $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();
		$drid 		= $this->db->get_where('gm_dr', array('id' => $routerid['DR']))->row_array();
		//ENKRIPSI PASSWORD ROUTER
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_user = $routerid['router_user'];
		$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $routerid['router_pass'];
		$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
		
		$te_str_ip = $teid['ip'];
		$te_ip = $ar_chip->decrypt($te_str_ip, $ar_rand);
		$te_str_user = $teid['user'];
		$te_user = $ar_chip->decrypt($te_str_user, $ar_rand);
		$te_str_pass = $teid['pass'];
		$te_pass = $ar_chip->decrypt($te_str_pass, $ar_rand);
		
		$dr_str_ip = $drid['ip'];
		$dr_ip = $ar_chip->decrypt($dr_str_ip, $ar_rand);
		$dr_str_user = $drid['user'];
		$dr_user = $ar_chip->decrypt($dr_str_user, $ar_rand);
		$dr_str_pass = $teid['pass'];
		$dr_pass = $ar_chip->decrypt($dr_str_pass, $ar_rand);
		
		
			
		$schname 		= $scheduler['permintaan']."-".$scheduler['pelanggan']."-".$scheduler['resource'];
		require_once APPPATH."third_party/addon.php";
		$kripto 	 	= new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$xdark_rand  	= "%^$%^&%*GMEDIA%^$%^&%*";
		if($scheduler['permintaan'] == "Upgrade" or $scheduler['permintaan'] == "Downgrade")
		{		
		if ($this->routerosapi->connect($dr_ip,$dr_user,$dr_pass))
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
		elseif($scheduler['permintaan'] == "Free BOD +50% Bandwidth")
		{		
		if ($this->routerosapi->connect($dr_ip,$dr_user,$dr_pass))
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
		elseif($scheduler['permintaan'] == "Free BOD +100% Bandwidth")
		{		
		if ($this->routerosapi->connect($dr_ip,$dr_user,$dr_pass))
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
		elseif($scheduler['permintaan'] == "BOD Berbayar")
		{		
		if ($this->routerosapi->connect($dr_ip,$dr_user,$dr_pass))
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
		if ($this->routerosapi->connect($te_ip,$te_user,$te_pass))
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
		//$this->session->unset_userdata('success');
        //return $this->session->set_flashdata('success', 'Berhasil menghapus data '.$schname.' '.$id_router.'');	
        return $this->db->delete('gm_scheduler', array('id' => $id));
        return false;
    }	
}