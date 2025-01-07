<?php

class M_kpi extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_kpi', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_kpi');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }

	
	
    public function simpan() {
	
		$data = array(
		'klasifikasi' => $this->input->post('klasifikasi'),
		'kegiatan' => $this->input->post('kegiatan'),
		'durasi' => $this->input->post('durasi'),
		'new_cust' => $this->input->post('new_cust'),
		
		);				
		$insert_db = $this->db->insert('blip_kpi', $data);
		
		if($insert_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data KPI",
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
		'klasifikasi' => $this->input->post('klasifikasi'),
		'kegiatan' => $this->input->post('kegiatan'),
		'durasi' => $this->input->post('durasi'),
		'new_cust' => $this->input->post('new_cust'),
		);		
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_kpi', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data KPI",
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
			'aktifitas' => "Menghapus data KPI",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log	
        return $this->db->delete('blip_kpi', array('id' => $id));
    }

}
