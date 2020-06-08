<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dashboard';
$route['test'] = 'dashboard/cek_fungsi';

// Login
// $route['login'] = 'auth';
$route['logout'] = 'login/logout';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
