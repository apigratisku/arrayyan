<?php
$arr = json_decode(file_get_contents("php://input"));
if (empty($arr->mail_token)){
    echo "Error Response! Invalid Mail Token !";
} else {
if($arr->mail_token == "BLiP*123#"){
if(isset($arr->mail_tiket)) {$mail_tiket =  $arr->mail_tiket;} else{$mail_tiket = "-";}
if(isset($arr->mail_lokasi_pekerjaan)) {$mail_lokasi_pekerjaan =  $arr->mail_lokasi_pekerjaan;} else{$mail_lokasi_pekerjaan = "-";}
if(isset($arr->mail_kendala)) {$mail_kendala =  $arr->mail_kendala;} else{$mail_kendala = "-";}
if(isset($arr->mail_keterangan)) {$mail_keterangan =  $arr->mail_keterangan;} else{$mail_keterangan = "-";}
if(isset($arr->mail_waktu_mulai)) {$mail_waktu_mulai = $arr->mail_waktu_mulai;} else{$mail_waktu_mulai = "-";}
if(isset($arr->mail_status)) {$mail_status = $arr->mail_status;} else{$mail_status = "-";}
if(isset($arr->mail_pic)) {$mail_pic = $arr->mail_pic;} else{$mail_pic = "-";}
$message = "<table style=\"width: 100%;
  background-color: #ffffff;
  border-collapse: collapse;
  border-width: 2px;
  border-color: #6e6e6e;
  border-style: solid;
  color: #000000;
  padding: 3px;\">

  <tbody>
    <tr>
      <td colspan=\"2\">Dear Admin,<br>
Mohon bantuannya untuk dapat diteruskan ke tim Technical Support sesuai data berikut:<br><br></td>
    </tr>
    <tr>
      <td style=\"background-color:#FF9933; width:25%; font-weight:bold; padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid;\">No Tiket</td>
      <td style=\"padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid\"><b>$mail_tiket</b></td>
    </tr>
    <tr>
      <td style=\"background-color:#FF9933; width:25%; font-weight:bold; padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid;\">Lokasi Pekerjaan</td>
      <td style=\"padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid\">$mail_lokasi_pekerjaan</td>
    </tr>
    <tr>
      <td style=\"background-color:#FF9933; width:25%; font-weight:bold; padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid;\">Kendala</td>
      <td style=\"padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid\">$mail_kendala</td>
    </tr>
    <tr>
      <td style=\"background-color:#FF9933; width:25%; font-weight:bold; padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid;\">Keterangan</td>
      <td style=\"padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid\">$mail_keterangan</td>
    </tr>
    <tr>
      <td style=\"background-color:#FF9933; width:25%; font-weight:bold; padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid;\">Waktu Mulai</td>
      <td style=\"padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid\">$mail_waktu_mulai</td>
    </tr>
    <tr>
      <td style=\"background-color:#FF9933; width:25%; font-weight:bold; padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid;\">Status</td>
      <td style=\"padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid\">$mail_status</td>
    </tr>
    <tr>
      <td style=\"background-color:#FF9933; width:25%; font-weight:bold; padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid;\">PIC</td>
      <td style=\"padding: 3px;border-width: 2px; border-color: #6e6e6e;border-style: solid\">$mail_pic</td>
    </tr>
     <tr>
      <td colspan=\"2\"><br><br>Demikian informasi yang disampaikan.<br>
Terima Kasih.</td>
    </tr>
  </tbody>
</table>";

        $from = $arr->mail_from;    
        $to = $arr->mail_to;    
        $subject = "[Open Ticket ".$arr->mail_tiket." Gangguan/Maintenance";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From:" . $from;    
        if(mail($to,$subject,$message, $headers)){
            echo"Mail Success";
        }else{
            ini_set( 'display_errors', 1 );   
            error_reporting( E_ALL );
        }

    }else{
        echo "Unauthorized Access";
    }
}

?>
