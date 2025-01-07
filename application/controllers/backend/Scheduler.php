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
class Scheduler extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }

        $this->load->library('TCPDF');
		$this->load->library('user_agent');
		$this->load->library('secure');
		
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
        if (!file_exists(APPPATH.'views/backend/scheduler/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
        $data['title'] = 'Data Scheduler';
        $data['items'] = $this->scheduler_model->get();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
			$this->load->view('backend/header', $data);
			$this->load->view('backend/scheduler/index', $data);
			$this->load->view('backend/footer');
		}else{
		show_404();
		}
        
    }

    public function tambah_a() {
        if (!file_exists(APPPATH.'views/backend/scheduler/input_a.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['wo_data'] = $this->m_wo->wo_scheduler();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
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
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/scheduler/input_a', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function tambah_b() {
        if (!file_exists(APPPATH.'views/backend/scheduler/input_b.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['wo_data'] = $this->m_wo->wo_scheduler();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
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
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/scheduler/input_b', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function tambah_c() {
        if (!file_exists(APPPATH.'views/backend/scheduler/input_c.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['wo_data'] = $this->m_wo->wo_scheduler();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
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
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/scheduler/input_c', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function tambah_d() {
        if (!file_exists(APPPATH.'views/backend/scheduler/input_d.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['wo_data'] = $this->m_wo->wo_scheduler();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
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
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
       if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/scheduler/input_d', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function tambah_e() {
        if (!file_exists(APPPATH.'views/backend/scheduler/input_e.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
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
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/scheduler/input_e', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function tambah_f() {
        if (!file_exists(APPPATH.'views/backend/scheduler/input_f.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
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
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/scheduler/input_f', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	public function tambah_g() {
        if (!file_exists(APPPATH.'views/backend/scheduler/input_g.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
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
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/scheduler/input_g', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }
	
	public function tambah_h() {
        if (!file_exists(APPPATH.'views/backend/scheduler/input_h.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['wo_data'] = $this->m_wo->wo_scheduler();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'scheduler';
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
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
       if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
        $this->load->view('backend/scheduler/input_h', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }

    public function simpan() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
       $this->scheduler_model->simpan();


        redirect('manage/scheduler');
		}else{
		show_404();
		}
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/scheduler/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->scheduler_model->get($id);
		$data['item_router'] = $this->router_model->get();
		$data['id_scheduler'] = $this->scheduler_model->getPEL();
		
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

      if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
		$this->load->view('backend/header', $data);
      	$this->load->view('backend/scheduler/input', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/scheduler/input.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
        if ($this->scheduler_model->timpa($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil mengubah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal mengubah data.');
        }

        redirect('manage/scheduler');
		}else{
		show_404();
		}
    }
	
	
    /*public function hapus($id) {
		$this->scheduler_model->delete($id);

        redirect('manage/scheduler');
    }*/
	public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6'){
        if ($this->scheduler_model->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/scheduler');
		}else{
		show_404();
		}
    }
	
	public function fetch_layanan() {
	   $data =  $this->scheduler_model->fetch_layanan($this->input->post('pelanggan'));
	   echo json_encode($data);
	 }
	
	

}
}