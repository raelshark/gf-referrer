<?php
/*
Plugin Name:  Referrer Field for Gravity Forms
Description:  A custom field for Gravity Forms that's automatically populated with the referrer URL for the current user
Version:      1.0.1
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

define( 'GF_REFERRER_ADDON_VERSION', '1.0' );
define( 'REFERRER_COOKIE_NAME', 'referrer_url');

function get_referrer() {
  $referrer_url = '';
  if (!empty($_SERVER['HTTP_REFERER'])) {
    error_log('HTTP_REFERER found.');
    $referrer_url = $_SERVER['HTTP_REFERER'];
  } else if(!empty($_SERVER['X-FORWARDED-FOR'])){
    error_log('X-FORWARDED-FOR found.');
    $referrer_url = $_SERVER['X-FORWARDED-FOR'];
  } else {
    error_log('No HTTP referrer found');
    error_log('HTTP Headers: ');
    error_log(wp_json_encode(getallheaders()));
  }
  return $referrer_url;
}

add_action( 'init', 'set_referrer_cookie' );
function set_referrer_cookie() {

  //exclude AJAX calls and admin pages
  if (wp_doing_ajax() || is_admin() || strpos($_SERVER['REQUEST_URI'],'wp-content') !== false) {
    return;
  }

  error_log('Setting cookie --------------------------');

  $current_url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  error_log('Current URL: '.$current_url);

  if (empty($_COOKIE[REFERRER_COOKIE_NAME])) {

    error_log("No referrer cookie value found. Checking HTTP referrers.");
    $referrer_url = get_referrer();

    if(!empty($referrer_url)) {

      error_log("Referrer found: ".$referrer_url);

      $url_parts = parse_url($referrer_url);
      $referrer_host = $url_parts['host'] . (!empty($url_parts['port']) ? ':'.$url_parts['port'] : '');
      $current_host = $_SERVER['HTTP_HOST'];

      //exclude cron job calls
      if (strtolower($url_parts['path']) === 'wp-cron.php') {
        error_log("Cookie not set: Cron job request");
        return;
      }

      error_log("is current host: ". var_export(strtolower($referrer_host) === strtolower($current_host), true));
      error_log("is localhost: ". var_export(strtolower($url_parts['host']) === 'localhost', true));
      error_log("is admin: ". var_export(is_admin(), true));
      error_log("is empty: ". var_export(empty($referrer_url), true));

      if (strtolower($referrer_host) !== strtolower($current_host)) {
        if (strtolower($url_parts['host']) !== 'localhost') {
          error_log("Setting value to cookie: ".$referrer_url);
          setcookie( REFERRER_COOKIE_NAME, $referrer_url, time() + 30 * DAY_IN_SECONDS, "/", null );
        } else {
          error_log("Cookie not set: Request is from localhost");
        }
      } else {
        error_log("Cookie not set: Request is from the current host");
      }
    } else {
      error_log("Cookie not set: Referrer value is empty");
    }
  }

}

add_action( 'gform_loaded', array( 'GF_Referrer_AddOn_Bootstrap', 'load' ), 5 );
class GF_Referrer_AddOn_Bootstrap {
  public static function load() {
    if ( ! method_exists( 'GFForms', 'include_addon_framework' ) ) {
        return;
    }
    require_once( 'class-gfreferrer-addon.php' );
    GFAddOn::register( 'GFReferrerAddOn' );
  }
}

?>
