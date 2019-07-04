        <section class="content-header">
          <h1>Pengaturan <small> Manajemen Lemari</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo site_url('setting/clemari') ?>">Lemari</a> </li>
            <li><a href="<?php echo site_url("setting/clemari/atur_rak/") ?>">Rak</a></li>
            <li><a href="<?php echo site_url("setting/clemari/atur_rak/") ?>">Informasi Album</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Informasi Album</h3>
                  <div class="pull-right">
                    <a href="<?php echo site_url("setting/clemari/atur_album/{$obj->no_rak}") ?>" class="btn btn-default"><i class="fa fa-reply"></i> kembali</a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <!-- <h4 class="text-center">Buku Tanah</h4> -->
                  <table class="table table-bordered table-hover">
                    <thead class="mini-font bg-gray">
                      <tr>
                        <th rowspan="2" class="text-center" width="80">NO LEMARI</th>
                        <th rowspan="2" class="text-center">NO RAK</th>
                        <th rowspan="2" class="text-center">NO ALBUM</th>
                        <th rowspan="2" class="text-center">DOKUMEN</th>
                        <th id="rows" class="text-center">INFORMASI KETERSEDIAAN HALAMAN</th>
                      </tr>
                    </thead>
                    <tbody class="mini-font text-center" id="data_album_informasi" data-lemari="<?php echo $obj->no_lemari; ?>" data-rak="<?php echo $obj->no_rak ?>" data-album="<?php echo $obj->no_album; ?>">

                    </tbody>
                  </table>
                </div>
                <div class="box-footer">
                  
                </div>
              </div>
            </div>
 
          </div><!-- /.row -->
        </section><!-- /.content -->
<style>.text-link { color: #444; padding: 5px; } .text-link:hover { padding: 4px; border-radius: 2px; border: 1px solid #CDCDCD; color: #444; background-color: #ECF0F5; }
.inner h3 { font-size: 26px; font-weight: bold; }
.box-title2 { font-size: 18px; margin: 0px; }
.mini-font { font-size: 11px; }
table.table a { color: #003399; text-decoration: none; padding:10px; text-align: center; }
table.table a:link, table.table a:visited { color: #003366; }
table.table a:hover {  font-weight: bold;}
</style>

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

<div class="modal" id="modal-data_kosong">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-bell-o"></i> Slot <span id="slot_kosong"></span> Kosong!</h4>
        <p>Apakah anda ingin mengisinya?</p>
      </div>
      <div class="modal-footer">
        <span id="tombol_isi"></span>
        <a href="" class="btn btn-default" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="modal-simpan_warkah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Masukkan No. 208 dan Tahun.</h4>
      </div>
      <form action="<?php echo site_url('apps/app_warkah/selipkan') ?>" id="form_simpan_warkah" onsubmit="return ajax_simpan_warkah();" method="post">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <div class="form-group">
              <label>No.208 : </label>
              <input type="text" class="form-control" placeholder="*Masukkan No.208..." name="no" required>
            </div>
          </div>
          <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Tahun :</label>
                <input type="text" class="form-control" placeholder="Masukkan Tahun.." name="thn"  required>
            </div><!-- /.form-group -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div>
      <input type="hidden" name="album" id="w_album">
      <input type="hidden" name="halaman" id="w_halaman">
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
      </div>
      </form>
    </div>
  </div>
</div>

