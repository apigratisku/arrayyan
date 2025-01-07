<?php

class M_noc_tiket_noc_ipcore extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_tiket_noc_ipcore', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_tiket_noc_ipcore');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }

	
	
    public function simpan() {
	
		$data = array(
		'nama' => $this->input->post('nama'),
		);				
		$insert_db = $this->db->insert('blip_tiket_noc_ipcore', $data);
		
		if($insert_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data NOC IP Core",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal menambah data.');
		}	
    }

    public function timpa($id) {
        
      $data = array(
		'nama' => $this->input->post('nama'),
		);		
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_tiket_noc_ipcore', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data NOC IP Core",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
		}else{
		return $this->session->set_flashdata('error', 'Gagal mengubah data.');
		}	
    }
	
    public function delete($id) {
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data NOC IP Core",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log	
        return $this->db->delete('blip_tiket_noc_ipcore', array('id' => $id));
    }

}
