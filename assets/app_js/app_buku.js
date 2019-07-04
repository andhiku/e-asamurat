$(function() {
  var $progress = $('#progress');
  $(document).ajaxStart(function() {
    //only add progress bar if not added yet.
    if ($progress.length === 0) {
      $progress = $('<div><dt/><dd/></div>').attr('id', 'progress');
      $("body").append($progress);
    }
    $progress.width((50 + Math.random() * 30) + "%");
  });

  $(document).ajaxComplete(function() {
    //End loading animation
    $progress.width("100%").delay(200).fadeOut(400, function() {
      $progress.width("0%").delay(200).show();
    });
  });
});


$(document).ready(function() {
    $('#add_buku')
        .formValidation({
            excluded: [':disabled'],
            fields: {
                waktu: { validators: { notEmpty: { message: 'Mohon isi waktu kejadian.' } } },
                tanggal: { validators: { notEmpty: { message: 'Mohon isi tanggal kejadian.' } } },
                alamat: { validators: { notEmpty: { message: 'Harap diisi.' } } },
                luas: { validators: { notEmpty: { message: 'Harap isi luas area terdampak.' } } },
                kecamatan: { validators: { notEmpty: { message: 'Pilih Salah Satu.' } } },
                desa: { validators: { notEmpty: { message: 'Pilih Salah Satu.' } } },
                jenis: { validators: { notEmpty: { message: 'Pilih Salah Satu Jenis Bencana.' } } },
                sebab: { validators: { notEmpty: { message: 'Harap diisi.' } } },
                kerugian: { validators: { notEmpty: { message: 'Harap diisi.' } } },
                tim: { validators: { notEmpty: { message: 'Harap diisi.' } } },
                foto: { validators: { notEmpty: { message: 'Harap Upload Dokumentasi Foto' } } }
            }
        })
        .on('err.form.fv', function(e) {
            var $form          = $(e.target),
                fv             = $form.data('formValidation'),
                $invalidFields = fv.getInvalidFields();

            for (var i = 0; i < $invalidFields.length; i++) {
                var $field    = $invalidFields.eq(i),
                    autoFocus = fv.isOptionEnabled($field.attr('data-fv-field'), 'autoFocus');

                if (autoFocus) {
                    // Activate the tab containing the field if exists
                    var $tabPane = $field.parents('.tab-pane'), tabId;
                    if ($tabPane && (tabId = $tabPane.attr('id'))) {
                        $('a[href="#' + tabId + '"][data-toggle="tab"]').tab('show');
                    }
                    break;
                }
            }
        })
            .on('success.field.fv', function(e, data) {
                console.log('success.field.fv -->', data.element);
            })
            .on('added.field.fv', function(e, data) {
                console.log('Added element -->', data.field, data.element);
            })
            .on('removed.field.fv', function(e, data) {
                console.log('Removed element -->', data.field, data.element);
            })
        .on('status.field.fv', function(e, data) {
            var validator = data.fv,
                $tabPane  = data.element.parents('.tab-pane'),
                tabId     = $tabPane.attr('id');
            
            if (tabId) {
                var $icon = $('a[href="#' + tabId + '"][data-toggle="tab"]').parent().find('i');

                // Add custom class to tab containing the field
                if (data.status == validator.STATUS_INVALID) {
                    $icon.removeClass('glyphicon-ok').addClass('glyphicon-remove');
                } else if (data.status == validator.STATUS_VALID) {
                    $icon.removeClass('glyphicon-ok glyphicon-remove');

                    var isValidTab = validator.isValidContainer($tabPane);
                    if (isValidTab !== null) {
                        $icon.addClass(isValidTab ? 'glyphicon-ok' : 'glyphicon-remove');
                    }
                }
            }
        });
    $('.addButton').on('click', function() {
        var index = $(this).data('index');
        if (!index) {
            index = 3;
            $(this).data('index', 0);
        }
        index++;
        $(this).data('index', index);

        var template     = $(this).attr('data-template'),
            $templateEle = $('#' + template + 'Template'),
            $row         = $templateEle.clone().removeAttr('id').insertBefore($templateEle).removeClass('hide'),
            $el          = $row.find('input').eq(0).attr('name', template + '['+index+']');
        $('#add_buku').formValidation('addField', $el);

        $row.on('click', '.removeButton', function(e) {
            $('#add_buku').formValidation('removeField', $el);
            $row.remove();
        });
    });

    // Load Data Rak
    $('#lemari').change(function() {
        $.ajax({
            type :'GET',
            url  : base_domain + '/api/get_listRak/' + $(this).val(),
            success: function (data) {
                $('#rak').empty();
                if(data.status == true ) {
                    $('#rak').append('<option value="">- PILIHAN - </option>');
                    for(i=0; i < data.result.length; i++) {
                        $('#rak').append('<option value="'+data.result[i].no_rak+'">'+data.result[i].nama_rak+'</option>');                      
                    }
                } else {  
                    $('#rak').empty();
                    $('#rak').append('<option value="">- PILIHAN - </option>');
                    $.notify("Maaf!!\nData Rak tidak ditemukan.", "warm");
                }
            }
        });
        return false;
    });
    $('#rak').change(function() {
         var lemari = $('#lemari').val();
         var rak    = $(this).val();
        $.ajax({
            type :'GET',
            url  : base_domain + '/api/get_listAlbum/'+ lemari + '/' + rak + '?doc=buku_tanah',
            success: function (data) {
                if(data.status == true ) {
                    $('#album').html('<option value="">- PILIHAN -</option>');
                    var option = '';
                    option = '<option value="">- PILIHAN -</option>';
                    $.each(data['result'], function(i,item){
                        option = '<option value="'+item['no_album']+'">'+item['nama_album']+'</option>';
                        option = option + '';
                        $('#album').append(option);
                    });
                } else {
                    $('#album').empty();
                    $('#laman').empty();
                    $.notify("Maaf!!\nData Album tidak ditemukan.", "warm");
                    $('#album').append('<option value="">- PILIHAN -</option>');
                }
            }
        });
        return false;
    });
    $('#album').change(function() {
        var lemari = $('#lemari').val();
        var rak    = $('#rak').val();
        var laman  = $(this).val();
        var data_load = $('#laman');
        $.ajax({
            type :'GET',
            url  : base_domain + '/api/get_listLaman/'+ lemari + '/' + rak + '/' + laman,
            beforeSend: function() {
                loading('#laman');
            },
            success: function (data) {
                $('#loading').remove();
                if(data.status == true ) {
                    $.each(data['results'], function(i, item, terisi) {
                        var ketersediaan = (item['ketersediaan']) ? '' : 'disabled';
                        var data_terisi = (item['ketersediaan']) ? '' : 'class="text-red" data-toggle="tooltip" data-placement="top" title="Terisi!"';
                        $('#laman').append('<li><div class="col-md-1 col-xs-3"><div class="radio"><label><strong onclick="cek_ketersedia('+data['no_lemari']+','+data['no_rak']+','+data['no_album']+','+item['no_halaman']+')" '+data_terisi+'><input type="radio" name="no_halaman" value="'+item['no_halaman']+'" '+ketersediaan+' required>'+item['no_halaman']+'</strong></label></div></div><li>');
                    });
                } else {
                    $.notify("Maaf!!\nMohon buat Album terlebih dahulu.", "warm");
                }
            }
        });
        return false;
    });

});
function loading(selector) {
    $(selector).html('<img src="' + base_path + '/assets/images/loading.gif" id="loading" />');
}

$('.add_buku').click( function (argument) {
    if (isNaN($('input[name="no_halaman"]').val()) || $('input[name="no_halaman"]').val() < 1 || $('input[name="no_halaman"]').val() > 100) {
        $.notify("Maaf!!\nMohon pilih Slot halaman yang tersedia.", "warm");
        $('#step1-tab').tab('show');
    } else {
        $.notify("Slot " + $('input[name="no_halaman"]').val() + " terpilih.", "info");
    }
})


function cek_ketersedia(lemari, rak, album, halaman) {
    $.ajax({
        type :'GET',
        url  : base_domain + '/api/cek_buku/'+ lemari + '/' + rak + '/' + album + '/' + halaman,
        success: function (data) {
            if(data.status) {
                var item = data['result'];
                $('#modal-data_tersedia').modal('show');
                var code = '<tr>\n';
                code += '<td><strong>Jenis Hak</strong></td>\n';
                code += '<td width="10" class="text-center">:</td>\n';
                code += '<td>'+item['jenis_bencana']+'</td><td width="30"></td>\n';
                code += '<td><strong>No 208</strong></td>\n';
                code += '<td width="10" class="text-center">:</td><td>'+item['no208']+'</td>\n';
                code += '</tr>\n';
                code += '<tr>\n';
                code += '<td><strong>No Hak</strong></td>\n';
                code += '<td width="10" class="text-center">:</td>\n';
                code += '<td>'+item['no_hakbuku']+'</td><td width="30"></td>\n';
                code += '<td><strong>Tahun</strong></td>\n';
                code += '<td width="10" class="text-center">:</td><td>'+item['tahun']+'</td>\n';
                code += '</tr>\n';
                code += '<tr>\n';
                code += '<td><strong>Kecamatan</strong></td>\n';
                code += '<td width="10" class="text-center">:</td>\n';
                code += '<td>'+item['kecamatan']+'</td><td width="30"></td>\n';
                code += '<td><strong>Luas</strong></td>\n';
                code += '<td width="30" class="text-center">:</td><td>'+item['luas']+'</td>\n';
                code += '</tr>\n';
                code += '<tr>\n';
                code += '<td><strong>Desa</strong></td>\n';
                code += '<td width="10" class="text-center">:</td>\n';
                code += '<td>'+item['desa']+'</td><td width="30"></td>\n';
                code += '<td><strong>Status</strong></td>\n';
                code += '<td width="10" class="text-center">:</td><td>'+item['status']+'</td>\n';
                code += '</tr>';
                $('#data_terisi').html(code);
                $('#slot').html(halaman);
            }
        }
    });
    return false;
}


$('.continue').click(function(){
  $('.nav-tabs > .active').next('li').find('a').trigger('click');
});
$('.back').click(function(){
  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
});

function delete_file_buku(id, nohak, id_buku) {
    $('#modal_delete_file_buku').modal('show');
    $('#button_delete_file_buku').html('<a href="'+base_domain + '/apps/file_buku/delete/'+ id + '/' + nohak + '/' + id_buku + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function edit_pinjam_buku(id) {
    $.ajax({
        type :'GET',
        url  : base_domain + '/apps/pinjam_buku/get_json/'+ id,
        success: function (data) {
            if(data.status) {
                var item = data['result'][0];
                $('#modal_edit_pinjam_buku').modal('show');
                $('.tgl_peminjaman').val(item['tgl_peminjaman']);
                $('.tgl_kembali').val(item['tgl_kembali']);
                $('#peminjam').val(item['peminjam']);
                $('#keterangan').val(item['kegiatan']);
                switch (item['status_pinjam']) {
                    case 'N':
                        document.getElementById('status_keluar').checked = true;
                        break;
                    case 'Y':
                        document.getElementById('status_kembali').checked = true;
                        break;
                }
                $('#form_edit_pinjam_buku').attr('action', base_domain + '/apps/pinjam_buku/update/' + id);
            } else {
                 $.notify("Gagal!!\nData Tidak ditemukan.", "warm");
            }
        },
        error : function () {
            $.notify("Gagal!!\nmengambil data pinjaman.", "warm");
        }
    });
    return false;
}

function delete_pinjam_buku(id) {
    $('#modal_delete_pinjam_buku').modal('show');
    $('#button_delete_pinjam_buku').html('<a href="#" id="delete_pinjam_buku" class="btn btn-danger">Hapus</a>');
    $('#delete_pinjam_buku').click(function () {
        $.ajax({
            type :'GET',
            url  : base_domain + '/apps/pinjam_buku/delete/'+ id,
            success: function (data) {
                if(data.status) {
                    window.location.reload();
                } else {
                    $.notify("Gagal!!\nmenghapus Data.", "warm");
                }
            },
            error : function () {
                $.notify("Gagal!!\Menghapus data.", "warm");
            }
        });
    });
    return false;
}


function print_buku(id) {
    newwindow=window.open(base_domain + '/apps/pinjam_buku/cetak/' + id,'name','height=600,width=800');
    if (window.focus) {
        newwindow.focus()
    }
    return false;
}


function foto_buku_hapus(id_buku) {
    var form_asal  = $("#form_edit_buku");
    $.ajax({
        type :'POST',
        data : $('#form_edit_buku').serialize(),
        url  : base_domain + '/apps/file_buku/bulk_action/'+ id_buku,
        success: function (data) {
            if(data.status) {
                $('#step3-tab').addClass('active');
                window.location.reload();
            } else {
                $.notify("Gagal!!\nmenghapus Data.", "warm");
            }
        },
        error : function () {
            $.notify("Gagal!!\Menghapus data.", "warm");
        }
    });
    return false;
}