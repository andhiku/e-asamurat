<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Bidang</h3>
                    <a href="#" class="btn btn-default pull-right" title="" data-toggle="modal" data-target="#add_bidang"><i class="fa fa-plus"></i> Tambah Bidang</a>
                </div>
                <div class="box-body table-responsive">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>Nama Bidang</th>
                                    <th>Jumlah Pegawai</th>
                                    <!--<th>Jumlah Dokumen</th>-->
                                    <th style="width: 100px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = (!$this->input->get('page')) ? 0 : $this->input->get('page');
                                foreach ($data_bidang as $row) :
                                    ?>
                                    <tr>
                                        <td><?php echo ++$no; ?>.</td>
                                        <td><?php echo ucwords(strtolower($row->nama_bidang)); ?></td>
                                        <td><?php echo $this->db->get_where('tb_pegawai', array('id_bidang' => $row->id_bidang))->num_rows(); ?></td>
                                        <td class="text-center">
                                            <a href="<?php echo site_url("bidang/pegawai/{$row->id_bidang}") ?>" class="btn btn-xs btn-success" title="Atur Pegawai"><i class="fa fa-eye"></i></a>
                                            <a href="#" onclick="edit_bidang('<?php echo $row->id_bidang; ?>');" class="btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" onclick="delete_bidang('<?php echo $row->id_bidang; ?>');" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></a>
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
                <!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div>
            <!-- /.box -->
        </div>
    </div><!--./row-->
</section>

<div class="modal modal-default" id="add_bidang" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form action="<?php echo site_url("bidang/set_bidang?method=add"); ?>" id="form_add_bidang" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Menambahkan Bidang</h4>
                </div>
                <div class="modal-body">
                    <label>Bidang :</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="bidang" type="text" class="form-control" style="text-transform: capitalize" autocomplete="off" placeholder="*Masukkan Nama Bidang..." required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"> Tambahkan</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal modal-default" id="edit_bidang" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form action="" id="form_edit_bidang" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> Update Bidang</h4>
                </div>
                <div class="modal-body">
                    <label>Bidang :</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="nama_bidang" id="bidang" type="text" class="form-control" style="text-transform: capitalize" autocomplete="off" placeholder="*Masukkan Nama Bidang..." required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"> Update</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Hapus -->
<div class="modal modal-default" id="delete_bidang" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus bidang?</h4>
            </div>
            <div class="modal-body">
                <p>Data yang berkaitan dengan bidang akan secara otomatis terhapus.</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Tidak</a>
                <div id="del_bidang"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


