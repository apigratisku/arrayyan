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
class Bts extends CI_Controller {

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
        if (!file_exists(APPPATH.'views/backend/bts/index.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();

        $data['menu']  = 'bts';
        $data['title'] = 'Data BTS';
        $data['items'] = $this->bts_model->get();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5' || $this->session->userdata('ses_admin')=='6')
		{ 

			$this->load->view('backend/header', $data);
			$this->load->view('backend/bts/index', $data); 
			$this->load->view('backend/footer');
		}
		else 
		{
		show_404(); 
		} 
        
    }

    public function tambah() {
        if (!file_exists(APPPATH.'views/backend/bts/input.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();

        $data['menu']  = 'bts';
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
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
		$this->load->view('backend/header', $data);
        $this->load->view('backend/bts/input', $data);
        $this->load->view('backend/footer', $footer);
		}
		else{
		show_404();
		}
    }

    public function simpan() {
        if (!file_exists(APPPATH.'views/backend/bts/input.php')) {
            show_404();
        }
		
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
        if ($this->bts_model->simpan()) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menambah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menambah data.');
        }
		redirect('manage/bts');
		}else{
		show_404();
		}
        
    }

    public function ubah($id) {
        if (!file_exists(APPPATH.'views/backend/bts/input2.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();
		
        $data['menu']  = 'bts';
        $data['title'] = 'Ubah Data';
        $data['item']  = $this->bts_model->get($id);
		
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
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
		$this->load->view('backend/header', $data);
        $this->load->view('backend/bts/input2', $data);
        $this->load->view('backend/footer', $footer);
		}else{
		show_404();
		}
    }

    public function timpa($id) {
        if (!file_exists(APPPATH.'views/backend/bts/input2.php')) {
            show_404();
        }
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
        if ($this->bts_model->timpa($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil mengubah data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal mengubah data.');
        }

        redirect('manage/bts');
		}else{
		show_404();
		}
    }
	
	
    public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
        if ($this->bts_model->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/bts'); 
		}else{
		show_404();
		}
    }
	
	public function maintenance() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
		$this->bts_model->maintenance();

        redirect('manage/bts/maintenance_result');
		}else{
		show_404();
		}
    }
	public function reload() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
		$this->bts_model->reload();

        redirect('manage/bts/');
		}else{
		show_404();
		}
    }
	
	
	public function backup() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 

		$this->bts_model->backup();

        redirect('manage/bts');
		}else{
		show_404();
		}
    }
	
	public function maintenance_result() {
			if (!file_exists(APPPATH.'views/backend/bts/maintenance_result.php')) {
            show_404();
        }
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
		$data['jumlah_pelanggan'] = $this->m_data_pelanggan->count();
		$data['sch_total'] = $this->scheduler_model->sch_total();
		$data['sch_run'] = $this->scheduler_model->sch_run();
		$data['sch_wait'] = $this->scheduler_model->sch_wait();

        $data['menu']  = 'bts';
        $data['title'] = 'Radio BTS - Maintenance';
        $data['items'] = $this->bts_model->get();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
			$this->load->view('backend/header', $data);
			$this->load->view('backend/bts/maintenance_result', $data); 
			$this->load->view('backend/footer');
		}else{
		show_404();
		}
    }
	public function export() {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'){ 
        $items = $this->bts_model->getEXPORT();
        $tanggal = date('d-m-Y');
 
        $pdf = new \TCPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
        $pdf->AddPage();
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(115, 0, "NOC - Pengecekan Frequency WE BTS - ".$tanggal, 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 9);
		$pdf->Cell(12, 8, "No", 1, 0, 'C');
        $pdf->Cell(42, 8, "Tanggal", 1, 0, 'C');
        $pdf->Cell(30, 8, "BTS", 1, 0, 'C');
        $pdf->Cell(70, 8, "Sektor", 1, 0, 'C');
        $pdf->Cell(30, 8, "IP", 1, 0, 'C');
		$pdf->Cell(25, 8, "Band", 1, 0, 'C');
		$pdf->Cell(25, 8, "Protocol", 1, 0, 'C');
        $pdf->Cell(25, 8, "Freq", 1, 0, 'C');
		$pdf->Cell(20, 8, "Status WE", 1, 1, 'C');
		
        $pdf->SetFont('', '', 10);
		$no = 1;
        foreach($items->result_array() as $k => $item) {
            $this->addRow($pdf, $k+1, $item);
			$no++;
        }
        $tanggal = date('d-m-Y');
        $pdf->Output('NOC - Pengecekan Frequency WE - '.$tanggal.'.pdf'); 
		}else{
		show_404();
		}
    }
 
    private function addRow($pdf, $no, $item) {
		if($item['we_status'] == "false") {$we_status = "enable";} else {$we_status = "disable";}
		$pdf->Cell(12, 8, $no, 1, 0, 'C');
        $pdf->Cell(42, 8, $item['waktu'], 1, 0, 'C');
        $pdf->Cell(30, 8, $item['nama_bts'], 1, 0, 'C');
        $pdf->Cell(70, 8, $item['sektor_bts'], 1, 0, 'C');
        $pdf->Cell(30, 8, $item['ip'], 1, 0, 'C');
		$pdf->Cell(25, 8, $item['band'], 1, 0, 'C');
        $pdf->Cell(25, 8, $item['b4_protocol']." / ".$item['protocol'], 1, 0, 'C');
		$pdf->Cell(25, 8, $item['b4_frek']." / ".$item['frek'], 1, 0, 'C');
		$pdf->Cell(20, 8, $we_status, 1, 1, 'C');
    }
	
	public function autoreport_station() {
        $items = $this->station_model->getEXPORT();
        $tanggal = date('d-m-Y');
 
        $pdf = new \TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(115, 0, "NOC - Pengecekan Frequency WE - ".$tanggal, 0, 1, 'L');
		$pdf->Cell(115, 0, "PT. Media Sarana Data (GMEDIA)", 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 10);
		$pdf->Cell(12, 8, "No", 1, 0, 'C');
        $pdf->Cell(42, 8, "Tanggal", 1, 0, 'C');
        $pdf->Cell(25, 8, "BTS", 1, 0, 'C');
        $pdf->Cell(50, 8, "Sektor", 1, 0, 'C');
        $pdf->Cell(25, 8, "IP", 1, 0, 'C');
        $pdf->Cell(25, 8, "Freq", 1, 0, 'C');
        $pdf->SetFont('', '', 10);
		$no = 1;
        foreach($items->result_array() as $k => $item) {
            $this->addRowEX($pdf, $k+1, $item);
			$no++;
        }
        $tanggal = date('d-m-Y');
		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/bts";
		$fileNL = $filelocation."/NOC - Pengecekan Frequency WE - ".$tanggal.".pdf";
        $pdf->Output($fileNL, 'F'); 
		//$file_location = $_SERVER['DOCUMENT_ROOT']."/gmedia_absensi/doc/report/Report Absensi - ".$tanggal.".pdf";
		//file_put_contents($file_location,$pdf); 
		//$this->telegram_lib->sendmsg($data['nama']." ".$data['status']." ".$data['check_inout']."\n");
		//if(date("H") <= 8 && date("i") <= 30)
		/*if(date("H") <= 9)
		{
		$this->telegram_lib->senddoc($_SERVER['DOCUMENT_ROOT']."/gmedia_absensi/doc/report/Report Absensi - ".$tanggal.".pdf","\n\nReport Absensi Masuk Karyawan \n=============================== \nPT. Media Sarana Data (GMEDIA)");
		}
		else
		{
		$this->telegram_lib->senddoc($_SERVER['DOCUMENT_ROOT']."/gmedia_absensi/doc/report/Report Absensi - ".$tanggal.".pdf","\n\nReport Absensi Pulang Karyawan \n=============================== \nPT. Media Sarana Data (GMEDIA)");
		}*/
		
		//$this->telegram_lib->senddoc($_SERVER['DOCUMENT_ROOT']."/xdark/doc/bts/NOC - Pengecekan Frequency WE - ".$tanggal.".pdf","\n\nReport Frequency WE  \n=========================== \nPT. Media Sarana Data (GMEDIA)");
		
		
    }
 
    private function addRowEX($pdf, $no, $item) {
		$pdf->Cell(12, 8, $no, 1, 0, 'C');
        $pdf->Cell(42, 8, $item['waktu'], 1, 0, 'C');
        $pdf->Cell(25, 8, $item['nama_bts'], 1, 0, '');
        $pdf->Cell(50, 8, $item['sektor_bts'], 1, 0, 'C');
        $pdf->Cell(25, 8, $item['ip'], 1, 0, 'C');
        $pdf->Cell(25, 8, $item['frek'], 1, 1, 'C');
    }
	
}
}