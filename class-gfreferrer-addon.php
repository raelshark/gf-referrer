<?php

GFForms::include_addon_framework();

class GFReferrerAddOn extends GFAddOn {
  protected $_version = GF_REFERRER_ADDON_VERSION;
  protected $_min_gravityforms_version = '1.9';
  protected $_slug = 'gf-referrer';
  protected $_path = 'gf-referrer/gf-referrer.php';
  protected $_full_path = __FILE__;
  protected $_title = 'Gravity Forms Referrer Add-On';
  protected $_short_title = 'Referrer Add-On';

  private static $_instance = null;

  public static function get_instance() {
    if ( self::$_instance == null ) {
        self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function pre_init() {
    parent::pre_init();

    if ( $this->is_gravityforms_supported() && class_exists( 'GF_Field' ) ) {
        require_once( 'includes/class-gfreferrer-field.php' );
    }
  }

  public function init_admin() {
    parent::init_admin();
  }
}

?>
