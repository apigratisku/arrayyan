				</div>

			</div>
			<nav class="navbar-default navbar-fixed-bottom">
				<div style="color:#FFFFFF; background-color:#157dc6; font-weight:bold; text-align:center; padding:7px 0px 7px 0px"><span style="font-weight:normal">Powered by</span> Gmedia Mataram</div>
			</nav>
			<!-- END MAIN CONTENT -->
			
		</div>
		<!-- END MAIN -->

		<div class="clearfix"></div>

	</div>
	<!-- END WRAPPER -->


	<!-- Javascript -->
	<script src="<?php echo base_url('static/'); ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url('static/'); ?>assets/scripts/bootstrap.min.js"></script>
	<script src="<?php echo base_url('static/'); ?>assets/scripts/jquery-datatables.min.js"></script>
	<script src="<?php echo base_url('static/'); ?>assets/scripts/bootstrap-datatables.min.js"></script>
    <script src="<?php echo base_url('static/'); ?>assets/scripts/summernote.min.js"></script>
    <script src="<?php echo base_url('static/'); ?>assets/scripts/select2.min.js"></script>
    <script src="<?php echo base_url('static/'); ?>assets/scripts/chartist.min.js"></script>
	<script src="<?php echo base_url('static/'); ?>assets/scripts/moment-with-locales.min.js"></script>
	<script src="<?php echo base_url('static/'); ?>assets/scripts/bootstrap-datetimepicker.min.js"></script>
	<script src="<?php echo base_url('static/'); ?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="<?php echo base_url('static/'); ?>assets/scripts/klorofil-common.js"></script>


	<script type="text/javascript">
        

	    $(document).ready(function() {

            <?php if (isset($scripts)) { echo $scripts; } ?>
			$('#data-table thead tr').clone(true).appendTo( '#data-table thead' );
            $('#data-table thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
			
			var table = $('#data-table').DataTable( {
                orderCellsTop: true,
                "pagingType": "full_numbers",
                "language": {
                    "emptyTable": "Belum ada data",
                    "info": "Terdapat _TOTAL_ data",
                    "infoEmpty": "",
                    "infoFiltered": "Mencari dari total _MAX_ data",
                    "lengthMenu": "_MENU_ &nbsp;data per halaman",
                    "paginate": {
                        "first": "<i class='fa fa-backward' aria-hidden='true'></i>",
                        "last": "<i class='fa fa-forward' aria-hidden='true'></i>",
                        "next": "<i class='fa fa-chevron-right' aria-hidden='true'></i>",
                        "previous": "<i class='fa fa-chevron-left' aria-hidden='true'></i>"
                    },
                    "search": "Cari",
                    "zeroRecords": "Hasil pencarian tidak ditemukan"
                },
                "order": []
            });
			
			$('#data-table1 thead tr').clone(true).appendTo( '#data-table1 thead' );
            $('#data-table1 thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table1.column(i).search() !== this.value ) {
                        table1
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
			
			var table1 = $('#data-table1').DataTable( {
                orderCellsTop: true,
                "pagingType": "full_numbers",
                "language": {
                    "emptyTable": "Belum ada data",
                    "info": "Terdapat _TOTAL_ data",
                    "infoEmpty": "",
                    "infoFiltered": "Mencari dari total _MAX_ data",
                    "lengthMenu": "_MENU_ &nbsp;data per halaman",
                    "paginate": {
                        "first": "<i class='fa fa-backward' aria-hidden='true'></i>",
                        "last": "<i class='fa fa-forward' aria-hidden='true'></i>",
                        "next": "<i class='fa fa-chevron-right' aria-hidden='true'></i>",
                        "previous": "<i class='fa fa-chevron-left' aria-hidden='true'></i>"
                    },
                    "search": "Cari",
                    "zeroRecords": "Hasil pencarian tidak ditemukan"
                },
                "order": []
            });
			
			$('#data-table2 thead tr').clone(true).appendTo( '#data-table2 thead' );
            $('#data-table2 thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table2.column(i).search() !== this.value ) {
                        table2
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
			
			var table2 = $('#data-table2').DataTable( {
                orderCellsTop: true,
                "pagingType": "full_numbers",
                "language": {
                    "emptyTable": "Belum ada data",
                    "info": "Terdapat _TOTAL_ data",
                    "infoEmpty": "",
                    "infoFiltered": "Mencari dari total _MAX_ data",
                    "lengthMenu": "_MENU_ &nbsp;data per halaman",
                    "paginate": {
                        "first": "<i class='fa fa-backward' aria-hidden='true'></i>",
                        "last": "<i class='fa fa-forward' aria-hidden='true'></i>",
                        "next": "<i class='fa fa-chevron-right' aria-hidden='true'></i>",
                        "previous": "<i class='fa fa-chevron-left' aria-hidden='true'></i>"
                    },
                    "search": "Cari",
                    "zeroRecords": "Hasil pencarian tidak ditemukan"
                },
                "order": []
            });
			
			$('#data-table3 thead tr').clone(true).appendTo( '#data-table3 thead' );
            $('#data-table3 thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table3.column(i).search() !== this.value ) {
                        table3
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
			
			var table3 = $('#data-table3').DataTable( {
                orderCellsTop: true,
                "pagingType": "full_numbers",
                "language": {
                    "emptyTable": "Belum ada data",
                    "info": "Terdapat _TOTAL_ data",
                    "infoEmpty": "",
                    "infoFiltered": "Mencari dari total _MAX_ data",
                    "lengthMenu": "_MENU_ &nbsp;data per halaman",
                    "paginate": {
                        "first": "<i class='fa fa-backward' aria-hidden='true'></i>",
                        "last": "<i class='fa fa-forward' aria-hidden='true'></i>",
                        "next": "<i class='fa fa-chevron-right' aria-hidden='true'></i>",
                        "previous": "<i class='fa fa-chevron-left' aria-hidden='true'></i>"
                    },
                    "search": "Cari",
                    "zeroRecords": "Hasil pencarian tidak ditemukan"
                },
                "order": []
            });
            
			
            $('.js-select').select2({
                theme: "bootstrap"
            });
	        $('.datetimepicker').datetimepicker({
                locale: 'id',
                format: 'YYYY-MM-DD',
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

</html>
