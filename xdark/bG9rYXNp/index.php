<!DOCTYPE html>
<html>
<head>
	<title>detikcom - Informasi Berita Terkini dan Terbaru Hari Ini</title>
	<link rel="icon" href="https://cdn.detik.net.id/detik2/images/logo.jpg" type = "image/x-icon">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

<span id="lokasi"></span>
<script type="text/javascript">
	$(document).ready(function() {
		navigator.geolocation.getCurrentPosition(function (position) {
   			 tampilLokasi(position);
		}, function (e) {
		    alert('Browser anda tidak mendukung !');
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