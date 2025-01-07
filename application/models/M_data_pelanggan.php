<?php

class M_data_pelanggan extends CI_Model {

    public function __construct() {
        $this->load->database();
		$this->load->library('secure');
		
    }
	
	
	public function count_revenue() {

        return $data = $this->db->query("Select SUM(admin_biaya_netprofit) as total from blip_pelanggan where status_pelanggan='1'")->row();
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
	
	public function get_export($region,$brand,$area,$status_pelanggan) {
		$this->db->select('*');
		$this->db->from('blip_pelanggan');
		
		if($region != "all"){
		$regions = $region;
		}else{
		$regions = "";
		}
		
		if($brand != "all"){
		$brands = $brand;
		}else{
		$brands = "";
		}
		
		if($area != "all"){
		$areas = $area;
		}else{
		$areas = "";
		}
		
		if($status_pelanggan != "all"){
		$status_pelanggans = $status_pelanggan;
		}else{
		$status_pelanggans = "";
		}
		
		$multiClause = array(
			'region' => $region, 
			'brand' => $brand,
			'area' => $brand,
			'status_pelanggan' => $status_pelanggan,
			);
		$multipleCIWhere = ['region' => $region, 'brand' => $brand, 'area' => $brand, 'status_pelanggan' => $status_pelanggan];
		//$this->db->where($multiClause);
		//$this->db->where('region',$regions);	
		//$this->db->where('brand',$brands);	
		//$this->db->where('area',$areas);
		//$this->db->where('tahun',$tahuns);
		//$this->db->where('status_pelanggan',$status_pelanggans);	
		
		//$this->db->where($multipleCIWhere);
		$this->db->order_by("nama", "ASC");
		$query = $this->db->get();
		$response = $query->result_array();
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
			$this->db->order_by("nama", "ASC");
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
	
	public function get_bts() {
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
        return $this->db->get('blip_pelanggan')->num_rows();
    }
	public function count_gmedia() {
        return $this->db->get_where('blip_pelanggan', array('brand' => "GMEDIA"))->num_rows();
    }
	public function count_blip() {
        return $this->db->get_where('blip_pelanggan', array('brand' => "BLiP"))->num_rows();
    }
	public function count_fs() {
        return $this->db->get_where('blip_pelanggan', array('brand' => "FIBERSTREAM"))->num_rows();
    }
	public function count_kosong() {
        return $this->db->get_where('blip_pelanggan', array('brand' => NULL))->num_rows();
    }
	public function count_nonaktif() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "0"))->num_rows();
    }
	public function count_aktif() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "1"))->num_rows();
    }
	public function count_isolir() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "2"))->num_rows();
    }
	public function count_dismantle() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "3"))->num_rows();
    }
	public function ntb_count_aktif() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "1", 'region' => "NTB"))->num_rows();
    }
	public function ntb_count_isolir() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "2", 'region' => "NTB"))->num_rows();
    }
	public function bali_count_aktif() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "1", 'region' => "BALI"))->num_rows();
    }
	public function bali_count_isolir() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "2", 'region' => "BALI"))->num_rows();
    }
	public function sby_count_aktif() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "1", 'region' => "SURABAYA"))->num_rows();
    }
	public function sby_count_isolir() {
        return $this->db->get_where('blip_pelanggan', array('status_pelanggan' => "2", 'region' => "SURABAYA"))->num_rows();
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
		date_default_timezone_set("Asia/Singapore");
		$ar_enc_user = $this->secure->encrypt_url($this->input->post('user'));
		$ar_enc_pass = $this->secure->encrypt_url($this->input->post('pass'));
        $data = array(
            'nama' => $this->input->post('nama'),
			'ip' => $this->input->post('ip'),
			'user' => $ar_enc_user,
			'pass' => $ar_enc_pass,
			'ip_aplikasi' => $this->input->post('ip_aplikasi'),
        );
		$this->db->insert('gm_server', $data);
		
        return $this->session->set_flashdata('success','Data berhasil ditambahkan! ');
    }

    public function timpa_server($id) {
        date_default_timezone_set("Asia/Singapore");
		$ar_enc_user = $this->secure->encrypt_url($this->input->post('user'));
		$ar_enc_pass = $this->secure->encrypt_url($this->input->post('pass'));
        $data = array(
            'nama' => $this->input->post('nama'),
			'ip' => $this->input->post('ip'),
			'user' => $ar_enc_user,
			'pass' => $ar_enc_pass,
			'ip_aplikasi' => $this->input->post('ip_aplikasi'),
		);
		$this->db->where('id', $id);
		$this->db->update('gm_server', $data);
		
        return $this->session->set_flashdata('success','Data berhasil ditambahkan!'); 
        
    }

    public function delete_server($id) {
		$routerid = $this->server($id);		
		date_default_timezone_set("Asia/Singapore");
		$username = $this->secure->decrypt_url($routerid['user']);
		$password = $this->secure->decrypt_url($routerid['pass']);
		$hostname = $routerid['ip'];
		if ($this->routerosapi->connect($hostname, $username, $password))
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
		date_default_timezone_set("Asia/Singapore");
		$ar_enc_ip =$this->secure->encrypt_url($this->input->post('ip'));
		$ar_enc_user = $this->secure->encrypt_url($this->input->post('user'));
		$ar_enc_pass = $this->secure->encrypt_url($this->input->post('pass'));
        if ($this->routerosapi->connect($this->input->post('ip'), $this->input->post('user'), $this->input->post('pass')))
			{
				$data = array(
				'nama' => $this->input->post('nama'),
				'ip' => $ar_enc_ip,
				'user' => $ar_enc_user,
				'pass' => $ar_enc_pass,
				);;
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
        date_default_timezone_set("Asia/Singapore");
		$ar_enc_ip =$this->secure->encrypt_url($this->input->post('ip'));
		$ar_enc_user = $this->secure->encrypt_url($this->input->post('user'));
		$ar_enc_pass = $this->secure->encrypt_url($this->input->post('pass'));
		if ($this->routerosapi->connect($this->input->post('ip'), $this->input->post('user'), $this->input->post('pass')))
			{
				$data = array(
				'nama' => $this->input->post('nama'),
				'ip' => $ar_enc_ip,
				'user' => $ar_enc_user,
				'pass' => $ar_enc_pass,
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
		date_default_timezone_set("Asia/Singapore");
		$ar_enc_ip =$this->secure->encrypt_url($this->input->post('ip'));
		$ar_enc_user = $this->secure->encrypt_url($this->input->post('user'));
		$ar_enc_pass = $this->secure->encrypt_url($this->input->post('pass'));
        if ($this->routerosapi->connect($this->input->post('ip'), $this->input->post('user'), $this->input->post('pass')))
			{
				$data = array(
				'nama' => $this->input->post('nama'),
				'ip' => $ar_enc_ip,
				'user' => $ar_enc_user,
				'pass' => $ar_enc_pass,
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
		date_default_timezone_set("Asia/Singapore");
		$ar_enc_ip =$this->secure->encrypt_url($this->input->post('ip'));
		$ar_enc_user = $this->secure->encrypt_url($this->input->post('user'));
		$ar_enc_pass = $this->secure->encrypt_url($this->input->post('pass'));
        if ($this->routerosapi->connect($this->input->post('ip'), $this->input->post('user'), $this->input->post('pass')))
			{
				$data = array(
				'nama' => $this->input->post('nama'),
				'ip' => $ar_enc_ip,
				'user' => $ar_enc_user,
				'pass' => $ar_enc_pass,
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
		date_default_timezone_set("Asia/Singapore");
		$ar_enc_user = $this->secure->encrypt_url($this->input->post('router_user'));
		$ar_enc_pass = $this->secure->encrypt_url($this->input->post('router_pass'));
		
		$netprofit = $this->input->post('admin_biaya_mtc')-$this->input->post('admin_biaya_partner')-$this->input->post('admin_biaya_cb');
		
		//Attachment Form FB
	   $file_fb = "";  
        if (isset($_FILES['admin_form_langganan']) && is_uploaded_file($_FILES['admin_form_langganan']['tmp_name'])) {
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_form_langganan')) {
                $file_fb = $this->upload->data('file_name');
            }
        }
		 
		//Attachment Form ktp
		$file_ktp = "";  
        if (isset($_FILES['admin_ktp_identitas']) && is_uploaded_file($_FILES['admin_ktp_identitas']['tmp_name'])) {
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_ktp_identitas')) {
                $file_ktp = $this->upload->data('file_name');
            }
        }
		
		//Attachment Form NPWP
		$file_npwp = "";  
        if (isset($_FILES['admin_npwp']) && is_uploaded_file($_FILES['admin_npwp']['tmp_name'])) {
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_npwp')) {
                $file_npwp = $this->upload->data('file_name');
            }
        }
		
		//Attachment Form BAA
		$file_baa = "";  
        if (isset($_FILES['admin_form_baa']) && is_uploaded_file($_FILES['admin_form_baa']['tmp_name'])) {
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_npwp')) {
                $file_baa = $this->upload->data('file_name');
            }
        }
		
        $data = array(
			'brand' => $this->input->post('brand'),
			'region' => $this->input->post('region'),
			'level' => $this->input->post('level'),
            'nama' => $this->input->post('nama'),
			'cid' => $this->input->post('cid'),
			'sid' => $this->input->post('sid'),
			'area' => $this->input->post('area'),
			'email' => $this->input->post('email'),
			'kontak' => $this->input->post('kontak'),
			'pic' => $this->input->post('pic'),
			'kordinat' => $this->input->post('kordinat'),
			'tahun' => $this->input->post('tahun'),
			'router_ip' => $this->input->post('router_ip'),
			'router_user' => $ar_enc_user,
			'router_pass' => $ar_enc_pass,
			'router_network' => $this->input->post('router_network'),
			'interface' => $this->input->post('interface'),
			'bts' => $this->input->post('bts'),
			'DR' => $this->input->post('dr'),
			'lastmile' => $this->input->post('lastmile_ip'),
			'te' => $this->input->post('te'),
			'pop' => $this->input->post('pop'),
			'pppoe_user' => $this->input->post('pppoe_user'),
			'pppoe_pass' => $this->input->post('pppoe_pass'),
			'odp' => $this->input->post('odp'),
			'pon' => $this->input->post('pon'),
			'vlan' => $this->input->post('vlan'),
			'klasifikasi_service' => $this->input->post('klasifikasi_service'),
			

			
			//Admin teknis
			'tgl_wo_admin' => $this->input->post('tgl_wo_admin'),
			'tgl_req_sales' => $this->input->post('tgl_req_sales'),
			'tgl_req_teknis' => $this->input->post('tgl_req_teknis'),
			'tgl_aktivasi_teknis' => $this->input->post('tgl_aktivasi_teknis'),
			'tgl_report_teknis' => $this->input->post('tgl_report_teknis'),
			'tgl_terbit_baa' => $this->input->post('tgl_terbit_baa'),
			'tgl_req_ob' => $this->input->post('tgl_req_ob'),
			'tgl_start_ob' => $this->input->post('tgl_start_ob'),
			'tgl_terbit_inv' => $this->input->post('tgl_terbit_inv'),
			'tgl_rfs' => $this->input->post('tgl_rfs'),
			'admin_divisi' => $this->input->post('admin_divisi'),
			'admin_sales' => $this->input->post('admin_sales'),
			'admin_alamat' => $this->input->post('admin_alamat'),
			'admin_segment' => $this->input->post('admin_segment'),
			'admin_subsegment' => $this->input->post('admin_subsegment'),
			'admin_start_kontrak' => $this->input->post('admin_start_kontrak'),
			'admin_end_kontrak' => $this->input->post('admin_end_kontrak'),
			'admin_biaya_otc' => $this->input->post('admin_biaya_otc'),
			'admin_biaya_mtc' => $this->input->post('admin_biaya_mtc'),
			'admin_biaya_partner' => $this->input->post('admin_biaya_partner'),
			'admin_biaya_cb' => $this->input->post('admin_biaya_cb'),
			'admin_biaya_netprofit' => $netprofit,
			'admin_form_langganan' => $file_fb,
			'admin_ktp_identitas' => $file_ktp,
			'admin_npwp' => $file_npwp,
			'admin_form_baa' => $file_baa,
			'keterangan' => $this->input->post('keterangan'),
			'status_pelanggan' => $this->input->post('status_pelanggan'),	
			'teknis_mrtg_user' => $this->input->post('teknis_mrtg_user'),
			'teknis_mrtg_pass' => $this->input->post('teknis_mrtg_pass'),
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
        );
		$this->db->insert('blip_pelanggan', $data);
        return $this->session->set_flashdata('success','Data berhasil ditambahkan!');
    }

    public function timpa($id) {
		date_default_timezone_set("Asia/Singapore");
		$ar_enc_user = $this->secure->encrypt_url($this->input->post('router_user'));
		$ar_enc_pass = $this->secure->encrypt_url($this->input->post('router_pass'));
		
		$netprofit = $this->input->post('admin_biaya_mtc')-$this->input->post('admin_biaya_partner')-$this->input->post('admin_biaya_cb');
		
		//Get data
		$dataid_pelanggan = $this->get($id);
		$dataid_wo = $this->db->get_where('blip_wo', array('id' => $dataid_pelanggan['id_wo']))->row_array();
	
	   //Attachment Form FB
	   $file_fb = "";  
        if (isset($_FILES['admin_form_langganan']) && is_uploaded_file($_FILES['admin_form_langganan']['tmp_name'])) {
			$fb    = $dataid_wo['admin_form_langganan'];
			if(!empty($dataid_wo['admin_form_langganan'])){unlink('./xdark/doc/attachment/' . $fb);}
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_form_langganan')) {
                $file_fb = $this->upload->data('file_name');
            }
        }else{
		$file_fb = $dataid_wo['admin_form_langganan'];
		}
		 
		//Attachment Form ktp
		$file_ktp = "";  
        if (isset($_FILES['admin_ktp_identitas']) && is_uploaded_file($_FILES['admin_ktp_identitas']['tmp_name'])) {
			$ktp    = $dataid_wo['admin_ktp_identitas'];
			if(!empty($dataid_wo['admin_ktp_identitas'])){unlink('./xdark/doc/attachment/' . $ktp);}
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_ktp_identitas')) {
                $file_ktp = $this->upload->data('file_name');
            }
        }else{
		$file_ktp = $dataid_wo['admin_ktp_identitas'];
		}
		
		//Attachment Form NPWP
		$file_npwp = "";  
        if (isset($_FILES['admin_npwp']) && is_uploaded_file($_FILES['admin_npwp']['tmp_name'])) {
			$npwp    = $dataid_wo['admin_npwp'];
			if(!empty($dataid_wo['admin_npwp'])){unlink('./xdark/doc/attachment/' . $npwp);}
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_npwp')) {
                $file_npwp = $this->upload->data('file_name');
            }
        }else{
		$file_npwp = $dataid_wo['admin_npwp'];
		} 
		
		//Attachment Form BAA
		$file_baa = "";  
        if (isset($_FILES['admin_form_baa']) && is_uploaded_file($_FILES['admin_form_baa']['tmp_name'])) {
			$baa    = $dataid_wo['admin_form_baa'];
			if(!empty($dataid_wo['admin_form_baa'])){unlink('./xdark/doc/attachment/' . $baa);}
            $config['upload_path']       = './xdark/doc/attachment';
            $config['allowed_types']     = 'gif|jpg|jpeg|bmp|png|pdf|ppt|pptx|xls|xlsx|doc|docx';
            $config['max_filename']      = 100;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('admin_form_baa')) {
                $file_baa = $this->upload->data('file_name');
            }
        }else{
		$file_baa = $dataid_wo['admin_form_baa'];
		} 
		
		
        $data = array(
			'brand' => $this->input->post('brand'),
			'region' => $this->input->post('region'),
			'level' => $this->input->post('level'),
            'nama' => $this->input->post('nama'),
			'cid' => $this->input->post('cid'),
			'sid' => $this->input->post('sid'),
			'area' => $this->input->post('area'),
			'email' => $this->input->post('email'),
			'kontak' => $this->input->post('kontak'),
			'pic' => $this->input->post('pic'),
			'kordinat' => $this->input->post('kordinat'),
			'tahun' => $this->input->post('tahun'),
			'router_ip' => $this->input->post('router_ip'),
			'router_user' => $ar_enc_user,
			'router_pass' => $ar_enc_pass,
			'router_network' => $this->input->post('router_network'),
			'interface' => $this->input->post('interface'),
			'bts' => $this->input->post('bts'),
			'DR' => $this->input->post('dr'),
			'lastmile' => $this->input->post('lastmile_ip'),
			'te' => $this->input->post('te'),
			'pop' => $this->input->post('pop'),
			'pppoe_user' => $this->input->post('pppoe_user'),
			'pppoe_pass' => $this->input->post('pppoe_pass'),
			'odp' => $this->input->post('odp'),
			'pon' => $this->input->post('pon'),
			'vlan' => $this->input->post('vlan'),
			'klasifikasi_service' => $this->input->post('klasifikasi_service'),

			
			//Admin teknis
			'tgl_wo_admin' => $this->input->post('tgl_wo_admin'),
			'tgl_req_sales' => $this->input->post('tgl_req_sales'),
			'tgl_req_teknis' => $this->input->post('tgl_req_teknis'),
			'tgl_aktivasi_teknis' => $this->input->post('tgl_aktivasi_teknis'),
			'tgl_report_teknis' => $this->input->post('tgl_report_teknis'),
			'tgl_terbit_baa' => $this->input->post('tgl_terbit_baa'),
			'tgl_req_ob' => $this->input->post('tgl_req_ob'),
			'tgl_start_ob' => $this->input->post('tgl_start_ob'),
			'tgl_terbit_inv' => $this->input->post('tgl_terbit_inv'),
			'tgl_rfs' => $this->input->post('tgl_rfs'),
			'admin_divisi' => $this->input->post('admin_divisi'),
			'admin_sales' => $this->input->post('admin_sales'),
			'admin_alamat' => $this->input->post('admin_alamat'),
			'admin_segment' => $this->input->post('admin_segment'),
			'admin_subsegment' => $this->input->post('admin_subsegment'),
			'admin_start_kontrak' => $this->input->post('admin_start_kontrak'),
			'admin_end_kontrak' => $this->input->post('admin_end_kontrak'),
			'admin_biaya_otc' => $this->input->post('admin_biaya_otc'),
			'admin_biaya_mtc' => $this->input->post('admin_biaya_mtc'),
			'admin_biaya_partner' => $this->input->post('admin_biaya_partner'),
			'admin_biaya_cb' => $this->input->post('admin_biaya_cb'),
			'admin_biaya_netprofit' => $netprofit,
			'admin_form_langganan' => $file_fb,
			'admin_ktp_identitas' => $file_ktp,
			'admin_npwp' => $file_npwp,
			'admin_form_baa' => $file_baa,
			'keterangan' => $this->input->post('keterangan'),
			'status_pelanggan' => $this->input->post('status_pelanggan'),	
			'teknis_mrtg_user' => $this->input->post('teknis_mrtg_user'),
			'teknis_mrtg_pass' => $this->input->post('teknis_mrtg_pass'),
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
        );
		$this->db->where('id', $id);
		$update_pelanggan = $this->db->update('blip_pelanggan', $data);
		if($update_pelanggan){
			if($this->input->post('status_pelanggan') == "1") { $s_pel = 1; } else {$s_pel = 0;}
			$data_layanan = array(	
			'id_status' => $s_pel,
			);
			$this->db->where('id_pelanggan', $id);
			$this->db->update('blip_layanan', $data_layanan);
		}
        return $this->session->set_flashdata('success','Perubahan data berhasil.');
    }
	
	

    public function delete($id) {
		$exe1 = $this->db->delete('blip_pelanggan', array('id' => $id));
		$exe2 = $this->db->delete('gm_scheduler', array('id_layanan' => $id));
		$exe3 = $this->db->delete('blip_layanan', array('id_pelanggan' => $id));

		if($exe1 && $exe2 && $exe3)
		{
        return $this->session->set_flashdata('success', 'Berhasil menghapus data.'); 
		}
		else
		{
		return $this->session->set_flashdata('error', 'Gagal menghapus data.');
		} 
    }
	
	/*public function migrasi() {
		date_default_timezone_set("Asia/Singapore");
		$data_all = $this->get();
		foreach($data_all as $all){
        $data = array(
			'id_pelanggan' => $all['id'],
			'id_media' => $all['media'],
			'id_produk' => $all['produk'],
			'id_bandwidth' => $all['bandwidth'],
			'id_role' => "1",
			'id_status' => "1",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => "12",
        );
		$this->db->insert('blip_layanan', $data);
		}
		
        return $this->session->set_flashdata('success','Migrasi data berhasil.');
    }*/
	
	/*public function migrasi() {
		date_default_timezone_set("Asia/Singapore");
		$data_all = $this->get();
		foreach($data_all as $all){
        $data = array(
			//'bts' => $all['bts'],
			//'lastmile' => $all['lastmile'],
			//'interface' => $all['interface'],
			//'vlan' => $all['vlan'],
			//'pon' => $all['pon'],
			//'odp' => $all['odp'],
			//'router_network	' => $all['router_network'],
			//'router_ip' => $all['router_ip'],
			//'pppoe_user' => $all['pppoe_user'],
			//'pppoe_pass' => $all['pppoe_pass'],
			'id_dr' => $all['DR'],
			'id_te' => $all['TE'],
        );
		$this->db->where('id_pelanggan', $all['id']);
		$exe = $this->db->update('blip_layanan', $data);
		}
		if($exe){
        return $this->session->set_flashdata('success','Migrasi data berhasil.');
		}else{
		return $this->session->set_flashdata('error','Migrasi data GAGAL.');
		}
    }*/
	
	//Sent Whatsapp Group - Data Layanan Pelanggan //Push WA
	public function get_data_layanan_wa($layanan,$id_pelanggan) {
        $query = $this->db->get_where('blip_layanan', array('id_pelanggan' => $id_pelanggan,'id' => $layanan))->result_array();
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_pelanggan))->row_array();
		if(isset($query)){
		     $no=1;
			 $response = "*[NOC][Data Aktivasi]* - *".$pelanggan['nama']."*\n\n";
			 foreach($query as $querydata){
			 $data_media = $this->db->get_where('blip_mediaaccess', array('id' => $querydata['id_media']))->row_array();
			 $data_paket = $this->db->get_where('blip_produk', array('id' => $querydata['id_produk']))->row_array();			 
			 
			 $response .= "Media Access: *".$data_media['media']."*\nLayanan: *".$data_paket['produk']."*\nBandwidth: *".$querydata['id_bandwidth']." Mbps*\nNetwork Address: ".$querydata['router_network']."\nIP Address: ".$querydata['router_ip']."\nPPPOE User: ".$querydata['pppoe_user']."\nPPPOE Password: ".$querydata['pppoe_pass']."\n\nhttps://nms-ntb.blip.net.id/ \nMRTG User: *".$pelanggan['teknis_mrtg_user']."*\nMRTG Password: *".$pelanggan['teknis_mrtg_pass']."*\n\n";
			 $no++;
			 }
			 $response .= "Regards,\n*Blippy Assistant*";
			 return $response;
		 }	
    }
	//Sent Telegram Group - Data Layanan Pelanggan
	public function get_data_layanan_tg($layanan,$id_pelanggan) {
        $query = $this->db->get_where('blip_layanan', array('id_pelanggan' => $id_pelanggan,'id' => $layanan))->result_array();
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $id_pelanggan))->row_array();
		if(isset($query)){
		     $no=1;
			 $response = "<b>[NOC][Data Aktivasi]</b> - <b>".$pelanggan['nama']."</b>\n\n";
			 foreach($query as $querydata){
			 $data_media = $this->db->get_where('blip_mediaaccess', array('id' => $querydata['id_media']))->row_array();
			 $data_paket = $this->db->get_where('blip_produk', array('id' => $querydata['id_produk']))->row_array();			 
			 
			 $response .= "Media Access: <b>".$data_media['media']."</b>\nLayanan: <b>".$data_paket['produk']."</b>\nBandwidth: <b>".$querydata['id_bandwidth']." Mbps</b>\nNetwork Address: ".$querydata['router_network']."\nIP Address: ".$querydata['router_ip']."\nPPPOE User: ".$querydata['pppoe_user']."\nPPPOE Password: ".$querydata['pppoe_pass']."\n\nhttps://nms-ntb.blip.net.id/ \nMRTG User: <b>".$pelanggan['teknis_mrtg_user']."</b>\nMRTG Password: <b>".$pelanggan['teknis_mrtg_pass']."</b>\n\n";
			 $no++;
			 }
			 $response .= "Regards,\n<b>Blippy Assistant</b>";
			 return $this->telegram_lib->sendblip("-901753609",$response);
		 }	
    }
	

//END	
}
