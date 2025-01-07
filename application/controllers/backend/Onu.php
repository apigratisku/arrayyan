<?php
require_once('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
if (fsockopen(base64_decode("MTAzLjI1NS4yNDIuNA=="), base64_decode("MjI4MA=="), $errno, $errstr, 1) == NULL){
			echo "<h2>Validasi Error</h2>
			<p style=\"font-size:20px;\">Lisensi tidak valid. Silahkan hubungi Administrator untuk validasi lisensi aplikasi.</p>		
			<p style=\"font-size:20px;\">Terima kasih.</p>		
			<p>*** Created by Adiarizki ***</p>";
}else{
class Onu extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->config('api_bot', true);
		$this->load->helper(array('form', 'url'));
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
		$this->load->model('bts_model');
		$this->load->model('m_vas_data');
		$this->load->model('m_vas_spec');
		$this->load->model('m_olt');
		$this->load->model('m_onu');
    }

    public function index() {
	    if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }else{
			if (!file_exists(APPPATH.'views/backend/OLT/index.php')) {
				show_404();
			}
			$data['wo_all'] = $this->m_wo->count_wo_all();
			$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
			$data['wo_baru'] = $this->m_wo->count_wo_baru();
			$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
			$data['sch_total'] = $this->scheduler_model->sch_total();
			$data['sch_run'] = $this->scheduler_model->sch_run();
			$data['sch_wait'] = $this->scheduler_model->sch_wait();
			$data['menu']  = 'onu_list';
			$data['title'] = 'Data ONU';
			$data['item_olt'] = $this->m_olt->get();
			$data['items'] = $this->m_onu->get();
			
			$this->load->view('backend/header', $data);
				if($this->agent->is_mobile()) { 
				$this->load->view('backend/ONU/index_mobile', $data); 
				}
				else
				{
				$this->load->view('backend/ONU/index', $data); 
				}
			$this->load->view('backend/footer');
		}
    }
	
	
	public function do_filter() {
	    if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }else{
			if (!file_exists(APPPATH.'views/backend/ONU/filter.php')) {
				show_404();
			}
			$data_filter = $this->m_onu->do_filter();
			$data['wo_all'] = $this->m_wo->count_wo_all();
			$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
			$data['wo_baru'] = $this->m_wo->count_wo_baru();
			$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
			$data['sch_total'] = $this->scheduler_model->sch_total();
			$data['sch_run'] = $this->scheduler_model->sch_run();
			$data['sch_wait'] = $this->scheduler_model->sch_wait();
			$data['menu']  = 'onu_list';
			$data['title'] = 'Data ONU';
			$data['item_olt'] = $this->m_olt->get();
			$data['items'] = $data_filter;
			
			$this->load->view('backend/header', $data);
				if($this->agent->is_mobile()) { 
				$this->load->view('backend/ONU/filter', $data); 
				}
				else
				{
				$this->load->view('backend/ONU/filter', $data); 
				}
			$this->load->view('backend/footer');
		}
    }
	
	public function do_scan_sn() {
	    if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
        }else{
			if (!file_exists(APPPATH.'views/backend/ONU/scan_sn.php')) {
				show_404();
			}
			$data_sn = $this->m_onu->do_scan_sn();
			$data['wo_all'] = $this->m_wo->count_wo_all();
			$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
			$data['wo_baru'] = $this->m_wo->count_wo_baru();
			$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
			$data['sch_total'] = $this->scheduler_model->sch_total();
			$data['sch_run'] = $this->scheduler_model->sch_run();
			$data['sch_wait'] = $this->scheduler_model->sch_wait();
			$data['menu']  = 'onu_list';
			$data['title'] = 'Data ONU';
			$data['item_olt'] = $this->m_olt->get();
			$data['items'] = $data_sn;
			
				if($this->agent->is_mobile()) { 
				$this->load->view('backend/ONU/scan_sn', $data); 
				}
				else
				{
				$this->load->view('backend/ONU/scan_sn', $data); 
				}
		}
    }
	
    public function tambah() {
	if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
     }else{
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
			if (!file_exists(APPPATH.'views/backend/OLT/input.php')) {
				show_404();
			}
			$data['wo_all'] = $this->m_wo->count_wo_all();
			$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
			$data['wo_baru'] = $this->m_wo->count_wo_baru();
			$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
			$data['sch_total'] = $this->scheduler_model->sch_total();
			$data['sch_run'] = $this->scheduler_model->sch_run();
			$data['sch_wait'] = $this->scheduler_model->sch_wait();
			$data['items'] = $this->m_onu->get();
			$data['item_pelanggan'] = $this->m_data_pelanggan->get();
			$data['item_olt'] = $this->m_olt->get();
			$data['menu']  = 'onu_list';
			$data['title'] = 'Tambah ONU';
	
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
			$this->load->view('backend/ONU/input', $data);
			$this->load->view('backend/footer', $footer);
			}else{
		redirect('/login', 'refresh');;
		}
	}
    }

    public function simpan() {
	if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
    }else{
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
			if (!file_exists(APPPATH.'views/backend/ONU/input.php')) {
				show_404();
			}
			if ($this->m_onu->simpan()) {
				$this->session->unset_userdata('success');
				$this->session->set_flashdata('success', 'Berhasil menambah data.');
			} else {
				$this->session->unset_userdata('error');
				$this->session->set_flashdata('error', 'Gagal menambah data.');
			}
			redirect('manage/onu');
			}else{
		redirect('/login', 'refresh');;
		}
		}
    }
	
	public function detail($id) {
	if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
    }else{
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
			if (!file_exists(APPPATH.'views/backend/ONU/show.php')) {
				show_404();
			}
			$data['wo_all'] = $this->m_wo->count_wo_all();
			$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
			$data['wo_baru'] = $this->m_wo->count_wo_baru();
			$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
			$data['sch_total'] = $this->scheduler_model->sch_total();
			$data['sch_run'] = $this->scheduler_model->sch_run();
			$data['sch_wait'] = $this->scheduler_model->sch_wait();
			$data['menu']  = 'ONU';
			$data['title'] = 'Detail ONU';
			$data['item'] = $this->m_onu->get($id);
			$data['item_pelanggan'] = $this->m_data_pelanggan->get();
			$data['item_olt'] = $this->m_olt->get();
	
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
			$this->load->view('backend/ONU/show', $data);
			$this->load->view('backend/footer', $footer);
			}else{
		redirect('/login', 'refresh');;
		}
	}
    }
	
    public function ubah($id) {
	if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
    }else{
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
			if (!file_exists(APPPATH.'views/backend/ONU/input.php')) {
				show_404();
			}
			$data['wo_all'] = $this->m_wo->count_wo_all();
			$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
			$data['wo_baru'] = $this->m_wo->count_wo_baru();
			$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
			$data['sch_total'] = $this->scheduler_model->sch_total();
			$data['sch_run'] = $this->scheduler_model->sch_run();
			$data['sch_wait'] = $this->scheduler_model->sch_wait();
			$data['menu']  = 'ONU';
			$data['title'] = 'Ubah Data ONU';
			$data['item'] = $this->m_onu->get($id);
			$data['item_pelanggan'] = $this->m_data_pelanggan->get();
			$data['item_olt'] = $this->m_olt->get();
	
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
			$this->load->view('backend/ONU/input', $data);
			$this->load->view('backend/footer', $footer);
			}else{
		redirect('/login', 'refresh');;
		}
	}
    }

    public function timpa($id) {
	if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
    }else{
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
			if (!file_exists(APPPATH.'views/backend/ONU/input.php')) {
				show_404();
			}
	
			if ($this->m_onu->timpa($id)) {
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
			$data['menu']  = 'ONU';
			$data['title'] = 'Ubah Data ONU';
			$data['item']  = $this->m_onu->timpa($id);
	
			$this->load->view('backend/header', $data);
			$this->load->view('backend/ONU/input', $data);
			$this->load->view('backend/footer');
			}else{
		redirect('/login', 'refresh');;
		}
	}
    }
	
	
    public function hapus($id) {
	if (!$this->session->userdata('masuk')) {
            redirect('/login', 'refresh');
    }else{
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3'){
			if ($this->m_onu->delete($id)) {
				$this->session->unset_userdata('success');
				$this->session->set_flashdata('success', 'Berhasil menghapus data.');
			} else {
				$this->session->unset_userdata('error');
				$this->session->set_flashdata('error', 'Gagal menghapus data.');
			}
	
			redirect('manage/onu');
			}else{
		redirect('/login', 'refresh');;
		}
	}
    }
	
	public function generate($id) {
	if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
        if ($this->m_onu->generate($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil generate data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal generate data.');
        }

        redirect('manage/onu');
		}else{
	redirect('/login', 'refresh');;
	}
    }
	public function unconfig($id) {
	if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
        if ($this->m_onu->unconfig($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil remove konfigurasi.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal remove konfigurasi.');
        }

        redirect('manage/onu');
		}else{
	redirect('/login', 'refresh');;
	}
    }
	
	public function onu_profile($id) {
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'ONU';
        $data['title'] = 'Detail ONU';
        $data['item'] = $this->m_onu->get($id);
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
		$data['item_olt'] = $this->m_olt->get();
		$data['result'] = $this->m_onu->onu_profile($id);

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
        $this->load->view('backend/ONU/show', $data);
        $this->load->view('backend/footer', $footer);
		
		}else{
		redirect('/login', 'refresh');;
		}
    }
	
	public function onu_pon($id) {
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'ONU';
        $data['title'] = 'Detail ONU';
        $data['item'] = $this->m_onu->get($id);
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
		$data['item_olt'] = $this->m_olt->get();
		$data['result'] = $this->m_onu->onu_pon($id);

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
        $this->load->view('backend/ONU/show', $data);
        $this->load->view('backend/footer', $footer);
		
		}else{
		redirect('/login', 'refresh');;
		}
    }
	
	public function onu_detail_log($id) {
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'ONU';
        $data['title'] = 'Detail ONU';
        $data['item'] = $this->m_onu->get($id);
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
		$data['item_olt'] = $this->m_olt->get();
		$data['result'] = $this->m_onu->onu_detail_log($id);

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
        $this->load->view('backend/ONU/show', $data);
        $this->load->view('backend/footer', $footer);
		
		}else{
		redirect('/login', 'refresh');;
		}
    }
	
	function onu_redaman($id){
		//Show Profile
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$identity_OLT = $id_olt['olt_nama']."#";

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
		//Filter 1 Layanan
		if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
			echo "$errstr ($errno)<br />\n";
		}else{
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect($hostname,$username,$password);
			//Cek Redaman
			if ($result == 0)
			{
			$telnet->DoCommand('', $result);
			$telnet->DoCommand('show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
			$telnet->DoCommand('', $result);
			$skuList1 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList1 as $value2)
				{
					if($value2 == 'show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'])
					{ echo""; }
					elseif($value2 == "           OLT                  ONU              Attenuation")
					{ echo""; }
					elseif($value2 == "--------------------------------------------------------------------------")
					{ echo""; }
					elseif($value2 == $identity_OLT)
					{ echo""; }
					else
					{
					$items_onu2[] = $value2;
					}
				}
			}	
			$telnet->DoCommand('show gpon onu detail-info gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
			$skuList2 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList2 as $value1)
				{
				$items_onu[] = $value1;
				}	
			
			$phase_state = explode(" ",$items_onu[9]);
			$get_up_tx = explode(" ",$items_onu2[0]);
			$get_up_rx = explode(" ",$items_onu2[2]);
						
			//print_r($items_onu2);	
			//echo"<br>";
			//print_r($phase);	
			//echo"<br><br>";
			//echo "UP tx:".$up_tx."<br>";
			//echo "DOWN rx:".$down_rx."<br>";
			
			/*
			if(isset($items_onu[9])){
			$phase_state = explode(" ",$items_onu[9]);
				if($phase_state[12] == "LOS"){
				$phase="LOS";
				}elseif($phase_state[12] == "working"){
				$phase="working";
				}elseif($phase_state[12] == "DyingGasp"){
				$phase="DyingGasp";
				}else{
				$phase="Offline";
				}
			}else{
			$phase_state = "Unknown";
			$phase="Offline";
			}
			*/
			
			/*
			if(isset($items_onu2[0])){
			$get_up_tx = explode(" ",$items_onu2[0]);
				if(isset($get_up_tx[8])){
				$up_tx = str_replace(":","",$get_up_tx[8]);
				}else{
				$up_tx = "No Signal";
				}
			}else{
			$get_up_tx="";
			$up_tx = "No Signal";
			}
			
			if(isset($items_onu2[2])){
			$get_up_rx = explode(" ",$items_onu2[2]);
			
				if(isset($get_up_tx[8])){
				$down_rx = str_replace("Rx:","",$get_up_rx[14]);
				}else{
				$down_rx = "No Signal";
				}
			}else{
			$get_up_rx="";
			$down_rx = "No Signal";
			}
			*/
			
			if(isset($get_up_tx[8])){
			$up_tx = str_replace(":","",$get_up_tx[8]);
			}
			if(isset($get_up_rx[14])){
			$down_rx = str_replace("Rx:","",$get_up_rx[14]);
			}

			$telnet->Disconnect();
			
			$data = array(
			'up_tx' => $up_tx,
			'down_rx' => $down_rx,
			'phase_state' => $phase_state[12],
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
			);	
			$this->db->where('id', $id);
			return $this->db->update('blip_onu', $data);
		}
	}
	
	public function redaman($id) {			
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		$data['menu']  = 'ONU';
		$data['title'] = 'Detail ONU';
		$data['item'] = $this->m_onu->get($id);
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
		$data['item_olt'] = $this->m_olt->get();

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
		
		$this->onu_redaman($id);
		redirect('/manage/onu/'.$id.'/detail', 'refresh');
		//$this->load->view('backend/header', $data);
		//$this->load->view('backend/ONU/show', $data);
		//$this->load->view('backend/footer', $footer);
		
		}else{
		redirect('/login', 'refresh');;
		}
    }
	public function remove_xcek_onu() {
		$tb_onu = array(
		'xcek' => "0",
		);	
		return $this->db->update('blip_onu', $tb_onu);
	}
	public function grab_onu_all() {
		$this->db->select('*');
		$this->db->from('blip_onu');
		//$this->db->limit(1, 1);
		$this->db->order_by("id", "desc");
		$query = $this->db->get();
		$response = $query->result_array();
		foreach($response as $data){
			$mon = array(
			'id_onu' => $data['id'],
			'status' => "0",
			);	
				$this->db->insert('blip_mon_onu', $mon);
			}
	}
	
	public function grab_onu() {
		$this->db->select('*');
		$this->db->from('blip_onu');
		//$this->db->limit(1, 1);
		$this->db->where("up_tx", "No Signal");
		$this->db->order_by("id", "asc");
		$query = $this->db->get();
		$response = $query->result_array();
	
		foreach($response as $data){
		$data_exist = $this->db->get_where('blip_mon_onu', array('id_onu' => $data['id']))->num_rows();
			//if($data['xcek'] == "0"){
			$mon = array(
			'id_onu' => $data['id'],
			'status' => "0",
			);	
				if($data_exist == 0){
				$this->db->insert('blip_mon_onu', $mon);
				}
			//}
		}
	}
	
	public function refresh_redaman() {
		$this->db->select('*');
		$this->db->from('blip_mon_onu');
		$this->db->where("status","0");
		$this->db->limit(1, 0);
		$this->db->order_by("id", "asc");
		$query = $this->db->get();
		$response = $query->row_array();
		
		//Get Onu
		$id_onu = $this->db->get_where('blip_onu', array('id' => $response['id_onu']))->row_array();
		
		if($this->onu_redaman($id_onu['id'])){
			if($id_onu['up_tx'] == "No Signal"){
				$tb_onu = array(
				'xcek' => "0",
				);	
				$this->db->where('id', $id_onu['id']);
				$exeupdate_onu = $this->db->update('blip_onu', $tb_onu);
				if($exeupdate_onu){
					$tb_mon = array(
					'status' => "1",
					);	
					$this->db->where('id', $response['id']);
					echo $id_onu['up_tx']."<br><br>";
					return $this->db->update('blip_mon_onu', $tb_mon);
					}
			}else{
				$tb_onu = array(
				'xcek' => "1",
				);	
				$this->db->where('id', $id_onu['id']);
				$exeupdate_onu = $this->db->update('blip_onu', $tb_onu);
				
				if($exeupdate_onu){
					$tb_mon = array(
					'status' => "1",
					);	
					$this->db->where('id', $response['id']);
					echo $id_onu['up_tx']."<br><br>";
					return $this->db->update('blip_mon_onu', $tb_mon);
					}
			}	
		}else{
		echo "GAGAL";
		}	
	}
	
	public function remove_mon_onu() {
		$this->db->select('*');
		$this->db->from('blip_mon_onu');
		$this->db->where('status','1');
		$query = $this->db->get();
		$response = $query->row_array();
		return $this->db->delete('blip_mon_onu', array('id' => $response['id']));
	}
	
	function do_export($fileName,$bsc = false) {
		//if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3'){
		date_default_timezone_set("Asia/Singapore");
		
		$xls = $this->m_onu->get_export($bsc);
		$tanggal = date("Y-m-d H:i:s");
		$user_exe = $this->session->userdata('ses_nama');
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		//$spreadsheet->getActiveSheet()->getStyle('A1:J10')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
		$header = [
					'alignment' => [
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
					],
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000'],
						],
					],
					'font' => array('bold' => true),
				];
		//horizontal center
		$horizontalCenter = [
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000'],
						],
			],
		];
		//horizontal left
		$horizontalLeft = [
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
			],
			'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000'],
						],
			],
		];
		
		
		$sheet = $spreadsheet->getActiveSheet();
		
		//title
		$sheet->setCellValue('A1', "Data Preventive ONU");
		$sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
					
		$sheet->setCellValue('A2', "Tanggal Export: ".$tanggal);
		$sheet->mergeCells('A2:E2'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A2')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		
		$sheet->setCellValue('A3', "Export by: ".$user_exe);
		$sheet->mergeCells('A3:E3'); // Set Merge Cell pada kolom A1 sampai E1
		$sheet->getStyle('A3')->getFont()->setBold(TRUE); // Set bold kolom A1
		$sheet->getStyle('A3')->getFont()->setSize(11); // Set font size 15 untuk kolom A1
		$sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		
		
		$sheet->setCellValue('A6', 'No');
		$sheet->setCellValue('B6', 'Pelanggan');
		$sheet->setCellValue('C6', 'PON');
		$sheet->setCellValue('D6', 'Redaman TX');
		$sheet->setCellValue('E6', 'Redaman RX');
		
		
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);
		$sheet->getColumnDimension('D')->setAutoSize(true);
		$sheet->getColumnDimension('E')->setAutoSize(true);

		
		$sheet->getStyle('A6')->applyFromArray($header);
		$sheet->getStyle('B6')->applyFromArray($header);
		$sheet->getStyle('C6')->applyFromArray($header);
		$sheet->getStyle('D6')->applyFromArray($header);
		$sheet->getStyle('E6')->applyFromArray($header);


		$rows = 7;
		$no = 1;
		foreach ($xls as $data){
		$this->load->database();
		
		$pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $data['id_pelanggan']))->row_array();
		$layanan = $this->db->get_where('blip_layanan', array('id' => $data['id_layanan1']))->row_array();
		
		$sheet->setCellValue('A' . $rows, $no);
		$sheet->setCellValue('B' . $rows, $pelanggan['nama']);
		$sheet->setCellValue('C' . $rows, $layanan['pon'].":".$data['onu_index']);
		$sheet->setCellValue('D' . $rows, $data['up_tx']);
		$sheet->setCellValue('E' . $rows, $data['down_rx']);

		
			
			$sheet->getStyle('A'.$rows.':E'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('B'.$rows.':E'.$rows)->applyFromArray($horizontalLeft);
			$sheet->getStyle('C'.$rows.':E'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('D'.$rows.':E'.$rows)->applyFromArray($horizontalCenter);
			$sheet->getStyle('E'.$rows.':E'.$rows)->applyFromArray($horizontalCenter);

			
			$rows++;
			$no++;
		} 

		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/onu";
		$writer = new Xlsx($spreadsheet);
		$writer->save($filelocation."/".$fileName);
		header("Content-Type: application/vnd.ms-excel");
		
		$api_path = base_url('xdark/doc/onu/'.$fileName);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_path);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch,CURLOPT_POSTFIELDS);
		curl_exec($ch);
		//redirect(base_url('xdark/doc/onu/').$fileName);
	}
	
		
	public function export() {
		date_default_timezone_set("Asia/Singapore");
		$this->do_export("Data Preventive ONU -".date("Y-m-d H:i:s")."-by-".$this->session->userdata('ses_nama').".xlsx");
		}
	
	public function report_onu_mtr() {;
		date_default_timezone_set("Asia/Singapore");
		$fileName = "Data Preventive OLT BSC NUTANA -".date("Y-m-d H:i:s")."-by-".$this->session->userdata('ses_nama').".xlsx";
		$doexp = $this->do_export($fileName,"2");
		$onu_tg = $this->m_onu->get_report_onu_tg_mtr();	
		$this->telegram_lib->sendblip_doc("-901753609","/home/admin/web/arrayyan.web.id/public_html/xdark/doc/onu/".$fileName,$onu_tg);
	}
	public function report_onu_pmg() {
		$onu_wa = $this->m_wo->get_wo_proses_wa();
		date_default_timezone_set("Asia/Singapore");
		$fileName = "Data Preventive OLT BSC PEMENANG -".date("Y-m-d H:i:s")."-by-".$this->session->userdata('ses_nama').".xlsx";
		$doexp = $this->do_export($fileName,"1");
		$onu_tg = $this->m_onu->get_report_onu_tg_pmg();	
		$this->telegram_lib->sendblip_doc("-901753609","/home/admin/web/arrayyan.web.id/public_html/xdark/doc/onu/".$fileName,$onu_tg);
	}
	public function onu_reboot($id) {
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
        $data['menu']  = 'ONU';
        $data['title'] = 'Detail ONU';
        $data['item'] = $this->m_onu->get($id);
		$data['item_pelanggan'] = $this->m_data_pelanggan->get();
		$data['item_olt'] = $this->m_olt->get();
		$data['result'] = $this->m_onu->onu_reboot($id);

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
        $this->load->view('backend/ONU/show', $data);
        $this->load->view('backend/footer', $footer);
		
		}else{
		redirect('/login', 'refresh');;
		}
    }
	public function onu_port($id,$port,$act) {
		if($this->session->userdata('ses_admin')=='1' ||  $this->session->userdata('ses_admin')=='3' ||  $this->session->userdata('ses_admin')=='5'){

        if ($this->m_onu->onu_port($id,$port,$act)) {
				$this->session->unset_userdata('success');
				$this->session->set_flashdata('success', 'Update '.$act.' port '.$port.' berhasil');
			} else {
				$this->session->unset_userdata('error');
				$this->session->set_flashdata('error', 'Update '.$act.' port '.$port.' gagal !!!');
			}
		redirect('/manage/onu/'.$id.'/detail', 'refresh');
		}else{
		redirect('/login', 'refresh');;
		}
    }
	
	public function onu_test($id){
		//Show Profile
		$id_onu = $this->db->get_where('blip_onu', array('id' => $id))->row_array();
		$id_olt = $this->db->get_where('blip_olt', array('id' => $id_onu['id_olt']))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$identity_OLT = $id_olt['olt_nama']."#";

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
		//Filter 1 Layanan
		if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
			echo "$errstr ($errno)<br />\n";
		}else{
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect($hostname,$username,$password);
			//Cek Redaman
			if ($result == 0)
			{
	
			$telnet->DoCommand('show gpon onu sta gpon-olt_'.$id_layanan['pon'].' '.$id_onu['onu_index'], $result);
			$skuList2 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList2 as $value1)
				{
				$items_onu[] = $value1;
				}	
			
			$phase_state = explode(" ",$items_onu[3]);
			//$get_up_tx = explode(" ",$items_onu2[0]);
			//$get_up_rx = explode(" ",$items_onu2[2]);
						
			//print_r($items_onu2);	
			//echo"<br>";
			//print_r($phase);	
			//echo"<br><br>";
			//echo "UP tx:".$up_tx."<br>";
			//echo "DOWN rx:".$down_rx."<br>";
			
			/*
			if(isset($items_onu[9])){
			$phase_state = explode(" ",$items_onu[9]);
				if($phase_state[12] == "LOS"){
				$phase="LOS";
				}elseif($phase_state[12] == "working"){
				$phase="working";
				}elseif($phase_state[12] == "DyingGasp"){
				$phase="DyingGasp";
				}else{
				$phase="Offline";
				}
			}else{
			$phase_state = "Unknown";
			$phase="Offline";
			}
			*/
			
			/*
			if(isset($items_onu2[0])){
			$get_up_tx = explode(" ",$items_onu2[0]);
				if(isset($get_up_tx[8])){
				$up_tx = str_replace(":","",$get_up_tx[8]);
				}else{
				$up_tx = "No Signal";
				}
			}else{
			$get_up_tx="";
			$up_tx = "No Signal";
			}
			
			if(isset($items_onu2[2])){
			$get_up_rx = explode(" ",$items_onu2[2]);
			
				if(isset($get_up_tx[8])){
				$down_rx = str_replace("Rx:","",$get_up_rx[14]);
				}else{
				$down_rx = "No Signal";
				}
			}else{
			$get_up_rx="";
			$down_rx = "No Signal";
			}
			*/
			$telnet->Disconnect();	
			print($phase_state[18]);
			}
		}
	}
	
	public function onu_redaman_all_mtr(){
		//Show Profile
		$id_olt = $this->db->get_where('blip_olt', array('id' => "2"))->row_array();
		$id_layanan = $this->db->get_where('blip_layanan', array('id' => $id_onu['id_layanan1']))->row_array();
		$identity_OLT = $id_olt['olt_nama']."#";

		$hostname = $this->secure->decrypt_url($id_olt['olt_ip']);
		$username = $this->secure->decrypt_url($id_olt['olt_user']);
		$password = $this->secure->decrypt_url($id_olt['olt_pwd']);
		
		//Filter 1 Layanan
		if (fsockopen($hostname, 22, $errno, $errstr, 30) == NULL){
			echo "$errstr ($errno)<br />\n";
		}else{
			$this->load->library('phptelnet');
			$telnet = new PHPTelnet();
			$result = $telnet->Connect($hostname,$username,$password);
			//Cek Redaman
			if ($result == 0)
			{
			$telnet->DoCommand('', $result);
			$telnet->DoCommand('show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
			$telnet->DoCommand('', $result);
			$skuList1 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList1 as $value2)
				{
					if($value2 == 'show pon power attenuation gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'])
					{ echo""; }
					elseif($value2 == "           OLT                  ONU              Attenuation")
					{ echo""; }
					elseif($value2 == "--------------------------------------------------------------------------")
					{ echo""; }
					elseif($value2 == $identity_OLT)
					{ echo""; }
					else
					{
					$items_onu2[] = $value2;
					}
				}
			}	
			$telnet->DoCommand('show gpon onu detail-info gpon-onu_'.$id_layanan['pon'].':'.$id_onu['onu_index'], $result);
			$skuList2 = preg_split('/\r\n|\r|\n/', $result);
				foreach($skuList2 as $value1)
				{
				$items_onu[] = $value1;
				}	
			
			$phase_state = explode(" ",$items_onu[9]);
			$get_up_tx = explode(" ",$items_onu2[0]);
			$get_up_rx = explode(" ",$items_onu2[2]);

			if(isset($get_up_tx[8])){
			$up_tx = str_replace(":","",$get_up_tx[8]);
			}
			if(isset($get_up_rx[14])){
			$down_rx = str_replace("Rx:","",$get_up_rx[14]);
			}

			$telnet->Disconnect();
			
			$data = array(
			'up_tx' => $up_tx,
			'down_rx' => $down_rx,
			'phase_state' => $phase_state[12],
			'history_waktu' => date("Y-m-d H:i"),
			'history_iduser' => $this->session->userdata('ses_id'),
			);	
			$this->db->where('id', $id);
			return $this->db->update('blip_onu', $data);
		}
	}
}
}