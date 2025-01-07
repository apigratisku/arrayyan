<?php
$message = "1 2 3 4 5 6 7 8 9 10";
$msgdata = explode(" ", $message);
$msgcount = count($msgdata);
$capel = "";
for($msgcapel=3; $msgcapel <= $msgcount;)
{

	$capel .= "$msgdata[$msgcapel] ";
	$msgcapel++;
}
echo $capel;
?>