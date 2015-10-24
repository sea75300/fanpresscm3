/**
 * FanPress CM system javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

jQuery.noConflict();
jQuery(document).ready(function () {

    if (fpcmSessionCheckEnabled) {
        setInterval(function() { fpcmJs.checkSession(); }, 60000);
    }

    fpcmAjax = new fpcmAjaxHandler();

    fpcmJs = new fpcmJs();
    fpcmJs.runCronsAsync();
    
    fpcmJs.windowResize();
    fpcmJs.assignButtons();
    fpcmJs.initInputShadow();
    
    jQuery(window).resize(function () {
        fpcmJs.windowResize();
    });
    
    jQuery(window).scroll(function () {
       fpcmJs.fixedHeader();
    });
    
    jQuery(document).tooltip();
    jQuery('.fpcm-link-fancybox').fancybox();    
    jQuery('input.fpcm-ui-spinner').spinner();    
    jQuery('.fpcm-tabs-general').tabs();
    jQuery('.fpcm-tabs-accordion').accordion({
        header: "h2",
        heightStyle: "content"
    });    
    
    jQuery('.fpcm-ui-input-select').selectmenu({
        width: 200
    });    
    
    jQuery('.fpcm-ui-input-select-articleactions').selectmenu({
        width: 200,
        position: {
            my: 'left top',
            at: 'left bottom+5',
            offset: null
        }
    });    
    
    jQuery('.fpcm-ui-input-select-moduleactions').selectmenu({
        width: 200,
        position: {
            my: 'left top',
            at: 'left bottom+5',
            offset: null
        }
    });
    
    jQuery('.fpcm-loader').click(function () {
        if (jQuery(this).hasClass('fpcm-noloader')) return false;        
        fpcmJs.showLoader(true);
    });
    
    jQuery('.fpcm-navigation-hide').click(function () {
        fpcmJs.hideNavigation();
    });

    jQuery('.fpcm-navigation-noclick').click(function () {
        fpcmJs.showLoader(false);
        return false;
    });

    jQuery('#fpcm-profile-menu-open').button({
        icons: {
            primary: "ui-icon-info",
            secondary: "ui-icon-triangle-1-s"
        },
        text: true
    }).click(function () {
        jQuery('#fpcm-profile-dialog-layer').dialog({
            width: 500,
            modal: true,
            resizable: false,
            title: fpcmQuickLinks,
            buttons: [
                {
                    text: fpcmOpenProfile,
                    icons: { primary: "ui-icon-wrench" },                  
                    click: function () {
                        fpcmJs.showLoader(true);
                        window.location.href = fpcmActionPath + 'system/profile';
                    }
                },
                {
                    text: fpcmLogout,
                    icons: { primary: "ui-icon-power" },
                    click: function () {
                        fpcmJs.showLoader(true);
                        window.location.href = fpcmActionPath + 'system/logout';
                    }
                }
            ]
        });
    });

    if (typeof fpcmArticlesSearchHeadline != 'undefined') {
        jQuery('#fpcmarticlesopensearch').button({
            icons: {
                primary: "ui-icon-search"
            },
            text: true
        }).click(function () {
            jQuery('.fpcm-ui-input-select-articlesearch').selectmenu({
                width: '100%',
                appendTo: '#fpcm-articles-search-dialog'
            });
            jQuery('.fpcm-full-width-date').datepicker({
                dateFormat: "yy-mm-dd",
                firstDay: 1
            });               

            jQuery('#fpcm-articles-search-dialog').dialog({
                width: 700,
                height: 350,
                modal    : true,
                resizable: true,
                title    : fpcmArticlesSearchHeadline,
                buttons  : [
                    {
                        text: fpcmArticlesSearchStart,
                        icons: {
                            primary: "ui-icon-check"            
                        },                        
                        click: function() {                            
                            var sfields = jQuery('.fpcm-articles-search-input');
                            var sParams = {
                                mode: fpcmArticleSearchMode,
                                filter: {}
                            };
                            
                            jQuery.each(sfields, function( key, obj ) {
                                var objVal  = jQuery(obj).val();
                                var objName = jQuery(obj).attr('name');                                
                                sParams.filter[objName] = objVal;
                            });

                            fpcmJs.startSearch(sParams);
                            jQuery(this).dialog('close');
                        }
                    },                    
                    {
                        text: fpcmClose,
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                        
                        click: function() {
                            jQuery(this).dialog('close');
                        }
                    }                            
                ],
                open: function( event, ui ) {
                    jQuery('#text').focus();
                }
            });
            return false;
        });
    }

    jQuery('#fpcmopennews').button({
        icons: {
            primary: "ui-icon-circle-triangle-e",
        },
        text: false
    });
    
    jQuery('.fpcm-articlelist-openlink').button({
        icons: {
            primary: "ui-icon-circle-triangle-e",
        },
        text: false
    });
    
    jQuery('.fpcm-reload-btn').button({
        icons: {
            primary: "ui-icon-refresh",
        },
        text: false
    });    

    jQuery('.fpcm-clear-btn').button({
        icons: {
            primary: "ui-icon-trash",
        },
        text: true
    });
        
    jQuery('.fpcm-external-btn').button({
        icons: {
            primary: "ui-icon-extlink",
        },
        text: true
    });

    jQuery('#fpcm-clear-cache').button({
        icons: {
            primary: "ui-icon-arrowrefresh-1-e",
        },
        text: false
    }).click(function () {
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
        var buttons = [
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
        ];
        fpcmJs.confirmDialog('<p class="fpcm-ui-center">' + fpcmConfirmMessage + '</p>', buttons);
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
                
    jQuery('.fpcm-ui-fileinput-php a').button({
        icons: {
            primary: "ui-icon-plusthick",
        },
        text: true
    }).click(function () {
        jQuery('#fpcm-ui-phpupload-filelist').empty();
        jQuery(this).parent().find('.fpcm-ui-fileinput-select').trigger('click');
        jQuery('.fpcm-ui-fileinput-select').change(function () {
            var uploads = jQuery(this);            
            for (var i=0;i<uploads[0].files.length;i++) {
                fpcmJs.appendHtml('#fpcm-ui-phpupload-filelist', '<tr><td>' + uploads[0].files[i].name +'</td></tr>')
            }
        });
        return false;
    }).parent().children('button.start-upload').button({
        icons: {
            primary: "ui-icon-circle-arrow-e",
        },
        text: true
    }).click(function () {
    }).next('button.cancel-upload').button({
        icons: {
            primary: "ui-icon-cancel",
        },
        text: true
    }).click(function () {
        jQuery('#fpcm-ui-phpupload-filelist').empty();
        jQuery('.fpcm-ui-fileinput-select').empty();
    });

    jQuery('#tabs-options-syscheck').click(function () {
        fpcmJs.systemCheck();
    });
    
    jQuery('.fpcm-updatecheck-manual').click(function () {
        fpcmJs.openManualCheckFrame();
        return false;
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