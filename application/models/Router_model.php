<?php

class Router_model extends CI_Model {

    public function __construct() {
        $this->load->database();
		$this->load->library('secure');
		
    }
	public function server($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_server', array('id' => $id));
            $response = $query->row_array();
        } else {
            $query = $this->db->get('gm_server');
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function serverdr($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_dr', array('id' => $id));
            $response = $query->row_array();
        } else {
            $query = $this->db->get('gm_dr');
            $response = $query->result_array();
        }

        return $response;
    }
	public function serverte($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_te', array('id' => $id));
            $response = $query->row_array();
        } else {
            $query = $this->db->get('gm_te');
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function serverROW() {
        $response = false;

            $query = $this->db->get('gm_server');
            $response = $query->row_array();

        return $response;
    }
	
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_pelanggan', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_pelanggan');
			$this->db->order_by("nama", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function get_pop($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_pop', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_pop');
			$this->db->order_by("pop", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function get_fs($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_router', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_router');
			$this->db->where("produk","FIBERSTREAM");
			$this->db->order_by("nama", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function bts() {
        $response = false;

            $this->db->select('*');
            $this->db->from('gm_bts');
			$this->db->order_by("sektor_bts", "asc");
            $query = $this->db->get();
            $response = $query->result_array();

        return $response;
    }
	
	public function btsid() {
        $response = false;

        $query = $this->db->get_where('gm_bts', array('id' => $this->input->post('bts')));
        $response = $query->row_array();
        return $response;
    }
	
	public function get_distribusi() {
        $response = false;

            $this->db->select('*');
            $this->db->from('gm_dr');
			$this->db->order_by("nama", "asc");
            $query = $this->db->get();
            $response = $query->result_array();

        return $response;
    }
	public function get_te() {
        $response = false;

            $this->db->select('*');
            $this->db->from('gm_te');
			$this->db->order_by("nama", "asc");
            $query = $this->db->get();
            $response = $query->result_array();

        return $response;
    }
	public function te() {
        $response = false;

            $this->db->select('*');
            $this->db->from('gm_te');
			$this->db->order_by("nama", "asc");
            $query = $this->db->get();
            $response = $query->result_array();

        return $response;
    }
	
	
	public function count() {
		if($this->session->userdata('ses_admin') == "1" || $this->session->userdata('ses_admin') == "2")
		{
        return $this->db->get('gm_router')->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_router', array('id' => $this->session->userdata('idrouter')))->num_rows();
		}
    }
	
	public function router_up() {
		if($this->session->userdata('ses_admin') == "1" || $this->session->userdata('ses_admin') == "2")
		{
        return $this->db->get_where('gm_router', array('status' => "1"))->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_router', array('id' => $this->session->userdata('idrouter'),'status' => "1"))->num_rows();
		}
    }
	
	public function router_down() {
		if($this->session->userdata('ses_admin') == "1" || $this->session->userdata('ses_admin') == "2")
		{
        return $this->db->get_where('gm_router', array('status' => "0"))->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_router', array('id' => $this->session->userdata('idrouter'),'status' => "0"))->num_rows();
		}
    }

	//SERVER
	public function simpan_server() {
        $data = array(
            'nama' => $this->input->post('nama'),
			'ip' => $this->input->post('ip'),
			'user' => $this->secure->encrypt_url($this->input->post('user')),
			'pass' => $this->secure->encrypt_url($this->input->post('pass')),
			'ip_aplikasi' => $this->input->post('ip_aplikasi'),
        );
		$this->db->insert('gm_server', $data);
		
        return $this->session->set_flashdata('success','Data berhasil ditambahkan! ');
    }

    public function timpa_server($id) {

        $data = array(
            'nama' => $this->input->post('nama'),
			'ip' => $this->input->post('ip'),
			'user' => $this->secure->encrypt_url($this->input->post('user')),
			'pass' => $this->secure->encrypt_url($this->input->post('pass')),
			'ip_aplikasi' => $this->input->post('ip_aplikasi'),
		);
		$this->db->where('id', $id);
		$this->db->update('gm_server', $data);
		
        return $this->session->set_flashdata('success','Data berhasil ditambahkan!'); 
        
    }

    public function delete_server($id) {
		$routerid = $this->server($id);
		$username = $this->secure->decrypt_url($routerid['user']);
		$password = $this->secure->decrypt_url($routerid['pass']);
		$hostname = $routerid['ip'];
		$port = $routerid['port'];
		if ($this->routerosapi->connect($hostname, $username, $password,$port))
			{
				$this->routerosapi->write("/tool/netwatch/print", false);			
				$this->routerosapi->write("=.proplist=.id", false);		
				$this->routerosapi->write("?comment=MTR-PROJECT");				
				$APInetwatch = $this->routerosapi->read();
				foreach ($APInetwatch as $netwatch)
				{
					$id_router = $netwatch['.id'];
				}
				if(isset($id_router))
				{
				$this->routerosapi->write('/tool/netwatch/remove',false);
				$this->routerosapi->write('=.id='.$id_router);
				$this->routerosapi->read();
				}
				$this->routerosapi->disconnect();	
			}
			else
			{
				$this->session->set_flashdata('error', 'Login gagal !');
			} 
        return $this->db->delete('gm_server', array('id' => $id));
    }
	
	//SERVER DISTRIBUSI
	public function simpan_distribusi() {
        if ($this->routerosapi->connect($this->input->post('ip'), $this->input->post('user'), $this->input->post('pass'), $this->input->post('port')))
			{
				$data = array(
				'nama' => $this->input->post('nama'),
				'ip' => $ar_enc_ip,
				'user' => $this->secure->encrypt_url($this->input->post('user')),
				'pass' => $this->secure->encrypt_url($this->input->post('pass')),
				'port' => $this->input->post('port'),
				);
				$this->db->insert('gm_dr', $data);
				$this->routerosapi->disconnect();	
				return $this->session->set_flashdata('success','Verifikasi API dan input data SUKSES !'); 
			}
			else
			{
				return $this->session->set_flashdata('error', 'Verifikasi API dan input data GAGAL !');
			}  
    }
	//EDIT DISTRIBUSI
	public function timpa_distribusi($id) {
		 if ($this->routerosapi->connect($this->input->post('ip'), $this->input->post('user'), $this->input->post('pass'), $this->input->post('port')))
			{
				$data = array(
				'nama' => $this->input->post('nama'),
				'ip' => $ar_enc_ip,
				'user' => $this->secure->encrypt_url($this->input->post('user')),
				'pass' => $this->secure->encrypt_url($this->input->post('pass')),
				'port' => $this->input->post('port'),
				);
				$this->db->where('id', $id);
				$this->db->update('gm_dr', $data);
				$this->routerosapi->disconnect();	
				return $this->session->set_flashdata('success','Verifikasi API dan edit data SUKSES !'); 
			}
			else
			{
				return $this->session->set_flashdata('error', 'Verifikasi API dan edit data GAGAL !');
			}  
    }
	
	//DELETE DISTRIBUSI
	public function delete_distribusi($id) {
        return $this->db->delete('gm_dr', array('id' => $id));
    }
	
	//SERVER TE
	public function simpan_te() {
         if ($this->routerosapi->connect($this->input->post('ip'), $this->input->post('user'), $this->input->post('pass'), $this->input->post('port')))
			{
				$data = array(
				'nama' => $this->input->post('nama'),
				'ip' => $ar_enc_ip,
				'user' => $this->secure->encrypt_url($this->input->post('user')),
				'pass' => $this->secure->encrypt_url($this->input->post('pass')),
				'port' => $this->input->post('port'),
				);
				$this->db->insert('gm_te', $data);
				$this->routerosapi->disconnect();	
				return $this->session->set_flashdata('success','Verifikasi API dan input data SUKSES !'); 
			}
			else
			{
				return $this->session->set_flashdata('error', 'Verifikasi API dan input data GAGAL !');
			}  
    }
	//EDIT TE
	public function timpa_te($id) {
         if ($this->routerosapi->connect($this->input->post('ip'), $this->input->post('user'), $this->input->post('pass'), $this->input->post('port')))
			{
				$data = array(
				'nama' => $this->input->post('nama'),
				'ip' => $ar_enc_ip,
				'user' => $this->secure->encrypt_url($this->input->post('user')),
				'pass' => $this->secure->encrypt_url($this->input->post('pass')),
				'port' => $this->input->post('port'),
				);
				$this->db->where('id', $id);
				$this->db->update('gm_te', $data);
				$this->routerosapi->disconnect();	
				return $this->session->set_flashdata('success','Verifikasi API dan edit data SUKSES !'); 
			}
			else
			{
				return $this->session->set_flashdata('error', 'Verifikasi API dan edit data GAGAL !');
			}  
    }
	
	//DELETE TE
	public function delete_te($id) {
        return $this->db->delete('gm_te', array('id' => $id));
    }
	
//ROUTER
    public function simpan() {
		//ENKRIPSI PASSWORD ROUTER
		$routerid = $this->serverROW();
		$btsid = $this->btsid();

        $data = array(
			'brand' => $this->input->post('brand'),
			'media' => $this->input->post('media'),
			'produk' => $this->input->post('produk'),
            'nama' => $this->input->post('nama'),
			'router_ip' => $this->input->post('router_ip'),
			'router_user' => $this->secure->encrypt_url($this->input->post('router_user')),
			'router_pass' => $this->secure->encrypt_url($this->input->post('router_pass')),
			'router_network' => $this->input->post('router_network'),
			'interface' => $this->input->post('interface'),
			'bts' => $this->input->post('bts'),
			'DR' => $this->input->post('dr'),
			'lastmile' => $this->input->post('lastmile_ip'),
			'te' => $this->input->post('te'),
			'cid' => $this->input->post('cid'),
			'sid' => $this->input->post('sid'),
			'pop' => $this->input->post('pop'),
			'pppoe_user' => $this->input->post('pppoe_user'),
			'pppoe_pass' => $this->input->post('pppoe_pass'),
			'odp' => $this->input->post('odp'),
			'area' => $this->input->post('area'),
			'email' => $this->input->post('email'),
			'kontak' => $this->input->post('kontak'),
			'pic' => $this->input->post('pic'),
			'bandwidth' => $this->input->post('bandwidth'),
			'tahun' => $this->input->post('tahun'),
			'kordinat' => $this->input->post('kordinat'),
			'pon' => $this->input->post('pon'),
			'vlan' => $this->input->post('vlan'),
        );
		$this->db->insert('blip_pelanggan', $data);
        return $this->session->set_flashdata('success','Data berhasil ditambahkan!');
    }

    public function timpa($id) {
	

        $data = array(
		'brand' => $this->input->post('brand'),
			'media' => $this->input->post('media'),
			'produk' => $this->input->post('produk'),
            'nama' => $this->input->post('nama'),
			'router_ip' => $this->input->post('router_ip'),
			'router_user' => $this->secure->encrypt_url($this->input->post('router_user')),
			'router_pass' => $this->secure->encrypt_url($this->input->post('router_pass')),
			'router_network' => $this->input->post('router_network'),
			'interface' => $this->input->post('interface'),
			'bts' => $this->input->post('bts'),
			'DR' => $this->input->post('dr'),
			'lastmile' => $this->input->post('lastmile_ip'),
			'te' => $this->input->post('te'),
			'cid' => $this->input->post('cid'),
			'sid' => $this->input->post('sid'),
			'pop' => $this->input->post('pop'),
			'pppoe_user' => $this->input->post('pppoe_user'),
			'pppoe_pass' => $this->input->post('pppoe_pass'),
			'odp' => $this->input->post('odp'),
			'area' => $this->input->post('area'),
			'email' => $this->input->post('email'),
			'kontak' => $this->input->post('kontak'),
			'pic' => $this->input->post('pic'),
			'bandwidth' => $this->input->post('bandwidth'),
			'tahun' => $this->input->post('tahun'),
			'kordinat' => $this->input->post('kordinat'),
			'pon' => $this->input->post('pon'),
			'vlan' => $this->input->post('vlan'),
        );
		$this->db->where('id', $id);
		$this->db->update('blip_pelanggan', $data);
		
        return $this->session->set_flashdata('success','Perubahan data berhasil.');
    }

    public function delete($id) {
		$exe1 = $this->db->delete('gm_router', array('id' => $id));
		$exe2 = $this->db->delete('gm_scheduler', array('idrouter' => $id));

		if($exe1 && $exe2)
		{
        return $this->session->set_flashdata('success', 'Berhasil menghapus data.'); 
		}
		else
		{
		return $this->session->set_flashdata('error', 'Gagal menghapus data.');
		} 
    }

//END	
}
