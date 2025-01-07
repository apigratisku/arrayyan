<?php

class Station_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	
	
    public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_radio_station', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_radio_station');
			$this->db->order_by("id", "desc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	public function count() {
		if($this->session->userdata('ses_admin') == "1" || $this->session->userdata('ses_admin') == "2")
		{
        return $this->db->get('gm_lastmile')->num_rows();
		}
    }
	
	public function lastmile_up() {
		if($this->session->userdata('ses_admin') == "1" || $this->session->userdata('ses_admin') == "2")
		{
        return $this->db->get_where('gm_lastmile', array('status' => "1"))->num_rows();
		}
    }
	
	public function lastmile_down() {
		if($this->session->userdata('ses_admin') == "1" || $this->session->userdata('ses_admin') == "2")
		{
        return $this->db->get_where('gm_lastmile', array('status' => "0"))->num_rows();
		}
    }
	
	public function getEXPORT() {
            $this->db->select('*');
            $this->db->from('gm_log_radio_realtime');
			$this->db->order_by("kualitas", "desc");
            return $this->db->get();
    }
	
	/*public function count() {
        if($this->session->userdata('ses_admin') == "1")
		{
        return $this->db->get('gm_log_radio_realtime')->num_rows();
		}
		else
		{
		return $this->db->get_where('gm_log_radio_realtime')->num_rows();
		}
    }*/
	
	public function getALL($id) {
            $this->db->select('gm_log_radio_realtime');
            $this->db->from('gm_log_radio_realtime');
            $this->db->where('gm_log_radio_realtime.id', $id);
            $query = $this->db->get();
			$response = $query->result_array();

        return $response;
    }
	
	 public function delete($id) {
        return $this->db->delete('gm_log_radio_realtime', array('id' => $id));

        return false;
    }

}
