<?php

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		if(empty($this->session->userdata('ses_admin'))) {
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
        if (!file_exists(APPPATH.'views/backend/dashboard.php')) {
            show_404();
        }

        $data['menu']  = 'dashboard';
        $data['title'] = 'Dashboard';
		
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['count_gmedia'] = $this->m_data_pelanggan->count_gmedia();
		$data['count_blip'] = $this->m_data_pelanggan->count_blip();
		$data['count_fs'] = $this->m_data_pelanggan->count_fs();
		$data['count_aktif'] = $this->m_data_pelanggan->count_aktif();
		$data['count_nonaktif'] = $this->m_data_pelanggan->count_nonaktif();
		$data['count_isolir'] = $this->m_data_pelanggan->count_isolir();
		$data['count_dismantle'] = $this->m_data_pelanggan->count_dismantle();
		$data['ntb_count_aktif'] = $this->m_data_pelanggan->ntb_count_aktif();
		$data['ntb_count_isolir'] = $this->m_data_pelanggan->ntb_count_isolir();
		$data['bali_count_aktif'] = $this->m_data_pelanggan->bali_count_aktif();
		$data['bali_count_isolir'] = $this->m_data_pelanggan->bali_count_isolir();
		$data['sby_count_aktif'] = $this->m_data_pelanggan->sby_count_aktif();
		$data['sby_count_isolir'] = $this->m_data_pelanggan->sby_count_isolir();
		$data['total_revenue'] = $this->m_data_pelanggan->count_revenue();
		
		
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
			
        $data['jumlah_operator'] = $this->operator_model->count();	
		$data['jumlah_station'] = $this->station_model->count();
		$data['jumlah_router_up'] = $this->router_model->router_up();
		$data['jumlah_router_down'] = $this->router_model->router_down();
		$data['jumlah_station_up'] = $this->station_model->lastmile_up();
		$data['jumlah_station_down'] = $this->station_model->lastmile_down();

		$this->load->view('backend/header', $data);
        $this->load->view('backend/dashboard', $data);
        $this->load->view('backend/footer');
    }
	public function pwd_encrypt()
        {
            $encrytKey = "d19i+r3n50eR4t";
            echo MD5(SHA1("godek123" . $encrytKey));
        }

}
