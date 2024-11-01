<?php

class WDU_Enquiry_Form {

    /**
     * Class constructor
     */
    public function __construct() {
  
        $this->define_hooks();
    }
  
    public function controller() {
  
        if( isset( $_POST['submit'] ) ) { // Submit button
  
            $full_name   = filter_input( INPUT_POST, 'full_name', FILTER_SANITIZE_STRING );
  
            $email       = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING | FILTER_SANITIZE_EMAIL );
  
            $prd_name    = filter_input( INPUT_POST, 'prd_name', FILTER_SANITIZE_STRING );
  
            $comments    = filter_input( INPUT_POST, 'comments', FILTER_SANITIZE_STRING );

            $sitename = strtolower( $_SERVER['SERVER_NAME'] );
            if ( substr( $sitename, 0, 4 ) == 'www.' ) {
                $sitename = substr( $sitename, 4 );
            }
			
			$headers = 'From:'.$full_name.'x<team@'.$sitename.'>';

            $adminEmail = get_option('admin_email');

             if(wp_mail( $adminEmail, 'Inquiry for '.$prd_name, $comments, $headers )){
                echo '<div class="alert alert-success text-center alert-dismissible fade show" role="alert">Thank you! Your message has been successfully sent
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

             }else{
                echo '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">Sorry! Something went wrong!!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
             };
        }
    }
  
    /**
     * Display form
     */
    public function display_form() {
  
        $full_name   = filter_input( INPUT_POST, 'full_name', FILTER_SANITIZE_STRING );
  
        $prd_name   = filter_input( INPUT_POST, 'prd_name', FILTER_SANITIZE_STRING );
  
        $email       = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING | FILTER_SANITIZE_EMAIL );
        $comments    = filter_input( INPUT_POST, 'comments', FILTER_SANITIZE_STRING );
  
        // Default empty array
  
        $output = '';
  
        $output .= '<form method="post">';
        $output .= '    <div class="form-group">';
        $output .= '        ' . $this->display_text( 'full_name', 'Name', $full_name );
        $output .= '    </div>';
        $output .= '    <div class="form-group">';
        $output .= '        ' . $this->display_email( 'email', 'Email', $email );
        $output .= '    </div>';
        $output .= '    <div class="form-group">';
        $output .= '        ' . $this->display_prd( 'prd_name', 'Name', $prd_name );
        $output .= '    </div>';
        $output .= '    <div class="form-group">';
        $output .= '        ' . $this->display_textarea( 'comments', 'Your Inquiry', $comments );
        $output .= '    </div>';
        $output .= '    <div class="form-group">';
        $output .= '        <input type="submit" name="submit" value="Send" />';
        $output .= '    </div>';
        $output .= '</form>';
  
        return $output;
    }
  
    /**
     * Display text field
     */
    private function display_text( $name, $label, $value = '' ) {
  
        $output = '';
  
       //$output .= '<label>' . esc_html__( $label, 'wpse_299521' ) . '</label>';
        $output .= '<input type="text" class="form-control" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" placeholder="Your Name">';
  
        return $output;
    }
  
      /**
     * Display EMAIL field
     */
    private function display_email( $email, $label, $value = '' ) {
  
      $output = '';
      $output .= '<input type="email" class="form-control" name="' . esc_attr( $email ) . '" value="' . esc_attr( $value ) . '" placeholder="Your Email">';
  
      return $output;
  }
    /**
     * Display prd-name field
     */
    private function display_prd( $name, $label, $value = '' ) {
  
      $output = '';
      $output .= '<input type="text" id="prd" class="form-control prd-name" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
  
      return $output;
  }
    /**
     * Display textarea field
     */
    private function display_textarea( $name, $label, $value = '' ) {
  
        $output = '';
        $output .= '<textarea placeholder="Your Inquiry" name="' . esc_attr( $name ) . '" >' . esc_html( $value ) . '</textarea>';
  
        return $output;
    }
  
    /**
     * Define hooks related to plugin
     */
    private function define_hooks() {
  
        /**
         * Add action to send email
         */
        add_action( 'wp', array( $this, 'controller' ) );
  
        /**
         * Add shortcode to display form
         */
        add_shortcode( 'contact', array( $this, 'display_form' ) );
    }
  }
  
  new WDU_Enquiry_Form();