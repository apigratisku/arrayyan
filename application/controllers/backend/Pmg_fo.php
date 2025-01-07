<?php

class Fiberstream extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

        $this->load->model('router_model');
		$this->load->model('mikrotik_model');
		$this->load->model('fiberstream_model');
		$this->load->library('user_agent');
		$this->load->helper(array('form', 'url'));

    }
	
    public function index() {
        if (!file_exists(APPPATH.'views/backend/fiberstream/index.php')) {
            show_404();
        }

        $data['menu']  = 'fiberstream_index';
        $data['title'] = 'Data Fiberstream';
        $data['items'] = $this->fiberstream_model->get_fs();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/fiberstream/index_mobile', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/fiberstream/index', $data); 
			}
		} 
        $this->load->view('backend/footer');
    }
	public function pon() {
        if (!file_exists(APPPATH.'views/backend/fiberstream/pon.php')) {
            show_404();
        }

        $data['menu']  = 'fiberstream_pon';
        $data['title'] = 'Data PON';
        $data['items'] = $this->fiberstream_model->get_pon();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/fiberstream/pon', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/fiberstream/pon', $data); 
			}
		} 
        $this->load->view('backend/footer');
    }
	public function tambah() {
        if (!file_exists(APPPATH.'views/backend/fiberstream/input.php')) {
            show_404();
        }

        $data['menu']  = 'fiberstream';
        $data['title'] = 'Buat Invoice';
        $data['item_fs'] = $this->fiberstream_model->getcid();
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/fiberstream/input', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/fiberstream/input', $data); 
			}
		} 
		else 
		{ 
		redirect('manage/fiberstream/'.$this->session->userdata('idrouter')); 
		} 
        $this->load->view('backend/footer');
    }
    

public function bcschedule() {

        if ($this->fiberstream_model->bcschedule()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Broadcast Scheduler sukses.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Broadcast Scheduler gagal!');
        }

        redirect('manage/fiberstream/');
    }
	
public function approve($cid,$id) {

        $this->fiberstream_model->approve($cid,$id);
        redirect('manage/fiberstream/');
    }
public function approve_tg($id) {

        $this->fiberstream_model->approve_tg($id);
        redirect('manage/fiberstream/');
    }
	
public function isolir($cid,$id) {

        $this->fiberstream_model->isolir($cid,$id);
        redirect('manage/fiberstream/');
    }
public function isolir_tg($id) {

        $this->fiberstream_model->isolir_tg($id);
        redirect('manage/fiberstream/');
    }
public function get_client($id) {
       $this->fiberstream_model->get_client($id);
    }
public function get_client_count($id) {
	   $this->fiberstream_model->get_client_count($id);
    }
public function redaman($cid) {
        $data['menu']  = 'fiberstream_result';
        $data['title'] = 'Hasil Pengecekan';
        $data['resultfs'] = $this->fiberstream_model->redaman($cid);
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
		} 
        $this->load->view('backend/footer');
    }
public function port($cid) {
        $data['menu']  = 'fiberstream_result';
        $data['title'] = 'Hasil Pengecekan';
        $data['resultfs'] = $this->fiberstream_model->port($cid);
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
		} 
        $this->load->view('backend/footer');
    }
public function profile($cid) {
        $data['menu']  = 'fiberstream_result';
        $data['title'] = 'Hasil Pengecekan';
        $data['resultfs'] = $this->fiberstream_model->profile($cid);
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
		} 
        $this->load->view('backend/footer');
    }
	
public function bandwidth($cid) {
        $data['menu']  = 'fiberstream_result';
        $data['title'] = 'Hasil Pengecekan';
        $data['resultfs'] = $this->fiberstream_model->bandwidth($cid);
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
		} 
        $this->load->view('backend/footer');
    }	
public function restart($cid) {
        $data['menu']  = 'fiberstream_result';
        $data['title'] = 'Hasil Pengecekan';
        $data['resultfs'] = $this->fiberstream_model->restart($cid);
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/fiberstream/result', $data); 
			}
		} 
        $this->load->view('backend/footer');
    }	
	
	
	
	
	
	
public function web_gpon_olt($id) {
 		
 		$this->load->library('phptelnet');
		$telnet = new PHPTelnet();
		$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
        if ($result == 0)
		{
		$telnet->DoCommand('show gpon onu detail-info gpon-onu_1/1/5:'.$id, $result);
		$skuList = preg_split('/\r\n|\r|\n/', $result);
			foreach($skuList as $key => $value )
			{
			$items_onu[] = $value;
			}
		print_r($items_onu);
		//DC Telnet
		$telnet->Disconnect();
		//Output ONU ke Telegram
		$output="";
		foreach($items_onu as $onu )
		{
			$output.= $onu."<br>";
			
			//Manipulasi string
			$str_olt = explode(" ", $onu);
			//print_r($str_olt);
			if(!empty($str_olt[16])) {$status = $str_olt[16];}elseif(!empty($str_olt[17])) {$status = $str_olt[17];} elseif(!empty($str_olt[18])) {$status = $str_olt[18];} elseif($str_olt[0] == "%Code") {$status = "KOSONG";} else{$status = "KOSONG";}
			if($str_olt[0] != "%Code") {$onuvalue = $str_olt[0];} else {$onuvalue = "KOSONG";}
			
				
			$this->load->database();
			$this->db->reconnect();	
			$data = array(
				'onu' => $onuvalue,
				'rx_olt' => "",
				'rx_onu' => "",
				'status' => $status,
				);
			if(!empty($onuvalue) && $onuvalue != "KOSONG")
			{
			$query1 = $this->db->get_where('gm_olt', array('onu' => $str_olt[0]));
			$query = $this->db->escape($query1);
        	$count = $query->num_rows();
				if ($count == 0) {
				$this->db->insert('gm_olt', $data);
				}
				else
				{
				$this->db->where('onu', $str_olt[0]); $this->db->update('gm_olt', $data);
				}
			}
		}
		
		//Manipulasi string total ONU Aktif/Offline/DyingGasp/LOS
		foreach($items_onu as $onustr )
		{
			if(strpos($onustr,'DyingGasp'))
			{ $items_onu_poweroff[] = $onustr."<br>"; }
			elseif(strpos($onustr,'LOS'))
			{ $items_onu_los[] = $onustr."<br>"; }
			elseif(strpos($onustr,'OffLine'))
			{ $items_onu_OffLine[] = $onustr."<br>"; }
		}
		//Hitung total ONU
		$len_aktif = count($items_onu);
		if(!empty($items_onu_poweroff)) {$len_poweroff = count($items_onu_poweroff);} else {$len_poweroff = 0;}
		if(!empty($items_onu_los)) {$len_los = count($items_onu_los);} else {$len_los = 0;}
		if(!empty($items_onu_OffLine)) {$len_offline = count($items_onu_OffLine);} else {$len_offline = 0;}
		//Reply to Telegram
		echo $output."<br>Total: ".$len_aktif."<br>Offline: ".$len_offline."<br>Power Off: ".$len_poweroff."<br>LOS: ".$len_los."<br><br><br>";
		}

    }



}
