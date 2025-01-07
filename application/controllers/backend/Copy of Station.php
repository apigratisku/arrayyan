<?php

class Station extends CI_Controller {

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
        if (!file_exists(APPPATH.'views/backend/station/index.php')) {
            show_404();
        }

        $data['menu']  = 'station';
        $data['title'] = 'Station Pelanggan';
        $data['items'] = $this->station_model->get();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) 
			{ 
			$this->load->view('backend/station/index_mobile', $data); 
			} 
			else 
			{
			$this->load->view('backend/station/index', $data); 
			} 
		
		}
		else 
		{
		 redirect('manage/router/'.$this->session->userdata('idrouter')); 
		} 
    }
	
	public function station() {
			if (!file_exists(APPPATH.'views/backend/station/index.php')) {
            show_404();
        }

        $data['menu']  = 'station';
        $data['title'] = 'Station Pelanggan';
        $data['items'] = $this->station_model->get();
		$data['wo_all'] = $this->m_wo->count_wo_all();
		$data['wo_selesai'] = $this->m_wo->count_wo_selesai();
		$data['wo_baru'] = $this->m_wo->count_wo_baru();
        
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2')
		{ 
			if($this->agent->is_mobile()) 
			{ 
			$this->load->view('backend/header_mobile', $data);
			$this->load->view('backend/station/station', $data); 
			} 
			else 
			{
			$this->load->view('backend/header', $data);
			$this->load->view('backend/station/station', $data); 
			} 
		
		}
		else 
		{
		 redirect('manage/router/'.$this->session->userdata('idrouter')); 
		} 
        $this->load->view('backend/footer');

    }

 public function hapus($id) {
		if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='2'){ 
        if ($this->station_model->delete($id)) {
            $this->session->unset_userdata('success');
            $this->session->set_flashdata('success', 'Berhasil menghapus data.');
        } else {
            $this->session->unset_userdata('error');
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }

        redirect('manage/station'); }
    }
	
	public function export() {
        $items = $this->station_model->getEXPORT();
        $tanggal = date('d-m-Y');
 
        $pdf = new \TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(115, 0, "NOC - Pengecekan link WE - ".$tanggal, 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 10);
		$pdf->Cell(15, 8, "No", 1, 0, 'C');
        $pdf->Cell(55, 8, "Tanggal", 1, 0, 'C');
        $pdf->Cell(70, 8, "Pelanggan", 1, 0, 'C');
        $pdf->Cell(15, 8, "Sinyal", 1, 0, 'C');
        $pdf->Cell(15, 8, "CCQ", 1, 0, 'C');
        $pdf->Cell(15, 8, "Kualitas", 1, 1, 'C');
        $pdf->SetFont('', '', 10);
		$no = 1;
        foreach($items->result_array() as $k => $item) {
            $this->addRow($pdf, $k+1, $item);
			$no++;
        }
        $tanggal = date('d-m-Y');
        $pdf->Output('NOC - Pengecekan link WE - '.$tanggal.'.pdf'); 
    }
 
    private function addRow($pdf, $no, $item) {
		$pdf->Cell(15, 8, $no, 1, 0, 'C');
        $pdf->Cell(55, 8, $item['waktu'], 1, 0, 'C');
        $pdf->Cell(70, 8, $item['pelanggan'], 1, 0, '');
        $pdf->Cell(15, 8, $item['sinyal'], 1, 0, 'C');
        $pdf->Cell(15, 8, $item['ccq'], 1, 0, 'C');
        $pdf->Cell(15, 8, $item['kualitas'], 1, 1, 'C');
    }
	
	public function autoreport_station() {
        $items = $this->station_model->getEXPORT();
        $tanggal = date('d-m-Y');
 
        $pdf = new \TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('', 'B', 20);
        $pdf->Cell(115, 0, "NOC - Pengecekan link WE - ".$tanggal, 0, 1, 'L');
		$pdf->Cell(115, 0, "PT. Media Sarana Data (GMEDIA)", 0, 1, 'L');
        $pdf->SetAutoPageBreak(true, 0);
 
        // Add Header
        $pdf->Ln(10);
        $pdf->SetFont('', 'B', 10);
		$pdf->Cell(15, 8, "No", 1, 0, 'C');
        $pdf->Cell(55, 8, "Tanggal", 1, 0, 'C');
        $pdf->Cell(70, 8, "Pelanggan", 1, 0, 'C');
        $pdf->Cell(15, 8, "Sinyal", 1, 0, 'C');
        $pdf->Cell(15, 8, "CCQ", 1, 0, 'C');
        $pdf->Cell(15, 8, "Kualitas", 1, 1, 'C');
        $pdf->SetFont('', '', 10);
		$no = 1;
        foreach($items->result_array() as $k => $item) {
            $this->addRowEX($pdf, $k+1, $item);
			$no++;
        }
        $tanggal = date('d-m-Y');
		$filelocation = $_SERVER['DOCUMENT_ROOT']."/xdark/doc/station";
		$fileNL = $filelocation."/NOC - Pengecekan link WE - ".$tanggal.".pdf";
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
		
		$this->telegram_lib->senddoc($_SERVER['DOCUMENT_ROOT']."/xdark/doc/station/NOC - Pengecekan link WE - ".$tanggal.".pdf","\n\nReport Station WE  \n=========================== \nPT. Media Sarana Data (GMEDIA)");
		
		
    }
 
    private function addRowEX($pdf, $no, $item) {
		$pdf->Cell(15, 8, $no, 1, 0, 'C');
        $pdf->Cell(55, 8, $item['waktu'], 1, 0, 'C');
        $pdf->Cell(70, 8, $item['pelanggan'], 1, 0, '');
        $pdf->Cell(15, 8, $item['sinyal'], 1, 0, 'C');
        $pdf->Cell(15, 8, $item['ccq'], 1, 0, 'C');
        $pdf->Cell(15, 8, $item['kualitas'], 1, 1, 'C');
    }

}
