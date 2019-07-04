<section class="content-header">
  <h1>
    <small>Rekam Buku Tanah</small>
  </h1>
  <ol class="breadcrumb">
    <li>
      <a href="#"><i class="fa fa-folder-o"></i> Buku Tanah</a>
    </li>
    <li class="active">Rekam Buku Tanah</li>
  </ol>
</section>
<style>
  a { color: #444; }
</style>
<section class="content">
  <div class="row"><!-- row-->
    <div class="col-md-12">
    <?php if($this->input->get('bin')=='tersedia') : ?>
      <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Maaf!</strong> Data Sudah tersedia.
      </div>
    <?php endif; ?>
    </div>
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <ul class="nav nav-tabs text-center">
            <li class="active text-center"><a href="#step1-tab" data-toggle="tab">
              <strong>Step 1</strong> <br>Lengkapi Data Dokumen Buku Tanah  <i class="glyphicon"></i></a>
            </li>
            <li class="text-center"><a href="#step2-tab" class="text-default" data-toggle="tab">
              <strong>Step 2</strong><br> Pilih Penyimpanan Dokumen Buku Tanah <i class="glyphicon"></i></a>
            </li>
            <li class="text-center"><a href="#step3-tab" class="text-default" data-toggle="tab">
              <strong>Step 3</strong><br> Upload File Dokumen <i class="glyphicon"></i></a>
            </li>
          </ul>
        </div>
        <form action="<?php echo site_url('apps/app_buku/insert'); ?>" id="add_buku" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="tab-content">
            <div class="tab-pane active" id="step1-tab">
              <div class="col-md-6 form-horizontal">
                <div class="form-group">
                  <label class="col-xs-3 control-label">Jenis Hak :</label>
                  <div class="col-xs-7">
                    <select name="hak" id="cek_hak" class="form-control">
                      <option value="">- PILIHAN -</option>
                      <?php foreach($this->mbpn->jenis_hak() as $row) : echo "<option value='{$row->id_hak}'>{$row->jenis_hak}</option>"; endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Nomor Hak :</label>
                  <div class="col-xs-7">
                    <input type="text" class="form-control" name="nohak" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Tahun :</label>
                  <div class="col-xs-7">
                    <input type="text" class="form-control" name="tahun" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">No. 208 :</label>
                  <div class="col-xs-7">
                    <input type="text" class="form-control" name="no208" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Pemilik Awal :</label>
                  <div class="col-xs-7">
                    <input type="text" class="form-control" name="pemilik" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-xs-3 control-label">Status :</label>
                  <div class="col-xs-7">
                    <select name="status" class="form-control" required="required">
                      <option value="Y">Aktif</option>
                      <option value="N">Mati</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6 form-horizontal">
                <div class="form-group">
                  <label class="col-xs-3 control-label" id="label_hak">Luas :</label>
                  <div class="col-xs-7">
                    <input type="text" class="form-control" name="luas" />
                  </div>
                </div>
                <div class="form-group" id="form_kecamatan">
                  <label class="col-xs-3 control-label">Kecamatan :</label>
                  <div class="col-xs-7">
                    <select name="kecamatan" id="list_kecamatan" class="form-control">
                      <option value="">- PILIHAN -</option>
                    </select>
                  </div>
                </div>
                <div class="form-group" id="form_desa">
                  <label class="col-xs-3 control-label">Desa :</label>
                  <div class="col-xs-7">
                    <select name="desa" id="list_desa" class="form-control">
                      <option value="">- PILIHAN -</option>
                    </select>
                  </div>
                </div>
                <div class="form-group" id="form_desa">
                  <label class="col-xs-3 control-label">Catatan :</label>
                  <div class="col-xs-7">
                    <textarea name="catatan" id="" cols="30" rows="4" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <hr>
                <div class="pull-right">
                  <button type="button" class="btn btn-default btn-lg continue">Lanjut <i class="fa fa-arrow-right"></i></button>
                </div>                
              </div>
            </div>
            <div class="tab-pane" id="step2-tab">
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
                      <td><?php echo (!$this->input->get('halaman')) ? '-' : $this->input->get('halaman'); ?></td>
                    </tr>
                  </thead>
                </table>
                <input type="hidden" name="lemari" value="<?php echo $data->no_lemari; ?>">
                <input type="hidden" name="rak" value="<?php echo $data->no_rak; ?>">
                <input type="hidden" name="album" value="<?php echo $data->no_album; ?>">
                <input type="hidden" name="no_halaman" value="<?php echo $this->input->get('halaman') ?>">
              </div>
              <div class="col-md-12">
                <hr>
                <div class="pull-left">
                  <button type="button" class="btn btn-default btn-lg back"><i class="fa fa-arrow-left"></i> Kembali</button>
                </div>   
                <div class="pull-right">
                  <button type="button" class="btn btn-default btn-lg continue">Lanjut <i class="fa fa-arrow-right"></i></button>
                </div>                
              </div>
            </div>
            <div class="tab-pane" id="step3-tab">
              <div class="col-md-12 form-horizontal">
                <div class="form-group">
                  <label class="col-lg-2 col-xs-12 control-label">Buku Tanah :</label>
                  <div class="col-lg-7 col-xs-7">
                    <input class="form-control" type="file" name="file[0]" data-index="0" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-2 col-xs-12 control-label">Surat Ukur :</label>
                  <div class="col-lg-7 col-xs-7">
                    <input class="form-control" type="file" name="file[1]" data-index="1" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-2 col-xs-12 control-label">Catatan Buku Tanah :</label>
                  <div class="col-lg-7 col-xs-7">
                    <input class="form-control" type="file" name="file[2]" data-index="2" />
                  </div>
                  <div class="col-lg-3 col-xs-3">
                    <button type="button" class="btn btn-default btn-sm addButton" data-template="file"><i class="fa fa-plus"></i></button>
                  </div>
                </div>
                <div class="form-group hide" id="fileTemplate">
                  <div class="col-lg-offset-2 col-lg-7 col-xs-7">
                    <input class="form-control" type="file" />
                  </div>
                  <div class="col-lg-3 col-xs-3">
                    <button type="button" class="btn btn-default btn-sm removeButton"><i class="fa fa-times"></i></button>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <hr>
                <div class="pull-left">
                  <button type="button" class="btn btn-default btn-lg back"><i class="fa fa-arrow-left"></i> Kembali</button>
                </div>   
                <div class="pull-right">
                  <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Simpan</button>
                </div>                
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">

        </div>
        </form>
      </div> 
              
    </div><!---col-12-->
  </div><!--./row-->
</section>
<style type="text/css">.text-default { color:#444; } </style>
