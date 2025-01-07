<?php

class OLT_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
	public function get_result($id) {
	$this->load->library('phptelnet');
		$telnet = new PHPTelnet();
		$result = $telnet->Connect('10.247.0.22','adhit',base64_decode(base64_decode("VFhSeVRXRnpkV3NxTVRJekl3PT0=")));
        if ($result == 0)
		{
		$count_olt = 12;
		$telnet->DoCommand('show gpon onu state gpon-olt_1/1/'.$id, $result);
		$skuList = preg_split('/\r\n|\r|\n/', $result);
			foreach($skuList as $key => $value )
			{
			if($value == "show gpon onu state gpon-olt_1/1/".$id."")
			{ echo""; }
			elseif(strpos($value,'OMCC'))
			{ echo""; }
			elseif($value == "--------------------------------------------------------------")
			{ echo""; }
			elseif($value == "OLT-ZTE-GMEDIA-PMG#")
			{ echo""; }
			elseif(strpos($value,'Number:'))
			{ echo""; }
			else
			{
			//$find = strpos($value,'1(GPON)');
			$modifstr = str_replace("1(GPON)", "",$value);
			$items_onu[] = $modifstr;
			}
		}
		//DC Telnet
		//$telnet->Disconnect();
		//Output ONU ke Telegram
		//Explode data Capel
		/*$capel = "";
		for($msgcapel=6; $msgcapel <= $msgcount;)
		{
		
			$capel .= "$msgdata[$msgcapel] ";
			$msgcapel++;
		}*/
		
		
		
		//SCRIPT OLT GPON
		$output="";
		foreach($items_onu as $onu )
		{
			$output.= $onu."<br>";
			
			//Manipulasi string
			$str_olt = explode(" ", $onu);
			//print_r($str_olt);
			if(!empty($str_olt[16])) {$status = $str_olt[16];}elseif(!empty($str_olt[17])) {$status = $str_olt[17];} elseif(!empty($str_olt[18])) {$status = $str_olt[18];} elseif($str_olt[0] == "%Code") {$status = "KOSONG";} else{$status = "KOSONG";}
			if($str_olt[0] != "%Code") {$onuvalue = $str_olt[0];} else {$onuvalue = "KOSONG";}
			
			
			//SCRIPT ONU POWER DB
			$telnet->DoCommand('show pon power attenuation gpon-onu_'.$onuvalue, $result);
			$skuList = preg_split('/\r\n|\r|\n/', $result);
			foreach($skuList as $key => $value )
			{
				$onupower[] = $value;
				//print_r($onupower)."<br><br>";
				if($value == "show pon power attenuation gpon-onu_/".$onuvalue."")
				{ echo""; }
				elseif(strpos($value,"OLT"))
				{ echo""; }
				elseif(strpos($value,"ONU"))
				{ echo""; }
				elseif(strpos($value,"Attenuation"))
				{ echo""; }
				elseif(strpos($value,"OLT ONU Attenuation"))
				{ echo""; }
				elseif($value == "--------------------------------------------------------------------------")
				{ echo""; }
				else
				{
					$items_onu_power[] = $value;
					
				}
			}
			//SCRIPT OLT GPON
					$output_power="";
					foreach($items_onu_power as $power)
					{
						$output_power.= $power."<br>";
					}
			
			
			
			//Save to DB
			$this->load->database();
			$this->db->reconnect();	
			$data = array(
				'onu' => $onuvalue,
				'rx_olt' => "",
				'rx_onu' => "",
				'status' => $status,
				);
			if(!empty($onuvalue) && $onuvalue != "KOSONG")
			{
			$query1 = $this->db->get_where('gm_olt', array('onu' => $str_olt[0]));
			$query = $this->db->escape($query1);
        	$count = $query->num_rows();
				if ($count == 0) {
				$this->db->insert('gm_olt', $data);
				}
				else
				{
				$this->db->where('onu', $str_olt[0]); $this->db->update('gm_olt', $data);
				}
			}
		}
		
		//Manipulasi string total ONU Aktif/Offline/DyingGasp/LOS
		foreach($items_onu as $onustr )
		{
			if(strpos($onustr,'DyingGasp'))
			{ $items_onu_poweroff[] = $onustr."<br>"; }
			elseif(strpos($onustr,'LOS'))
			{ $items_onu_los[] = $onustr."<br>"; }
			elseif(strpos($onustr,'OffLine'))
			{ $items_onu_OffLine[] = $onustr."<br>"; }
			elseif(strpos($onustr,'working'))
			{ $items_onu_working[] = $onustr."<br>"; }
		
		}
		
		
		
		//Hitung total ONU		
		if(!empty($items_onu_poweroff)) {$len_poweroff = count($items_onu_poweroff);} else {$len_poweroff = 0;}
		if(!empty($items_onu_los)) {$len_los = count($items_onu_los);} else {$len_los = 0;}
		if(!empty($items_onu_OffLine)) {$len_offline = count($items_onu_OffLine);} else {$len_offline = 0;}
		if(!empty($items_onu_working)) {$len_working = count($items_onu_working);} else {$len_working = 0;}
		if(empty($len_working)) {$len_aktif = 0;} else {$len_aktif = count($items_onu);}
		$this->load->database();
		$this->db->reconnect();		
		//Reply to Telegram
		return print $output."<br>Total Onu: ".$len_aktif."<br>Aktif: ".$len_working."<br>Offline: ".$len_offline."<br>Power Off: ".$len_poweroff."<br>LOS: ".$len_los."<br><br>".$output_power;
	}
	}
//END	





//NEW
	public function get($id=false) {
        $response = false;

        if ($id) {
            $query = $this->db->get_where('blip_olt', array('id' => $id));
            $response = $query->row_array();
        } else {
            $this->db->select('*');
            $this->db->from('blip_olt');
			$this->db->order_by("id", "asc");
            $query = $this->db->get();
            $response = $query->result_array();
        }

        return $response;
    }
	public function count() {
        return $this->db->get('blip_olt')->num_rows();
    }
	public function delete($id) {			
        return $this->db->delete('blip_olt', array('id' => $id));
    }
	public function simpan() {
		//ENKRIPSI PASSWORD
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_ip = $this->input->post('ip');
		$ar_enc_ip = $ar_chip->encrypt($ar_str_ip, $ar_rand);
		$ar_str_user = $this->input->post('user');
		$ar_enc_user = $ar_chip->encrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $this->input->post('pass');
		$ar_enc_pass = $ar_chip->encrypt($ar_str_pass, $ar_rand);
		$hostname = $ar_enc_ip;
		$username = $ar_enc_user;
		$password = $ar_enc_pass;		
				
				$data = array(
				'olt_nama' => $this->input->post('nama'),
				'olt_brand' => $this->input->post('brand'),
				'olt_ip' => $ar_enc_ip,
				'olt_user' => $ar_enc_user,
				'olt_pwd' => $ar_enc_pass,
				'olt_uptime' => "",
				);				
				$this->db->insert('blip_olt', $data);

		return $this->session->set_flashdata('success', 'Berhasil menambah data.');
    }
	
	public function timpa($id) {
        //ENKRIPSI PASSWORD
		require_once APPPATH."third_party/addon.php";
		$ar_chip 	 = new Cipher(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$ar_rand 	 = "%^$%^&%*GMEDIA%^$%^&%*";
		$ar_str_ip = $this->input->post('ip');
		$ar_enc_ip = $ar_chip->encrypt($ar_str_ip, $ar_rand);
		$ar_str_user = $this->input->post('user');
		$ar_enc_user = $ar_chip->encrypt($ar_str_user, $ar_rand);
		$ar_str_pass = $this->input->post('pass');
		$ar_enc_pass = $ar_chip->encrypt($ar_str_pass, $ar_rand);
		$hostname = $ar_enc_ip;
		$username = $ar_enc_user;
		$password = $ar_enc_pass;	
		
        $data = array(
				'olt_nama' => $this->input->post('nama'),
				'olt_ip' => $ar_enc_ip,
				'olt_user' => $ar_enc_user,
				'olt_pwd' => $ar_enc_pass,
				'olt_uptime' => "",
				);					
		$this->db->where('id', $id);
		$this->db->update('blip_olt', $data);
        return $this->session->set_flashdata('success', 'Berhasil mengubah data.');
    }
	
//END	
}
