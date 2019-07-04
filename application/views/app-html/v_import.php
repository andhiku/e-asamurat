        <section class="content">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-upload"></i> Import - <small>Dokumen</small></h3>
                  <div class="box-tools pull-right">
                  <a href="<?php echo base_url('assets/CONTOH_IMPORT_DATA.xls'); ?>" class="btn btn-sm btn-default"><i class="fa fa-download"></i> Unduh Contoh Import Data</a>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header  <?php echo site_url('apps/import/insert_data') ?> -->
                <form action="<?php echo site_url('apps/import/insert_data') ?>" id="import_dokumen" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12" id="upload_load"></div>
                    <div class="col-md-12 form-horizontal">
                      <div class="form-group">
                        <label class="col-sm-3 control-label">File Excel : <strong class="text-red">*</strong></label>
                        <div class="col-sm-6">
                          <input type="file" id="file_excel" name="file_excel" class="form-control"  />
                          <p class="help-block"><strong class="text-red">* </strong><small>File excel extensi : .xls "Microsoft Excel 97-2003 Worksheet"</small></p>
                        </div>
                      </div>
                     </div><!--/.col (right) -->
                  </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-app pull-right"><i class="fa fa-upload"></i> Import Data</button>
                </div>
              </div><!-- /. box -->
              </form>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->