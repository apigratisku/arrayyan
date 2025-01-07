<?php

class M_layanan extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_layanan', array('id_pelanggan' => $id));
            $response = $query->result_array();
        } 

        return $response;
    }
	public function get_layanan($id=false) {
        $response = false;
        if ($id) {
            $query = $this->db->get_where('blip_layanan', array('id' => $id));
            $response = $query->row_array();
        } 

        return $response;
    }
	public function get_pelanggan($id=false) {
        $response = false;
		$id_layanan = $this->db->get_where('blip_layanan', array('id_pelanggan' => $id))->row_array();
        if ($id_layanan) {
            $query = $this->db->get_where('blip_layanan', array('id' => $id_layanan));
            $response = $query->row_array();
        } 

        return $response;
    }
	

    public function layanan_timpa($id) {
		date_default_timezone_set("Asia/Singapore");

        $data = array(
			'id_pelanggan' => $this->input->post('id_pelanggan'),
			'id_media' => $this->input->post('id_media'),
			'id_produk' => $this->input->post('id_produk'),
			'id_bandwidth' => $this->input->post('id_bandwidth'),
			'id_role' => $this->input->post('id_role'),
			'id_status' => $this->input->post('id_status'),
			'id_dr' => $this->input->post('id_dr'),
			'id_te' => $this->input->post('id_te'),
			'bts' => $this->input->post('bts'),
			'lastmile' => $this->input->post('lastmile'),
			'interface' => $this->input->post('interface'),
			'vlan' => $this->input->post('vlan'),
			'pon' => $this->input->post('pon'),
			'odp' => $this->input->post('odp'),
			'router_network' => $this->input->post('router_network'),
			'router_ip' => $this->input->post('router_ip'),
			'pppoe_user' => $this->input->post('pppoe_user'),
			'pppoe_pass' => $this->input->post('pppoe_pass'),
			'keterangan' => $this->input->post('keterangan'),
			'id_mode' => $this->input->post('id_mode'),
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
        );
		$this->db->where('id', $id);
		if($this->db->update('blip_layanan', $data)){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Mengubah data layanan",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success','Perubahan data berhasil.');
		}else{
		return $this->session->set_flashdata('error','Perubahan data gagal.');
		}
    }
	public function layanan_simpan() {
		date_default_timezone_set("Asia/Singapore");

        $data = array(
			'id_pelanggan' => $this->input->post('id_pelanggan'),
			'id_media' => $this->input->post('id_media'),
			'id_produk' => $this->input->post('id_produk'),
			'id_bandwidth' => $this->input->post('id_bandwidth'),
			'id_role' => $this->input->post('id_role'),
			'id_status' => $this->input->post('id_status'),
			'id_dr' => $this->input->post('id_dr'),
			'id_te' => $this->input->post('id_te'),
			'bts' => $this->input->post('bts'),
			'lastmile' => $this->input->post('lastmile'),
			'interface' => $this->input->post('interface'),
			'vlan' => $this->input->post('vlan'),
			'pon' => $this->input->post('pon'),
			'odp' => $this->input->post('odp'),
			'router_network' => $this->input->post('router_network'),
			'router_ip' => $this->input->post('router_ip'),
			'pppoe_user' => $this->input->post('pppoe_user'),
			'pppoe_pass' => $this->input->post('pppoe_pass'),
			'keterangan' => $this->input->post('keterangan'),
			'id_mode' => $this->input->post('id_mode'),
			
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
        );
		if($this->db->insert('blip_layanan', $data)){
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menyimpan data layanan",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->session->set_flashdata('success','Penambahan data berhasil.');
		}else{
		return $this->session->set_flashdata('error','Penambahan data gagal.');
		}
    }
	
    public function layanan_hapus($id) {	
		//Log Aktifitas
		$log = array(
			'aktifitas' => "Menghapus data layanan",
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
		);				
		$this->db->insert('blip_log_user', $log);
		//End Log
		return $this->db->delete('blip_layanan', array('id' => $id));
		
    }

}
