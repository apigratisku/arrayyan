<?php

class Lokalan extends CI_Controller {

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
        if (!file_exists(APPPATH.'views/backend/lokalan/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
        $data['menu']  = 'lokalan';
        $data['title'] = 'Data Lokalan';
        $data['items'] = $this->lokalan_model->get();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) 
			{ 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/lokalan/index_mobile', $data); 
			} 
			else 
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/lokalan/index', $data); 
			} 
		}
		else 
		{
		 redirect('manage/router/'.$this->session->userdata('idrouter')); 
		} 
        $this->load->view('backend/footer');
    }

    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/lokalan/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
        $data['menu']  = 'lokalan';
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
		$data['item_router'] = $this->router_model->get();
        if($this->agent->is_mobile()) 
			{
        	$this->load->view('backend/header_mobile', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2'){ $this->load->view('backend/lokalan/input', $data);} else { redirect('manage/lokalan/'.$this->session->userdata('idrouter')); } 
        $this->load->view('backend/footer', $footer);
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/lokalan/input.php')) {
            show_404();
        }

        if ($this->lokalan_model->simpan()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menambah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menambah data.');
        }

        redirect('manage/lokalan');
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/lokalan/input.php')) {
            show_404();
        }
		
        $data['menu']  = 'router';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->lokalan_model->get($id);
		$data['item_router'] = $this->router_model->get();
		$data['id_lokalan'] = $this->lokalan_model->getPEL();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		
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

        if($this->agent->is_mobile()) 
			{
        	$this->load->view('backend/header_mobile', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2'){ $this->load->view('backend/lokalan/input', $data); } else { redirect('manage/lokalan/'.$this->session->userdata('idrouter')); } 
        $this->load->view('backend/footer', $footer);
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/lokalan/input.php')) {
            show_404();
        }

        if ($this->lokalan_model->timpa($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil mengubah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal mengubah data.');
        }

        redirect('manage/lokalan');
    }
	
	
    public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2'){ 
        if ($this->lokalan_model->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/lokalan'); }
    }
	
	

}
