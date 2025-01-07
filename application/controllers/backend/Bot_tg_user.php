<?php

class Bot_tg_user extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

        $this->load->model('telegram_model');
		$this->load->library('user_agent');
    }
	
    public function index() {
        if (!file_exists(APPPATH.'views/backend/bot_tg_user/index.php')) {
            show_404();
        }

        $data['menu']  = 'bot_tg_user';
        $data['title'] = 'Data User Telegram';
        $data['items'] = $this->telegram_model->get();
        
		if($this->session->userdata('ses_admin')=='1')
		{ 
			if($this->agent->is_mobile()) 
			{ 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/bot_tg_user/index_mobile', $data); 
			} 
			else 
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/bot_tg_user/index', $data); 
			} 
		}
        $this->load->view('backend/footer');
    }
	
    public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1')
		{ 
			if ($this->telegram_model->delete($id)) {
				$this->session->unset_userdata('success');
				$this->session->set_flashdata('success', 'Berhasil menghapus data.');
			} else {
				$this->session->unset_userdata('error');
				$this->session->set_flashdata('error', 'Gagal menghapus data.');
			}
        redirect('manage/bot_tg_user'); 
		}
    }
	
	public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/bot_tg_user/input.php')) {
            show_404();
        }

        $data['menu']  = 'router';
        $data['title'] = 'Ubah Data';
        $data['items']  = $this->telegram_model->get($id);
		
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
        if($this->session->userdata('ses_admin')=='1'){ $this->load->view('backend/bot_tg_user/input', $data); }
        $this->load->view('backend/footer', $footer);
    }
	

}
