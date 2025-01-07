<?
require_once "telnet_class.php";

$telnet = new PHPTelnet();

// if the first argument to Connect is blank,
// PHPTelnet will connect to the local host via 127.0.0.1
$result = $telnet->Connect('10.247.0.22','adhit','MtrMasuk*123#');

if ($result == 0) {
$telnet->DoCommand('show gpon onu state gpon-olt_'.$_GET['olt'].'', $result);
// NOTE: $result may contain newlines
	// say Disconnect(0); to break the connection without explicitly logging out
$skuList = preg_split('/\r\n|\r|\n/', $result);
//echo "<pre>";
//print_r($skuList);
foreach($skuList as $key => $value ){
	if($value == "show gpon onu state gpon-olt_".$_GET['olt']."")
	{ echo""; }
	elseif(strpos($value,'OMCC'))
	{ echo""; }
	elseif($value == "--------------------------------------------------------------")
	{ echo""; }
	elseif($value == "OLT-ZTE-GMEDIA-PMG#")
	{ echo""; }
	//elseif(strpos($value,'Number:'))
	//{ echo""; }
	else
	{
	$items[] = $value;
	//echo $value. '<br />';
	}
}
$output="";
foreach($items as $value2 ){
$output.= $value2."<br>";
}
echo"$output";
$len2 = count($items);
//echo "</pre>";
$telnet->Disconnect();
}

?>

