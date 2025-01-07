<!DOCTYPE html>
<html>
<head>
	<title>Belajar Ambil Lokasi</title>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<p>lokasi anda saat ini: <span id="lokasi"></span></p>

<script type="text/javascript">
	$(document).ready(function() {
		navigator.geolocation.getCurrentPosition(function (position) {
   			 tampilLokasi(position);
		}, function (e) {
		    alert('Geolocation Tidak Mendukung Pada Browser Anda');
		}, {
		    enableHighAccuracy: true
		});
	});
	function tampilLokasi(posisi) {
		//console.log(posisi);
		var latitude 	= posisi.coords.latitude;
		var longitude 	= posisi.coords.longitude;
		$.ajax({
			type 	: 'POST',
			url		: 'lokasi.php',
			data 	: 'latitude='+latitude+'&longitude='+longitude,
			success	: function (e) {
				if (e) {
					$('#lokasi').html(e);
				}else{
					$('#lokasi').html('Tidak Tersedia');
				}
			}
		})
	}
</script>
</body>
</html>