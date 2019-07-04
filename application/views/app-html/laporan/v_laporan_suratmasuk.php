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
                    <h3 class="box-title">Laporan Surat Masuk</h3>
                    <div class="box-tools">
                        <a href="<?php echo site_url("laporan_suratmasuk/cetak?status={$where['status']}&bln={$where['bln']}&thn={$where['thn']}"); ?>" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                        <!--<a href="< ?php echo site_url("laporan_suratmasuk/cetak?jenisbencana={$where['id_jenis']}&thn={$where['thn']}&desa={$where['desa']}&thn_suratmasuk={$where['thn_suratmasuk']}&bln={$where['bln']}"); ?>" class="btn btn-default" target="_blank"><i class="fa fa-print"></i> Cetak</a>-->
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form action="" method="get">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status Disposisi :</label>
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
                                <a href="<?php echo site_url('laporan_suratmasuk') ?>" class="btn btn-warning right" style="margin-left: 10px;"><i class="fa fa-times"></i> Reset</a>
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
                                <th rowspan="2" class="text-center">Asal</th>
                                <th rowspan="2" class="text-center">Perihal</th>
                                <th colspan="3" class="text-center">Tanggal</th>
                                <th rowspan="2" class="text-center">Isi</th>
                                <th rowspan="2" class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tujuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                <th rowspan="2" class="text-center">Status</th>
                                <th rowspan="2" class="text-center">Keterangan</th>
                                <th rowspan="2" class="text-center" style="width: 80px"></th>
                            </tr>
                            <tr>
                                <th rowspan="1" class="text-center">&nbsp;&nbsp;Tgl.&nbsp;Surat&nbsp;&nbsp;</th>
                                <th rowspan="1" class="text-center">Tgl.&nbsp;Terima</th>
                                <th rowspan="1" class="text-center">Tgl.&nbsp;Disposisi</th>
                            </tr>
                        </thead>
                        <tbody class="mini-font">
                            <?php
                            $no = ($this->input->get('page')) ? $this->input->get('page') : 0;
                            foreach ($data_surat_masuk as $row) :
                                $tgl_surat = explode('-', $row->tgl_surat);
                                $tgl_terima = explode('-', $row->tgl_terima);
                                $tgl_disposisi = explode('-', $row->tgl_disposisi);
                                ?>
                                <tr>
                                    <td><?php echo ++$no; ?>.</td>
                                    <td><?= ($row->no_surat); ?></td>
                                    <td><?= ($row->asal); ?></td>
                                    <td><?= ($row->perihal); ?></td>
                                    <td><?= $tgl_surat[2] . " " . bulan_short($tgl_surat[1]) . " " . $tgl_surat[0]; ?></td>
                                    <td><?= $tgl_terima[2] . " " . bulan_short($tgl_terima[1]) . " " . $tgl_terima[0]; ?></td>
                                    <?php
                                    if ($row->tgl_disposisi != '0000-00-00') {
                                        echo "<td>" . $tgl_disposisi[2] . " " . bulan_short($tgl_disposisi[1]) . " " . $tgl_disposisi[0] . "</td>";
                                    } else {
                                        echo "<td class='text-center'>-</td>";
                                    }
                                    ?>
                                    <?php
                                    if ($row->isi == '0') {
                                        echo "<td class='text-center'>-</td>";
                                    } elseif ($row->isi != '') {
                                        echo "<td>" . $row->isi . "</td>";
                                    } else {
                                        echo "<td class='text-center'>-</td>";
                                    }
                                    ?>
                                    <td class="text-center">
                                        <?php
                                        if ($row->tujuan != '0') {
                                            echo tempel('tb_users', 'nama_lengkap', "id = '$row->tujuan'");
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo ($row->status); ?></td>
                                    <td><?php echo ($row->keterangan); ?></td>
<!--                                    <td class="text-center">
                                        < ?php
                                        if ($row->status != 'pelaksana') {
                                            echo "Menunggu";
                                        } else {
                                            echo "Selesai";
                                        }
                                        ?>
                                    </td>-->
                                    <td class="text-center">
                                        <?php if ($row->status == 'selesai') : ?>
                                            <a href="#" onclick="ds_admin('<?= $row->id_surat; ?>');" class="btn btn-xs btn-primary" title="Lembar Disposisi"><i class="fa fa-file"></i></a>
                                        <?php endif; ?>
                                        <?php if ($row->status != 'selesai') : ?>
                                            <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#menunggu" title="Belum Selesai"><i class="fa fa-times"></i></a>
                                        <?php endif; ?>
                                        <a href="#" onclick="viewpdf('<?= $row->id_surat; ?>');" class="btn btn-xs btn-success" title="File Surat Masuk"><i class="fa fa-eye"></i></a>
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
</section>
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
<div class="modal fade modal-warning menunggu" id="menunggu" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> Maaf !</h4>
            </div>
            <div class="modal-body">
                <small>Lembar disposisi belum diproses pimpinan.</small>
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