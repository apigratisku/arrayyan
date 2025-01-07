<?php

class Kpi extends CI_Controller {

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
		$this->load->model('m_kpi_induk');
		$this->load->model('m_media');
		$this->load->model('m_sales');
		$this->load->model('m_level');
		$this->load->model('m_produk');
		$this->load->model('m_layanan');
		$this->load->model('m_data_pelanggan');
    }

    public function index() {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='4' || $this->session->userdata('ses_admin')=='6'){
        if (!file_exists(APPPATH.'views/backend/kpi/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'kpi';
        $data['title'] = 'Data KPI';
        $data['items'] = $this->m_kpi->get();
       
		$this->load->view('backend/header', $data);
		$this->load->view('backend/kpi/index', $data); 
        $this->load->view('backend/footer');
	}else{
	redirect('logout');
	}
    }

    public function tambah() {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
        if (!file_exists(APPPATH.'views/backend/kpi/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_kpi_induk'] = $this->m_kpi_induk->get();
		
        $data['menu']  = 'kpi';
        $data['title'] = 'Tambah Data';

        $footer['scripts'] = "
            $('#konten').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['undo', 'redo']],
                    ['insert', ['link']]
                ]
            });
        ";
		$this->load->view('backend/header', $data);
        $this->load->view('backend/kpi/input', $data);
        $this->load->view('backend/footer', $footer);
	}else{
	redirect('logout');
	}
    }

    public function simpan() {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
        if (!file_exists(APPPATH.'views/backend/kpi/input.php')) {
            show_404();
        }
		$this->m_kpi->simpan();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'kpi';
        $data['title'] = 'Tambah Data';
		$this->load->view('backend/header', $data);
        $this->load->view('backend/kpi/input', $data);
        $this->load->view('backend/footer');
	}else{
	redirect('logout');
	}
    }

    public function ubah($id) {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
        if (!file_exists(APPPATH.'views/backend/kpi/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['items_kpi_induk'] = $this->m_kpi_induk->get();
		$data['items_kpi'] = $this->m_kpi->get();
        $data['menu']  = 'kpi';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->m_kpi->get($id);

        $footer['scripts'] = "
            $('#konten').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['undo', 'redo']],
                    ['insert', ['link']]
                ]
            });
        ";

  
		$this->load->view('backend/header', $data);
        $this->load->view('backend/kpi/input', $data);
        $this->load->view('backend/footer', $footer);
	}else{
	redirect('logout');
	}
    }

    public function timpa($id) {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
        if (!file_exists(APPPATH.'views/backend/kpi/input.php')) {
            show_404();
        }

        $this->m_kpi->timpa($id);
		redirect('manage/kpi');
	}else{
	redirect('logout');
	}
    }
	
	
    public function hapus($id) {
	if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='4'){
        if ($this->m_kpi->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/kpi');
	}else{
	redirect('logout');
	}
    }	
}

