/**
 * FanPress CM system javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

jQuery.noConflict();
jQuery(document).ready(function () {

    if (typeof fpcmSessionCheckEnabled != 'undefined' && fpcmSessionCheckEnabled) {
        setInterval(function() { fpcmJs.checkSession(); }, 60000);
    }

    fpcmAjax = new fpcmAjaxHandler();

    fpcmJs = new fpcmJs();
    fpcmJs.runCronsAsync();
    
    fpcm.ui.load();
    fpcmJs.windowResize();
    
    jQuery(window).resize(function () {
        fpcmJs.windowResize();
    });
    
    jQuery(window).scroll(function () {
       fpcm.ui.fixedHeader();
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

    fpcm.ui.button('#fpcm-profile-menu-open', {
        icons: {
            primary: "ui-icon-info",
            secondary: "ui-icon-triangle-1-s"
        },
        text: true
    },
    function () {
        
        if (jQuery(window).width() >= 600) {
            dialogWidth = 500;
        } else if (jQuery(window).width() >= 480) {
            dialogWidth = '75%';
        } else if (jQuery(window).width() <= 480) {
            dialogWidth = '95%';
        }
        
        fpcm.ui.dialog({
            id: 'profile',
            title: fpcmQuickLinks,
            dlWidth: dialogWidth,
            dlButtons: [
                {
                    text: fpcmOpenProfile,
                    icons: { primary: "ui-icon-wrench" },                  
                    click: function () {
                        fpcmJs.showLoader(true);
                        fpcmJs.relocate(fpcmActionPath + 'system/profile');
                    }
                },
                {
                    text: fpcmLogout,
                    icons: { primary: "ui-icon-power" },
                    click: function () {
                        fpcmJs.showLoader(true);
                        fpcmJs.relocate(fpcmActionPath + 'system/logout');
                    }
                }
            ],
            dlOnClose: null
        });

    });

    if (typeof fpcmSearchHeadline != 'undefined') {

        fpcmJs.initArticleSearch();        
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
            content: fpcmConfirmMessage,
            dlButtons: [
                {
                    text: fpcmYes,
                    icons: { primary: "ui-icon-check" },                    
                    click: function() {
                        fpcmJs.clearLogs(logId); 
                        jQuery(this).dialog('close');
                    }
                },
                {
                    text: fpcmNo,
                    icons: { primary: "ui-icon-closethick" },
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
    
    jQuery('.fpcm-tabs-articles-headers a').click(function () {
        if (jQuery(this).hasClass('tabs-article-hidesearch')) {
            jQuery('#fpcmarticlesopensearch').hide();
            jQuery('#fpcmarticleslistaddnew').hide();
        } else if (jQuery('#fpcmarticlesopensearch').css('display') == 'none' ) {
            jQuery('#fpcmarticlesopensearch').show();
            jQuery('#fpcmarticleslistaddnew').show();
        }
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
            if (fpcmPasswordCheckAlert) {
                alert(fpcmPasswordCheckAlert);
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

function initCodeMirrorTemplates(id) {
    var editor = CodeMirror.fromTextArea(document.getElementById(id), {
        lineNumbers: true,
        matchBrackets: true,
        lineWrapping: true,
        autoCloseTags: true,
        id: 'idtest',
        mode: "text/html",
        matchTags: {bothTags: true},
        extraKeys: {"Ctrl-Space": "autocomplete"},
        value: document.documentElement.innerHTML
    });

    editor.setOption('theme', 'mdn-like');
};