<?php $session = $this->session->userdata('login'); ?>
            <div class="col-md-12">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">Pencarian : <small> </small></h3>
                  <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse" title="Minimize"><i class="fa fa-minus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12 dokument-information">
                      <div class="col-md-3">
                        <table>
                          <tr>
                            <td class="doc-label">Jenis Hak </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo $this->bpn->hak($data->id_hak); ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">No. Hak </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo $data->no_hakbuku; ?></td>
                          </tr>
                          <?php if($data->id_hak != 5) : ?>
                          <tr>
                            <td class="doc-label">Kecamatan</td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo $this->bpn->kecamatan($data->id_kecamatan); ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">Desa/Kel </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo (!$data->id_desa) ? '-' : $this->bpn->desa($data->id_desa); ?></td>
                          </tr>
                          <?php endif; ?>
                          <tr>
                            <td class="doc-label">No208 </td>
                            <td width="20px" class="text-center">:</td>
                            <td><?php echo $data->no208; ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">Tahun </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo $data->tahun; ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label"><?php echo ($data->id_hak==5) ? 'Nilai' : 'Luas'; ?> </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo $data->luas; ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">Pemilik Awal </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo (!$data->pemilik_awal) ? '-' : $data->pemilik_awal; ?></td>
                          </tr>
                        </table>        
                      </div>
                      <div class="col-md-4">
                        <table>
                          <tr>
                            <td class="doc-label">Status </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php if($data->status_buku=='Y') { echo '<span class="label label-success">Aktif</span>'; } else { echo '<span class="label label-danger">Mati</span>'; } ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">Keterangan </td>
                            <td width="20px" class="text-center">:</td>
                            <td>
                            <?php if($this->m_buku->keterangan($data->id_bencana)) : ?>
                              <span class="label label-danger">Keluar</span>
                            <?php else : ?>
                              <span class="label label-success">Ada</span>
                            <?php endif; ?>
                            </td>
                          </tr>
                          <tr  style="vertical-align: top;">
                            <td class="doc-label">Catatan </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo (!$data->catatan_buku) ? '-' : $data->catatan_buku;  ?></td>
                          </tr>
                        <?php if($this->m_buku->keterangan($data->id_bencana)) : $pinjam = $this->m_buku->get_pinjam($data->id_bencana); ?>
                          <tr>
                            <td class="doc-label">Dipinjam Oleh </td>
                            <td width="20px" class="text-center">:</td>
                            <td><?php echo $pinjam->peminjam; ?> </td>
                          </tr>
                          <tr>
                            <td class="doc-label">Tgl Peminjaman </td>
                            <td width="20px" class="text-center">:</td>
                            <td> <?php echo tgl_indo($pinjam->tgl_peminjaman); ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">Ket Kegiatan </td>
                            <td width="20px" class="text-center">:</td>
                            <td > <small><?php echo $pinjam->kegiatan; ?></small></td>
                          </tr>
                          <?php endif; ?>
                        </table>

                      </div>
                      <?php if('viewer' != $session['level_akses']) : ?>
                      <div class="col-md-5">
                        <table>
                        <?php if($storage) : ?>
                          <tr>
                            <td class="doc-label">No. Lemari </td>
                            <td width="34px" class="text-center">:</td>
                            <td> <?php echo $this->mbpn->lemari($storage->no_lemari); ?> </td>
                          </tr>
                          <tr>
                            <td class="doc-label">Rak</td>
                            <td width="34px" class="text-center">:</td>
                            <td><?php echo $this->bpn->rak($storage->no_rak) ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">No. Album</td>
                            <td width="34px" class="text-center">:</td>
                            <td><?php echo  $this->bpn->album($storage->no_album) ?></td>
                          </tr>
                          <tr>
                            <td class="doc-label">Halaman</td>
                            <td width="34px" class="text-center">:</td>
                            <td> <?php echo (!$storage->no_halaman) ? '-' : $storage->no_halaman; ?></td>
                          </tr>
                        <?php else : ?> 
                            <tr>
                              <td colspan="3">
                                <div class="alert alert-warning">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  <strong>Maaf!</strong><br> data penyimpanan belum dilengkapi.
                                </div>
                              </td>
                            </tr>
                        <?php endif; ?>
                        </table>
                      </div>
                    <?php endif; ?>
                      <div class="col-md-12">
                      	<hr>
                      <?php if('viewer' != $session['level_akses']) : ?>
          						<div class='list-group gallery'>
            						<?php $no=1; foreach($this->m_buku->file(0, $data->id_bencana) as $row) : ?>
            				      <div class='col-sm-2 col-xs-6 col-md-2'>
            				        <?php if($row->mime_type=='application/pdf') : ?>
            				        <a class="fancybox fancybox.iframe btn btn-xs btn-default" href="<?php echo base_url("assets/files/{$row->nama_file}"); ?>"><i class="fa fa-file-pdf-o"></i> <?php echo file_name($no); ?></a>
            				        <?php else : ?>
            				          <a class="thumbnail fancybox" rel="ligthbox" href="<?php echo base_url("assets/files/{$row->nama_file}"); ?>">
            				          <img class="img-responsive" alt="" src="<?php echo base_url("assets/files/{$row->nama_file}"); ?>" />
            				          </a>
            				        <?php endif; ?>
            				      </div> <!-- col-6 / end -->
            						<?php $no++; endforeach; ?>
            				    </div> <!-- list-group / end -->
                      </div>  
                      <div class="col-md-12 pad with-border"></div>
                      <?php endif; ?>
                    </div><!--./end col-atas-->
                  </div>
                </div><!-- /.box-body -->

                <?php if('viewer' != $session['level_akses']) : ?>
                <div class="box-footer">
                	<div class="btn-group pull-right">
                		<a href="<?php echo site_url("buku/document/{$data->id_bencana}?t=data") ?>" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit Dokumen</a>
                    <?php if($this->m_buku->keterangan($data->id_bencana)) : ?>
                    <a class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_kembali_buku_tanah"><i class="fa fa-sign-out"></i> Kembalikan</a>
                    <?php else : ?>
                		<a class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_pinjam_buku_tanah"><i class="fa fa-sign-out"></i> Pinjamkan</a>
                    <?php endif; 
                      if($session['level_akses']=='admin' OR $session['level_akses']=='super_admin') : 
                        if($this->mtrash->cek($data->id_bencana)) : 
                    ?>
                		<a data-toggle="modal" data-target="#modal_delete_buku_tanah" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i> Hapus Dokumen</a>
                    <?php endif; endif; ?>
                	</div>
                </div>
                <?php endif; ?>
              </div><!-- /. box -->
            </div><!-- /.col -->
            <!-- MODAL HAPUS DOKUMEN -->
            <div class="modal modal-danger" id="modal_delete_buku_tanah" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-question-circle"></i> Question!</h4>
                    <small>Yakin anda akan menghapusnya? 
                      <br><strong>(Hapus Semua)</strong> Hapus Dokumen Buku Tanah Dan Warkah!
                    </small>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Tidak</button>
                    <a href="<?php echo site_url("apps/app_buku/delete_all/{$data->id_bencana}/{$data->no208}"); ?>" type="button" class="btn btn-outline"> Hapus Semua</a>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- MODAL PINJAMKAN -->
            <div class="modal modal-default" id="modal_pinjam_buku_tanah" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <form action="<?php echo site_url("apps/app_buku/pinjam_buku/{$data->id_bencana}") ?>" method="post">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Peminjaman Arsip Buku Tanah.</h4>
                  </div>
                  <div class="modal-body">
                  <p>Masukkan Keterangan pengeluaran :</p>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Peminjam :</label>
                            <input type="text" name="peminjam" class="form-control" placeholder="*Masukkan nama peminjam" required>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Ket Kegiatan :</label>
                            <textarea name="kegiatan" class="form-control" placeholder="*Jika iya masukkan keterangan" required></textarea>
                          </div>
                        </div>
                      </div>  
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary"> Pinjamkan</button>
                  </div>
                </div><!-- /.modal-content -->
                </form>
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <!-- MODAL KEMBALI -->
            <div class="modal modal-default" id="modal_kembali_buku_tanah" tabindex="-1" data-backdrop="static" data-keyboard="false">
              <form action="<?php echo site_url("apps/app_buku/kembali_buku/{$data->id_bencana}") ?>" method="post">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Kembalikan Arsip Buku Tanah ?</h4>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"> Kembalikan</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
              </form>
            </div><!-- /.modal -->


<?php 
if($this->input->get('print')=='true') :  
$id_print = $this->input->get('data_print');
?>
<script>
newwindow=window.open('<?php echo site_url("/apps/pinjam_buku/cetak/{$id_print}") ?>','name','height=600,width=800');
if (window.focus) {
    newwindow.focus();
}
</script>
<?php endif; ?>
