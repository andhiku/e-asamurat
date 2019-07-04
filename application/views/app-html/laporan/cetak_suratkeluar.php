<html>
    <head></head>
    <body onload="window.print()"> <!--  onload="window.print()" -->
        <div class="wrapper">
            <div class="header">
                <div class="big-title">Data Surat Keluar</div>
            </div>
        </div>
        <div class="content">
            <table class="gridtable" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center">#</th>
                        <th rowspan="2" class="text-center">No.</br>Surat</th>
                        <th rowspan="2" class="text-center">Perihal</th>
                        <th colspan="2" class="text-center">Tanggal</th>
                        <th rowspan="2" class="text-center">Isi</th>
                        <th rowspan="2" class="text-center">Tujuan</th>
                        <th rowspan="2" class="text-center">Status</th>
                        <th rowspan="2" class="text-center">Keterangan</th>
                    </tr>
                    <tr>
                        <th rowspan="1" class="text-center">Tgl.&nbsp;Surat</th>
                        <th rowspan="1" class="text-center">Tgl.&nbsp;Terima</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = ($this->input->get('page')) ? $this->input->get('page') : 0;
                    foreach ($data_loop as $row) :
                        $tgl_surat = explode('-', $row->tgl_surat);
                        $tgl_proses = explode('-', $row->tgl_proses);
                        ?>
                        <tr>
                            <td><?php echo ++$no; ?>.</td>
                            <td><?= ($row->no_surat); ?></td>
                            <td><?= ($row->perihal); ?></td>
                            <td class="text-center"><?= $tgl_surat[2] . " " . bulan_short($tgl_surat[1]) . " " . $tgl_surat[0]; ?></td>
                            <td class="text-center"><?= $tgl_proses[2] . " " . bulan_short($tgl_proses[1]) . " " . $tgl_proses[0]; ?></td>
                            <td><?= ($row->isi); ?></td>
                            <td>
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

