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
|	http://codeigniter.com/user_guide/general/routing.html
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

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'index';
/**
 * 文章
 */

$route['article/(:num)'] = 'article/detail/index/$1';
$route['article'] = 'article/main';
$route['article/([a-z]*)'] = 'article/main/index/article/$1';
//发布文章
$route['publish/article']  = 'article/publish/index/publish';
//更新文章
$route['update/article/(:num)']   = 'article/publish/index/update/$1';

$route['exhibition'] = 'article/main/index/exhibition';
$route['exhibition/([a-z]*)'] = 'article/main/index/exhibition/$1';
/**
 *联系人
 */
$route['contacts']  = 'contacts/main';

/**
 * 用户
 */
$route['login'] = 'account/main/index/login';
$route['signup'] = 'account/main/index/signup';
$route['setting']   = 'account/setting/index/user';
$route['setting/(([a-z]*))']   = 'account/setting/index/$1';

/**
 *圈子 
 */
$route['community/(:num)'] = 'community/main/index/$1';
$route['post/(:num)'] = 'community/post/index/$1';
$route['publish/community'] = 'community/publish/index/community';
$route['publish/post'] = 'community/publish/index/post';

/**
 * 联系人
 */
$route['contacts'] = 'contacts/main';
$route['contacts/([a-z]*)'] = 'contacts/main';

/**
 * 私信
 */
$route['conversation/(:num)'] = 'conversation/main/index/$1';

/**
 * 动态
 */
$route['feed'] = 'feed/main';

/**
 *消息 
 */
$route['notification']  = 'notification/main';
$route['notification/([a-z]*)'] = 'notification/main/index/$1';

/**
 * 用户主页
 */
$route['home/([a-z0-9_]*)'] = 'home/main/index/$1';
$route['home/([a-z0-9_]*)/community'] = 'home/main/index/$1/community';
$route['home/([a-z0-9_]*)/intro'] = 'home/main/index/$1/intro';
$route['home/([a-z0-9_]*)/article'] = 'home/main/index/$1/article';
$route['home/([a-z0-9_]*)/cooperate'] = 'home/main/index/$1/cooperate';



/**
 * 管理员用户管理
 */
$route['admin/user/u'] = 'admin/user/index/u';
$route['admin/user/u/(:num)'] = 'admin/user/index/u/$1';
$route['admin/user/a'] = 'admin/user/index/a';
$route['admin/user/a/(:num)'] = 'admin/user/index/a/$1';

/**
 * 管理员文章管理
 */
$route['admin/article/a'] = 'admin/article/index/a';
$route['admin/article/a/(:num)'] = 'admin/article/index/a/$1';
