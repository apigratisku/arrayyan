<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CekConnect extends CI_Controller {

   public function index() {
		$this->db->select('*');
        $this->db->from('gm_router');
		$this->db->where('produk',"MAXI");
		$this->db->order_by("id", "asc");
		$this->db->limit(20,20);
		$query = $this->db->get();
        $routerid = $query->result_array();
		//$routerid = $this->db->get('gm_bts')->order_by("id", "asc")->limit(1)->result_array();
		foreach($routerid as $radio)
			{
			//DECRYPT AKSES
			require_once APPPATH."third_party/addon.php";
			$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
			$ar_str_user = $radio['router_user'];
			$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
			$ar_str_pass = $radio['router_pass'];
			$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
			$hostname = $radio['router_ip'];
			$username = $ar_dec_user;
			$password = $ar_dec_pass;
				//PROSES LOGIN			
				if ($this->routerosapi->connect($hostname, $username, $password))
				{	
				
					print("Login ke IP $radio[router_ip] -  $radio[nama] ==> OK <br>");
			
				}
				else
				{
					print("Login ke IP $radio[router_ip] -  $radio[nama] ==> GAGAL <br>");
				}	
			}
			return $this->session->set_flashdata('message','Data berhasil ditambahkan!');
	}
}