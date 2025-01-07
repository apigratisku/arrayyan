<?php

class M_baddebt extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_mediaaccess', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_mediaaccess');
			//$this->db->limit(1, 1);
			$this->db->order_by("media", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }

	
	
    public function simpan() {
	
		$data = array(
		'media' => $this->input->post('media'),
		);				
		$insert_db = $this->db->insert('blip_mediaaccess', $data);
		
		if($insert_db){
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal menambah data.');
		}	
    }

    public function timpa($id) {
        
      $data = array(
		'media' => $this->input->post('media'),
		);	
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_mediaaccess', $data);			
		
		if($update_db){
		return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal mengubah data.');
		}	
    }
	
    public function delete($id) {	
        return $this->db->delete('blip_mediaaccess', array('id' => $id));
    }

}
