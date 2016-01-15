/**
 * FanPress CM javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
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
        
        fpcmAjax.action   = 'cache';
        fpcmAjax.execDone = 'fpcmJs.clearCacheDone(fpcmAjax.result)';
        fpcmAjax.get();
        
        return false;        
    };    
    
    this.clearCacheDone = function (ajaxResult) {
        
        fpcmJs.showLoader(false);
        fpcmJs.addAjaxMassage('notice', ajaxResult);      
    };
    
    this.clearLogs = function(id) {
        self.showLoader(true);
        
        var logType = id.split('_');
        
        fpcmAjax.action   = 'logs/clear';
        fpcmAjax.query    = 'log=' + logType[1];
        fpcmAjax.workData = id;
        fpcmAjax.execDone = "fpcmJs.clearLogsDone(fpcmAjax.result, fpcmAjax.workData);";
        fpcmAjax.get();
        
        return false;
    };
    
    this.clearLogsDone = function(ajaxResult, workData) {
        
        fpcmJs.showLoader(false);
        jQuery('.fpcm-messages').remove();
        fpcmJs.appendHtml('#fpcm-body', ajaxResult);
        fpcmJs.messagesCenter();
        fpcmJs.reloadLogs(workData);

    };
    
    this.reloadLogs = function(id) {
        self.showLoader(true);
        
        var logType = id.split('_');

        fpcmAjax.action   = 'logs/reload';
        fpcmAjax.query    = 'log=' + logType[1];
        fpcmAjax.workData = logType[1];
        fpcmAjax.execDone = "fpcmJs.reloadLogsDone(fpcmAjax.result, fpcmAjax.workData)";
        fpcmAjax.get();
        
        return false;
    };
    
    this.reloadLogsDone = function(ajaxResult, workData) {
        
        fpcmJs.showLoader(false);
        fpcmJs.assignHtml('#fpcm-logcontent'+ workData, ajaxResult);

    };
    
    this.reloadFiles = function () {
        self.showLoader(true);

        fpcmAjax.action   = 'filelist';
        fpcmAjax.query    = 'mode=' + fpcmFmgrMode;
        fpcmAjax.execDone = 'fpcmJs.reloadFilesDone(fpcmAjax.result);';
        fpcmAjax.get();
        
        return false;
    };
    
    this.reloadFilesDone = function (ajaxResult) {
        fpcmJs.assignHtml("#tabs-files-list-content", ajaxResult);
        fpcmJs.assignButtons();
        fpcmFilemgr.assignButtons();
        var fpcmRFDinterval = setInterval(function(){
            if (jQuery('#fpcm-filelist-images-finished').length == 1) {
                fpcmJs.showLoader(false);
                clearInterval(fpcmRFDinterval);
                return false;
            }
        }, 1000);
    };
    
    this.relocate = function (url) {
        window.location.href = url;
    };
    
    this.messagesCenter = function () {
        var messagesTopPos  = (jQuery(window).height() / 2 - jQuery('.fpcm-messages').height() * 0.5);
        var messagesLeftPos = (jQuery(window).width() / 2 - jQuery('.fpcm-messages').width() * 0.5);
        jQuery('.fpcm-messages').css('top', messagesTopPos);
        jQuery('.fpcm-messages').css('left', messagesLeftPos);        
        jQuery('.fpcm-messages.fpcm-messages-fadeout').delay(3000).fadeOut('slow');
        jQuery('.fpcm-messages div.fpcm-message-box').draggable({
            opacity: 0.5,
            cursor: 'move'
        });
    };
    
    this.windowResize = function () {        
        self.messagesCenter();
        self.initMenu();
        
        jQuery('#fpcm-ui-errorbox').css('top', jQuery(window).height() / 2 - jQuery('#fpcm-ui-errorbox').height() / 2);
    };
    
    this.initMenu = function () {
        
        if (jQuery(window).width() <= 1040) {
            jQuery('.fpcm-menu').menu({
                position: {
                    my: "left top",
                    at: "left+10 top"
                }
            });
            jQuery('.fpcm-admin-navi .fpcm-submenu .ui-menu-item').width(jQuery('.fpcm-menu').width() - 40);
        } else {
            jQuery('.fpcm-menu').menu({
                position: {
                    my: "left top",
                    at: "right-5 top"
                }
            });            
        }
    };
    
    this.windowLoginResize = function () {
        var loginTopPos = (jQuery(window).height() / 2 - jQuery('.fpcm-login-form').height() * 0.5 - jQuery('.fpcm-header').height());
        jQuery('.fpcm-login-form').css('margin-top', loginTopPos);      
    };
    
    this.fixedHeader = function () {
        if (jQuery(window).scrollTop() > 60) {
            jQuery('#fpcm-header').addClass('fpcm-header-fixed');
            jQuery('#fpcm-header-fixed-spacer').addClass('fpcm-header-fixed');
        }
        
        if (jQuery(window).scrollTop() < 30) {
            jQuery('#fpcm-header').removeClass('fpcm-header-fixed');
            jQuery('#fpcm-header-fixed-spacer').removeClass('fpcm-header-fixed');
        }
    };
    
    this.hideNavigation = function () {
        if (jQuery('.fpcm-menu').hasClass('fpcm-navigation-small')) {
            jQuery('.fpcm-navigation-hide span').removeClass('fa-rotate-180');
            jQuery('.fpcm-menu').removeClass('fpcm-navigation-small');
            jQuery('.fpcm-admin-navi').removeClass('fpcm-navigation-small');
            jQuery('.fpcm-wrapper').removeClass('fpcm-wrapper-small-navigation');
            jQuery('.fpcm-menu .fpcm-nav-link-descr-main').show();
        } else {
            jQuery('.fpcm-menu .fpcm-nav-link-descr-main').hide();
            jQuery('.fpcm-menu').addClass('fpcm-navigation-small');
            jQuery('.fpcm-admin-navi').addClass('fpcm-navigation-small');
            jQuery('.fpcm-wrapper').addClass('fpcm-wrapper-small-navigation');
            jQuery('.fpcm-navigation-hide span').addClass('fa-rotate-180');
        }        
    };
    
    this.assignButtons = function () {
        jQuery('.fpcm-ui-button').button();
        jQuery('.fpcm-ui-buttonset').buttonset();
        
        self.actionButtonsGenreal();
        self.assignBlankIconButton();
        self.assignCheckboxes();
        self.assignCheckboxesSub();
        self.articleActionsOkButton();
        self.commentActionButtons();
        self.usersActionButtons();
        self.moduleActionButtons();
        self.assignDeleteButton();
        self.pagerButtons();
        
        noActionButtonAssign = false;
    };
    
    this.assignCheckboxes = function () {
        jQuery('#fpcmselectall').click(function(){
            jQuery('.fpcm-select-allsub').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox').prop('checked', false);
        });
        jQuery('#fpcmselectalldraft').click(function(){
            jQuery('.fpcm-select-allsub-draft').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox-draft').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox-draft').prop('checked', false);
        });
        jQuery('#fpcmselectalltrash').click(function(){
            jQuery('.fpcm-select-allsub-trash').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox-trash').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox-trash').prop('checked', false);
        });
        jQuery('#fpcmselectallrevisions').click(function(){
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectboxrevisions').prop('checked', true);
            else
                jQuery('.fpcm-list-selectboxrevisions').prop('checked', false);
        });
    };
    
    this.assignCheckboxesSub = function () {
        jQuery('.fpcm-select-allsub').click(function(){
            var subValue = jQuery(this).val();
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox-sub' + subValue).prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox-sub' + subValue).prop('checked', false);
        });
    };

    this.assignDeleteButton = function () {
        
        if (noDeleteButtonAssign) return false;
        
        jQuery('.fpcm-delete-btn').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }
        });
        
        noDeleteButtonAssign = true;
    };
    
    this.assignBlankIconButton = function () {
        jQuery('.fpcm-ui-button-blank').button({
            icons: {
                primary: "ui-icon-blank",
            },
            text: false
        });        
    };
    
    this.articleActionsOkButton = function () {
        if (noActionButtonAssign) return false;
        
        jQuery('.fpcm-ui-articleactions-ok').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }
            
            if (jQuery('#actionsaction').val() == 'newtweet') {
                
                var articleIds = [];
                jQuery('.fpcm-list-selectbox:checked').map(function (idx, item) {
                    articleIds.push(jQuery(item).val());
                });

                if (articleIds.length == 0) {
                    fpcmJs.showLoader(false);
                    return false;
                }

                fpcmAjax.action     = 'articles/tweet';
                fpcmAjax.data       = {ids: JSON.stringify(articleIds)};
                fpcmAjax.execDone   = "fpcmJs.showLoader(false);result = JSON.parse(fpcmAjax.result);if (result.notice != 0) {fpcmJs.addAjaxMassage('notice', result.notice);}if (result.error != 0) {fpcmJs.addAjaxMassage('error', result.error);}jQuery('#actionsaction').prop('selectedIndex',0);jQuery('#actionsaction').selectmenu('refresh');";
                fpcmAjax.async      = false;
                fpcmAjax.post();
                fpcmAjax.reset();

                return false;
            }
        });
    };
    
    this.commentActionButtons = function () {        
        jQuery('.fpcm-ui-commentaction').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }            
        });
    };
    
    this.usersActionButtons = function () {
        jQuery('.fpcm-ui-useractions-diable').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }            
        });
                
        jQuery('.fpcm-ui-useractions-enable').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcmConfirmMessage)) {
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
            self.addAjaxMassage('error', fpcmArticlesSearchWaitMsg);            
            return false;
        }

        self.showLoader(true);
        
        fpcmAjax.action     = 'articles/search';
        fpcmAjax.data       = sParams;
        fpcmAjax.execDone   = 'fpcmJs.startSearchDone(fpcmAjax.result)';
        fpcmAjax.post();
        
        fpcmArticlesLastSearch = (new Date()).getTime();
    };
    
    this.startSearchDone = function (ajaxResult) {
        
        fpcmJs.showLoader(false);
        fpcmJs.assignHtml('#tabs-article-list', ajaxResult);
        noActionButtonAssign = true;
        fpcmJs.assignButtons();
    };
    
    this.addAjaxMassage = function (type, message, fadeOut) {
        if (typeof fadeOut == 'undefined') fadeOut = true;

        fpcmAjax.action     = 'addmsg';
        fpcmAjax.data       = {type:type,msgtxt:message};
        fpcmAjax.execDone   = "fpcmJs.addAjaxMassageDone(fpcmAjax.result, fpcmAjax.workData)";
        fpcmAjax.workData   = fadeOut;
        fpcmAjax.post();
    };
    
    this.addAjaxMassageDone = function (ajaxResult, workData) {
        fpcmJs.showLoader(false);
        jQuery('.fpcm-messages').remove();
        fpcmJs.appendHtml('#fpcm-body', ajaxResult);
        if (!workData) {
            jQuery('.fpcm-messages').removeClass('fpcm-messages-fadeout');
        };
        fpcmJs.messagesCenter();
    };
    
    this.systemCheck = function () {
        fpcmJs.showLoader(true);
        fpcmAjax.action = 'syscheck';
        fpcmAjax.execDone = 'fpcmJs.systemCheckDone(fpcmAjax.result);';
        fpcmAjax.get();
    };
    
    this.systemCheckDone = function (ajaxResult) {       
        fpcmJs.showLoader(false);
        fpcmJs.assignHtml("#tabs-options-check", ajaxResult);
    };
    
    this.actionButtonsGenreal = function () {
        jQuery('.fpcm-ui-actions-genreal').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }            
        });
    };
    
    this.openManualCheckFrame = function () {
        jQuery('#fpcm-manualupdate-check').dialog({
            width    : 500,
            height   : 500,
            modal    : true,
            resizable: true,
            title    : fpcmManualCheckHeadline,
            buttons  : [
                {
                    text: fpcmNewWindow,
                    icons: {
                        primary: "ui-icon-extlink"            
                    },                    
                    click: function() {
                        window.open(fpcmManualCheckUrl);
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
            open: function (event, ui) {
                jQuery(this).empty();
                self.appendHtml(this, '<iframe class="fpcm-full-width" style="height:100%;"  src="' + fpcmManualCheckUrl + '"></iframe>');
            },
            close: function( event, ui ) {
                jQuery(this).empty();
            }
        });
    };
    
    this.runCronsAsync = function () {
        if (typeof fpcmCronAsyncDiabled != 'undefined' && fpcmCronAsyncDiabled) return;
        fpcmAjax.reset();
        fpcmAjax.action = 'cronasync';
        fpcmAjax.get();
        fpcmAjax.reset();
    };
    
    this.confirmDialog = function (content, buttons, title, id) {

        if (typeof title == 'undefined') title = '';
        if (typeof id == 'undefined') id = (new Date()).getTime();

        var dialogId = 'fpcm-confirm-dialog-'+ id;        
        
        self.appendHtml('#fpcm-body', '<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="' + dialogId + '">' + content + '</div>');
        jQuery('#' + dialogId).dialog({
            width    : 500,
            modal    : true,
            resizable: false,
            title    : title,
            buttons  : buttons,
            close: function() {
                jQuery(this).remove();
                self.showLoader(false);
            }
        });
    };
    
    this.permissionButtonIcons = function() {
        jQuery('.fpcm-ui-buttonset-permissions').find('input[type="checkbox"]').button({
            icons: {
                primary: "ui-icon-check"
            },
            text: false
        });
    };
    
    this.pagerButtons = function() {
        
        jQuery('#pageSelect').selectmenu({
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
    
    this.initInputShadow = function() {
        jQuery('.fpcm-ui-input-wrapper input[type=text]').focus(function () {
            jQuery(this).parent().parent().addClass('fpcm-ui-input-wrapper-hover');
        }).blur(function () {
            jQuery(this).parent().parent().removeClass('fpcm-ui-input-wrapper-hover');
        });

        jQuery('.fpcm-ui-input-wrapper input[type=password]').focus(function () {
            jQuery(this).parent().parent().addClass('fpcm-ui-input-wrapper-hover');
        }).blur(function () {
            jQuery(this).parent().parent().removeClass('fpcm-ui-input-wrapper-hover');
        });

        jQuery('.fpcm-ui-input-wrapper textarea').focus(function () {
            jQuery(this).parent().parent().addClass('fpcm-ui-input-wrapper-hover');
        }).blur(function () {
            jQuery(this).parent().parent().removeClass('fpcm-ui-input-wrapper-hover');
        });  
    };
    
    this.checkSession = function() {
        
        if (!fpcmSessionCheckEnabled) {
            return false;
        }
        
        fpcmAjax.action   = 'session';
        fpcmAjax.execDone = 'var chkres = fpcmAjax.result; fpcmJs.addCheckSessionMessage(fpcmAjax.result);';
        fpcmAjax.get();
        
        return false;
    };
    
    this.addCheckSessionMessage = function(sessionOk) {
        
        fpcmSessionCheckEnabled = false;
        if (sessionOk == '0') {
            var buttons = [
                {
                    text: fpcmYes,
                    icons: { primary: "ui-icon-check" },                    
                    click: function() {
                        fpcmJs.relocate(fpcmActionPath + 'system/login');
                        jQuery(this).dialog('close');
                    }
                },
                {
                    text: fpcmNo,
                    icons: { primary: "ui-icon-closethick" },
                    click: function() {
                        fpcmSessionCheckEnabled = true;
                        jQuery(this).dialog('close');
                    }
                }
            ];

            self.confirmDialog('<p class="fpcm-ui-center">' + fpcmSessionCheckMsg + '</p>', buttons, '', 'sessioncheck');
        }        
    };
    
    this.loadDashboardContainer = function() {
        fpcmAjax.action   = 'dashboard';
        fpcmAjax.execDone = 'fpcmJs.loadDashboardContainerCallback(fpcmAjax.result);';
        fpcmAjax.get();
        
    };
    
    this.loadDashboardContainerCallback = function(resultData) {
        fpcmJs.assignHtml('#fpcm-dashboard-containers', resultData);
        fpcmJs.assignButtons();
        
        var fpcmRFDinterval = setInterval(function(){
            if (jQuery('#fpcm-dashboard-finished').length == 1) {
                jQuery('#fpcm-dashboard-containers-loading').remove();
                clearInterval(fpcmRFDinterval);
                return false;
            }
        }, 250);
    };
}