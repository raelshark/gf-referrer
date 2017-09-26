<?php

class GF_Referrer_Field extends GF_Field_Hidden {

  public $type = 'gfreferrer';

  /**
	 * Return the field title, for use in the form editor.
	 *
	 * @return string
	 */
  public function get_form_editor_field_title() {
    return esc_attr__( 'Referrer', 'gf-referrer' );
  }

  /**
	 * Assign the field button to the Advanced Fields group.
	 *
	 * @return array
	 */
  public function get_form_editor_button() {
    return array(
      'group' => 'advanced_fields',
      'text'  => $this->get_form_editor_field_title(),
    );
  }

  /**
   * The settings which should be available on the field in the form editor.
   *
   * @return array
   */
  function get_form_editor_field_settings() {
		return array(
      'label_setting',
      'prepopulate_field_setting'
		);
	}

  /**
	 * Set the scripts to be included in the form editor.
	 *
	 * @return string
	 */
	public function get_form_editor_inline_script_on_page_render() {
		// set the default field label for the simple type field
		$script = sprintf( "function SetDefaultValues_%s(field) {" .
      "field.label = '%s'," .
      "field.allowsPrepopulate = true," .
      "field.inputName = 'gfreferrer';" .
      //"defaultValue = '"++"'" .
      "}", $this->type, $this->get_form_editor_field_title() ) . PHP_EOL;
      $script .= sprintf( "jQuery(document).bind( 'gform_load_field_settings', function( event, field, form ) {" .
    // $script .= sprintf( "jQuery(document).bind( 'gform_load_field_settings', function( event, field, form ) {" .
      //TODO: Make this selector work - event runs BEFORE fields are in DOM
      //TODO: Make sure this only applies to the custom field
        "console.log('opened:'+field.id);" .
        "var fieldSelector = '#field_' + field.id;" .
        "console.log(fieldSelector + ' input#field_prepopulate');" .
        "console.log(jQuery(fieldSelector + ' input#field_prepopulate'));" .
        "jQuery(fieldSelector + ' input#field_prepopulate').prop('disabled',true);" .
         "});") . PHP_EOL;
		return $script;
	}
  
}

GF_Fields::register( new GF_Referrer_Field() );

?>
