/**
 * FanPress CM Filemanager Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.filemanager = {

    init: function() {

        this.initJqUpload();
        this.initUploadButtons();
        
        if (window.fpcmLoadAjax) {
            this.reloadFiles();
            this.initActionButtons();
        }
    
        jQuery('#tabs-files-list-reload').click(function () {
            fpcm.filemanager.reloadFiles();
            return false;
        });
    },

    assignButtons: function () {
        fpcm.ui.assignCheckboxes();
        this.initInsertButtons();
        this.initSelectionCheckboxes();
        this.initPagination();
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
                    fpcm.ui.appendHtml('#fpcm-ui-phpupload-filelist', '<tr><td>' + fileList[i].name +'</td></tr>')
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

        var uploaderEl = jQuery('#fileupload');

        uploaderEl.fileupload({
            url: fpcmAjaxActionPath + 'jqupload',
            dropZone: jQuery('#fpcm-filemanager-upload-drop'),
        });
        
        this._uploadsDone = 0;
        uploaderEl.on('fileuploaddone', function (e, data) {

            fpcm.filemanager._uploadsDone++;
            if (fpcm.filemanager._uploadsDone < data.getNumberOfFiles()) {
                return true;
            }

            fpcmJs.showLoader(true);
            fpcm.ajax.get('cronasync', {
                data    : {
                    cjId: 'fileindex'
                },
                execDone: 'fpcmJs.showLoader(false);'
            });
        });

        uploaderEl.addClass('fileupload-processing');
        jQuery.ajax({
            url: uploaderEl.fileupload('option', 'url'),
            dataType: 'json',
            context: uploaderEl[0]
        }).always(function () {
            jQuery(this).removeClass('fileupload-processing');
        }).done(function (result) {
            jQuery(this).fileupload('option', 'done').call(this, jQuery.Event('done'), {result: result});
        });
        
        jQuery(document).bind('dragover', function (e) {
            var dropZone = jQuery('#fpcm-filemanager-upload-drop'), timeout = window.dropZoneTimeout;

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

    },
    
    initPagination: function() {

        fpcm.ui.selectmenu('#pageSelect', {
            select: function( event, ui ) {
                fpcm.filemanager.reloadFiles(ui.item.value);
            }
        });

        jQuery('#fpcmpagernext').click(function() {
            var page = jQuery(this).attr('href').split('&page=');
            fpcm.filemanager.reloadFiles((page[1] === undefined) ? 1 : page[1]);
            return false;
        });

        jQuery('#fpcmpagerback').click(function() {
            var page = jQuery(this).attr('href').split('&page=');
            fpcm.filemanager.reloadFiles((page[1] === undefined) ? 1 : page[1]);
            return false;
        });

    },

    reloadFiles: function (page) {

        fpcmJs.showLoader(true);

        if (!page) {
            page = 1;
        }

        fpcm.ajax.get('filelist', {
            data: {
                mode: fpcmFmgrMode,
                page: page
            },
            execDone: function () {

                fpcm.ui.assignHtml("#tabs-files-list-content", fpcm.ajax.getResult('filelist'));
                fpcmJs.assignButtons();
                fpcm.filemanager.assignButtons();
                var fpcmRFDinterval = setInterval(function(){
                    if (jQuery('#fpcm-filelist-images-finished').length == 1) {
                        fpcmJs.showLoader(false);
                        fpcm.ui.resize();
                        clearInterval(fpcmRFDinterval);
                        if (page) {
                            jQuery(window).scrollTop(0);
                        }
                        return false;
                    }
                }, 250);
            }
        });
        
        return false;
    }
};