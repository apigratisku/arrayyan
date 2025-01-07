
<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">
       <div class="box-footer">
			<?php if($this->session->userdata('ses_admin')=='1'):?>
                <a href="<?php echo base_url('manage/router/tambah_fo_onnet'); ?>" class="btn btn-info pull-right">Tambah Data</a>
			 <?php endif; ?>
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
        <table class="table table-bordered table-striped" id="example2">

            <thead>

                <tr>

                    <th nowrap="nowrap">Router</th>
					<th style="text-align:center" width="5%">Produk</th>
					<th nowrap="nowrap">Media</th>
					<th>IP Router</th>
					<th>Network</th>
					<th style="text-align:center" width="10%">Status</th>
                    <th style="text-align:center" width="12%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>

                        <td>
                            <?php echo $item['nama']; ?>
                        </td><td>
                             <?php $produk = $this->db->get_where('blip_produk', array('id' => $item['produk']))->row_array(); echo $produk['produk']; ?>
                        </td><td>
                            <?php echo $item['media']; 
							if($item['media'] == "Fiber Optic (Onnet)") {$input = "tambah_fo_onnet";} 
							elseif($item['media'] == "Fiber Optic (CGS)") {$input = "tambah_fo_cgs";} 
							elseif($item['media'] == "Fiber Optic (ICON)") {$input = "ttambah_fo_icon";} 
							elseif($item['media'] == "Fiber Optic (TELKOM)") {$input = "tambah_fo_telkom";} 
							elseif($item['media'] == "Fiber Optic (MITRA LAIN)") {$input = "tambah_fo_mitra";} 
							else {$input = "tambah_we";} ?>
                        </td><td>
                            <?php echo $item['router_ip']; ?>
                        </td><td>
                             <?php echo $item['router_network']; ?>
                        </td><td style="text-align:center">
                            <?php 
							if($item['status'] == "0") {echo"<span style=\"color:red; font-weight:bold\">OFFLINE</span>";} else{echo"<span style=\"color:green; font-weight:bold\">ONLINE</span>";}
							?>
                        </td><td style="text-align:center">
						
<table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td><a href="<?php echo base_url('manage/router/' . $item['id']); ?>" class="btn btn-xs btn-primary"><i class="fa fa-search-plus"></i></a></td>
    <td><a href="<?php echo base_url('manage/router/' . $item['id'] . '/'.$input); ?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a></td>
    <td><a href="<?php echo base_url('manage/router/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
  </tr>
  
 <tfoot>
                
</table>
                            
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>


			<tr>
                    <th nowrap="nowrap">Router</th>
					<th style="text-align:center" width="5%">Produk</th>
					<th nowrap="nowrap">Media</th>
					<th>IP Router</th>
					<th>Network</th>


					<th style="text-align:center" width="10%">Status</th>
                    <th style="text-align:center" width="12%">Tindakan</th>
                </tr>
                </tfoot> 
        </table>
		</div>

    </div>

</div>

<!-- END PANEL HEADLINE -->
