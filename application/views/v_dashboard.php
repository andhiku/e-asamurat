<section class="content">
    <div class="row">
        <div class="col-md-3 col-xs-6">
            <div class="small-box bg-aqua pad">
                <div class="inner">
                    <h3><?php echo $this->m_presentation->getDok_aktif(); ?></h3>
                    <p>Dokumen Aktif</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="small-box bg-red pad">
                <div class="inner">
                    <h3><?php echo $this->m_presentation->getDok_mati(); ?></h3>
                    <p>Dokumen Mati</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file-text-o"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="small-box bg-yellow pad">
                <div class="inner">
                    <h3><?php echo $this->m_presentation->getDokBuku_keluar(); ?></h3>
                    <p>Buku Tanah Keluar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-out"></i>
                </div>
            </div>
        </div> 
        <div class="col-md-3 col-xs-6">
            <div class="small-box bg-yellow pad">
                <div class="inner">
                    <h3><?php echo $this->m_presentation->getDokWarkah_keluar(); ?></h3>
                    <p>Warkah Tanah Keluar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-out"></i>
                </div>
            </div>
        </div> 

        <div class="col-md-8 col-sm-12 col-xs-12"> 
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Indeks Dokumen </h3> <small>-</small>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="canvas" height="330" width="500"></canvas>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Jumlah <sup>/</sup>Kecamatan</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="212"></canvas>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <ul class="chart-legend clearfix">
                                    <?php foreach ($this->m_apps->kecamatan() as $row) { ?>
                                        <li><i class="fa fa-circle-o" style="color: <?php echo colorChart($row->id_kecamatan); ?>;"></i>
                                            <?php echo strtoupper($row->nama_kecamatan); ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Jumlah <sup>/</sup>Jenis Bencana</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="jenishak" height="212"></canvas>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <ul class="chart-legend clearfix">
                                    <?php foreach ($this->m_landbook->tampilhak() as $row) { ?>
                                        <li><i class="fa fa-circle-o" style="color: <?php echo colorChart($row->id_jenis); ?>;"></i> <?php echo $row->jenis_hak; ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Aktivitas</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <?php foreach ($history as $row) { ?>
                        <div class="post">
                            <div class="user-block">
                                <span class="description"><i class="fa fa-clock-o"></i> 
                                    <?php echo tgl_indo($row->tanggal); ?> - 
                                    <time class="timeago" datetime="<?php echo $row->time; ?>"><?php echo $row->time; ?></time>
                                </span>
                                <small><?php echo $row->deskripsi; ?></small>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="box-footer text-center">
                    <a href="<?php echo site_url() . '/setting/users'; ?>" class="uppercase">Lihat Semua ...</a>
                </div>
            </div>
        </div>


    </div>
</section>

