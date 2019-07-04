<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['default_controller'] = 'utama';
$route['404_override'] = '';

//$route['surat'] = 'surat';

$route['buku/create'] = 'apps/app_bencana';
$route['buku/tim'] = 'apps/app_bencana/tim';
$route['buku/jenis'] = 'apps/app_bencana/jenis';
$route['buku/kecamatan'] = 'apps/app_bencana/kecamatan';
$route['buku/desa'] = 'apps/app_bencana/desa';

// Custom module route apps/app_buku
$route['buku/create'] = 'apps/app_buku';
$route['buku/selipkan'] = 'apps/app_buku/selipkan';
$route['buku/search'] = 'apps/app_buku/search';
$route['buku/document/(\d+)'] = 'apps/app_buku/get/$1';
// Custome module apps/pinjma_buku
$route['buku/keluar'] = 'apps/pinjam_buku';
// Custome module apps/pinjma_warkah
$route['warkah/keluar'] = 'apps/pinjam_warkah';
// Custom Routes apps/app_warkah
$route['warkah/search'] = 'apps/app_warkah';
$route['warkah/document/(\d+)'] = 'apps/app_warkah/get/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */