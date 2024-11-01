/**
   * Frontend boxes
   */

   $('.frontend_box').each(function(){
        console.log($(this).data('auto-close'));
        if( $(this).data('auto-close') == true ){

            $(this).slideDown().delay( $(this).data('delay') * 1000 ).fadeOut();

        } else {

            $(this).slideDown();

        }

   });
   $('.frontend_box_close').on('click', function(e){
          e.preventDefault();
          $(this).parents('.frontend_box').fadeOut();
   });