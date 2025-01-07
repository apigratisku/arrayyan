<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			FIREWALL - FILTER ADDRESS
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
					<th nowrap="nowrap">Source</th>
					<th nowrap="nowrap">IP Address</th>
                    <th nowrap="nowrap">Name</th>
					<th nowrap="nowrap">Country</th>
					<th nowrap="nowrap">State</th>
					<th nowrap="nowrap">City</th>
					<th nowrap="nowrap">Lat</th>
					<th nowrap="nowrap">Long</th>
					<th nowrap="nowrap">ASN</th>
					<th nowrap="nowrap">ISP</th>
					<th nowrap="nowrap">Timezone</th>
                    <th style="text-align:center" width="10%">Tindakan</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
                       <td>
                            <?php 
							$teid = $this->db->get_where('gm_te', array('id' => $item['source']))->row_array();
							echo $teid['nama']; 
							?>
                        </td><td>
                            <?php echo $item['ip']; ?>
                        </td><td>
                            <?php echo $item['country_capital']; ?>
                        </td><td>
                            <?php echo $item['country']; ?>
                        </td><td>
                            <?php echo $item['region']; ?>
                        </td><td>
                            <?php echo $item['city']; ?>
                        </td><td>
                            <?php echo $item['latitude']; ?>
                        </td><td>
                            <?php echo $item['longitude']; ?>
                        </td><td>
                            <?php echo $item['asn']; ?>
                        </td><td>
                            <?php echo $item['isp']; ?>
                        </td><td>
                            <?php echo $item['timezone']; ?>
                        </td><td  style="text-align:center">
                            <a href="<?php echo base_url('manage/firewall_filter/' . $item['id'] . '/hapus'); ?>" onClick="javascript:return confirm('Yakin ingin menghapus data?')" class="btn btn-xs btn-danger">
                                Whitelist
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->
