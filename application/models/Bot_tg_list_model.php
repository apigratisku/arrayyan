<?php

class Bot_tg_list_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('gm_telegram_bot', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('gm_telegram_bot');
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }

    public function simpan() {

        $data = array(
			'bot_nama' => $this->input->post('bot_nama'),
			'bot_api' => $this->input->post('bot_api'),
        );				
		$this->db->insert('gm_telegram_bot', $data);
		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
    }

    public function timpa($id) {
         $data = array(
			'bot_nama' => $this->input->post('bot_nama'),
			'bot_api' => $this->input->post('bot_api'),
        );					
		$this->db->where('id', $id);
		$this->db->update('gm_telegram_bot', $data);
        return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
    }

    public function delete($id) {
        return $this->db->delete('gm_telegram_bot', array('id' => $id));
    }
	
	
}
