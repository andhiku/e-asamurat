        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Data Jenis Bencana</h3>
                  <a href="#" class="btn btn-default pull-right" title="Data Jenis Bencana" data-toggle="modal" data-target="#add_hak"><i class="fa fa-plus"></i> Tambah Jenis Bencana</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                  <div class="col-md-12">
                    <table class="table table-striped table-hover">
                      <thead>
                      <tr>
                        <th style="width: 50px">#</th>
                        <th>Nama Bencana</th>
                        <th>Jumlah Dokumen</th>
                        <th style="width: 100px"></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php 
                      $no = (!$this->input->get('page')) ? 0 : $this->input->get('page'); foreach($data_bencana as $row) : ?>
                        <tr>
                          <td><?php echo ++$no; ?>.</td>
                          <td><?php echo strtoupper($row->jenis_bencana); ?></td>
                          <td><?php echo $this->db->get_where('tb_bencana', array('id_jenis'=>$row->id_jenis))->num_rows(); ?></td>
                          <td class="text-center">
                            <a href="#" onclick="edit_hak('<?php echo $row->id_jenis; ?>');" class="btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" onclick="delete_hak('<?php echo $row->id_jenis; ?>');" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash-o"></i></a>
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

            <div class="modal modal-default" id="add_hak" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <form action="<?php echo site_url("setting/chak/add"); ?>" id="form_add_jenis" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Menambahkan Jenis Bencana Baru</h4>
                  </div>
                  <div class="modal-body">
                  <label>Jenis Bencana :</label>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <input name="jenis_bencana" type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="*Masukkan Nama Jenis Bencana..." required>
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

            <div class="modal modal-default" id="edit_hak" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <form action="" id="form_edit_hak" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> Update Jenis Bencana</h4>
                  </div>
                  <div class="modal-body">
                  <label>Jenis Bencana :</label>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <input name="jenis_bencana" type="text" id="jenis_bencana" class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="*Masukkan Nama Jenis Bencana..." required>
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
        <div class="modal modal-default" id="delete_hak" tabindex="-1" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus data bencana?</h4>
              </div>
              <div class="modal-body">
                <p>Data yang berkaitan dengan jenis Bencana ini akan secara otomatis terhapus</p>
              </div>
              <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Tidak</a>
                <div id="del_hak"></div>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->