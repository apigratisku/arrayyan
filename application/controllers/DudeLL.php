<?php
defined('BASEPATH') or exit('No direct script access allowed');
class DudeLL extends CI_Controller {

   public function index() {
   		$this->load->database();
		$this->db->select('*');
        $this->db->from('gm_router');
		$this->db->where('media','WE');
		$this->db->order_by("id", "asc");
		$this->db->limit(20,81);
		//$this->db->limit(1);
		$query = $this->db->get();
        $routerid = $query->result_array();
		$aplikasi = $this->db->get_where('gm_server', array('ip' => "103.255.242.22"))->row_array();
		
		//$routerid = $this->db->get('gm_bts')->order_by("id", "asc")->limit(1)->result_array();
		foreach($routerid as $radio)
			{
			$LL = $this->db->get_where('gm_bts', array('id' => $radio['bts']))->row_array();
			//DECRYPT AKSES
			require_once APPPATH."third_party/addon.php";
			$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
			$ar_str_user = $LL['user'];
			$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
			$ar_str_pass = $LL['password'];
			$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
			$hostname = $LL['ip'];
			$username = $ar_dec_user;
			$password = $ar_dec_pass;
			
				//PROSES LOGIN			
				if ($this->routerosapi->connect($hostname,$username,$password))
				{	

				//LASTMILE
				$this->routerosapi->write('/tool/netwatch/print',false);				
				$this->routerosapi->write("=.proplist=host", false);	
				$this->routerosapi->write("=.proplist=comment", false);
				$this->routerosapi->write("=.proplist=.id", false);						
				$this->routerosapi->write("?comment=".$radio['nama']);			
				$API_LL = $this->routerosapi->read();
				foreach ($API_LL as $LL)
				{
					$ID_LL = $LL['.id'];
				}
				if($ID_LL)
				{
				$this->routerosapi->write('/tool/netwatch/remove',false);
				$this->routerosapi->write('=.id='.$ID_LL);
				$this->routerosapi->read();
				}
				
				$this->routerosapi->write('/tool/netwatch/add',false);				
				$this->routerosapi->write('=host='.$radio['lastmile'], false);							
				$this->routerosapi->write('=interval=00:00:10', false);
				$this->routerosapi->write('=timeout=10', false);     				
				$this->routerosapi->write('=comment='.$radio['nama'], false);
				$this->routerosapi->write('=up-script='."/tool fetch url=\"https://".$aplikasi['ip_aplikasi']."/xdark/update.php?IPlastmile=".$radio['lastmile']."&status=1\" keep-result=no", false);			
				$this->routerosapi->write('=down-script='."/tool fetch url=\"https://".$aplikasi['ip_aplikasi']."/xdark/update.php?IPlastmile=".$radio['lastmile']."&status=0\" keep-result=no", false);		
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				
				print("$radio[lastmile] OK <br>");
			
				}
				else
				{
					print("$radio[ip] GAGAL <br>");
				}	
			}
			return $this->session->set_flashdata('message','Data berhasil ditambahkan!');
	}
}