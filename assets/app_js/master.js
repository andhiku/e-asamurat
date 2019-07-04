//$('#form_add_bidang').formValidation({
//    message: 'This value is not valid',
//    icon: {
//        valid: 'glyphicon glyphicon-ok',
//        invalid: 'glyphicon glyphicon-remove',
//        validating: 'glyphicon glyphicon-refresh'
//    },
//    fields: {
//        bidang: {
//            message: 'Nama bidang tidak valid',
//            validators: {
//                notEmpty: {
//                    message: 'Nama bidang tidak boleh kosong.'
//                },
//                remote: {
//                    type: 'POST',
//                    url: base_domain + '/bidang/cek_bidang',
//                    message: 'Maaf! nama bidang sudah ada.',
//                    delay: 1000
//                }
//            }
//        }
//    }
//});

function edit_bidang(id) {
    $.ajax({
        url: base_domain + '/bidang/get_bidang/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#edit_bidang').modal('show');
                $('#bidang').val(item['nama_bidang']);
                $('#form_edit_bidang').attr('action', base_domain + '/bidang/set_bidang?id=' + id + '&method=update');
            } else {
                alert('ERROR!');
            }
        },
        error: function () {
            alert('ERROR!');
        }
    });
    return false;
}

function delete_bidang(id) {
    $('#delete_bidang').modal('show');
    $('#del_bidang').html('<a href="' + base_domain + '/bidang/set_bidang?method=delete&id=' + id + '" class="btn btn-danger">Hapus</a>');
    return false;
}

//$('#form_add_pegawai').formValidation({
//    message: 'This value is not valid',
//    icon: {
//        valid: 'glyphicon glyphicon-ok',
//        invalid: 'glyphicon glyphicon-remove',
//        validating: 'glyphicon glyphicon-refresh'
//    },
//    fields: {
//        pegawai: {
//            message: 'Nama bidang tidak valid',
//            validators: {
//                notEmpty: {
//                    message: 'Nama pegawai tidak boleh kosong.'
//                },
//                remote: {
//                    type: 'POST',
//                    url: base_domain + '/bidang/cek_pegawai',
//                    message: 'Maaf! nama pegawai sudah ada.',
//                    delay: 1000
//                }
//            }
//        },
//        jabatan: {
//            message: 'Jabatan tidak valid',
//            validators: {
//                notEmpty: {
//                    message: 'Jabatan tidak boleh kosong.'
//                }
//            }
//        }
//    }
//});

function edit_pegawai(id, bidang) {
    $.ajax({
        url: base_domain + '/bidang/get_pegawai/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#edit_pegawai').modal('show');
                $('#nama_pegawai').val(item['nama_pegawai']);
                $('#jabatan').val(item['jabatan']);
                $('#form_edit_pegawai').attr('action', base_domain + '/bidang/set_pegawai?id=' + id + '&method=update&bidang=' + bidang);
            } else {
                alert('ERROR!');
            }
        },
        error: function () {
            alert('ERROR!');
        }
    });
    return false;
}

function delete_pegawai(id, kecamatan) {
    $('#delete_pegawai').modal('show');
    $('#del_pegawai').html('<a href="' + base_domain + '/bidang/set_pegawai?method=delete&id=' + id + '&bidang=' + bidang + '" class="btn btn-danger">Hapus</a>');
    return false;
}