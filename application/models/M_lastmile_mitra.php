<?php

class M_lastmile_mitra extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_lastmile_mitra', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_lastmile_mitra');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }

	
	
    public function simpan() {
	
		$data = array(
		'mitra' => $this->input->post('mitra'),
		'pelanggan' => $this->input->post('pelanggan'),
		'cid' => $this->input->post('cid'),
		'alamat' => $this->input->post('alamat'),
		'latitude' => $this->input->post('latitude'),
		'longtitude' => $this->input->post('longtitude'),
		'status' => $this->input->post('status'),
		);				
		$insert_db = $this->db->insert('blip_lastmile_mitra', $data);
		
		if($insert_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data Lastmile mitra",
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
		'mitra' => $this->input->post('mitra'),
		'pelanggan' => $this->input->post('pelanggan'),
		'cid' => $this->input->post('cid'),
		'alamat' => $this->input->post('alamat'),
		'latitude' => $this->input->post('latitude'),
		'longtitude' => $this->input->post('longtitude'),
		'status' => $this->input->post('status'),
		);		
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_lastmile_mitra', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data Lastmile mitra",
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
			'aktifitas' => "Menghapus data Lastmile mitra",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        return $this->db->delete('blip_lastmile_mitra', array('id' => $id));
    }

}
