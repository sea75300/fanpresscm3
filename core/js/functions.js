/**
 * FanPress CM javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var noActionButtonAssign = false;

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
        fpcmAjax.execDone = 'fpcmJs.showLoader(false);fpcmJs.addAjaxMassage(\'notice\', fpcmAjax.result); ';
        fpcmAjax.get();
        
        return false;        
    };
    
    this.clearLogs = function(id) {
        self.showLoader(true);
        
        var logType = id.split('_');
        
        fpcmAjax.action   = 'logs/clear';
        fpcmAjax.query    = 'log=' + logType[1];
        fpcmAjax.workData = id;
        fpcmAjax.execDone = "fpcmJs.showLoader(false);jQuery('.fpcm-messages').remove();fpcmJs.appendHtml('#fpcm-body', fpcmAjax.result);fpcmJs.messagesCenter();fpcmJs.reloadLogs(fpcmAjax.workData);";
        fpcmAjax.get();
        
        return false;
    };
    
    this.reloadLogs = function(id) {
        self.showLoader(true);
        
        var logType = id.split('_');

        fpcmAjax.action   = 'logs/reload';
        fpcmAjax.query    = 'log=' + logType[1];
        fpcmAjax.workData = logType[1];
        fpcmAjax.execDone = "fpcmJs.showLoader(false);fpcmJs.assignHtml('#fpcm-logcontent'+ fpcmAjax.workData, fpcmAjax.result);";
        fpcmAjax.get();
        
        return false;
    };
    
    this.reloadFiles = function () {
        self.showLoader(true);

        fpcmAjax.action   = 'filelist';
        fpcmAjax.query    = 'mode=' + fpcmFmgrMode;
        fpcmAjax.execDone = 'fpcmJs.showLoader(false);fpcmJs.assignHtml("#tabs-files-list", fpcmAjax.result);fpcmJs.assignButtons();';
        fpcmAjax.get();
        
        return false;
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
                position: { my: "left top", at: "left+10 top" }
            });
            jQuery('.fpcm-admin-navi .fpcm-submenu .ui-menu-item').width(jQuery('.fpcm-menu').width() - 40);
        } else {
            jQuery('.fpcm-menu').menu({
                position: { my: "left top", at: "right-5 top" }
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
        
        self.actionButtonsGenreal();
        self.assignSaveButton();
        self.assignNewButton();
        self.assignEditButton();
        self.assignCheckboxes();
        self.assignCheckboxesSub();
        self.articleActionsOkButton();
        self.commentActionButtons();
        self.usersActionButtons();
        self.filemanagerButtons();
        self.filemanagerInsertButtons();
        self.moduleActionButtons();
        self.assignDeleteButton();
        self.pagerButtons();
        
        noActionButtonAssign = false;
    };
    
    this.setFileManagerIconButtons = function () {
        jQuery('.fpcm-filelist-link-thumb').button({
            icons: {
                primary: "ui-icon-newwin"
            },
            text: false        
        }).next().button({
            icons: {
                primary: "ui-icon-arrow-4-diag"
            },
            text: false        
        }).next().button({
            icons: {
                primary: "ui-icon-circle-zoomin"
            },
            text: false        
        }).next().button({
            icons: {
                primary: "ui-icon-image"
            },
            text: false        
        });
        
        jQuery('.fpcm-filelist-articleimage').button({
            icons: {
                primary: "ui-icon-image"
            },
            text: false        
        });
    };
    
    this.filemanagerButtons = function () {
        jQuery('.fpcm-filemanager-buttons #btnRenameFiles').button({
            icons: {
                primary: "ui-icon-pencil",
            },
            text: true
        }).click(function () {
            if (typeof fpcmFmgrNewName != 'undefined') {
                var newName = prompt(fpcmFmgrNewName, '');
                if (!newName || newName == '') {
                    jQuery(this).addClass('fpcm-noloader');
                    return false;
                }            
                jQuery('#newfilename').val(newName);                
            }
            
        });
        
        jQuery('.fpcm-filemanager-buttons #btnCreateThumbs').button({
            icons: {
                primary: "ui-icon-image",
            },
            text: true
        }).click(function () {            
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }
        });
        
        self.filemanagerDeleteCheckboxes();
    };
    
    this.filemanagerInsertButtons = function () {
        jQuery('.fpcm-filelist-tinymce-thumb').click(function () {
            var url   = jQuery(this).attr('href');
            var title = jQuery(this).attr('imgtxt');  

            if (fpcmEditorType == 1) {
                if (parent.fileOpenMode == 1) {
                    parent.document.getElementById('linksurl').value  = url;
                    parent.document.getElementById('linkstext').value = title;
                }            
                if (parent.fileOpenMode == 2) {
                    parent.document.getElementById('imagespath').value = url;
                    parent.document.getElementById('imagesalt').value  = title;                
                }

                window.parent.jQuery("#fpcm-editor-html-filemanager").dialog('close');
                window.parent.jQuery('#fpcm-editor-html-filemanager').empty();
            } else {
                top.tinymce.activeEditor.windowManager.getParams().oninsert(url, { alt: title, text: title });
                top.tinymce.activeEditor.windowManager.close();
            }

            return false;
        });

        jQuery('.fpcm-filelist-tinymce-full').click(function () {
            var url   = jQuery(this).attr('href');
            var title = jQuery(this).attr('imgtxt');

            if (fpcmEditorType == 1) {
                if (parent.fileOpenMode == 1) {
                    parent.document.getElementById('linksurl').value  = url;
                    parent.document.getElementById('linkstext').value = title;
                }            
                if (parent.fileOpenMode == 2) {
                    parent.document.getElementById('imagespath').value = url;
                    parent.document.getElementById('imagesalt').value  = title;
                }

                window.parent.jQuery("#fpcm-editor-html-filemanager").dialog('close');
                window.parent.jQuery('#fpcm-editor-html-filemanager').empty();
            } else {
                top.tinymce.activeEditor.windowManager.getParams().oninsert(url, { alt: title, text: title });
                top.tinymce.activeEditor.windowManager.close();
            }

            return false;
        });

        jQuery('.fpcm-filelist-articleimage').click(function () {
            var url   = jQuery(this).attr('href');

            parent.document.getElementById('articleimagepath').value  = url;

            if (fpcmEditorType == 1) {
                window.parent.jQuery("#fpcm-editor-html-filemanager").dialog('close');
                window.parent.jQuery('#fpcm-editor-html-filemanager').empty();
            } else {
                top.tinymce.activeEditor.windowManager.close();
            }

            return false;
        });
    };
    
    this.assignCheckboxes = function () {
        jQuery('#fpcmselectall').click(function(){
            jQuery('.fpcm-select-allsub').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox').prop('checked', false);
            
            self.filemanagerDeleteCheckboxes();
        });
        jQuery('#fpcmselectalldraft').click(function(){
            jQuery('.fpcm-select-allsub').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox').prop('checked', false);
        });
        jQuery('#fpcmselectalltrash').click(function(){
            jQuery('.fpcm-select-allsub').prop('checked', false);
            if (jQuery(this).prop('checked'))        
                jQuery('.fpcm-list-selectbox').prop('checked', true);
            else
                jQuery('.fpcm-list-selectbox').prop('checked', false);
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
        jQuery('.fpcm-delete-btn').button({
            icons: {
                primary: "ui-icon-trash",
            },
            text: true
        }).click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }
        });        
    };
    
    this.assignNewButton = function () {
        jQuery('.fpcm-new-btn').button({
            icons: {
                primary: "ui-icon-document",
            },
            text: true
        });
    };
    
    this.assignSaveButton = function () {
        jQuery('.fpcm-save-btn').button({
            icons: {
                primary: "ui-icon-disk",
            },
            text: true
        });        
    };
    
    this.assignEditButton = function () {
        jQuery('.fpcm-ui-button-edit').button({
            icons: {
                primary: "ui-icon-pencil",
            },
            text: false
        });        
    };
    
    this.articleActionsOkButton = function () {
        if (noActionButtonAssign) return false;
        
        jQuery('.fpcm-ui-articleactions-ok').button({
            icons: {
                primary: "ui-icon-check",
            },
            text: true
        }).click(function () {
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
        
        jQuery('.fpcm-ui-commentaction-spam').button({
            icons: {
                primary: "ui-icon-flag",
            },
            text: true
        });
        jQuery('.fpcm-ui-commentaction-approve').button({
            icons: {
                primary: "ui-icon-check",
            },
            text: true
        });
        jQuery('.fpcm-ui-commentaction-private').button({
            icons: {
                primary: "ui-icon-radio-off",
            },
            text: true
        });
    };
    
    this.usersActionButtons = function () {
        jQuery('.fpcm-ui-useractions-diable').button({
            icons: {
                primary: "ui-icon-radio-off",
            },
            text: true
        }).click(function () {
            if (jQuery(this).hasClass('fpcm-noloader')) jQuery(this).removeClass('fpcm-noloader');
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }            
        });
                
        jQuery('.fpcm-ui-useractions-enable').button({
            icons: {
                primary: "ui-icon-radio-on",
            },
            text: true
        }).click(function () {
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
        fpcmAjax.execDone   = "fpcmJs.showLoader(false);fpcmJs.assignHtml('#tabs-article-list', fpcmAjax.result);noActionButtonAssign = true;fpcmJs.assignButtons();jQuery('.fpcm-articlelist-openlink').button({icons:{primary:'ui-icon-circle-triangle-e'},text:false});";
        fpcmAjax.post();
        
        fpcmArticlesLastSearch = (new Date()).getTime();
    };
    
    this.addAjaxMassage = function (type, message, fadeOut) {
        if (typeof fadeOut == 'undefined') fadeOut = true;

        fpcmAjax.action     = 'addmsg';
        fpcmAjax.data       = {type:type,msgtxt:message};
        fpcmAjax.execDone   = "fpcmJs.showLoader(false);jQuery('.fpcm-messages').remove();fpcmJs.appendHtml('#fpcm-body', fpcmAjax.result);if (!fpcmAjax.workData) {jQuery('.fpcm-messages').removeClass('fpcm-messages-fadeout');};fpcmJs.messagesCenter();";
        fpcmAjax.workData   = fadeOut;
        fpcmAjax.post();
    };
    
    this.systemCheck = function () {
        fpcmJs.showLoader(true);
        fpcmAjax.action = 'syscheck';
        fpcmAjax.execDone = 'fpcmJs.showLoader(false);fpcmJs.assignHtml("#tabs-options-check", fpcmAjax.result);';
        fpcmAjax.get();
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
        fpcmAjax.action = 'cronasync';
        fpcmAjax.get();
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
    
    this.filemanagerDeleteCheckboxes = function() {
        jQuery('.fpcm-filemanager-buttons #fpcmselectall').button({
            icons: {
                primary: "ui-icon-circle-check"
            },
            text: false
        });
        
        jQuery('.fpcm-filelist-actions-checkbox').find('input[type="checkbox"]').button({
            icons: {
                primary: "ui-icon-check"
            },
            text: false
        }).button('refresh');
    };
    
    this.pagerButtons = function() {
        
        jQuery('.fpcm-ui-pager-buttons.fpcm-ui-pager-prev').button({
            icons: {
                primary: "ui-icon-circle-triangle-w"
            },
            text: true
        });
        
        jQuery('.fpcm-ui-pager-buttons.fpcm-ui-pager-next').button({
            icons: {
                secondary: "ui-icon-circle-triangle-e"
            },
            text: true
        });
        
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
}