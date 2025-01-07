<?php

class Esp8266 extends CI_Controller {

    public function __construct() {
        parent::__construct();

		$this->load->library('TCPDF');
		$this->load->library('user_agent');
		
		$this->load->model('bts_model');
        $this->load->model('operator_model');
		$this->load->model('station_model');
		$this->load->model('lokalan_model');	
		$this->load->model('router_model');
		$this->load->model('scheduler_model');
		$this->load->model('mikrotik_model');
		$this->load->model('lokalan_model');
		$this->load->model('mapping_model');
		$this->load->model('fiberstream_model');
		$this->load->model('maintenance_model');
		$this->load->model('telegram_model');
		$this->load->model('m_baddebt');
		$this->load->model('m_wo');
		$this->load->model('m_vas_data');
		$this->load->model('m_media');
		$this->load->model('m_sales');
		$this->load->model('m_level');
		$this->load->model('m_produk');
		$this->load->model('m_layanan');
		$this->load->model('m_data_pelanggan');
		$this->load->model('m_vas_spec');
		$this->load->model('m_vas_data');
		$this->load->model('m_spk');
    }

    public function index() {
	echo "tes";
    }
	
	public function post_relay() {
		if($this->input->post('in') == NULL){
		echo"No value detected !";
		}
		else{
		$this->load->database();
		$data = array(
			'in' => $this->input->post('in'),
			'time' => date("Y-m-d H:i"),
			
			);						
			$this->db->insert('blip_8266', $data);
		}
    }

   
}

