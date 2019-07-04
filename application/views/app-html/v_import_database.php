        <section class="content">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="box box-warning">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-upload"></i> Import - <small>Database</small></h3>
                  <div class="box-tools pull-right">

                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <!-- id="import_database" -->
                <form action="<?php echo site_url('apps/export/insert_database') ?>"  method="post" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <?php echo $this->session->flashdata('alert'); ?>

                    </div>
                    <div class="col-md-12 form-horizontal">
                      <div class="form-group">
                        <label class="col-sm-3 control-label">File SQL : <strong class="text-red">*</strong></label>
                        <div class="col-sm-6">
                          <input type="file" id="file" name="file_sql" class="form-control" required="">
                          <p class="help-block"><strong class="text-red">* </strong><small>File SQL extensi : .sql </small></p>
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