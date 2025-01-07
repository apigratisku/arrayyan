<?php

class Operator_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function auth_operator($email){
		return  $this->db->get_where('gm_operator', array('email' => $email));  
    }
	 public function auth_fs($cid){
		return  $this->db->get_where('gm_router', array('cid' => $cid));  
    }
	public function data_fs($cid){
		return  $this->db->get_where('gm_fiberstream', array('cid' => $cid));  
    }
   
    public function count() {
        return $this->db->get('gm_operator')->num_rows();
    }

    public function get($id=false) {
        $response = false;

        if ($id) {
            $this->db->select('*');
            $this->db->from('gm_operator');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_operator');
            $query = $this->db->get();
            $response = $query->result_array();
        }
        return $response;
    }
	
	public function getROUTER($id) {
			$routerid = $this->get($id); 
			$this->db->select('*');
            $this->db->from('gm_router');
            $this->db->where('id', $routerid['idrouter']);
            $query = $this->db->get();
            return $response = $query->row_array();
    }
	
	public function getTS() {
			$this->db->select('*');
            $this->db->from('gm_operator');
            $this->db->where('admin', "5");
			$this->db->or_where('admin', "3");
			
            $query = $this->db->get();
            return $response = $query->result_array();
    }
	
	public function simpan() {
		  $foto = "";
		  
        if (isset($_FILES['foto']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
            $config['upload_path']       = './static/photos/operator';
            $config['allowed_types']     = 'gif|jpg|png';
            $config['max_filename']      = 40;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data('file_name');
            }
        }
		$pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        $data = array(
            'nama' => $this->input->post('nama'),
            'password' => $pass,
            'foto' => $foto,
            'admin' => $this->input->post('admin'),
            'email' => $this->input->post('email'),
			'no_wa' => $this->input->post('no_wa'),
			'telegram' => $this->input->post('telegram'),
        );

        return $this->db->insert('gm_operator', $data);
    }

    public function timpa($id) {
		
		if ($id) {
            $this->db->select('id, email, nama, foto, admin,no_wa,telegram');
            $this->db->from('gm_operator');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $response = $query->row_array();
        } else {
            $this->db->select('id, email, nama, foto, admin,no_wa,telegram');
            $this->db->from('gm_operator');
            $query = $this->db->get();
            $response = $query->result_array();
        }
	
        $foto = "";
		$opdata 	= $this->get($id);
        if (isset($_FILES['foto']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
       	    $foto_op    = $opdata['foto'];
			unlink('./static/photos/operator/' . $foto_op);
            $config['upload_path']       = './static/photos/operator';
            $config['allowed_types']     = 'gif|jpg|png';
            $config['max_filename']      = 40;
            $config['encrypt_name']      = true;
            $config['file_ext_tolower']  = true;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data('file_name');
            }
        }
		
		if($this->input->post('password') != NULL) {$pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);}
        if ($foto == "" && $this->input->post('password') == NULL) {
            $data = array(
				'email' => $this->input->post('email'),
                'nama' => $this->input->post('nama'),
                'admin' => $this->input->post('admin'),
				'no_wa' => $this->input->post('no_wa'),
				'telegram' => $this->input->post('telegram'),
            );
        }elseif ($this->input->post('password') == NULL) {
            $data = array(
				'email' => $this->input->post('email'),
                'nama' => $this->input->post('nama'),
                'admin' => $this->input->post('admin'),
				'no_wa' => $this->input->post('no_wa'),
				'telegram' => $this->input->post('telegram'),
				'foto' => $foto,
            );
        }elseif ($foto == "") {
            $data = array(
				'email' => $this->input->post('email'),
				'password' => $pass,
                'nama' => $this->input->post('nama'),
                'admin' => $this->input->post('admin'),
				'no_wa' => $this->input->post('no_wa'),
				'telegram' => $this->input->post('telegram'),
            );
        }elseif ($this->input->post('no_wa') == NULL) {
            $data = array(
				'email' => $this->input->post('email'),
				'password' => $pass,
                'nama' => $this->input->post('nama'),
                'admin' => $this->input->post('admin'),
				'telegram' => $this->input->post('telegram'),
            );
        }elseif ($this->input->post('telegram') == NULL) {
            $data = array(
				'email' => $this->input->post('email'),
				'password' => $pass,
                'nama' => $this->input->post('nama'),
                'admin' => $this->input->post('admin'),
            );
        }else {
            $data = array(
              	'email' => $this->input->post('email'),
				'password' => $pass,
                'nama' => $this->input->post('nama'),
                'foto' => $foto,
				'admin' => $this->input->post('admin'),
				'no_wa' => $this->input->post('no_wa'),
            );
        }

        $this->db->where('id', $id);

        return $this->db->update('gm_operator', $data);
    }

    public function delete($id) {
        return $this->db->delete('gm_operator', array('id' => $id));

        return false;
    }
	
	
	public function prosespwd() {
		$cek_operator  = $this->auth_operator($this->session->userdata('ses_userid'));
		$data=$cek_operator->row_array();
		$password  = strip_tags($this->input->post('password1'));
		$passbaru = password_hash($this->input->post('password2'), PASSWORD_BCRYPT);
		if($this->input->post('password3') != $this->input->post('password2')) 
		{
			$this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Silahkan isi konfirmasi password dengan benar.');
		}
		elseif(!password_verify($password, $data['password']))
		{
			$this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Silahkan isi password lama anda dengan benar.');
		}
		else
		{
            $data = array(
				'password' => $passbaru,
            );

         $this->db->where('id', $this->session->userdata('ses_id'));
         $this->db->update('gm_operator', $data);
		 $this->session->unset_userdata('success');
         return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
		}
    }

}
