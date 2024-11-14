jQuery(document).ready(function () {
    // // mobail bottom tab open and  cloes
    function bindEventsBasedOnWidth() {
     var viewportWidth = jQuery(window).width();
     if (viewportWidth <= 991) {
        jQuery('.wl-left-slide-bar').removeClass('active');
        jQuery('.wl-left-slide-bar>.inner-colum>.nav-pills>.nav-link').removeClass('active next previous');
        jQuery('.wl-left-slide-bar>.inner-colum>.tab-content>.tab-pane').removeClass('active show');
         jQuery('.wl-left-slide-bar>.inner-colum>.nav-pills>.nav-link').click(function (event) {
             event.stopPropagation();
 
             jQuery('.wl-left-slide-bar').removeClass('active');
             jQuery(this).closest('.wl-left-slide-bar').addClass('active');
         });
 
         jQuery('button.cloes-btn').click(function () {
             resetClasses();
         });
 
         jQuery(document).click(function (event) {
             if (!jQuery(event.target).closest('.wl-left-slide-bar').length) {
                 resetClasses();
             }
         });
     } else {
         jQuery('.wl-left-slide-bar>.inner-colum>.nav-pills>.nav-link').off('click');
         jQuery('button.cloes-btn').off('click');
         jQuery(document).off('click');
     }
 }
 
 bindEventsBasedOnWidth();
 
 jQuery(window).resize(function () {
     bindEventsBasedOnWidth();
 });
 
 function resetClasses() {
     jQuery('.wl-left-slide-bar').removeClass('active');
     jQuery('.wl-left-slide-bar>.inner-colum>.nav-pills>.nav-link').removeClass('active next previous ');
     jQuery('.wl-left-slide-bar>.inner-colum>.tab-content>.tab-pane').removeClass('active show');
 }
 });