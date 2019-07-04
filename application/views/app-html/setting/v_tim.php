<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Data Tim Petugas Lapangan</h3>
                    <a href="#" class="btn btn-default pull-right" title="Data Jenis Tim Petugas Lapangan" data-toggle="modal" data-target="#add_tim"><i class="fa fa-plus"></i> Tambah Tim Petugas Lapangan</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>Nama Tim Petugas Lapangan</th>
                                    <th style="width: 100px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = (!$this->input->get('page')) ? 0 : $this->input->get('page');
                                foreach ($data_tim as $row) :
                                    ?>
                                    <tr>
                                        <td><?php echo ++$no; ?>.</td>
                                        <td><?php echo strtoupper($row->nama_tim); ?></td>
                                        <td class="text-center">
                                            <a href="#" onclick="edit_tim('<?php echo $row->id_tim; ?>');" class="btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" onclick="delete_tim('<?php echo $row->id_tim; ?>');" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></a>
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

<div class="modal modal-default" id="add_tim" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form action="<?php echo site_url("setting/ctim/add"); ?>" id="form_add_tim" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Menambahkan Tim Baru</h4>
                </div>
                <div class="modal-body">
                    <label>Tim  Petugas Lapangan :</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="nama_tim" type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="*Masukkan Nama Tim  Petugas Lapangan..." required>
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

<div class="modal modal-default" id="edit_tim" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form action="" id="form_edit_tim" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> Ubah Nama Tim Petugas Lapangan</h4>
                </div>
                <div class="modal-body">
                    <label>Nama Baru Tim Petugas Lapangan :</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="nama_tim" type="text" id="tim" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="*Masukkan Nama Baru Tim Petugas Lapangan..." required>
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
<div class="modal modal-default" id="delete_tim" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus data tim?</h4>
            </div>
            <div class="modal-body">
                <p>Yakin anda akan menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Tidak</a>
                <div id="del_tim"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Redundand database -->
<!--<div class="modal modal-default" id="red_tim" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus data tim?</h4>
            </div>
            <div class="modal-body">
                <p>Yakin anda akan menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Tidak</a>
                <div id="del_tim"></div>
            </div>
        </div> /.modal-content 
    </div> /.modal-dialog 
</div> /.modal -->
