<?php
$details = "http://maps.googleapis.com/maps/api/distancematrix/json?origins=-8.577385,116.144476&destinations=-8.579183,116.144337&mode=driving&sensor=false";


    $json = file_get_contents($details);

    $details = json_decode($json, TRUE);

    echo "<pre>"; print_r($details); echo "</pre>";
?>