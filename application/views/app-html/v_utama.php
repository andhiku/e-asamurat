<?php
$session = $this->session->userdata('login');
$data_user = $this->db->query("SELECT * FROM tb_users WHERE username = '{$session['username']}'")->row();
?>

<section class="content-header">
    <h1><small>Dashboard</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url(); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3 col-xs-6">
            <div class="small-box pad" style="background-color: #0A940A; color: white;">
                <div class="inner">
                    <h3><?= $this->m_presentation->getDok('tb_surat_masuk'); ?></h3>
                    <p>Surat Masuk</p>
                </div>
                <div class="icon">
                    <i class="fa fa-download"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="small-box pad" style="background-color: #D73050; color: white;">
                <div class="inner">
                    <h3><?= $this->m_presentation->getDok('tb_surat_keluar'); ?></h3>
                    <p>Surat Keluar</p>
                </div>
                <div class="icon">
                    <i class="fa fa-upload"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="small-box pad" style="background-color: #505aff; color: white;">
                <div class="inner">
                    <h3><?= $this->m_apps->recTotal('tb_surat_masuk', "status = 'selesai'"); ?></h3>
                    <p>Disposisi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-envelope"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="small-box pad" style="background-color: #D0A711; color: white;">
                <div class="inner">
                    <h3><?= $this->m_presentation->getDok('tb_users'); ?></h3>
                    <p>Pengguna</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>

        <!--              <div class="col-md-5 col-xs-12 col-sm-12">
                        <div class="box box-warning">
                          <div class="box-header with-border">
                            <h3 class="box-title">Hak Tanggungan </h3> <small></small>
                            <div class="box-tools pull-right">
                              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                          </div>
                          <div class="box-body chart-responsive">
                            <div class="chart" id="line-chart" style="height: 210px;"></div>
                          </div> /.box-body 
                        </div> /.box   
                      </div> -->

        <!--        <div class="col-md-7 col-sm-12 col-xs-12">
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">Jumlah Bencana PerKecamatan</h3>
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
                                        <canvas id="pieChart" height="205"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <ul class="chart-legend clearfix">
                                        < ?php foreach ($this->m_apps->kecamatan() as $row) {
                                            if ($row->id_kecamatan == 7) : continue;
                                            endif; ?>
                                            <li><i class="fa fa-circle" style="color: <? = colorChart($row->id_kecamatan); ?>;"></i> < ?= strtoupper($row->nama_kecamatan); ?></li>
                                        < ?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->

        <div class="col-md-9 col-xs-12 col-sm-12">
            <div class="box box-warning">
                <div class="box-header with-border bg-teal-gradient">
                    <h3 class="box-title-baru">Presentase Surat Masuk</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body chat">
                    <canvas class="chart" id="line-charte" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xs-12 col-sm-12">
            <div class="box box-warning">
                <div class="box-header with-border bg-teal-gradient">
                    <h3 class="box-title-baru">Log Aktivitas</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body chat" id="chat-box" style="height: 260px; width: 100%;">
                    <?php
                    $dt_log = $this->db->query('SELECT * FROM tb_history ORDER BY id DESC LIMIT 4');
                    foreach ($dt_log->result() as $row) :
                        ?>
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <a class="direct-chat-name pull-left"><?php echo tempel('tb_users', 'nama_lengkap', "id = '$row->id_user'"); ?></a>
                                <span class="direct-chat-timestamp pull-right"><?php echo date_format(date_create($row->tanggal), 'd-m-Y'); ?></span>
                            </div>
                            <img class="direct-chat-img-baru" src="
                            <?php
                            $photos = $this->db->query("SELECT * FROM tb_users WHERE id = '$row->id_user'");
                            foreach ($photos->result() as $raw) {
                                if ($raw->foto == 'null') {
                                    echo base_url('assets/dist/img/no-images.png');
                                } elseif ($raw->foto != NULL) {
                                    echo base_url("assets/user/$raw->foto");
                                }
                            }
                            ?>" alt="Foto">
                            <div class="direct-chat-text">
                                <?php echo $row->log; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>   
        </div> 
    </div>
</section>
<style>.mini-font { font-size:11px; }</style>
<!--<script src="< ?= base_url('assets/surat/DashboardChart.min.js'); ?>"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js" type="text/javascript"></script>
<script>

<?php
foreach ($data as $data) {
    $total[] = $data->total;
    $monthname[] = $data->monthname;
}
//foreach ($datask as $datask) {
//    $totalsk[] = $data->totalsk;
//    $monthnamesk[] = $data->monthnamesk;
//}
?>

//    $(document).ready(function () {
//        $.ajax({
//            url: base_domain + '/utama',
//            method: "GET",
//            data: {},
//            dataType: "json",
//            success: function (data) {

    var suratmasuk = <?php echo json_encode($total); ?>;
    var suratkeluar = <?php echo json_encode($total); ?>;

//                for (var i in data) {
//                    if (data[i].tahun === '< ?php echo date('Y'); ?>>') {
//                        suratmasuk.push(data[i].< ?= $row->totalsm; ?>);
//                    } else {
//                        suratkeluar.push(data[i].< ?= $row->totalsk; ?>);
//                    }
//                }

    var datasuratmasuk = {
        label: 'Surat Masuk',
        data: suratmasuk,
        backgroundColor: ['rgba(60,186,159,0.2)'],
        borderColor: "#3cba9f",
        fill: true
    };

    var datasuratkeluar = {
        label: 'Surat Keluar',
        data: suratkeluar,
        backgroundColor: ['rgba(196,48,80,0.2)'],
        borderColor: "#c45850",
        fill: true
    };

    var datasemua = {
        labels: <?php echo json_encode($monthname); ?>,
        datasets: [datasuratmasuk]
//        datasets: [datasuratmasuk, datasuratkeluar]
    };

    var chartOptions = {
        responsive: true,
        legend: {display: false},
        title: {
            display: true,
            text: 'INDEKS SURAT MASUK TAHUN <?= date("Y"); ?>'
        }
    };

//                var lineChart = new Chart(tampil_chart, {
    var lineChart = new Chart(document.getElementById("line-charte"), {
        type: 'line',
        data: datasemua,
        options: chartOptions
    });

//            }
//        });
//
//    });
</script>