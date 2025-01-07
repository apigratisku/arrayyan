<script type="text/javascript">
						function playSound()
							{
								var audio = new Audio('https://xdarkavenger.xyz/xdark/siren_2ydq7ssj.wav');
								audio.play();
							}
						</script>
<div class="panel panel-headline">

    <div class="panel-heading">
        <div class="row">
            
           <div class="col-md-6 panel-action">
                <a href="<?php echo base_url('manage/station/export'); ?>" class="btn btn-success" target="_blank">EXPORT DATA</a>
            </div>
        </div>
    </div>

    <hr class="panel-divider">

    <div class="panel-body">

        <?php if ($this->session->flashdata('success')): ?>

            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('success'); ?>
            </div>

        <?php elseif ($this->session->flashdata('error')): ?>

            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $this->session->flashdata('error'); ?>
            </div>

        <?php endif; ?>
		<div class="table-responsive">
        <table class="table table-bordered table-hover" id="example1">

            <thead>

                <tr>
                    <th nowrap>Nama</th>
					 <th width="20%">Sektor</th>
					<th>IP</th>
					<th>Jarak</th>
					<th>SIGNAL</th>
					<th>CCQ</th>
					<th>Kualitas</th>
					<th>Waktu</th>
					<th>Act</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                        <td nowrap>
                            <?php echo $item['pelanggan']; ?>
                        </td><td width="20%">
                            <?php echo $item['sektor']; ?>
                        </td><td>
                            <?php echo $item['ipaddr']; ?>
                        </td><td align="center">
                            <?php echo $item['jarak']; ?> km
                        </td><td>
                            <?php echo $item['sinyal']; ?>
                        </td><td>
                            <?php echo $item['ccq']; ?>
                        </td>
						<td align="center">
						
                           <?php 
						   
						   if($item['kualitas'] == "Buruk") 
						   {
						   echo"<span style=\"color:red; font-weight:bold\">Buruk</span>"; 
$myAudioFile = base_url('xdark/windows-xp-error-sound.mp3');
echo '<audio autoplay="true" style="display:none;">
         <source src="'.$myAudioFile.'" type="audio/wav">
      </audio>';
						   } 
						   elseif($item['kualitas'] == "Diperlukan Optimasi") 
						   {
						   echo"<span style=\"color:orange; font-weight:bold\">Diperlukan Optimasi</span>";
						   } 
						   else
						   {
						   echo"<span style=\"color:green; font-weight:bold\">Baik</span>";
						   } 
						   ?>
                        </td>
						<td>
                           <?php echo $item['waktu']; ?>
                        </td><td style="text-align:center" width="5%">
<table width="5%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="<?php echo base_url('manage/station/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
  </tr>
</table>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>

    </div>

</div>

<!-- END PANEL HEADLINE -->