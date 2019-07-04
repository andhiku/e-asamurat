<html>
    <head></head>
    <body onload="window.print()"> <!--  onload="window.print()" -->
        <div class="wrapper">
            <div class="header">
                <div class="big-title">Data Surat Masuk</div>
            </div>
        </div>
        <div class="content">
            <table class="gridtable" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">#</th>
                        <th rowspan="2" class="text-center">No.</br>Surat</th>
                        <th rowspan="2" class="text-center">Asal</th>
                        <th rowspan="2" class="text-center">Perihal</th>
                        <th colspan="3" class="text-center">Tanggal</th>
                        <th rowspan="2" class="text-center">Isi</th>
                        <th rowspan="2" class="text-center">Tujuan</th>
<!--                        <th rowspan="2" class="text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tujuan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>-->
                        <th rowspan="2" class="text-center">Status</th>
                        <th rowspan="2" class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th rowspan="1" class="text-center">Tgl.&nbsp;Surat</th>
                        <th rowspan="1" class="text-center">Tgl.&nbsp;Terima</th>
                        <th rowspan="1" class="text-center">Tgl.&nbsp;Disposisi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = ($this->input->get('page')) ? $this->input->get('page') : 0;
                    foreach ($data_loop as $row) :
                        $tgl_surat = explode('-', $row->tgl_surat);
                        $tgl_terima = explode('-', $row->tgl_terima);
                        $tgl_disposisi = explode('-', $row->tgl_disposisi);
                        ?>
                        <tr>
                            <td><?php echo ++$no; ?>.</td>
                            <td><?= ($row->no_surat); ?></td>
                            <td><?= ($row->asal); ?></td>
                            <td><?= ($row->perihal); ?></td>
                            <td><?= $tgl_surat[2] . " " . bulan_short($tgl_surat[1]) . " " . $tgl_surat[0]; ?></td>
                            <td><?= $tgl_terima[2] . " " . bulan_short($tgl_terima[1]) . " " . $tgl_terima[0]; ?></td>
                            <td>
                                <?php
                                if ($row->tgl_disposisi != '0000-00-00') {
                                    echo $tgl_disposisi[2] . " " . bulan_short($tgl_disposisi[1]) . " " . $tgl_disposisi[0];
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                            <td><?php
                                if ($row->isi != '') {
                                    echo $row->isi;
                                } else {
                                    echo "-";
                                }
                                ?></td>
                            <td class="text-center">
                                <?php
                                if ($row->tujuan != '0') {
                                    echo tempel('tb_users', 'nama_lengkap', "id = '$row->tujuan'");
                                } else {
                                    echo "-";
                                }
                                ?>
                            </td>
                            <td><?php echo ($row->status); ?></td>
                            <td><?php echo ($row->keterangan); ?></td>
<!--                            <td>
                                < ?php
                                if ($row->tgl_disposisi == '0000-00-00') {
                                    echo "Menunggu";
                                } else {
                                    echo "";
                                }
                                ?>
                            </td>-->
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html> 

<style>
    table { font-size:12px; font-family:'Arial'; }
    .header { width:100%; height:10%; text-align:center; font-weight:500;  }
    .big-title {  font-family:'Arial'; font-size:14px; letter-spacing:normal; font-weight:bold; }
    .small-title {  font-family:'Times New Roman'; font-size:13px; letter-spacing:normal; }
    .content { font-size:12px; font-family:'Arial'; margin-top:-20px;}
    .upper { text-transform: uppercase;  }
    .underline { text-decoration: underline; }
    .bold { font-weight:bold; }
    table.gridtable {
        border-width: 1px;
        border-color: black;
        border-collapse: collapse; 
        font-size:0.8em;
    }
    table.gridtable th {
        border-width: 1px;
        padding: 5px;
        border-style: solid;
        border-color: black;
    }
    table.gridtable td {
        border-width: 0.1px;
        border-top: 0px;
        padding: 0px 0px 0px 3px;
        border-style: solid;
        border-color: black;
    }
</style>

