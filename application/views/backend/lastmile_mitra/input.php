<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			ADMIN - KPI
			</div>
			<br>
<div class="panel panel-headline">

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
        if (isset($item)) {
            echo form_open('manage/lastmile_mitra/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/lastmile_mitra/simpan');
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Mitra</label>
                 <select class="form-control" id="mitra" name="mitra" required>		
				 <?php if(isset($item['mitra'])):?>							
				<option value="<?php echo isset($item['mitra']) ? $item['mitra'] : ''; ?>" selected><?php echo $item['mitra']; ?></option>	
				<?php endif;?>						
				<option value="CGS">CGS</option>
				<option value="TELKOM">TELKOM</option>
				<option value="ICON">ICON</option>
				<option value="XL">XL</option>
				<option value="INDOSAT">INDOSAT</option>
				<option value="PT.AKBAR PRIMA MEDIA">PT.AKBAR PRIMA MEDIA</option>

				</select>
            </div>
			<div class="form-group">
                        <label for="level">Pelanggan</label>
                        <select class="form-control" id="pelanggan" name="pelanggan" placeholder="List Pelanggan" value="<?php echo isset($item) ? $item['pelanggan'] : ''; ?>">
						<?php if(isset($item['pelanggan'])):?>							
						<option value="<?php echo isset($item['pelanggan']) ? $item['pelanggan'] : ''; ?>" selected><?php $customers = $this->db->get_where('blip_pelanggan', array('id' => $item['pelanggan']))->row_array(); echo $customers['nama']; ?></option>	
						<?php endif; ?>
						<?php foreach ($item_pelanggan as $pelanggan): ?>
						<option value="<?php echo $pelanggan['id']; ?>"><?php echo $pelanggan['nama']; ?></option>
						<?php endforeach; ?>
						</select>
                    </div>
					
            <div class="form-group">
                <label for="nama_keahlian">CID</label>
                <input type="text" class="form-control" id="cid" name="cid" value="<?php echo isset($item) ? $item['cid'] : ''; ?>" required autofocus>
            </div>
			 <div class="form-group">
                <label for="nama_keahlian">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo isset($item) ? $item['alamat'] : ''; ?>" required autofocus>
            </div>
			 <div class="form-group">
                <label for="nama_keahlian">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo isset($item) ? $item['latitude'] : ''; ?>" required autofocus>
            </div>
			 <div class="form-group">
                <label for="nama_keahlian">Longtitude</label>
                <input type="text" class="form-control" id="longtitude" name="longtitude" value="<?php echo isset($item) ? $item['longtitude'] : ''; ?>" required autofocus>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Status</label>
                 <select class="form-control" id="status" name="status" required>	
				 <?php if(isset($item['status'])):?>							
						<option value="<?php echo isset($item['status']) ? $item['status'] : ''; ?>" selected>
						<?php if($item['status'] == 0){echo "Nonactive";}else{echo "Active";} ?>
						</option>	
				<?php endif; ?>							
				<option value="0">Nonactive</option>
				<option value="1">Active</option>

				</select>
            </div>
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="<?php echo base_url('manage/lastmile_mitra'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>

			</div>



        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
