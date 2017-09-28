<?php
/*
Plugin Name:  Referrer Field for Gravity Forms
Description:  A custom field for Gravity Forms that's automatically populated with the referrer URL for the current user
Version:      1.0.1
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

define( 'GF_REFERRER_ADDON_VERSION', '1.0' );

add_action('init', 'start_session', 1);
function start_session() {
  if(!session_id()) {
    session_start();
  }
}

add_action('wp_logout', 'end_session');
add_action('wp_login', 'end_session');
add_action('end_session_action', 'end_session');
function end_session() {
  session_destroy();
}

add_action('init', 'gfreferrer_set_referrer', 1);
function gfreferrer_set_referrer() {
  if (!isset($_SESSION['gf_referral_source']) || empty($_SESSION['gf_referral_source'])) {
    error_log("No referrer session value found. Checking HTTP referrers.");
    $referrer_url = "";
    if (!empty($_SERVER['HTTP_REFERER'])) {
      error_log("HTTP_REFERER found.");
      $referrer_url = $_SERVER['HTTP_REFERER'];
    } else if(!empty($_SERVER['X-FORWARDED-FOR'])){
      error_log("X-FORWARDED-FOR found.");
      $referrer_url = $_SERVER['X-FORWARDED-FOR'];
    } else {
      error_log("No HTTP referrer found");
    }

    error_log("Referrer variable set: ".$referrer_url);

    $referrer_host = parse_url($referrer_url, PHP_URL_HOST);
    $current_host = $_SERVER['HTTP_HOST'];
    error_log("Current host: ".$current_host);

    if(!empty($referrer_url) && !strpos(strtolower($referrer_host), strtolower($current_host))) {
      error_log("Value set to session: ".$referrer_url);
      $_SESSION['gf_referral_source'] = $referrer_url;
    } else {
      error_log("Referrer variable empty or hosts are the same");
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
