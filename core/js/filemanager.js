/**
 * FanPress CM javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmFilemanager = function () {
    
    var self = this;

    this.assignButtons = function () {
        fpcm.ui.assignCheckboxes();
        self.initInsertButtons();
        self.initSelectionCheckboxes();
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

                window.parent.jQuery("#fpcm-dialog-editor-html-filemanager").dialog('close');
                window.parent.jQuery('#fpcm-dialog-editor-html-filemanager').empty();
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

                window.parent.jQuery("#fpcm-dialog-editor-html-filemanager").dialog('close');
                window.parent.jQuery('#fpcm-dialog-editor-html-filemanager').empty();
            } else {
                top.tinymce.activeEditor.windowManager.getParams().oninsert(url, { alt: title, text: title });
                top.tinymce.activeEditor.windowManager.close();
            }

            return false;
        });

        jQuery('.fpcm-filelist-articleimage').click(function () {
            var url   = jQuery(this).attr('href');

            parent.document.getElementById('articleimagepath').value  = url;
            window.parent.jQuery("#fpcm-dialog-editor-html-filemanager").dialog('close');
            window.parent.jQuery('#fpcm-dialog-editor-html-filemanager').empty();

            return false;
        });
    };
    
    this.initSelectionCheckboxes = function() {

        fpcm.ui.button('.fpcm-filemanager-buttons #fpcmselectall', {
            icons: {
                primary: "ui-icon-circle-check"
            },
            text: false
        },
        function() {
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

jQuery(document).ready(function () {

    fpcm.ui.button('#btnAddFile', {
        icons: {
            primary: "ui-icon-plusthick",
        },
        text: true
    },
    function () {

        jQuery('#fpcm-ui-phpupload-filelist').empty();
        jQuery(this).parent().find('.fpcm-ui-fileinput-select').trigger('click');
        jQuery('.fpcm-ui-fileinput-select').change(function () {

            jQuery('#fpcm-ui-phpupload-filelist').empty();
            
            var fileList = jQuery(this)[0].files;
            if (fileList === undefined) {
                return false;
            }

            for (var i=0;i<fileList.length;i++) {
                fpcmJs.appendHtml('#fpcm-ui-phpupload-filelist', '<tr><td>' + fileList[i].name +'</td></tr>')
            }
            return false;
        });

        return false;

    });

    fpcm.ui.button('#btnUploadFile', {
        icons: {
            primary: "ui-icon-circle-arrow-e",
        },
        text: true
    });

    fpcm.ui.button('#btnCancelUpload', {
        icons: {
            primary: "ui-icon-cancel",
        },
        text: true
    },
    function () {
        jQuery('#fpcm-ui-phpupload-filelist').empty();
        jQuery('.fpcm-ui-fileinput-select').empty();
    });

});