<?php

class M_vas_spec extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_vas_spesifikasi', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_vas_spesifikasi');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }

	
	
    public function simpan() {
	
		$data = array(
		'nama' => $this->input->post('nama'),
		'merk' => $this->input->post('merk'),		
		);				
		$insert_db = $this->db->insert('blip_vas_spesifikasi', $data);
		
		if($insert_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data spesifikasi perangkat VAS",
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
		'merk' => $this->input->post('merk'),
		);		
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_vas_spesifikasi', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data spesifikasi perangkat VAS",
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
			'aktifitas' => "Menghapus data spesifikasi perangkat VAS",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log	
        return $this->db->delete('blip_vas_spesifikasi', array('id' => $id));
    }

}
