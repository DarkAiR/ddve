<?php
class JConfig {
	var $offline = '0';
	var $editor = 'tinymce';
	var $list_limit = '20';
	var $helpurl = 'http://help.joomla.org';
	var $debug = '0';
	var $debug_lang = '0';
	var $sef = '0';
	var $sef_rewrite = '0';
	var $sef_suffix = '0';
	var $feed_limit = '10';
	var $feed_email = 'author';
	var $secret = 'aTTgcSJdZg40sLzE';
	var $gzip = '0';
	var $error_reporting = '-1';
	var $xmlrpc_server = '0';
	var $log_path = '/home/u17424/ddve.ru/www/logs';
	var $tmp_path = '/home/u17424/ddve.ru/www/tmp';
	var $live_site = 'http://www.ddve.ru';
	var $force_ssl = '0';
	var $offset = '5';
	var $caching = '0';
	var $cachetime = '15';
	var $cache_handler = 'file';
	var $memcache_settings = array();
	var $ftp_enable = '0';
	var $ftp_host = '';
	var $ftp_port = '0';
	var $ftp_user = '';
	var $ftp_pass = '';
	var $ftp_root = '';
	var $dbtype = 'mysql';
	var $host = 'localhost';
	var $user = 'u17424';
	var $password = 'fopow4zofub';
	var $db = 'u17424_ddve';
	var $dbprefix = 'jos_';
	var $mailer = 'mail';
	var $mailfrom = 'darkair2@gmail.com';
	var $fromname = 'localhost/ddve.ru';
	var $sendmail = '/usr/sbin/sendmail';
	var $smtpauth = '0';
	var $smtpsecure = 'none';
	var $smtpport = '25';
	var $smtpuser = 'ddve_smtp@mail.ru';
	var $smtppass = 'lldtcvng';
	var $smtphost = 'smtp.mail.ru';
	var $MetaAuthor = '1';
	var $MetaTitle = '1';
	var $lifetime = '15';
	var $session_handler = 'database';
	var $sitename = 'ddve.ru';
	var $MetaDesc = '';
	var $MetaKeys = '&quot;ДайтеДве!&quot;, ДайтеДве!, ДайтеДве,  Дайте Две, дайте две, Дайте две, ресторан доставки &quot;ДайтеДве!&quot;, ресторан доставки ДайтеДве, ресторан доставки Дайте Две, доставка Нижний Тагил, доставка еды, доставка еды Нижний Тагил, доставка роллов, доставка ролов, доставка роллов Нижний Тагил, доставка ролов Нижний Тагил, суши Нижний Тагил, ресторан доставки, китайская лапша';
	var $offline_message = '';
}
return;

/**
* @version		$Id: configuration.php-dist 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software and parts of it may contain or be derived from the
* GNU General Public License or other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*
* -------------------------------------------------------------------------
* THIS SHOULD ONLY BE USED AS A LAST RESORT WHEN THE WEB INSTALLER FAILS
*
* If you are installing Joomla! manually i.e. not using the web browser installer
* then rename this file to configuration.php e.g.
*
* UNIX -> mv configuration.php-dist configuration.php
* Windows -> rename configuration.php-dist configuration.php
*
* Now edit this file and configure the parameters for your site and
* database.
*/
class JConfig {
	/**
	* -------------------------------------------------------------------------
	* Site configuration section
	* -------------------------------------------------------------------------
	*/
	/* Site Settings */
	var $offline = '0';
	var $offline_message = '';
	var $sitename = 'www.ddve.ru';
	var $editor = 'tinymce';
	var $list_limit = '20';
	var $legacy = '0';

	/**
	* -------------------------------------------------------------------------
	* Database configuration section
	* -------------------------------------------------------------------------
	*/
	/* Database Settings */
	var $dbtype = 'mysql';
	var $host = 'localhost';
	var $user = 'u17424';
	var $password = 'fopow4zofub';
	var $db = 'u17424_ddve';
	var $dbprefix = 'jos_';

	/* Server Settings */
	var $secret = 'aTTgcSJdZg40sLzE';
	var $gzip = '0';
	var $error_reporting = '-1';
	var $helpurl = 'http://help.joomla.org';
	var $xmlrpc_server = '0';
	var $ftp_host = '';
	var $ftp_port = '';
	var $ftp_user = '';
	var $ftp_pass = '';
	var $ftp_root = '';
	var $ftp_enable = '0';
	var $tmp_path = '/home/u17424/ddve.ru/www/tmp';
	var $log_path = '/home/u17424/ddve.ru/www/logs';
	var $offset = '0';
	var $live_site = 'http://ddve.ru';
	var $force_ssl = '0';

	/* Session settings */
	var $lifetime = '15';
	var $session_handler = 'database';

	/* Mail Settings */
	var $mailer = 'mail';
	var $mailfrom = 'darkair2@gmail.com';
	var $fromname = 'ddve';
	var $sendmail = '/usr/sbin/sendmail';
	var $smtpauth = '0';
	var $smtpuser = 'ddve_smtp@mail.ru';
	var $smtppass = 'lldtcvng';
	var $smtphost = 'smtp.mail.ru';
	var $smtpport = '587';

	/* Cache Settings */
	var $caching = '0';
	var $cachetime = '15';
	var $cache_handler = 'file';

	/* Debug Settings */
	var $debug = '0';
	var $debug_db 	= '0';
	var $debug_lang = '0';

	/* Meta Settings */
	var $MetaDesc = '';
	var $MetaKeys = '&quot;!&quot;, !, ,   ,  ,  ,   &quot;!&quot;,   ,    ,   ,  ,    ,  ,  ,    ,    ,   ,  ,  ';
	var $MetaTitle = '1';
	var $MetaAuthor = '1';

	/* SEO Settings */
	var $sef = '0';
	var $sef_rewrite = '0';
	var $sef_suffix = '0';

	/* Feed Settings */
	var $feed_limit = '10';
	var $feed_email = 'author';

//	var $memcache_settings = array();
//	var $smtpsecure = 'none';
}
?>
