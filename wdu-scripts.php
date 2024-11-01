<?php
//enqueue bootstrap
function wdu_inquiryform_add_boot(){

    wp_enqueue_style('boot-cs', plugin_dir_url( __FILE__ ).'assets/bootstrap/bootstrap.min.css');

    wp_enqueue_script('boot_js', plugin_dir_url( __FILE__ ).'assets/bootstrap/bootstrap.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts','wdu_inquiryform_add_boot');