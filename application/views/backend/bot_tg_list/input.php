<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $title; ?></h3>
    </div>

    <hr class="panel-divider">

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
            echo form_open('manage/bot_tg_list/' . $item['id'] . '/timpa');
        } else {
            echo form_open('manage/bot_tg_list/simpan');
        }
        ?>
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Nama Bot</label>
                <input type="text" class="form-control" id="bot_nama" name="bot_nama" value="<?php echo isset($item) ? $item['bot_nama'] : ''; ?>" required autofocus>
            </div>
			</div>
			
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">API</label>
                <input type="text" class="form-control" id="bot_api" name="bot_api" value="<?php echo isset($item) ? $item['bot_api'] : ''; ?>" required autofocus>
            </div>
			
			</div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons">
                    <a href="<?php echo base_url('manage/bot_tg_list'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; KEMBALI</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
