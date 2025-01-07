<?php

class Specialtools extends CI_Controller {

    public function __construct() {
        parent::__construct();
   
        $this->load->model('mikrotik_model');
		$this->load->model('router_model');
    }

    public function index() {
       show_404();
    }
	
	 public function bypass() {
        $data['title'] = 'BLiP - Bypass Hotspot';
		$data['item_router'] = $this->mikrotik_model->get_router_ip();
        $this->load->view('backend/specialtools/bypass',$data);
    }
	public function simpan_bypass() {		
		$this->mikrotik_model->specialtools_hotspot_bypass();
		redirect('specialtools/bypass', 'refresh');
    }


}
