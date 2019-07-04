 <?php  

    $where = array(
      'id_hak' => $this->input->get('jenishak'), 
      'desa' => $this->input->get('desa'),
      'no_hakbuku' => $this->input->get('nohak'),
      'no208' => $this->input->get('no208'),
      'thn' => $this->input->get('thn'),
      'bln' => $this->input->get('bln'),
      'thn_pinjam' => $this->input->get('thn_pinjam')
    );
 ?>
  <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Export Buku Tanah</h3>
                  <div class="box-tools">
                    <a href="<?php echo site_url("apps/export/cetak?jenishak={$where['id_hak']}&no208={$where['no208']}&nohak={$where['no_hakbuku']}&thn={$where['thn']}&desa={$where['desa']}") ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Cetak</a>
                    <a href="<?php echo site_url("apps/export/excel?jenishak={$where['id_hak']}&no208={$where['no208']}&nohak={$where['no_hakbuku']}&thn={$where['thn']}&desa={$where['desa']}&thn_pinjam={$where['thn_pinjam']}") ?>" target="_blank" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Export</a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                <form action="" method="get">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Jenis Hak :</label>
                        <select class="form-control input-sm" name="jenishak">
                          <option value="">- PILIHAN -</option>
                          <?php foreach($this->mbpn->jenis_hak() as $row) : $sama = ($where['id_hak']==$row->id_hak) ? 'selected' : '';
                            echo "<option value='{$row->id_hak}' {$sama}>{$row->jenis_hak}</option>"; endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label>No. 208 :</label>
                      <input type="text" name="no208" class="form-control input-sm" value="<?php echo $where['no208'] ?>">
                    </div>

                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Nomor Hak :</label>
                      <input type="text" name="nohak" class="form-control input-sm" value="<?php echo $where['no_hakbuku'] ?>">
                    </div>
                    <div class="form-group">
                      <label>Tahun <small>(warkah)</small> :</label>
                      <input type="text" name="thn" class="form-control input-sm" value="<?php echo $where['thn'] ?>">
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
                    <div class="form-group">
                      <label>Tahun <small>(Pinjaman)</small> : </label>
                      <select name="thn_pinjam" class="form-control input-sm">
                      <option value=""> - PILIHAN -</option>
                      <?php for($thn=date('Y'); $thn<=date('Y')+1; $thn++) : $pd = ($where['thn_pinjam']==$thn) ? 'selected' : ''; ?>
                      <option value="<?php echo $thn; ?>" <?php echo $pd; ?>><?php echo $thn; ?></option>
                    <?php endfor; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Bulan : </label>
                      <select name="bln" class="form-control input-sm">
                      <option value=""> - PILIHAN -</option>
                      <?php for($bln=1; $bln<=12; $bln++) : $podo = ($where['bln']==$bln) ? 'selected' : ''; ?>
                      <option value="<?php echo $bln; ?>" <?php echo $podo; ?>><?php echo bulan($bln); ?></option>
                    <?php endfor; ?>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-default top"><i class="fa fa-search"></i> Filter</button>
                    <a href="<?php echo site_url('apps/export') ?>" class="btn btn-default top" style="margin-left: 10px;"><i class="fa fa-times"></i> Reset</a>
                  </div>
                </form>
                </div>
                <div class="box-body">
                  <p><i>Menampilkan <?php echo ($total_page <= $per_page) ? $total_page : $per_page;?> dari <?php echo $total_page; ?> Data</i></p>
                  <table class="table table-bordered">
                    <thead class="mini-font">
                      <tr>
                        <th width="50">No.</th>
                        <th>Jenis Hak</th>
                        <th>Nomor Hak</th>
                        <th>Nomor 208</th>
                        <th>Tahun</th>
                        <th>Kelurahan / Desa</th>
                      </tr>
                    </thead>
                    <tbody class="mini-font">
                    <?php $no = ($this->input->get('page')) ? $this->input->get('page') : 0; foreach($data as $row) : ?>
                      <tr>
                        <td><?php echo ++$no; ?>.</td>
                        <td><?php echo $row->jenis_hak; ?></td>
                        <td><?php echo $row->no_hakbuku; ?></td>
                        <td><?php echo $row->no208; ?></td>
                        <td><?php echo $row->tahun; ?></td>
                        <td><?php echo $row->nama_desa; ?></td>
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