<?php

class Mikrotik_model extends CI_Model{
	
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

public function hs_info($id){
		
$routerid = $this->get_router($id);
$hostname = $routerid['ip'];
$username = $routerid['user'];
$password = $routerid['pass'];								
			
if ($this->routerosapi->connect($hostname, $username, $password))
	{
		$this->routerosapi->write('/ip/hotspot/getall');
		$API_hs = $this->routerosapi->read();
		foreach ($API_hs as $hs)
		{
			$hs_id 			= $hs['.id'];
			$hs_disabled 	= $hs['disabled'];	
		}
		if($hs_id == NULL)
		{
		$response = "Tidak Aktif";
		}
		else
		{
			if($hs_disabled == "false"){$response = "Aktif";} else {$response = "Tidak Aktif";}
		}
	}	
return $response;			
}

public function hs_aktif($id){
		
$routerid = $this->get_router($id);
$hostname = $routerid['ip'];
$username = $routerid['user'];
$password = $routerid['pass'];								
			
if ($this->routerosapi->connect($hostname, $username, $password))
	{
		$this->routerosapi->write('/ip/hotspot/active/getall');
		return $this->routerosapi->read();
	}			
}

public function hs_remove($id,$id_session){
		
$routerid = $this->get_router($id);
$hostname = $routerid['ip'];
$username = $routerid['user'];
$password = $routerid['pass'];								
			
	if ($this->routerosapi->connect($hostname, $username, $password))
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
$hostname = $routerid['ip'];
$username = $routerid['user'];
$password = $routerid['pass'];								
			
	if ($this->routerosapi->connect($hostname, $username, $password))
	{
		$this->routerosapi->write('/system/reboot');
		$this->routerosapi->read();
		$data = array(
            'up_down' => "0",
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
$hostname = $routerid['ip'];
$username = $routerid['user'];
$password = $routerid['pass'];								
			
if ($this->routerosapi->connect($hostname, $username, $password))
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
		
$routerid = $this->get_router($id);
$hostname = $routerid['ip'];
$username = $routerid['user'];
$password = $routerid['pass'];								
			
if ($this->routerosapi->connect($hostname, $username, $password))
	{
		$this->routerosapi->write('/ip/address/print', false);
		$this->routerosapi->write("=.proplist=interface",false);
		$this->routerosapi->write("=?address=$hostname");
		return $this->routerosapi->read();
		//foreach ($API_interface as $interface)
		//{
		//	$bw_id 			= $interface['.id'];
		//	$bw_int		 	= $interface['interface'];	
		//}
		//$this->routerosapi->write('/interface/monitor-traffic', false);
		//$this->routerosapi->write("=interface=$bw_int");
		//return $this->routerosapi->read();
	}	
		
}

//END FUNGSI	
}

