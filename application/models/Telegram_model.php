<?php

class Telegram_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_telegram_user', array('id_user' => $id));
            $response = $query->row_array();
        } 
		else
		{
			$query = $this->db->get('gm_telegram_user');
            $response = $query->result_array();
		}

        return $response;
    }
public function count() {
        return $this->db->get('gm_telegram_user')->num_rows();
    }
    public function simpan($id_user,$id_nama,$id_area) {
        $data_id = array(
			'id_user' => $id_user,
			'id_nama' => $id_nama,
			'id_area' => $id_area,
			'status' => "1",
		);
		
		return $this->db->insert('gm_telegram_user', $data_id);
    }
	
	public function simpan_temp($id_user,$id_nama) {
        $data_id = array(
			'id_user' => $id_user,
			'id_nama' => $id_nama,
			'status' => "0",
		);
		
		return $this->db->insert('gm_telegram_user', $data_id);
    }

    public function timpa($id_user,$id_area,$status) {
 		$data_id = array(
			'id_user' => $id_user,
			'id_area' => $id_area,
			'status' => $status,
		);		
		$this->db->where('id_user', $id_user);
		return $this->db->update('gm_telegram_user', $data_id);
    }

    public function delete($id_user) {

        return $this->db->delete('gm_telegram_user', array('id_user' => $id_user));


    }
	
	
}
