<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
if (fsockopen(base64_decode("MTAzLjI1NS4yNDIuNA=="), base64_decode("MjI4MA=="), $errno, $errstr, 1) == NULL){
			echo "<h2>Validasi Error</h2>
			<p style=\"font-size:20px;\">Lisensi tidak valid. Silahkan hubungi Administrator untuk validasi lisensi aplikasi.</p>		
			<p style=\"font-size:20px;\">Terima kasih.</p>		
			<p>*** Created by Adiarizki ***</p>";
}else{
class Maintenance extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

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
    }
	
    public function index() {
        if (!file_exists(APPPATH.'views/backend/maintenance/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_akses'] = $this->maintenance_model->get_akses();
		
        $data['menu']  = 'maintenance';
        $data['title'] = 'Maintenance Data';
		$this->load->view('backend/header', $data);
		$this->load->view('backend/maintenance/index', $data); 
        $this->load->view('backend/footer');
    }
	
	public function user_akses_history() {
        if (!file_exists(APPPATH.'views/backend/maintenance/user_akses_history.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_akses'] = $this->maintenance_model->get_history();
		
        $data['menu']  = 'maintenance';
        $data['title'] = 'Maintenance Data';
		$this->load->view('backend/header', $data);
		$this->load->view('backend/maintenance/user_akses_history', $data); 
        $this->load->view('backend/footer');
    }
	
	public function user_akses_tambah() {
        if (!file_exists(APPPATH.'views/backend/maintenance/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_akses'] = $this->maintenance_model->get_akses();
		
        $data['menu']  = 'maintenance';
        $data['title'] = 'Maintenance User Akses Router';
		$this->load->view('backend/header', $data);
		$this->load->view('backend/maintenance/user_akses_tambah', $data); 
        $this->load->view('backend/footer');
    }
	public function user_akses_ubah($id) {
        if (!file_exists(APPPATH.'views/backend/maintenance/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_akses'] = $this->maintenance_model->get_akses($id);
		
        $data['menu']  = 'maintenance';
        $data['title'] = 'Maintenance User Akses Router';
		$this->load->view('backend/header', $data);
		$this->load->view('backend/maintenance/user_akses_tambah', $data); 
        $this->load->view('backend/footer');
    }
	public function user_akses_simpan() {
		$this->maintenance_model->user_akses_simpan();
        redirect('manage/maintenance');
    }
	public function user_akses_timpa($id) {
		$this->maintenance_model->user_akses_timpa($id);
        redirect('manage/maintenance');
    }
	public function user_akses_hapus($id) {
		$this->maintenance_model->user_akses_hapus($id);
        redirect('manage/maintenance');
    }
	public function user_akses_sync($id) {
		$this->maintenance_model->user_akses_sync($id);
        redirect('manage/maintenance');
    }

    

    public function maintenance_radio_bts() {
		$this->maintenance_model->start_maintenance("WE","radio_bts");
        redirect('manage/maintenance');
    }
	public function maintenance_radio_client() {
		$this->maintenance_model->start_maintenance("WE","radio_client");
        redirect('manage/maintenance');
    }
	public function maintenance_router_client() {
		$this->maintenance_model->start_maintenance("ALL","router_client");
        redirect('manage/maintenance');
    }

	public function maintenance_result() {
			if (!file_exists(APPPATH.'views/backend/bts/maintenance_result.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'bts';
        $data['title'] = 'Radio BTS - Maintenance';
        $data['items'] = $this->bts_model->get();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) 
			{ 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/bts/maintenance_result', $data); 
			} 
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/bts/maintenance_result', $data); 
			} 
			$this->load->view('backend/footer');
		}
    }

	
}
}