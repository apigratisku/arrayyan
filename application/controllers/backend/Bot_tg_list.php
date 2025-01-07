<?php

class Bot_tg_list extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

        $this->load->model('bot_tg_list_model');
		$this->load->library('user_agent');
    }
	
    public function index() {
        if (!file_exists(APPPATH.'views/backend/bot_tg_list/index.php')) {
            show_404();
        }

        $data['menu']  = 'bot_tg_list';
        $data['title'] = 'Data Bot';
        $data['items'] = $this->bot_tg_list_model->get();
        
		if($this->session->userdata('ses_admin')=='1')
		{ 
			if($this->agent->is_mobile()) 
			{ 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/bot_tg_list/index_mobile', $data); 
			} 
			else 
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/bot_tg_list/index', $data); 
			} 
		}
        $this->load->view('backend/footer');
    }

    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/bot_tg_list/input.php')) {
            show_404();
        }

        $data['menu']  = 'bot_tg_list';
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
        if($this->agent->is_mobile()) 
			{
        	$this->load->view('backend/header_mobile', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1'){ $this->load->view('backend/bot_tg_list/input', $data);} else { redirect('manage/bot_tg_list/'.$this->session->userdata('idrouter')); } 
        $this->load->view('backend/footer', $footer);
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/bot_tg_list/input.php')) {
            show_404();
        }

        if ($this->bot_tg_list_model->simpan()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menambah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menambah data.');
        }

        redirect('manage/bot_tg_list');
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/bot_tg_list/input.php')) {
            show_404();
        }

        $data['menu']  = 'bot_tg_list';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->bot_tg_list_model->get($id);
		
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
        if($this->session->userdata('ses_admin')=='1'){ $this->load->view('backend/bot_tg_list/input', $data); } else { redirect('manage/bot_tg_list/'.$this->session->userdata('idrouter')); } 
        $this->load->view('backend/footer', $footer);
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/lokalan/input.php')) {
            show_404();
        }

        if ($this->bot_tg_list_model->timpa($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil mengubah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal mengubah data.');
        }

        redirect('manage/bot_tg_list');
    }
	
	
    public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1'){ 
        if ($this->bot_tg_list_model->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/bot_tg_list'); }
    }
	
	

}
