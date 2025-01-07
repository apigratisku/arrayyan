<div class="panel panel-headline">
    <div class="panel-heading">

		<!-- /.box-body -->
              <div class="box-footer">
			  <a href="#" class="btn btn-info pull-right" onClick="javascript:return confirm('Proses refresh data. Lanjutkan?')">Refresh Data</a>
              </div>
    </div>



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
					<th style="text-align:center"  width="8%">CID</th>
                    <th style="text-align:center" width="40%">Pelanggan</th>
					<th style="text-align:center" width="10%">VLAN</th>
                    <th  style="text-align:center" width="40%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr> 

						<td style="text-align:center">
                            <?php echo $item['cid']; ?>
                        </td>
                        <td>
                            <?php echo $item['nama']; ?>
                        </td>
						<td>
                            <?php echo $item['interface']; ?>
                        </td>
						<td style="text-align:center">
						
<table width="98%" border="0" cellspacing="0" cellpadding="0" style="text-align:left">
  <tr>
    <td>
<?php
$data1 = trim($item['cid'],' ');
$method="AES-128-CBC";
$key ="25c6c7ff35b9979b151f2136cd13b0ff";
$option=0;
$iv="1251632135716362";
$dataCID=bin2hex(openssl_encrypt($data1, $method, $key, $option, $iv));

$getkey = substr($item['interface'],0,-8);
?>	

<?php if($getkey == "xvlan"):?>
<a href="<?php echo base_url('manage/fiberstream/' . $dataCID . '/' . $item['id'] . '/profile'); ?>" class="btn btn-primary">Profile</a>
<a href="<?php echo base_url('manage/fiberstream/' . $dataCID . '/' . $item['id'] . '/redaman'); ?>" class="btn btn-primary">Redaman</a>
<a href="<?php echo base_url('manage/fiberstream/' . $dataCID . '/' . $item['id'] . '/port'); ?>" class="btn btn-primary">Port</a>
<a href="<?php echo base_url('manage/fiberstream/' . $dataCID . '/' . $item['id'] . '/bandwidth'); ?>" class="btn btn-primary">Bandwidth</a>
<a href="<?php echo base_url('manage/fiberstream/' . $dataCID . '/' . $item['id'] . '/restart'); ?>" class="btn btn-primary" onclick="return confirm('ONU akan direstart. Lanjutkan?');">Restart</a>
<?php else: ?>
<a href="<?php echo base_url('manage/fiberstream/' . $dataCID . '/' . $item['id'] . '/bandwidth'); ?>" class="btn btn-primary">Bandwidth</a>
<?php endif; ?>
	
	
	
	</td>
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
