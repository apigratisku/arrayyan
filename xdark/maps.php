<?php
## formula untuk menghitung jarak antara dua koordinat
## rumus / formula ini merupakan hasil konversi dari rumus baku
## dalam hal pengukuran jarak "great-circle"
function rad($x){ return $x * M_PI / 180; }
function distHaversine($coord_a, $coord_b){
    # jarak kilometer dimensi (mean radius) bumi
    $R = 6371;
    $coord_a = explode(",",$coord_a);
    $coord_b = explode(",",$coord_b);
    $dLat = rad(($coord_b[0]) - ($coord_a[0]));
    $dLong = rad($coord_b[1] - $coord_a[1]);
    $a = sin($dLat/2) * sin($dLat/2) + cos(rad($coord_a[0])) * cos(rad($coord_b[0])) * sin($dLong/2) * sin($dLong/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $d = $R * $c;
    # hasil akhir dalam satuan kilometer
    return number_format($d, 2, '.', ',');
}
## cara penggunaannya
## contoh ada 2 koordinat (latitude dan longitude)
$a = "-8.359537, 116.146759";
$b = "-8.3602666, 116.1461173";
$distance = distHaversine($a, $b);
$jarak = $distance*1000;
echo $jarak." Meter";
?>