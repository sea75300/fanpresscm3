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

        fpcm.ui.checkboxradio('.fpcm-filemanager-buttons #fpcmselectall', {
            icon: "ui-icon-circle-check",
            showLabel: false
        },
        function() {
            self.refreshSingleCheckboxes();
        });
        
        self.refreshSingleCheckboxes();
    };
    
    this.refreshSingleCheckboxes = function() {
        jQuery('.fpcm-filelist-actions-checkbox').find('input[type="checkbox"]').checkboxradio({
            icon: "ui-icon-check",
            showLabel: false
        });  
    };
}

var fpcmFilemgr = new fpcmFilemanager();

jQuery(document).ready(function () {

    fpcm.ui.button('#btnAddFile', {
        icon: "ui-icon-plusthick"
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
        icon: "ui-icon-circle-arrow-e"
    });

    fpcm.ui.button('#btnCancelUpload', {
        icon: "ui-icon-cancel"
    },
    function () {
        jQuery('#fpcm-ui-phpupload-filelist').empty();
        jQuery('.fpcm-ui-fileinput-select').empty();
    });

});