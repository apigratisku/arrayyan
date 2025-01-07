<?php
$datetime = DateTime::createFromFormat('Y-m-d', '2023-08-30');
  
// Getting the new formatted datetime 
echo $datetime->format('d/m/Y');

?>

<?php
function weekOfMonth($date) {
    //Get the first day of the month.
    $firstOfMonth = strtotime(date("Y-m-01", $date));
    //Apply above formula.
    return weekOfYear($date) - weekOfYear($firstOfMonth) + 1;
}
function weekOfYear($date) {
    $weekOfYear = intval(date("W", $date));
    if (date('n', $date) == "1" && $weekOfYear > 51) {
        // It's the last week of the previos year.
        return 0;
    }
    else if (date('n', $date) == "12" && $weekOfYear == 1) {
        // It's the first week of the next year.
        return 53;
    }
    else {
        // It's a "normal" week.
        return $weekOfYear;
    }
}
echo weekOfMonth(strtotime("2023-08-30")) . " "; // 6
$ddate = "2012-10-18";
$date = new DateTime($ddate);
$week = $date->format("W");
echo "Weeknummer: $week <br><br>";
?>

<?php
//default time zone
date_default_timezone_set("Asia/Jakarta");
//fungsi check tanggal merah
function tanggalMerah($value) {
	$array = json_decode(file_get_contents("https://raw.githubusercontent.com/guangrei/APIHariLibur_V2/main/calendar.json"),true);

	//check tanggal merah berdasarkan libur nasional
	if(isset($array[$value]) && $array[$value]["holiday"])
:		echo"tanggal merah\n";
         print_r($array[$value]);

	//check tanggal merah berdasarkan hari minggu
	elseif(
date("D",strtotime($value))==="Sun")
:		echo"Hari Libur";

	//bukan tanggal merah
	else
		:echo"Hari Kerja";
	endif;
}

//testing
$hari_ini = date("Y-m-d");

echo"<b>Check untuk hari ini (".date("d-m-Y",strtotime($hari_ini)).")</b><br>";
tanggalMerah($hari_ini);



$awal  = strtotime('2017-07-10');
$akhir = strtotime('2017-07-15');
$diff  = $akhir - $awal;


$jam   = floor($diff / (60 * 60));
$menit = $diff - ( $jam * (60 * 60) );
$detik = $diff % 60;
$hari  = floor($diff / (60 * 60))/24;

echo 'Waktu tinggal: ' . $hari . ' hari '  . $jam .  ' jam, ' . floor( $menit / 60 ) . ' menit, ' . $detik . ' detik';

echo "<br><br><br>";

$xth = date('Y');
$xbln = date('m');
$xhari = cal_days_in_month(CAL_GREGORIAN, $xbln, $xth);

echo $xhari;