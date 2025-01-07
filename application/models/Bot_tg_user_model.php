<?php

class Bot_tg_user_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_telegram_user', array('id' => $id));
            $response = $query->row_array();
        } else {
			$this->db->select('gm_telegram_user.*,gm_router.nama,gm_router.router_ip');
            $this->db->from('gm_router');
			$this->db->join('gm_telegram_user','gm_telegram_user.id_router = gm_router.id');
            $query = $this->db->get();
            $response = $query->result_array();
       	    return $response; 
        }

        return $response;
    }
	public function get_existing($id_user) {
        $response = false;

        if ($id_user) {
            $query = $this->db->get_where('gm_telegram_user', array('id_user' => $id_user));
            $response = $query->row_array();
        } 
        return $response;
    }

	public function getROUTER() {
           $this->db->select('*');
            $this->db->from('gm_router');
			$this->db->order_by("id", "asc");
            $query = $this->db->get();
            return $query->result_array();
    }
	public function register($id_user,$tg_fname,$tg_lname) {
        $data = array(
			
            'id_bot' => "1",
			'id_router' => "0",
			'id_user' => $id_user,
			'id_fullname' => "$tg_fname $tg_lname",
			'status' => "0",
        );				
		return $this->db->insert('gm_telegram_user', $data);

    }
	
    public function simpan() {
        $data = array(
			
            'id_bot' => $this->input->post('id_bot'),
			'id_router' => $this->input->post('id_router'),
			'id_user' => $this->input->post('id_user'),
			'status' => $this->input->post('status'),
        );				
		$this->db->insert('gm_telegram_user', $data);
					
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
    }
	
	

    public function timpa($id) {
 		$data = array(
			
            'id_bot' => $this->input->post('id_bot'),
			'id_router' => $this->input->post('id_router'),
			'id_user' => $this->input->post('id_user'),
			'status' => $this->input->post('status'),
        );				
		$this->db->where('id', $id);
		$this->db->update('gm_telegram_user', $data);

        return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
    }

    public function delete($id) {

        return $this->db->delete('gm_telegram_user', array('id' => $id));


    }
	
	
}
