<?php

class Bypass extends CI_Controller {

    public function __construct() {
        parent::__construct();
   
        $this->load->model('mikrotik_model');
    }

    public function index() {
        if (!file_exists(APPPATH.'views/backend/specialtool/bypass.php')) {
            show_404();
        }
		
        $this->load->view('backend/specialtool/bypass');
    }


}
