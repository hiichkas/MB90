<?php
/*
Plugin Name: MemberPress MailChimp
Plugin URI: http://www.memberpress.com/
Description: MailChimp Autoresponder integration for MemberPress.
Version: 1.0.3
Author: Caseproof, LLC
Author URI: http://caseproof.com/
Text Domain: memberpress-mailchimp
Copyright: 2004-2015, Caseproof, LLC
*/

if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if(is_plugin_active('memberpress/memberpress.php')) {

  define('MPMAILCHIMP_PLUGIN_SLUG','memberpress-mailchimp/main.php');
  define('MPMAILCHIMP_PLUGIN_NAME','memberpress-mailchimp');
  define('MPMAILCHIMP_EDITION',MPMAILCHIMP_PLUGIN_NAME);
  define('MPMAILCHIMP_PATH',WP_PLUGIN_DIR.'/'.MPMAILCHIMP_PLUGIN_NAME);
  $mpmailchimp_url_protocol = (is_ssl())?'https':'http'; // Make all of our URLS protocol agnostic
  define('MPMAILCHIMP_URL',preg_replace('/^https?:/', "{$mpmailchimp_url_protocol}:", plugins_url('/'.MPMAILCHIMP_PLUGIN_NAME)));

  // Load Addon
  require_once(MPMAILCHIMP_PATH . '/MpMailChimp.php');
  new MpMailChimp;

  // Load Update Mechanism -- will this ever fail because of the path?
  require_once(MPMAILCHIMP_PATH . '/../memberpress/app/lib/MeprAddonUpdates.php');
  new MeprAddonUpdates(
    MPMAILCHIMP_EDITION,
    MPMAILCHIMP_PLUGIN_SLUG,
    'mpmailchimp_license_key',
    __('MemberPress MailChimp', 'memberpress-mailchimp'),
    __('MailChimp Autoresponder Integration for MemberPress.', 'memberpress-mailchimp')
  );

}

