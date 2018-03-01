/****************************************************************************
*																			*
*	File:		nav_selections.js  											*
*																			*
*	Author:		Branch Vincent												*
*																			*
*	Date:		Sep 9, 2016													*
*																			*
*	Purpose:	This file highlights the current page in the various        *
*               navigation bars									            *
*																			*
****************************************************************************/

jQuery.noConflict()(function ($) {
    $(document).ready(setup_nav());
    $('#topNav').removeClass('hide');
    $('#sideNav').removeClass('hide');
});

// function setup_nav() {
//
//     var url = document.location.href;
//     var str = url.substring(url.lastIndexOf('/') + 1);
//     jQuery("#topNav li a").each(function() {
//         if (str.indexOf(this.href.toLowerCase()) > -1) {
//             jQuery("li.active").removeClass("active");
//             jQuery(this).parent().addClass("active");
//         }
//     });
//     jQuery("li.active").parents().each(function(){
//         if (jQuery(this).is("li")){
//             jQuery(this).addClass("active");
//         }
//     });
// }

/****************************************************************************
*																			*
*	Function:	setup_nav													*
*																			*
*	Purpose:	To highlight the current page in all navigation bars        *
*																			*
****************************************************************************/

function setup_nav() {

//  Get filename

    var url = document.location.href;
    var page = url.substring(url.lastIndexOf('/') + 1) || 'index.php';

//  Select current file in top/side navigations

    select_top_tabs(page);
    select_side_tabs(page);
    disable_links();

//  Add animation to accordion-style side navigation links

    // var acc = jQuery('.accordion');
    //
    // for (var i = 0; i < acc.length; i++) {
    //     acc[i].onclick = function() {
    //         this.classList.toggle('active');
    //         this.nextElementSibling.classList.toggle('show');
    //     }
    // }
    jQuery('.accordion').each(function() {
        this.onclick = function() {
            this.classList.toggle('active');
            this.nextElementSibling.classList.toggle('show');
        }
    });
}

/****************************************************************************
*									                                        *
*	Function:	select_top_tabs 											*
*																			*
*	Purpose:	To highlight the top navigation tab that matches the        *
*               specified url                                               *
*																			*
****************************************************************************/

function select_top_tabs(page) {

//  Get top tabs

    var tabs = jQuery('#topNav li a');
    var found = false;

//  Cycle through tabs and highlight if found

    for (var i = 0; i < tabs.length; i++) {
        var href = jQuery(tabs[i]).attr('href');
        if (href == page) {
            jQuery(tabs[i]).addClass('active');
            found = true;
        } else
            jQuery(tabs[i]).removeClass('active');
    }

//  If not found, highlight basic settings page

    var basic_settings = jQuery('#topNav li a[href="basic_settings.php"]')
    if (!found) jQuery(basic_settings).addClass('active');
}

/****************************************************************************
*									                                        *
*	Function:	select_side_tabs										    *
*																			*
*	Purpose:	To highlight the side navigation tab that matches the       *
*               specified url                                               *
*																			*
****************************************************************************/

function select_side_tabs(page) {

//  Get side tabs

    var tabs = jQuery('#sideNav li a');

//  Cycle through href links and highlight if found

    for (var i = 0; i < tabs.length; i++) {
        var href = jQuery(tabs[i]).attr('href');
        if (href == page) {
            jQuery(tabs[i]).addClass('active');
        }
        else
            jQuery(tabs[i]).removeClass('active');
    }

//  Cycle through accordion content and activate if found

    var found = false;
    var acc = jQuery('#sideNav .accordion');
    var acc_content = jQuery('#sideNav .accordion-content');

    for (var i = 0; i < acc.length; i++) {
        jQuery(acc[i]).removeClass('active');
        jQuery(acc_content[i]).removeClass('show');
    }

    for (var i = 0; i < acc.length; i++) {

        var kids = jQuery(acc_content[i]).children();
        var hrefs = [];
        for (var j = 0; j < kids.length; j++)
            hrefs[j] = jQuery(kids[j]).attr('href');
        if (jQuery.inArray(page, hrefs) != -1 && !found) {
            jQuery(acc[i]).addClass('active');
            jQuery(acc_content[i]).addClass('show');
            console.log(acc[i]);
            found = true;
        }
    }

    // for (var i = 0; i < acc.length; i++) {
    //     var kids = jQuery(acc_content[i]).children();
    //     var hrefs = [];
    //     for (var j = 0; j < kids.length; j++)
    //         hrefs[j] = jQuery(kids[j]).attr('href');
    //     console.log(hrefs);
    //     if (jQuery.inArray(page, hrefs) && !found) {
    //         jQuery(acc[i]).addClass('active');
    //         jQuery(acc_content[i]).addClass('show');
    //         console.log(page);
    //         // console.log(hrefs);
    //         found = true;
    //     } else if (!found) {
    //         jQuery(acc[i]).removeClass('active');
    //         jQuery(acc_content[i]).removeClass('show');
    //     }
    // }
}

function disable_links() {
    var val = jQuery('#assistant_info').val();
    if (val == 0) {
        jQuery('#sideNav li a[href="view_results.php"]').removeAttr("href");
        jQuery('#sideNav li a[href="investigate.php?operator=engineer"]').removeAttr("href");
        jQuery('#sideNav li a[href="investigate.php?operator=conductor"]').removeAttr("href");
        jQuery('#sideNav li a[href="sim_summary.php"]').removeAttr("href");
    }
    else if (val == 1) {
        jQuery('#sideNav li a[href="investigate.php?operator=conductor"]').removeAttr("href");
    }
}
