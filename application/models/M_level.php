<?php

class M_level extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_level_prioritas', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_level_prioritas');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }

	
	
    public function simpan() {
	
		$data = array(
		'level' => $this->input->post('level'),
		);				
		$insert_db = $this->db->insert('blip_level_prioritas', $data);
		
		if($insert_db){
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal menambah data.');
		}	
    }

    public function timpa($id) {
        
      $data = array(
		'level' => $this->input->post('level'),
		);		
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_level_prioritas', $data);			
		
		if($update_db){
		return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal mengubah data.');
		}	
    }
	
    public function delete($id) {	
        return $this->db->delete('blip_level_prioritas', array('id' => $id));
    }

}
