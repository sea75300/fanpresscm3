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
    
    fpcm.ui.load();
    fpcmJs.windowResize();
    
    jQuery(window).resize(function () {
        fpcmJs.windowResize();
    });
    
    jQuery('.fpcm-loader').click(function () {
        if (jQuery(this).hasClass('fpcm-noloader')) return false;        
        fpcmJs.showLoader(true);
    });

    jQuery('.fpcm-navigation-noclick').click(function () {
        fpcmJs.showLoader(false);
        return false;
    });
    
    jQuery('#fpcm-ui-showmenu-li').click(function () {
        jQuery('li.fpcm-menu-level1.fpcm-menu-level1-show').fadeToggle();
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
    
    jQuery('.fpcm-logs-clear').click(function () {
        var logId = jQuery(this).attr('id');
        fpcm.ui.dialog({
            title: fpcm.ui.translate('confirmHL'),
            content: fpcm.ui.translate('confirmMessage'),
            dlButtons: [
                {
                    text: fpcm.ui.translate('yes'),
                    icon: "ui-icon-check",                    
                    click: function() {
                        fpcmJs.clearLogs(logId); 
                        jQuery(this).dialog('close');
                    }
                },
                {
                    text: fpcm.ui.translate('no'),
                    icon: "ui-icon-closethick",
                    click: function() {
                        jQuery(this).dialog('close');
                    }
                }
            ]
        });
        
        return false;
    });
    
    jQuery('.fpcm-logs-reload').click(function () {
        fpcmJs.reloadLogs(jQuery(this).attr('id'));        
        return false;
    });
    
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
    
    jQuery('#fpcm-messages').find('.fpcm-msg-close').click(function () {
        var closeId = jQuery(this).attr('id');
        jQuery('#msgbox-' + closeId.substring(9)).fadeOut('slow');
    }).mouseover(function () {
        jQuery(this).find('.fa.fa-square').removeClass('fa-inverse');
        jQuery(this).find('.fa.fa-times').addClass('fa-inverse');
    }).mouseout(function () {
        jQuery(this).find('.fa.fa-square').addClass('fa-inverse');
        jQuery(this).find('.fa.fa-times').removeClass('fa-inverse');
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
