/**
 * FanPress CM system javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

jQuery.noConflict();
jQuery(document).ready(function () {

    if (typeof fpcmSessionCheckEnabled !== 'undefined' && fpcmSessionCheckEnabled) {
        setInterval(function() {
            fpcmJs.checkSession();
        }, 60000);
    }

    fpcmAjax = new fpcmAjaxHandler();

    fpcmJs = new fpcmJs();
    fpcmJs.runCronsAsync();
    
    jQuery.each(fpcm, function(idx, object) {
        if (typeof object.init === 'function') {
            object.init();
        }
    });

    fpcmJs.windowResize();
    
    jQuery(window).resize(function () {
        fpcmJs.windowResize();
    });
    
    jQuery('.fpcm-loader').click(function () {
        if (jQuery(this).hasClass('fpcm-noloader')) return false;        
        fpcmJs.showLoader(true);
    });

    if (fpcmLang.searchHeadline !== undefined) {    
        fpcmJs.initCommentSearch();
    }

    jQuery('#fpcm-clear-cache').click(function () {
        return fpcmJs.clearCache();
    });

    if (typeof fpcmDtMasks != 'undefined') {
        jQuery("#system_dtmask").autocomplete({
            source: fpcmDtMasks
        });
        jQuery("#usermetasystem_dtmask").autocomplete({
            source: fpcmDtMasks
        });        
    };
    
    jQuery('#tabs-files-list-reload').click(function () {
        fpcmJs.reloadFiles();
        return false;
    });  
    
    jQuery('.fpcm-ui-commentlist-link').click(function () {
        var layerUrl = jQuery(this).attr('href');
        fpcmEditor.showCommentLayer(layerUrl);
        return false;
    });  

    jQuery('#tabs-options-syscheck').click(function () {
        fpcmJs.systemCheck();
    });
    
    jQuery('#password_confirm').focusout(function () {
        var password = jQuery('#password').val();
        var confirm  = jQuery(this).val();

        if (password != confirm) {
            if (fpcmLang.passCheckAlert !== undefined) {
                alert(fpcm.ui.translate('passCheckAlert'));
            } else {
                fpcmJs.addAjaxMassage('error', 'SAVE_FAILED_PASSWORD_MATCH');                
            }
        }

        return false;
    });
    
    jQuery('.fpcm-cronjoblist-exec').click(function () {
        var cjId = jQuery(this).attr('id');
        fpcmJs.execCronjobDemand(cjId);
        return false;
    });

    jQuery(".fpcm-cronjoblist-intervals" ).on("selectmenuchange", function(event, ui) {

        var cronjob  = jQuery(this).attr('id').split('_');
        var interval = jQuery(this).val();

        fpcmJs.setCronjobInterval(cronjob[1], interval);
        return false;
    });

    jQuery("#generatepasswd" ).click(function () {
        fpcmJs.generatePasswdString();
        return false;
    });

});
