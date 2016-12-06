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
        fpcm.ui.appendMessage(ajaxResult)

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
        fpcmJs.reloadLogs(workData);        
        fpcm.ui.appendMessage(ajaxResult)

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

        if (workData == 4) {
            fpcm.ui.accordion('.fpcm-accordion-pkgmanager');
        }

    };
    
    this.reloadFiles = function (page) {
        self.showLoader(true);

        fpcmAjax.action   = 'filelist';
        fpcmAjax.query    = 'mode=' + fpcmFmgrMode + (page !== undefined ? '&page=' + page : '');
        fpcmAjax.execDone = 'fpcmJs.reloadFilesDone(fpcmAjax.result);';
        fpcmAjax.get();
        
        return false;
    };
    
    this.reloadFilesDone = function (ajaxResult) {
        fpcmJs.assignHtml("#tabs-files-list-content", ajaxResult);
        fpcmJs.assignButtons();
        fpcm.filemanager.assignButtons();
        var fpcmRFDinterval = setInterval(function(){
            if (jQuery('#fpcm-filelist-images-finished').length == 1) {
                fpcmJs.showLoader(false);
                clearInterval(fpcmRFDinterval);
                fpcmJs.windowResize();
                return false;
            }
        }, 1000);
    };
    
    this.relocate = function (url) {
        window.location.href = url;
    };
    
    this.windowResize = function () {        
        fpcm.ui.prepareMessages();
        jQuery('#fpcm-ui-errorbox').css('top', jQuery(window).height() / 2 - jQuery('#fpcm-ui-errorbox').height() / 2);

        var wrpl        = jQuery('#fpcm-wrapper-left');
        var prof_btn    = jQuery('#fpcm-navigation-profile');
        var wrpl_height = jQuery('body').height() < jQuery(window).height() ? jQuery(window).height() : jQuery('body').height();           

        wrpl.css('min-height', '');
        if (jQuery(window).width() > 800) {
            jQuery('li.fpcm-menu-level1.fpcm-menu-level1-show').show();
            wrpl.css('min-height', wrpl_height);
        }

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
        self.usersActionButtons();
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
    
    this.usersActionButtons = function () {
        jQuery('.fpcm-ui-useractions-diable').click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcm.ui.translate('confirmMessage'))) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }            
        });
                
        jQuery('.fpcm-ui-useractions-enable').click(function () {
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
        fpcmJs.windowResize();
    };
    
    this.startCommentSearch = function (sParams) {
        if (((new Date()).getTime() - fpcmCommentsLastSearch) < 10000) {
            self.addAjaxMassage('error', fpcm.ui.translate('searchWaitMsg'));            
            return false;
        }

        self.showLoader(true);
        
        fpcmAjax.action     = 'comments/search';
        fpcmAjax.data       = sParams;
        fpcmAjax.execDone   = 'fpcmJs.startCommentSearchDone(fpcmAjax.result)';
        fpcmAjax.post();

        fpcmCommentsLastSearch = (new Date()).getTime();
    };
    
    this.startCommentSearchDone = function (ajaxResult) {
        
        fpcmJs.showLoader(false);
        fpcmJs.assignHtml('#tabs-comments-active', ajaxResult);
        noActionButtonAssign = true;
        fpcmJs.assignButtons();
        fpcmJs.initCommentSearch();
        fpcm.ui.assignSelectmenu();
        fpcmJs.windowResize();
    };
    
    this.addAjaxMassage = function (type, message) {

        jQuery('.fpcm-messages').empty();

        fpcmAjax.action     = 'addmsg';
        fpcmAjax.data       = {
            type:type,
            msgtxt:message
        };
        fpcmAjax.execDone   = "fpcmJs.addAjaxMassageDone(fpcmAjax.result)";
        fpcmAjax.post();

    };
    
    this.addAjaxMassageDone = function (ajaxResult) {

        fpcmJs.showLoader(false);
        fpcm.ui.appendMessage(ajaxResult);
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
        fpcmJs.assignButtons();
        fpcmJs.windowResize();
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
        fpcmAjax.reset();
        fpcmAjax.action = 'cronasync';
        fpcmAjax.get();
        fpcmAjax.reset();
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
        
        fpcmAjax.action   = 'session';
        fpcmAjax.execDone = 'var chkres = fpcmAjax.result; fpcmJs.addCheckSessionMessage(fpcmAjax.result);';
        fpcmAjax.get();
        
        return false;
    };
    
    this.addCheckSessionMessage = function(sessionOk) {
        
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
    };
    
    this.loadDashboardContainer = function() {
        fpcmAjax.action   = 'dashboard';
        fpcmAjax.execDone = 'fpcmJs.loadDashboardContainerCallback(fpcmAjax.result);';
        fpcmAjax.get();        
    };
    
    this.loadDashboardContainerCallback = function(resultData) {
        fpcmJs.assignHtml('#fpcm-dashboard-containers', resultData);
        fpcmJs.assignButtons();
    
        jQuery('.fpcm-updatecheck-manual').click(function () {
            fpcmJs.openManualCheckFrame();
            return false;
        });
        
        var fpcmRFDinterval = setInterval(function(){
            if (jQuery('#fpcm-dashboard-finished').length == 1) {
                jQuery('#fpcm-dashboard-containers-loading').remove();
                clearInterval(fpcmRFDinterval);
                fpcmJs.windowResize();
                return false;
            }
        }, 250);
    };
    
    this.execCronjobDemand = function(cronjobId) {
        self.showLoader(true);
        fpcmAjax.action = 'cronasync';
        fpcmAjax.data   = {cjId:cronjobId};
        fpcmAjax.execDone = 'fpcmJs.showLoader(false);';
        fpcmAjax.get();
    };
    
    this.setCronjobInterval = function(cronjobId, cronjobInterval) {
        self.showLoader(true);
        fpcmAjax.action = 'croninterval';
        fpcmAjax.data   = {cjId:cronjobId,interval:cronjobInterval};
        fpcmAjax.execDone = 'fpcmJs.showLoader(false);';
        fpcmAjax.get();
    };

    this.generatePasswdString = function() {
      
        var passwd = generatePassword(12, false, /[\w\d\?\-]/);
        jQuery('#password').val(passwd);
        jQuery('#password_confirm').val(passwd);
        
        return false;
    };
    
    this.initCommentSearch = function() {

        jQuery('#fpcmcommentsopensearch').click(function () {

            fpcm.ui.selectmenu('.fpcm-ui-input-select-commentsearch', {
                width: '100%',
                appendTo: '#fpcm-dialog-comments-search'
            });

            fpcm.ui.datepicker('.fpcm-full-width-date');

            var size = fpcm.ui.getDialogSizes();

            fpcm.ui.dialog({
                id      : 'comments-search',
                dlWidth: size.width,
                resizable: true,
                title    : fpcm.ui.translate('searchHeadline'),
                dlButtons  : [
                    {
                        text: fpcm.ui.translate('searchStart'),
                        icon: "ui-icon-check",                        
                        click: function() {                            
                            var sfields = jQuery('.fpcm-comments-search-input');
                            var sParams = {
                                filter: {}
                            };
                            
                            jQuery.each(sfields, function( key, obj ) {
                                var objVal  = jQuery(obj).val();
                                var objName = jQuery(obj).attr('name');                                
                                sParams.filter[objName] = objVal;
                            });

                            fpcmJs.startCommentSearch(sParams);
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
                dlOnOpen: function( event, ui ) {
                    jQuery('#text').focus();
                }
            });

            return false;
        });

    };
}