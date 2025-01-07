<?php

class Router extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }
		$this->load->library('secure');
        $this->load->model('router_model');
		$this->load->model('scheduler_model');
		$this->load->model('mikrotik_model');
		$this->load->model('lokalan_model');
		$this->load->model('mapping_model');
		$this->load->model('fiberstream_model');
		 $this->load->model('m_wo');
		$this->load->model('m_kpi');
		$this->load->model('m_media');
		$this->load->model('m_sales');
		$this->load->model('m_level');
		$this->load->model('m_produk');
		$this->load->library('user_agent');
		$this->load->helper(array('form', 'url'));

    }
	
    public function index() {
        if (!file_exists(APPPATH.'views/backend/router/index.php')) {
            show_404();
        }
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
        $data['title'] = 'Data Router';
        $data['items'] = $this->router_model->get();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) { 
			$this->load->view('backend/header', $data);
			$this->load->view('backend/router/index', $data); 
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/router/index', $data); 
			}
		} 
		else 
		{ 
		redirect('manage/router/'.$this->session->userdata('idrouter')); 
		} 
        $this->load->view('backend/footer');
    }

    public function tambah_fo_onnet($id=false) {
        if (!file_exists(APPPATH.'views/backend/router/input_fo_onnet.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
        if($id) {$data['title'] = 'Ubah Data'; $data['get_item'] = $this->router_model->get($id); $data['get_pop'] = $this->router_model->get_pop(); } else {$data['title'] = 'Tambah Data';$data['get_pop'] = $this->router_model->get_pop();}
		$data['te_items'] = $this->router_model->te();
		$data['dr_items'] = $this->router_model->get_distribusi();
		$data['odp_items'] = $this->mapping_model->get_ntb();
		$data['items_kpi'] = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
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
        	$this->load->view('backend/header', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ $this->load->view('backend/router/input_fo_onnet', $data);} else { redirect('manage/router/'.$this->session->userdata('idrouter')); } 
		} 
		else 
		{ 
		redirect('manage/router/'); 
		} 
        $this->load->view('backend/footer', $footer);
    }
	public function tambah_fo_cgs($id=false) {
        if (!file_exists(APPPATH.'views/backend/router/input_fo_cgs.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4')
		{ 
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
         if($id) {$data['title'] = 'Ubah Data'; $data['get_item'] = $this->router_model->get($id); $data['get_pop'] = $this->router_model->get_pop(); } else {$data['title'] = 'Tambah Data';$data['get_pop'] = $this->router_model->get_pop();}
		$data['te_items'] = $this->router_model->te();
		$data['dr_items'] = $this->router_model->get_distribusi();
		$data['odp_items'] = $this->mapping_model->get_ntb();
		$data['items_kpi'] = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
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
        	$this->load->view('backend/header', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ $this->load->view('backend/router/input_fo_cgs', $data);} else { redirect('manage/router/'.$this->session->userdata('idrouter')); } 
		} 
		else 
		{ 
		redirect('manage/router/'); 
		} 
        $this->load->view('backend/footer', $footer);
    }
	public function tambah_fo_telkom($id=false) {
        if (!file_exists(APPPATH.'views/backend/router/input_fo_telkom.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4')
		{ 
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
        if($id) {$data['title'] = 'Ubah Data'; $data['get_item'] = $this->router_model->get($id); } else {$data['title'] = 'Tambah Data';$data['get_pop'] = $this->router_model->get_pop();}
		$data['te_items'] = $this->router_model->te();
		$data['dr_items'] = $this->router_model->get_distribusi();
		$data['odp_items'] = $this->mapping_model->get_ntb();
				$data['items_kpi'] = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
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
        	$this->load->view('backend/header', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ $this->load->view('backend/router/input_fo_telkom', $data);} else { redirect('manage/router/'.$this->session->userdata('idrouter')); } 
		} 
		else 
		{ 
		redirect('manage/router/'); 
		} 
        $this->load->view('backend/footer', $footer);
    }
	public function tambah_fo_icon($id=false) {
        if (!file_exists(APPPATH.'views/backend/router/input_fo_icon.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4')
		{ 
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
        if($id) {$data['title'] = 'Ubah Data'; $data['get_item'] = $this->router_model->get($id); } else {$data['title'] = 'Tambah Data';$data['get_pop'] = $this->router_model->get_pop();}
		$data['te_items'] = $this->router_model->te();
		$data['dr_items'] = $this->router_model->get_distribusi();
		$data['odp_items'] = $this->mapping_model->get_ntb();
		$data['items_kpi'] = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
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
        	$this->load->view('backend/header', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ $this->load->view('backend/router/input_fo_icon', $data);} else { redirect('manage/router/'.$this->session->userdata('idrouter')); }
		} 
		else 
		{ 
		redirect('manage/router/'); 
		}  
        $this->load->view('backend/footer', $footer);
    }
	public function tambah_fo_mitra($id=false) {
        if (!file_exists(APPPATH.'views/backend/router/input_fo_mitra.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
        if($id) {$data['title'] = 'Ubah Data'; $data['get_item'] = $this->router_model->get($id); } else {$data['title'] = 'Tambah Data';$data['get_pop'] = $this->router_model->get_pop();}
		$data['te_items'] = $this->router_model->te();
		$data['dr_items'] = $this->router_model->get_distribusi();
		$data['odp_items'] = $this->mapping_model->get_ntb();
				$data['items_kpi'] = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
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
        	$this->load->view('backend/header', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ $this->load->view('backend/router/input_fo_mitra', $data);} else { redirect('manage/router/'.$this->session->userdata('idrouter')); } 
		} 
		else 
		{ 
		redirect('manage/router/'); 
		} 
        $this->load->view('backend/footer', $footer);
    }
	
	public function tambah_we($id=false) {
        if (!file_exists(APPPATH.'views/backend/router/input_we.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
        if($id) {$data['title'] = 'Ubah Data'; $data['get_item'] = $this->router_model->get($id);$data['get_pop'] = $this->router_model->get_pop(); } else {$data['title'] = 'Tambah Data';$data['get_pop'] = $this->router_model->get_pop();}
		$data['bts_items'] = $this->router_model->bts();
		$data['te_items'] = $this->router_model->te();
		$data['dr_items'] = $this->router_model->get_distribusi();
				$data['items_kpi'] = $this->m_kpi->get();
		$data['items_media'] = $this->m_media->get();
		$data['items_admin_sales'] = $this->m_sales->get();
		$data['items_admin_level'] = $this->m_level->get();
		$data['items_admin_produk'] = $this->m_produk->get();
		
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
        	$this->load->view('backend/header', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ $this->load->view('backend/router/input_we', $data);} else { redirect('manage/router/'.$this->session->userdata('idrouter')); } 
		} 
		else 
		{ 
		redirect('manage/router/'); 
		} 
        $this->load->view('backend/footer', $footer);
    }

    public function simpan() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4')
		{ 
		$this->router_model->simpan();
        $data['menu']  = 'router';
        $data['title'] = 'Tambah Router';

        redirect('manage/router');
		} 
		else 
		{ 
		redirect('manage/router/'); 
		} 
    }

    public function ubah($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4')
		{ 
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'router';
        $data['title'] = 'Ubah Data';
		$getidrouter = $this->router_model->get($id);
		if($getidrouter['media'] == "FO") {$input = "input_fo";} else {$input = "input_we";}
        $data['item']  = $this->router_model->get($id);

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
        	$this->load->view('backend/header', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			}
        if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ $this->load->view('backend/router/'.$input, $data); } else { redirect('manage/router/'.$this->session->userdata('idrouter')); }
		} 
		else 
		{ 
		redirect('manage/router/'); 
		}  
        $this->load->view('backend/footer', $footer);
    }

    public function timpa($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4')
		{ 
        $this->router_model->timpa($id);
		redirect('manage/router');
		} 
		else 
		{ 
		redirect('manage/router/'); 
		} 
    }
	
	
    public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ 
        if ($this->router_model->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/router'); } else { redirect('manage/router/'.$this->session->userdata('idrouter')); } 
		} 
		else 
		{ 
		redirect('manage/router/'); 
		} 
    }
	
	public function detil($id) {
        if (!file_exists(APPPATH.'views/backend/router/show.php')) {
            show_404();
        }
		$data['jumlah_router'] = $this->router_model->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  		= 'router';
        $data['title'] 		= 'Detil Data Router';
		$data['item']  		= $this->router_model->get($id);
		$data['data_log'] = $this->mikrotik_model->report_log($id);
		$data['ipservice']  	= $this->mikrotik_model->ipservice($id);
		$ro_data = $this->router_model->get($id);
		if($ro_data['status'] == "1")
		{
			if($ro_data['produk'] == "MAXI" || $ro_data['produk'] == "GFORCE")
			{
			$data['hs_info']  	= $this->mikrotik_model->hs_info($id);
			$data['hslogin']  	= $this->mikrotik_model->hs_aktif($id);
			$data['bwinfo']  	= $this->mikrotik_model->bw_info($id);
			$data['resource']   = $this->mikrotik_model->uptime($id);
			$data['data_lokalan'] = $this->lokalan_model->getALL($id);
			$data['routerboard']   = $this->mikrotik_model->routerboard($id);
			
			}
			else
			{
			$data['bwinfo']  	= $this->mikrotik_model->bw_info($id);
			}
				
		}
			if($this->agent->is_mobile())
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/router/show', $data);
			}
			else
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/router/show', $data);
			}
        $this->load->view('backend/footer');
    }
	
	public function hotspot($id) {
        $data['item']  = $this->router_model->get($id);
		$id_session =  $this->uri->segment(5);
		$this->mikrotik_model->hs_remove($id,$id_session);
        redirect('manage/router/'.$id);
    }
	public function restart($id) {
        $data['item']  = $this->router_model->get($id);
		$this->mikrotik_model->restart($id);
       if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='4'){ redirect('manage/router/'); } else { redirect('manage/router/'.$this->session->userdata('idrouter')); }
    }	
	public function backup($id) {
        $data['item']  = $this->router_model->get($id);
		$this->mikrotik_model->backup($id);
        redirect('manage/router/'.$id);
    }
	
	public function tambah_temporer() {
		$this->router_model->simpan_temporer();
        redirect('manage/router');
    }
	public function get_bw($id) {
	   $this->fiberstream_model->get_bw($id);
    }

}
