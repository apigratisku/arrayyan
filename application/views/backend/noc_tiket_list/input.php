<?php
date_default_timezone_set("Asia/Singapore");
?>
<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			NOC - SISTEM TIKET - LIST
			</div>
			<br>

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

        <?php
        if (isset($item['id'])) {
            echo form_open('manage/noc_tiket_list/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/noc_tiket_list/simpan');
			
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
				<label for="bts">Customer</label>
				<select class="form-control" id="pelanggan" name="customers">	
				<option value="">-Customer-</option>
				<?php if(isset($item['customers'])):?>							
				<option value="<?php echo isset($item['customers']) ? $item['customers'] : ''; ?>" selected><?php $customers = $this->db->get_where('blip_pelanggan', array('id' => $item['customers']))->row_array(); echo $customers['nama']; ?></option>	
				<?php endif; ?>
				<?php foreach ($tb_pelanggan as $pelanggan): ?>
				<?php 
						if($pelanggan['status_pelanggan'] == "0") {$status_pelanggan = "Tidak Aktif";$disabled="disabled=\"disabled\"";} elseif($pelanggan['status_pelanggan'] == "1"){$status_pelanggan = "Aktif";$disabled="";}elseif($pelanggan['status_pelanggan'] == "2"){$status_pelanggan = "Isolir";}else{$status_pelanggan = "Dismantle"; $disabled="disabled=\"disabled\"";}
						?>
				<option value="<?php echo $pelanggan['id'] ?>" <?php echo $disabled; ?>><?php echo $pelanggan['nama']." - [".$status_pelanggan."]"; ?></option>	
				<?php endforeach; ?>
				</select>
			</div>
			
			<div class="form-group">
                <label for="nama_keahlian">Case</label>
                <input type="text" class="form-control" id="case_gangguan" name="case_gangguan" value="<?php echo isset($item['case_gangguan']) ? $item['case_gangguan'] : ''; ?>" autofocus required>
            </div>
			<div class="form-group">
				<label for="bts">Case Klasifikasi</label>
				<select class="form-control" id="id_perangkat" name="case_klasifikasi">	
				<option value="">-Case Klasifikasi-</option>
				<?php if(isset($item['case_klasifikasi'])):?>							
				<option value="<?php echo isset($item['case_klasifikasi']) ? $item['case_klasifikasi'] : ''; ?>" selected><?php $getcase_klasifikasi = $this->db->get_where('blip_tiket_case_klasifikasi', array('id' => $item['case_klasifikasi']))->row_array(); echo $getcase_klasifikasi['nama']; ?></option>	
				<?php endif; ?>
				<?php foreach ($tb_case_klasifikasi as $case_klasifikasi): ?>
				<option value="<?php echo $case_klasifikasi['id'] ?>"><?php echo $case_klasifikasi['nama'] ?></option>	
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="bts">Case Sub Klasifikasi</label>
				<select class="form-control" id="input_nama_exist" name="case_subklasifikasi">	
				<option value="">-Case SubKlasifikasi-</option>
				<?php if(isset($item['case_subklasifikasi'])):?>							
				<option value="<?php echo isset($item['case_subklasifikasi']) ? $item['case_subklasifikasi'] : ''; ?>" selected><?php $getcase_subklasifikasi = $this->db->get_where('blip_tiket_case_subklasifikasi', array('id' => $item['case_subklasifikasi']))->row_array(); echo $getcase_subklasifikasi['nama']; ?></option>	
				<?php endif; ?>
				<?php foreach ($tb_case_subklasifikasi as $case_subklasifikasi): ?>
				<option value="<?php echo $case_subklasifikasi['id'] ?>"><?php echo $case_subklasifikasi['nama'] ?></option>	
				<?php endforeach; ?>
				</select>
			</div>
			

			<div class="form-group">
				<label for="bts">Eskalasi NOC</label>
				<select class="form-control" id="" name="eskalasi_noc">	
				<option value="">-Eskalasi NOC-</option>
				<?php if(isset($item['eskalasi_noc'])):?>							
				<option value="<?php echo isset($item['eskalasi_noc']) ? $item['eskalasi_noc'] : ''; ?>" selected><?php $eskalasi_noc = $this->db->get_where('blip_tiket_list', array('eskalasi_noc' => $item['eskalasi_noc']))->row_array(); echo $eskalasi_noc['eskalasi_noc']; ?></option>	
				<?php endif; ?>
				<option value="NOC HD">NOC HD</option>	
				<option value="NOC IP Core">NOC IP Core</option>	
				</select>
			</div>
			<div class="form-group">
				<label for="bts">NOC IP Core</label>
				<select class="form-control" id="" name="noc_ip_core">	
				<?php if(isset($item['noc_ip_core'])):?>							
				<option value="<?php echo isset($item['noc_ip_core']) ? $item['noc_ip_core'] : ''; ?>" selected><?php $get_noc_ip_core = $this->db->get_where('blip_tiket_noc_ipcore', array('id' => $item['noc_ip_core']))->row_array(); echo $get_noc_ip_core['nama']; ?></option>	
				<?php endif; ?>
				<?php foreach ($tb_noc_ipcore as $noc_ipcore): ?>
				<option value="<?php echo $noc_ipcore['id'] ?>" selected="selected"><?php echo $noc_ipcore['nama'] ?></option>	
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="bts">NOC HD</label>
				<select class="form-control" id="lokasi_pelanggan" name="noc_hd_duty">	
				<option value="">-NOC HD-</option>
				<?php if(isset($item['noc_hd_duty'])):?>							
				<option value="<?php echo isset($item['noc_hd_duty']) ? $item['noc_hd_duty'] : ''; ?>" selected><?php $get_noc_hd_duty = $this->db->get_where('blip_tiket_noc_hd', array('id' => $item['noc_hd_duty']))->row_array(); echo $get_noc_hd_duty['nama']; ?></option>	
				<?php endif; ?>
				<?php foreach ($tb_noc_hd as $noc_hd): ?>
				<option value="<?php echo $noc_hd['id'] ?>"><?php echo $noc_hd['nama'] ?></option>	
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="bts">Eskalasi Akhir</label>
				<select class="form-control" id="input_odp" name="eskalasi_akhir">	
				<option value="">-Eskalasi Akhir-</option>
				<?php if(isset($item['eskalasi_akhir'])):?>							
				<option value="<?php echo isset($item['eskalasi_akhir']) ? $item['eskalasi_akhir'] : ''; ?>" selected><?php $get_eskalasi_akhir = $this->db->get_where('blip_tiket_eskalasi', array('id' => $item['eskalasi_akhir']))->row_array(); echo $get_eskalasi_akhir['nama']; ?></option>	
				<?php endif; ?>
				<?php foreach ($tb_eskalasi as $eskalasi): ?>
				<option value="<?php echo $eskalasi['id'] ?>"><?php echo $eskalasi['nama'] ?></option>	
				<?php endforeach; ?>
				</select>
			</div>
			
			
			</div>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Problem</label>
                <input type="text" class="form-control" id="problem" name="problem" value="<?php echo isset($item['problem']) ? $item['problem'] : ''; ?>" autofocus required>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Action</label>
                <input type="text" class="form-control" id="action" name="action" value="<?php echo isset($item['action']) ? $item['action'] : ''; ?>" autofocus>
            </div>
			<div class="form-group">
				<label for="bts">Status</label>
				<select class="form-control" id="lokasi_pelanggan" name="status">	
				<option value="">-Status-</option>
				<?php if(isset($item['status'])):?>							
				<option value="<?php echo isset($item['status']) ? $item['status'] : ''; ?>" selected><?php echo $item['status']; ?></option>	
				<?php endif; ?>
				<option value="Solved">Solved</option>	
				<option value="Pending">Pending</option>
				<option value="Scheduled">Scheduled</option>
				<option value="Monitoring">Monitoring</option>
				<option value="Progress">Progress</option>	
				</select>
			</div>
			<div class="form-group">
                <label for="nama_keahlian">PIC</label>
                <input type="text" class="form-control" id="pic" name="pic" value="<?php echo isset($item['pic']) ? $item['pic'] : ''; ?>" autofocus required>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Waktu Start</label>
                <input type="text" class="form-control" id="datetime2" name="waktu_mulai" value="<?php echo isset($item['tgl_open']) ? $item['tgl_open']." ".$item['jam_open'] : ''; ?>" autofocus required>
            </div>
			<script type="text/javascript">
			$("#datetime2").datetimepicker({
				format: 'yyyy-mm-dd hh:ii:ss',
				autoclose: true
			});
			</script>
			<div class="form-group">
                <label for="nama_keahlian">Waktu Close</label>
                <input type="text" class="form-control" id="datetime3" name="waktu_close" value="<?php echo isset($item['tgl_close']) ? $item['tgl_close']." ".$item['jam_close'] : ''; ?>" autofocus>
            </div>
			<script type="text/javascript">
			$("#datetime3").datetimepicker({
				format: 'yyyy-mm-dd hh:ii:ss',
				autoclose: true
			});
			</script>
			
			<div class="form-group">
                <label for="nama_keahlian">Waktu Close SLA</label>
                <input type="text" class="form-control" id="datetime4" name="waktu_close_sla" value="<?php echo isset($item['tgl_close_sla']) ? $item['tgl_close_sla']." ".$item['jam_close_sla'] : ''; ?>" autofocus>
            </div>
			<script type="text/javascript">
			$("#datetime4").datetimepicker({
				format: 'yyyy-mm-dd hh:ii:ss',
				autoclose: true
			});
			</script>
			
			
			<div class="form-group">
                <label for="nama_keahlian">Kirim Email</label>
                <input type="checkbox" id="notif_email" name="notif_email" value="notif_email">
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Notifikasi Telegram</label>
                <input type="checkbox" id="notif_tg" name="notif_tg" value="notif_tg">
            </div>
			
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="<?php echo base_url('manage/noc_tiket_list'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>
			
			</div>



        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->

