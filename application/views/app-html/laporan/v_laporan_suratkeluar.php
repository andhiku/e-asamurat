<?php
$where = array(
    'status' => $this->input->get('status'),
    'bln' => $this->input->get('bln'),
    'thn' => $this->input->get('thn'),
);
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Laporan Surat Keluar</h3>
                    <div class="box-tools">
                        <a href="<?php echo site_url("laporan_suratkeluar/cetak?status={$where['status']}&bln={$where['bln']}&thn={$where['thn']}"); ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form action="" method="get">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status Surat Keluar :</label>
                                <select class="form-control input-sm" style="width: 100%;" name="status">
                                    <option value="">- SEMUA -</option>
                                    <option value="admin">Admin</option>
                                    <option value="kalak">Kepala Pelaksana</option>
                                    <option value="kabag">Kepala Bagian</option>
                                    <option value="pelaksana">Pelaksana</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Bulan :</label>
                                <select class="form-control input-sm" style="width: 100%;" name="bln">
                                    <option value="">- SEMUA BULAN -</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei </option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tahun :</label>
                                <input type="text" name="thn" class="form-control input-sm" value="<?php echo $where['thn'] ?>" placeholder=" - SEMUA TAHUN - " autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                </br>
                                <button type="submit" class="btn btn-success right"><i class="fa fa-search"></i> Filter</button>
                                <a href="<?php echo site_url('laporan_suratkeluar') ?>" class="btn btn-danger right" style="margin-left: 10px;"><i class="fa fa-times"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover" width="100%">
                        <thead class="mini-font">
                            <tr>
                                <th rowspan="2" class="text-center">#</th>
                                <th rowspan="2" class="text-center">Nomor<br>Surat</th>
                                <th rowspan="2" class="text-center">Perihal</th>
                                <th colspan="2" class="text-center">Tanggal</th>
                                <th rowspan="2" class="text-center">Isi</th>
                                <th rowspan="2" class="text-center">Tujuan</th>
                                <th rowspan="2" class="text-center">Status</th>
                                <th rowspan="2" class="text-center">Keterangan</th>
                                <th rowspan="2" class="text-center" style="width: 80px">Aksi</th>
                            </tr>
                            <tr>
                                <th rowspan="1" class="text-center">&nbsp;&nbsp;Tgl.&nbsp;Surat&nbsp;&nbsp;</th>
                                <th rowspan="1" class="text-center">Tgl.&nbsp;Terima</th>
                            </tr>
                        </thead>
                        <tbody class="mini-font">
                            <?php
                            $no = ($this->input->get('page')) ? $this->input->get('page') : 0;
                            foreach ($data_surat_keluar as $row) :
                                $tgl_surat = explode('-', $row->tgl_surat);
                                $tgl_proses = explode('-', $row->tgl_proses);
                                ?>
                                <tr>
                                    <td><?= ++$no; ?>.</td>
                                    <td><?= ($row->no_surat); ?></td>
                                    <td><?= ($row->perihal); ?></td>
                                    <td class="text-center"><?= $tgl_surat[2] . " " . bulan_short($tgl_surat[1]) . " " . $tgl_surat[0]; ?></td>
                                    <td class="text-center"><?= $tgl_proses[2] . " " . bulan_short($tgl_proses[1]) . " " . $tgl_proses[0]; ?></td>
                                    <?php
                                    if ($row->isi != '') {
                                        echo "<td>" . strtoupper($row->isi) . "</td>";
                                    } else {
                                        echo "<td class='text-center'>-</td>";
                                    }
                                    ?>
                                    <td class="text-center">
                                        <?php
                                        if ($row->tujuan != '0') {
                                            echo strtoupper(tempel('tb_users', 'nama_lengkap', "id = '$row->tujuan'"));
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?= strtoupper($row->status); ?></td>
                                    <td><?= strtoupper($row->keterangan); ?></td>
                                    <td class="text-center">
                                        <?php if ($row->status == 'selesai') : ?>
                                            <a href="#" onclick="ds_surat_keluar('<?= $row->id_surat; ?>');" class="btn btn-xs btn-primary" title="Lembar Surat Keluar"><i class="fa fa-file"></i></a>
                                        <?php endif; ?>
                                        <?php if ($row->status != 'selesai') : ?>
                                            <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#menunggu" title="Belum Selesai"><i class="fa fa-times"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="ds_surat_keluar" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-titles"></h4>
            </div>
            <div class="modal-body">
                <embed src="" frameborder="0" width="100%" height="400px" id="filez" type="application/pdf">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
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
                <small>Lembar disposisi belum diproses.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-sm pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .top { margin-top:20px; }
    .mini-font { font-size:11px; }
</style>