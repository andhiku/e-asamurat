<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('pagination_list')) {

    function pagination_list() {
        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="">';
        $config['num_tag_close'] = '</li>';
        return $config;
    }

}

if (!function_exists('set_permalink')) {

    function set_permalink($content) {
        $karakter = array('{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+', '-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']');
        $hapus_karakter_aneh = strtolower(str_replace($karakter, "", $content));
        $tambah_strip = strtolower(str_replace(' ', '-', $hapus_karakter_aneh));
        return $tambah_strip;
    }

}


//if (!function_exists('file_name')) {
//    function file_name($angka) {
//        switch ($angka) {
//            case 1:
//                $data = 'Buku Tanah';
//                break;
//            case 2:
//                $data = 'Surat Ukur';
//                break;
//            case 3:
//                $data = 'Catatan Buku Tanah';
//                break;
//            default:
//                $data = 'Catatan Buku Tanah';
//                break;
//        }
//        return strtoupper($data);
//    }
//
//}


/*  Trash Helper */
if (!function_exists('trash')) {

    function trash($jenis_delete) {
        switch ($jenis_delete) {
            case 'all':
                $data = 'Buku Tanah';
                break;
            case 'tb_pinjam_buku':
                $data = 'Peminjaman Buku Tanah';
                break;
            case 'tb_pinjam_warkah':
                $data = 'Peminjaman Warkah';
                break;
            default:
                $data = '';
                break;
        }
        return $data;
    }

}

/* Menu active helpers */
if (!function_exists('active_link_controller')) {

    function active_link_controller($controller) {
        $CI = & get_instance();
        $class = $CI->router->fetch_class();
        return ($class == $controller) ? 'active' : NULL;
    }

}


if (!function_exists('active_link_function')) {

    function active_link_function($controller) {
        $CI = & get_instance();
        $class = $CI->router->fetch_method();
        return ($class == $controller) ? 'active' : NULL;
    }

}


if (!function_exists('level_akses')) {

    function level_akses($level) {
        switch ($level) {
            case 'super_admin':
                echo "Programmer";
                break;
            case 'admin':
                echo "Administrator";
                break;
            case 'kalak':
                echo "Kepala Pelaksana";
                break;
            case 'kabag':
                echo "Kepala Bagian";
                break;
            case 'pelaksana':
                echo "Pelaksana";
                break;
            default:
                echo "-";
                break;
        }
    }

}

function tempel($tabel, $hasilcari, $kondisi = null) {
    $res_cari = mysql_query("SELECT $hasilcari FROM $tabel WHERE $kondisi");
    if ($res_cari) {
        if ($row_cari = mysql_fetch_array($res_cari)) {
            return $row_cari[$hasilcari];
        }
    } else {
        return '-- no data result --';
    }
}

function rupiah($nominal) {
    $hasil_rupiah = "Rp. " . number_format($nominal, 0, '.', '.');
    return $hasil_rupiah;
}

function number_format_short($n, $precision = 1) {
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = ' Ribu';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = ' Juta';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = ' Miliar';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = ' Triliun';
    }

    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format . $suffix;
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai) {
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function rph($angka) {
    $hasil_rupiah = "Rp." . number_format($angka, 0, ',-', '.');
    return $hasil_rupiah;
}
