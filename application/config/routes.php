<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'beranda';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['init/generate'] = 'init/Generate';
$route['init/rollback'] = 'init/Generate/rollback';
$route['init/patch1'] = 'init/Generate/patch1';
$route['init/patch2'] = 'init/Generate/patch2';
$route['init/patch3'] = 'init/Generate/patch3';
$route['init/patch4'] = 'init/Generate/patch4';

/* Backend Routes */
$route['login'] = 'auth/index';
$route['logout'] = 'auth/logout';
$route['(:any)/twofatoken'] = 'auth/twofatoken/$1';
$route['token'] = 'auth/token';
$route['ilhamtanibot/produk'] = 'ilhamtanibot/produk';
$route['PTAMbot/(:any)/(:any)/(:any)/satpam_ptam_status'] = 'PTAMbot/satpam_ptam_status/$1/$2/$3/';
$route['PTAMbot/(:any)/(:any)/satpam_ptam_enginer'] = 'PTAMbot/satpam_ptam_enginer/$1/$2/';


//BLIP SALES
$route['blip'] = 'blip';

//WHATSAPP API
$route['manage/api/whatsapp'] = 'backend/Api/whatsapp';

//PRTG MONITORING
//$route['singleconn/(:any)/(:any)/(:any)/prtg'] = 'backend/singleconn/prtg/$1/$2/$3';
$route['singleconn/prtg'] = 'backend/singleconn/prtg';

//DIRECT message Telegram NOC
$route['blip_monitor/'] = 'blip_monitor';
$route['blip_monitor/(:any)/get_status'] = 'blip_monitor/get_status/$1';
$route['blip_monitor/(:any)/fo_onnet_mtr'] = 'blip_monitor/fo_onnet_mtr/$1';
$route['blip_monitor/(:any)/fo_onnet_pmg'] = 'blip_monitor/fo_onnet_pmg/$1';
$route['blip_monitor/(:any)/(:any)/we_check'] = 'blip_monitor/we_check/$1/$2';
$route['blip_monitor/(:any)/fo_raisecom_check_ntb'] = 'blip_monitor/fo_raisecom_check_ntb/$1';
$route['blip_monitor/(:any)/fo_raisecom_check_teknis'] = 'blip_monitor/fo_raisecom_check_teknis/$1';
$route['blip_monitor/(:any)/(:any)/(:any)/mondevices'] = 'blip_monitor/mondevices/$1/$2/$3';
$route['blip_monitor/dailyreport'] = 'blip_monitor/dailyreport';


//SPECIAL TOOLS
$route['specialtools/bypass'] = 'specialtools/bypass';
$route['specialtools/bypass_simpan'] = 'specialtools/bypass_simpan/';

$route['manage'] = 'backend/Dashboard';
$route['manage/pwd_encrypt'] = 'backend/Dashboard/pwd_encrypt';
$route['manage/temp/(:num)/bw_info'] = 'backend/Temp/bw_info/$1';

//BLiP ADMIN - Media Access
$route['manage/media'] = 'backend/Media';
$route['manage/media/tambah'] = 'backend/Media/tambah';
$route['manage/media/simpan'] = 'backend/Media/simpan';
$route['manage/media/(:num)/ubah'] = 'backend/Media/ubah/$1';
$route['manage/media/(:num)/timpa'] = 'backend/Media/timpa/$1';
$route['manage/media/(:num)/hapus'] = 'backend/Media/hapus/$1';
//BLiP ADMIN - Mitra
$route['manage/mitra'] = 'backend/Mitra';
$route['manage/mitra/tambah'] = 'backend/Mitra/tambah';
$route['manage/mitra/simpan'] = 'backend/Mitra/simpan';
$route['manage/mitra/(:num)/ubah'] = 'backend/Mitra/ubah/$1';
$route['manage/mitra/(:num)/timpa'] = 'backend/Mitra/timpa/$1';
$route['manage/mitra/(:num)/hapus'] = 'backend/Mitra/hapus/$1';
//BLiP ADMIN - KPI ROOT DATA
$route['manage/kpi_induk'] = 'backend/Kpi_induk';
$route['manage/kpi_induk/tambah'] = 'backend/Kpi_induk/tambah';
$route['manage/kpi_induk/simpan'] = 'backend/Kpi_induk/simpan';
$route['manage/kpi_induk/(:num)/ubah'] = 'backend/Kpi_induk/ubah/$1';
$route['manage/kpi_induk/(:num)/timpa'] = 'backend/Kpi_induk/timpa/$1';
$route['manage/kpi_induk/(:num)/hapus'] = 'backend/Kpi_induk/hapus/$1';
//BLiP ADMIN - KPI
$route['manage/kpi'] = 'backend/Kpi';
$route['manage/kpi/tambah'] = 'backend/Kpi/tambah';
$route['manage/kpi/simpan'] = 'backend/Kpi/simpan';
$route['manage/kpi/(:num)/ubah'] = 'backend/Kpi/ubah/$1';
$route['manage/kpi/(:num)/timpa'] = 'backend/Kpi/timpa/$1';
$route['manage/kpi/(:num)/hapus'] = 'backend/Kpi/hapus/$1';
//BLiP ADMIN - PRODUK
$route['manage/produk'] = 'backend/Produk';
$route['manage/produk/tambah'] = 'backend/Produk/tambah';
$route['manage/produk/simpan'] = 'backend/Produk/simpan';
$route['manage/produk/(:num)/ubah'] = 'backend/Produk/ubah/$1';
$route['manage/produk/(:num)/timpa'] = 'backend/Produk/timpa/$1';
$route['manage/produk/(:num)/hapus'] = 'backend/Produk/hapus/$1';
//BLiP ADMIN - BAD DEBT
$route['manage/baddebt'] = 'backend/Produk';
$route['manage/baddebt/tambah'] = 'backend/Baddebt/tambah';
$route['manage/baddebt/simpan'] = 'backend/Baddebt/simpan';
$route['manage/baddebt/(:num)/ubah'] = 'backend/Baddebt/ubah/$1';
$route['manage/baddebt/(:num)/timpa'] = 'backend/Baddebt/timpa/$1';
$route['manage/baddebt/(:num)/hapus'] = 'backend/Baddebt/hapus/$1';
//BLiP ADMIN - WO
$route['manage/wo'] = 'backend/Wo';
$route['manage/wo/get_pelanggan'] = 'backend/Wo/get_pelanggan';
$route['manage/wo/tambah'] = 'backend/Wo/tambah';
$route['manage/wo/simpan'] = 'backend/Wo/simpan';
$route['manage/wo/(:num)'] = 'backend/Wo/detail/$1';
$route['manage/wo/(:num)/ubah'] = 'backend/Wo/ubah/$1';
$route['manage/wo/(:num)/timpa'] = 'backend/Wo/timpa/$1';
$route['manage/wo/(:num)/hapus'] = 'backend/Wo/hapus/$1';
$route['manage/wo/(:num)/batalkan'] = 'backend/Wo/batalkan/$1';
$route['manage/wo/(:num)/selesaikan'] = 'backend/Wo/selesaikan/$1';
$route['manage/wo/(:num)/existing'] = 'backend/Wo/existing/$1';
$route['manage/wo/(:num)/survey'] = 'backend/Wo/survey/$1';
$route['manage/wo/wo_reminder'] = 'backend/Wo/wo_reminder';
$route['manage/wo/export'] = 'backend/Wo/export';
//BLiP ADMIN - SALES
$route['manage/sales'] = 'backend/Sales';
$route['manage/sales/tambah'] = 'backend/Sales/tambah';
$route['manage/sales/simpan'] = 'backend/Sales/simpan';
$route['manage/sales/(:num)/ubah'] = 'backend/Sales/ubah/$1';
$route['manage/sales/(:num)/timpa'] = 'backend/Sales/timpa/$1';
$route['manage/sales/(:num)/hapus'] = 'backend/Sales/hapus/$1';
//BLiP ADMIN - LEVEL PRIORITAS
$route['manage/level_prioritas'] = 'backend/Level_prioritas';
$route['manage/level_prioritas/tambah'] = 'backend/Level_prioritas/tambah';
$route['manage/level_prioritas/simpan'] = 'backend/Level_prioritas/simpan';
$route['manage/level_prioritas/(:num)/ubah'] = 'backend/Level_prioritas/ubah/$1';
$route['manage/level_prioritas/(:num)/timpa'] = 'backend/Level_prioritas/timpa/$1';
$route['manage/level_prioritas/(:num)/hapus'] = 'backend/Level_prioritas/hapus/$1';
//BLiP Teknis - Lastmile Mitra
$route['manage/lastmile_mitra'] = 'backend/Lastmile_mitra';
$route['manage/lastmile_mitra/tambah'] = 'backend/Lastmile_mitra/tambah';
$route['manage/lastmile_mitra/simpan'] = 'backend/Lastmile_mitra/simpan';
$route['manage/lastmile_mitra/(:num)/ubah'] = 'backend/Lastmile_mitra/ubah/$1';
$route['manage/lastmile_mitra/(:num)/timpa'] = 'backend/Lastmile_mitra/timpa/$1';
$route['manage/lastmile_mitra/(:num)/hapus'] = 'backend/Lastmile_mitra/hapus/$1';
//BLiP Teknis - VAS Spec
$route['manage/vas_spec'] = 'backend/Vas_spec';
$route['manage/vas_spec/tambah'] = 'backend/Vas_spec/tambah';
$route['manage/vas_spec/simpan'] = 'backend/Vas_spec/simpan';
$route['manage/vas_spec/(:num)/ubah'] = 'backend/Vas_spec/ubah/$1';
$route['manage/vas_spec/(:num)/timpa'] = 'backend/Vas_spec/timpa/$1';
$route['manage/vas_spec/(:num)/hapus'] = 'backend/Vas_spec/hapus/$1';
//BLiP Teknis - VAS Data
$route['manage/vas_data'] = 'backend/Vas_data';
$route['manage/vas_data/tambah'] = 'backend/Vas_data/tambah';
$route['manage/vas_data/simpan'] = 'backend/Vas_data/simpan';
$route['manage/vas_data/(:num)/ubah'] = 'backend/Vas_data/ubah/$1';
$route['manage/vas_data/(:num)/timpa'] = 'backend/Vas_data/timpa/$1';
$route['manage/vas_data/(:num)/hapus'] = 'backend/Vas_data/hapus/$1';
$route['manage/vas_data/export'] = 'backend/vas_data/export';
//BLiP Teknis - SPK
$route['manage/spk'] = 'backend/Spk';
$route['manage/spk/tambah'] = 'backend/Spk/tambah';
$route['manage/spk/simpan'] = 'backend/Spk/simpan';
$route['manage/spk/(:num)/ubah'] = 'backend/Spk/ubah/$1';
$route['manage/spk/(:num)/timpa'] = 'backend/Spk/timpa/$1';
$route['manage/spk/(:num)/hapus'] = 'backend/Spk/hapus/$1';
$route['manage/spk/(:any)/konfirmasi'] = 'backend/Spk/konfirmasi/$1';
$route['manage/spk/(:any)/(:any)/whatsapp'] = 'backend/Spk/whatsapp/$1/$2';
$route['manage/spk/konfirmasi_simpan'] = 'backend/Spk/Konfirmasi_simpan';
$route['manage/spk/export'] = 'backend/Spk/export';
//BLiP Teknis - WO Khusus By Admin
$route['manage/wo_khusus_admin'] = 'backend/Wo_khusus_admin';
$route['manage/wo_khusus_admin/tambah'] = 'backend/Wo_khusus_admin/tambah';
$route['manage/wo_khusus_admin/simpan'] = 'backend/Wo_khusus_admin/simpan';
$route['manage/wo_khusus_admin/(:num)/ubah'] = 'backend/Wo_khusus_admin/ubah/$1';
$route['manage/wo_khusus_admin/(:num)/timpa'] = 'backend/Wo_khusus_admin/timpa/$1';
$route['manage/wo_khusus_admin/(:num)/hapus'] = 'backend/Wo_khusus_admin/hapus/$1';
$route['manage/wo_khusus_admin/export'] = 'backend/Wo_khusus_admin/export';
//BLiP Teknis - WO Khusus By NOC
$route['manage/wo_khusus_noc'] = 'backend/Wo_khusus_noc';
$route['manage/wo_khusus_noc/tambah'] = 'backend/Wo_khusus_noc/tambah';
$route['manage/wo_khusus_noc/simpan'] = 'backend/Wo_khusus_noc/simpan';
$route['manage/wo_khusus_noc/(:num)/ubah'] = 'backend/Wo_khusus_noc/ubah/$1';
$route['manage/wo_khusus_noc/(:num)/timpa'] = 'backend/Wo_khusus_noc/timpa/$1';
$route['manage/wo_khusus_noc/(:num)/hapus'] = 'backend/Wo_khusus_noc/hapus/$1';
$route['manage/wo_khusus_noc/get_noc_maintenance'] = 'backend/Wo_khusus_noc/get_noc_maintenance';
$route['manage/wo_khusus_noc/export'] = 'backend/Wo_khusus_noc/export';

//BLiP ALL
$route['manage/data_pelanggan'] = 'backend/Data_pelanggan';
$route['manage/data_pelanggan/modifikasi'] = 'backend/Data_pelanggan/modifikasi';
$route['manage/data_pelanggan/(:num)'] = 'backend/Data_pelanggan/detil/$1';
$route['manage/data_pelanggan/tambah'] = 'backend/Data_pelanggan/tambah';
$route['manage/data_pelanggan/simpan'] = 'backend/Data_pelanggan/simpan';
$route['manage/data_pelanggan/(:num)/ubah'] = 'backend/Data_pelanggan/ubah/$1';
$route['manage/data_pelanggan/(:num)/timpa'] = 'backend/Data_pelanggan/timpa/$1';
$route['manage/data_pelanggan/(:num)/hapus'] = 'backend/Data_pelanggan/hapus/$1';
$route['manage/data_pelanggan/migrasi'] = 'backend/Data_pelanggan/migrasi';
$route['manage/data_pelanggan/(:num)/layanan_tambah'] = 'backend/Data_pelanggan/layanan_tambah/$1';
$route['manage/data_pelanggan/layanan_simpan'] = 'backend/Data_pelanggan/layanan_simpan';
$route['manage/data_pelanggan/(:num)/(:num)/layanan_ubah'] = 'backend/Data_pelanggan/layanan_ubah/$1/$2';
$route['manage/data_pelanggan/(:num)/layanan_timpa'] = 'backend/Data_pelanggan/layanan_timpa/$1';
$route['manage/data_pelanggan/(:num)/layanan_hapus'] = 'backend/Data_pelanggan/layanan_hapus/$1';
$route['manage/data_pelanggan/export'] = 'backend/Data_pelanggan/export';
$route['manage/data_pelanggan/(:num)/(:num)/whatsapp'] = 'backend/Data_pelanggan/whatsapp/$1/$2';
$route['manage/data_pelanggan/(:num)/(:num)/telegram'] = 'backend/Data_pelanggan/telegram/$1/$2';
//BLiP Teknis - OLT Provisioning
$route['manage/olt'] = 'backend/Olt';
$route['manage/olt/tambah'] = 'backend/Olt/tambah';
$route['manage/olt/simpan'] = 'backend/Olt/simpan';
$route['manage/olt/(:num)/ubah'] = 'backend/Olt/ubah/$1';
$route['manage/olt/(:num)/timpa'] = 'backend/Olt/timpa/$1';
$route['manage/olt/(:num)/hapus'] = 'backend/Olt/hapus/$1';
//BLiP Teknis - OLT Provisioning
$route['manage/onu'] = 'backend/Onu';
$route['manage/(:any)/onu'] = 'backend/Onu/$1';
$route['manage/onu/(:num)/detail'] = 'backend/Onu/detail/$1';
$route['manage/onu/tambah'] = 'backend/Onu/tambah';
$route['manage/onu/simpan'] = 'backend/Onu/simpan';
$route['manage/onu/(:num)/ubah'] = 'backend/Onu/ubah/$1';
$route['manage/onu/(:num)/timpa'] = 'backend/Onu/timpa/$1';
$route['manage/onu/(:num)/hapus'] = 'backend/Onu/hapus/$1';
$route['manage/onu/(:num)/generate'] = 'backend/Onu/generate/$1';
$route['manage/onu/(:num)/unconfig'] = 'backend/Onu/unconfig/$1';
$route['manage/onu/(:num)/onu_profile'] = 'backend/Onu/onu_profile/$1';
$route['manage/onu/(:num)/onu_pon'] = 'backend/Onu/onu_pon/$1';
$route['manage/onu/(:num)/onu_detail_log'] = 'backend/Onu/onu_detail_log/$1';
$route['manage/onu/(:num)/onu_reboot'] = 'backend/Onu/onu_reboot/$1';
$route['manage/onu/(:num)/redaman'] = 'backend/Onu/redaman/$1';
$route['manage/onu/refresh_redaman'] = 'backend/Onu/refresh_redaman';
$route['manage/onu/grab_onu_all'] = 'backend/Onu/grab_onu_all';
$route['manage/onu/grab_onu'] = 'backend/Onu/grab_onu';
$route['manage/onu/remove_mon_onu'] = 'backend/Onu/remove_mon_onu';
$route['manage/onu/remove_xcek_onu'] = 'backend/Onu/remove_xcek_onu';
$route['manage/onu/export'] = 'backend/Onu/export';
$route['manage/onu/report_onu_mtr'] = 'backend/Onu/report_onu_mtr';
$route['manage/onu/report_onu_pmg'] = 'backend/Onu/report_onu_pmg';
$route['manage/onu/set_redaman'] = 'backend/Onu/set_redaman';
$route['manage/onu/(:num)/(:any)/(:any)/onu_port'] = 'backend/Onu/onu_port/$1/$2/$3';
$route['manage/onu/do_filter'] = 'backend/Onu/do_filter/';
$route['manage/onu/do_scan_sn'] = 'backend/Onu/do_scan_sn/';
$route['manage/onu/(:num)/onu_test'] = 'backend/Onu/onu_test/$1/';


//BLiP Teknis - Firewall Filter
$route['manage/firewall_filter'] = 'backend/Firewall_filter';
$route['manage/firewall_filter/(:num)/import'] = 'backend/Firewall_filter/import/$1';
$route['manage/firewall_filter/export'] = 'backend/Firewall_filter/export';
$route['manage/firewall_filter/syncdata'] = 'backend/Firewall_filter/syncdata';
$route['manage/firewall_filter/(:num)/hapus'] = 'backend/Firewall_filter/hapus/$1';
$route['manage/firewall_filter/torch_ix'] = 'backend/Firewall_filter/torch_ix';
$route['manage/firewall_filter/torch_iix'] = 'backend/Firewall_filter/torch_iix';
$route['manage/firewall_filter/torch_content'] = 'backend/Firewall_filter/torch_content';
$route['manage/firewall_filter/index_ix'] = 'backend/Firewall_filter/index_ix';
$route['manage/firewall_filter/index_iix'] = 'backend/Firewall_filter/index_iix';
$route['manage/firewall_filter/index_content'] = 'backend/Firewall_filter/index_content';
$route['manage/firewall_filter/syncdata_ix'] = 'backend/Firewall_filter/syncdata_ix';
$route['manage/firewall_filter/syncdata_iix'] = 'backend/Firewall_filter/syncdata_iix';
$route['manage/firewall_filter/syncdata_content'] = 'backend/Firewall_filter/syncdata_content';
$route['manage/firewall_filter/bar_chart'] = 'backend/Firewall_filter/bar_chart';
$route['manage/firewall_filter/charttest'] = 'backend/Firewall_filter/charttest';

//BLiP Teknis - Tiket Case
$route['manage/noc_tiket_case'] = 'backend/Noc_tiket_case';
$route['manage/noc_tiket_case/tambah'] = 'backend/Noc_tiket_case/tambah';
$route['manage/noc_tiket_case/simpan'] = 'backend/Noc_tiket_case/simpan';
$route['manage/noc_tiket_case/(:num)/ubah'] = 'backend/Noc_tiket_case/ubah/$1';
$route['manage/noc_tiket_case/(:num)/timpa'] = 'backend/Noc_tiket_case/timpa/$1';
$route['manage/noc_tiket_case/(:num)/hapus'] = 'backend/Noc_tiket_case/hapus/$1';

//BLiP Teknis - Tiket Case Klasifikasi
$route['manage/noc_tiket_case_klasifikasi'] = 'backend/Noc_tiket_case_klasifikasi';
$route['manage/noc_tiket_case_klasifikasi/tambah'] = 'backend/Noc_tiket_case_klasifikasi/tambah';
$route['manage/noc_tiket_case_klasifikasi/simpan'] = 'backend/Noc_tiket_case_klasifikasi/simpan';
$route['manage/noc_tiket_case_klasifikasi/(:num)/ubah'] = 'backend/Noc_tiket_case_klasifikasi/ubah/$1';
$route['manage/noc_tiket_case_klasifikasi/(:num)/timpa'] = 'backend/Noc_tiket_case_klasifikasi/timpa/$1';
$route['manage/noc_tiket_case_klasifikasi/(:num)/hapus'] = 'backend/Noc_tiket_case_klasifikasi/hapus/$1';

//BLiP Teknis - Tiket Case Sub Klasifikasi
$route['manage/noc_tiket_case_subklasifikasi'] = 'backend/Noc_tiket_case_subklasifikasi';
$route['manage/noc_tiket_case_subklasifikasi/tambah'] = 'backend/Noc_tiket_case_subklasifikasi/tambah';
$route['manage/noc_tiket_case_subklasifikasi/simpan'] = 'backend/Noc_tiket_case_subklasifikasi/simpan';
$route['manage/noc_tiket_case_subklasifikasi/(:num)/ubah'] = 'backend/Noc_tiket_case_subklasifikasi/ubah/$1';
$route['manage/noc_tiket_case_subklasifikasi/(:num)/timpa'] = 'backend/Noc_tiket_case_subklasifikasi/timpa/$1';
$route['manage/noc_tiket_case_subklasifikasi/(:num)/hapus'] = 'backend/Noc_tiket_case_subklasifikasi/hapus/$1';

//BLiP Teknis - Tiket NOC IP CORE
$route['manage/noc_tiket_noc_ipcore'] = 'backend/Noc_tiket_noc_ipcore';
$route['manage/noc_tiket_noc_ipcore/tambah'] = 'backend/Noc_tiket_noc_ipcore/tambah';
$route['manage/noc_tiket_noc_ipcore/simpan'] = 'backend/Noc_tiket_noc_ipcore/simpan';
$route['manage/noc_tiket_noc_ipcore/(:num)/ubah'] = 'backend/Noc_tiket_noc_ipcore/ubah/$1';
$route['manage/noc_tiket_noc_ipcore/(:num)/timpa'] = 'backend/Noc_tiket_noc_ipcore/timpa/$1';
$route['manage/noc_tiket_noc_ipcore/(:num)/hapus'] = 'backend/Noc_tiket_noc_ipcore/hapus/$1';

//BLiP Teknis - Tiket NOC HD
$route['manage/noc_tiket_noc_hd'] = 'backend/Noc_tiket_noc_hd';
$route['manage/noc_tiket_noc_hd/tambah'] = 'backend/Noc_tiket_noc_hd/tambah';
$route['manage/noc_tiket_noc_hd/simpan'] = 'backend/Noc_tiket_noc_hd/simpan';
$route['manage/noc_tiket_noc_hd/(:num)/ubah'] = 'backend/Noc_tiket_noc_hd/ubah/$1';
$route['manage/noc_tiket_noc_hd/(:num)/timpa'] = 'backend/Noc_tiket_noc_hd/timpa/$1';
$route['manage/noc_tiket_noc_hd/(:num)/hapus'] = 'backend/Noc_tiket_noc_hd/hapus/$1';

//BLiP Teknis - Tiket Eskalasi
$route['manage/noc_tiket_eskalasi'] = 'backend/Noc_tiket_eskalasi';
$route['manage/noc_tiket_eskalasi/tambah'] = 'backend/Noc_tiket_eskalasi/tambah';
$route['manage/noc_tiket_eskalasi/simpan'] = 'backend/Noc_tiket_eskalasi/simpan';
$route['manage/noc_tiket_eskalasi/(:num)/ubah'] = 'backend/Noc_tiket_eskalasi/ubah/$1';
$route['manage/noc_tiket_eskalasi/(:num)/timpa'] = 'backend/Noc_tiket_eskalasi/timpa/$1';
$route['manage/noc_tiket_eskalasi/(:num)/hapus'] = 'backend/Noc_tiket_eskalasi/hapus/$1';

//BLiP Teknis - Tiket List
$route['manage/noc_tiket_list'] = 'backend/Noc_tiket_list';
$route['manage/noc_tiket_list/(:any)/detil'] = 'backend/Noc_tiket_list/detil/$1';
$route['manage/noc_tiket_list/tambah'] = 'backend/Noc_tiket_list/tambah';
$route['manage/noc_tiket_list/simpan'] = 'backend/Noc_tiket_list/simpan';
$route['manage/noc_tiket_list/import'] = 'backend/Noc_tiket_list/import';
$route['manage/noc_tiket_list/export_pdf'] = 'backend/Noc_tiket_list/export_pdf';
$route['manage/noc_tiket_list/export_xls'] = 'backend/Noc_tiket_list/export_xls';
$route['manage/noc_tiket_list/simpan_import'] = 'backend/Noc_tiket_list/simpan_import';
$route['manage/noc_tiket_list/(:num)/ubah'] = 'backend/Noc_tiket_list/ubah/$1';
$route['manage/noc_tiket_list/(:num)/timpa'] = 'backend/Noc_tiket_list/timpa/$1';
$route['manage/noc_tiket_list/(:num)/hapus'] = 'backend/Noc_tiket_list/hapus/$1';
$route['manage/noc_tiket_list/kirim_report'] = 'backend/Noc_tiket_list/kirim_report';
$route['manage/noc_tiket_list/do_filter'] = 'backend/Noc_tiket_list/do_filter/';


$route['manage/router'] = 'backend/Router';
$route['manage/router/(:num)'] = 'backend/Router/detil/$1';
$route['manage/router/tambah_fo_onnet'] = 'backend/Router/tambah_fo_onnet';
$route['manage/router/tambah_fo_cgs'] = 'backend/Router/tambah_fo_cgs';
$route['manage/router/tambah_fo_telkom'] = 'backend/Router/tambah_fo_telkom';
$route['manage/router/tambah_fo_icon'] = 'backend/Router/tambah_fo_icon';
$route['manage/router/tambah_fo_mitra'] = 'backend/Router/tambah_fo_mitra';

$route['manage/router/(:any)/tambah_fo_onnet'] = 'backend/Router/tambah_fo_onnet/$1';
$route['manage/router/(:any)/tambah_fo_cgs'] = 'backend/Router/tambah_fo_cgs/$1';
$route['manage/router/(:any)/tambah_fo_telkom'] = 'backend/Router/tambah_fo_telkom/$1';
$route['manage/router/(:any)/tambah_fo_icon'] = 'backend/Router/tambah_fo_icon/$1';
$route['manage/router/(:any)/tambah_fo_mitra'] = 'backend/Router/tambah_fo_mitra/$1';

$route['manage/router/tambah_we'] = 'backend/Router/tambah_we';
$route['manage/router/(:any)/tambah_we'] = 'backend/Router/tambah_we/$1';
$route['manage/router/tambah_temporer'] = 'backend/Router/tambah_temporer';
$route['manage/router/simpan'] = 'backend/Router/simpan';
$route['manage/router/(:num)/ubah'] = 'backend/Router/ubah/$1';
$route['manage/router/(:num)/timpa'] = 'backend/Router/timpa/$1';
$route['manage/router/(:num)/hapus'] = 'backend/Router/hapus/$1';
$route['manage/router/(:num)/hotspot/(:any)'] = 'backend/Router/hotspot/$1/$1';
$route['manage/router/(:num)/restart'] = 'backend/Router/restart/$1';
$route['manage/router/(:num)/backup'] = 'backend/Router/backup/$1';

$route['manage/distribusi'] = 'backend/Distribusi';
$route['manage/distribusi/tambah'] = 'backend/Distribusi/tambah';
$route['manage/distribusi/simpan'] = 'backend/Distribusi/simpan';
$route['manage/distribusi/(:num)/ubah'] = 'backend/Distribusi/ubah/$1';
$route['manage/distribusi/(:num)/timpa'] = 'backend/Distribusi/timpa/$1';
$route['manage/distribusi/(:num)/hapus'] = 'backend/Distribusi/hapus/$1';

$route['manage/TE'] = 'backend/TE';
$route['manage/TE/tambah'] = 'backend/TE/tambah';
$route['manage/TE/simpan'] = 'backend/TE/simpan';
$route['manage/TE/(:num)/ubah'] = 'backend/TE/ubah/$1';
$route['manage/TE/(:num)/timpa'] = 'backend/TE/timpa/$1';
$route['manage/TE/(:num)/hapus'] = 'backend/TE/hapus/$1';


$route['manage/server'] = 'backend/Server';
$route['manage/server/(:num)'] = 'backend/Server/detil/$1';
$route['manage/server/tambah'] = 'backend/Server/tambah';
$route['manage/server/simpan'] = 'backend/Server/simpan';
$route['manage/server/(:num)/ubah'] = 'backend/Server/ubah/$1';
$route['manage/server/(:num)/timpa'] = 'backend/Server/timpa/$1';
$route['manage/server/(:num)/hapus'] = 'backend/Server/hapus/$1';

$route['manage/bts'] = 'backend/Bts';
$route['manage/bts/(:num)'] = 'backend/Bts/detil/$1';
$route['manage/bts/tambah'] = 'backend/Bts/tambah';
$route['manage/bts/simpan'] = 'backend/Bts/simpan';
$route['manage/bts/maintenance'] = 'backend/Bts/maintenance';
$route['manage/bts/maintenance_result'] = 'backend/Bts/maintenance_result';
$route['manage/bts/reload'] = 'backend/Bts/reload';
$route['manage/bts/(:num)/ubah'] = 'backend/Bts/ubah/$1';
$route['manage/bts/(:num)/timpa'] = 'backend/Bts/timpa/$1';
$route['manage/bts/(:num)/hapus'] = 'backend/Bts/hapus/$1';
$route['manage/bts/export'] = 'backend/Bts/export';
$route['manage/bts/backup'] = 'backend/Bts/backup';

$route['manage/station'] = 'backend/Station';
$route['manage/station/tambah'] = 'backend/Station/tambah';
$route['manage/station/simpan'] = 'backend/Station/simpan';
$route['manage/station/(:num)/hapus'] = 'backend/Station/hapus/$1';
$route['manage/station/(:num)/backup'] = 'backend/Station/backup/$1';
$route['manage/station/station'] = 'backend/Station/station';
$route['manage/station/export_xls'] = 'backend/Station/export_xls';
$route['manage/station/export_pdf'] = 'backend/Station/export_pdf';
$route['manage/station/reloadall'] = 'backend/Station/reloadall';
$route['manage/station/(:num)/refresh'] = 'backend/Station/refresh/$1';
$route['manage/station/kirim_report'] = 'backend/Station/kirim_report';

$route['manage/mapping'] = 'backend/Mapping';
$route['manage/mapping/tambah'] = 'backend/Mapping/tambah';
$route['manage/mapping/simpan'] = 'backend/Mapping/simpan';
$route['manage/mapping/import'] = 'backend/Mapping/import';
$route['manage/mapping/simpan_import'] = 'backend/Mapping/simpan_import';
$route['manage/mapping/hasil_mapping'] = 'backend/Mapping/hasil_mapping';
$route['manage/mapping/result'] = 'backend/Mapping/result';
$route['manage/mapping/export'] = 'backend/Mapping/export';
$route['manage/mapping/delete_site_bali'] = 'backend/Mapping/delete_site_bali';
$route['manage/mapping/(:num)/result_hapus'] = 'backend/Mapping/result_hapus/$1';
$route['manage/mapping/hasil_test'] = 'backend/Mapping/hasil_test';
$route['manage/mapping/(:num)/ubah'] = 'backend/Mapping/ubah/$1';
$route['manage/mapping/(:num)/timpa'] = 'backend/Mapping/timpa/$1';
$route['manage/mapping/(:num)/hapus'] = 'backend/Mapping/hapus/$1';
$route['manage/mapping/maps'] = 'backend/Mapping/maps';
$route['manage/mapping/refresh_pelanggan'] = 'backend/Mapping/refresh_pelanggan';

$route['manage/lokalan'] = 'backend/Lokalan';
$route['manage/lokalan/(:num)'] = 'backend/Lokalan/detil/$1';
$route['manage/lokalan/tambah'] = 'backend/Lokalan/tambah';
$route['manage/lokalan/simpan'] = 'backend/Lokalan/simpan';
$route['manage/lokalan/(:num)/ubah'] = 'backend/Lokalan/ubah/$1';
$route['manage/lokalan/(:num)/timpa'] = 'backend/Lokalan/timpa/$1';
$route['manage/lokalan/(:num)/hapus'] = 'backend/Lokalan/hapus/$1';




$route['manage/scheduler'] = 'backend/Scheduler';
$route['manage/scheduler/(:num)'] = 'backend/Scheduler/detil/$1';
$route['manage/scheduler/tambah_a'] = 'backend/Scheduler/tambah_a';
$route['manage/scheduler/tambah_b'] = 'backend/Scheduler/tambah_b';
$route['manage/scheduler/tambah_c'] = 'backend/Scheduler/tambah_c';
$route['manage/scheduler/tambah_d'] = 'backend/Scheduler/tambah_d';
$route['manage/scheduler/tambah_e'] = 'backend/Scheduler/tambah_e';
$route['manage/scheduler/tambah_f'] = 'backend/Scheduler/tambah_f';
$route['manage/scheduler/tambah_g'] = 'backend/Scheduler/tambah_g';
$route['manage/scheduler/tambah_h'] = 'backend/Scheduler/tambah_h';
$route['manage/scheduler/simpan'] = 'backend/Scheduler/simpan';
$route['manage/scheduler/(:num)/ubah'] = 'backend/Scheduler/ubah/$1';
$route['manage/scheduler/(:num)/timpa'] = 'backend/Scheduler/timpa/$1';
$route['manage/scheduler/(:num)/hapus'] = 'backend/Scheduler/hapus/$1';
$route['manage/scheduler/fetch_layanan'] = 'backend/Scheduler/fetch_layanan/';


$route['manage/operator'] = 'backend/Operator';
$route['manage/operator/(:num)'] = 'backend/Operator/detil/$1';
$route['manage/operator/tambah'] = 'backend/Operator/tambah';
$route['manage/operator/simpan'] = 'backend/Operator/simpan';
$route['manage/operator/(:num)/ubah'] = 'backend/Operator/ubah/$1';
$route['manage/operator/(:num)/timpa'] = 'backend/Operator/timpa/$1';
$route['manage/operator/(:num)/hapus'] = 'backend/Operator/hapus/$1';
$route['manage/operator/gantipwd'] = 'backend/Operator/gantipwd';
$route['manage/operator/prosespwd'] = 'backend/Operator/prosespwd/';

$route['manage/profil'] = 'backend/Profil';

$route['fiberstream'] = 'auth/fiberstream';
$route['logout_fiberstream'] = 'auth/logout_fiberstream';
$route['manage/fiberstream'] = 'backend/Fiberstream';
$route['manage/fiberstream/cust'] = 'backend/Fiberstream/Cust';
$route['manage/fiberstream/tambah'] = 'backend/Fiberstream/Tambah';
$route['manage/fiberstream/result'] = 'backend/Fiberstream/Result';
$route['manage/fiberstream/simpan_invoice'] = 'backend/Fiberstream/simpan_invoice';
$route['manage/fiberstream/simpan_resi'] = 'backend/Fiberstream/simpan_resi';
$route['manage/fiberstream/bcinvoice'] = 'backend/Fiberstream/bcinvoice';
$route['manage/fiberstream/bcschedule'] = 'backend/Fiberstream/bcschedule';

$route['manage/fiberstream/(:any)/(:any)/approve'] = 'backend/Fiberstream/approve/$1/$2';
$route['manage/fiberstream/(:any)/(:any)/isolir'] = 'backend/Fiberstream/isolir/$1/$2';
$route['manage/fiberstream/(:any)/approve_tg'] = 'backend/Fiberstream/approve_tg/$1';
$route['manage/fiberstream/(:any)/isolir_tg'] = 'backend/Fiberstream/isolir_tg/$1';
$route['manage/fiberstream/(:any)/abort'] = 'backend/Fiberstream/abort/$1';
$route['manage/fiberstream/(:any)/reject'] = 'backend/Fiberstream/reject/$1';
$route['manage/fiberstream/(:any)/get_client'] = 'backend/Fiberstream/get_client/$1';
$route['manage/fiberstream/(:any)/get_client_count'] = 'backend/Fiberstream/get_client_count/$1';

$route['manage/fiberstream/pon'] = 'backend/Fiberstream/Pon';
$route['manage/fiberstream/(:any)/(:any)/redaman'] = 'backend/Fiberstream/redaman/$1/$2';
$route['manage/fiberstream/(:any)/(:any)/port'] = 'backend/Fiberstream/port/$1/$2';
$route['manage/fiberstream/(:any)/(:any)/bandwidth'] = 'backend/Fiberstream/bandwidth/$1/$2';
$route['manage/fiberstream/(:any)/(:any)/restart'] = 'backend/Fiberstream/restart/$1/$2';
$route['manage/fiberstream/(:any)/(:any)/profile'] = 'backend/Fiberstream/profile/$1/$2';

$route['manage/fiberstream/web_gpon_olt/(:num)'] = 'backend/fiberstream/web_gpon_olt/$1';
$route['manage/fiberstream/web_gpon_olt_nutana/(:num)'] = 'backend/fiberstream/web_gpon_olt_nutana/$1';
$route['manage/gmediabot/fs_client_all'] = 'backend/gmediabot/fs_client_all';

$route['manage/olt'] = 'backend/OLT';
$route['manage/olt/statistik'] = 'backend/OLT/statistik';
$route['manage/olt/tambah'] = 'backend/OLT/tambah';
$route['manage/olt/simpan'] = 'backend/OLT/simpan';
$route['manage/olt/(:num)/ubah'] = 'backend/OLT/ubah/$1';
$route['manage/olt/(:num)/timpa'] = 'backend/OLT/timpa/$1';
$route['manage/olt/(:num)/hapus'] = 'backend/OLT/hapus/$1';

$route['manage/maintenance'] = 'backend/Maintenance';
$route['manage/maintenance/user_akses_tambah'] = 'backend/Maintenance/user_akses_tambah';
$route['manage/maintenance/user_akses_simpan'] = 'backend/Maintenance/user_akses_simpan';
$route['manage/maintenance/user_akses_history'] = 'backend/Maintenance/user_akses_history';
$route['manage/maintenance/(:num)/user_akses_ubah'] = 'backend/Maintenance/user_akses_ubah/$1';
$route['manage/maintenance/(:num)/user_akses_timpa'] = 'backend/Maintenance/user_akses_timpa/$1';
$route['manage/maintenance/(:num)/user_akses_hapus'] = 'backend/Maintenance/user_akses_hapus/$1';
$route['manage/maintenance/(:num)/user_akses_sync'] = 'backend/Maintenance/user_akses_sync/$1';

$route['manage/maintenance/filter_tambah'] = 'backend/Maintenance/filter_tambah';
$route['manage/maintenance/filter_simpan'] = 'backend/Maintenance/filter_simpan';
$route['manage/maintenance/(:num)/filter_ubah'] = 'backend/Maintenance/filter_ubah/$1';
$route['manage/maintenance/(:num)/filter_timpa'] = 'backend/Maintenance/filter_timpa/$1';
$route['manage/maintenance/(:num)/filter_hapus'] = 'backend/Maintenance/filter_hapus/$1';

$route['manage/maintenance/maintenance_radio_bts'] = 'backend/Maintenance/maintenance_radio_bts';
$route['manage/maintenance/maintenance_radio_client'] = 'backend/Maintenance/maintenance_radio_client';
$route['manage/maintenance/maintenance_router_client'] = 'backend/Maintenance/maintenance_router_client';

$route['manage/bot_tg_list'] = 'backend/Bot_tg_list';
$route['manage/bot_tg_list/(:num)'] = 'backend/Bot_tg_list/detil/$1';
$route['manage/bot_tg_list/tambah'] = 'backend/Bot_tg_list/tambah';
$route['manage/bot_tg_list/simpan'] = 'backend/Bot_tg_list/simpan';
$route['manage/bot_tg_list/(:num)/ubah'] = 'backend/Bot_tg_list/ubah/$1';
$route['manage/bot_tg_list/(:num)/timpa'] = 'backend/Bot_tg_list/timpa/$1';
$route['manage/bot_tg_list/(:num)/hapus'] = 'backend/Bot_tg_list/hapus/$1';

$route['manage/bot_tg_user'] = 'backend/bot_tg_user';
$route['manage/bot_tg_user/(:num)'] = 'backend/bot_tg_user/detil/$1';
$route['manage/bot_tg_user/tambah'] = 'backend/bot_tg_user/tambah';
$route['manage/bot_tg_user/simpan'] = 'backend/bot_tg_user/simpan';
$route['manage/bot_tg_user/(:num)/ubah'] = 'backend/bot_tg_user/ubah/$1';
$route['manage/bot_tg_user/(:num)/timpa'] = 'backend/bot_tg_user/timpa/$1';
$route['manage/bot_tg_user/(:num)/hapus'] = 'backend/bot_tg_user/hapus/$1';
$route['gmediabot/(:any)/gmakses_web'] = 'gmediabot/gmakses_web/$1';

