
$(document).ready(function() {
    var lemari = $('#data_album_informasi').data('lemari'); 
    var rak    = $('#data_album_informasi').data('rak');
    var album  = $('#data_album_informasi').data('album');
    $.ajax({
        type :'GET',
        url  : base_domain + '/api/informasi_album/'+ lemari + '/' + rak + '/' + album,
        success: function (data) {
            if(data.status == true ) {
                var object = data['object'],
                    buku = data['results_buku'],
                    warkah = data['results_warkah'];
                var code = '<tr>\n';
                var doc = (object['document']==='buku_tanah') ? 'Buku Tanah' : 'Warkah';
                var jumlah_rows = (object['document']==='buku_tanah') ? 10 : 5;
                $('#rows').attr('colspan', jumlah_rows + 5);
                code += '<td rowspan="11" class="bg-warning">'+ object['nama_lemari'] +'</td>\n';
                code += '<td rowspan="11" class="bg-warning">'+ object['nama_rak'] +'</td>\n';
                code += '<td rowspan="11" class="bg-warning">'+ object['nama_album'] +'</td>\n';
                code += '<td rowspan="11" class="bg-warning">'+ doc +'</td>\n';
                code += '</tr>\n';

                if(object['document']==='buku_tanah') {
                    code += '<tr>\n';
                    var ca = 0;
                    for (var ra = 1; ra <= 10; ra++) {
                        code += '<td width="50" class="text-center '+ buku[ca++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var cb = 10;
                    for (var ra = 11; ra <= 20; ra++) {
                         code += '<td width="50" class="text-center '+ buku[cb++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var cc = 20;
                    for (var ra = 21; ra <= 30; ra++) {
                         code += '<td width="50" class="text-center '+ buku[cc++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var cd = 30;
                    for (var ra = 31; ra <= 40; ++ra) {
                         code += '<td width="50" class="text-center '+ buku[cd++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var ce = 40;
                    for (var ra = 41; ra <= 50; ++ra) {
                         code += '<td width="50" class="text-center '+ buku[ce++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var ce = 50;
                    for (var ra = 51; ra <= 60; ++ra) {
                         code += '<td width="50" class="text-center '+ buku[ce++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var ce = 60;
                    for (var ra = 61; ra <= 70; ++ra) {
                         code += '<td width="50" class="text-center '+ buku[ce++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var ce = 70;
                    for (var ra = 71; ra <= 80; ++ra) {
                         code += '<td width="50" class="text-center '+ buku[ce++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var ce = 80;
                    for (var ra = 81; ra <= 90; ++ra) {
                         code += '<td width="50" class="text-center '+ buku[ce++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var ce = 90;
                    for (var ra = 91; ra <= 100; ++ra) {
                         code += '<td width="50" class="text-center '+ buku[ce++]['color'] +'"><a href="#" onclick="informasi_buku_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                } else {
                    code += '<tr>\n';
                    var ca = 0;
                    for (var ra = 1; ra <= 10; ra++) {
                        code += '<td width="50" class="text-center '+ warkah[ca++]['color'] +'"><a href="#" onclick="informasi_warkah_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var cb = 10;
                    for (var ra = 11; ra <= 20; ra++) {
                         code += '<td width="50" class="text-center '+ warkah[cb++]['color'] +'"><a href="#" onclick="informasi_warkah_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var cc = 20;
                    for (var ra = 21; ra <= 30; ra++) {
                         code += '<td width="50" class="text-center '+ warkah[cc++]['color'] +'"><a href="#" onclick="informasi_warkah_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var cd = 30;
                    for (var ra = 31; ra <= 40; ++ra) {
                         code += '<td width="50" class="text-center '+ warkah[cd++]['color'] +'"><a href="#" onclick="informasi_warkah_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                    code += '<tr>\n';
                    var ce = 40;
                    for (var ra = 41; ra <= 50; ++ra) {
                         code += '<td width="50" class="text-center '+ warkah[ce++]['color'] +'"><a href="#" onclick="informasi_warkah_album('+lemari+','+rak+','+album+','+ ra +');">'+ ra +'</a></td>\n';
                    }
                    code += '</tr>';
                }

                $('#data_album_informasi').html(code);
            } else {
               // $.notify("Maaf!!\nData Halaman tidak tersedia.", "danger");
            }
        }
    });
    return false;
});


function informasi_buku_album(lemari, rak, album, halaman) {
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
                code += '<tr>\n';
                code += '<td><strong>Pemilik Awal</strong></td>\n';
                code += '<td width="10" class="text-center">:</td>\n';
                code += '<td>'+item['pemilik']+'</td><td width="30"></td>\n';
                code += '<td><strong>Catatan Buku Tanah</strong></td>\n';
                code += '<td width="10" class="text-center">:</td><td>'+item['catatan']+'</td>\n';
                code += '</tr>';
                $('#data_terisi').html(code);
                $('#slot').html(halaman);
            } else {
                $('#slot_kosong').html(halaman);
                $('#modal-data_kosong').modal('show');
                $('#tombol_isi').html('<a href="'+ base_domain + '/buku/selipkan?no_album=' + album + '&halaman=' + halaman +'" class="btn btn-primary pull-left">Isi Buku Tanah</a>');
            }
        }
    });
    return false;
}


function informasi_warkah_album(lemari, rak, album, halaman) {
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
                code += '<tr>\n';
                code += '<td><strong>Pemilik Awal</strong></td>\n';
                code += '<td width="10" class="text-center">:</td>\n';
                code += '<td>'+item['pemilik']+'</td><td width="30"></td>\n';
                code += '<td><strong>Catatan Warkah</strong></td>\n';
                code += '<td width="10" class="text-center">:</td><td>'+item['catatan']+'</td>\n';
                code += '</tr>';
                $('#data_terisi').html(code);
                $('#slot').html(halaman);
            } else {
                $('#slot_kosong').html(halaman);
                $('#modal-data_kosong').modal('show');
                $('#tombol_isi').html('<a href="#" class="btn btn-primary pull-left" onclick="simpan_warkah('+album+','+halaman+');">Isi Warkah</a>');
            }
        }
    });
    return false;
}

function simpan_warkah(album, halaman) {    
    $('#modal-simpan_warkah').modal('show');
    $('#w_album').val(album);
    $('#w_halaman').val(halaman);
    return false;
}

function ajax_simpan_warkah() {
    var form_asal  = $("#form_simpan_warkah");
    $.ajax({
        type :'POST',
        data : $('#form_simpan_warkah').serialize(),
        url  : $('#form_simpan_warkah').attr('action'),
        success: function (data) {
            if(data.status) {
                window.location.reload();
            } else {
                $.notify("Gagal!!\nmemasukkan data warkah.", "warm");
            }
        },
        error : function () {
            $.notify("Gagal!!\nmemasukkan data warkah.", "warm");
        }
    });
    return false;
}