        <section class="content-header">
          <h1>Pengaturan <small> Manajemen Lemari</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url('setting/clemari') ?>">Lemari</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title"><a href="<?php echo site_url('setting/clemari') ?>" class="text-link">Data Lemari</a> </h3>
                  <div class="box-tools pull-right">
                    <div class="btn-group">
                      <a href="#" data-toggle="modal" data-target="#add_lemari" class="btn btn-default"><i class="fa fa-plus"></i> Tambah Lemari</a>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                  <?php foreach($data_lemari as $row) : ?>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                      <!-- small box -->
                      <div class="small-box bg-yellow">
                        <div class="inner text-center">
                          <h3>Lemari <?php echo $row->nama_lemari; ?></h3>
                        </div>
                        <div style="width: 100%; background-color: #CF850F; padding: 10px;" class="text-center">
                          <a href="<?php echo site_url("setting/clemari/atur_rak/{$row->no_lemari}") ?>" class="btn btn-default btn-xs"><i class="fa fa-list"></i> Atur Rak</a>
                          <a href="#" onclick="delete_lemari('<?php echo $row->no_lemari; ?>');" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i> Hapus</a>
                        </div>
                      </div>
                    </div><!-- ./col -->
                  <?php endforeach; if(!$data_lemari) : ?>
                    <div class="col-md-6 col-md-offset-3">
                      <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-warning"></i> Maaf!</h4> Data tidak lemari tersedia.
                      </div>
                    </div>
                  <?php endif; ?>
                  </div>
                </div>
                <div class="box-footer">
                  <div class="pull-right">
                    <?php echo $this->pagination->create_links(); ?> 
                  </div>                
                </div>
                <div class="box-body <?php echo (!$data_lemari) ? 'hidden' : ''; ?>">
                  <h4 class="pull-left">Informasi Lemari</h4>  
                  <table class="table table-bordered table-striped table-hover">
                    <thead class="mini-font bg-gray">
                      <tr>
                        <th rowspan="3" class="text-center" width="80">NO LEMARI</th>
                        <th rowspan="3" class="text-center">JUMLAH RAK</th>
                        <th colspan="2" class="text-center">JUMLAH ALBUM</th>
                        <th colspan="6" class="text-center">INFORMASI LEMARI <small>(Dokumen)</small></th>
                      </tr>
                      <tr>
                        <th rowspan="2" class="text-center">BUKU TANAH</th>
                        <th rowspan="2" class="text-center">WARKAH</th>
                        <th colspan="3" class="text-center">BUKU TANAH</th>
                        <th colspan="3" class="text-center">WARKAH</th>
                      </tr>
                      <tr>
                        <th class="text-center">MAKSIMUM</th>
                        <th class="text-center">KOSONG</th>
                        <th class="text-center">TERISI</th>
                        <th class="text-center">MAKSIMUM</th>
                        <th class="text-center">KOSONG</th>
                        <th class="text-center">TERISI</th>
                      </tr>
                    </thead>
                    <tbody class="mini-font">
                    <?php foreach($data_lemari as $row) : 
                    $jumlah_album = $this->m_arsip->count_album($row->no_lemari);

                    $jumlah_album_buku = $this->m_arsip->count_album($row->no_lemari,0, 'buku_tanah');
                    $jumlah_album_warkah = $this->m_arsip->count_album($row->no_lemari,0, 'warkah');
                    $jumlah_buku = $this->m_arsip->count_buku($row->no_lemari);
                    $jumlah_warkah = $this->m_arsip->count_warkah($row->no_lemari);
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $row->nama_lemari; ?></td>
                        <td class="text-center"><?php echo $this->m_arsip->count_rak($row->no_lemari); ?></td>
                        <td class="text-center"><?php echo $jumlah_album_buku; ?></td>
                        <td class="text-center"><?php echo $jumlah_album_warkah; ?></td>
                        <td class="text-center"><?php echo ($jumlah_album_buku=='-') ? '-' : ($jumlah_album_buku * 100) ?></td>
                        <td class="text-center"><?php echo ($jumlah_album_buku=='-') ? '-' : ($jumlah_album_buku * 100) - $jumlah_buku; ?></td>
                        <td class="text-center"><?php echo $jumlah_buku; ?></td>
                        <td class="text-center"><?php echo ($jumlah_album_warkah=='-') ? '-' : ($jumlah_album_warkah * 50) ?></td>
                        <td class="text-center"><?php echo ($jumlah_album_warkah=='-') ? '-' : ($jumlah_album_warkah * 50) - $jumlah_warkah; ?></td>
                        <td class="text-center"><?php echo $jumlah_warkah; ?></td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
 
          </div><!-- /.row -->
        </section><!-- /.content -->
<style>.text-link { color: #444; padding: 5px; } .text-link:hover { padding: 4px; border-radius: 2px; border: 1px solid #CDCDCD; color: #444; background-color: #ECF0F5; }
  .inner h3 { font-size: 26px; font-weight: bold; }
  .mini-font { font-size:11px; } 
  .no_center th, td { text-align: left; }
</style>

        <div class="modal modal-default" id="add_lemari" tabindex="-1" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Lemari Baru ?</h4>
              </div>
              <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Batal</a>
                <a href="<?php echo site_url('setting/clemari/set_lemari?method=add') ?>" class="btn btn-primary">Buat</a>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- Hapus -->
        <div class="modal modal-default" id="delete_lemari" tabindex="-1" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus ?</h4>
              </div>
              <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Batal</a>
                <div id="del_lemari"></div>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->