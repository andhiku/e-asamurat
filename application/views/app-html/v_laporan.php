<section class="content-header">
    <h1><small><b>Laporan Surat Masuk</b></small></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url('laporan'); ?>"><i class="fa fa-file-o"></i> Laporan Surat Masuk</a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <!--                <div class="box-header with-border">
                                    <h3 class="box-title">Laporan Surat Masuk</h3>
                                    <div class="box-tools">
                                    </div>
                                </div>-->
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover" id="arsipbuku" width="100%">
                        <thead class="mini-font">
                            <tr>
                                <th rowspan="2" class="text-center">#</th>
                                <th rowspan="2" class="text-center">No.</br>Surat</th>
                                <th rowspan="2" class="text-center">Asal</th>
                                <th rowspan="2" class="text-center">Perihal</th>
                                <th colspan="3" class="text-center">Tanggal</th>
                                <th rowspan="2" class="text-center">Isi</th>
                                <th rowspan="2" class="text-center">Tujuan</th>
                                <th rowspan="2" class="text-center">Status</th>
                                <th rowspan="2" class="text-center" style="width: 80px">Aksi</th>
                            </tr>
                            <tr>
                                <th rowspan="1" class="text-center">Tgl.Surat</th>
                                <th rowspan="1" class="text-center">Tgl.Terima</th>
                                <th rowspan="1" class="text-center">Tgl.Disposisi</th>
                            </tr>
                        </thead>
                        <tbody class="mini-font">
                            <?php
                            $no = (!$this->input->get('page')) ? 0 : $this->input->get('page');
                            foreach ($data_smasuk as $row) :
//                                $waktu = explode(':', $row->waktu);
//                                $desa = $this->bpn->desa($row->id_desa);
//                                $kec = $this->bpn->kecamatan($row->id_kecamatan);
//                                $jenis = $this->bpn->hak($row->id_jenis);
//                                $team = explode(',', $row->id_tim);
//                                $tim = $this->bpn->tim($row->id_tim);
                                $disposisi = $row->tgl_disposisi;
                                ?>
                                <tr>
                                    <td><?= ++$no; ?>.</td>
                                    <td><?= ($row->no_surat); ?></td>
                                    <td><?= ($row->asal); ?></td>
                                    <td><?= ($row->perihal); ?></td>
                                    <td><?= ($row->tgl_surat); ?></td>
                                    <td><?= ($row->tgl_terima); ?></td>
                                    <td>
                                        <?php if ($row->tgl_disposisi != '0000-00-00') { echo $row->tgl_disposisi; }
                                        else { echo "-"; }
                                        ?>
                                    </td>
                                    <td><?= ($row->isi); ?></td>
                                    <td>
                                        <?php if ($row->tujuan != '0') { echo $row->tujuan; }
                                        else { echo "-"; }
                                        ?>
                                    </td>
                                    <td><?= ($row->status); ?></td>
    <!--                                    <td class="text-center">< ?= ($waktu[0] . ':' . $waktu[1]); ?> </br>
                                        < ?= tgl_indo($row->tanggal); ?></td>-->
    <!--                                    <td>< ?= (!$row->id_kecamatan) ? '-' : strtoupper($kec); ?></td>
                                    <td>< ?= (!$row->id_desa) ? '-' : strtoupper($desa); ?></td>
                                    <td>< ?= (!$row->id_jenis) ? '-' : strtoupper($jenis); ?></td>
                                    <td>< ?= strtoupper($row->sebab); ?></td>
                                    <td>< ?php
                                        foreach ($team as $value) {
                                            echo tempel('tb_tim', 'nama_tim', "id_tim = '$value'") . ', ';
                                        }
                                        ?></td>-->
                                    <td class="text-center">
                                        <a href="#" onclick="delete_smasuk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="col-md-12">
<?= $this->pagination->create_links(); ?>
                    </div> 
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="callout callout-default">
                        <h5>Keterangan :</h5>
                        <table>
                            <tr>
                                <td>TS</td>
                                <td class="text-center" width="15px;">:</td>
                                <td>Tanggal Surat</td>
                            </tr>
                            <tr>
                                <td>TT</td>
                                <td class="text-center" width="15px;">:</td>
                                <td>Tanggal Terima</td>
                            </tr>
                            <tr>
                                <td>TD</td>
                                <td class="text-center" width="15px;">:</td>
                                <td>Tanggal Disposisi</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- box-footer -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
<style type="text/css">
    .top { margin-top:20px; }
    .mini-font { font-size:11px; }
</style>

<!-- Hapus -->
<div class="modal modal-default" id="delete_smasuk" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus data?</h4>
            </div>
            <div class="modal-body">
                <p><font color="red">Foto dokumentasi</font> yang berkaitan dengan data bencana ini akan terhapus</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Tidak</a>
                <div id="del_smasuk"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function delete_smasuk(id) {
        $('#delete_smasuk').modal('show');
        $('#del_smasuk').html('<a href="' + base_domain + '/laporan/set_smasuk?method=delete&id=' + id + '" class="btn btn-danger">Hapus</a>');
        return false;
    }
    function edit_foto(id, bencana) {
        $.ajax({
            url: base_domain + '/laporan/get_foto/' + id,
            dataType: 'json',
            success: function (response) {
                if (response['status']) {
                    var item = response['result'][0];
                    $('#edit_foto').modal('show');
                    $('#nama_foto').val(item['file_name']);
                    $('#form_edit_foto').attr('action', base_domain + '/laporan/set_foto?id=' + id + '&method=update&bencana=' + bencana);
                } else {
                    alert('ERROR!');
                }
            },
            error: function () {
                alert('ERROR!');
            }
        });
        return false;
    }

    function delete_foto(id, bencana) {
        $('#delete_foto').modal('show');
        $('#del_foto').html('<a href="' + base_domain + '/laporan/set_foto?method=delete&id=' + id + '&bencana=' + bencana + '" class="btn btn-danger">Hapus</a>');
        return false;
    }
</script>