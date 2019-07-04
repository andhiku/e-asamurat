$('#form_add_smasuk').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        no: {
            message: 'Nomor surat tidak valid',
            validators: {
                notEmpty: {
                    message: 'Nomor surat tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/surat/cek',
                    message: 'Maaf! Nomor surat sudah ada.',
                    delay: 1000
                }
            }
        },
        ts: {
            message: 'Tanggal surat tidak valid',
            validators: {
                notEmpty: {
                    message: 'Tanggal surat tidak boleh kosong.'
                }
            }
        },
        tt: {
            message: 'Tanggal terima surat tidak valid',
            validators: {
                notEmpty: {
                    message: 'Tanggal terima surat tidak boleh kosong.'
                }
            }
        },
        asal: {
            message: 'Asal surat tidak valid',
            validators: {
                notEmpty: {
                    message: 'Asal surat tidak boleh kosong.'
                }
            }
        },
        perihal: {
            message: 'perihal tidak valid',
            validators: {
                notEmpty: {
                    message: 'Perihal surat tidak boleh kosong.'
                }
            }
        },
        filed: {
            message: 'File tidak valid',
            validators: {
                notEmpty: {
                    message: 'Mohon pilih file surat.'
                }
            }
        }
    }
});

function edit_smasuk(id) {
    $.ajax({
        url: base_domain + '/surat/get_smasuk/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#edit_smasuk').modal('show');
                $('#no').val(item['no_surat']);
                $('#asal').val(item['asal']);
                $('#perihal').val(item['perihal']);
                $('#date3').val(item['tgl_surat']);
                $('#date4').val(item['tgl_terima']);
                $('#ket').val(item['keterangan']);
                $('#form_edit_smasuk').attr('action', base_domain + '/surat/set_smasuk?id=' + id + '&method=update');
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

function delete_smasuk(id) {
    $('#delete_smasuk').modal('show');
    $('#del_smasuk').html('<a href="' + base_domain + '/surat/set_smasuk?method=delete&id=' + id + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function viewpdf(id) {
    $.ajax({
        url: base_domain + '/surat/get_smasuk/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#viewpdf').modal('show');
                $('#filed').attr('src', base_path + '/assets/doc/smasuk/' + item['file']);
                $('.modal-titles').text('Lembar Disposisi');
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

function ds_admin(id) {
    $.ajax({
        url: base_domain + '/surat/get_smasuk/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#ds_admin').modal('show');
                $('#filera').attr('src', base_path + '/assets/doc/disposisi/' + item['disposisi']);
                $('.modal-titles').text('Lembar Disposisi');
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

function ds_kalak(id) {
    $.ajax({
        url: base_domain + '/surat/get_smasuk/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
//                $.post(base_domain + '/surat/addlaporan?id=' + id + '&method=add', function (data) {
                    $('#ds_kalak').modal('show');
//                });
                $('.modal-titles').text('Lembar Disposisi Kepala Pelaksana');
                $('#filerb').attr('src', base_path + '/assets/doc/disposisi/' + item['disposisi']);
                $('#form_ttd_kalak').attr('action', base_domain + '/surat/addlaporan?id=' + id + '&method=update');
                $('#form_ds_kalak').attr('action', base_domain + '/surat/addlaporan?id=' + id + '&method=update');
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

$('#form_ttd_kalak').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        password: {
            message: 'Password tidak valid',
            validators: {
                notEmpty: {
                    message: 'Password tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/surat/cek_pwd',
                    message: 'Maaf! Password yang anda masukkan salah.',
                    delay: 1000
                }
            }
        }
    }
});

function ds_kabag(id) {
    $.ajax({
        url: base_domain + '/surat/get_smasuk/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#ds_kabag').modal('show');
                $('#filerc').attr('src', base_path + '/assets/doc/disposisi/' + item['disposisi']);
//                $('#ds_kabag').attr('action', base_domain + '/surat/addlaporan?id=' + id + '&method=agree');
                $('#form_ttd_kabag').attr('action', base_domain + '/surat/addlaporan?id=' + id + '&method=agree');
                $('#form_ds_kabag').attr('action', base_domain + '/surat/addlaporan?id=' + id + '&method=agree');
                $('.modal-titles').text('Lembar Disposisi Kepala Bagian');
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

$('#form_ttd_kabag').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        tjn_akhir: {
            message: 'Tujuan tidak valid',
            validators: {
                notEmpty: {
                    message: 'Tujuan tidak boleh kosong.'
                }
            }
        },
        password: {
            message: 'Password tidak valid',
            validators: {
                notEmpty: {
                    message: 'Password tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/surat/cek_pwd',
                    message: 'Maaf! Password yang anda masukkan salah.',
                    delay: 1000
                }
            }
        }
    }
});

function ds_pelaksana(id) {
    $.ajax({
        url: base_domain + '/surat/get_smasuk/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#ds_pelaksana').modal('show');
                $('#filerd').attr('src', base_path + '/assets/doc/disposisi/' + item['disposisi']);
//                $('#ds_pelaksana').attr('action', base_domain + '/surat/addlaporan?id=' + id + '&method=selesai');
                $('#form_ttd_pelaksana').attr('action', base_domain + '/surat/addlaporan?id=' + id + '&method=selesai');
                $('#form_ds_pelaksana').attr('action', base_domain + '/surat/addlaporan?id=' + id + '&method=selesai');
                $('.modal-titles').text('Lembar Disposisi Pelaksana');
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

$('#form_ttd_pelaksana').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        password: {
            message: 'Password tidak valid',
            validators: {
                notEmpty: {
                    message: 'Password tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/surat/cek_pwd',
                    message: 'Maaf! Password yang anda masukkan salah.',
                    delay: 1000
                }
            }
        }
    }
});

$('#form_add_skeluar').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        nosk: {
            message: 'Nomor surat tidak valid',
            validators: {
                notEmpty: {
                    message: 'Nomor surat tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/surat/cek_skeluar',
                    message: 'Maaf! Nomor surat sudah ada.',
                    delay: 1000
                }
            }
        },
        tssk: {
            message: 'Tanggal surat tidak valid',
            validators: {
                notEmpty: {
                    message: 'Tanggal surat tidak boleh kosong.'
                }
            }
        },
        perihalsk: {
            message: 'perihal tidak valid',
            validators: {
                notEmpty: {
                    message: 'Perihal surat tidak boleh kosong.'
                }
            }
        }
    }
});

function edit_skeluar(id) {
    $.ajax({
        url: base_domain + '/surat/get_skeluar/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#edit_skeluar').modal('show');
                $('#nosk').val(item['no_surat']);
                $('#date4').val(item['tgl_surat']);
                $('#perihalsk').val(item['perihal']);
                $('#tmptjsk').val(item['tempat_tujuan']);
                $('#ketsk').val(item['keterangan']);
                $('#form_edit_skeluar').attr('action', base_domain + '/surat/set_skeluar?id=' + id + '&method=update');
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

function delete_skeluar(id) {
    $('#delete_skeluar').modal('show');
    $('#del_skeluar').html('<a href="' + base_domain + '/surat/set_skeluar?method=delete&id=' + id + '" class="btn btn-danger">Hapus</a>');
    return false;
}

function gen_pdf(id) {
    $.ajax({
        url: base_domain + '/surat/get_skeluar/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $.post(base_domain + '/surat/addlaporan_sk?id=' + id + '&method=add', function (data) {
                    $('#gen_pdf').modal('show');
                });
//                alert('SUCCESS! PDF berhasil dibuat');
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

function ds_adminsk(id) {
    $.ajax({
        url: base_domain + '/surat/get_skeluar/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#ds_adminsk').modal('show');
                $('#filerh').attr('src', base_path + '/assets/doc/skeluar/' + item['surat_keluar']);
                $('.modal-titles').text('Lembar Surat Keluar');
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

function ds_kalaksk(id) {
    $.ajax({
        url: base_domain + '/surat/get_skeluar/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
//                $.post(base_domain + '/surat/addlaporan_sk?id=' + id + '&method=add', function (data) {
                    $('#ds_kalaksk').modal('show');
//                });
                $('.modal-titles').text('Lembar Surat Keluar Kepala Pelaksana');
                $('#fileri').attr('src', base_path + '/assets/doc/skeluar/' + item['surat_keluar']);
                $('#form_ttd_kalaksk').attr('action', base_domain + '/surat/addlaporan_sk?id=' + id + '&method=update');
                $('#form_ds_kalaksk').attr('action', base_domain + '/surat/addlaporan_sk?id=' + id + '&method=update');
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

$('#form_ttd_kalaksk').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        password: {
            message: 'Password tidak valid',
            validators: {
                notEmpty: {
                    message: 'Password tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/surat/cek_pwd',
                    message: 'Maaf! Password yang anda masukkan salah.',
                    delay: 1000
                }
            }
        }
    }
});

function ds_kabagsk(id) {
    $.ajax({
        url: base_domain + '/surat/get_skeluar/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#ds_kabagsk').modal('show');
                $('#filerj').attr('src', base_path + '/assets/doc/skeluar/' + item['surat_keluar']);
                $('#form_ttd_kabagsk').attr('action', base_domain + '/surat/addlaporan_sk?id=' + id + '&method=agree');
                $('#form_ds_kabagsk').attr('action', base_domain + '/surat/addlaporan_sk?id=' + id + '&method=agree');
                $('.modal-titles').text('Lembar Surat Keluar Kepala Bagian');
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

$('#form_ttd_kabagsk').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        tjn_akhirsk: {
            message: 'Tujuan tidak valid',
            validators: {
                notEmpty: {
                    message: 'Tujuan tidak boleh kosong.'
                }
            }
        },
        password: {
            message: 'Password tidak valid',
            validators: {
                notEmpty: {
                    message: 'Password tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/surat/cek_pwd',
                    message: 'Maaf! Password yang anda masukkan salah.',
                    delay: 1000
                }
            }
        }
    }
});

function ds_pelaksanask(id) {
    $.ajax({
        url: base_domain + '/surat/get_skeluar/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#ds_pelaksanask').modal('show');
                $('#filerk').attr('src', base_path + '/assets/doc/skeluar/' + item['surat_keluar']);
                $('#form_ttd_pelaksanask').attr('action', base_domain + '/surat/addlaporan_sk?id=' + id + '&method=selesai');
                $('#form_ds_pelaksanask').attr('action', base_domain + '/surat/addlaporan_sk?id=' + id + '&method=selesai');
                $('.modal-titles').text('Lembar Surat Keluar Pelaksana');
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

$('#form_ttd_pelaksanask').formValidation({
    message: 'This value is not valid',
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        password: {
            message: 'Password tidak valid',
            validators: {
                notEmpty: {
                    message: 'Password tidak boleh kosong.'
                },
                remote: {
                    type: 'POST',
                    url: base_domain + '/surat/cek_pwd',
                    message: 'Maaf! Password yang anda masukkan salah.',
                    delay: 1000
                }
            }
        }
    }
});

function ds_surat_keluar(id) {
    $.ajax({
        url: base_domain + '/surat/get_skeluar/' + id,
        dataType: 'json',
        success: function (response) {
            if (response['status']) {
                var item = response['result'][0];
                $('#ds_surat_keluar').modal('show');
                $('#filez').attr('src', base_path + '/assets/doc/skeluar/' + item['surat_keluar']);
                $('.modal-titles').text('Lembar Surat Keluar');
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