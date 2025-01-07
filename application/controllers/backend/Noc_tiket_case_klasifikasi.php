<?php

class Noc_tiket_case_klasifikasi extends CI_Controller {

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
		$this->load->model('m_noc_tiket_case_klasifikasi');
    }

    public function index() {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_case_klasifikasi/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'noc_tiket_case_klasifikasi';
        $data['title'] = 'Data Case Klasifikasi';
        $data['items'] = $this->m_noc_tiket_case_klasifikasi->get();
       
		$this->load->view('backend/header', $data);
		$this->load->view('backend/noc_tiket_case_klasifikasi/index', $data); 
        $this->load->view('backend/footer');
    }

    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_case_klasifikasi/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'noc_tiket_case_klasifikasi';
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
        $this->load->view('backend/noc_tiket_case_klasifikasi/input', $data);
        $this->load->view('backend/footer', $footer);
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_case_klasifikasi/input.php')) {
            show_404();
        }
		$this->m_noc_tiket_case_klasifikasi->simpan();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();		
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'noc_tiket_case_klasifikasi';
        $data['title'] = 'Tambah Data';
		$this->load->view('backend/header', $data);
        $this->load->view('backend/noc_tiket_case_klasifikasi/input', $data);
        $this->load->view('backend/footer');
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_case_klasifikasi/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'noc_tiket_case_klasifikasi';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->m_noc_tiket_case_klasifikasi->get($id);

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
        $this->load->view('backend/noc_tiket_case_klasifikasi/input', $data);
        $this->load->view('backend/footer', $footer);
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/noc_tiket_case_klasifikasi/input.php')) {
            show_404();
        }

        $this->m_noc_tiket_case_klasifikasi->timpa($id);
		redirect('manage/noc_tiket_case_klasifikasi');
    }
	
	
    public function hapus($id) {
        if ($this->m_noc_tiket_case_klasifikasi->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/noc_tiket_case_klasifikasi');
    }

}
