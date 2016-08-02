/**
 * FanPress CM UI Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, 2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.filemanager = {

    assignButtons: function () {
        fpcm.ui.assignCheckboxes();
        this.initInsertButtons();
        this.initSelectionCheckboxes();
        jQuery('.fpcm-link-fancybox').fancybox();
    },
    
    initActionButtons : function() {
        jQuery('#btnRenameFiles').click(function () {
            if (fpcmLang.newNameMsg === undefined) {
                fpcmJs.showLoader(false);
                return true;
            }

            var newName = prompt(fpcm.ui.translate('newNameMsg'), '');
            if (!newName || newName == '') {
                jQuery(this).addClass('fpcm-noloader');
                fpcmJs.showLoader(false);
                return false;
            }

            jQuery('#newfilename').val(newName);

        });
        
        jQuery('#btnCreateThumbs').click(function () {            
            if (!confirm(fpcm.ui.translate('confirmMessage'))) {
                jQuery(this).addClass('fpcm-noloader');
                return false;
            }
        });
        
        this.initSelectionCheckboxes();
    },
    
    initInsertButtons: function () {
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
    },
    
    initSelectionCheckboxes: function() {

        fpcm.ui.checkboxradio(
            '.fpcm-filemanager-buttons #fpcmselectall', {}, function() {
                fpcm.filemanager.refreshSingleCheckboxes();
        });
        
        this.refreshSingleCheckboxes();
    },
    
    refreshSingleCheckboxes: function() {
        jQuery('.fpcm-filelist-actions-checkbox').find('input[type="checkbox"]').checkboxradio({
            showLabel: false
        }).checkboxradio('refresh');  
    },
    
    initUploadButtons: function() {

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

    },
    
    initJqUpload: function() {
        
        if (!fpcmJqUploadInit) {
            return false;
        }

        'use strict';

        jQuery('#fileupload').fileupload({
            url: fpcmAjaxActionPath + 'jqupload',
            dropZone: jQuery('#fpcm-filemanager-upload-drop')
        });

        jQuery('#fileupload').addClass('fileupload-processing');
        jQuery.ajax({
            url: jQuery('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: jQuery('#fileupload')[0]
        }).always(function () {
            jQuery(this).removeClass('fileupload-processing');
        }).done(function (result) {
            jQuery(this).fileupload('option', 'done')
                .call(this, jQuery.Event('done'), {result: result});
        });
        
        jQuery(document).bind('dragover', function (e) {
            var dropZone = $('#fpcm-filemanager-upload-drop'), timeout = window.dropZoneTimeout;

            if (!timeout) {
                dropZone.addClass('in');
            } else {
                clearTimeout(timeout);
            }

            var found = false, node = e.target;

            do {
                if (node === dropZone[0]) {
                    found = true;
                    break;
                }
                node = node.parentNode;
            } while (node != null);
            if (found) {
                dropZone.addClass('hover');
            } else {
                dropZone.removeClass('hover');
            }
            window.dropZoneTimeout = setTimeout(function () {
                window.dropZoneTimeout = null;
                dropZone.removeClass('in hover');
            }, 100);
        });

    }
};

jQuery(document).ready(function () {
    fpcm.filemanager.initJqUpload();
    fpcm.filemanager.initUploadButtons();
});