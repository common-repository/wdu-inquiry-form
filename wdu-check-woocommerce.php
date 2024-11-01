<?php
function wdu_inquiryform_check_woocommerce_is_on() {
    if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        add_action( 'admin_notices', 'wdu_inquiryform_error_notice' );

        deactivate_plugins( plugin_basename( __FILE__ ) ); 

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
    }
}
add_action( 'admin_init', 'wdu_inquiryform_check_woocommerce_is_on' );

function wdu_inquiryform_error_notice(){
    ?><div class="error"><p><?php _e('Please activate woocommerce for WDU Product Inquiry Plugin','wdu-product-inquiry') ?></p></div><?php
}