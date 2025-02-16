jQuery(document).ready(function () {
  // Show dropdown menus
  jQuery(".user-header-menu-wrapper .user-header-menu-icon").on("click", function(){
    jQuery(this).toggleClass('active');
    jQuery(".user-header-menu-wrapper .menu-header-hide").toggle();
  });

  // Hide dropdown menu if click outside
  jQuery(document).on("click", function(event){
         var jQuerytrigger = jQuery(".user-header-menu-wrapper");
         if(jQuerytrigger !== event.target && !jQuerytrigger.has(event.target).length && jQuerytrigger.is(':visible')){
           jQuery(".user-header-menu-wrapper .user-header-menu-icon").removeClass('active');
           jQuery(".user-header-menu-wrapper .menu-header-hide").hide();
         }
     });
});
