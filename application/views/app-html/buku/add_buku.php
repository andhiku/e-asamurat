<style>
    a { color: #444; }
</style>
<section class="content">
    <div class="row"><!-- row-->
        <div class="col-md-12">
            <?php if ($this->session->flashdata('success')) { ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p style="text-align:center;"><strong>Sukses!</strong> Data telah ditambahkan.</p>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <ul class="nav nav-tabs text-center">
                        <li class="active text-center"><a href="#step1-tab" data-toggle="tab">
                                <strong>Step 1</strong> <br>Lengkapi Data Kejadian Bencana  <i class="glyphicon"></i></a>
                        </li>
                        <li class="text-center"><a href="#step2-tab" class="text-default" data-toggle="tab">
                                <strong>Step 2</strong><br> Lengkapi Data Korban dan Kerugian <i class="glyphicon"></i></a>
                        </li>
                        <li class="text-center"><a href="#step3-tab" class="text-default" data-toggle="tab">
                                <strong>Step 3</strong><br> Upload File pada Album Foto <i class="glyphicon"></i></a>
                        </li>
                    </ul>
                </div>
                <form action="<?php echo site_url('apps/app_buku/insert'); ?>" id="add_buku" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="step1-tab">
                                <div class="col-md-6 form-horizontal">
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Waktu :</label>
                                        <div class="col-xs-7">
                                            <input type="time" class="form-control time" name="waktu" />
                                            <small class="text-muted">ex. 12:00 AM</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Tanggal :</label>
                                        <div class="col-xs-7">
                                            <input type="date" class="form-control date" name="tanggal" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Alamat :</label>
                                        <div class="col-xs-7">
                                            <input type="text" class="form-control" name="alamat" onkeyup="this.value = this.value.toUpperCase();"/>
                                        </div>
                                    </div>
                                    <div class="form-group" id="form_kecamatan">
                                        <label class="col-xs-3 control-label">Kecamatan :</label>
                                        <div class="col-xs-7">
                                            <select name="kecamatan" id="list_kecamatan" class="form-control">
                                                <option value="">- PILIHAN -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="form_desa">
                                        <label class="col-xs-3 control-label">Desa :</label>
                                        <div class="col-xs-7">
                                            <select name="desa" id="list_desa" class="form-control">
                                                <option value="">- PILIHAN -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-horizontal">
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Jenis Bencana :</label>
                                        <div class="col-xs-7">
                                            <select name="jenis" id="cek_jenis" class="form-control">
                                                <option value="">- PILIHAN -</option>
                                                <?php
                                                foreach ($this->mbpn->jenis_hak() as $row) : echo "<option value='{$row->id_jenis}'>{$row->jenis_bencana}</option>";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="luas">Luas Area :</label>
                                        <div class="col-xs-7">
                                            <input class="form-control" name="luas" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="sebab">Penyebab :</label>
                                        <div class="col-xs-7">
                                            <input type="text" class="form-control" name="sebab" onkeyup="this.value = this.value.toUpperCase();"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Kerugian :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control uang" name="kerugian" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label">Keterangan :</label>
                                        <div class="col-xs-7">
                                            <textarea name="ket" id="ket" cols="30" rows="2" class="form-control" onkeyup="this.value = this.value.toUpperCase();"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default btn-lg continue">Lanjut <i class="fa fa-arrow-right"></i></button>
                                    </div>                
                                </div>
                            </div>
                            <div class="tab-pane" id="step2-tab">
                                <div class="col-md-6 form-horizontal">
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="kk">Korban KK :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control" name="kk" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="jiwa">Korban Jiwa :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control" name="jiwa" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="rusak_ringan">Rusak Ringan :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control" name="rusak_ringan" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="rusak_sedang">Rusak Sedang :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control" name="rusak_sedang" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="rusak_berat">Rusak Berat :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control" name="rusak_berat" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-horizontal">
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="f_pendidikan">Pendidikan :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control" name="f_pendidikan" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="f_peribadatan">Peribadahan :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control" name="f_peribadatan" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="f_kesehatan">Kesehatan :</label>
                                        <div class="col-xs-7">
                                            <input type="number" class="form-control" name="f_kesehatan" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-3 control-label" id="list_tim">Tim :</label>
                                        <div class="col-xs-7">
                                            <select name="tim[]" class="form-control select" multiple="multiple" style="width: 340px;">
                                                <?php
                                                foreach ($this->mbpn->tim() as $row) : echo "<option value='{$row->id_tim}'>{$row->nama_tim}</option>" . ",";
                                                endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <div class="pull-left">
                                        <button type="button" class="btn btn-default btn-lg back"><i class="fa fa-arrow-left"></i> Kembali</button>
                                    </div>   
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-default btn-lg continue">Lanjut <i class="fa fa-arrow-right"></i></button>
                                    </div>                
                                </div>
                            </div>
                            <div class="tab-pane" id="step3-tab">
                                <div class="col-md-12 form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-2 col-xs-12 control-label">Dokumentasi :</label>
                                        <div class="col-lg-7 col-xs-7">
                                            <!--<input class="form-control" type="file" id="foto" name="foto" accept="image/*"/>-->
                                            <input class="form-control" type="file" id="foto" name="foto[]" data-index="0" multiple="multiple" accept="image/*"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                    <div class="pull-left">
                                        <button type="button" class="btn btn-default btn-lg back">
                                            <i class="fa fa-arrow-left"></i> Kembali</button>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success btn-lg">
                                            <i class="fa fa-save"></i> Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                    </div>
                </form>
            </div> 

        </div>
    </div>
</section>
<style type="text/css">.text-default { color:#444; } </style>

<div class="modal fade modal-default" id="myModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Success!</h4> &nbsp;
                <center><small>Data telah ditambahkan.</small></center>
            </div>
            <div class="modal-footer">
                <center><a href="#" class="btn btn-success" data-dismiss="modal">OK</a></center>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker();
    });

    //    jquery inputmask bundle
    (function ($) {
        $('.datetime').inputmask("datetime", {
            mask: "1-2-y h:s",
            placeholder: "DD-MM-YYYY HH:MM",
            leapday: "-02-29",
            separator: "-",
            alias: "dd/mm/yyyy"
        });

    })(jQuery)
//    jquery inputmask bundle

    //    jquery mask start
    $(document).ready(function () {

        // Format mata uang.
        $('.uang').mask('000.000.000.000.000', {reverse: true});
        $('.date').mask('00-00-0000');
        $('.time').mask('00:00:00');
        $('.date_time').mask('00-00-0000 00:00:00');
        $('.phone').mask('000-000-000-000');
        $('.phone_with_ddd').mask('(00) 00 000-000-000');
        $('.phone_us').mask('(000) 000-0000');
        $('.percent').mask('##0,00%', {reverse: true});
        $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
        $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
        $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
    })
    //    datetime stop


    // multiple select
    $("select").multipleSelect({
        selectAll: false
    });
</script>