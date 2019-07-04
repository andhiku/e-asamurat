function delete_lemari(id) {
    $('#delete_lemari').modal('show');
    $('#del_lemari').html('<a href="' + base_domain + '/setting/clemari/set_lemari?method=delete&id=' + id + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function delete_rak(id, lemari) {
    $('#delete_rak').modal('show');
    $('#del_rak').html('<a href="' + base_domain + '/setting/clemari/set_rak?method=delete&id=' + id + '&lemari=' + lemari + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function delete_album(id, rak) {
    $('#delete_album').modal('show');
    $('#del_album').html('<a href="' + base_domain + '/setting/clemari/set_album?method=delete&id=' + id + '&rak=' + rak + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function edit_kecamatan(id) {
    $.ajax({
        url: base_domain + '/setting/cwilayah/get_kecamatan/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#edit_kecamatan').modal('show');
                $('#nama_kecamatan').val(item['nama_kecamatan']);
                $('#form_edit_kecamatan').attr('action', base_domain + '/setting/cwilayah/set_kecamatan?id=' + id + '&method=update');
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

function delete_kecamatan(id) {
    $('#delete_kecamatan').modal('show');
    $('#del_kecamatan').html('<a href="' + base_domain + '/setting/cwilayah/set_kecamatan?method=delete&id=' + id + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function edit_desa(id, kecamatan) {
    $.ajax({
        url: base_domain + '/setting/cwilayah/get_desa/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#edit_desa').modal('show');
                $('#nama_desa').val(item['nama_desa']);
                $('#form_edit_desa').attr('action', base_domain + '/setting/cwilayah/set_desa?id=' + id + '&method=update&kecamatan=' + kecamatan);
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

function delete_desa(id, kecamatan) {
    $('#delete_desa').modal('show');
    $('#del_desa').html('<a href="' + base_domain + '/setting/cwilayah/set_desa?method=delete&id=' + id + '&kecamatan=' + kecamatan + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function edit_hak(id) {
    $.ajax({
        url: base_domain + '/setting/chak/get/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#edit_hak').modal('show');
                $('#jenis_hak').val(item['jenis_hak']);
                $('#form_edit_hak').attr('action', base_domain + '/setting/chak/update/' + id);
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

function delete_hak(id) {
    $('#delete_hak').modal('show');
    $('#del_hak').html('<a href="' + base_domain + '/setting/chak/delete/' + id + '" class="btn btn-danger">Hapus</a>');
    return false;
}

$('#form_add_jenis').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        jenis_bencana: {
            message: 'Jenis bencana tidak valid',
            validators: {
                notEmpty: {
                    message: 'Jenis bencana tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/setting/chak/cek',
                    message: 'Maaf! Jenis bencana sudah ada.',
                    delay: 1000
                }
            }
        }
    }
});

$('#form_add_tim').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        nama_tim: {
            message: 'Nama tim tidak valid',
            validators: {
                notEmpty: {
                    message: 'Nama tim tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/setting/ctim/cek',
                    message: 'Maaf! nama tim sudah ada.',
                    delay: 1000
                }
            }
        }
    }
});


function edit_tim(id) {
    $.ajax({
        url: base_domain + '/setting/ctim/get/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#edit_tim').modal('show');
                $('#data_tim').val(item['data_tim']);
                $('#form_edit_tim').attr('action', base_domain + '/setting/ctim/update/' + id);
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


function delete_tim(id) {
    $('#delete_tim').modal('show');
    $('#del_tim').html('<a href="' + base_domain + '/setting/ctim/delete/' + id + '" class="btn btn-danger">Hapus</a>');
    return false;
}

$('#form_add_user').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        nama: {validators: {notEmpty: {message: 'Nama Lengkap tidak boleh kosong.'}}},
        jabatan: {validators: {notEmpty: {message: 'Jabatan tidak boleh kosong.'}}},
        bidang: {validators: {notEmpty: {message: 'Bidang tidak boleh kosong.'}}},
//        email: {
//            message: 'email tidak valid',
//            validators: {
//                notEmpty: {message: 'Email tidak boleh kosong.'
//                }
//            }
//        },
        userfile: {
            message: 'tanda tangan tidak valid',
            validators: {
                notEmpty: {message: 'Mohon masukkan tanda tangan yang telah discan dengan format file *.png.'
                }
            }
        },
        username: {
            message: 'Username tidak valid',
            validators: {
                notEmpty: {
                    message: 'Username tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/setting/cusers/cek',
                    message: 'Maaf! Username telah digunakan.',
                    delay: 1000
                }
            }
        },
        pass: {
            validators: {
                notEmpty: {message: 'Password tidak boleh kosong.'},
                stringLength: {
                    min: 6,
                    max: 20,
                    message: 'Minimal 6 dan 20 karakter.'
                }
            }
        },
        again: {
            validators: {
                notEmpty: {message: 'Password tidak boleh kosong.'},
                identical: {field: 'pass', message: 'Password tidak sama pada sebelumnya.'}
            }
        },
    }
});

$('#form_update_profil').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        nama: {validators: {notEmpty: {message: 'Nama Lengkap tidak boleh kosong.'}}},
        ttd: {validators: {notEmpty: {message: 'Mohon masukkan tanda tangan yang telah discan dengan format file *.png.'}}},
    }
});

function delete_user(id) {
    $('#delete_user').modal('show');
    $('#del_user').html('<a href="' + base_domain + '/setting/cusers/delete/' + id + '" class="btn btn-danger">Hapus</a>');
    return false;
}

$('#form_ganti_pass').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        lama: {
            message: 'The password is not valid',
            validators: {
                notEmpty: {
                    message: 'Password tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/setting/profile/cek_pass',
                    message: 'Maaf! Password lama anda salah.',
                    delay: 1000
                }
            }
        },
        password: {
            validators: {
                notEmpty: {message: 'Password tidak boleh kosong.'},
                stringLength: {
                    min: 6,
                    max: 20,
                    message: 'Minimal 6 dan 30 karakter.'
                },
            }
        },
    }
});
