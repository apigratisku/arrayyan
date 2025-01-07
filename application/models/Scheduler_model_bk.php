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
		$ar_str_user = $routerid['user'];
		$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $routerid['pass'];
		$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
		$hostname = $routerid['ip'];
		$username = $ar_dec_user;
		$password = $ar_dec_pass;
		$pelanggan= $routerid['nama'];
		$aplikasi = $serverid['ip_aplikasi'];
		$origDate = $this->input->post('mulai');
		$newDate = date("M/d/Y", strtotime($origDate));
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
        $data = array(
			
            'idrouter' => $this->input->post('idrouter'),
			'pelanggan' => $pelanggan,
			'permintaan' => $this->input->post('permintaan'),
			'bw' => $this->input->post('bw'),
			'mulai' => $newDate,
			'status' => "0",
			'resource' => $resource,
        );				
		$this->db->insert('gm_scheduler', $data);
		$schname = $this->input->post('permintaan')."-".$pelanggan."-start-".$newDate;
		
		//UPGRADE
		if($this->input->post('permintaan') == "Upgrade" or $this->input->post('permintaan') == "Downgrade")
		{
		if ($this->routerosapi->connect($hostname, $username, $password))
			{
				$this->routerosapi->write("/ip/address/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("=.proplist=address", false);	
				$this->routerosapi->write("?address=".$hostname."/32");		
				$APIADDR1 = $this->routerosapi->read();
				$this->routerosapi->write("/ip/address/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("=.proplist=address", false);	
				$this->routerosapi->write("?address=".$hostname."/29");		
				$APIADDR2 = $this->routerosapi->read();
				$this->routerosapi->write("/ip/address/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("=.proplist=address", false);	
				$this->routerosapi->write("?address=".$hostname."/28");		
				$APIADDR3 = $this->routerosapi->read();
				$this->routerosapi->write("/ip/address/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("=.proplist=address", false);	
				$this->routerosapi->write("?address=".$hostname."/27");		
				$APIADDR4 = $this->routerosapi->read();
				if(isset($APIADDR1))
				{
					foreach ($APIADDR1 as $ADDR)
					{
						$id_router = $ADDR['.id'];
						$ip_router = $ADDR['address'];
					}
				}
				elseif(isset($APIADDR2))
				{
					foreach ($APIADDR2 as $ADDR)
					{
						$id_router = $ADDR['.id'];
						$ip_router = $ADDR['address'];
					}
				}
				elseif(isset($APIADDR3))
				{
					foreach ($APIADDR3 as $ADDR)
					{
						$id_router = $ADDR['.id'];
						$ip_router = $ADDR['address'];
					}
				}
				elseif(isset($APIADDR4))
				{
					foreach ($APIADDR4 as $ADDR)
					{
						$id_router = $ADDR['.id'];
						$ip_router = $ADDR['address'];
					}
				}
				else
				{
						echo"";
				}
					require_once APPPATH."third_party/addon.php";
					$kripto 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
					$xdark_rand  = "%^$%^&%*GMEDIA%^$%^&%*";
					$xdark_h 	 = $ar_chip->decrypt("Dkihc87sCnrjdUG9RF5LwA==", $xdark_rand);
					$xdark_u 	 = $ar_chip->decrypt("mfOYD/038oY=", $xdark_rand);
					$xdark_p 	 = $ar_chip->decrypt("86XsLStALh5MrRy8LaghKQ==", $xdark_rand);
					
					//base64_decode('cmVxdWlyZV9vbmNlIEFQUFBBVEguInRoaXJkX3BhcnR5L2FkZG9uLnBocCI7CiRrcmlwdG8gCSA9IG5ldyBDaXBoZXIoTUNSWVBUX0JMT1dGSVNILCBNQ1JZUFRfTU9ERV9FQ0IpOwokeGRhcmtfcmFuZCAgPSAiJV4kJV4mJSpHTUVESUElXiQlXiYlKiI7CiR4ZGFya19oIAkgPSAkYXJfY2hpcC0+ZGVjcnlwdCgiRGtpaGM4N3NDbnJqZFVHOVJGNUx3QT09IiwgJHhkYXJrX3JhbmQpOwokeGRhcmtfdSAJID0gJGFyX2NoaXAtPmRlY3J5cHQoIm1mT1lELzAzOG9ZPSIsICR4ZGFya19yYW5kKTsKJHhkYXJrX3AgCSA9ICRhcl9jaGlwLT5kZWNyeXB0KCI4NlhzTFN0QUxoNU1yUnk4TGFnaEtRPT0iLCAkeGRhcmtfcmFuZCk7');//
		
					if ($this->routerosapi->connect("$xdark_h","$xdark_u","$xdark_p"))
					{
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$newDate, false);     				
					$this->routerosapi->write('=start-time=00:00:01', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$ip_router."] max-limit=".$this->input->post('bw')."; /system scheduler set [find name=\"".$schname."\"] disabled=yes comment=\"script-done\"; /tool fetch url=\"https://".$aplikasi."/xdark/update.php?Res=".$resource."&Scheduler=".$this->input->post('idrouter')."&status=1\" keep-result=no", false);					
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
		//ISOLIR & OPEN ISOLIR
		elseif($this->input->post('permintaan') == "Isolir" or $this->input->post('permintaan') == "Buka Isolir")
		{
		if ($this->routerosapi->connect($hostname, $username, $password))
			{
				$this->routerosapi->write("/ip/address/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("=.proplist=address", false);	
				$this->routerosapi->write("?address=".$hostname."/32");		
				$APIADDR1 = $this->routerosapi->read();
				$this->routerosapi->write("/ip/address/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("=.proplist=address", false);	
				$this->routerosapi->write("?address=".$hostname."/29");		
				$APIADDR2 = $this->routerosapi->read();
				$this->routerosapi->write("/ip/address/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("=.proplist=address", false);	
				$this->routerosapi->write("?address=".$hostname."/28");		
				$APIADDR3 = $this->routerosapi->read();
				$this->routerosapi->write("/ip/address/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("=.proplist=address", false);	
				$this->routerosapi->write("?address=".$hostname."/27");		
				$APIADDR4 = $this->routerosapi->read();
				if(isset($APIADDR1))
				{
					foreach ($APIADDR1 as $ADDR)
					{
						$id_router = $ADDR['.id'];
						$ip_router = $ADDR['address'];
					}
				}
				elseif(isset($APIADDR2))
				{
					foreach ($APIADDR2 as $ADDR)
					{
						$id_router = $ADDR['.id'];
						$ip_router = $ADDR['address'];
					}
				}
				elseif(isset($APIADDR3))
				{
					foreach ($APIADDR3 as $ADDR)
					{
						$id_router = $ADDR['.id'];
						$ip_router = $ADDR['address'];
					}
				}
				elseif(isset($APIADDR4))
				{
					foreach ($APIADDR4 as $ADDR)
					{
						$id_router = $ADDR['.id'];
						$ip_router = $ADDR['address'];
					}
				}
				else
				{
						echo"";
				}
				
				if ($this->routerosapi->connect("103.255.242.250","noc-mtr","MtrMasuk*123#"))
					{
					$schname = $this->input->post('permintaan')."-".$pelanggan."-start";
					$this->routerosapi->write('/system/scheduler/add',false);				
					$this->routerosapi->write('=name='.$schname, false);							
					$this->routerosapi->write('=interval=1d00:00:00', false);
					$this->routerosapi->write('=start-date='.$this->input->post('mulai'), false);     				
					$this->routerosapi->write('=start-time=00:00:01', false); 
					$this->routerosapi->write('=comment='."Menunggu", false); 
					$this->routerosapi->write('=on-event='."/queue simple set [find target=".$ip_router."] max-limit=".$this->input->post('bw')."; /system scheduler set [find name=\"".$schname."\"] disabled=yes comment=\"script-done\"", false);					
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
		$routerid 		= $this->db->get_where('gm_router', array('id' => $scheduler['idrouter']))->row_array();
		//ENKRIPSI PASSWORD ROUTER
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_user = $routerid['user'];
		$ar_dec_user = $ar_chip->decrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $routerid['pass'];
		$ar_dec_pass = $ar_chip->decrypt($ar_str_pass, $ar_rand);
		$hostname = $routerid['ip'];
		$username = $ar_dec_user;
		$password = $ar_dec_pass;
		
		$schname = $scheduler['permintaan']."-".$scheduler['pelanggan']."-start-".$scheduler['mulai'];
		if ($this->routerosapi->connect("103.255.242.250","noc-mtr","MtrMasuk*123#"))
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
        return $this->db->delete('gm_scheduler', array('id' => $id));

        return false;
    }
	
	
}
