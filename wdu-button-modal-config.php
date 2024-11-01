<?php
// add button by replacing cart in single page
function wdu_inquiryform_add_button_modal(){ ?>

<?php
//Get values from settings
$form_source_array = get_option('wdu_inquiryform_form_source');
$form_source = $form_source_array[0];
$form_shortcode = get_option('wdu_inquiryform_shortcode');
?>
    <!-- Trigger the modal with a button -->
    <button id="trigger_cf" type="button" class="btn btn-secondary2 d-block btn-info btn-lg" data-toggle="modal" data-target="#myModal"><?php _e('Send Request','wdu-product-inquiry'); ?></button>
  
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><?php _e('Inquiry For ','wdu-product-inquiry'); the_title();?></h4>
             <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <?php if($form_source == 1){
                echo do_shortcode('[contact]');
            }elseif($form_source == 2 && empty($form_shortcode)){
                _e('Please insert custom form shortcode','wdu-product-inquiry');
            }else{
              echo do_shortcode($form_shortcode);
            }
              ?>
          </div>
        </div>
      </div>
    </div>
  
  <?php }
  add_action('woocommerce_single_product_summary','wdu_inquiryform_add_button_modal',30);

  
  //Connect modal with button click
  function wdu_inquiryform_btn_modal_connection() { ?>
  
      <script type="text/javascript">
          jQuery('#trigger_cf').on('click', function(){
          if ( jQuery(this).text() == 'Send Request' ) {
                      jQuery('#product_inq').css("display","block");
                      jQuery('input[name="prd_name"]').val('<?php the_title(); ?>');
  
          } else {
              jQuery('#product_inq').hide();
              jQuery("#trigger_cf").html('Send Request'); 
          }
          });
  
  var input = document.getElementsByClassName("prd-name");
  var att = document.createAttribute("onchange");     
  att.value = "myFunction()";                        
  input[0].setAttributeNode(att);
  
  function myFunction() {
    var x = document.getElementById("prd");
    x.value = '<?php the_title(); ?>';
  }
      </script>
      <?php
         
  }
  add_action( 'woocommerce_single_product_summary', 'wdu_inquiryform_btn_modal_connection', 40 );


  //Add a button in loop page
  function wdu_inquiryform_add_button_loop(){?>

    <a href="<?php the_permalink(); ?>" class="button product_type_simple add_to_cart_button"><?php _e('Details','wdu-product-inquiry') ?></a>

  <?php }
  add_action('woocommerce_after_shop_loop_item','wdu_inquiryform_add_button_loop',10);