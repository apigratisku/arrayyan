<?php

class Fiberstream_model extends CI_Model{

public function get_fs() {
            $this->db->select('gm_fiberstream.*,gm_router.nama,gm_router.cid,gm_router.interface,gm_router.status');
            $this->db->from('gm_router');
			$this->db->join('gm_fiberstream','gm_fiberstream.cid = gm_router.cid');
			$this->db->order_by("status_layanan", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
       	    return $response;
    }
public function get_pon() {
            $this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where("produk","FIBERSTREAM");
			$this->db->or_where("produk","GFORCE");
			$this->db->order_by("interface", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
       	    return $response;
    }
public function count() {
        return $this->db->get_where('gm_router', array('produk' => "FIBERSTREAM"))->num_rows();
    }	
public function count_isolir() {
        return $this->db->get_where('gm_fiberstream', array('status_layanan' => "0"))->num_rows();
    }
public function count_isolir_list() {
			$this->db->select('gm_fiberstream.*,gm_router.nama,gm_router.cid,gm_router.status');
            $this->db->from('gm_router');
			$this->db->join('gm_fiberstream','gm_fiberstream.cid = gm_router.cid');
			$this->db->where("status_layanan","0");
            $query = $this->db->get();
            $response = $query->result_array();
       	    return $response; 
    }
public function bcschedule() {
			$this->db->truncate('gm_fiberstream');
            $this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where("produk","FIBERSTREAM");
			$this->db->order_by("nama", "asc");
			//$this->db->limit(1,1);
            $query = $this->db->get();
            $response = $query->result_array();
        	$serverid = $this->db->get('gm_server')->row_array();
			foreach ($response as $item)
			{	
					//BC GET DATA TE
					$teid = $this->db->get_where('gm_te', array('id' => $item['TE']))->row_array();
					$this->db->select('*');
					$this->db->from('gm_fiberstream');
					$this->db->where("cid",$item['cid']);
					$this->db->order_by("id", "desc");
					$this->db->limit(1,1);
					$query = $this->db->get();
					$fsid = $query->row_array();
					
					//Random Resource
					$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					$passrand = array(); //remember to declare $pass as an array
					$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
					for ($i = 0; $i < 8; $i++) {
					$n = rand(0, $alphaLength);
					$passrand[] = $alphabet[$n];
					}
					$resource = implode($passrand);
					
					
					//ENKRIPSI PASSWORD ROUTER
					/*require_once APPPATH."third_party/addon.php";
					$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
					$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
					
					$te_str_ip = $teid['ip'];
					$te_ip = $ar_chip->decrypt($te_str_ip, $ar_rand);
					$te_str_user = $teid['user'];
					$te_user = $ar_chip->decrypt($te_str_user, $ar_rand);
					$te_str_pass = $teid['pass'];
					$te_pass = $ar_chip->decrypt($te_str_pass, $ar_rand);
					//Random Resource
					$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					$passrand = array(); //remember to declare $pass as an array
					$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
					for ($i = 0; $i < 8; $i++) {
					$n = rand(0, $alphaLength);
					$passrand[] = $alphabet[$n];
					}
					$resource = implode($passrand);
					//DATE
					date_default_timezone_set("Asia/Singapore");
					$newDate = date("M/")."20/".date("Y");
					$schname = "Isolir-".$item['nama']."-".$resource;
					$aplikasi = $serverid['ip_aplikasi'];
					//BC SCHEDULER TE PEMENANG
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass,$te_port))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);     				
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time=00:00:01', false);  
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$item['router_network']." - ".$item['nama']."\" chain=forward action=drop disabled=no src-address=".$item['router_network']."; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$item['id']."&status=1\" keep-result=no; /system scheduler remove [find name=\"".$schname."\"];", false);			
					$this->routerosapi->write('=disabled=no');
					$this->routerosapi->read();					
					$this->routerosapi->disconnect();	
					$this->session->set_flashdata('message','Data berhasil ditambahkan!');
					}
					else
					{
						$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}*/
					$bulan = date("M");
					$tahun = date("Y");
					$data = array(
					
					'cid' => $item['cid'],
					'resource' => $resource,
					'status_layanan' => $fsid['status_layanan'],
					);				
					$this->db->insert('gm_fiberstream', $data);
			}
					$this->session->set_flashdata('success', 'Refresh data berhasil.');	
    }
	
public function get($cid) {

        if ($cid) {
            $query = $this->db->get_where('gm_fiberstream', array('cid' => $cid));
            $response = $query->result_array();
        }
        return $response;
    }
public function getcid() {

        	$this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where('cid !=', 'NULL');
			$this->db->order_by("cid", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
			return $response; 
    }
public function approve($cid,$id) {

					//BC GET DATA TE
					$fsid = $this->db->get_where('gm_fiberstream', array('id' => $id))->row_array();
					$routerid = $this->db->get_where('gm_router', array('cid' => $fsid['cid']))->row_array();
					$teid = $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();
					$fsdata = $this->db->get_where('gm_fiberstream', array('id' => $id))->result_array();

					$te_ip = $this->secure->decrypt_url($teid['ip']);
					$te_user = $this->secure->decrypt_url($teid['user']);
					$te_pass = $this->secure->decrypt_url($teid['pass']);
					$te_port = $teid['port'];
					//Random Resource
					$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					$passrand = array(); //remember to declare $pass as an array
					$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
					for ($i = 0; $i < 8; $i++) {
					$n = rand(0, $alphaLength);
					$passrand[] = $alphabet[$n];
					}
					$resource = implode($passrand);
					//DATE
					date_default_timezone_set("Asia/Singapore");
					$newDate = date("M/")."13/".date("Y");
					$newDate_now = date("M/d/Y H:i:s");
					$schname = "Open Isolir-".$routerid['nama']."-".$fsid['resource'];
					//$schname_open = "Isolir-".$routerid['nama']."-".$resource;
					
					//BC SCHEDULER TE PEMENANG
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass,$te_port))
					{	
						foreach($fsdata as $fsdataku)
						{
							$schname_get = "Isolir-".$routerid['nama']."-".$fsdataku['resource'];
							$this->routerosapi->write("/system/scheduler/print", false);			
							$this->routerosapi->write("=.proplist=.id", false);		
							$this->routerosapi->write("?name=".$schname_get);				
							$APIsch = $this->routerosapi->read();
							foreach ($APIsch as $sch)
							{
								$id_router = $sch['.id'];
							}
							if(isset($id_router))
							{
							$this->routerosapi->write('/system/scheduler/remove',false);
							$this->routerosapi->write("=.id=".$id_router);
							$this->routerosapi->read();
							}
							$this->routerosapi->write('/system/scheduler/add',false);				
							$this->routerosapi->write('=name='.$schname, false);							
							$this->routerosapi->write('=interval=00:00:03', false);
							$this->routerosapi->write('=start-time=startup', false);  
							$this->routerosapi->write('=on-event='."/ip firewall filter remove [find comment=\"".$routerid['router_network']." - ".$routerid['nama']."\"]; /system scheduler remove [find name=\"".$schname."\"];", false);						
							$this->routerosapi->write('=disabled=no');				
							$this->routerosapi->read();
								//if($fsdataku['status_bayar'] == "0")
								//{
								//$data = $this->telegram_lib->sendmsg("Pembayaran pelanggan <b>".$routerid['nama']."</b> CID <b>".$fsdataku['cid']."</b> tagihan <b>".$fsdataku['invoice_bulan']." ".$fsdataku['invoice_tahun']."</b> terverifikasi tanggal <b>".date("M/d/Y H:i:s")."</b> Wita.");
								//}
							$data = array(
							'status_layanan' => "1",
							'status_bayar' => "1",
							);
							$this->db->where('id', $fsdataku['id']);
							$this->db->update('gm_fiberstream', $data);
							$this->telegram_lib->sendmsg("Open isolir pelanggan <b>".$routerid['nama']."</b> telah di proses tanggal <b>".$newDate_now."</b> secara otomatis.\n\nTerima kasih.");
						}
						$this->routerosapi->disconnect();
						
						return $this->session->set_flashdata('success', 'Pembayaran pelanggan '.$routerid['nama'].' telah di approve.');
					}
					else
					{
						return $this->session->set_flashdata('error', 'Approval pembayaran gagal.');
					}
					/*$bulan = date("M");
					$tahun = date("Y");
					$data = array(
					
					'cid' => $fsid['cid'],
					'invoice_tahun' => $tahun,
					'invoice_bulan' => $bulan,
					'resource' => $resource,
					);	*/				

    }
public function approve_tg($id) {

					//BC GET DATA TE
					$this->db->select('*');
					$this->db->from('gm_fiberstream');
					$this->db->where('cid',$id);
					$this->db->order_by('id', 'desc');
					//$this->db->limit(1,1);
					$query = $this->db->get();
					$fsid = $query->row_array();
					
					$routerid = $this->db->get_where('gm_router', array('cid' => $id))->row_array();
					$teid = $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();
					$fsdata = $this->db->get_where('gm_fiberstream', array('cid' => $id))->result_array();
					
					$te_ip = $this->secure->decrypt_url($teid['ip']);
					$te_user = $this->secure->decrypt_url($teid['user']);
					$te_pass = $this->secure->decrypt_url($teid['pass']);
					$te_port = $teid['port'];
					//Random Resource
					$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					$passrand = array(); //remember to declare $pass as an array
					$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
					for ($i = 0; $i < 8; $i++) {
					$n = rand(0, $alphaLength);
					$passrand[] = $alphabet[$n];
					}
					$resource = implode($passrand);
					//DATE
					date_default_timezone_set("Asia/Singapore");
					$newDate = date("M/")."13/".date("Y");
					$newDate_now = date("M/d/Y H:i:s");
					$schname = "Open-".$routerid['nama']."-".$resource;
					//$schname_open = "Isolir-".$routerid['nama']."-".$resource;
					
					//BC SCHEDULER TE PEMENANG
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass,$te_port))
					{	
						foreach($fsdata as $fsdataku)
						{
							$this->routerosapi->write('/system/scheduler/add',false);				
							$this->routerosapi->write('=name='.$schname, false);							
							$this->routerosapi->write('=interval=00:00:03', false);
							$this->routerosapi->write('=start-time=startup', false);  
							$this->routerosapi->write('=on-event='."/ip firewall filter remove [find comment=\"".$routerid['router_network']." - ".$routerid['nama']."\"]; /system scheduler remove [find name=\"".$schname_get."\"];", false);						
							$this->routerosapi->write('=disabled=no');				
							$this->routerosapi->read();
								
							$data = array(
							'status_layanan' => "1",
							'status_bayar' => "1",
							);
							$this->db->where('id', $fsdataku['id']);
							$this->db->update('gm_fiberstream', $data);
							
						}
						$this->routerosapi->disconnect();	
						return $this->telegram_lib_noc->sendmsg("Open isolir pelanggan <b>".$routerid['nama']."</b> telah sukses di proses tanggal <b>".$newDate_now."</b> secara otomatis.\nTerima kasih");
					}
					else
					{
						return $this->telegram_lib_noc->sendmsg("Open isolir pelanggan <b>".$routerid['nama']."</b> Gagal.");
					}			

    }
	
public function isolir($cid,$id) {
					//BC GET DATA TE
					$this->db->select('*');
					$this->db->from('gm_fiberstream');
					$this->db->where('id',$id);
					$this->db->order_by('id', 'desc');
					//$this->db->limit(1,1);
					$query = $this->db->get();
					$fsid = $query->row_array();
					
					//$fsid = $this->db->get_where('gm_fiberstream', array('id' => $id))->row_array();
					//return $this->session->set_flashdata('success', 'Isolir pelanggan CID '.$fsid['cid'].'-'.$fsid['invoice_bulan'].'-'.$fsid['id'].' '.$routerid['nama'].' SUKSES.');
				 //$fsid = $this->db->get_where('gm_fiberstream', array('cid' => $id))->order_by("id", "desc")->limit(1,1)->row_array();
					$routerid = $this->db->get_where('gm_router', array('cid' => $fsid['cid']))->row_array();
					$teid = $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();
					
					$te_ip = $this->secure->decrypt_url($teid['ip']);
					$te_user = $this->secure->decrypt_url($teid['user']);
					$te_pass = $this->secure->decrypt_url($teid['pass']);
					$te_port = $teid['port'];
					//Random Resource
					$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					$passrand = array(); //remember to declare $pass as an array
					$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
					for ($i = 0; $i < 8; $i++) {
					$n = rand(0, $alphaLength);
					$passrand[] = $alphabet[$n];
					}
					$resource = implode($passrand);
					//DATE
					$newDate = date("M/")."13/".date("Y");
					$newDate_now = date("M/d/Y H:i:s");
					$schname = "Isolir-".$routerid['nama']."-".$resource;
					$schname_open = "Isolir-".$routerid['nama']."-".$resource;
					$schname_get = "Isolir-".$routerid['nama']."-".$fsid['resource'];
					//BC SCHEDULER TE PEMENANG
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass,$te_port))
					{
						$this->routerosapi->write('/system/scheduler/add',false);				
						$this->routerosapi->write('=name='.$schname, false);							
						$this->routerosapi->write('=interval=00:00:03', false);     				
						$this->routerosapi->write('=start-time=startup', false); 
						$this->routerosapi->write('=comment='."Menunggu", false); 
						$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['router_network']." - ".$routerid['nama']."\" chain=forward action=drop disabled=no src-address=".$routerid['router_network']."; /system scheduler remove [find name=\"".$schname."\"]; ", false);						
						$this->routerosapi->write('=disabled=no');				
						$this->routerosapi->read();
						$this->routerosapi->disconnect();
						//$data = $this->telegram_lib->sendmsg("Isolir pelanggan <b>".$routerid['nama']."</b> telah sukses di eksekusi tanggal <b>".date("M/d/Y H:i:s")."</b> secara otomatis ya kak.");
					}
					else
					{
						$this->session->set_flashdata('error', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
					}
					$bulan = date("M");
					$tahun = date("Y");
					$data = array(
					
					'cid' => $fsid['cid'],
					'invoice_tahun' => $tahun,
					'invoice_bulan' => $bulan,
					'resource' => $resource,
					);					
		
        if ($id) {
			$data = array(
			'status_layanan' => "0",
			'status_bayar' => "0",
        );
            $this->db->where('id', $fsid['id']);
            $this->db->update('gm_fiberstream', $data);
			//$this->telegram_lib->sendmsg("Isolir pelanggan <b>".$routerid['nama']."</b> telah di proses tanggal <b>".$newDate_now."</b> secara otomatis.\n\nTerima kasih.");
			return $this->session->set_flashdata('success', 'Isolir pelanggan CID '.$cid.'-'.$routerid['nama'].' sukses.');
			
        }
		return $this->session->set_flashdata('error', 'Isolir pelanggan CID '.$cid.'-'.$routerid['nama'].' gagal !!!');
}
public function isolir_tg($id) {
					//BC GET DATA TE
					$this->db->select('*');
					$this->db->from('gm_fiberstream');
					$this->db->where('cid',$id);
					$this->db->order_by('id', 'desc');
					$query = $this->db->get();
					$fsid = $query->row_array();
					$routerid = $this->db->get_where('gm_router', array('cid' => $fsid['cid']))->row_array();
					$teid = $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();
					
					$te_ip = $this->secure->decrypt_url($teid['ip']);
					$te_user = $this->secure->decrypt_url($teid['user']);
					$te_pass = $this->secure->decrypt_url($teid['pass']);
					$te_port = $teid['port'];
					//Random Resource
					$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
					$passrand = array(); //remember to declare $pass as an array
					$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
					for ($i = 0; $i < 8; $i++) {
					$n = rand(0, $alphaLength);
					$passrand[] = $alphabet[$n];
					}
					$resource = implode($passrand);
					//DATE
					$newDate = date("M/")."13/".date("Y");
					$schname = "Isolir-".$routerid['nama']."-".$resource;
					$schname_open = "Isolir-".$routerid['nama']."-".$resource;
					$schname_get = "Isolir-".$routerid['nama']."-".$fsid['resource'];
					//BC SCHEDULER TE PEMENANG
					if ($this->routerosapi->connect($te_ip,$te_user,$te_pass,$te_port))
					{
						$this->routerosapi->write("/ip/firewall/filter/print",false);			
						$this->routerosapi->write("=.proplist=.id", false);		
						$this->routerosapi->write("=.proplist=src-address", false);		
						$this->routerosapi->write("?src-address=".$routerid['router_network']);				
						$API_FILTER = $this->routerosapi->read();
						foreach ($API_FILTER as $FILTER)
						{
							$DATA_FILTER = $FILTER['src-address'];
						}
						if($DATA_FILTER == NULL)
						{
						$this->routerosapi->write('/system/scheduler/add',false);				
						$this->routerosapi->write('=name='.$schname, false);							
						$this->routerosapi->write('=interval=00:00:03', false);     				
						$this->routerosapi->write('=start-time=startup', false); 
						$this->routerosapi->write('=comment='."Menunggu", false); 
						$this->routerosapi->write('=on-event='."/ip firewall filter add comment=\"".$routerid['router_network']." - ".$routerid['nama']."\" chain=forward action=drop disabled=no src-address=".$routerid['router_network']."; /system scheduler remove [find name=\"".$schname."\"]; ", false);						
						$this->routerosapi->write('=disabled=no');				
						$this->routerosapi->read();
						}
						
						$this->routerosapi->disconnect();
						
						$bulan = date("M");
						$tahun = date("Y");
						$data = array(
						
						'cid' => $fsid['cid'],
						'invoice_tahun' => $tahun,
						'invoice_bulan' => $bulan,
						'resource' => $resource,
						);					
		
						if ($id) 
						{
							$data = array(
							'status_layanan' => "0",
							'status_bayar' => "0",
							);
							$this->db->where('id', $fsid['id']);
							$this->db->update('gm_fiberstream', $data);
					return $this->telegram_lib->sendmsg("Isolir pelanggan <b>".$routerid['nama']."</b> telah sukses di eksekusi tanggal <b>".$newDate_now."</b> secara otomatis ya kak.");
						}
					}
					else
					{
						return $this->telegram_lib->sendmsg("Isolir pelanggan <b>".$routerid['nama']."</b> Gagal.");
					}
}


public function get_client($keyword) {
			$this->db->select('*');
			//$this->db->select('gm_fiberstream.*,gm_router.nama,gm_router.cid,gm_router.status');
            $this->db->from('gm_router');
			//$this->db->join('gm_fiberstream','gm_fiberstream.cid = gm_router.cid');
			$this->db->where("produk","FIBERSTREAM");
			$this->db->group_start();
			$this->db->like('gm_router.nama',$keyword);
			$this->db->group_end();
            $query = $this->db->get();
            $response = $query->result_array();
       	    return $response;
    }

public function get_client_count($keyword) {
			$this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where("produk","FIBERSTREAM");
			$this->db->group_start();
			$this->db->like('gm_router.nama',$keyword);
			$this->db->group_end();
            $query = $this->db->get();
            $response = $query->num_rows();
       	    return $response;
    }
public function get_client_all() {
			$this->db->select('*');
			//$this->db->select('gm_fiberstream.*,gm_router.nama,gm_router.cid,gm_router.status');
            $this->db->from('gm_router');
			//$this->db->join('gm_fiberstream','gm_fiberstream.cid = gm_router.cid');
			$this->db->where("produk","FIBERSTREAM");
            $query = $this->db->get();
            $response = $query->result_array();
       	    return $response;
    }
public function get_client_count_all() {
			$this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where("produk","FIBERSTREAM");
            $query = $this->db->get();
            $response = $query->num_rows();
       	    return $response;
    }
public function reset() {  
		if ($this->setting_model->reset()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil Reset default database Laporan');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal Reset default database Laporan');
        }
        redirect('manage/setting');
    }
//public function reset(){
//            return $this->db->truncate('adamart_laporan');
//    }	
	
//END FUNGSI

//SYNTAX FIBERSTREAM OLT
public function redaman($getcid) {
 		
		//Get DB [xvlan2205-123]
		$data1 = trim($getcid,' ');
		$method="AES-128-CBC";
		$key ="25c6c7ff35b9979b151f2136cd13b0ff";
		$option=0;
		$iv="1251632135716362";
		$cid=openssl_decrypt(hex2bin($data1), $method, $key, $option, $iv);
		$db_client = $this->db->get_where('gm_router', array('cid' => $cid))->row_array();
		$pon_str = explode("-",$db_client['interface']);
		$pon_str1 = substr($pon_str[0], 7);
		$pon_str2 = substr($pon_str[1],1,-1);
		if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
		$pon_fix = "$pon_str1:$pon_str3";
		//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
 		$this->load->library('phptelnet');
		$telnet1 = new PHPTelnet();
		$result1 = $telnet1->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
		$telnet2 = new PHPTelnet();
		$result2 = $telnet2->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
        /*if ($result == 0)
		{
		$telnet->DoCommand('', $result);
		$telnet->DoCommand('show pon power attenuation gpon-onu_1/1/'.$pon_fix, $result);
		$telnet->DoCommand('', $result);
		$skuList = preg_split('/\r\n|\r|\n/', $result);
			foreach($skuList as $key => $value )
			{
				if($value == "show pon power attenuation gpon-onu_1/1/".$pon_fix)
				{ echo""; }
				elseif($value == "           OLT                  ONU              Attenuation")
				{ echo""; }
				elseif($value == "--------------------------------------------------------------------------")
				{ echo""; }
				elseif($value == "OLT-ZTE-GMEDIA-PMG#")
				{ echo""; }
				else
				{
				$items_onu[] = $value;
				}
			}
				
				$output1="";
				foreach($items_onu as $onu )
				{
					$output1.= $onu."<br>";
				}
			
				
	
		}*/
		/*if(strpos($output1, '1'))
			{

					$telnet->DoCommand('', $result);
					$telnet->DoCommand('show gpon onu detail-info gpon-onu_1/1/'.$pon_fix, $result);
					$telnet->DoCommand('', $result);	
					$skuList2 = preg_split('/\r\n|\r|\n/', $result);
					$output_all = "";
					foreach($skuList2 as $key2 => $value2 )
					{
						if($value2 == "show gpon onu detail-info gpon-onu_1/1/".$pon_fix)
						{ $output_all.= ""; }
						elseif($value2 == "Phase state:         LOS")
						{ $output_all.= "Phase state: LOS"; }
						elseif($value2 == "Phase state:         OffLine")
						{ $output_all.= "Phase state: OffLine"; }
						elseif($value2 == "Phase state:         DyingGasp")
						{ $output_all.= "Phase state: DyingGasp"; }
						else
						{ $output_all.= "Phase state: working"; }
					}
			}
			else
			{
				$output_all = $output1;
			}*/
			
			
		if ($result1 == 0)
		{
		$telnet1->DoCommand('show gpon onu detail-info gpon-onu_1/1/'.$pon_fix, $result1);
		$skuList1 = preg_split('/\r\n|\r|\n/', $result1);
			foreach($skuList1 as $key => $value1)
			{
			$items_onu[] = $value1;
			}
			$output="";
			foreach($items_onu as $onu)
			{
				$output.= $onu."<br>";
				$str_olt = explode(" ", $onu);
			}
			$output_phase = $items_onu[9]."<br>".$items_onu[13];
		}
		//Cek Redaman
		if ($result2 == 0)
		{
			$telnet2->DoCommand('', $result2);
			$telnet2->DoCommand('show pon power attenuation gpon-onu_1/1/'.$pon_fix, $result2);
			$telnet2->DoCommand('', $result2);
			$skuList2 = preg_split('/\r\n|\r|\n/', $result2);
				foreach($skuList2 as $key => $value2 )
				{
					if($value2 == "show pon power attenuation gpon-onu_1/1/".$pon_fix)
					{ echo""; }
					elseif($value2 == "           OLT                  ONU              Attenuation")
					{ echo""; }
					elseif($value2 == "--------------------------------------------------------------------------")
					{ echo""; }
					elseif($value2 == "OLT-ZTE-GMEDIA-PMG#")
					{ echo""; }
					else
					{
					$items_onu2[] = $value2;
					}
				}
					
					$output_redaman="";
					foreach($items_onu2 as $onu2 )
					{
						$output_redaman.= $onu2."<br>";
					}	
			
		}	
			
			if($items_onu[9] == "Phase state: working")
			{	
				$response = "<b>".$db_client['nama']."</b><br>-------------------------------------------------------------------------<br>".$output_redaman;
			}	
			else
			{
				$response = "<b>".$db_client['nama']."</b><br>-------------------------------------------------------------------------<br>".$output_phase."<br><br>".$output_redaman;
			}
			
			
		return $response;	
    }

public function port($getcid) {
 		
		//Get DB [xvlan2205-123]
		$data1 = trim($getcid,' ');
		$method="AES-128-CBC";
		$key ="25c6c7ff35b9979b151f2136cd13b0ff";
		$option=0;
		$iv="1251632135716362";
		$cid=openssl_decrypt(hex2bin($data1), $method, $key, $option, $iv);
		$db_client = $this->db->get_where('gm_router', array('cid' => $cid))->row_array();
		$pon_str = explode("-",$db_client['interface']);
		$pon_str1 = substr($pon_str[0], 7);
		$pon_str2 = substr($pon_str[1],1,-1);
		if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
		$pon_fix = "$pon_str1:$pon_str3";
		//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
 		$this->load->library('phptelnet');
		$telnet = new PHPTelnet();
		$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
        if ($result == 0)
		{
		$telnet->DoCommand('show onu running config gpon-onu_1/1/'.$pon_fix, $result);
		$skuList = preg_split('/\r\n|\r|\n/', $result);
			foreach($skuList as $key => $value )
			{
			$items_onu[] = $value;
			}
				//DC Telnet
				$telnet->Disconnect();
				$output="";
				foreach($items_onu as $onu )
				{
					$output.= $onu."<br>";
					
				}
				$response = "<b>".$db_client['nama']."</b><br><br>".$output;
				return $response;
		}
		
    }
public function profile($getcid) {
 		
		//Get DB [xvlan2205-123]
		$data1 = trim($getcid,' ');
		$method="AES-128-CBC";
		$key ="25c6c7ff35b9979b151f2136cd13b0ff";
		$option=0;
		$iv="1251632135716362";
		$cid=openssl_decrypt(hex2bin($data1), $method, $key, $option, $iv);
		$db_client = $this->db->get_where('gm_router', array('cid' => $cid))->row_array();
		$pon_str = explode("-",$db_client['interface']);
		$pon_str1 = substr($pon_str[0], 7);
		$pon_str2 = substr($pon_str[1],1,-1);
		if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
		$pon_fix = "$pon_str1:$pon_str3";
		//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
 		$this->load->library('phptelnet');
		$telnet = new PHPTelnet();
		$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
        if ($result == 0)
		{
		$telnet->DoCommand('show run interface gpon-onu_1/1/'.$pon_fix, $result);
		$skuList = preg_split('/\r\n|\r|\n/', $result);
			foreach($skuList as $key => $value )
			{
			$items_onu[] = $value;
			}
				//DC Telnet
				$telnet->Disconnect();
				$output="";
				foreach($items_onu as $onu )
				{
					$output.= $onu."<br>";
					
				}
				$response = "<b>".$db_client['nama']."</b><br><br>".$output;
				return $response;
		}
		
    }
public function bandwidth($getcid){
	//Get DB [xvlan2205-123]
	$data1 = trim($getcid,' ');
	$method="AES-128-CBC";
	$key ="25c6c7ff35b9979b151f2136cd13b0ff";
	$option=0;
	$iv="1251632135716362";
	$cid=openssl_decrypt(hex2bin($data1), $method, $key, $option, $iv);
	$routerid = $this->db->get_where('gm_router', array('cid' => $cid))->row_array();
	
	$getkey = substr($routerid['interface'],0,-8);
	if($getkey == "xvlan"){$teid = $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();}
	else{$teid = $this->db->get_where('gm_router', array('cid' => $cid))->row_array();}
	
	
	if($getkey == "xvlan")
	{
		$te_str_ip = $teid['ip'];
		$te_str_user = $teid['user'];
		$te_str_pass = $teid['pass'];
		$te_ip = $this->secure->decrypt_url($teid['ip']);
		$te_user = $this->secure->decrypt_url($teid['user']);
		$te_pass = $this->secure->decrypt_url($teid['pass']);
	} 
	else 
	{
		$te_ip = $teid['router_ip'];
		$te_user = $teid['router_user'];
		$te_pass = $teid['router_pass'];
		$te_port = $teid['router_port'];
	}
	
	
									
				
	if ($this->routerosapi->connect($te_ip, $te_user, $te_pass,$te_port))
		{
	
			$this->routerosapi->write("/interface/monitor-traffic",false);			
			$this->routerosapi->write("=interface=".$routerid['interface'],false);	
			$this->routerosapi->write("=once=",true);
			$ARRAY = $this->routerosapi->read();
			if(count($ARRAY)>0){  
			  $rxB = number_format($ARRAY[0]["rx-bits-per-second"],1);
			  $txB = number_format($ARRAY[0]["tx-bits-per-second"],1);
			  $rxK = number_format($ARRAY[0]["rx-bits-per-second"]/1024,1);
			  $txK = number_format($ARRAY[0]["tx-bits-per-second"]/1024,1);
			  $rxM = number_format($ARRAY[0]["rx-bits-per-second"]/1024/1024,1);
			  $txM = number_format($ARRAY[0]["tx-bits-per-second"]/1024/1024,1);
			  if(strlen($rxK) >= 5) {$DL="Download: $txM Mbps";} elseif($rxB == 0) {$DL="Download: $rxB Bytes";} else {$DL="Download: $txK Kbps";}
			  if(strlen($txK) >= 5) {$UP="Upload: $rxM Mbps";} elseif($txB == 0) {$UP="Download: $txB Bytes";} else {$UP="Upload: $rxK Kbps";}		  
			  $response = "<b>".$routerid['nama']."</b><br><br>$UP<br>$DL";
			}	
			else
			{
				$response = "-";
			}
			return $response;
		}	
		$this->routerosapi->disconnect();	
}
public function restart($getcid) {
 		
		//Get DB [xvlan2205-123]
		$data1 = trim($getcid,' ');
		$method="AES-128-CBC";
		$key ="25c6c7ff35b9979b151f2136cd13b0ff";
		$option=0;
		$iv="1251632135716362";
		$cid=openssl_decrypt(hex2bin($data1), $method, $key, $option, $iv);
		$db_client = $this->db->get_where('gm_router', array('cid' => $cid))->row_array();
		$pon_str = explode("-",$db_client['interface']);
		$pon_str1 = substr($pon_str[0], 7);
		$pon_str2 = substr($pon_str[1],1,-1);
		if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
		$pon_fix = "$pon_str1:$pon_str3";
		//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
 		$this->load->library('phptelnet');
		$telnet = new PHPTelnet();
		$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
        if ($result == 0)
		{
		$telnet->DoCommand('configure terminal', $result);
		$telnet->DoCommand('pon-onu-mng gpon-onu_1/1/'.$pon_fix, $result);
		$telnet->DoCommand('reboot', $result);
		$telnet->DoCommand('yes', $result);
		$skuList = preg_split('/\r\n|\r|\n/', $result);
			foreach($skuList as $key => $value )
			{
			$items_onu[] = $value;
			}
				//DC Telnet
				$telnet->Disconnect();
				$output="";
				foreach($items_onu as $onu )
				{
					$output.= $onu."<br>";
					
				}
				return "Proses Restart ONU <b>".$db_client['nama']."<b> - ".$db_client['interface'];
		}
		
    }




/*//SYNTAX FIBERSTREAM OLT [TELEGRAM]
public function get_fo_redaman($nama) {
		//Get Data from table Router
 		$this->db->select('*');
		$this->db->from('gm_router');
		$this->db->group_start();
		$this->db->like('gm_router.nama',$nama);
		$this->db->group_end();
		$get_query = $this->db->get();
		$get_data = $get_query->row_array();
		if($get_data['DR'] == "4" && $get_data['media'] == "Fiber Optic (Onnet)")
		{
			$pon_str = explode("-",$get_data['interface']);
			$pon_str1 = substr($pon_str[0], 7);
			$pon_str2 = substr($pon_str[1],1,-1);
			if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
			$pon_fix = "$pon_str1:$pon_str3";
			//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			if ($result == 0)
			{
			$telnet->DoCommand('', $result);
			$telnet->DoCommand('show pon power attenuation gpon-onu_1/1/'.$pon_fix, $result);
			$telnet->DoCommand('', $result);
			$skuList = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList as $key => $value )
				{
					if($value == "show pon power attenuation gpon-onu_1/1/".$pon_fix)
					{ echo""; }
					elseif($value == "           OLT                  ONU              Attenuation")
					{ echo""; }
					elseif($value == "--------------------------------------------------------------------------")
					{ echo""; }
					elseif($value == "OLT-ZTE-GMEDIA-PMG#")
					{ echo""; }
					else
					{
					$items_onu[] = $value;
					}
				}
					//DC Telnet
					$telnet->Disconnect();
					$output1="";
					foreach($items_onu as $onu )
					{
						$output1.= urlencode($onu."\r\n");
					}
				$response = urlencode("<b>".$get_data['nama']."</b>\r\n").$output1;
				return $response;
			}
		}
		else
		{
			return "Pelanggan under OLT Nutana masih dalam pengerjaan.";
		}
    }*/
	
//SYNTAX FIBERSTREAM OLT [TELEGRAM]
public function get_fo_redaman($nama) {
		//Get Data from table Router
 		$this->db->select('*');
		$this->db->from('gm_router');
		$this->db->group_start();
		$this->db->like('gm_router.nama',$nama);
		$this->db->group_end();
		$get_query = $this->db->get();
		$get_data = $get_query->row_array();
		
		if($get_data['DR'] == "4" && $get_data['media'] == "Fiber Optic (Onnet)")
		{
			$pon_str = explode("-",$get_data['interface']);
			$pon_str1 = substr($pon_str[0], 7);
			$pon_str2 = substr($pon_str[1],1,-1);
			if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
			$pon_fix = "$pon_str1:$pon_str3";
			//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
			$this->load->library('phptelnet');
			$telnet1 = new PHPTelnet();
			$result1 = $telnet1->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			$telnet2 = new PHPTelnet();
			$result2 = $telnet2->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			if ($result1 == 0)
			{
			$telnet1->DoCommand('show gpon onu detail-info gpon-onu_1/1/'.$pon_fix, $result1);
			$skuList1 = preg_split('/\r\n|\r|\n/', $result1);
				foreach($skuList1 as $key => $value1)
				{
				$items_onu[] = $value1;
				}
				$output="";
				foreach($items_onu as $onu)
				{
					$output.= $onu."\r\n";
					$str_olt = explode(" ", $onu);
				}
				$output_phase = urlencode($items_onu[9]."\r\n".$items_onu[13]."\r\n");
			}
			//Cek Redaman
			if ($result2 == 0)
			{
				$telnet2->DoCommand('', $result2);
				$telnet2->DoCommand('show pon power attenuation gpon-onu_1/1/'.$pon_fix, $result2);
				$telnet2->DoCommand('', $result2);
				$skuList2 = preg_split('/\r\n|\r|\n/', $result2);
					foreach($skuList2 as $key => $value2 )
					{
						if($value2 == "show pon power attenuation gpon-onu_1/1/".$pon_fix)
						{ echo""; }
						elseif($value2 == "           OLT                  ONU              Attenuation")
						{ echo""; }
						elseif($value2 == "--------------------------------------------------------------------------")
						{ echo""; }
						elseif($value2 == "OLT-ZTE-GMEDIA-PMG#")
						{ echo""; }
						else
						{
						$items_onu2[] = $value2;
						}
					}
						
						$output_redaman="";
						foreach($items_onu2 as $onu2 )
						{
							$output_redaman.= urlencode("\r\n".$onu2);
						}	
				
			}	
			
			if($items_onu[9] == "Phase state: working")
			{	
				$response = urlencode("<b>".$get_data['nama']."</b>\r\n\r\n").$output_phase."".$output_redaman;
			}	
			else
			{
				$response = urlencode("<b>".$get_data['nama']."</b>\r\n\r\n").$output_phase."".$output_redaman;
			}
			return $response;
		}
		else
		{
			return "Pelanggan under OLT Nutana masih dalam pengerjaan.";
		}
    }
public function get_fo_profile($nama) {
		//Get Data from table Router
 		$this->db->select('*');
		$this->db->from('gm_router');
		$this->db->group_start();
		$this->db->like('gm_router.nama',$nama);
		$this->db->group_end();
		$get_query = $this->db->get();
		$get_data = $get_query->row_array();
		if($get_data['DR'] == "3" && $get_data['media'] == "FO")
		{
			$pon_str = explode("-",$get_data['interface']);
			$pon_str1 = substr($pon_str[0], 7);
			$pon_str2 = substr($pon_str[1],1,-1);
			if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
			$pon_fix = "$pon_str1:$pon_str3";
			//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			if ($result == 0)
			{
			$telnet->DoCommand('show run interface gpon-onu_1/1/'.$pon_fix, $result);
			$skuList = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList as $key => $value )
				{
					if($value == "show run interface gpon-onu_1/1/".$pon_fix)
					{ echo""; }
					elseif($value == "Building configuration...")
					{ echo""; }
					elseif($value == "!")
					{ echo""; }
					elseif($value == "end")
					{ echo""; }
					elseif($value == "OLT-ZTE-GMEDIA-PMG#")
					{ echo""; }
					else
					{
					$items_onu[] = $value;
					}
				}
					//DC Telnet
					$telnet->Disconnect();
					$output1="";
					foreach($items_onu as $onu )
					{
						$output1.= urlencode($onu."\r\n");
					}
				$response = urlencode("<b>".$get_data['nama']."</b>\r\n").$output1;
				return $response;
			}
		}
		else
		{
			return "Pelanggan under OLT Nutana masih dalam pengerjaan.";
		}
    }	
public function get_fo_mng($nama) {
		//Get Data from table Router
 		$this->db->select('*');
		$this->db->from('gm_router');
		$this->db->group_start();
		$this->db->like('gm_router.nama',$nama);
		$this->db->group_end();
		$get_query = $this->db->get();
		$get_data = $get_query->row_array();
		if($get_data['DR'] == "3" && $get_data['media'] == "FO")
		{
			$pon_str = explode("-",$get_data['interface']);
			$pon_str1 = substr($pon_str[0], 7);
			$pon_str2 = substr($pon_str[1],1,-1);
			if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
			$pon_fix = "$pon_str1:$pon_str3";
			//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			if ($result == 0)
			{
			$telnet->DoCommand('show onu running config gpon-onu_1/1/'.$pon_fix, $result);
			$skuList = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList as $key => $value )
				{
					if($value == "show onu running config gpon-onu_1/1/".$pon_fix)
					{ echo""; }
					elseif($value == "!")
					{ echo""; }
					elseif($value == "OLT-ZTE-GMEDIA-PMG#")
					{ echo""; }
					else
					{
					$items_onu[] = $value;
					}
				}
					//DC Telnet
					$telnet->Disconnect();
					$output1="";
					foreach($items_onu as $onu )
					{
						$output1.= urlencode($onu."\r\n");
					}
				$response = urlencode("<b>".$get_data['nama']."</b>\r\n").$output1;
				return $response;
			}
		}
		else
		{
			return "Pelanggan under OLT Nutana masih dalam pengerjaan.";
		}
    }
public function get_fo_restart($nama) {		
		//Get Data from table Router
 		$this->db->select('*');
		$this->db->from('gm_router');
		$this->db->group_start();
		$this->db->like('gm_router.nama',$nama);
		$this->db->group_end();
		$get_query = $this->db->get();
		$get_data = $get_query->row_array();
		if($get_data['DR'] == "3" && $get_data['media'] == "FO")
		{
			$pon_str = explode("-",$get_data['interface']);
			$pon_str1 = substr($pon_str[0], 7);
			$pon_str2 = substr($pon_str[1],1,-1);
			if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
			$pon_fix = "$pon_str1:$pon_str3";
			//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			if ($result == 0)
			{
			$telnet->DoCommand('configure terminal', $result);
			$telnet->DoCommand('pon-onu-mng gpon-onu_1/1/'.$pon_fix, $result);
			$telnet->DoCommand('reboot', $result);
			$telnet->DoCommand('yes', $result);
			$skuList = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList as $key => $value )
				{
				$items_onu[] = $value;
				}
					//DC Telnet
					$telnet->Disconnect();
					$output1="";
					foreach($items_onu as $onu )
					{
						$output1.= urlencode($onu."\r\n");
					}
				$response = urlencode("<b>".$get_data['nama']."</b>\r\n").$output1."Proses reboot ONU. . .";
				return $response;
			}
		}
		else
		{
			return "Pelanggan under OLT Nutana masih dalam pengerjaan.";
		}
		
    }

//SYNTAX AUTO CHECK STATUS BROADBAND
public function get_status($ip) {
		//Get Data from table Router
 		$this->db->select('*');
		$this->db->from('gm_router');
		$this->db->where("router_ip",$ip);
		$get_query = $this->db->get();
		$get_data = $get_query->row_array();
		$get_layanan = $this->db->get_where('gm_fiberstream', array('cid' => $get_data['cid']))->row_array();
		if($get_layanan['status_bayar'] == "0" && $get_layanan['status_layanan'] == "0"){$layanan = "Isolir";} else {$layanan = "Aktif";}
		if($get_data['DR'] == "4" && $get_data['media'] == "Fiber Optic (Onnet)")
		{
			$pon_str = explode("-",$get_data['interface']);
			$pon_str1 = substr($pon_str[0], 7);
			$pon_str2 = substr($pon_str[1],1,-1);
			if($pon_str2 == "0"){$pon_str3 = substr($pon_str[1],2);} else {$pon_str3 = substr($pon_str[1],1);} 
			$pon_fix = "$pon_str1:$pon_str3";
			//return "$pon_str1 <br>$pon_str2 <br>$pon_fix";
			$this->load->library('phptelnet');
			$telnet1 = new PHPTelnet();
			$result1 = $telnet1->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			$telnet2 = new PHPTelnet();
			$result2 = $telnet2->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
			if ($result1 == 0)
			{
			$telnet1->DoCommand('show gpon onu detail-info gpon-onu_1/1/'.$pon_fix, $result1);
			$skuList1 = preg_split('/\r\n|\r|\n/', $result1);
				foreach($skuList1 as $key => $value1)
				{
				$items_onu[] = $value1;
				}
				$output="";
				foreach($items_onu as $onu)
				{
					$output.= $onu."\r\n";
					$str_olt = explode(" ", $onu);
				}
				$output_phase = json_decode('"\u27a1"')."".$items_onu[9]."\n".json_decode('"\u27a1"')."".$items_onu[13]."\n".json_decode('"\u27a1"')."".$items_onu[2]."\n";
			}
			//Cek Redaman
			if ($result2 == 0)
			{
				$telnet2->DoCommand('', $result2);
				$telnet2->DoCommand('show pon power attenuation gpon-onu_1/1/'.$pon_fix, $result2);
				$telnet2->DoCommand('', $result2);
				$skuList2 = preg_split('/\r\n|\r|\n/', $result2);
					foreach($skuList2 as $key => $value2 )
					{
						if($value2 == "show pon power attenuation gpon-onu_1/1/".$pon_fix)
						{ echo""; }
						elseif($value2 == "           OLT                  ONU              Attenuation")
						{ echo""; }
						elseif($value2 == "--------------------------------------------------------------------------")
						{ echo""; }
						elseif($value2 == "OLT-ZTE-GMEDIA-PMG#")
						{ echo""; }
						else
						{
						$items_onu2[] = $value2;
						}
					}
						
						$output_redaman="";
						foreach($items_onu2 as $onu2 )
						{
							$output_redaman.= $onu2;
						}	
				
			}	
			
				if($items_onu[9] == "Phase state: working")
			{	
				//$response = urlencode("<b>".$get_data['nama']."</b>\r\n\r\n")."Status layanan: ".$layanan."".urlencode("\r\n").$output_phase."".$output_redaman;
				$response = $this->telegram_lib_noc->sendmsg("".json_decode('"\u2728"')."<b> REPORT FO ONNET ZTE </b>".json_decode('"\u2728"')."\n\n<b>".$get_data['nama']."</b>\nStatus layanan: ".$layanan."\n<pre>".$items_onu[9]."\n".$items_onu[13]."\n".$items_onu[15]."\n".$items_onu[2]."\n</pre>\nStatus Redaman:\n".$items_onu2[0]."\n".$items_onu2[2]."");
			}	
			else
			{
				//$response = urlencode("<b>".$get_data['nama']."</b>\r\n\r\n")."Status layanan: ".$layanan."".urlencode("\r\n").$output_phase."".$output_redaman;
				$response = $this->telegram_lib_noc->sendmsg("".json_decode('"\u2728"')."<b> REPORT FO ONNET ZTE </b>".json_decode('"\u2728"')."\n\n<b>".$get_data['nama']."</b>\nStatus layanan: ".$layanan."\n<pre>".$items_onu[9]."\n".$items_onu[13]."\n".$items_onu[15]."\n".$items_onu[2]."\n</pre>\nStatus Redaman:\n".$items_onu2[0]."\n".$items_onu2[2]."");
			}
			return $response;
		}
		else
		{
			return "Pelanggan under OLT Nutana masih dalam pengerjaan.";
		}
    }
	
}

