/**
 * FanPress CM javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var noActionButtonAssign = false;
var noDeleteButtonAssign = false;

var fpcmJs = function () {
    
    var self = this;
    
    this.showLoader = function(show, addtext) {

        if (!show) {
            jQuery('#fpcm-loader').fadeOut('fast', function(){
                jQuery(this).remove();
            });
            return false;
        }

        fpcm.ui.appendHtml('#fpcm-body', '<div class="fpcm-loader" id="fpcm-loader" style="' + window.spinnerParams + '"><span class="fa-stack ' + (addtext ? 'fa-lg' : 'fa-2x') + '"><span class="fa fa-square fa-stack-2x"></span><span class="fa fa-spinner fa-spin fa-fw fa-stack-1x fa-inverse"></span></span> ' + (addtext ? addtext : '') + '</div>');

        jQuery('#fpcm-loader').css('top',  ( parseInt( (jQuery(window).height() * 0.5) - (jQuery('#fpcm-loader').height() / 2) ) + 'px' ) )
                              .css('left', ( parseInt( (jQuery(window).width() * 0.5) - (jQuery('#fpcm-loader').width() / 2) ) + 'px' ) )
                              .fadeIn('fast');

        return true;
    };    
    
    this.clearCache = function () {
        
        self.showLoader(true);

        fpcm.ajax.get('cache', {
            execDone: function () {
                fpcmJs.showLoader(false);
                fpcm.ui.appendMessage(fpcm.ajax.getResult('cache'));
            }
        });
        
        return false;        
    };
    
    this.relocate = function (url) {
        window.location.href = url;
    };
    
    this.windowResize = function () {
        console.warn('Using "fpcmJs.windowResize" class is deprecated as of version 3.5! Use "fpcm.ui.resize" instead.');
        fpcm.ui.resize();
    };
    
    this.assignButtons = function () {

        fpcm.ui.controlgroup('.fpcm-ui-buttonset');
        fpcm.ui.controlgroup('.fpcm-buttons.fpcm-ui-list-buttons', {
            onlyVisible: true
        });

        fpcm.ui.controlgroup('.fpcm-buttons div.fpcm-ui-margin-center', {
            onlyVisible: true
        });

        fpcm.ui.button('.fpcm-ui-button');
        fpcm.ui.actionButtonsGenreal();
        fpcm.ui.assignBlankIconButton();
        fpcm.ui.assignCheckboxes();
        fpcm.ui.assignCheckboxesSub();
        self.articleActionsOkButton();
        self.moduleActionButtons();
        self.assignDeleteButton();
        self.pagerButtons();
        
        noActionButtonAssign = false;
    };

    this.assignDeleteButton = function () {
        
        if (noDeleteButtonAssign) return false;
        
        jQuery('.fpcm-delete-btn').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcm.ui.translate('confirmMessage'))) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }
        });
        
        noDeleteButtonAssign = true;
    };
    
    this.articleActionsOkButton = function () {

        if (noActionButtonAssign) return false;

        var articleActions = {
            newtweet: 'newtweet',
            doActionBtn: '#btnDoAction'
        }
        
        fpcm.ui.selectmenu('#actionsaction', {
            change: function( event, ui ) {

                if (ui.item.value == articleActions.newtweet) {
                    fpcm.ui.removeLoaderClass(articleActions.doActionBtn);
                }
                else if (!jQuery(articleActions.doActionBtn).hasClass('fpcm-loader')) {
                    jQuery(articleActions.doActionBtn).addClass('fpcm-loader');
                }

            }
        });
        
        jQuery('.fpcm-ui-articleactions-ok').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcm.ui.translate('confirmMessage'))) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }

            if (jQuery('#actionsaction').val() == articleActions.newtweet) {
                fpcm.articlelist.articleActionsTweet();
                return false;
            }
        });
    };
    
    this.moduleActionButtons = function () {        
        if (typeof fpcmModulelist == 'undefined') return false;
        return fpcmModulelist.actionButtons();
    };
    
    this.startSearch = function (sParams) {
        if (((new Date()).getTime() - fpcmArticlesLastSearch) < 10000) {
            self.addAjaxMassage('error', fpcm.ui.translate('searchWaitMsg'));
            return false;
        }

        self.showLoader(true);

        fpcm.ajax.post('articles/search', {
            data: sParams,
            execDone: function () {
                fpcmJs.showLoader(false);
                fpcm.ui.assignHtml('#tabs-article-list', fpcm.ajax.getResult('articles/search'));
                window.noActionButtonAssign = true;
                fpcmJs.assignButtons();
                fpcm.ui.resize();
            }
        });

        fpcmArticlesLastSearch = (new Date()).getTime();
    };
    
    this.addAjaxMassage = function (type, message) {

        jQuery('.fpcm-messages').empty();

        fpcm.ajax.post('addmsg', {
            data: {
                type  : type,
                msgtxt: message
            },
            execDone: function () {
                fpcmJs.showLoader(false);
                fpcm.ui.appendMessage(fpcm.ajax.getResult('addmsg'));
            }
        });

    };
    
    this.systemCheck = function () {
        fpcmJs.showLoader(true);
        fpcm.ajax.get('syscheck', {
            execDone: function () {
                fpcmJs.showLoader(false);
                fpcm.ui.assignHtml("#tabs-options-check", fpcm.ajax.getResult('syscheck'));
                fpcmJs.assignButtons();
                fpcm.ui.resize();
            }
        });
        
    };
    
    this.openManualCheckFrame = function () {

        var size = fpcm.ui.getDialogSizes();

        fpcm.ui.dialog({
            id         : 'manualupdate-check',
            dlWidth    : size.width,
            dlHeight   : size.height,
            resizable  : true,
            title      : fpcmManualCheckHeadline,
            dlButtons  : [
                {
                    text: fpcm.ui.translate('newWindow'),
                    icon: "ui-icon-extlink",                    
                    click: function() {
                        window.open(fpcmManualCheckUrl);
                        jQuery(this).dialog('close');
                    }
                },
                {
                    text: fpcm.ui.translate('close'),
                    icon: "ui-icon-closethick",                    
                    click: function() {
                        jQuery(this).dialog('close');
                    }
                }
            ],
            dlOnOpen: function (event, ui) {
                jQuery(this).empty();
                fpcm.ui.appendHtml(this, '<iframe class="fpcm-full-width" style="height:100%;"  src="' + fpcmManualCheckUrl + '"></iframe>');
            },
            dlOnClose: function( event, ui ) {
                jQuery(this).empty();
            }
        });
    };
    
    this.runCronsAsync = function () {
        if (typeof fpcmCronAsyncDiabled != 'undefined' && fpcmCronAsyncDiabled) return;
        fpcm.ajax.get('cronasync');
    };
    
    this.pagerButtons = function() {

        fpcm.ui.selectmenu('#pageSelect', {
            select: function( event, ui ) {
                if (ui.item.value == '1') {
                    window.location.href = fpcmActionPath + fpcmCurrentModule;
                    return true;
                }
                window.location.href = fpcmActionPath + fpcmCurrentModule + '&page=' + ui.item.value;
            }
        });
        
    };
    
    this.setFocus = function(elemId) {
        console.warn('Using "fpcmJs.setFocus" class is deprecated as of version 3.5! Use "fpcm.ui.setFocus" instead.');
        fpcm.ui.setFocus(elemId);
    };
    
    this.assignHtml = function(elemId, data) {
        console.warn('Using "fpcmJs.assignHtml" class is deprecated as of version 3.5! Use "fpcm.ui.assignHtml" instead.');
        fpcm.ui.assignHtml(elemId, data);
    };
    
    this.assignText = function(elemId, data) {
        console.warn('Using "fpcmJs.assignText" class is deprecated as of version 3.5! Use "fpcm.ui.assignText" instead.');
        fpcm.ui.assignText(elemId, data);
    };
    
    this.appendHtml = function(elemId, data) {
        console.warn('Using "fpcmJs.appendHtml" class is deprecated as of version 3.5! Use "fpcm.ui.appendHtml" instead.');
        fpcm.ui.appendHtml(elemId, data);
    };
    
    this.checkSession = function() {
        
        if (!fpcmSessionCheckEnabled) {
            return false;
        }

        fpcm.ajax.exec('session', {
            execDone: function() {
                var sessionOk = fpcm.ajax.getResult('session');
                fpcmSessionCheckEnabled = false;
                if (sessionOk == '0') {
                    fpcm.ui.dialog({
                        content: fpcm.ui.translate('sessionCheckMsg'),
                        dlButtons: buttons = [
                            {
                                text: fpcm.ui.translate('yes'),
                                icon: "ui-icon-check",
                                click: function() {
                                    fpcmJs.relocate(fpcmActionPath + 'system/login');
                                    jQuery(this).dialog('close');
                                }
                            },
                            {
                                text: fpcm.ui.translate('no'),
                                icon: "ui-icon-closethick",
                                click: function() {
                                    fpcmSessionCheckEnabled = true;
                                    jQuery(this).dialog('close');
                                }
                            }
                        ],
                        id: 'sessioncheck'
                    });
                }        
            }
        });
        
        return false;
    };

    this.generatePasswdString = function() {
      
        var passwd = generatePassword(12, false, /[\w\d\?\-]/);
        jQuery('#password').val(passwd);
        jQuery('#password_confirm').val(passwd);
        
        return false;
    };

}