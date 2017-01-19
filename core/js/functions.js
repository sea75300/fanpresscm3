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
    
    this.spinJsOpts = {
        lines: 15,
        length: 5,
        width: 8,
        radius: 20,
        corners: 1,
        rotate: 0,
        direction: 1,
        color: '#2E6E9E',
        speed: 0.8,
        trail: 50,
        shadow: false,
        hwaccel: true,
        className: 'spinner',
        zIndex: 100,
        top: '50%',
        left: '50%'
    };
    
    this.spinner = new Spinner(self.spinJsOpts);
    
    this.showLoader = function(show) {
        return (show) ? self.spinner.spin(document.getElementById('fpcm-body')) : self.spinner.stop();
    };    
    
    this.clearCache = function () {
        
        self.showLoader(true);

        fpcm.ajax.get('cache', {
            execDone: function () {
                fpcmJs.showLoader(false);
                fpcm.ui.appendMessage(fpcm.ajax.getResult('cache'))
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
        self.commentActionButtons();
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
                    jQuery(articleActions.doActionBtn).removeClass('fpcm-loader');
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
    
    this.commentActionButtons = function () {        
        jQuery('.fpcm-ui-commentaction').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcm.ui.translate('confirmMessage'))) {
                jQuery(this).addClass('fpcm-noloader');
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
                fpcmJs.assignHtml('#tabs-article-list', fpcm.ajax.getResult('articles/search'));
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
                fpcmJs.assignHtml("#tabs-options-check", fpcm.ajax.getResult('syscheck'));
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
                self.appendHtml(this, '<iframe class="fpcm-full-width" style="height:100%;"  src="' + fpcmManualCheckUrl + '"></iframe>');
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
        jQuery('#' + elemId).focus();
    };
    
    this.assignHtml = function(elemId, data) {
        jQuery(elemId).html(data);
    };
    
    this.assignText = function(elemId, data) {
        jQuery(elemId).text(data);
    };
    
    this.appendHtml = function(elemId, data) {
        jQuery(elemId).append(data);
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