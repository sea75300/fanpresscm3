/**
 * FanPress CM javascript editor functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmEditor = function () {
    
    var self = this;    
    var filemanagerWidth  = jQuery(top).width() * 0.75;
    var filemanagerHeight = jQuery(top).height() * 0.75;

    /**
     * Author: DDogg, http://www.php.de/html-usability-und-barrierefreiheit/34508-onclick-input-text-area.html
     */
    this.insert = function(aTag, eTag) {    

        if(editor.doc.somethingSelected()) {
            selectedText = editor.doc.getSelection();        
            editor.doc.replaceSelection(aTag + selectedText + eTag);
        } else {
            var cursorPos       = editor.doc.getCursor();
            editor.doc.replaceRange(aTag + '' + eTag, cursorPos, cursorPos);        

            if(eTag != '') {
                cursorPos.ch = (eTag.length > cursorPos.ch)
                             ? cursorPos.ch + aTag.length
                             : cursorPos.ch - eTag.length;

                editor.doc.setCursor(cursorPos);            
            }

            editor.focus();
        }

        return false;  
    };

    this.clearPathTextValuesLink = function() {      
        jQuery('#linksurl').val('http://');
        jQuery('#linkstext').val('');
        jQuery('#linkstarget').val('');
        jQuery('#linkscss').val('');
        fileOpenMode = 0;
    }

    this.clearPathTextValuesImg = function() {
        jQuery('#imagespath').val('http://');
        jQuery('#imagesalign').val('');
        jQuery('#imagesalt').val('');
        jQuery('#imagescss').val('');
        fileOpenMode = 0;
    }

    this.clearTableForm = function() {
        jQuery('#tablerows').val('1');
        jQuery('#tablecols').val('1');
    }

    this.insertLink = function() {
        var lnk_url = jQuery('#linksurl').val();
        var lnk_txt = jQuery('#linkstext').val();
        var lnk_tgt = jQuery('#linkstarget').val();

        if(jQuery('#linkscss') != null) {
            var lnk_css = jQuery('#linkscss').value;
        }

        if (lnk_tgt != "") {
            aTag = '<a href=\"' + lnk_url + '"\ target=\"' + lnk_tgt + '\"';
            if(lnk_css) { aTag = aTag + ' class=\"'+ lnk_css +'\"'; }
            aTag = aTag + '>' + lnk_txt ;
        }
        else {
            aTag = '<a href=\"' + lnk_url + '\"';
            if(lnk_css) { aTag = aTag + ' class=\"'+ lnk_css +'\"'; }
            aTag = aTag + '>' + lnk_txt ;
        }

        self.insert(aTag, '</a>');
    }

    this.insertTable = function() {
        var tablerows = jQuery('#tablerows').val();
        var tablecols = jQuery('#tablecols').val();
        var aTag = '<table>\n'

        for (i=0;i<tablerows;i++) {        
            aTag += '<tr>\n';        
            for (x=0;x<tablecols;x++) { aTag += '<td></td>\n'; }        
            aTag += '</tr>\n';        
        }
        self.insert(aTag + '</table>', '');  
    }

    this.insertPicture = function() {
        var pic_path = jQuery('#imagespath').val();
        var pic_align = jQuery('#imagesalign').val();
        var pic_atxt = jQuery('#imagesalt').val();

        if(jQuery('#imagescss') != null) {
            var pic_css = jQuery('#imagescss').value;
        }

        if (pic_align == "right" || pic_align == "left") {
            aTag = '<img src=\"' + pic_path + '\" alt=\"' + pic_atxt + '\" style=\"float:' + pic_align + ';margin:3px;\"';
            if(pic_css) { aTag = aTag + ' class=\"'+ pic_css +'\"'; }
            self.insert(aTag + '/>', ' ');
        } else if (pic_align == "center") {
            aTag = '<div style=\"text-align:' + pic_align + ';\"><img src=\"' + pic_path + '\" alt=\"' + pic_atxt + '\"';
            if(pic_css) { aTag = aTag + ' class=\"'+ pic_css +'\"'; }
            self.insert(aTag + '/></div>', ' ');
        } else {
            aTag = '<img src=\"' + pic_path + '\" alt=\"' + pic_atxt + '\"';
            if(pic_css) { aTag = aTag + ' class=\"'+ pic_css +'\"'; }
            self.insert(aTag + ' />', ' ');
        }
    }

    this.insertListToFrom = function(listtype) {
        aTag = "";

        do {
            $liTxt = prompt(fpcmEditorHtmlElement,"");
            if($liTxt != "" && $liTxt != null) { aTag = aTag + '<li>' + $liTxt + '</li>\n'; }
        } while($liTxt != "" && $liTxt != null);

        aTag = '<' + listtype + '>\n' + aTag;

        self.insert(aTag, '</' + listtype + '>');
    }

    this.insertFontsize = function(fs) {
        aTag = '<span style=\"font-size:' + fs + 'pt;\">';
        self.insert(aTag, '</span>');
    }

    this.insertAlignTags = function(aligndes) {
        aTag = '<p style=\"text-align:' + aligndes + ';\">';
        self.insert(aTag, '</p>');
    }

    this.insertMoreArea = function() { self.insert('<readmore>', '</readmore>'); }
    this.insertSmilies = function(smiliecode) { self.insert(' ' + smiliecode + ' ', ''); }
    this.insertColor = function(color, mode) {    
        mode    = (typeof mode == 'undefined') ? 'color' : mode;
        color   = (color == '') ? '#000000' : color;    
        self.insert('<span style="' + mode + ':' + color + ';">', '</span>');

        jQuery('#fpcmdialogeditorhtmlcolorhexcode').val('');
        jQuery('.color_mode:checked').removeAttr('checked');    
        jQuery('#color_mode1').prop( "checked", true );
    }
    
    this.insertPlayer = function (url, tagName) {
        aTag  = '<' + tagName + '>';
        aTag += '<source src="' + url + '">';        
        self.insert(aTag, '</' + tagName + '>');
        
        jQuery('#mediapath').val('');
        jQuery('#mediatype:checked').removeAttr('checked');    
        jQuery('#mediatype').prop( "checked", true );        
    };

    this.showFileManager = function() {

        fpcmJs.appendHtml('#fpcm-dialog-editor-html-filemanager', '<iframe id="fpcm-dialog-editor-html-filemanager-frame" class="fpcm-full-width" src="' + fpcmFileManagerUrl + fpcmFileManagerUrlMode + '"></iframe>');
        fpcm.ui.dialog({
            id       : 'editor-html-filemanager',
            minWidth : filemanagerWidth,
            minHeight: filemanagerHeight,
            modal    : true,
            resizable: true,
            title    : fpcmFileManagerHeadline,
            buttons  : [
                {
                    text: fpcmExtended,
                    icons: {
                        primary: "ui-icon-wrench",
                        secondary: "ui-icon-triangle-1-n"
                    },                    
                    click: function() {
                        jQuery(this).children('#fpcm-dialog-editor-html-filemanager-frame').contents().find('.fpcm-filemanager-buttons').fadeToggle();
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
            close: function( event, ui ) {
                jQuery(this).empty();
            }
        });   
    };
    
    this.showCommentLayer = function (layerUrl) {
        
        if (jQuery(window).width() >= 600) {
            dialogWidth = 900;
        } else {
            dialogWidth = '95%';
        }
        
        fpcmJs.appendHtml('#fpcm-dialog-editor-comments', '<iframe id="fpcm-editor-comment-frame" name="fpcmeditorcommentframe" class="fpcm-full-width" src="' + layerUrl + '"></iframe>');
        jQuery('.fpcm-ui-commentaction-buttons').fadeOut();
        fpcm.ui.dialog({
            id       : 'editor-comments',
            dlWidth    : dialogWidth,
            resizable: true,
            title    : fpcmEditorCommentLayerHeader,
            dlButtons  : [
                {
                    text: fpcmEditorCommentLayerSave,
                    icons: {
                        primary: "ui-icon-disk"
                    },                        
                    click: function() {
                        jQuery(this).children('#fpcm-editor-comment-frame').contents().find('#btnCommentSave').trigger('click');
                    }
                },
                {
                    text: fpcmClose,
                    icons: {
                        primary: "ui-icon-closethick"            
                    },                    
                    click: function() {
                        jQuery(this).dialog('close');
                        jQuery('.fpcm-ui-commentaction-buttons').fadeIn();
                    }
                }                            
            ],
            dlOnClose: function( event, ui ) {
                jQuery(this).empty();
            }
        });
        fpcmJs.showLoader(false);
        return false;
    };    
    
    this.setSelectToDialog = function (obj) {
        jQuery(obj).find('.fpcm-ui-input-select').selectmenu({
            appendTo: "#" + jQuery(obj).attr('id')
        });
    };
    
    this.initCodeMirror = function () {
        jQuery('#fpcmdialogeditorhtmlcolorhexcode').colorPicker({
            rows        : 5,
            cols        : 8,
            showCode    : 0,
            cellWidth   : 15,
            cellHeight  : 15,
            top         : 27,
            left        : 0,
            colorData   : fpcmCmColors,            
            onSelect    : function(colorCode) {
                jQuery('#fpcmdialogeditorhtmlcolorhexcode').val(colorCode);
            }
        });    

        jQuery('#linksurl').autocomplete({
            source: fpcmEditorAutocompleteLinks,
            appendTo: "#fpcm-dialog-editor-html-insertlink",
            minLength: 0,
            select: function( event, ui ) {
                jQuery('#linkstext').val(ui.item.label);
            }
        });    

        jQuery('#imagespath').autocomplete({
            source: fpcmEditorAutocompleteImages,
            appendTo: "#fpcm-dialog-editor-html-insertimage",
            minLength: 0,
            select: function( event, ui ) {
                jQuery('#imagesalt').val(ui.item.label);
            }
        });

        editor = CodeMirror.fromTextArea(document.getElementById("articlecontent"), {
            lineNumbers     : true,
            matchBrackets   : true,
            lineWrapping    : true,
            autoCloseTags   : true,
            id              : 'idtest',
            mode            : "text/html",
            matchTags       : {bothTags: true},
            extraKeys       : {"Ctrl-Space": "autocomplete"},
            value           : document.documentElement.innerHTML
        });

        editor.setOption('theme', 'mdn-like');
//        editor.on('paste', function(cm, ev) {
//            return true;
//        });
    };
    
    this.initTinyMce = function() {
        tinymce.init({
            selector              : "textarea",
            skin                  : "fpcm",
            theme                 : "modern",
            custom_elements       : fpcmTinyMceElements,
            language              : fpcmTinyMceLang,
            plugins               : fpcmTinyMcePlugins,
            toolbar1              : fpcmTinyMceToolbar,
            link_class_list       : fpcmTinyMceCssClasses,
            image_class_list      : fpcmTinyMceCssClasses,
            link_list             : fpcmTinyMceLinkList,
            image_list            : fpcmTinyMceImageList,
            textpattern_patterns  : fpcmTinyMceTextpattern,
            templates             : fpcmTinyMceTemplatesList,
            menubar               : false,
            relative_urls         : false,
            image_advtab          : true,
            resize                : true,
            convert_urls          : true,
            browser_spellcheck    : true,
            link_assume_external_targets: true,
            default_link_target   : "_blank",
            autoresize_min_height : '500',
            image_caption         : true,
            file_picker_callback  : function(callback, value, meta) {
                tinymce.activeEditor.windowManager.open({
                    file            : fpcmFileManagerUrl + fpcmFileManagerUrlMode,
                    title           : fpcmFileManagerHeadline,
                    width           : filemanagerWidth,
                    height          : filemanagerHeight,
                    close_previous  : false,
                    buttons  : [
                        {
                            text: fpcmExtended,                   
                            onclick: function() {
                                var tinyMceWins = top.tinymce.activeEditor.windowManager.getWindows();
                                jQuery('#'+ tinyMceWins[1]._id).find('iframe').contents().find('.fpcm-filemanager-buttons').fadeToggle();
                            }
                        },
                        {
                            text: fpcmClose,                      
                            onclick: function() {
                                top.tinymce.activeEditor.windowManager.close();
                            }
                        }                            
                    ]
                },
                {
                    oninsert: function (url, objVals) {
                        callback(url, objVals);
                    }
                });
            },
            setup : function(ed) { 
                ed.on('init', function() {
                    this.getBody().style.fontSize = fpcmTinyMceDefaultFontsize;
                    jQuery(this.iframeElement).removeAttr('title');
                });
            }                
        });    
    };
    
    this.htmlInserTemplateCallback = function(responseData) {

        var responseData = fpcmAjax.fromJSON(responseData);

        window.editor.doc.setValue(responseData.data);
        jQuery('#fpcm-dialog-editor-html-insertdraft').dialog('close');

        return true;
    }
};

jQuery(document).ready(function() {
    
    fpcmJs.setFocus('articletitle');
    
    fpcmEditor = new fpcmEditor(); 

    jQuery('.fpcm-editor-htmlclick').click(function() {        
        var tag = jQuery(this).attr('htmltag');
        fpcmEditor.insert('<' + tag + '>', '</' + tag + '>');
        jQuery(this).parent().parent().trigger('click');
        return false;
    });
    
    jQuery('.fpcm-editor-cssclick').click(function() {        
        var tag = jQuery(this).attr('htmltag');
        fpcmEditor.insert(' class="' + tag + '"', '');
        jQuery(this).parent().parent().trigger('click');
        return false;
    });    
    
    jQuery('.fpcm-editor-htmlfontsize').click(function() {        
        var tag = jQuery(this).attr('htmltag');
        fpcmEditor.insertFontsize(tag);
        jQuery(this).parent().parent().trigger('click');
        return false;
    });
    
    jQuery('.fpcm-editor-htmlsymbol').click(function() {
        fpcmEditor.insert(jQuery(this).attr('symbolcode'), '');
        return false;
    });

    jQuery('.fpcm-editor-alignclick').click(function() {
        var tag = jQuery(this).attr('htmltag');
        fpcmEditor.insertAlignTags(tag);
        return false;
    });

    jQuery('#fpcm-dialog-editor-html-insertlist-btn').click(function() {
        fpcmEditor.insertListToFrom('ul');
        return false;
    });
    
    jQuery('#fpcm-dialog-editor-html-insertlistnum-btn').click(function() {
        fpcmEditor.insertListToFrom('ol');
        return false;
    });
    
    jQuery('#fpcm-dialog-editor-html-insertiframe-btn').click(function() {
        fpcmEditor.insert('<iframe src="http://" class="fpcm-articletext-iframe">','</iframe>');
        return false;
    });
    
    jQuery('#fpcm-dialog-editor-html-insertmore-btn').click(function() {
        fpcmEditor.insertMoreArea();
        return false;
    });

    jQuery('#fpcm-dialog-editor-html-removetags-btn').click(function() {
        
        fpcmAjax.action     = 'editor/cleartags';
        fpcmAjax.data       = {text: editor.doc.getValue()};
        fpcmAjax.execDone   = 'window.editor.doc.setValue(fpcmAjax.result);';
        fpcmAjax.post();
        
        return false;
    });

    jQuery('#articlepostponed').click(function () {
        jQuery('.fpcm-ui-editor-postponed').fadeToggle();
    });

    fpcm.ui.button('#fpcmeditorextended', {
        icons: {
            primary: "ui-icon-wrench",
            secondary: "ui-icon-triangle-1-n"
        },
        text: false,
    },
    function() {

        if (jQuery(window).width() >= 800) {
            dialogWidth = 600;
        } else if (jQuery(window).width() >= 480) {
            dialogWidth = '75%';
        } else if (jQuery(window).width() <= 480) {
            dialogWidth = '95%';
        }
        
        fpcm.ui.dialog({
            id: 'editor-extended',
            dlWidth: dialogWidth,
            title: fpcmExtended,
            dlButtons: [
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
            dlOnOpen: function (event, ui) {
                fpcmEditor.setSelectToDialog(this);
            },
            dlOnClose: function (event, ui) {
                jQuery(this).dialog('destroy');
            }
        });
        return false;
    });
    
    fpcm.ui.button('.fpcm-editor-select-button', {
        icons: {
            secondary: "ui-icon-triangle-1-s"
        },
        text: true,
    },
    function() {
        
        jQuery(this).parent().children('.fpcm-editor-select').click(function() {
            jQuery(this).removeClass('active').fadeToggle();
        })
        
        var topPos  = jQuery(this).position().top + jQuery(this).parent().height() - 7;
        var topLeft = jQuery(this).position().left - 6;
        
        jQuery('.fpcm-editor-select.active').fadeOut();
        
        jQuery(this).parent().children('.fpcm-editor-select').css('top', topPos).css('left', topLeft).css('min-width', jQuery(this).parent().width()).toggleClass('active').fadeToggle().children('.fpcm-editor-smenu').menu();
        
        return false;
    });
    
    fpcm.ui.spinner('input.fpcm-ui-spinner-hour', {
        min: 0,
        max: 23
    });

    fpcm.ui.spinner('input.fpcm-ui-spinner-minutes', {
        min: 0,
        max: 59
    });
    
    fpcm.ui.datepicker('input.fpcm-ui-datepicker', {
        maxDate: "+2m",
        minDate: "-0d",
        showButtonPanel: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        monthNames: fpcmPostponeDatePicker['months'],
        dayNames: fpcmPostponeDatePicker['daysfull'],
        dayNamesShort: fpcmPostponeDatePicker['daysshort'],
        dayNamesMin: fpcmPostponeDatePicker['daysshort']
    });   
    
    jQuery('.fp-ui-button-restore').click(function() {
        if(!confirm(fpNewsListActionConfirmMsg)) {
            fpcmJs.showLoader(true);
            return false;
        }        
    });
    
    jQuery(window).click(function() {
        jQuery('.fpcm-editor-select').fadeOut();
    });
    
    jQuery('.fpcm-articlelist-shortlink').click(function () {
        var text = jQuery(this).text();
        var link = jQuery(this).attr('href');
        
        if (jQuery(window).width() >= 600) {
            dialogWidth = 900;
        } else if (jQuery(window).width() >= 480) {
            dialogWidth = '75%';
        } else if (jQuery(window).width() <= 480) {
            dialogWidth = '95%';
        } 
        
        fpcm.ui.dialog({
            id: 'editor-shortlink',
            dlWidth: dialogWidth,
            title: text,
            dlButtons: [
                {
                    text: fpcmClose,
                    icons: {
                        primary: "ui-icon-closethick"            
                    },                        
                    click: function() {
                        jQuery( this ).dialog( "close" );
                    }
                }
            ],
            dlOnOpen: function (event, ui) {                
                var appendCode  = fpcmCanConnect
                                ? '<div class="fpcm-ui-input-wrapper"><div class="fpcm-ui-input-wrapper-inner"><input type="text" value="' + link + '"></div></div>'
                                : '<iframe class="fpcm-full-width"  src="' + link + '"></iframe>';

                fpcmJs.appendHtml(this, appendCode);
            },
            dlOnClose: function( event, ui ) {
                jQuery(this).empty();
            }
         });
         return false;
    });
    
    jQuery('.fpcm-articlelist-articleimage').fancybox();
    
    jQuery('#fpcmuieditoraimgfmg').click(function () {
        fpcmFileManagerUrlMode = 3;
        fpcmEditor.showFileManager();
        fpcmFileManagerUrlMode = 2;
        return false;
    });
    
    /**
     * Keycodes
     * http://www.brain4.de/programmierecke/js/tastatur.php
     */
    jQuery(document).keypress(function(thekey) {
        if(typeof editor == 'undefined' || (editor && !editor.state.focused) || !fmcEditorKeyShortcutsEnabled) return;

        if (thekey.ctrlKey && thekey.which == 115) {
            if(jQuery("#btnArticleSave")) {
                jQuery("#btnArticleSave").click();
                return false;
            }
        }

        if (thekey.ctrlKey && thekey.which == 98) { fpcmEditor.insert('<b>', '</b>');return false; }
        if (thekey.ctrlKey && thekey.which == 105) { fpcmEditor.insert('<i>', '</i>');return false; }
        if (thekey.ctrlKey && thekey.which == 117) { fpcmEditor.insert('<u>', '</u>');return false; }
        if (thekey.ctrlKey && thekey.which == 111) { fpcmEditor.insert('<s>', '</s>');return false; }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 89) { fpcmEditor.insert('<sub>', '</sub>');return false; }
        if (thekey.ctrlKey && thekey.which == 121) { fpcmEditor.insert('<sup>', '</sup>');return false; }

        if (thekey.ctrlKey && thekey.which == 46) { fpcmEditor.insertListToFrom('ul');return false; }
        if (thekey.ctrlKey && thekey.which == 35) { fpcmEditor.insertListToFrom('ol');return false; }

        if (thekey.ctrlKey && thekey.which == 113) { fpcmEditor.insert('<blockquote>', '</blockquote>');return false; }
        if (thekey.ctrlKey && thekey.which == 102) { jQuery('#fpcm-dialog-editor-html-insertiframe-btn').click();return false; }
        if (thekey.ctrlKey && thekey.which == 109) { fpcmEditor.insertMoreArea();return false; }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 90) { jQuery('#fpcm-dialog-editor-html-insertmedia-btn').click();return false; }
        if (thekey.ctrlKey && thekey.which == 108) { jQuery('#fpcm-dialog-editor-html-insertlink-btn').click();return false;  }
        if (thekey.ctrlKey && thekey.which == 112) { jQuery('#fpcm-dialog-editor-html-insertimage-btn').click();return false;  }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 84) { jQuery('#fpcm-dialog-editor-html-inserttable-btn').click();return false;  }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 69) { jQuery('#fpcm-dialog-editor-html-insertsmiley-btn').click();return false;  }        

        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 76) { fpcmEditor.insertAlignTags('left');return false; }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 67) { fpcmEditor.insertAlignTags('center');return false; }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 82) { fpcmEditor.insertAlignTags('right');return false; }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 74) { fpcmEditor.insertAlignTags('justify');return false; }
        
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 70) { jQuery('#fpcm-dialog-editor-html-insertcolor-btn').click();return false; }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 83) { jQuery('#fpcm-dialog-editor-html-removetags-btn').click();return false; }
        if (thekey.ctrlKey && thekey.shiftKey && thekey.which == 73) { jQuery('#fpcm-dialog-editor-html-insertsymbol-btn').click();return false; }
    });        
});