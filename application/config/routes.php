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
 * 首页
 *
 */
$route['home'] = 'home/main';
/**
 * 文章
 */

$route['article/(:num)'] = 'article/detail/index/$1';
$route['article'] = 'article/main';
$route['topic'] = 'article/main/index/topic';
//发布文章
$route['publish/article']  = 'article/publish/index/publish';
//更新文章
$route['update/article/(:num)']   = 'article/publish/index/update/$1';

//$route['topic'] = 'article/main/index/topic';
//$route['topic/([a-z]*)'] = 'article/main/index/topic/$1';
$route['publish/topic'] = 'topic/publish/index/publish';
$route['update/topic/(:num)'] = 'topic/publish/index/update/$1';
/**
 * 艺术品
 */
$route['production/(:num)'] = 'production/detail/index/$1';
$route['production'] = 'production/main';
//发布艺术品
$route['publish/production']  = 'production/publish/index/publish';
//更新艺术品
$route['update/production/(:num)']   = 'production/publish/index/update/$1';

/**
 * 艺术家
 */
$route['artist'] 		= 'artist/main';
$route['artist/(:num)'] = 'artist/detail/index/$1';
//发布艺术品
$route['publish/artist']  = 'artist/publish/index/publish';
//更新艺术品
$route['update/artist/(:num)']   = 'artist/publish/index/update/$1';
//购物车
$route['cart']  = 'cart/main';
//购买记录
$route['transaction']  = 'transaction/main';
/**
 * 用户
 */
$route['login'] = 'account/main/index/login';
$route['signup'] = 'account/main/index/signup';
$route['setting']   = 'account/setting/index/user';
$route['setting/(([a-z]*))']   = 'account/setting/index/$1';

/**
 * 收藏列表
 */
$route['like'] = 'like/main';
$route['like/([a-z]*)']   = 'like/main/index/$1';
/**
 * 私信
 */
$route['conversation/(:num)'] = 'conversation/main/index/$1';

/**
 *消息
 */
$route['msg']  = 'notification/main';
$route['msg/([a-z]*)'] = 'notification/main/index/$1';

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

/**
 * 管理员艺术品管理
 */
$route['admin/production/p'] = 'admin/production/index/p';
$route['admin/production/p/(:num)'] = 'admin/production/index/p/$1';
$route['admin/production/t'] = 'admin/production/index/t';
$route['admin/production/t/(:num)'] = 'admin/production/index/t/$1';
$route['admin/production/m'] = 'admin/production/index/m';
$route['admin/production/m/(:num)'] = 'admin/production/index/m/$1';
