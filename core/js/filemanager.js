/**
 * FanPress CM javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmFilemanager = function () {
    
    var self = this;

    this.assignButtons = function () {
        fpcmJs.assignCheckboxes();
        self.initInsertButtons();
        self.initSelectionCheckboxes();
    };
    
    this.initButtonIcons = function () {
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
    
    this.initActionButtons = function () {
        jQuery('#btnRenameFiles').click(function () {
            if (typeof fpcmFmgrNewName != 'undefined') {
                var newName = prompt(fpcmFmgrNewName, '');
                if (!newName || newName == '') {
                    jQuery(this).addClass('fpcm-noloader');
                    return false;
                }            
                jQuery('#newfilename').val(newName);                
            }
            
        });
        
        jQuery('#btnCreateThumbs').click(function () {            
            if (!confirm(fpcmConfirmMessage)) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }
        });
        
        self.initSelectionCheckboxes();
    };
    
    this.initInsertButtons = function () {
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
            window.parent.jQuery("#fpcm-editor-html-filemanager").dialog('close');
            window.parent.jQuery('#fpcm-editor-html-filemanager').empty();

            return false;
        });
    };
    
    this.initSelectionCheckboxes = function() {
        jQuery('.fpcm-filemanager-buttons #fpcmselectall').button({
            icons: {
                primary: "ui-icon-circle-check"
            },
            text: false
        }).click(function() {
            self.refreshSingleCheckboxes();
        });
        
        self.refreshSingleCheckboxes();
    };
    
    this.refreshSingleCheckboxes = function() {
        jQuery('.fpcm-filelist-actions-checkbox').find('input[type="checkbox"]').button({
            icons: {
                primary: "ui-icon-check"
            },
            text: false
        }).button('refresh');  
    };
}

var fpcmFilemgr = new fpcmFilemanager();