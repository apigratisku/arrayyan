
<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#FFFFFF; font-size:20px; padding:10px 0px 10px 10px">DATA PELANGGAN - <?php echo $title; ?></div>

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
		if($title == "Ubah Data Layanan"){
            echo form_open('manage/data_pelanggan/' . $item['id'] . '/layanan_timpa');
		}elseif($title == "Tambah Data Layanan"){
            echo form_open('manage/data_pelanggan/layanan_simpan');
        }
		
        ?>
		
		<div class="col-md-6">
		<div class="col-md-6">
			 <div class="form-group">
                <label for="nama_keahlian">Pelanggan</label>
				<?php if($title == "Tambah Data Layanan"): ?>
                <input type="text" class="form-control" value="<?php echo $item['nama']; ?>" required autofocus disabled="disabled">
				 <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="<?php echo $item['id']; ?>">
				 <?php elseif($title == "Ubah Data Layanan"): ?>
				 <?php $id_pelanggan = $this->db->get_where('blip_pelanggan', array('id' => $item['id_pelanggan']))->row_array(); ?>
                <input type="text" class="form-control" value="<?php echo $id_pelanggan['nama']; ?>" required autofocus disabled="disabled">
				 <input type="hidden" id="id_pelanggan" name="id_pelanggan" value="<?php echo $id_pelanggan['id']; ?>">
				 <?php endif; ?>
				 
				 
            </div>
			
			<div class="form-group">
			<label for="dr">Router Distribusi</label>
			<select class="form-control" id="id_dr" name="id_dr">
			<option value="">-DR-</option>
			<?php if(isset($item['id_dr'])):?>
			<option value="<?php echo isset($item['id_dr']) ? $item['id_dr'] : ''; ?>" selected><?php $dr = $this->db->get_where('gm_dr', array('id' => $item['id_dr']))->row_array(); echo $dr['nama']; ?></option>	
			<?php endif; ?>	
			<?php foreach ($dr_items as $dr_item): ?>							
			<option value="<?php echo $dr_item['id']; ?>"><?php echo $dr_item['nama']; ?></option>
			<?php endforeach; ?>
			</select>
			</div>
			
			<div class="form-group">
			<label for="bts">BTS/TE</label>
			<select class="form-control" id="id_te" name="id_te">	
			<option value="">-TE-</option>
			<?php if(isset($item['id_te'])):?>			
			<option value="<?php echo isset($item['id_te']) ? $item['id_te'] : ''; ?>" selected><?php $te = $this->db->get_where('gm_te', array('id' => $item['id_te']))->row_array(); echo $te['nama']; ?></option>	
			<?php endif; ?>
			
			<?php foreach ($te_items as $te_item): ?>							
			<option value="<?php echo $te_item['id']; ?>"><?php echo $te_item['nama']; ?></option>
			<?php endforeach; ?>
			</select>
			</div>
			
			
           <div class="form-group">
				<label for="level">Media Access</label>
				<select class="form-control" id="id_media" name="id_media">
				<option value="">- Media Access -</option>
				<?php $media_id = $this->db->get_where('blip_mediaaccess', array('id' => $item['id_media']))->row_array(); ?>
				<?php if(isset($media_id['id'])):?><option value="<?php echo isset($media_id['id']) ? $media_id['id'] : ''; ?>" selected><?php echo isset($media_id['id']) ? $media_id['media'] : ''; ?></option><?php endif; ?>

				<?php foreach ($items_media as $media): ?>
				<option value="<?php echo $media['id']; ?>"><?php echo $media['media']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="level">Produk</label>
				<select class="form-control" id="id_produk" name="id_produk">
				<option value="">- Produk -</option>
				<?php $produk_id = $this->db->get_where('blip_produk', array('id' => $item['id_produk']))->row_array(); ?>
				<?php if(isset($produk_id['produk'])):?><option value="<?php echo isset($produk_id['id']) ? $produk_id['id'] : ''; ?>" selected><?php echo isset($produk_id['produk']) ? $produk_id['produk'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_admin_produk as $produk): ?>
				<option value="<?php echo $produk['id']; ?>"><?php echo $produk['produk']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="level">Bandwidth</label>
				<input type="number" class="form-control"  id="id_bandwidth" name="id_bandwidth" value="<?php echo isset($item['id_bandwidth']) ? $item['id_bandwidth'] : ''; ?>" required autofocus>
			</div>
			<div class="form-group">
                <label for="nama_keahlian">Status Role</label>
                 <select class="form-control" id="id_role" name="id_role" required>					
				<option value="1" <?php if(isset($item['id_role'])){if($item['id_role'] == "1"){echo "selected";}} ?>>Link Utama</option>
				<option value="2" <?php if(isset($item['id_role'])){if($item['id_role'] == "2"){echo "selected";}} ?>>Link Backup</option>

				</select>
            </div>
			<div class="form-group">
                <label for="nama_keahlian">Status Layanan</label>
                 <select class="form-control" id="id_status" name="id_status" required>					
				<option value="0" <?php if(isset($item['id_status'])){if($item['id_status'] == "0"){echo "selected";}} ?>>Tidak Aktif</option>
				<option value="1" <?php if(isset($item['id_status'])){if($item['id_status'] == "1"){echo "selected";}} ?>>Aktif</option>

				</select>
            </div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="level" style="color:#FF0000">BTS (Wireless)</label>
				<select class="form-control" id="input_bts" name="bts">
				<option value="">- BTS -</option>
				<?php $gm_bts = $this->db->get_where('gm_bts', array('id' => $item['bts']))->row_array(); ?>
				<?php if(isset($gm_bts['id'])):?><option value="<?php echo isset($gm_bts['id']) ? $gm_bts['id'] : ''; ?>" selected><?php echo isset($gm_bts['sektor_bts']) ? $gm_bts['sektor_bts'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_bts as $bts): ?>
				<option value="<?php echo $bts['id']; ?>"><?php echo $bts['sektor_bts']; ?></option>
				<?php endforeach; ?>
				</select>

			</div>
			<div class="form-group">
				<label for="level" style="color:#FF0000">Lastmile (Wireless)</label>
				<input type="text" class="form-control"  id="lastmile" name="lastmile" value="<?php echo isset($item['lastmile']) ? $item['lastmile'] : ''; ?>"  autofocus>
			</div>
			<div class="form-group">
				<label for="level">Interface</label>
				<input type="text" class="form-control"  id="interface" name="interface" value="<?php echo isset($item['interface']) ? $item['interface'] : ''; ?>"  autofocus>
			</div>
			<div class="form-group">
				<label for="level">Vlan</label>
				<input type="text" class="form-control"  id="vlan" name="vlan" value="<?php echo isset($item['vlan']) ? $item['vlan'] : ''; ?>"  autofocus>
			</div>
			<div class="form-group">
				<label for="level">PON</label>
				<input type="text" class="form-control"  id="pon" name="pon" value="<?php echo isset($item['pon']) ? $item['pon'] : ''; ?>"  autofocus>
			</div>
			<div class="form-group">
				<label for="level">ODP</label>
				<select class="form-control" id="input_odp" name="odp">
				<option value="">- ODP -</option>
				<?php $gm_odp = $this->db->get_where('gm_mapping', array('id' => $item['odp']))->row_array(); ?>
				<?php if(isset($gm_odp['id'])):?><option value="<?php echo isset($gm_odp['id']) ? $gm_odp['id'] : ''; ?>" selected><?php echo isset($gm_odp['odp']) ? $gm_odp['odp'] : ''; ?></option><?php endif; ?>
				<?php foreach ($items_odp as $odp): ?>
				<option value="<?php echo $odp['id']; ?>"><?php echo $odp['odp']; ?></option>
				<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
                <label for="nama_keahlian">Mode (Konfigurasi OLT ZTE) - Bisa dikosongkan</label>
                 <select class="form-control" id="id_mode" name="id_mode" >		
				 <option value=""></option>			
				<option value="Bridge" <?php if(isset($item['id_mode'])){if($item['id_mode'] == "Bridge"){echo "selected";}} ?>>Bridge</option>
				<option value="PPPOE" <?php if(isset($item['id_mode'])){if($item['id_mode'] == "PPPOE"){echo "selected";}} ?>>PPPOE</option>

				</select>
            </div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label for="level">Network</label>
				<input type="text" class="form-control"  id="router_network" name="router_network" value="<?php echo isset($item['router_network']) ? $item['router_network'] : ''; ?>"  autofocus>
			</div>
			<div class="form-group">
				<label for="level">IP Address</label>
				<input type="text" class="form-control"  id="router_ip" name="router_ip" value="<?php echo isset($item['router_ip']) ? $item['router_ip'] : ''; ?>"  autofocus>
			</div>
			<div class="form-group">
				<label for="level">PPPOE Username</label>
				<input type="text" class="form-control"  id="pppoe_user" name="pppoe_user" value="<?php echo isset($item['pppoe_user']) ? $item['pppoe_user'] : ''; ?>"  autofocus>
			</div>
			<div class="form-group">
				<label for="level">PPPOE Password</label>
				<input type="text" class="form-control"  id="pppoe_pass" name="pppoe_pass" value="<?php echo isset($item['pppoe_pass']) ? $item['pppoe_pass'] : ''; ?>"  autofocus>
			</div>
			<div class="form-group">
				<label for="level">Keterangan</label>
				<input type="text" class="form-control"  id="keterangan" name="keterangan" value="<?php echo isset($item['keterangan']) ? $item['keterangan'] : ''; ?>"  autofocus>
			</div>
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="javascript:history.go(-1)" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>

		</div>
        </form>
		

    </div>

</div>