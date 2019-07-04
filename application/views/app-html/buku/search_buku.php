<?php 
$where = array(
  'hak' => $this->input->get('hak'),
  'nohak' => $this->input->get('nohak'),
  'kecamatan' => $this->input->get('kecamatan'),
  'desa' => $this->input->get('desa')
); 
?>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Pencarian - <small>Buku Tanah</small></h3>
                  <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">

              <form  action="" method="GET">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Jenis Hak : </label>
                      <select class="form-control" name="hak" id="cari_tanggugan">
                        <option selected>--PILIH--</option>
                        <?php foreach($jenishak as $row) { $sama = ($where['hak']==$row->id_hak) ? 'selected' :''; ?>
                        <option value="<?php echo $row->id_hak; ?>" <?php echo $sama; ?>><?php echo $row->jenis_hak; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                       <label for="exampleInputEmail1">No Hak :</label>
                       <input type="text" class="form-control" placeholder="Masukkan No Hak.." name="nohak" value="<?php echo $where['nohak']; ?>" required>
                    </div><!-- /.form-group -->
                  </div><!-- /.col -->
                  <div class="col-md-3">
                    <div class="form-group" id="tampil_desa">
                      <label>Kelurahan / Desa : </label>
                      <select id="list_desa" name="desa" class="form-control select">
                      <option value=""> - PILIHAN -</option>
                      <?php foreach($this->mbpn->desa() as $row) : $sama = ($where['desa']==$row->id_desa) ? 'selected' : ''; ?>
                      <option value="<?php echo $row->id_desa; ?>" <?php echo $sama; ?>><?php echo $row->nama_desa; ?></option>
                    <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="form-group" id="tampil_thn">
                      <label>Tahun : </label>
                      <input type="text" name="thn" id="" value="<?php echo $this->input->get('thn') ?>" class="form-control" placeholder="Masukkan Tahun ..">
                    </div>
                  </div>
                  <div class="col-md-2 ">
                    <div class="form-group">
                      <button class="btn btn-app" type="submit"><i class="fa fa-search"></i> Cari</button>  
                    </div><!-- /.form-group -->
                  </div><!-- /.col -->
                </div><!-- /.row -->
              </form>

                </div><!-- /.box-body -->
              </div><!-- /. box -->
              <a name="top"></a>
            </div><!-- /.col -->
            <?php if(!$data) : ?>
            <div class="col-md-12">
              <div class="callout bg-gray">
                <h4 class="text-white"><i class="fa fa-info-circle"></i> Info !</h4>
                <p>- Silahkan Masukkan Jenis Hak, Nomor Hak, Kecamatan, Kelurahan / Desa.</p>
              </div>
            </div>
            <?php else :  $this->load->view('app-html/buku/result_buku', $data, FALSE); endif; ?>
          </div><!-- /.row -->
        </section><!-- /.content -->
