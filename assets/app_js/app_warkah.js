$(document).ready(function() {
    // Load Data Rak
    $('#lemari_warkah').change(function() {
        $.ajax({
            type :'GET',
            url  : base_domain + '/api/get_listRak/' + $(this).val(),
            success: function (data) {
                $('#rak_warkah').empty();
                if(data.status == true ) {
                    $('#rak_warkah').append('<option value="">- PILIHAN - </option>');
                    for(i=0; i < data.result.length; i++) {
                        $('#rak_warkah').append('<option value="'+data.result[i].no_rak+'">'+data.result[i].nama_rak+'</option>');                      
                    }
                } else {  
                    $('#rak_warkah').empty();
                    $('#rak_warkah').append('<option value="">- PILIHAN - </option>');
                    $.notify("Maaf!!\nData Rak tidak ditemukan.", "warm");
                }
            }
        });
        return false;
    });
    $('#rak_warkah').change(function() {
        var lemari = $('#lemari_warkah').val();
        var rak    = $(this).val();
        $.ajax({
            type :'GET',
            url  : base_domain + '/api/get_listAlbum/'+ lemari + '/' + rak + '?doc=warkah',
            success: function (data) {
                if(data.status == true ) {
                    $('#album_warkah').attr('data-rak', rak);
                    $('#album_warkah').html('<option value="">- PILIHAN -</option>');
                    var option = '';
                    option = '<option value="">- PILIHAN -</option>';
                    $.each(data['result'], function(i,item){
                        option = '<option value="'+item['no_album']+'">'+item['nama_album']+'</option>';
                        option = option + '';
                        $('#album_warkah').append(option);
                    });
                } else {
                    $('#album_warkah').empty();
                    $('#laman_warkah').empty();
                    $.notify("Maaf!!\nData Album tidak ditemukan.", "warm");
                    $('#album_warkah').append('<option value="">- PILIHAN - </option>');
                }
            }
        });
        return false;
    });
    $('#album_warkah').change(function() {
        var lemari = $('#lemari_warkah').val();
        var rak    = $('#rak_warkah').val();
        var laman  = $(this).val();
        var data_load = $('#laman');
        $.ajax({
            type :'GET',
            url  : base_domain + '/api/get_listLaman_warkah/'+ lemari + '/' + rak + '/' + laman,
            beforeSend: function() {
                loading('#laman');
            },
            success: function (data) {
                $('#loading').remove();
                if(data.status == true ) {
                    $.each(data['results'], function(i, item, terisi) {
                        var ketersediaan = (item['ketersediaan']) ? '' : 'disabled';
                        var data_terisi = (item['ketersediaan']) ? '' : 'class="text-red" data-toggle="tooltip" data-placement="top" title="Terisi!"';
                        $('#laman').append('<li><div class="col-md-1 col-xs-3"><div class="radio"><label><strong onclick="cek_ketersedia_warkah('+data['no_lemari']+','+data['no_rak']+','+data['no_album']+','+item['no_halaman']+')" '+data_terisi+'><input type="radio" name="no_halaman" value="'+item['no_halaman']+'" '+ketersediaan+'>'+item['no_halaman']+'</strong></label></div></div><li>');
                    })
                } else {
                    $('#laman').empty();
                    $.notify("Maaf!!\nMohon buat Album terlebih dahulu.", "warm");
                }
            }
        });
        return false;
    });
});



function cek_ketersedia_warkah(lemari, rak, album, halaman) {
    $.ajax({
        type :'GET',
        url  : base_domain + '/api/cek_warkah/'+ lemari + '/' + rak + '/' + album + '/' + halaman,
        success: function (data) {
            if(data.status) {
                var item = data['result'];
                $('#modal-data_tersedia').modal('show');
                var code = '<tr>\n';
                code += '<td><strong>Jenis Hak</strong></td>\n';
                code += '<td width="10" class="text-center">:</td>\n';
                code += '<td>'+item['jenis_hak']+'</td><td width="30"></td>\n';
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

$('#add_file_warkah').formValidation({
    excluded: [':disabled'],
    fields: {
        'file[0]': { validators: {   notEmpty: {  message: 'Harap isi File.' }, }  }
    }
});

function delete_file_warkah(id, no208) {
    $('#modal_delete_file_warkah').modal('show');
    $('#button_delete_file_warkah').html('<a href="'+base_domain + '/apps/file_warkah/delete/'+ id + '/' + no208 + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function edit_pinjam_warkah(id) {
    $.ajax({
        type :'GET',
        url  : base_domain + '/apps/pinjam_warkah/get_json/'+ id,
        success: function (data) {
            if(data.status) {
                var item = data['result'][0];
                $('#modal_edit_pinjam_warkah').modal('show');
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
                $('#form_edit_pinjam_warkah').attr('action', base_domain + '/apps/pinjam_warkah/update/' + id);
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

function delete_pinjam_warkah(id) {
    $('#modal_delete_pinjam_warkah').modal('show');
    $('#button_delete_pinjam_warkah').html('<a href="#" id="delete_pinjam_warkah" class="btn btn-danger">Hapus</a>');
    $('#delete_pinjam_warkah').click(function () {
        $.ajax({
            type :'GET',
            url  : base_domain + '/apps/pinjam_warkah/delete/'+ id,
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