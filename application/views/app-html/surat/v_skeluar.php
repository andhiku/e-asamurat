<?php
$session = $this->session->userdata('login');
?>
<script src="<?php echo base_url('assets/surat/jquery-1.11.1.min.js'); ?>"></script>

<!--<section class="content-header">
    <h1><small><b>Surat Masuk</b></small></h1>
</section>-->

<section class="content responsive">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <input type="text" id="myInput" style="width: 25%; text-transform:uppercase;" class="form-control pull-left" onfocus="this.value = ''" placeholder="Pencarian surat keluar">
                    <button type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                    <?php if ($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') : ?>
                        <a href="#" class="btn btn-warning pull-right" title="Tambah Data Surat Keluar" data-toggle="modal" data-target="#add_skeluar"><i class="fa fa-plus"></i> Tambah Surat Keluar</a>
                    <?php endif; ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-striped table-dark" id="table_smasuk" width="100%">
                        <thead class="mini-font">
                            <tr>
                                <th rowspan="2" class="">#</th>
                                <th rowspan="2" class="">No. Surat</th>
                                <th rowspan="2" class="">Perihal</th>
                                <th rowspan="2" class="text-center">Tgl.Surat</th>
                                <th rowspan="2" class="text-center">Tgl.Proses</th>
                                <th rowspan="2" class="">Keterangan</th>
                                <th rowspan="2" class="">Status</th>
                                <th rowspan="2" class="text-center" style="width: 180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="mini-font" id="myTable">
                            <?php
                            $no = (!$this->input->get('page')) ? 0 : $this->input->get('page');
                            foreach ($data_surat as $row) :
                                $pgw = ($row->status);
                                ?>
                                <tr>
                                    <td><?= ++$no; ?>.</td>
                                    <td><?= ($row->no_surat); ?></td>
                                    <td><?= ($row->perihal); ?></td>
                                    <td class="text-center"><?= tgl_short_indo($row->tgl_surat); ?></td>
                                    <td class="text-center"><?= tgl_short_indo($row->tgl_proses); ?></td>
                                    <?php
                                    if ($row->keterangan == '0') {
                                        echo "<td></td>";
                                    } else {
                                        echo "<td>" . $row->keterangan . "</td>";
                                    }
                                    ?>
                                    <td><?php
                                        if ($pgw == 'admin') : echo 'Menunggu Kepala Pelaksana';
                                        elseif ($pgw == 'kalak') : echo 'Diproses Kepala Pelaksana';
                                        elseif ($pgw == 'kabag') : echo 'Diproses Kepala Bagian';
                                        elseif ($pgw == 'pelaksana') : echo 'Diproses Pelaksana';
                                        elseif ($pgw == 'selesai') : echo 'Selesai';
                                        endif;
                                        ?></td>
                                    <td class="text-center">
                                        <?php if (($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') AND $row->tujuan == '') : ?>
                                            <a href="#" onclick="gen_pdf('<?= $row->id_surat; ?>');" class="btn btn-xs btn-success" title="Buat PDF"><i class="fa fa-file-pdf-o"></i></a>
                                        <?php endif; ?>
                                        <?php if (($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') AND $row->tujuan != '') : ?>
                                            <a href="#" onclick="ds_adminsk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-success" title="Lembar Surat Keluar Admin"><i class="fa fa-eye"></i></a>
                                        <?php endif; ?>
                                        <?php if (($session['level_akses'] == 'super_admin' OR $session['level_akses'] == 'kalak' OR $session['level_akses'] == 'kabag' OR $session['level_akses'] == 'pelaksana') AND $row->tujuan == '0') : ?>
                                            <a href="#" onclick="ds_adminsk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-success" title="Lembar Surat Keluar"><i class="fa fa-eye"></i></a>
                                        <?php endif; ?>
                                        <?php if (($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') AND $row->tujuan == '') : ?>
                                            <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#menunggu" title="Belum Selesai"><i class="fa fa-times"></i></a>
                                        <?php endif; ?>
                                        <?php if (($session['level_akses'] == 'kalak' OR $session['level_akses'] == 'super_admin') AND $row->lvl3 == '') : ?>
                                            <a href="#" onclick="ds_kalaksk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Surat Keluar Kalak"><i class="fa fa-file"></i></a>
                                        <?php endif; ?>
                                        <?php if ($pgw == 'kabag' && ($session['level_akses'] == 'kabag' OR $session['level_akses'] == 'super_admin')) : ?>
                                            <a href="#" onclick="ds_kabagsk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Surat Keluar Kabag" <?php if($pgw == 'selesai') {echo "style='display:none;'";} ?>><i class="fa fa-file"></i></a>
                                        <?php endif; ?>
                                        <?php if ($pgw == 'pelaksana' && ($session['level_akses'] == 'pelaksana' OR $session['level_akses'] == 'super_admin')) : ?>
                                            <a href="#" onclick="ds_pelaksanask('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Surat Keluar Pelaksana" <?php if($pgw == 'selesai') {echo "style='display:none;'";} ?>><i class="glyphicon glyphicon-ok"></i></a>
                                        <?php endif; ?>
                                        <?php if ($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') : ?>
                                            <a href="#" onclick="edit_skeluar('<?= $row->id_surat; ?>');" class="btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" onclick="delete_skeluar('<?= $row->id_surat; ?>');" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="col-md-12">
                        <?php echo $this->pagination->create_links(); ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="add_skeluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-80p">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Surat Keluar
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url("surat/set_skeluar?method=add"); ?>" id="form_add_skeluar" method="post">
                    <div class="form-group form-group-sm">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nosk" class="col-sm-2 control-label">No.&nbsp;Surat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nosk" onkeyup="this.value = this.value.toUpperCase();" placeholder="Masukkan nomor surat">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tssk" class="col-sm-2 control-label">Tgl.&nbsp;Surat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="date3" name="tssk" placeholder="YYYY-MM-DD" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="perihalsk" class="col-sm-1 control-label">Perihal</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" rows="3" name="perihalsk" onkeyup="this.value = this.value.toUpperCase();" placeholder="Perihal surat">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="tmptjsk" class="col-sm-1 control-label">Tujuan</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" rows="3" name="tmptjsk" onkeyup="this.value = this.value.toUpperCase();" placeholder="Tempat tujuan tugas">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ketsk" class="col-sm-1 control-label">Keterangan</label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" name="ketsk" onkeyup="this.value = this.value.toUpperCase();"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-warning pull-left">Reset</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_skeluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-80p">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Edit Surat Keluar
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" id="form_edit_skeluar" method="post">
                    <div class="form-group form-group-sm">
                        <!-- left column -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nosk" class="col-sm-2 control-label">No.&nbsp;Surat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nosk" name="nosk" onkeyup="this.value = this.value.toUpperCase();" placeholder="Masukkan nomor keluar" disabled>
                                </div>
                            </div>
                        </div>
                        <!-- right column -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tssk" class="col-sm-2 control-label">Tgl.&nbsp;Surat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="date4" name="tssk" placeholder="YYYY-MM-DD" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="perihalsk" class="col-sm-1 control-label">Perihal</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" rows="3" id="perihalsk" name="perihalsk" onkeyup="this.value = this.value.toUpperCase();" placeholder="Perihal" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="tmptjsk" class="col-sm-1 control-label">Tujuan</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" rows="3" id="tmptjsk" name="tmptjsk" onkeyup="this.value = this.value.toUpperCase();" placeholder="Tempat tujuan tugas" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ketsk" class="col-sm-1 control-label">Keterangan</label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" id="ketsk" name="ketsk"  onkeyup="this.value = this.value.toUpperCase();"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Hapus -->
<div class="modal modal-default" id="delete_skeluar" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Peringatan</h4>
            </div>
            <div class="modal-body">
                <p>Yakin anda akan menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Tidak</a>
                <div id="del_skeluar"></div>
            </div>
        </div>
    </div>
</div>

<div id="ds_adminsk" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <embed src="" frameborder="0" width="100%" height="450px" id="filerh" type="application/pdf">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_kalaksk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Konfirmasi !</h4>
            </div>
            <div class="modal-body">
                Apakah anda yakin untuk menindaklanjuti surat ?
                <form class="form-horizontal" enctype="multipart/form-data" action="" id="form_ttd_kalaksk" method="post">
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control tjnsk" name="tjnsk" id="tjnsk" value="">
                            <input type="hidden" class="form-control isiisk" name="isiisk" id="isiisk" value="">
                        </div>
                    </div>
                    Mohon masukkan password untuk mengkonfirmasi.
                    <div class="form-group">
                        <label for="password" class="col-sm-1 control-label">Password</label>
                        <div class="col-sm-12">
                            <input name="password" type="password" id="password" class="form-control" placeholder="Masukkan password anda" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_ttdkalaksk" class="btn btn-success">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal disposisi kalak-->
<div id="ds_kalaksk" class="modal fade">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <form id="form_ds_kalaksk" action="" method="post" class="form-horizontal" enctype="multipart/form-data" role="form" onsubmit="return validateForm();">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-8">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <embed src="" frameborder="0" width="100%" height="390px" id="fileri" type="application/pdf">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="tujuansk" class="col-sm-1 control-label">Ditujukan&nbsp;Kepada</label>
                                <div class="col-xs-12">
                                    <select id="tujuansk" name="tujuansk" class="form-control tujuansk select" style="width: 100%" onkeyup="kalaksk()" required>
                                        <option value="">- PILIHAN -</option>
                                        <?php foreach ($this->m_apps->listkabag() as $row) : ?>
                                            <option value='<?= $row->id; ?>'><?= $row->nama_lengkap . " - " . tempel('tb_bidang', 'nama_bidang', "id_bidang = '$row->id_bidang'"); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="isisk" class="col-sm-1 control-label">Isi&nbsp;Disposisi</label>
                                <div class="col-xs-12">
                                    <textarea class="form-control isisk" rows="4" id="isisk" name="isisk" onkeyup="kalaksk()" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <input type="button" value="Update" id="ttdkalaksk" data-toggle="modal" onkeyup="kalaksk()" data-target="#confirm_kalaksk" class="btn btn-success" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_kabagsk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Konfirmasi !</h4>
            </div>
            <div class="modal-body">
                Apakah anda yakin untuk menindaklanjuti surat ?
                <form class="form-horizontal" enctype="multipart/form-data" action="" id="form_ttd_kabagsk" method="post">
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control tjn_endsk" name="tjn_endsk" id="tjn_endsk" value="">
                        </div>
                    </div>
                    Mohon masukkan password untuk mengkonfirmasi.
                    <div class="form-group">
                        <label for="password" class="col-sm-1 control-label">Password</label>
                        <div class="col-sm-12">
                            <input name="password" type="password" id="password" class="form-control" placeholder="Masukkan password anda" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_ttdkabagsk" class="btn btn-success">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal disposisi kabag-->
<div id="ds_kabagsk" class="modal fade">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <form id="form_ds_kabagsk" action="" method="post" class="form-horizontal" enctype="multipart/form-data" role="form" onsubmit="return validateForm();">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-8">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <embed src="" frameborder="0" width="100%" height="390px" id="filerj" type="application/pdf">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="tjn_akhirsk" class="col-sm-1 control-label">Ditujukan&nbsp;Kepada</label>
                                <div class="col-xs-12">
                                    <select id="tjn_akhir" name="tjn_akhirsk" class="form-control tjn_akhirsk select" style="width: 100%" onkeyup="kabag()" required>
                                        <option value="">- PILIHAN -</option>
                                        <?php foreach ($this->m_apps->listpelaksana() as $row) : ?>
                                            <option value='<?= $row->id; ?>'><?= $row->nama_lengkap . " - " . tempel('tb_bidang', 'nama_bidang', "id_bidang = '$row->id_bidang'"); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <input type="button" value="Update" id="ttdkabagsk" data-toggle="modal" onkeyup="kabagsk()" data-target="#confirm_kabagsk" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_pelaksana" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Konfirmasi !</h4>
            </div>
            <div class="modal-body">
                Apakah anda yakin untuk menindaklanjuti surat ?
                <form class="form-horizontal" enctype="multipart/form-data" action="" id="form_ttd_pelaksana" method="post">
                    Mohon masukkan password untuk mengkonfirmasi.
                    <div class="form-group">
                        <label for="password" class="col-sm-1 control-label">Password</label>
                        <div class="col-sm-12">
                            <input name="password" type="password" id="password" class="form-control" placeholder="Masukkan password anda" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_ttdpelaksana" class="btn btn-success">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal disposisi pelaksana-->
<div id="ds_pelaksanask" class="modal fade">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <form id="form_ds_pelaksanask" action="" method="post" class="form-horizontal" enctype="multipart/form-data" role="form" onsubmit="return validateForm();">
                    <embed src="" frameborder="0" width="100%" height="400px" id="filerk" type="application/pdf">
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <input type="button" value="Update" id="ttdpelaksanask" data-toggle="modal" data-target="#confirm_pelaksanask" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_pelaksanask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Konfirmasi !</h4>
            </div>
            <div class="modal-body">
                Apakah anda yakin untuk menindaklanjuti surat ?
                <form class="form-horizontal" enctype="multipart/form-data" action="" id="form_ttd_pelaksanask" method="post">
                    Mohon masukkan password untuk mengkonfirmasi.
                    <div class="form-group">
                        <label for="password" class="col-sm-1 control-label">Password</label>
                        <div class="col-sm-12">
                            <input name="password" type="password" id="password" class="form-control" placeholder="Masukkan password anda" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_ttdpelaksanask" class="btn btn-success">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-warning menunggu" id="menunggu" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Maaf !</h4>
            </div>
            <div class="modal-body">
                <small>Lembar surat keluar belum diproses pimpinan.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-warning gen_pdf" id="gen_pdf" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Berhasil !</h4>
            </div>
            <div class="modal-body">
                <small>File PDF lembar surat keluar selesai dibuat.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
// date picker
    $(document).ready(function () {
        var date_input = $('input[name="date"]'); //our date input has the name "date"
        var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
        var options = {
            format: 'mm/ddd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true
        };
        date_input.datepicker(options);
    });

// pencarian
    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

// disable button jika belum mengisi tujuan dan isi
    function kalaksk() {
        if (document.getElementById("tujuansk").value !== "" && document.getElementById("isisk").value !== "") {
            document.getElementById('ttdkalaksk').disabled = false;
        } else {
            document.getElementById('ttdkalaksk').disabled = true;
        }
    }

// modal konfirmasi kalak
    $('#ttdkalaksk').click(function () {
        document.getElementById("tjnsk").value = $('.tujuansk').val();
        document.getElementById("isiisk").value = $('.isisk').val();
    });

    $('#submit_ttdkalaksk').click(function () {
        $('#form_ds_kalaksk').submit();
        $('#form_ttd_kalaksk').submit();
    });

// disable button jika belum mengisi tujuan
    function kabagsk() {
        if (document.getElementById("tjn_akhirsk").value !== "") {
            document.getElementById('ttdkabagsk').disabled = false;
        } else {
            document.getElementById('ttdkabagsk').disabled = true;
        }
    }

// modal konfirmasi kabag
    $('#ttdkabagsk').click(function () {
        document.getElementById("tjn_endsk").value = $('.tjn_akhirsk').val();
    });

    $('#submit_ttdkabagsk').click(function () {
        $('#form_ds_kabagsk').submit();
        $('#form_ttd_kabagsk').submit();
    });

// modal konfirmasi pelaksana
    $('#submit_ttdpelaksanask').click(function () {
        $('#form_ds_pelaksanask').submit();
        $('#form_ttd_pelaksanask').submit();
    });
</script>