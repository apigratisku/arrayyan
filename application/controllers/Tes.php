<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tes extends CI_Controller {

   public function index() {
		$this->db->select('*');
        $this->db->from('gm_bts');
		$this->db->order_by("id", "asc");
		$this->db->limit(50,51);
		//$this->db->limit(1);
		$query = $this->db->get();
        $routerid = $query->result_array();
		//$routerid = $this->db->get('gm_bts')->order_by("id", "asc")->limit(1)->result_array();
		foreach($routerid as $radio)
			{
			//DECRYPT AKSES
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
				//PROSES LOGIN			
				if ($this->routerosapi->connect($hostname, "gmntb","mtr*123#2021"))
				{	
				//CEK USER LAMA	
				$this->routerosapi->write("/user/print",false);	
				$this->routerosapi->write("=.proplist=.id",false);															
				$this->routerosapi->write("=.proplist=name",false);		
				$this->routerosapi->write("?name=noc-mtr");		
				$step2 = $this->routerosapi->read();
				/*//HAPUS USER LAMA
				foreach($step2 as $dataiduser){ $iduser = $dataiduser['.id'];}
				$this->routerosapi->write("/user/remove",false);															
				$this->routerosapi->write("=.id=noc-mtr");				
				$step3 = $this->routerosapi->read();*/
				//TAMBAH USER BARU
				$this->routerosapi->write("/user/add",false);										
				$this->routerosapi->write("=group=full", false);     
				$this->routerosapi->write("=name=noc-mtr", false);  				
				$this->routerosapi->write("=password=mtr2021", false); 						
				$this->routerosapi->write("=disabled=no");				
				$step1 = $this->routerosapi->read();

				
				//ENCRYPT AKSES
				require_once APPPATH."third_party/addon.php";
				$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
				$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
				$ar_str_user = "noc-mtr";
				$ar_en_user = $ar_chip->encrypt($ar_str_user, $ar_rand);
				$ar_str_pass = "mtr2021";
				$ar_en_pass = $ar_chip->encrypt($ar_str_pass, $ar_rand);
				$username_db = $ar_en_user;
				$password_db = $ar_en_pass;
				
				//FINAL PROSES
				$data = array(
						'user' => $username_db,
						'password' => $password_db,
					);			
					$this->db->where('id', $radio['id']);
					$this->db->update('gm_bts', $data);
				print("Perubahan IP $radio[ip] OK <br>");
			
				}
				else
				{
					print("Perubahan IP $radio[ip] GAGAL <br>");
				}	
			}
			return $this->session->set_flashdata('message','Data berhasil ditambahkan!');
	}
}