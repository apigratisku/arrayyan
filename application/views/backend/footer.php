</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
  
    <div class="pull-right hidden-xs">
       <span style="color:#FFF"><b>Version</b> 1.3</span>
    </div>
    <span style="color:#FFF">Copyright &copy; 2022 <a href="https://arrayyan.web.id" style="color:#ff4e00;">BLiP NTB</a> | Created by -Adhit-</span>
	
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
   

  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script src="<?php echo base_url('static/'); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Select2 -->
<script src="<?php echo base_url('static/'); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url('static/'); ?>assets/bower_components/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url('static/'); ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?php echo base_url('static/'); ?>assets/bower_components/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/morris.js/morris.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/js/adminlte.min.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/js/pages/dashboard.js"></script>
<script src="<?php echo base_url('static/'); ?>assets/js/demo.js"></script>

<script type="text/javascript">
 $(document).ready(function() {
     $('#pelanggan').select2();
 });
</script>
<script type="text/javascript">
 $(document).ready(function() {
     $('#input_nama_exist').select2();
 });
</script>
<script type="text/javascript">
 $(document).ready(function() {
     $('#input_nama_survey').select2();
 });
</script>
<script type="text/javascript">
 $(document).ready(function() {
     $('#input_bts').select2();
 });
</script>
<script type="text/javascript">
 $(document).ready(function() {
     $('#input_odp').select2();
 });
</script>
<script type="text/javascript">
 $(document).ready(function() {
     $('#id_perangkat').select2();
 });
</script>
<script type="text/javascript">
 $(document).ready(function() {
     $('#lokasi_pelanggan').select2();
 });
</script>
<script>
  $(function () {
   $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>


	<script type="text/javascript">
        

	    $(document).ready(function() {

            
            $('.js-select').select2({
                theme: "bootstrap"
            });
	        $('.datetimepicker').datetimepicker({
                locale: 'id',
                format: "YYYY-MM-DD",
                viewMode: 'years',
                widgetPositioning: {
                    vertical: 'top',
                }
            });
            $('.datetimepicker-alt').datetimepicker({
                locale: 'id',
                format: 'YYYY-MM-DD',
                widgetPositioning: {
                    vertical: 'top',
                }
            });
	    });
	</script>
</body>