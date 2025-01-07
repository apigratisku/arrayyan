<?php

class Singleconn extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->library('TCPDF');
		$this->load->library('user_agent');
    }

    public function prtg() {
		date_default_timezone_set("Asia/Singapore");	
		//Sent Telegram
		$pesan_tg = "<b>[Informasi Link - PRTG Monitoring]</b>\n";
		$pesan_tg .= "<b>==========================================</b>\n";
		$pesan_tg .= "Link ID: <b>".$this->input->post('sitename')."</b>\nStatus: <b>".$this->input->post('status')."</b>\nWaktu Start: <b>".date("d-F-Y H:i:s")."</b>\nMessage: <b>".$this->input->post('message')."</b>\n\n";
		$pesan_tg .= "Regards,\n<b>Blippy Assistant</b>";
		$this->telegram_lib->sendblip("-1001406929911",$pesan_tg);
		
    }

}
