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

        if (workData == 4) {
            self.initAccordion('.fpcm-accordion-pkgmanager');
        }

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
        jQuery('#fpcm-ui-errorbox').css('top', jQuery(window).height() / 2 - jQuery('#fpcm-ui-errorbox').height() / 2);
    };
    
    this.windowLoginResize = function () {
        var loginTopPos = (jQuery(window).height() / 2 - jQuery('.fpcm-login-form').height() * 0.5 - jQuery('.fpcm-header').height());
        jQuery('.fpcm-login-form').css('margin-top', loginTopPos);      
    };
    
    this.fixedHeader = function () {
        if (jQuery(window).scrollTop() > 50) {
            jQuery('#fpcm-header').addClass('fpcm-header-fixed');
            jQuery('#fpcm-header-fixed-spacer').show();
        }
        
        if (jQuery(window).scrollTop() < 30) {
            jQuery('#fpcm-header').removeClass('fpcm-header-fixed');
            jQuery('#fpcm-header-fixed-spacer').hide();
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
    
    this.assignSelectmenu = function () {
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
    
    this.startCommentSearch = function (sParams) {
        if (((new Date()).getTime() - fpcmCommentsLastSearch) < 10000) {
            self.addAjaxMassage('error', fpcmSearchWaitMsg);            
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
        fpcmJs.assignSelectmenu();
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
        
        var iframeWidth  = jQuery(window).width() * 0.5;
        var iframeHeight = jQuery(window).height() * 0.75;
        
        jQuery('#fpcm-manualupdate-check').dialog({
            width    : iframeWidth,
            height   : iframeHeight,
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
    
    this.initAccordion = function(elemId) {
        jQuery(elemId).accordion({
            header: "h2",
            heightStyle: "content"
        });  
    }
    
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
    
        jQuery('.fpcm-updatecheck-manual').click(function () {
            fpcmJs.openManualCheckFrame();
            return false;
        });
        
        var fpcmRFDinterval = setInterval(function(){
            if (jQuery('#fpcm-dashboard-finished').length == 1) {
                jQuery('#fpcm-dashboard-containers-loading').remove();
                clearInterval(fpcmRFDinterval);
                return false;
            }
        }, 250);
    };
    
    this.showTemplatePreview = function() {
        
        jQuery('.fpcm-template-tab').click(function () {

            fpcmTemplateId = jQuery(this).data('tpl');
            
            if (fpcmTemplateId == 7) {
                jQuery('#template_buttons').hide();
                jQuery('#article_template_buttons').show();
                return false;
            }
            
            jQuery('#template_buttons').show();            
            jQuery('#article_template_buttons').hide();
            
            if (fpcmTemplateId > 5) {
                jQuery('#showpreview').hide();
                return false;
            }
            
            jQuery('#showpreview').show();
            return false;
        });
        
        jQuery('#showpreview').click(function () {

            fpcmJs.appendHtml('#fpcm-templatepreview-layer', '<iframe id="fpcm-templatepreview-layer-frame" class="fpcm-full-width" src="' + fpcmActionPath + 'system/templatepreview&tid=' + fpcmTemplateId + '"></iframe>');

            jQuery('#fpcm-templatepreview-layer').dialog({
                width    : '75%',
                modal    : true,
                resizable: true,
                title    : fpcmPreviewHeadline,
                buttons  : [
                    {
                        text: fpcmClose,
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                    
                        click: function() {
                            jQuery(this).dialog('close');
                            jQuery('.fpcm-templatepreview-layer-frame').remove();
                        }
                    }                            
                ],
                close: function( event, ui ) {
                    jQuery(this).empty();
                }
            });
            
            return false;
        })
        
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
      
        var passwd = generatePassword(12, false);
        jQuery('#password').val(passwd);
        jQuery('#password_confirm').val(passwd);
        
        return false;
    };
    
    this.initCommentSearch = function() {

        jQuery('#fpcmcommentsopensearch').click(function () {

            jQuery('.fpcm-ui-input-select-commentsearch').selectmenu({
                width: '100%',
                appendTo: '#fpcm-comments-search-dialog'
            });

            jQuery('.fpcm-full-width-date').datepicker({
                dateFormat: "yy-mm-dd",
                firstDay: 1
            });               

            jQuery('#fpcm-comments-search-dialog').dialog({
                width: 700,
                height: 350,
                modal    : true,
                resizable: true,
                title    : fpcmSearchHeadline,
                buttons  : [
                    {
                        text: fpcmSearchStart,
                        icons: {
                            primary: "ui-icon-check"            
                        },                        
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

    };
}