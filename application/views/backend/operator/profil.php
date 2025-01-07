<!-- PANEL HEADLINE -->

<div class="panel panel-headline">


    <div class="panel-body">

        <div class="row">

            <div class="col-md-3">
                <a href="" class="thumbnail">
                    <?php if (empty($item['foto'])): ?>
                        <img src="<?php echo base_url('static/photos/default-user.png'); ?>">
                    <?php else: ?>
                        <img src="<?php echo base_url('static/photos/operator/' . $item['foto']); ?>">
                    <?php endif; ?>
                </a>
            </div>

            <div class="col-md-9">

                <table class="table table-striped table-bordered">
                    <tbody>
                        <tr>
                            <td>
                                <b>Nama Lengkap</b>
                            </td><td>
                                <?php echo $item['nama']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Email</b>
                            </td><td>
                                <?php echo $item['email']; ?>
                            </td>
                        </tr><tr>
                            <td>
                                <b>Hak Akses</b>
                            </td><td>
                                <?php if ($item['admin'] == "0") { echo "Operator"; } else { echo "Super Admin"; }  ?>
                            </td>
                        </tr>
						 <?php if ($item['admin'] == "0") {
						echo"<tr>
                            <td>
                                <b>Kabupaten</b>
                            </td><td>
                             ".ucwords(strtolower($this->db->query("SELECT * FROM regencies WHERE id='".$this->session->userdata('ses_kabupaten')."' LIMIT 1")->row_array()['name']))."
                            </td>
                        </tr>"; 
						}
						?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</div>

<!-- END PANEL HEADLINE -->
