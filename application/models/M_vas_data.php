<?php

class M_vas_data extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_vas_data', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_vas_data');
			//$this->db->limit(1, 1);
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	
	public function get_export() {
            $this->db->select('*');
            $this->db->from('blip_vas_data');
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        return $response;
    }
	
	public function get_perangkat($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_vas_data', array('id_pelanggan' => $id));
            $response = $query->result_array();
        }

        return $response;
    }

	
	
    public function simpan() {
		date_default_timezone_set("Asia/Singapore");
		$data = array(
		'id_pelanggan' => $this->input->post('id_pelanggan'),
		'id_perangkat' => $this->input->post('id_perangkat'),
		'mac_address' => $this->input->post('mac_address'),	
		'serial_number' => $this->input->post('serial_number'),	
		'jumlah' => $this->input->post('jumlah'),	
		'satuan' => $this->input->post('satuan'),
		'alokasi' => $this->input->post('alokasi'),	
		'keterangan' => $this->input->post('keterangan'),
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$insert_db = $this->db->insert('blip_vas_data', $data);
		
		if($insert_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menambahkan data perangkat VAS",
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
        date_default_timezone_set("Asia/Singapore");
     	$data = array(
		'id_pelanggan' => $this->input->post('id_pelanggan'),
		'id_perangkat' => $this->input->post('id_perangkat'),
		'mac_address' => $this->input->post('mac_address'),	
		'serial_number' => $this->input->post('serial_number'),
		'jumlah' => $this->input->post('jumlah'),	
		'satuan' => $this->input->post('satuan'),
		'alokasi' => $this->input->post('alokasi'),
		'keterangan' => $this->input->post('keterangan'),
		'history_waktu' => date("Y-m-d H:i"),
		'history_iduser' => $this->session->userdata('ses_id'),	
		);	
		$this->db->where('id', $id);
		$update_db = $this->db->update('blip_vas_spesifikasi', $data);			
		
		if($update_db){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data perangkat VAS",
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
			'aktifitas' => "Menghapus data perangkat VAS",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
        return $this->db->delete('blip_vas_data', array('id' => $id));
    }

}
