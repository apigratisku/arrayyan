<div class="panel panel-headline">
<div style="background-color:#222d32; font-weight:bold; color:#ff4e00; font-size:20px; padding:10px 0px 10px 10px">Detail Data Tiket</div>
<br>


    <div class="panel-body">

        <div class="row">


            <div class="col-md-12">

                <table class="table table-striped table-bordered" style="font-size:11px">
                    <tbody>
                        <tr>
                            <td>
                                <b>Tahun</b>
                            </td><td>
                                <?php echo $item['tahun']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Bulan</b>
                            </td><td>
                                <?php echo $item['bulan']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Week</b>
                            </td><td>
                                 <?php echo $item['week']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>POP</b>
                            </td><td>
								<?php echo $item['pop']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Customers</b>
                            </td><td>
                             <?php $customers = $this->db->get_where('blip_pelanggan', array('id' => $item['customers']))->row_array(); ?>
                             <?php echo $customers['nama'];  ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Case</b>
                            </td><td>
                               <?php echo $item['case_gangguan']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Case Klasifikasi</b>
                            </td><td>
                        <?php $case_klasifikasi = $this->db->get_where('blip_tiket_case_klasifikasi', array('id' => $item['case_klasifikasi']))->row_array(); ?>
                        <?php echo $case_klasifikasi['nama'];  ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Case Sub Klasifikasi</b>
                            </td><td>
                        <?php $case_subklasifikasi = $this->db->get_where('blip_tiket_case_subklasifikasi', array('id' => $item['case_subklasifikasi']))->row_array(); ?>
                        <?php echo $case_subklasifikasi['nama'];  ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tanggal Open</b>
                            </td><td>
                                <?php echo $item['tgl_open']; ?> <?php echo $item['jam_open']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Eskalasi NOC</b>
                            </td><td>
                                <?php echo $item['eskalasi_noc']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>NOC IP Core</b>
                            </td><td>
                        <?php $noc_ip_core = $this->db->get_where('blip_tiket_noc_ipcore', array('id' => $item['noc_ip_core']))->row_array(); ?>
                        <?php echo $noc_ip_core['nama'];  ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>NOC HD On Dutty</b>
                            </td><td>
                        <?php $noc_hd = $this->db->get_where('blip_tiket_noc_hd', array('id' => $item['noc_hd_duty']))->row_array(); ?>
                        <?php echo $noc_hd['nama'];  ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Eskalasi Akhir</b>
                            </td><td>
                        <?php $eskalasi_akhir = $this->db->get_where('blip_tiket_eskalasi', array('id' => $item['eskalasi_akhir']))->row_array(); ?>
                        <?php echo $eskalasi_akhir['nama'];  ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>PIC</b>
                            </td><td>
                         <?php echo $item['pic']; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Problem</b>
                            </td><td>
                         <?php echo $item['problem']; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Action</b>
                            </td><td>
                         <?php echo $item['action']; ?>
                            </td>
                        </tr>
						<tr>
                            <td>
                                <b>Status</b>
                            </td><td>
                         <b><?php echo $item['status']; ?></b>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Tanggal Close</b>
                            </td><td>
                                <?php echo $item['tgl_close']; ?> <?php echo $item['jam_close']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Durasi Stop Clock NOC</b>
                            </td><td>
                                <?php 
								//Hitung Durasi 
								$awal  = strtotime($item['tgl_open']." ".$item['jam_open']);
								$akhir = strtotime($item['tgl_close']." ".$item['jam_close']);
								//$awal  = strtotime('2017-08-10 10:05:25');
								//$akhir = strtotime('2017-08-11 11:07:33');
								$diff  = $akhir - $awal;
								
								$jam   = floor($diff / (60 * 60));
								$menit = $diff - ( $jam * (60 * 60) );
								$detik = $diff % 60;
								$str_jam = $jam * 60;
								$str_menit = floor( $menit / 60 );
								$str_durasi = $str_jam+$str_menit;
								echo $str_durasi." menit";
								//echo $item['durasi']; 
								
								?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Durasi Solving</b>
                            </td><td>
                                <?php 
								//Hitung Durasi 
								$awal_sla  = strtotime($item['tgl_open']." ".$item['jam_open']);
								$akhir_sla = strtotime($item['tgl_close_sla']." ".$item['jam_close_sla']);
								//$awal  = strtotime('2017-08-10 10:05:25');
								//$akhir = strtotime('2017-08-11 11:07:33');
								$diff_sla  = $akhir_sla - $awal_sla;
								
								$jam_sla   = floor($diff_sla / (60 * 60));
								$menit_sla = $diff_sla - ( $jam_sla * (60 * 60) );
								$detik_sla = $diff_sla % 60;
								$str_jam_sla = $jam_sla * 60;
								$str_menit_sla = floor( $menit_sla / 60 );
								$str_durasi_sla = $str_jam_sla+$str_menit_sla;
								echo $str_durasi_sla." menit";
								//echo $item['durasi']; 
								
								?>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
<div align="right">
				<?php if($this->session->userdata('ses_admin')=='1' || $this->session->userdata('ses_admin')=='3' || $this->session->userdata('ses_admin')=='5'):?>
                <a href="<?php echo base_url('manage/noc_tiket_list'); ?>" class="btn btn-warning">KEMBALI</a>
				<?php endif; ?>
            </div>
 </div>

</div>

<!-- END PANEL HEADLINE -->
