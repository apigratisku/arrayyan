<?php

class Member extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

        $this->load->model('member_model');
    }

    public function index() {
        if (!file_exists(APPPATH.'views/backend/member/index.php')) {
            show_404();
        }

        $data['menu']  = 'member';
        $data['title'] = 'Data Member';
        $data['items'] = $this->member_model->get();

        $this->load->view('backend/header', $data);
        $this->load->view('backend/member/index', $data);
        $this->load->view('backend/footer');
    }

    public function detil($id) {
        if (!file_exists(APPPATH.'views/backend/member/show.php')) {
            show_404();
        }

        $data['menu']  = 'member';
        $data['title'] = 'Detil Data Member';
        $data['item']  = $this->member_model->get($id);

        $this->load->view('backend/header', $data);
        $this->load->view('backend/member/show', $data);
        $this->load->view('backend/footer');
    }

    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/member/input.php')) {
            show_404();
        }

        $data['menu']  = 'member';
        $data['title'] = 'Tambah Data Member';

        $this->load->view('backend/header', $data);
        $this->load->view('backend/member/input', $data);
        $this->load->view('backend/footer');
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/member/input.php')) {
            show_404();
        }

        if ($this->member_model->simpan()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menambah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menambah data.');
        }

        $data['menu']  = 'member';
        $data['title'] = 'Tambah Data Member';

        $this->load->view('backend/header', $data);
        $this->load->view('backend/member/input', $data);
        $this->load->view('backend/footer');
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/member/input.php')) {
            show_404();
        }

        $data['menu']  = 'member';
        $data['title'] = 'Ubah Data Member';
        $data['item']  = $this->member_model->get($id);

        $this->load->view('backend/header', $data);
        $this->load->view('backend/member/input', $data);
        $this->load->view('backend/footer');
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/member/input.php')) {
            show_404();
        }

        if ($this->member_model->timpa($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil mengubah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal mengubah data.');
        }

        $data['menu']  = 'member';
        $data['title'] = 'Ubah Data Member';
        $data['item']  = $this->member_model->get($id);

        $this->load->view('backend/header', $data);
        $this->load->view('backend/member/input', $data);
        $this->load->view('backend/footer');
    }

    public function hapus($id) {
        $member = $this->member_model->get($id);
		$foto_member = $this->member_model->getFOTO($id);
		$foto   = $foto_member['foto'];

        if ($this->member_model->delete($id)) {
            unlink('./static/photos/member/' . $foto);
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/member');
    }
	
	

}
