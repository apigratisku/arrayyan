<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CekConnect extends CI_Controller {

   public function index() {
		$this->db->select('*');
        $this->db->from('gm_router');
		$this->db->where('produk',"MAXI");
		$this->db->order_by("id", "asc");
		$this->db->limit(50,51);
		$query = $this->db->get();
        $routerid = $query->result_array();
		//$routerid = $this->db->get('gm_bts')->order_by("id", "asc")->limit(1)->result_array();
		foreach($routerid as $device)
			{
			$this->load->database();
			$this->db->reconnect();
			//DECRYPT AKSES
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
			
			
			//ENCRYPT AKSES
				require_once APPPATH."third_party/addon.php";
				$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
				$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
				$ar_str_user = "noc-mtr";
				$ar_en_user = $ar_chip->encrypt($ar_str_user, $ar_rand);
				$ar_str_pass = "RFd3d76890";
				$ar_en_pass = $ar_chip->encrypt($ar_str_pass, $ar_rand);
				$username_db = $ar_en_user;
				$password_db = $ar_en_pass;
				

					//PROSES LOGIN			
					if ($this->routerosapi->connect($hostname, $username, $password))
					{
					/*//TAMBAH USER BARU
					$this->routerosapi->connect($hostname, $username, $password);
					$this->routerosapi->write("/user/add",false);										
					$this->routerosapi->write("=group=full", false);     
					$this->routerosapi->write("=name=noc-mtr", false);  				
					$this->routerosapi->write("=password=RFd3d76890", false); 
					$this->routerosapi->write("=address=112.78.38.135,103.255.242.22,103.255.242.18,192.168.10.0/24", false); 						
					$this->routerosapi->write("=disabled=no");				
					$step1 = $this->routerosapi->read();*/
					
					
					
					//CEK USER LAMA	
					$this->routerosapi->write("/user/print",false);	
					$this->routerosapi->write("=.proplist=.id",false);															
					$this->routerosapi->write("=.proplist=name",false);		
					$this->routerosapi->write("?name=noc-mtr");		
					$step2 = $this->routerosapi->read();
					
					$this->routerosapi->write("/user/print",false);	
					$this->routerosapi->write("=.proplist=.id",false);															
					$this->routerosapi->write("=.proplist=name",false);		
					$this->routerosapi->write("?name=noc");		
					$step4 = $this->routerosapi->read();
					
					//HAPUS USER LAMA
					foreach($step4 as $dataiduser){ $iduser = $dataiduser['.id'];}
					if(isset($iduser))
					{
					$this->routerosapi->write("/user/remove",false);															
					$this->routerosapi->write("=.id=".$iduser);				
					$step3 = $this->routerosapi->read();
					}
					
					foreach($step2 as $datastep2){ if($datastep2['name'] != NULL) {$message_user_new = "User noc-mtr [OK]";}else {$message_user_new = "User noc-mtr [TIDAK ADA]";}}
					
					foreach($step4 as $datastep4){ if(isset($datastep4['name'])) {$message_user_new2 = "User noc [OK]";} else {$message_user_new2 = "User noc [TIDAK ADA]";}}
					
					
					$this->routerosapi->disconnect();
					
					
					//FINAL PROSES
					$data = array(
							'router_user' => $username_db,
							'router_pass' => $password_db,
						);			
						$this->db->where('id', $device['id']);
						$this->db->update('gm_router', $data);

						print("Perubahan IP $device[router_ip]-$device[nama] - <span style=\"color:blue\">$message_user_new</span> - <span style=\"color:green\">[ALL OK]</span><br>");

					}
					else
					{
						print("Perubahan IP $device[router_ip]-$device[nama] - [NOK]<br>");
					}
					
			}
			return $this->session->set_flashdata('message','Data berhasil ditambahkan!');
	}
}