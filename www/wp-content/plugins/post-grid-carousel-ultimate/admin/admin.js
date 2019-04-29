jQuery(document).ready(function($) {

    $(".tabs-menu a").click( function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    } ); 

     $("#sel5").change(function() {
      if($(this).val() == 'grid'){

          $("#tab2").css('display', 'block');
          $("#tab1").css('display', 'none');
          $("#tab3").css('display', 'none');

      }
      if($(this).val() == 'isotope'){

          $("#tab2").css('display', 'none');
          $("#tab1").css('display', 'none');
          $("#tab3").css('display', 'block');
          $("#tab4").css('display', 'none');

      }
      if($(this).val() == 'carousel'){

          $("#tab2").css('display', 'none');
          $("#tab1").css('display', 'block');
          $("#tab3").css('display', 'none');

      }
  });

    
     jQuery( '.cpa-color-picker' ).wpColorPicker();
   


});