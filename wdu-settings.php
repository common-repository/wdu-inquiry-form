<?php

class WDU_InquiryForm_Settings_Page {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wdu_inquiryform_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wdu_inquiryform_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wdu_inquiryform_setup_fields' ) );
		add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), array( $this, 'wdu_inquiryform_settings_link' ) );
	}

	public function wdu_inquiryform_settings_link($links) {
	    $newlink = sprintf("<a href='%s'>%s</a>",'options-general.php?page=wdu_inquiry_form',__('Settings','wdu-product-inquiry'));
	    $links[] = $newlink;
	    return $links;
	}

	public function wdu_inquiryform_create_settings() {
		$page_title = __( 'WDU Inquiry Form', 'wdu-product-inquiry' );
		$menu_title = __( 'WDU Inquiry Form', 'wdu-product-inquiry' );
		$capability = 'manage_options';
		$slug       = 'wdu_inquiry_form';
		$callback   = array( $this, 'wdu_inquiryform_settings_content' );
		add_options_page( $page_title, $menu_title, $capability, $slug, $callback );
	}

	public function wdu_inquiryform_settings_content() { ?>
        <div class="wrap">
            <h1><?php _e('WDU Inqury Form Settings'); ?></h1>
            <form method="POST" action="options.php">
				<?php
				settings_fields( 'wdu_inquiry_form' );
				do_settings_sections( 'wdu_inquiry_form' );
				submit_button();
				?>
            </form>
        </div> <?php
	}

	public function wdu_inquiryform_setup_sections() {
		add_settings_section( 'wdu_inquiryform_section', __('Use the settings bellow to make it easy to use','wdu-product-inquiry'), array(), 'wdu_inquiry_form' );
	}

	public function wdu_inquiryform_setup_fields() {
		$fields = array(
			array(
				'label'       => __( 'Turn off Bootstrap?', 'wdu-product-inquiry' ),
				'id'          => 'wdu_inquiryform_boot_switch',
				'type'        => 'checkbox',
				'section'     => 'wdu_inquiryform_section',
			),
			array(
				'label' => __('Form Source','wdu-product-inquiry'),
				'id' => 'wdu_inquiryform_form_source',
				'type' => 'radio',
				'section' => 'wdu_inquiryform_section',
				'options' => array(
					'1' => __('Default Form','wdu-product-inquiry'),
					'2' => __('Custom Form','wdu-product-inquiry'),
				),
			),
			array(
				'label' => __('Custom Form Shortcode','wdu-product-inquiry'),
				'id' => 'wdu_inquiryform_shortcode',
				'type' => 'text',
				'section' => 'wdu_inquiryform_section',
				'desc' => __('If you want to use a custom or third party form then use this field to paste the shortcode of that form. Please use shortcode with single quotation mark not double (Follow the placeholder format)','wdu-product-inquiry'),
				'placeholder' => "[contact-form-7 id='57' title='Contact form 1']",
			),
		);
		foreach ( $fields as $field ) {
			add_settings_field( $field['id'], $field['label'], array(
				$this,
				'wdu_inquiryform_field_callback'
			), 'wdu_inquiry_form', $field['section'], $field );
			register_setting( 'wdu_inquiry_form', $field['id'] );
		}
	}

	public function wdu_inquiryform_field_callback( $field ) {
		$value = get_option( $field['id'] );
		switch ( $field['type'] ) {
			case 'radio':
			if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
				$options_markup = '';
				$iterator = 0;
				foreach( $field['options'] as $key => $label ) {
					$iterator++;
					if (!is_array($value)) {
						$value = str_split($value);
					};
					$options_markup.= sprintf('<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
					$field['id'],
					$field['type'],
					$key,
					checked($value[array_search($key, $value, true)], $key, false),
					$label,
					$iterator
					);
					}
					printf( '<fieldset>%s</fieldset>',
					$options_markup
					);
			}
			break;
			case 'textarea':
				printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
					$field['id'],
					isset( $field['placeholder'] ) ? $field['placeholder'] : '',
					$value
				);
				break;

			case 'checkbox':
				printf('<input %s id="%s" name="%s" type="checkbox" value="1">',
					$value === '1' ? 'checked' : '',
					$field['id'],
					$field['id']
			);

				break;
			default:
				printf( '<input class="regular-text" name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					isset( $field['placeholder'] ) ? $field['placeholder'] : '',
					$value
				);
		}
		if ( isset( $field['desc'] ) ) {
			if ( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
}

new WDU_InquiryForm_Settings_Page();