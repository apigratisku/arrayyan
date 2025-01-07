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
class TE extends CI_Controller {

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
        $data['menu']  = 'TE';
        $data['title'] = 'Data TE';
        $data['items'] = $this->router_model->serverte();
		
        if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
		$this->load->view('backend/TE/index', $data); 
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }

    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/TE/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'TE';
        $data['title'] = 'Tambah TE';

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
		if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/TE/input', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/TE/input.php')) {
            show_404();
        }
		$this->router_model->simpan_te();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'TE';
        $data['title'] = 'Tambah TE';
		
		if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/TE/input', $data);
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/TE/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'TE';
        $data['title'] = 'Ubah TE';
        $data['item']  = $this->router_model->serverte($id);

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

        if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/TE/input', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/TE/input.php')) {
            show_404();
        }

        if ($this->router_model->timpa_te($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil mengubah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal mengubah data.');
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'TE';
        $data['title'] = 'Ubah TE';
        $data['item']  = $this->router_model->timpa_te($id);

        if($this->session->userdata('ses_admin')=='1'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/TE/input', $data);
        $this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	
	
    public function hapus($id) {
	
		if($this->session->userdata('ses_admin')=='1'){
        if ($this->router_model->delete_te($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/TE');
		}else{
		show_404();
		}
    }

}
}