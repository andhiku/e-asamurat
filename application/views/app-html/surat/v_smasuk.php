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
                    <input type="text" id="myInput" style="width: 25%; text-transform:uppercase;" class="form-control pull-left" onfocus="this.value = ''" placeholder="Pencarian surat masuk">
                    <button type="button" class="btn btn-primary" disabled><i class="fa fa-search"></i></button>
                    <?php if ($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') : ?>
                        <a href="#" class="btn btn-warning pull-right" title="Tambah Data Surat Masuk" data-toggle="modal" data-target="#add_smasuk"><i class="fa fa-plus"></i> Tambah Surat Masuk</a>
                    <?php endif; ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-striped" id="table_smasuk" width="100%">
                        <thead class="mini-font">
                            <tr>
                                <th rowspan="2" class="">#</th>
                                <th rowspan="2" class="">No. Surat</th>
                                <th rowspan="2" class="">Asal</th>
                                <th rowspan="2" class="text-center">Tgl.Surat</th>
                                <th rowspan="2" class="text-center">Tgl.Diterima</th>
                                <th rowspan="2" class="">Perihal</th>
                                <th rowspan="2" class="">Keterangan</th>
                                <th rowspan="2" class="">Status</th>
                                <th rowspan="2" class="text-center" style="width: 210px">Aksi</th>
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
                                    <td><?= ($row->asal); ?></td>
                                    <td><?= tgl_short_indo($row->tgl_surat); ?></td>
                                    <td><?= tgl_short_indo($row->tgl_terima); ?></td>
                                    <td><?= ($row->perihal); ?></td>
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
                                        <?php if (($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') AND $row->tujuan != '') : ?>
                                            <a href="#" onclick="ds_admin('<?= $row->id_surat; ?>');" class="btn btn-xs btn-success" title="Lembar Disposisi Admin"><i class="fa fa-eye"></i></a>
                                        <?php endif; ?>
                                        <?php if (($session['level_akses'] == 'super_admin' OR $session['level_akses'] == 'kalak' OR $session['level_akses'] == 'kabag' OR $session['level_akses'] == 'pelaksana') AND $row->tujuan == '0') : ?>
                                            <a href="#" onclick="ds_admin('<?= $row->id_surat; ?>');" class="btn btn-xs btn-success" title="Lembar Disposisi"><i class="fa fa-eye"></i></a>
                                        <?php endif; ?>
                                        <?php if (($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') AND $row->tujuan == '') : ?>
                                            <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#menunggu" title="Belum Selesai"><i class="fa fa-times"></i></a>
                                        <?php endif; ?>
                                        <?php if (($session['level_akses'] == 'kalak' OR $session['level_akses'] == 'super_admin') AND $row->lvl3 == '') : ?>
                                            <a href="#" onclick="ds_kalak('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Disposisi Kalak"><i class="fa fa-file"></i></a>
                                        <?php endif; ?>
                                        <?php if ($pgw == 'kabag' && ($session['level_akses'] == 'kabag' OR $session['level_akses'] == 'super_admin')) : ?>
                                            <a href="#" onclick="ds_kabag('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Disposisi Kabag" <?php if($pgw == 'selesai') {echo "style='display:none;'";} ?>><i class="fa fa-file"></i></a>
                                        <?php endif; ?>
                                        <?php if ($pgw == 'pelaksana' && ($session['level_akses'] == 'pelaksana' OR $session['level_akses'] == 'super_admin')) : ?>
                                            <a href="#" onclick="ds_pelaksana('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Disposisi Pelaksana" <?php if($pgw == 'selesai') {echo "style='display:none;'";} ?>><i class="glyphicon glyphicon-ok"></i></a>
                                        <?php endif; ?>
                                        <a href="#" onclick="viewpdf('<?= $row->id_surat; ?>');" class="btn btn-xs btn-success" title="File Surat Masuk"><i class="fa fa-eye"></i></a>
                                        <?php if ($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') : ?>
                                            <a href="#" onclick="edit_smasuk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" onclick="delete_smasuk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></a>
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

<div class="modal fade" id="add_smasuk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-80p">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Tambah Surat Masuk
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo site_url("surat/set_smasuk?method=add"); ?>" id="form_add_smasuk" method="post">
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="no" class="col-sm-1 control-label">No.&nbsp;Surat</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" name="no" onkeyup="this.value = this.value.toUpperCase();" placeholder="Masukkan nomor surat">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <!-- left column -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ts" class="col-sm-2 control-label">Tgl.&nbsp;Surat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="date" name="ts" placeholder="YYYY-MM-DD" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <!-- right column -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tt" class="col-sm-2 control-label">Tgl.&nbsp;Terima</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="date2" name="tt" placeholder="YYYY-MM-DD" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="asal" class="col-sm-1 control-label">Asal</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" rows="3" name="asal" onkeyup="this.value = this.value.toUpperCase();" placeholder="Pengirim surat">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="perihal" class="col-sm-1 control-label">Perihal</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" rows="3" name="perihal" onkeyup="this.value = this.value.toUpperCase();" placeholder="Perihal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ket" class="col-sm-1 control-label">Keterangan</label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" name="ket" onkeyup="this.value = this.value.toUpperCase();"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="file" class="col-sm-1 control-label">File&nbsp;Surat</label>
                                <div class="col-sm-11">
                                    <input class="form-control" type="file" id="file" name="filed" data-index="0" accept="application/pdf"/>
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

<div class="modal fade" id="edit_smasuk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-80p">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Edit Surat Masuk
                </h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" id="form_edit_smasuk" method="post">
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="no" class="col-sm-1 control-label">No.&nbsp;Surat</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" id="no" name="no" onkeyup="this.value = this.value.toUpperCase();" placeholder="Masukkan nomor surat" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <!-- left column -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ts" class="col-sm-2 control-label">Tgl.&nbsp;Surat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="date3" name="ts" placeholder="YYYY-MM-DD" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <!-- right column -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tt" class="col-sm-2 control-label">Tgl.&nbsp;Terima</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="date4" name="tt" placeholder="YYYY-MM-DD" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="asal" class="col-sm-1 control-label">Asal</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" rows="3" id="asal" name="asal" onkeyup="this.value = this.value.toUpperCase();" placeholder="Pengirim surat">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="perihal" class="col-sm-1 control-label">Perihal</label>
                                <div class="col-sm-11">
                                    <input type="text" class="form-control" rows="3" id="perihal" name="perihal" onkeyup="this.value = this.value.toUpperCase();" placeholder="Perihal">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="ket" class="col-sm-1 control-label">Keterangan</label>
                                <div class="col-sm-11">
                                    <textarea class="form-control" rows="3" id="ket" name="ket"  onkeyup="this.value = this.value.toUpperCase();"></textarea>
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
<div class="modal modal-default" id="delete_smasuk" tabindex="-1" data-backdrop="static" data-keyboard="false">
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
                <div id="del_smasuk"></div>
            </div>
        </div>
    </div>
</div>

<div id="viewpdf" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <embed src="" frameborder="0" width="100%" height="400px" id="filed" type="application/pdf">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ds_admin" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group form-group-sm">
                    <div class="col-xs-12">
                        <embed src="" frameborder="0" width="100%" height="450px" id="filera" type="application/pdf">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!--modal disposisi kalak-->
<div id="ds_kalak" class="modal fade">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <form id="form_ds_kalak" action="" method="post" class="form-horizontal" enctype="multipart/form-data" role="form" onsubmit="return validateForm();">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-8">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <embed src="" frameborder="0" width="100%" height="390px" id="filerb" type="application/pdf">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="tujuan" class="col-sm-1 control-label">Ditujukan&nbsp;Kepada</label>
                                <div class="col-xs-12">
                                    <select id="tujuan" name="tujuan" class="form-control tujuan select" style="width: 100%" onkeyup="kalak()" required>
                                        <option value="">- PILIHAN -</option>
                                        <?php foreach ($this->m_apps->listkabag() as $row) : ?>
                                            <option value='<?= $row->id; ?>'><?= $row->nama_lengkap . " - " . tempel('tb_bidang', 'nama_bidang', "id_bidang = '$row->id_bidang'"); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="isi" class="col-sm-1 control-label">Isi&nbsp;Disposisi</label>
                                <div class="col-xs-12">
                                    <textarea class="form-control isi" rows="4" id="isi" name="isi" onkeyup="kalak()" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <input type="button" value="Update" id="ttdkalak" data-toggle="modal" onkeyup="kalak()" onClick="submitKalak()" data-target="#confirm_kalak" class="btn btn-success" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_kalak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Konfirmasi !</h4>
            </div>
            <div class="modal-body">
                Apakah anda yakin untuk menindaklanjuti surat ?
                <form class="form-horizontal" enctype="multipart/form-data" action="" id="form_ttd_kalak" method="post">
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control tjn" name="tjn" id="tjn" value="">
                            <input type="hidden" class="form-control isii" name="isii" id="isii" value="">
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
                        <button type="submit" id="submit_ttdkalak" class="btn btn-success">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal disposisi kabag-->
<div id="ds_kabag" class="modal fade">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <form id="form_ds_kabag" action="" method="post" class="form-horizontal" enctype="multipart/form-data" role="form" onsubmit="return validateForm();">
                    <div class="form-group form-group-sm">
                        <div class="col-xs-8">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <embed src="" frameborder="0" width="100%" height="390px" id="filerc" type="application/pdf">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label for="tjn_akhir" class="col-sm-1 control-label">Ditujukan&nbsp;Kepada</label>
                                <div class="col-xs-12">
                                    <select id="tjn_akhir" name="tjn_akhir" class="form-control tjn_akhir select" style="width: 100%" onkeyup="kabag()" required>
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
                        <input type="button" value="Update" id="ttdkabag" data-toggle="modal" onkeyup="kabag()" data-target="#confirm_kabag" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_kabag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Konfirmasi !</h4>
            </div>
            <div class="modal-body">
                Apakah anda yakin untuk menindaklanjuti surat ?
                <form class="form-horizontal" enctype="multipart/form-data" action="" id="form_ttd_kabag" method="post">
                    <div class="form-group form-group-sm">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control tjn_end" name="tjn_end" id="tjn_end" value="">
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
                        <button type="submit" id="submit_ttdkabag" class="btn btn-success">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--modal disposisi pelaksana-->
<div id="ds_pelaksana" class="modal fade">
    <div class="modal-dialog modal-xlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <form id="form_ds_pelaksana" action="" method="post" class="form-horizontal" enctype="multipart/form-data" role="form" onsubmit="return validateForm();">
                    <!--                    <div class="form-group form-group-sm">
                                            <div class="col-xs-8">
                                                <div class="form-group">
                                                    <div class="col-xs-12">-->
                    <embed src="" frameborder="0" width="100%" height="400px" id="filerd" type="application/pdf">
                    <!--                                </div>
                                                </div>
                                            </div>
                                        </div>-->
                    <div class="modal-footer">
                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Close</button>
                        <input type="button" value="Update" id="ttdpelaksana" data-toggle="modal" data-target="#confirm_pelaksana" class="btn btn-success">
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

<div class="modal fade modal-warning menunggu" id="menunggu" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Maaf !</h4>
            </div>
            <div class="modal-body">
                <small>Lembar Disposisi belum diproses.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
//    $(document).ready(function () {
//        $('#table_smasuk').DataTable();
//    });
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
    function kalak() {
        if (document.getElementById("tujuan").value !== "" && document.getElementById("isi").value !== "") {
            document.getElementById('ttdkalak').disabled = false;
        } else {
            document.getElementById('ttdkalak').disabled = true;
        }
    }

// modal konfirmasi kalak
    $('#ttdkalak').click(function () {
        document.getElementById("tjn").value = $('.tujuan').val();
        document.getElementById("isii").value = $('.isi').val();
    });

    $('#submit_ttdkalak').click(function () {
        $('#form_ds_kalak').submit();
        $('#form_ttd_kalak').submit();
    });

// disable button jika belum mengisi tujuan
    function kabag() {
        if (document.getElementById("tjn_akhir").value !== "") {
            document.getElementById('ttdkabag').disabled = false;
        } else {
            document.getElementById('ttdkabag').disabled = true;
        }
    }

// modal konfirmasi kabag
    $('#ttdkabag').click(function () {
        document.getElementById("tjn_end").value = $('.tjn_akhir').val();
    });

    $('#submit_ttdkabag').click(function () {
        $('#form_ds_kabag').submit();
        $('#form_ttd_kabag').submit();
    });

// modal konfirmasi pelaksana
    $('#submit_ttdpelaksana').click(function () {
        $('#form_ds_pelaksana').submit();
        $('#form_ttd_pelaksana').submit();
    });
</script>