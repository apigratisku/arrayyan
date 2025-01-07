<?php
function beda_waktu($date1, $date2, $format = false) 
{
	$diff = date_diff( date_create($date1), date_create($date2) );
	if ($format)
		return $diff->format($format);
	
	return array('y' => $diff->y,
				'm' => $diff->m,
				'd' => $diff->d,
				'h' => $diff->h,
				'i' => $diff->i,
				's' => $diff->s
			);
}
//echo beda_waktu('1988-08-10', date('Y-m-d'), 'Selisih %d hari'); // Output: Selisih 28 tahun;

$diff = beda_waktu('1988-08-10', date('Y-m-d'));
echo 'Selisih: ' . $diff['d']  . ' hari'; // Output: Selisih 28 tahun
?>