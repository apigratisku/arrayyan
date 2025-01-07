<?php

class Lokalan_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_lokalan', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_lokalan');
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	public function count() {
        if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get('gm_lokalan')->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_lokalan', array('idrouter' => $this->session->userdata('idrouter')))->num_rows();
		}
    }
	
	public function lokalan_up() {
		if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get_where('gm_lokalan', array('status' => "1"))->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_lokalan', array('idrouter' => $this->session->userdata('idrouter'),'status' => "1"))->num_rows();
		}
    }
	
	public function lokalan_down() {
		if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get_where('gm_lokalan', array('status' => "0"))->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_lokalan', array('idrouter' => $this->session->userdata('idrouter'),'status' => "0"))->num_rows();
		}
    }
	
	public function getALL($id) {
            $this->db->select('gm_lokalan.*, gm_router.id');
            $this->db->from('gm_lokalan');
            $this->db->join('gm_router', 'gm_lokalan.idrouter = gm_router.id');
            $this->db->where('gm_lokalan.idrouter', $id);
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
        $data = array(
			
            'idrouter' => $this->input->post('idrouter'),
			'pelanggan' => $pelanggan,
			'area' => $this->input->post('area'),
			'ip' => $this->input->post('ip'),
			'status' => "0",
        );				
		$this->db->insert('gm_lokalan', $data);
					
		if ($this->routerosapi->connect($hostname, $username, $password))
			{
				$this->routerosapi->write('/tool/netwatch/add',false);				
				$this->routerosapi->write('=host='.$this->input->post('ip'), false);							
				$this->routerosapi->write('=interval=00:00:10', false);
				$this->routerosapi->write('=timeout=10', false);     				
				$this->routerosapi->write('=comment='.$this->input->post('area'), false);
				$this->routerosapi->write('=up-script='."/tool fetch url=\"https://".$aplikasi."/xdark/update.php?IDrouter=".$this->input->post('idrouter')."&IPlokalan=".$this->input->post('ip')."&status=1\" keep-result=no", false);			
				$this->routerosapi->write('=down-script='."/tool fetch url=\"https://".$aplikasi."/xdark/update.php?IDrouter=".$this->input->post('idrouter')."&IPlokalan=".$this->input->post('ip')."&status=0\" keep-result=no", false);		
				$this->routerosapi->write('=disabled=no');				
				$this->routerosapi->read();
				$this->routerosapi->disconnect();	
				$this->session->set_flashdata('message','Data berhasil ditambahkan!');
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal. Pastikan hostname, username dan password yang Anda masukkan benar!');
			}	
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
    }

    public function timpa($id) {
        $routerid = $this->db->get_where('gm_router', array('id' => $this->input->post('idrouter')))->row_array();
		$serverid = $this->db->get('gm_server')->row_array();
		$query3 = $this->get($id);
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
        $data = array(
			
            'idrouter' => $this->input->post('idrouter'),
			'pelanggan' => $pelanggan,
			'area' => $this->input->post('area'),
			'ip' => $this->input->post('ip'),
			'status' => "0",
        );				
		$this->db->where('id', $id);
		$this->db->update('gm_lokalan', $data);
		
		if ($this->routerosapi->connect($hostname, $username, $password))
			{
				$this->routerosapi->write("/tool/netwatch/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?comment=".$query3['area']);				
				$APInetwatch = $this->routerosapi->read();
				foreach ($APInetwatch as $netwatch)
				{
					$id_router = $netwatch['.id'];
				}
				$this->routerosapi->write('/tool/netwatch/set',false);
				$this->routerosapi->write('=host='.$this->input->post('ip'),false);
				$this->routerosapi->write('=comment='.$this->input->post('area'),false);
				$this->routerosapi->write('=up-script='."/tool fetch url=\"https://".$aplikasi."/xdark/update.php?IDrouter=".$this->input->post('idrouter')."&IPlokalan=".$this->input->post('ip')."&status=1\" keep-result=no", false);			
				$this->routerosapi->write('=down-script='."/tool fetch url=\"https://".$aplikasi."/xdark/update.php?IDrouter=".$this->input->post('idrouter')."&IPlokalan=".$this->input->post('ip')."&status=0\" keep-result=no", false);
				$this->routerosapi->write('=.id='.$id_router);
				$this->routerosapi->read();
				$this->routerosapi->disconnect();	
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal !');
			}
		
        return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
    }

    public function delete($id) {
		$lokalan   = $this->db->get_where('gm_lokalan', array('id' => $id))->row_array();	
		$routerid = $this->db->get_where('gm_router', array('id' => $query1['idrouter']))->row_array();
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
			
		if ($this->routerosapi->connect($hostname, $username, $password))
			{
				$this->routerosapi->write("/tool/netwatch/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?comment=".$lokalan['area']);				
				$APInetwatch = $this->routerosapi->read();
				foreach ($APInetwatch as $netwatch)
				{
					$id_router = $netwatch['.id'];
				}
				$this->routerosapi->write('/tool/netwatch/remove',false);
				$this->routerosapi->write('=.id='.$id_router);
				$this->routerosapi->read();
				$this->routerosapi->disconnect();	
			}
			else
			{
				$this->session->set_flashdata('message', 'Login gagal !');
			}
        return $this->db->delete('gm_lokalan', array('id' => $id));

        return false;
    }
	
	
}
