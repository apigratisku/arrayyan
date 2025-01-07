<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">BTS - RADIO AP BTS - MAINTENANCE</div>

   <div class="panel-heading">
                
            <?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
            <div class="box-footer">
			<a href="<?php echo base_url('manage/bts/'); ?>" class="btn btn-primary">DATA RADIO</a>
			<?php if($this->session->userdata('ses_admin')=='1'):?><a href="<?php echo base_url('manage/bts/tambah'); ?>" class="btn btn-success">TAMBAH</a><?php endif;?>
			<a href="<?php echo base_url('manage/bts/export'); ?>" class="btn btn-success" target="_blank">EXPORT</a>
			<a href="<?php echo base_url(); ?>manage/bts/reload" class="btn btn-danger" >RELOAD</a>		
			<a href="<?php echo base_url(); ?>manage/bts/backup" class="btn btn-success">BACKUP RSC</a>
			<a href="<?php echo base_url(); ?>manage/bts/maintenance" class="btn btn-danger" target="_blank">MAINTENANCE</a>
        	</div>
			<?php endif; ?>
		
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
        <table class="table table-hover table-bordered table-act" id="data-table">

            <thead>

                <tr>
					<th style="text-align:center">Waktu</th>
					<th width="15%">Sektor</th>
					<th style="text-align:center; width:5%">IP Addr</th>
					<th style="text-align:center">Login</th>
					<th style="text-align:center">User</th>
					<th style="text-align:center">Script</th>
					<th style="text-align:center">AddrList</th>
					<th style="text-align:center">SSH</th>
					<th style="text-align:center">OS</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
						<td nowrap>
                            <?php echo $item['waktu']; ?>
                        </td>
                        <td nowrap>
                            <?php echo $item['sektor_bts']; ?>
                        </td><td align="center">
                            <?php echo $item['ip']; ?>
                        </td><td align="center">
							<?php 
							if($item['cek_login'] == "NOK") 
							{echo"<span style=\"color:red; font-weight:bold\">NOK</span>";} 
							else 
							{echo"<span style=\"color:green; font-weight:bold\">$item[cek_login]</span>";} 
							?>
                        </td><td align="center">
                            <?php 
							if($item['cek_user'] == "NOK") 
							{echo"<span style=\"color:red; font-weight:bold\">NOK</span>";} 
							else 
							{echo"<span style=\"color:green; font-weight:bold\">$item[cek_user]</span>";} 
							?>
                        </td><td align="center">
							<?php 
							if($item['cek_script'] == "NOK") 
							{echo"<span style=\"color:red; font-weight:bold\">NOK</span>";} 
							else 
							{echo"<span style=\"color:green; font-weight:bold\">$item[cek_script]</span>";} 
							?>
                        </td><td align="center">
							<?php 
							if($item['cek_addrlist'] == "NOK") 
							{echo"<span style=\"color:red; font-weight:bold\">NOK</span>";} 
							else 
							{echo"<span style=\"color:green; font-weight:bold\">$item[cek_addrlist]</span>";} 
							?>
                        </td><td align="center">
							<?php 
							if($item['cek_port_ssh'] == "NOK") 
							{echo"<span style=\"color:red; font-weight:bold\">NOK</span>";} 
							else 
							{echo"<span style=\"color:green; font-weight:bold\">$item[cek_port_ssh]</span>";} 
							?>
                        </td><td align="center">
                            <?php echo $item['cek_os']; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>

    </div>

</div>

<!-- END PANEL HEADLINE -->