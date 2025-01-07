<?php

class Mikrotik_model extends CI_Model{

public function __construct() {
        $this->load->database();
		$this->load->library('secure');
		
    }
public function get_router($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_router', array('id' => $id));
            $response = $query->row_array();
        } else {
            $query = $this->db->get('gm_router');
            $response = $query->result_array();
        }

        return $response;
    }

public function get_router_ip($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_router', array('id'));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where("produk","MAXI");
			$this->db->or_where("produk","BLiP Busol Dedicated");
			$this->db->or_where("produk","BLiP Busol Starter");
			$this->db->or_where("produk","BLiP Busol Business");	
			$this->db->order_by("nama", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }

public function hs_info($id){
		
$routerid = $this->get_router($id);
$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);
$port = $routerid['port'];					
			
if ($this->routerosapi->connect($hostname, $username, $password, $port, $port))
	{
		$this->routerosapi->write('/ip/hotspot/getall');
		$API_hs = $this->routerosapi->read();
		foreach ($API_hs as $hs)
		{
			$hs_id 			= $hs['.id'];
			$hs_disabled 	= $hs['disabled'];	
		}
			if(!isset($hs_id))
			{
			$response = "Tidak Aktif";
			}
			else
			{
				if($hs_disabled == "false"){$response = "Aktif";} else {$response = "Tidak Aktif";}
			}
			return $response;
	}			
}

public function hs_aktif($id){
		
$routerid = $this->get_router($id);
$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);
$port = $routerid['port'];									
			
if ($this->routerosapi->connect($hostname, $username, $password, $port))
	{
		$this->routerosapi->write('/ip/hotspot/active/getall');
		return $this->routerosapi->read();
	}			
}

public function hs_remove($id,$id_session){
		
$routerid = $this->get_router($id);
$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);
$port = $routerid['port'];							
			
	if ($this->routerosapi->connect($hostname, $username, $password, $port))
	{
		$this->routerosapi->write('/ip/hotspot/active/remove',false);
		$this->routerosapi->write("=.id=$id_session");
		$this->routerosapi->read();
		return $this->session->set_flashdata('success', 'Berhasil menghapus session user.');
	}	
	else
	{
		return $this->session->set_flashdata('error', 'Gagal menghubungkan router.');
	}		
}

public function restart($id){
		
$routerid = $this->get_router($id);
$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);								
$port = $routerid['port'];			
	if ($this->routerosapi->connect($hostname, $username, $password, $port))
	{
		$this->routerosapi->write('/system/reboot');
		$this->routerosapi->read();
		$data = array(
            'status' => "1",
        );
		$this->db->where('id', $id);
		$this->db->update('gm_router', $data);
		return $this->session->set_flashdata('success', 'Berhasil melakukan restart router.');
	}	
	else
	{
		return $this->session->set_flashdata('error', 'Gagal menghubungkan router.');
	}	
		
}

public function backup($id){
		
$routerid = $this->get_router($id);
$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);		
$port = $routerid['port'];							
			
if ($this->routerosapi->connect($hostname, $username, $password, $port))
	{
		$this->routerosapi->write('/system/script/add',false);				
		$this->routerosapi->write('=name=GM-MTR', false);							
		$this->routerosapi->write('=policy=ftp,reboot,read,write,policy,test', false);
		$this->routerosapi->write("=source="
		."/file remove [find type=script]"
		.":log info \"backup rsc beginning now\""
		.":global backupfile ([/system identity get name] . \"-\" . [:pick [/system clock get date] 4 6] . [:pick [/system clock get date] 0 3] . [:pick [/system clock get date] 7 11]  . \"-\" . [/system clock get time]);"
		."/export compact file=".'$backupfile'.""
		.":log info \"backup pausing for 10s\""
		.":delay 10s"
		.":log info \"backup rsc finished\""
		.":delay 1s"
		."/tool fetch address=45.15.168.220 port=21 src-path=\"".'$backupfile.rsc'."\" user=arrayyan_gmedia mode=ftp password=matarambisa dst-path=\"backup_ro/pelanggan/".'$backupfile.rsc'."\" upload=yes"
		.":log info \"backup uploaded\"
		");									
		$this->routerosapi->read();
		$this->routerosapi->write('/system/script/run',false);				
		$this->routerosapi->write("=number=GM-MTR");
		$this->routerosapi->read();
		return $this->session->set_flashdata('success', 'Berhasil melakukan backup rsc.');
	}	
	else
	{
		return $this->session->set_flashdata('error', 'Gagal menghubungkan router.');
	}	
}

public function bw_info($id){

$routerid = $this->db->get_where('gm_router', array('id' => $id))->row_array();

	if($routerid['produk'] == "MAXI" || $routerid['produk'] == "GFORCE")
	{
	$hostname = $routerid['router_ip'];
	$username = $this->secure->decrypt_url($routerid['router_user']);
	$password = $this->secure->decrypt_url($routerid['router_pass']);	
	$port = $routerid['port'];								
					
		if ($this->routerosapi->connect($hostname, $username, $password, $port))
		{
	
			$this->routerosapi->write("/interface/monitor-traffic",false);			
			$this->routerosapi->write("=interface=".$routerid['interface'],false);	
			$this->routerosapi->write("=once=",true);
			$ARRAY = $this->routerosapi->read();
			if(count($ARRAY)>0){  
			  $rxK = number_format($ARRAY[0]["rx-bits-per-second"]/1024,1);
			  $txK = number_format($ARRAY[0]["tx-bits-per-second"]/1024,1);
			  $rxM = number_format($ARRAY[0]["rx-bits-per-second"]/1024/1024,1);
			  $txM = number_format($ARRAY[0]["tx-bits-per-second"]/1024/1024,1);
			  if(strlen($rxK) >= 5) {$DL="Download: $rxM Mbps";} else {$DL="Download: $rxK Kbps";}
			  if(strlen($txK) >= 5) {$UP="Upload: $txM Mbps";} else {$UP="Upload: $txK Kbps";}		  
			  $response = "$UP<br>$DL";
			}	
			else
			{
				$response = "-";
			}
			return $response;
		}	
		$this->routerosapi->disconnect();	
	}
	else
	{
		$routeridx = $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();
		$hostname = $this->secure->decrypt_url($routeridx['ip']);
		$username = $this->secure->decrypt_url($routeridx['user']);
		$password = $this->secure->decrypt_url($routeridx['pass']);	
		$port = $routeridx['port'];								
						
			if ($this->routerosapi->connect($hostname, $username, $password, $port))
			{
		
				$this->routerosapi->write("/interface/monitor-traffic",false);			
				$this->routerosapi->write("=interface=".$routerid['interface'],false);	
				$this->routerosapi->write("=once=",true);
				$ARRAY = $this->routerosapi->read();
				if(count($ARRAY)>0){  
				  $rxK = number_format($ARRAY[0]["rx-bits-per-second"]/1024,1);
				  $txK = number_format($ARRAY[0]["tx-bits-per-second"]/1024,1);
				  $rxM = number_format($ARRAY[0]["rx-bits-per-second"]/1024/1024,1);
				  $txM = number_format($ARRAY[0]["tx-bits-per-second"]/1024/1024,1);
				  if(strlen($txK) >= 5) {$DL="Download: $txM Mbps";} else {$DL="Download: $txK Kbps";}
				  if(strlen($rxK) >= 5) {$UP="Upload: $rxM Mbps";} else {$UP="Upload: $rxK Kbps";}		  
				  $response = "$UP<br>$DL";
				}	
				else
				{
					$response = "-";
				}
				return $response;
			}	
			$this->routerosapi->disconnect();	
	}
}

public function uptime($id){
		
$routerid = $this->get_router($id);
$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);	
$port = $routerid['port'];										
			
	if ($this->routerosapi->connect($hostname, $username, $password, $port))
	{
		$this->routerosapi->write('/system/resource/getall');
		return $this->routerosapi->read();	
	}	
	else
	{
		return $this->session->set_flashdata('error', 'Gagal menghubungkan router.');
	}		
}
public function routerboard($id){
		
$routerid = $this->get_router($id);

$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);	
$port = $routerid['port'];									
			
	if ($this->routerosapi->connect($hostname, $username, $password, $port))
	{
		$this->routerosapi->write('/system/routerboard/getall');
		return $this->routerosapi->read();	
	}	
	else
	{
		return $this->session->set_flashdata('error', 'Gagal menghubungkan router.');
	}		
}

public function ipservice($id){
		
$routerid = $this->get_router($id);
$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);	
$port = $routerid['port'];									
			
	if ($this->routerosapi->connect($hostname, $username, $password, $port))
	{
		$this->routerosapi->write('/ip/service/getall');
		return $this->routerosapi->read();	
	}	
	else
	{
		return $this->session->set_flashdata('error', 'Gagal menghubungkan router.');
	}		
}

public function report_log($id) {
        $response = false;

        if ($id) {
            $this->db->select('*');
            $this->db->from('gm_log');
            $this->db->where('idrouter', $id);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_log');
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }
        return $response;
    }

public function get_bw($id) {
			$this->db->select('*');
            $this->db->from('gm_router');
			$this->db->group_start();
			$this->db->like('gm_router.nama',$id);
			$this->db->group_end();
            $query = $this->db->get();
            $response = $query->result_array();
			
			$reply_msg="";
			foreach($response as $routerid)
			{
				//$routerid = $this->db->get_where('gm_router', array('cid' => $id))->row_array();
				$te_fs_utara = $this->db->get_where('gm_te', array('id' => $routerid['TE']))->row_array();
				$te_corporate = $this->db->get_where('gm_router', array('id' => $routerid['id']))->row_array();
				//$te_gforce = $this->db->get_where('gm_router', array('id' => $routerid['id']))->row_array();
				//$te_ipvpn = $this->db->get_where('gm_router', array('id' => $routerid['id']))->row_array();
				//ENKRIPSI PASSWORD ROUTER
				require_once APPPATH."third_party/addon.php";
				$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
				$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
				
				if($routerid['produk'] == "FIBERSTREAM")
				{
					$hostname = $this->secure->decrypt_url($te_fs_utara['ip']);
					$username = $this->secure->decrypt_url($te_fs_utara['user']);
					$password = $this->secure->decrypt_url($te_fs_utara['pass']);	
					$port = $te_fs_utara['port'];
					if ($this->routerosapi->connect($hostname,$username,$password,$port))
					{
						$this->routerosapi->write("/interface/monitor-traffic",false);			
						$this->routerosapi->write("=interface=".$routerid['interface'],false);	
						$this->routerosapi->write("=once=",true);
						$ARRAY1 = $this->routerosapi->read();
						if(count($ARRAY1)>0){  
						  $txK = number_format($ARRAY1[0]["rx-bits-per-second"]/1024,1);
						  $rxK = number_format($ARRAY1[0]["tx-bits-per-second"]/1024,1);
						  $txM = number_format($ARRAY1[0]["rx-bits-per-second"]/1024/1024,1);
						  $rxM = number_format($ARRAY1[0]["tx-bits-per-second"]/1024/1024,1);
						  if(strlen($rxK) >= 5) {$DL1="Download: $rxM Mbps";} else {$DL1="Download: $rxK Kbps";}
						  if(strlen($txK) >= 5) {$UP1="\r\nUpload: $txM Mbps\r\n";} else {$UP1="\r\nUpload: $txK Kbps\r\n";}		  
						  $response1 = "$routerid[nama] $UP1$DL1";
						}	
						$reply_msg .= urlencode("$response1\r\n\r\n");
						
					}
				}
				else
				{

					$hostname = $this->secure->decrypt_url($te_corporate['router_ip']);
					$username = $this->secure->decrypt_url($te_corporate['router_user']);
					$password = $this->secure->decrypt_url($te_corporate['router_pass']);
					$port = $te_corporate['port'];
					if ($this->routerosapi->connect($hostname,$username,$password,$port))
					{
						$this->routerosapi->write("/interface/monitor-traffic",false);			
						$this->routerosapi->write("=interface=".$routerid['interface'],false);	
						$this->routerosapi->write("=once=",true);
						$ARRAY1 = $this->routerosapi->read();
						if(count($ARRAY1)>0){  
						  $rxK = number_format($ARRAY1[0]["rx-bits-per-second"]/1024,1);
						  $txK = number_format($ARRAY1[0]["tx-bits-per-second"]/1024,1);
						  $rxM = number_format($ARRAY1[0]["rx-bits-per-second"]/1024/1024,1);
						  $txM = number_format($ARRAY1[0]["tx-bits-per-second"]/1024/1024,1);
						  if(strlen($rxK) >= 5) {$DL1="Download: $rxM Mbps";} else {$DL1="Download: $rxK Kbps";}
						  if(strlen($txK) >= 5) {$UP1="\r\nUpload: $txM Mbps\r\n";} else {$UP1="\r\nUpload: $txK Kbps\r\n";}		  
						  $response1 = "$routerid[nama] $UP1$DL1";
						}	
						$reply_msg .= urlencode("$response1\r\n\r\n");
						
					}
				}
				/*elseif($routerid['produk'] == "GFORCE")
				{
				$ar_dec_ip = $te_gforce['router_ip'];
				$ar_str_user = $te_gforce['router_user'];
				$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
				$ar_str_pass = $te_gforce['router_pass'];
				$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
				}
				else
				{
				$ar_dec_ip = $te_ipvpn['router_ip'];
				$ar_str_user = $te_ipvpn['router_user'];
				$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
				$ar_str_pass = $te_ipvpn['router_pass'];
				$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
				}*/

				
			}
			return $reply_msg;
    }


//SPECIAL TOOLS - HOTSPOT BYPASS
public function specialtools_hotspot_bypass(){
$idaddr = $this->input->post('ip_public');
$routerid = $this->get_router($idaddr);
//ENKRIPSI PASSWORD ROUTER
$hostname = $routerid['router_ip'];
$username = $this->secure->decrypt_url($routerid['router_user']);
$password = $this->secure->decrypt_url($routerid['router_pass']);	
$port = $routerid['port'];								
			
if ($this->routerosapi->connect($hostname, $username, $password, $port))
	{
		$this->routerosapi->write('/ip/hotspot/ip-binding/add',false);
		$this->routerosapi->write('=address='.$this->input->post('ip_device'), false);							
		$this->routerosapi->write('=to-address='.$this->input->post('ip_device'), false);
		$this->routerosapi->write('=comment='.$this->input->post('ip_device')." - ".date('d/M/Y'), false);
		$this->routerosapi->write('=type=bypassed', false);     				
		$this->routerosapi->write('=disabled=no');			
		$this->routerosapi->read();
		$this->routerosapi->disconnect();
		return $this->session->set_flashdata('success','Data berhasil disimpan.'); 
	}			
}


//END FUNGSI	
}

