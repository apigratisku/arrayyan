<?php

class Logintest extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

		$this->load->model('mikrotik_model');
		$this->load->library('user_agent');
		$this->load->helper(array('form', 'url'));

    }
	
    public function index($id) {
        if (!file_exists(APPPATH.'views/backend/router/tesconnect.php')) {
            show_404();
        }

        $data['menu']  			= 'router';
        $data['title'] 			= 'Test Router';
        $data['ipservice']  	= $this->mikrotik_model->ipservice($id);

			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/router/tesconnect', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/router/tesconnect', $data); 
			}
    }

}
