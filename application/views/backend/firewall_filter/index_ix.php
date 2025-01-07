<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			SUMMARY DATA IX (INTERNATIONAL)
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
					<th nowrap="nowrap">IP Address</th>
					<th nowrap="nowrap" style="text-align:center">Ultilitas (MB)</th>
                    <th nowrap="nowrap">Name</th>
					<th nowrap="nowrap" style="text-align:center">Country</th>
					<th nowrap="nowrap" style="text-align:center">State</th>
					<th nowrap="nowrap" style="text-align:center">City</th>
					<th nowrap="nowrap" style="text-align:center">Lat</th>
					<th nowrap="nowrap" style="text-align:center">Long</th>
					<th nowrap="nowrap" style="text-align:center">ASN</th>
					<th nowrap="nowrap" style="text-align:center">ISP</th>
					
                </tr>

            </thead>

            <tbody>

                <?php foreach ($items as $item): ?>

                    <tr>
					<td>
                            <?php echo $item['ip']; ?>
                        </td><td align="center">
                            <?php echo round($item['rx']/100000,0);?>
                        </td><td>
                            <?php echo $item['country_capital']; ?>
                        </td><td align="center">
                            <?php echo $item['country']; ?>
                        </td><td align="center">
                            <?php echo $item['region']; ?>
                        </td><td align="center">
                            <?php echo $item['city']; ?>
                        </td><td align="center">
                            <?php echo $item['latitude']; ?>
                        </td><td align="center">
                            <?php echo $item['longitude']; ?>
                        </td><td align="center">
                            <?php echo $item['asn']; ?>
                        </td><td align="center">
                            <?php echo $item['isp']; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
<script src="<?php echo base_url('static/'); ?>assets/chartjs/dist/Chart.min.js"></script>
 <script src="<?php echo base_url('static/'); ?>assets/chartjs/samples/utils.js"> </script>
<div id="canvas-holder" style="width:90%; text-align:center">
		<canvas id="chart-area"></canvas>
	</div>

	<script>
	$.getJSON( "https://arrayyan.web.id/manage/firewall_filter/bar_chart", function( data ) {
	var isi_labels = [];
    var isi_data=[];
	
	$(data).each(function(i){         
        isi_labels.push(data[i].isp); 
        //jml item dalam persentase
        isi_data.push(data[i].rx);
    });
	
	
		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};
		var ctx = document.getElementById('chart-area').getContext('2d');
		var myPieChart = new Chart(ctx, {
			type: 'pie',
			data: {
				labels: isi_labels,
				datasets: [{
					data: isi_data,
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
						window.chartColors.blue,
					],
					label: 'Dataset 1'
				}],
				
			},
			
	 });
	 });
	 
	 


		
	</script>
		
		
		</div>
    </div>

</div>

<!-- END PANEL HEADLINE -->

