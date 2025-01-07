<!-- PANEL HEADLINE -->

<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			USER MANAGER
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
        if (isset($item)) {
            echo form_open_multipart('manage/operator/' . $item['id'] . '/timpa');
        } else {
            echo form_open_multipart('manage/operator/simpan');
        }
        ?>
            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama lengkap" value="<?php echo isset($item) ? $item['nama'] : ''; ?>" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="Email">UserID</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Isi dengan UserID anda" value="<?php echo isset($item) ? $item['email'] : ''; ?>" required>
                    </div>
					 <div class="form-group">
                        <label for="Password">Password <?php if($title == "Ubah Data Operator") { echo "<small style='color:#6688FF;'> (Kosongkan jika menggunakan password lama)</small>"; } ?></label>
                        <input type="password" class="form-control" id="password" name="password" value="" <?php if($title == "Tambah Data Operator") { echo "placeholder=\"Isi dengan password anda\" required"; } else { echo "placeholder=\"*****\"";} ?>>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="level">Level</label>
                        <select class="form-control" id="admin" name="admin" placeholder="Tidak harus diisi" value="<?php echo isset($item['admin']) ? $item['admin'] : ''; ?>">
						<?php if(isset($item['admin'])):?>
						<option value="<?php echo isset($item['admin']) ? $item['admin'] : ''; ?>" selected><?php $leveladmin = $this->db->get_where('gm_operator', array('id' => $item['id']))->row_array();  if($leveladmin['admin'] == "1") { echo "Super Admin"; } elseif ($leveladmin['admin'] == "2") { echo "Manager"; }elseif ($leveladmin['admin'] == "3") { echo "Technical Leader"; }elseif ($leveladmin['admin'] == "4") { echo "Admin Operational"; }elseif ($leveladmin['admin'] == "5") { echo "Technical Staff"; }elseif ($leveladmin['admin'] == "6") { echo "Asistant Manager"; }elseif ($leveladmin['admin'] == "7") { echo "Sales CE"; }elseif ($leveladmin['admin'] == "8") { echo "Sales Staff"; } echo $leveladmin['admin']; ?></option>	
			<?php endif; ?>	
						<option value="1">Super Admin</option>
						<option value="2">Manager</option>
						<option value="6">Ass.Manager</option>
						<option value="3">Technical Leader</option>
						<option value="4">Admin Teknis</option>
						<option value="5">Technical Staff</option>
						<option value="7">Sales CE</option>
						<option value="8">Sales Staff</option>
						</select>
                    </div>
					 <div class="form-group">
                        <label for="Email">Nomor Whatsapp</label>
                        <input type="number" class="form-control" id="no_wa" name="no_wa" placeholder="Isi dengan No Whatsapp Anda" value="<?php echo isset($item) ? $item['no_wa'] : ''; ?>" required>
                    </div>
					
					<div class="form-group">
                        <label for="Email">ID Telegram</label>
                        <input type="text" class="form-control" id="telegram" name="telegram" placeholder="Isi dengan ID telegram Anda" value="<?php echo isset($item) ? $item['telegram'] : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Operator<?php echo isset($item) ? "<small style='color:#6688FF;'> (kosongkan jika tidak ingin mengganti foto)</small>" : ""; ?></label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
					
					

                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="<?php echo base_url('manage/operator'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
