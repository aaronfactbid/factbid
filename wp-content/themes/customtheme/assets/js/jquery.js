function resize() {
    if (jQuery(window).width() < 768) {
        jQuery("#myCollapse").removeClass("show");
        jQuery("#collapse-div").removeClass("d-none");
        jQuery("#collapse-div").addClass("d-block");

        jQuery("#collapseSidebar").removeClass("show");
        jQuery("#collapse-news-page").removeClass("d-none");
        jQuery("#collapse-news-page").addClass("d-block");
    }else {
        jQuery("#myCollapse").addClass("show");
        jQuery("#collapse-div").removeClass("d-block");
        jQuery("#collapse-div").addClass("d-none");

        jQuery("#collapseSidebar").addClass("show");
        jQuery("#collapse-news-page").removeClass("d-block");
        jQuery("#collapse-news-page").addClass("d-none");
    }
}
jQuery(window).on('resize', function() {
    resize()
  });
  jQuery(document).ready(function() {
    
    jQuery("#claim-about-tab").click(function() {
        
        jQuery('#about-header-area').removeClass("d-none");
        jQuery("#about-header-area").addClass("show");
        
        if (jQuery('#response-header-area').hasClass('show')){
            jQuery('#response-header-area').removeClass("show");
            jQuery('#response-header-area').addClass("d-none");
        }
    });

    jQuery("#claim-discuss-tab").click(function() {
        
        jQuery('#about-header-area').removeClass("d-none");
        jQuery("#about-header-area").addClass("show");
        
        if (jQuery('#response-header-area').hasClass('show')){
            jQuery('#response-header-area').removeClass("show");
            jQuery('#response-header-area').addClass("d-none");
        }
    });
    
    jQuery("#claim-response-tab").click(function() {
        jQuery('#response-header-area').removeClass("d-none");
        jQuery("#response-header-area").addClass("show");

        if (jQuery('#about-header-area').hasClass('show')){
            jQuery('#about-header-area').removeClass("show");
            jQuery('#about-header-area').addClass("d-none");
        }
    });

    jQuery("#about-tab").click(function() {
        if (jQuery('#othertabs-facts-header').hasClass('show')){
            jQuery('#othertabs-facts-header').removeClass("show");
            jQuery('#othertabs-facts-header').removeClass("d-none");
        }
        jQuery('#about-facts-header').removeClass("d-none");
        jQuery("#about-facts-header").addClass("show");
    });
    jQuery("#discuss-tab").click(function() {
        if (jQuery('#about-facts-header').hasClass('show')){
            jQuery('#about-facts-header').removeClass("show");
            jQuery('#about-facts-header').addClass("d-none");
        }
        jQuery('#othertabs-facts-header').removeClass("d-none");
        jQuery("#othertabs-facts-header").addClass("show");
    });
    
});