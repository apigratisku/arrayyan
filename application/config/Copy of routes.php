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

$route['manage'] = 'backend/Dashboard';


$route['manage/router'] = 'backend/Router';
$route['manage/router/(:num)'] = 'backend/Router/detil/$1';
$route['manage/router/tambah'] = 'backend/Router/tambah';
$route['manage/router/simpan'] = 'backend/Router/simpan';
$route['manage/router/(:num)/ubah'] = 'backend/Router/ubah/$1';
$route['manage/router/(:num)/timpa'] = 'backend/Router/timpa/$1';
$route['manage/router/(:num)/hapus'] = 'backend/Router/hapus/$1';

$route['manage/apsektor'] = 'backend/apSektor';
$route['manage/apsektor/(:num)'] = 'backend/apSektor/detil/$1';
$route['manage/apsektor/tambah'] = 'backend/apSektor/tambah';
$route['manage/apsektor/simpan'] = 'backend/apRoapSektoruter/simpan';
$route['manage/apsektor/(:num)/ubah'] = 'backend/apSektor/ubah/$1';
$route['manage/apsektor/(:num)/timpa'] = 'backend/apSektor/timpa/$1';
$route['manage/apsektor/(:num)/hapus'] = 'backend/apSektor/hapus/$1';

$route['manage/stsektor'] = 'backend/stSektor';
$route['manage/stsektor/(:num)'] = 'backend/stSektor/detil/$1';
$route['manage/stsektor/tambah'] = 'backend/stSektor/tambah';
$route['manage/stsektor/simpan'] = 'backend/stSektor/simpan';
$route['manage/stsektor/(:num)/ubah'] = 'backend/stSektor/ubah/$1';
$route['manage/stsektor/(:num)/timpa'] = 'backend/stSektor/timpa/$1';
$route['manage/stsektor/(:num)/hapus'] = 'backend/stSektor/hapus/$1';

$route['manage/server'] = 'backend/Server';
$route['manage/server/(:num)'] = 'backend/Server/detil/$1';
$route['manage/server/tambah'] = 'backend/Server/tambah';
$route['manage/server/simpan'] = 'backend/Server/simpan';
$route['manage/server/(:num)/ubah'] = 'backend/Server/ubah/$1';
$route['manage/server/(:num)/timpa'] = 'backend/Server/timpa/$1';
$route['manage/server/(:num)/hapus'] = 'backend/Server/hapus/$1';

$route['manage/traffic'] = 'backend/Traffic';
$route['manage/traffic/tambah'] = 'backend/Traffic/tambah';
$route['manage/traffic/tambah2/(:num)'] = 'backend/Traffic/tambah2/$1';
$route['manage/traffic/simpan'] = 'backend/Traffic/simpan';
$route['manage/traffic/(:num)/ubah'] = 'backend/Traffic/ubah/$1';
$route['manage/traffic/(:num)/timpa'] = 'backend/Traffic/timpa/$1';
$route['manage/traffic/(:num)/hapus'] = 'backend/Traffic/hapus/$1';

$route['manage/wireless'] = 'backend/Wireless';
$route['manage/wireless/tambah'] = 'backend/Wireless/tambah';
$route['manage/wireless/simpan'] = 'backend/Wireless/simpan';
$route['manage/wireless/(:num)/ubah'] = 'backend/Wireless/ubah/$1';
$route['manage/wireless/(:num)/timpa'] = 'backend/Wireless/timpa/$1';
$route['manage/wireless/(:num)/hapus'] = 'backend/Wireless/hapus/$1';

$route['manage/netwatch'] = 'backend/Netwatch';
$route['manage/netwatch/(:num)'] = 'backend/Netwatch/detil/$1';
$route['manage/netwatch/tambah'] = 'backend/Netwatch/tambah';
$route['manage/netwatch/simpan'] = 'backend/Netwatch/simpan';
$route['manage/netwatch/(:num)/ubah'] = 'backend/Netwatch/ubah/$1';
$route['manage/netwatch/(:num)/timpa'] = 'backend/Netwatch/timpa/$1';
$route['manage/netwatch/(:num)/hapus'] = 'backend/Netwatch/hapus/$1';

$route['manage/hs'] = 'backend/Hs';
$route['manage/hs/(:num)'] = 'backend/Hs/detil/$1';
$route['manage/hs/tambah'] = 'backend/Hs/tambah';
$route['manage/hs/simpan'] = 'backend/Hs/simpan';
$route['manage/hs/(:num)/ubah'] = 'backend/Hs/ubah/$1';
$route['manage/hs/(:num)/timpa'] = 'backend/Hs/timpa/$1';
$route['manage/hs/(:num)/hapus'] = 'backend/Hs/hapus/$1';

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