
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
            echo form_open('manage/fiberstream/simpan_invoice');
        ?>
			<div class="col-md-6">
			 <div class="form-group">
                        <label for="level">CID Pelanggan</label>
                        <select class="form-control" id="cid" name="cid" placeholder="Pilih CID" value="">
						<?php foreach ($item_fs as $fs): ?>
						<option value="<?php echo $fs['cid']; ?>"><?php echo "$fs[cid] - $fs[nama]"; ?></option>
						<?php endforeach; ?>
						</select>
             </div>
			 
            
			
			</div>
			
			<div class="col-md-6">
			<div class="form-group">
                <label for="nama_keahlian">Tanggal Invoice</label>
				
                <input type="text" class="form-control datetimepicker-alt" id="datetime2" name="tanggal_invoice" required autofocus>
<script type="text/javascript">
$("#datetime2").datetimepicker({
	format: 'yyyy-mm-dd hh:ii',
	autoclose: true
});
</script>
            </div>
			
			</div>

            <hr>

            <div class="row">
                <div class="col-md-12 form-buttons" align="right">
                    <a href="<?php echo base_url('manage/scheduler'); ?>" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
                    &nbsp;
                    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>

        </form>

    </div>

</div>

<!-- END PANEL HEADLINE -->
<script type="text/javascript">
$(function () {
    var today = new Date();
	var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
	var time = today.getHours() + ":" + today.getMinutes();
	var dateTime = date+' '+time;
    $("#form_datetime").datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
		autoclose: true,
        todayBtn: true,
        startDate: dateTime
    });
});
</script>