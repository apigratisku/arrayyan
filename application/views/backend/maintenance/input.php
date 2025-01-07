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
            echo form_open('manage/maintenance/' . $item['id'] . '/user_akses_timpa');
        } else {
            echo form_open('manage/maintenance/user_akses_simpan');
        }
        ?>
			<div class="col-md-6">
            <div class="form-group">
                        <label for="level">Role</label>
                        <select class="form-control" id="idrouter" name="idrouter" placeholder="Pilih Router" value="<?php echo isset($item) ? $item['idrouter'] : ''; ?>">
						<?php foreach ($item_router as $router): ?>
						
						<?php if ($router['idrouter'] == $id_lokalan['idrouter']): ?>
						<option value="<?php echo $router['id']; ?>" selected="selected"><?php echo $router['nama']; ?></option>
						<?php else: ?>
						<option value="<?php echo $router['id']; ?>"><?php echo $router['nama']; ?></option>
						<?php endif; ?>
						<?php endforeach; ?>
						</select>
             </div>
			<div class="form-group">
                <label for="nama_keahlian">User</label>
                <input type="text" class="form-control" id="user" name="user" value="<?php echo isset($item) ? $item['area'] : ''; ?>" required autofocus>
            </div>
			</div>
			
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Password</label>
                <input type="text" class="form-control" id="ip" name="ip" value="<?php echo isset($item) ? $item['ip'] : ''; ?>" required autofocus>
            </div>
			
			</div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons">
                    <a href="<?php echo base_url('manage/lokalan'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; KEMBALI</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
