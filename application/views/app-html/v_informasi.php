 <?php  

    $where = array(
      'id_jenis' => $this->input->get('jenisbencana'), 
      'desa' => $this->input->get('desa'),
//      'no_hakbuku' => $this->input->get('nohak'),
//      'no208' => $this->input->get('no208'),
      'tanggal' => $this->input->get('tanggal')
//      'storage' => $this->input->get('storage'),
//      'pemilik' => $this->input->get('pemilik'),
//      'status' => $this->input->get('status')
    );
 ?>
  <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Informasi Buku Tanah</h3>
                  <div class="box-tools">
                    <a href="<?php echo site_url("informasi/cetak?jenisbencana={$where['id_jenis']}&tanggal={$where['tanggal']}&desa={$where['desa']}") ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Cetak</a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                <form action="" method="get">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Jenis Hak :</label>
                        <select class="form-control input-sm" name="jenisbencana">
                          <option value="">- PILIHAN -</option>
                          <?php foreach($this->mbpn->jenis_hak() as $row) : $sama = ($where['id_jenis']==$row->id_jenis) ? 'selected' : '';
                            echo "<option value='{$row->id_jenis}' {$sama}>{$row->jenis_bencana}</option>"; endforeach; ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Tahun <small>(warkah)</small> :</label>
                      <input type="text" name="tanggal" class="form-control input-sm" value="<?php echo $where['tanggal'] ?>">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Kelurahan / Desa : </label>
                      <select id="list_desa" name="desa" class="form-control input-sm select">
                      <option value=""> - PILIHAN -</option>
                      <?php foreach($this->mbpn->desa() as $row) : $sama = ($where['desa']==$row->id_desa) ? 'selected' : ''; ?>
                      <option value="<?php echo $row->id_desa; ?>" <?php echo $sama; ?>><?php echo $row->nama_desa; ?></option>
                    <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-app top"><i class="fa fa-search"></i> Filter</button>
                    <a href="<?php echo site_url('informasi') ?>" class="btn btn-app top" style="margin-left: 10px;"><i class="fa fa-times"></i> Reset</a>
                  </div>
                </form>
                </div>
                <div class="box-body">
                  <p><i>Menampilkan <?php echo ($total_page <= $per_page) ? $total_page : $per_page;?> dari <?php echo $total_page; ?> Data</i></p>
                  <table class="table table-bordered">
                    <thead class="mini-font">
                      <tr>
                        <th width="50">No.</th>
                        <th>Jenis Bencana</th>
                        <th>Tahun</th>
                        <th>Kelurahan / Desa</th>
                      </tr>
                    </thead>
                    <tbody class="mini-font">
                    <?php $no = ($this->input->get('page')) ? $this->input->get('page') : 0; foreach($data as $row) : ?>
                      <tr>
                        <td><?php echo ++$no; ?>.</td>
                        <td><?php echo $row->jenis_bencana; ?></td>
                        <td><?php echo $row->tahun; ?></td>
                        <td><?php echo (!$row->id_desa) ? '-' : $this->bpn->desa($row->id_desa); ?></td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <?php echo $this->pagination->create_links(); ?>
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