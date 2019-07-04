<section class="content-header">
    <h1><small><b>Album Foto</b></small></h1>
    <ol class="breadcrumb">
        <li class="active"><a href="<?= base_url('laporan'); ?>"><i class="fa fa-file-o"></i> Laporan Bencana</a></li>
        <li><i class="fa fa-photo"></i> Album Foto</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <?php if ($this->session->flashdata('success')) { ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php } ?> 
        <?= validation_errors('<div class="alert alert-danger alert-dismissible" role="alert">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span></button>', '</div>');
        ?>
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <!--<h3 class="box-title">Album Foto</h3>-->
                    <?php // foreach ($dtlist->result() as $det) { ?>
                    <!--<a href="< ?= base_url("laporan/foto/{$det->id_bencana}") ?>" class="btn btn-default pull-right" title="Album Foto" data-toggle="modal" data-target="#add_foto"><i class="fa fa-plus"></i> Tambah Foto</a>-->
                    <!--<a href="< ?= base_url('laporan/foto') ?>" class="btn btn-default pull-right" title="Album Foto" data-toggle="modal"> data-target="#add_foto"<i class="fa fa-plus"></i> Tambah Foto</a>-->
                </div>
                <div class="gallery">
                    <?php foreach ($dtlist->result() as $det) { ?>
                        <figure>
                            <img src="<?= base_url() ?>assets/bencana/<?= $det->foto ?>" alt="" width="700" />
                            <figcaption>BPBD <small>Kota Banjarbaru</small></figcaption>
                        </figure>
                    <?php } ?>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display:none;">
                    <symbol id="close" viewBox="0 0 18 18">
                        <path fill-rule="evenodd" clip-rule="evenodd" fill="#FFFFFF" d="M9,0.493C4.302,0.493,0.493,4.302,0.493,9S4.302,17.507,9,17.507
                              S17.507,13.698,17.507,9S13.698,0.493,9,0.493z M12.491,11.491c0.292,0.296,0.292,0.773,0,1.068c-0.293,0.295-0.767,0.295-1.059,0
                              l-2.435-2.457L6.564,12.56c-0.292,0.295-0.766,0.295-1.058,0c-0.292-0.295-0.292-0.772,0-1.068L7.94,9.035L5.435,6.507
                              c-0.292-0.295-0.292-0.773,0-1.068c0.293-0.295,0.766-0.295,1.059,0l2.504,2.528l2.505-2.528c0.292-0.295,0.767-0.295,1.059,0
                              s0.292,0.773,0,1.068l-2.505,2.528L12.491,11.491z"/>
                    </symbol>
                </svg>
            </div>
        </div>
    </div>
</section>

<!--<div class="modal modal-default" id="add_foto" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form action="< ?= site_url("setting/cwilayah/set_desa?method=add&kecamatan={$this->uri->segment(4)}"); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Menambahkan Foto Dokumentasi</h4>
                </div>
                <div class="modal-body">
                    <label>Dokumentasi :</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="form-control" type="file" id="foto" name="foto" accept="image/*"/>
                                <input name="desa" type="file" class="form-control" placeholder="*Masukkan Nama Desa / Kelurahan..." required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"> Tambahkan</button>
                </div>
            </div> /.modal-content 
        </form>
    </div> /.modal-dialog 
</div> /.modal -->