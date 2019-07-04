        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit - <small>Buku Tanah</small></h3>
                  <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <!-- Custom Tabs -->
                      <div class="nav-tabs-custom tab-warning">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#step1-tab" data-toggle="tab">Data Dokumen</a></li>
                          <li class=""><a href="#step2-tab" data-toggle="tab">Data Penyimpanan</a></li>
                          <li class=""><a href="#step3-tab" data-toggle="tab">File Dokumen</a></li>
                          <a href="<?php echo site_url("buku/search?hak={$data->id_hak}&nohak={$data->no_hakbuku}&kecamatan={$data->id_kecamatan}&desa={$data->id_desa}&thn={$data->tahun}") ?>" class="btn btn-default btn-sm pull-right"><i class="fa fa-reply"></i> Kembali ke pencarian</a>
                        </ul>
                        <form id="form_edit_buku" action="<?php echo site_url("apps/app_buku/update/{$data->id_bencana}") ?>" method="post">
                        <div class="tab-content">
                          <div class="tab-pane active" id="step1-tab">
                            <hr>
                            <div class="row">
                              <div class="col-md-6 form-horizontal">
                                <div class="form-group">
                                  <label class="col-xs-3 control-label">Jenis Bencana :</label>
                                  <div class="col-xs-7">
                                    <select name="hak" id="" class="form-control">
                                      <option value="">- PILIHAN -</option>
                                      <?php foreach($this->mbpn->jenis_hak() as $row) : $sama = ($data->id_jenis==$row->id_jenis) ? 'selected' : '';
                                       echo "<option value='{$row->id_jenis}' {$sama}>{$row->jenis_bencana}</option>"; endforeach; ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-xs-3 control-label">Nomor Hak :</label>
                                  <div class="col-xs-7">
                                    <input type="text" class="form-control" name="nohak" value="<?php echo $data->no_hakbuku; ?>" />
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-xs-3 control-label">Tahun :</label>
                                  <div class="col-xs-7">
                                    <input type="text" class="form-control" name="tahun" value="<?php echo $data->tahun; ?>" />
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-xs-3 control-label">No. 208 :</label>
                                  <div class="col-xs-7">
                                    <input type="text" class="form-control" name="no208" value="<?php echo $data->no208; ?>" />
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-xs-3 control-label">Pemilik Awal :</label>
                                  <div class="col-xs-7">
                                    <input type="text" class="form-control" name="pemilik" value="<?php echo $data->pemilik_awal; ?>" />
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-6 form-horizontal">
                                <div class="form-group">
                                  <label class="col-xs-3 control-label">Status Dokumen :</label>
                                  <div class="col-xs-7">
                                    <select name="status" id="" class="form-control">
                                      <option value=""<?php echo (!$data->status_buku) ? 'selected' : ''; ?>>- PILIHAN -</option>
                                      <option value="Y" <?php echo ($data->status_buku=='Y') ? 'selected' : ''; ?>>Aktif</option>
                                      <option value="N" <?php echo ($data->status_buku=='N') ? 'selected' : ''; ?>>Mati</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-xs-3 control-label"><?php echo ($data->id_hak==5) ? 'Nilai' : 'Luas'; ?> :</label>
                                  <div class="col-xs-7">
                                    <input type="text" class="form-control" name="luas" value="<?php echo $data->luas; ?>" />
                                  </div>
                                </div>
                                <?php if(($data->id_hak != 5)) : ?>
                                <div class="form-group">
                                  <label class="col-xs-3 control-label">Kecamatan :</label>
                                  <div class="col-xs-7">
                                    <select name="kecamatan" id="list_kecamatan" class="form-control" data-kecamatan="<?php echo $data->id_kecamatan ?>">
                                      <option value="">- PILIHAN -</option>
                                    </select>
                                    <input type="hidden" name="no_kecamatan" value="<?php echo $data->id_kecamatan;  ?>">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-xs-3 control-label">Desa :</label>
                                  <div class="col-xs-7">
                                    <select name="desa" id="list_desa" class="form-control">
                                      <option value="">- PILIHAN -</option>
                                      <?php foreach($this->mbpn->desa() as $row) : $sama = ($row->id_desa==$data->id_desa) ? 'selected' : ''; ?>
                                      <option value="<?php echo $row->id_desa; ?>" <?php echo $sama; ?>><?php echo $row->nama_desa; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="no_desa" value="<?php echo $data->id_desa;  ?>">
                                  </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group" id="form_desa">
                                  <label class="col-xs-3 control-label">Catatan :</label>
                                  <div class="col-xs-7">
                                    <textarea name="catatan" id="" cols="30" rows="3" class="form-control"><?php echo $data->catatan_buku; ?></textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <br> 
                              <div class="pull-right">
                                <button type="button" class="btn btn-default btn-lg continue">Lanjut <i class="fa fa-arrow-right"></i></button>
                              </div>                
                            </div>
                          </div><!-- /.tab-pane -->
                          <div class="tab-pane" id="step2-tab">
                            <hr>
                            <div class="row">
                              <div class="col-md-12">
                                <table class="col-md-6 col-xs-12">
                                  <thead>
                                    <tr>
                                      <td width="100"><strong>Lemari</strong></td>
                                      <td width="20" class="text-center">:</td>
                                      <td><?php echo $this->mbpn->lemari($data->no_lemari); ?></td>
                                      <td width="100"><strong>Rak</strong></td>
                                      <td width="20"></td>
                                      <td width="20" class="text-center">:</td>
                                      <td><?php echo $this->bpn->rak($data->no_rak); ?></td>
                                    </tr>
                                    <tr>
                                      <td><strong>Album</strong></td>
                                      <td width="20" class="text-center">:</td>
                                      <td><?php echo $this->bpn->album($data->no_album); ?></td>
                                      <td><strong>Halaman</strong></td>
                                      <td width="20"></td>
                                      <td width="20" class="text-center">:</td>
                                      <td><?php echo (!$data->no_halaman) ? '-' : $data->no_halaman; ?></td>
                                    </tr>
                                  </thead>
                                </table>
                                <div class="col-xs-12"><hr></div>
                              </div>
                              <div class="form-group col-md-4">
                                <label class="control-label">Lemari :</label>
                                <select name="lemari" id="lemari" class="form-control">
                                  <option value="">- PILIH -</option>
                                  <?php foreach($lemari as $row): ?>
                                  <option value="<?php echo $row->no_lemari; ?>"> <?php echo $row->nama_lemari; ?></option>
                                <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="form-group col-md-4">
                                <label class="control-label">Rak :</label>
                                <select name="rak" id="rak" class="form-control">
                                  <option value="">- PILIH -</option>
                                </select>
                              </div>
                              <div class="form-group col-md-4">
                                <label class="control-label">Album :</label>
                                <select name="album" id="album" class="form-control">
                                  <option value="">- PILIH -</option>
                                </select>
                              </div>
                              <div class="col-md-12">
                                <div class="col-md-12">
                                  <p>Pilih Slot Halaman Yang tersedia : </p>
                                </div>
                                <div class="form-group">
                                  <ul id="laman" style="list-style: none; margin-left: -30px;"></ul>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <br>
                              <div class="pull-left">
                                <button type="button" class="btn btn-default btn-lg back"><i class="fa fa-arrow-left"></i> Kembali</button>
                              </div>   
                              <div class="pull-right">
                                <button type="submit" class="btn btn-success btn-lg">Simpan <i class="fa fa-save"></i></button>
                              </div>                
                            </div>
                          </div><!-- /.tab-pane -->
                          <div class="tab-pane" id="step3-tab">
                            <div class="row">
                              <div class="col-md-12">
                                <hr>
                                <div class="col-md-2 padding-top">
                                  <select class="form-control input-sm" name="action">
                                    <option value="null">- TINDAKAN MASSAL -</option>
                                    <option value="delete">DELETE</option>
                                  </select>
                                </div>
                                <div class="col-md-2 padding-top">
                                  <button type="button" onclick="foto_buku_hapus('<?php echo $data->id_bencana ?>');" class="btn btn-sm btn-default">Terapkan</button>
                                </div>
                                <div class="col-md-2 padding-top pull-right">
                                  <button type="button" data-toggle="modal" data-target="#modal_add_file" class="btn btn-sm btn-default"><i class="fa fa-plus"></i> Tambahkan File</button>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <hr>
                                <table class="table table-bordered table-responsive">
                                  <thead>
                                    <tr>
                                      <th width="50"><input type="checkbox" id="checkAll" name="checkAll"></th>
                                      <th>No.</th>
                                      <th>Nama File</th>
                                      <th>File Type</th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php $no=1; foreach($file as $row) : ?>
                                    <tr>
                                      <td><input type="checkbox" name="file[]" value="<?php echo $row->id; ?>"></td>
                                      <td width="50"><?php echo $no++; ?>.</td>
                                      <td><a class="fancybox fancybox.iframe" href="<?php echo base_url("assets/files/{$row->nama_file}"); ?>"><?php echo $row->nama_file; ?></td>
                                      <td><?php echo $row->mime_type; ?></td>
                                      <td width="50" class="text-center">
                                        <a href="#" onclick="delete_file_buku('<?php echo $row->id; ?>','<?php echo $data->no_hakbuku; ?>','<?php echo $data->id_bencana; ?>')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                                      </td>
                                    </tr>
                                  <?php endforeach; ?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                        </form>
                        <?php echo (!$this->input->get('storage')) ? '' : ''; ?>
                      </div><!-- nav-tabs-custom -->
                    </div><!-- /.col -->
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->

<div class="modal" id="modal-data_tersedia">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-bell-o"></i> Slot <span id="slot"></span> Terisi!</h4>
      </div>
      <div class="modal-body">
        <table width="100%">
          <tbody id="data_terisi"></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal_delete_file_buku">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-red">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus File ini?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        <div class="btn-group" id="button_delete_file_buku"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modal_add_file" tabindex="-1" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
  <form id="form_add_file" method="POST" class="form-horizontal" action="<?php echo site_url("apps/file_buku/add_multiple/{$data->id_bencana}/{$data->no_hakbuku}") ?>" enctype="multipart/form-data"  accept-charset="utf-8">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-plus"></i> Tambahkan File Dokumen Buku Tanah</h4>
      </div>
      <div class="modal-body">
                <div class="form-group">
                  <label class="col-lg-3 col-xs-12 control-label">Buku Tanah :</label>
                  <div class="col-lg-7 col-xs-7">
                    <input class="form-control" type="file" name="file[0]" data-index="0" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 col-xs-12 control-label">Surat Ukur :</label>
                  <div class="col-lg-7 col-xs-7">
                    <input class="form-control" type="file" name="file[1]" data-index="1" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-3 col-xs-12 control-label">Catatan Buku Tanah :</label>
                  <div class="col-lg-7 col-xs-7">
                    <input class="form-control" type="file" name="file[2]" data-index="2" />
                  </div>
                  <div class="col-lg-2 col-xs-3">
                    <button type="button" class="btn btn-default btn-sm addButton" data-template="file"><i class="fa fa-plus"></i></button>
                  </div>
                </div>
        <div class="form-group hide" id="fileTemplate">
          <div class="col-lg-offset-3 col-lg-7 col-xs-7">
            <input class="form-control" type="file" />
          </div>
          <div class="col-lg-2 col-xs-2">
            <button type="button" class="btn btn-default btn-sm removeButton"><i class="fa fa-times"></i></button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default out" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Tambahkan</button>
      </div>
    </div>
  </form>
  </div>
</div>
