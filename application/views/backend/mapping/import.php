<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">DATA ODP</div>


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
			echo form_open_multipart('manage/mapping/simpan_import');
        ?>
			<div class="col-md-6">
            <div class="form-group">
                <label for="nama_keahlian">File Excel Data ODP</label>
                <input type="file" class="form-control" id="fileExcel" name="fileExcel" required autofocus>
             </div>
			
			</div>


            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons">
                    <a href="<?php echo base_url('manage/mapping'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; KEMBALI</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
