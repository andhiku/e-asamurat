<?php $param = $this->db->query("SELECT tb_rak.*, tb_lemari.* FROM tb_rak join tb_lemari ON tb_rak.no_lemari = tb_lemari.no_lemari WHERE tb_rak.no_rak = '{$this->uri->segment(4)}'")->row(); ?>
        <section class="content-header">
          <h1>Pengaturan <small> Manajemen Lemari</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url('setting/clemari') ?>">Lemari</a> </li>
            <li><a href="<?php echo site_url("setting/clemari/atur_rak/") ?>">Rak</a></li>
            <li><a href="<?php echo site_url("setting/clemari/atur_rak/") ?>">Atur Album</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title2">
                    <a href="<?php echo site_url('setting/clemari') ?>" class="text-link">Pengaturan</a> 
                    <span><i class="fa fa-angle-double-right"></i></span>
                    <a href="<?php echo site_url("setting/clemari/atur_rak/{$param->no_lemari}") ?>" class="text-link">Lemari <?php echo $param->nama_lemari ?></a> 
                    <span><i class="fa fa-angle-double-right"></i></span>
                    <a href="<?php echo site_url("setting/clemari/atur_rak/{$param->no_lemari}") ?>" class="text-link">Rak <?php echo $param->nama_rak; ?></a> 
                    <span><i class="fa fa-angle-double-right"></i></span>
                    <a href="#" class="text-link"><strong>Album </strong></a> 
                  </h3>
                  <div class="box-tools pull-right" style="width: 300px;">
                      <a href="<?php echo site_url("setting/clemari/atur_rak/{$param->no_lemari}") ?>" class="btn btn-default"><i class="fa fa-reply"></i> kembali</a>
                      <a href="#" data-toggle="modal" data-target="#add_album" class="btn btn-default"><i class="fa fa-plus"></i> Tambah Album</a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                  <?php foreach($data_album as $row) : ?>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                      <!-- small box -->
                      <div class="small-box bg-yellow">
                        <div class="inner">
                          <h3>Album <?php echo $row->nama_album; ?>
                            <br><small><strong class="text-white">- <?php echo ($row->document=='buku_tanah') ? 'Buku Tanah' : 'Warkah'; ?></strong></small>
                          </h3>
                        </div>
                        <div style="width: 100%; background-color: #CF850F; padding: 10px;" class="text-center">
                          <a href="<?php echo site_url("setting/clemari/informasi/{$row->no_album}") ?>" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Informasi</a>
                          <a href="#" onclick="delete_album('<?php echo $row->no_album; ?>','<?php echo $row->no_rak ?>');" class="btn btn-default btn-xs"><i class="fa fa-trash-o"></i> Hapus</a>
                        </div>
                      </div>
                    </div><!-- ./col -->
                  <?php endforeach; if(!$data_album) : ?>
                    <div class="col-md-6 col-md-offset-3">
                      <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-warning"></i> Maaf!</h4> Data tidak album tersedia.
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
              </div>
            </div>
 
          </div><!-- /.row -->
        </section><!-- /.content -->
<style>.text-link { color: #444; padding: 5px; } .text-link:hover { padding: 4px; border-radius: 2px; border: 1px solid #CDCDCD; color: #444; background-color: #ECF0F5; }
.inner h3 { font-size: 26px; font-weight: bold; }
.box-title2 { font-size: 18px; margin: 0px; }
.text-white { color: white; }
</style>

        <div class="modal modal-default" id="add_album" tabindex="-1" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Album Baru ?</h4>
              </div>
              <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Batal</a>
                <a href="<?php echo site_url("setting/clemari/set_album?method=add&lemari={$param->no_lemari}&rak={$param->no_rak}&doc=warkah") ?>" class="btn btn-primary">Warkah</a>
                <a href="<?php echo site_url("setting/clemari/set_album?method=add&lemari={$param->no_lemari}&rak={$param->no_rak}&doc=buku_tanah") ?>" class="btn btn-primary">Buku Tanah</a>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- Hapus -->
        <div class="modal modal-default" id="delete_album" tabindex="-1" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Hapus Album?</h4>
              </div>
              <div class="modal-footer">
                <a href="#" class="btn btn-default pull-left" data-dismiss="modal">Batal</a>
                <div id="del_album"></div>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

