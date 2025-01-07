<?php

class Firewall_filter extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //if (!$this->session->userdata('masuk')) {
        //    redirect('/login', 'refresh');
        //}

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
		$this->load->model('m_kpi');
		$this->load->model('m_media');
		$this->load->model('m_sales');
		$this->load->model('m_level');
		$this->load->model('m_produk');
		$this->load->model('m_layanan');
		$this->load->model('m_data_pelanggan');
		$this->load->model('m_firewall_filter');
    }

    public function index() {
        if (!file_exists(APPPATH.'views/backend/TE/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'Firewall Filter';
        $data['title'] = 'Data Firewall Address';
        $data['items'] = $this->m_firewall_filter->get();
		
        if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
		$this->load->view('backend/firewall_filter/index', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	
	public function index_ix() {
        if (!file_exists(APPPATH.'views/backend/TE/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'Firewall Filter';
        $data['title'] = 'Data Firewall Address';
        $data['items'] = $this->m_firewall_filter->index_ix();
		$data['get_ix'] = $this->m_firewall_filter->get_ix();
		
        if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
		$this->load->view('backend/firewall_filter/index_ix', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	
	public function bar_chart() {
   
     
      print_r($this->m_firewall_filter->get_ix());
    }
	public function charttest() {
	$this->load->view('backend/firewall_filter/charttest');   
	 }
	
	public function index_iix() {
        if (!file_exists(APPPATH.'views/backend/TE/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'Firewall Filter';
        $data['title'] = 'Data Firewall Address';
        $data['items'] = $this->m_firewall_filter->get_torch_iix();

		$query =  $this->db->query("SELECT FROM blip_torch_ix GROUP BY hasil"); 
 
      $record = $query->result();
      $data_chart = [];
 
      foreach($record as $row) {
            $data_chart['label'][] = $row->month_name;
            $data_chart['data'][] = (int) $row->count;
      }
      $data['chart_data'] = json_encode($data_chart);
		
        if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
		$this->load->view('backend/firewall_filter/index_iix', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	
	public function index_content() {
        if (!file_exists(APPPATH.'views/backend/TE/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'Firewall Filter';
        $data['title'] = 'Data Firewall Address';
        $data['items'] = $this->m_firewall_filter->get_torch_content();
		
        if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
		$this->load->view('backend/firewall_filter/index_content', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }


    public function import($id) {
	
		if($this->session->userdata('ses_admin')=='1'){
       	$this->m_firewall_filter->import($id);
        redirect('manage/TE');
		}else{
		show_404();
		}
    }
	public function syncdata() {
	
       	$this->m_firewall_filter->syncdata();
        //redirect('manage/firewall_filter');
    }
	
    public function torch_ix() {	
		
		$torch_ip = $this->secure->decrypt_url("R01MMXVsa0FFeTdCM3VyZGh1OG9RUT09");
		$torch_user = $this->secure->decrypt_url("UmtSbzkrZjdra1NlcDRsV3pSRjFWUT09");
		$torch_pass = $this->secure->decrypt_url("ajJHOXlOeGNKRnhCY3drVnhrM2Qydz09");
		$torch_port = "5521";
		$torch_interface = "vlan1802";
		
		
		if ($this->routerosapi->connect($torch_ip,$torch_user,$torch_pass,$torch_port)){
		$this->routerosapi->write('/tool/torch', false);	
		$this->routerosapi->write("=interface=".$torch_interface, false);	
		$this->routerosapi->write("=src-address=!127.0.0.1", false);	
		$this->routerosapi->write("=duration=3");		
		$addr = $this->routerosapi->read();
			foreach($addr as $getaddr){
			if(isset($getaddr['src-address'])){
			$torch = $this->db->get_where('blip_torch_ix', array('ip' => $getaddr['src-address']))->num_rows();
			$ipaddr = $this->db->get_where('blip_torch_ix', array('ip' => $getaddr['src-address']))->row_array();
				if(!empty($getaddr['src-address']) && $getaddr['rx'] > 100000){
					if($torch == 0){
					$data = array(
						'ip' => $getaddr['src-address'],
						//'tx' => $getaddr['tx'],
						'rx' => $getaddr['rx'],
					);				
					$insert_torch = $this->db->insert('blip_torch_ix', $data);
					}else{
					//$tx = $ipaddr['tx']+$getaddr['tx'];
					$rx = $ipaddr['rx']+$getaddr['rx'];
					$data = array(
						'ip' => $getaddr['src-address'],
						//'tx' => $tx,
						'rx' => $rx,
					);
					$this->db->where('id', $ipaddr['id']);
					$update_db = $this->db->update('blip_torch_ix', $data);
					}
				}
			}
			}
		return $this->session->set_flashdata('success','Data torch address berhasil ditambahkan !');
		}
		
    }
	
	
	public function syncdata_ix() {
	
       	$this->m_firewall_filter->syncdata_ix();
    }
	public function syncdata_iix() {
	
       	$this->m_firewall_filter->syncdata_iix();
    }
	public function syncdata_content() {
	
       	$this->m_firewall_filter->syncdata_content();
    }

}

