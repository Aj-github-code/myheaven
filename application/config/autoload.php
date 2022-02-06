<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/
$autoload['packages'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in system/libraries/ or your
| application/libraries/ directory, with the addition of the
| 'database' library, which is somewhat of a special case.
|
| Prototype:
|
|	$autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|	$autoload['libraries'] = array('user_agent' => 'ua');
*/
$autoload['libraries'] = array(
							'database',
							'encryption',
							'user_agent',
							'form_validation',
							'MY_Form_validation',
							'session',
							'pagination',
							'breadcrumbs',
							'email',
							'notifications',
							'custom_constants',
							'common_lib',
							'custom_pagination',
                            'signin/signin_constants',
							'signin/signin_table',
							'profile/profile_constants',
                            'franchise/franchise_constants',
							'franchise/franchise_table',
                            //'franchise_products/franchise_products_constants',
						//	'franchise_products/franchise_products_table',
							//'products/product_constants',
							//'products/product_table',
							'signin/signin_constants',
							'signin/signin_table',
							'profile/profile_constants',
							'i_card/i_card_constants',
							'password/password_constants',
							'forgot_password/forgot_password_constants',
							'dashboard/dashboard_constants',
							'dashboard/dashboard_table',
							'kyc/kyc_constants',
							'kyc/kyc_table',
							'announcements/announcements_constants',
							'announcements/announcements_table',
							'products/products_constants',
							'products/products_table',
							'cart/cart_constants',
							'cart/cart_table',
							'orders/orders_constants',
							'orders/orders_table',
							'my_products/my_products_constants',
							'my_products/my_products_table',
							'payout/payout_constants',
							'payout/payout_table',
							'customers/customers_constants',
							'customers/customers_table',
							'customer_orders/customer_orders_constants',
							'customer_orders/customer_orders_table',
							'top_up/top_up_constants',
							'top_up/top_up_table',
							'repurchase/repurchase_constants',
							'repurchase/repurchase_table',
							'commissions/commissions_table',
							'gallery/gallery_constants',
							'gallery/gallery_table',
							'news/news_constants',
							'news/news_table',
							'messages/messages_constants',
							'crud/cruds_constants',
							'crud/cruds_table',
							'overview/overview_constants',
							'support/supports_table',
							'support/supports_constants',
							'network/networks_table',
							'network/networks_constants',
							'genealogy_list/genealogy_table',
							'genealogy_list/genealogy_constants',	
							'binary_tree/binary_table',
							'binary_tree/binary_constants',	
							'accounts/accounts_table',
							'accounts/accounts_constants',
							'join_link/joins_table',
							'join_link/joins_constants',
						);

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|	$autoload['drivers'] = array('cache');
|
| You can also supply an alternative property name to be assigned in
| the controller:
|
|	$autoload['drivers'] = array('cache' => 'cch');
|
*/
$autoload['drivers'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['helper'] = array('url', 'file');
*/
$autoload['helper'] = array('url', 'file', 'form', 'security', 'language', 'check_login', 'permissions_helper', 'template_helper', 'custom_functions');

/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/
$autoload['config'] = array('regex', 'my_config', 'custom', 'breadcrumb');

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/
$autoload['language'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|	$autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|	$autoload['model'] = array('first_model' => 'first');
*/
$autoload['model'] = array('common_model' => 'common');
