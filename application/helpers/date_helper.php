<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('tgl_pendek_indo')) {

    function tgl_panjang_indo($tgl) {
        date_default_timezone_set('Asia/Makassar');
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }

}

if (!function_exists('tgl_short_indo')) {

    function tgl_short_indo($tgl) {
        date_default_timezone_set('Asia/Makassar');
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = bulan_short($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . '&nbsp;' . $bulan . '&nbsp;' . $tahun;
    }

}

if (!function_exists('bulan_short')) {

    function bulan_short($bln) {
        switch ($bln) {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Aug";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Okt";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Des";
                break;
        }
    }

}

if (!function_exists('tgl_indo')) {

    function tgl_indo($tgl) {
        date_default_timezone_set('Asia/Makassar');
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . '&nbsp;' . $bulan . '&nbsp;' . $tahun;
    }

}

if (!function_exists('bulan')) {

    function bulan($bln) {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

}

if (!function_exists('nama_hari')) {

    function nama_hari($tanggal) {
        date_default_timezone_set('Asia/Makassar');
        $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];

        $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
        $nama_hari = "";
        if ($nama == "Sunday") {
            $nama_hari = "Minggu";
        } else if ($nama == "Monday") {
            $nama_hari = "Senin";
        } else if ($nama == "Tuesday") {
            $nama_hari = "Selasa";
        } else if ($nama == "Wednesday") {
            $nama_hari = "Rabu";
        } else if ($nama == "Thursday") {
            $nama_hari = "Kamis";
        } else if ($nama == "Friday") {
            $nama_hari = "Jumat";
        } else if ($nama == "Saturday") {
            $nama_hari = "Sabtu";
        }
        return $nama_hari;
    }

}

if (!function_exists('hitung_mundur')) {

    function hitung_mundur($wkt) {
        date_default_timezone_set('Asia/Makassar');
        $waktu = array(365 * 24 * 60 * 60 => "tahun",
            30 * 24 * 60 * 60 => "bulan",
            7 * 24 * 60 * 60 => "minggu",
            24 * 60 * 60 => "hari",
            60 * 60 => "jam",
            60 => "menit",
            1 => "detik");

        $hitung = strtotime(gmdate("Y-m-d H:i:s", time() + 60 * 60 * 8)) - $wkt;
        $hasil = array();
        if ($hitung < 5) {
            $hasil = 'kurang dari 5 detik yang lalu';
        } else {
            $stop = 0;
            foreach ($waktu as $periode => $satuan) {
                if ($stop >= 6 || ($stop > 0 && $periode < 60))
                    break;
                $bagi = floor($hitung / $periode);
                if ($bagi > 0) {
                    $hasil[] = $bagi . ' ' . $satuan;
                    $hitung -= $bagi * $periode;
                    $stop++;
                } else if ($stop > 0)
                    $stop++;
            }
            $hasil = implode(' ', $hasil) . ' yang lalu';
        }
        return $hasil;
    }

}

///KONSEP MENGHITUNG SELISIH TANGGAL
function selisih_tanggal($dateline, $kembali) {
    date_default_timezone_set('Asia/Makassar');
    $tgl_dateline = explode('-', $dateline);
    $tgl_dateline = $tgl_dateline[2] . '-' . $tgl_dateline[1] . '-' . $tgl_dateline[0];

    $tgl_kembali = explode('-', $kembali);
    $tgl_kembali = $tgl_kembali[2] . '-' . $tgl_kembali[1] . '-' . $tgl_kembali[0];

    $selisih = strtotime($tgl_kembali) - strtotime($tgl_dateline);
    $selisih = $selisih / 86400;

    if ($selisih >= 1) {
        $hasil = floor($selisih);
    } else {
        $hasil = 0;
    }
    return $hasil;
}

// KONSEP MENGHITUNG SELISIH BULAN
function selisih_bulan($start, $end, $period = "day") {
    $day = 0;
    $month = 0;
    $month_array = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $datestart = strtotime($start);
    $dateend = strtotime($end);
    $month_start = strftime("%m", $datestart);
    $current_year = strftime("%y", $datestart);
    $diff = $dateend - $datestart;
    $date = $diff / (60 * 60 * 24);
    $day = $date;

    $awal = 1;

    while ($date > 0) {
        if ($awal) {
            $loop = $month_start - 1;
            $awal = 0;
        } else {
            $loop = 0;
        }
        for ($i = $loop; $i < 12; $i++) {
            if ($current_year % 4 == 0 && $i == 1)
                $day_of_month = 29;
            else
                $day_of_month = $month_array[$i];

            $date -= $day_of_month;

            if ($date <= 0) {
                if ($date == 0)
                    $month++;
                break;
            }
            $month++;
        }

        $current_year++;
    }
    switch ($period) {
        case "day" : return $day;
            break;
        case "month" : return $month;
            break;
        case "year" : return intval($month / 12);
            break;
    }
}

function bulan_romawi($bln) {
    switch ($bln) {
        case 1:
            return 'I';
            break;
        case 2:
            return 'II';
            break;
        case 3:
            return 'III';
            break;
        case 4:
            return 'IV';
            break;
        case 5:
            return 'V';
            break;
        case 6:
            return 'VI';
            break;
        case 7:
            return 'VII';
            break;
        case 8:
            return 'VIII';
            break;
        case 9:
            return 'IX';
            break;
        case 10:
            return 'X';
            break;
        case 11:
            return 'XI';
            break;
        case 12:
            return 'XII';
            break;
    }
}

?>