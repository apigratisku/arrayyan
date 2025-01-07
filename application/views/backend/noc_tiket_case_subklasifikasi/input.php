<?php
date_default_timezone_set("Asia/Singapore");
?>
<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">
			NOC - SISTEM TIKET - CASE SUB KLASIFIKASI
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
            echo form_open('manage/noc_tiket_case_subklasifikasi/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/noc_tiket_case_subklasifikasi/simpan');
			
        }
        ?>
			<div class="col-md-6">
			

			
			<div class="form-group">
                <label for="nama_keahlian">Case Sub Klasifikasi</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($item['nama']) ? $item['nama'] : ''; ?>" autofocus required>
            </div>

			
			
			<div class="row">
                <div class="col-md-12 form-buttons" align="left">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    &nbsp;
                    <a href="<?php echo base_url('manage/noc_tiket_case_subklasifikasi'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                </div>
            </div>

			</div>



        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->

