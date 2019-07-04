<style type="text/css">
    #tbl {
        background: #fff;
    }
    tr, td {
        padding: 5px;
        /*border: table-cell;*/
        border: 1px  solid #444;
        vertical-align: top;
    }
    .bat {
        position: relative;
        right: 0;
        text-align: right;
    }
    .bottom-align-text {
        position: absolute;
        bottom: 0;
        /*right: 0;*/
        margin-bottom: -240px;
        margin-right: -200px;
        text-align: center;
    }
    #right {
        border-right: none !important;
    }
    #left {
        border-left: none !important;
    }
    .isi {
        height: 300px!important;
    }
    .isihead {
        height: 60px!important;
    }
    .disp {
        text-align: center;
        padding: 1.5rem 0;
        margin-bottom: .5rem;
    }
    .logodisp {
        float: left;
        position: relative;
        width: 80px;
        margin: 0 0 0 1rem;
    }
    #lead {
        width: auto;
        position: relative;
        margin: 25px 0 0 80%;
    }
    .lead {
        font-size: 16px;
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: -10px;
    }
    .tterima {
        font-weight: bold;
        text-decoration: underline;
        margin-bottom: -10px;
    }
    .tgh {
        text-align: center;
    }
    #nama {
        font-size: 2.1rem;
        margin-bottom: -1rem;
    }
    #alamat {
        font-size: 16px;
    }
    .up {
        text-transform: uppercase;
        margin: 0;
        line-height: 2.2rem;
        font-size: 1.5rem;
    }
    .status {
        margin: 0;
        font-size: 1.3rem;
        margin-bottom: .5rem;
    }
    #lbr {
        font-size: 20px;
        font-weight: bold;
        text-decoration: underline;
    }
    .separator {
        border-bottom: 2px solid #616161;
        margin: -1.3rem 0 1.5rem;
    }
    /*    @media print{
            body {
                font-size: 12px;
                color: #212121;
            }
            nav {
                display: none;
            }
            table {
                width: 100%;
                font-size: 12px;
                color: #212121;
            }
            tr, td {
                border: table-cell;
                border: 1px  solid #444;
                padding: 8px!important;
    
            }
            tr,td {
                vertical-align: top!important;
            }
            #lbr {
                font-size: 20px;
            }
            .isi {
                height: 200px!important;
            }
            .tgh {
                text-align: center;
            }
            .disp {
                text-align: center;
                margin: -.5rem 0;
            }
            .logodisp {
                float: left;
                position: relative;
                width: 80px;
                height: 80px;
                margin: -.5rem 0;
            }
            #lead {
                width: auto;
                position: relative;
                margin: 15px 0 0 75%;
            }
            .lead {
                font-weight: bold;
                text-decoration: underline;
                margin-bottom: -10px;
            }
            #nama {
                font-size: 20px!important;
                font-weight: bold;
                text-transform: uppercase;
                margin: -10px 0 -20px 0;
            }
            .up {
                font-size: 17px!important;
                font-weight: normal;
            }
            .status {
                font-size: 17px!important;
                font-weight: normal;
                margin-bottom: -.1rem;
            }
            #alamat {
                margin-top: -15px;
                font-size: 13px;
            }
            #lbr {
                font-size: 17px;
                font-weight: bold;
            }
            .separator {
                border-bottom: 2px solid #616161;
                margin: -1rem 0 1rem;
            }
        }*/
</style>
<!--<body onload="window.print()">-->
<section class="content ">
    <div id="colres">
        <div class="disp">
            <img class="logodisp" src="<?= base_url(); ?>assets/images/bjb.png"/>
            <h6 class="up">PEMERINTAH KOTA BANJARBARU</h6>
            <h5 class="up" id="nama">BADAN PENANGGULANGAN BENCANA DAERAH</h5><br/>
            <h6 class="status">Jl. Trikora No.1 Banjarbaru Kalimantan Selatan 70713 Telp. 085103668118 - 081253951966</h6>
            <span id="alamat"><h6>email: bpbdbanjarbaru@gmail.com</h6></span>
        </div>
        <div class="separator"></div>
        <div class="tgh" id="lbr" colspan="5">LEMBAR DISPOSISI</div>
        <div class="box-body table-responsive">
            <table class="bordered" width="100%" id="tbl">
            <!--<table class="bordered" id="tbl">-->
                <tbody>
                    <tr>
                        <td id="right" width="18%"><strong>Perihal</strong></td>
                        <td id="left" style="border-right: none;" width="57%">: <?php // echo $perihal; ?></td>
                    </tr>
                    <tr>
                        <td id="right"><strong>Asal Surat</strong></td>
                        <td id="left" colspan="2">: $row['asal_surat']</td>
                    </tr>
                    <tr>
                        <td id="right"><strong>Tanggal Surat</strong></td>
                        <td id="left" colspan="2">: <?= date('d M Y'); ?></td>
                    </tr>
                    <tr>
                        <td id="right"><strong>Nomor Surat</strong></td>
                        <td id="left" colspan="2">: $row['no_surat']</td>
                    </tr>
                    <tr class="isihead">
                        <td id="right">
                            <strong>Diterima TUMSIP</strong><br>
                            <strong>Tanggal Diterima</strong><br>
                            <strong>Nomor Agenda</strong><br>
                        </td>
                        <td id="left" colspan="2">
                            <br>
                            : <?= date('d M Y'); ?><br>
                            : $row['no_surat']<br>
                        </td>
                    </tr>
                    <tr class="isi">
                        <td>
                            <strong>Diteruskan Kepada</strong> : <br/>$row['tujuan']<br/>
                            <strong>Tanggal</strong> : <br/><?= date('d M Y'); ?>
                        </td>
                        <td colspan="2">
                            <div style="font-weight: bold; text-align: center">Isi Disposisi</div>
                            <div style="height: 10px;"></div>
                            <div>$row['isi_disposisi']</div>
                            <span class="bat">
                                <div class="bottom-align-text">
                                    <div>Tanda&nbsp;Terima</div>
                                    <div style="height: 70px;"></div>
                                    <div style="font-weight: bold">ASDFASDFASDFASDF</div>
                                    <div>NIP. XXXXXXX XXXXXX X XXX</div>
                                </div>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="lead">
            <div align="center">Kepala Pelaksana</div>
            <div style="height: 80px;"></div>
            <span class="lead">
                <div align="center">ASDFASDFASDFASDF</div>
            </span>
            <div align="center">NIP. XXXXXXX XXXXXX X XXX</div>
        </div>
    </div>
    <div class="jarak2"></div>
</section>