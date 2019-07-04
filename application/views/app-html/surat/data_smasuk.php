<table class="table table-striped table-dark" width="100%">
    <thead class="mini-font">
        <tr>
            <th rowspan="2" class="">#</th>
            <th rowspan="2" class="">No. Surat</th>
            <th rowspan="2" class="">Asal</th>
            <th rowspan="2" class="text-center">Tgl.Surat</th>
            <th rowspan="2" class="text-center">Tgl.Diterima</th>
            <!--<th colspan="2" class="text-center">Tanggal</th>-->
            <th rowspan="2" class="">Perihal</th>
            <th rowspan="2" class="">Keterangan</th>
            <th rowspan="2" class="">Status</th>
            <th rowspan="2" class="text-center" style="width: 210px">Aksi</th>
        </tr>
<!--                            <tr>
            <th rowspan="2" class="text-center">Tgl.Surat</th>
            <th rowspan="2" class="text-center">Tgl.Diterima</th>
        </tr>-->
    </thead>
    <tbody class="mini-font">
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
                <td><?= ($row->keterangan); ?></td>
                <td><?php
                    if ($pgw == 'admin') : echo 'Menunggu Kepala Pelaksana';
                    elseif ($pgw == 'kalak') : echo 'Diproses Kepala Pelaksana';
                    elseif ($pgw == 'kabag') : echo 'Diproses Kepala Bagian';
                    elseif ($pgw == 'pelaksana') : echo 'Selesai';
                    elseif ($pgw == 'super_admin') : echo 'Diproses Programmer';
                    endif;
                    ?></td>
                <td class="text-center">

                                        <!--<a href="<?php // echo site_url("surat/kalak/{$row->id_surat}")           ?>" class="btn btn-xs btn-success" title="kalak"><i class="fa fa-eye"></i></a>-->

                                        <!--<a href="#konfirmasi" data-toggle="modal" class="btn btn-xs btn-info" title="Lihat Surat"><i class="fa fa-file"></i></a>-->
                    <?php if ($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') : ?>
                        <a href="#" onclick="ds_admin('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Disposisi Admin"><i class="fa fa-file"></i></a>
                    <?php endif; ?>
                    <?php if ($session['level_akses'] == 'kalak' OR $session['level_akses'] == 'super_admin') : ?>
                        <a href="#" onclick="ds_kalak('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Disposisi Kalak"><i class="fa fa-file"></i></a>
                    <?php endif; ?>
                    <?php if ($session['level_akses'] == 'kabag' OR $session['level_akses'] == 'super_admin') : ?>
                        <a href="#" onclick="ds_kabag('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Disposisi Kabag"><i class="fa fa-file"></i></a>
                    <?php endif; ?>
                    <?php if ($pgw == 'kabag' && ($session['level_akses'] == 'pelaksana' OR $session['level_akses'] == 'super_admin')) : ?>
                        <a href="#" onclick="ds_pelaksana('<?= $row->id_surat; ?>');" class="btn btn-xs btn-warning" title="Lembar Disposisi Pelaksana"><i class="glyphicon glyphicon-ok"></i></a>
                    <?php endif; ?>
                    <a href="#" onclick="viewpdf('<?= $row->id_surat; ?>');" class="btn btn-xs btn-success" title="File Surat Masuk"><i class="fa fa-eye"></i></a>
                    <?php if ($session['level_akses'] == 'admin' OR $session['level_akses'] == 'super_admin') : ?>
                        <a href="#" onclick="edit_smasuk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                        <!--<a href="#" onclick="delete_smasuk('< ?= $row->id_surat; ?>');" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></a>-->
                        <a href="#" onclick="delete_smasuk('<?= $row->id_surat; ?>');" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></a>
                        <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>