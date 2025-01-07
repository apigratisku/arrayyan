<!-- PANEL HEADLINE -->

<div class="panel panel-headline">

    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $title; ?></h3>
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

        <?php 
            echo form_open_multipart(base_url('manage/operator/prosespwd'));
        ?>

            <div class="row">

                <div class="col-md-6">

					 <div class="form-group">
                        <label for="Password">Password Lama</label>
                        <input type="password" class="form-control" id="password1" name="password1"  required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="Password">Password Baru</label>
                        <input type="password" class="form-control" id="password2" name="password2"  required>
                    </div>

                    <div class="form-group">
                        <label for="Password">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password3" name="password3"  required>
                    </div>

                </div>

            </div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; SIMPAN</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
