/**
 * FanPress CM javascript editor functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmEditor = function () {
    
    var self = this;    

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
    };

    this.clearPathTextValuesImg = function() {
        jQuery('#imagespath').val('http://');
        jQuery('#imagesalign').val('');
        jQuery('#imagesalt').val('');
        jQuery('#imagescss').val('');
        fileOpenMode = 0;
    };

    this.clearTableForm = function() {
        jQuery('#tablerows').val('1');
        jQuery('#tablecols').val('1');
    };

    this.clearListForm = function() {
        jQuery('#listrows').val('1');
    };

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
    };

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
    };

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
    };

    this.insertListToFrom = function(listtype) {

        var tablerows = jQuery('#listrows').val();

        aTag = '<' + listtype + '>\n';
        for (i=0;i<tablerows;i++) {
            aTag += '<li></li>\n';
        }

        self.insert(aTag, '</' + listtype + '>');
    };

    this.insertFontsize = function(fs) {
        aTag = '<span style=\"font-size:' + fs + 'pt;\">';
        self.insert(aTag, '</span>');
    };

    this.insertAlignTags = function(aligndes) {
        aTag = '<p style=\"text-align:' + aligndes + ';\">';
        self.insert(aTag, '</p>');
    };

    this.insertMoreArea = function() {
        self.insert('<readmore>', '</readmore>');
    };
    
    this.insertSmilies = function(smiliecode) {
        self.insert(' ' + smiliecode + ' ', '');
    };

    this.insertColor = function(color, mode) {    
        mode    = (mode === undefined) ? 'color' : mode;
        color   = (color == '') ? '#000000' : color;    
        self.insert('<span style="' + mode + ':' + color + ';">', '</span>');

        jQuery('#fpcmdialogeditorhtmlcolorhexcode').val('');
        jQuery('.color_mode:checked').removeAttr('checked');    
        jQuery('#color_mode1').prop( "checked", true );
    };
    
    this.insertPlayer = function (url, tagName) {
        aTag  = '<' + tagName + '>';
        aTag += '<source src="' + url + '">';        
        self.insert(aTag, '</' + tagName + '>');
        
        jQuery('#mediapath').val('');
        jQuery('.fpcm-editor-mediatype').removeAttr('checked');    
        jQuery('#mediatype_a').prop( "checked", true );        
    };
    
    this.insertFrame = function (url, params) {
        
        if (url === undefined) {
            url = 'http://';
        }
        
        if (params === undefined) {
            params = [];
        }

        fpcmEditor.insert('<iframe src="' + url + '" class="fpcm-articletext-iframe" ' + params.join(' ') + '>','</iframe>');
    };

    this.showFileManager = function() {
        
        var size = fpcm.ui.getDialogSizes();
        
        fpcmJs.appendHtml('#fpcm-dialog-editor-html-filemanager', '<iframe id="fpcm-dialog-editor-html-filemanager-frame" class="fpcm-full-width" src="' + fpcmFileManagerUrl + fpcmFileManagerUrlMode + '"></iframe>');
        fpcm.ui.dialog({
            id       : 'editor-html-filemanager',
            dlMinWidth : size.width,
            dlMinHeight: size.height,
            modal    : true,
            resizable: true,
            title    : fpcm.ui.translate('fileManagerHeadline'),
            dlButtons  : [
                {
                    text: fpcm.ui.translate('extended'),
                    icon: "ui-icon-wrench",                    
                    click: function() {
                        jQuery(this).children('#fpcm-dialog-editor-html-filemanager-frame').contents().find('.fpcm-filemanager-buttons').fadeToggle();
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
            dlOnClose: function( event, ui ) {
                jQuery(this).empty();
            }
        });   
    };
    
    this.showCommentLayer = function (layerUrl) {
        
        var size = fpcm.ui.getDialogSizes();
        
        fpcmJs.appendHtml('#fpcm-dialog-editor-comments', '<iframe id="fpcm-editor-comment-frame" name="fpcmeditorcommentframe" class="fpcm-full-width" src="' + layerUrl + '"></iframe>');
        jQuery('.fpcm-ui-commentaction-buttons').fadeOut();

        var size = fpcm.ui.getDialogSizes();

        fpcm.ui.dialog({
            id       : 'editor-comments',
            dlWidth    : size.width,
            dlHeight   : size.height,
            resizable: true,
            title    : fpcm.ui.translate('editorCommentLayerHeader'),
            dlButtons  : [
                {
                    text: fpcmEditorCommentLayerSave,
                    icon: "ui-icon-disk",                        
                    click: function() {
                        jQuery(this).children('#fpcm-editor-comment-frame').contents().find('#btnCommentSave').trigger('click');
                    }
                },
                {
                    text: fpcm.ui.translate('close'),
                    icon: "ui-icon-closethick",                    
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
    
    this.initCodeMirrorAutosave = function () {

        var autoSaveStorage = localStorage.getItem(fpcmEditorAutosavePrefix);
        var isDisabled = (autoSaveStorage === null ? true : false);
        
        fpcm.ui.button('#fpcm-editor-html-restoredraft-btn',
        {
            disabled: isDisabled
        },
        function () {

            var autoSaveStorage = localStorage.getItem(fpcmEditorAutosavePrefix);
            editor.setValue(autoSaveStorage);

            return false;
        });
        
        setInterval(function() {

            var editorValue = editor.getValue();
            if (!editorValue) {
                return false;
            }
            
            if (editorValue === localStorage.getItem(fpcmEditorAutosavePrefix)) {
                return true;
            }

            localStorage.setItem(fpcmEditorAutosavePrefix, editorValue);
            fpcm.ui.button('#fpcm-editor-html-restoredraft-btn', {
                disabled: false
            });
            
        }, 30000);

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

        editor = CodeMirror.fromTextArea(
            document.getElementById("articlecontent"), {
            lineNumbers     : true,
            matchBrackets   : true,
            lineWrapping    : true,
            autoCloseTags   : true,
            id              : 'htmleditor',
            mode            : "text/html",
            matchTags       : {
                bothTags: true
            },            
            extraKeys       : {
                "Ctrl-Space": "autocomplete",
                "Ctrl-B"    : function() {
                    jQuery('#fpcm-editor-html-bold-btn').click();
                },
                "Ctrl-I"    : function() {
                    jQuery('#fpcm-editor-html-italic-btn').click();
                },
                "Ctrl-U"    : function() {
                    jQuery('#fpcm-editor-html-underline-btn').click();
                },
                "Ctrl-O"    : function() {
                    jQuery('#fpcm-editor-html-strike-btn').click();
                },
                "Shift-Ctrl-F"    : function() {
                    jQuery('#fpcm-dialog-editor-html-insertcolor-btn').click();
                },
                "Ctrl-Y"    : function() {
                    jQuery('#fpcm-editor-html-sup-btn').click();
                },
                "Shift-Ctrl-Y"    : function() {
                    jQuery('#fpcm-editor-html-sub-btn').click();
                },
                "Shift-Ctrl-L"    : function() {
                    jQuery('#fpcm-editor-html-aleft-btn').click();
                },
                "Shift-Ctrl-C"    : function() {
                    jQuery('#fpcm-editor-html-acenter-btn').click();
                },
                "Shift-Ctrl-R"    : function() {
                    jQuery('#fpcm-editor-html-aright-btn').click();
                },
                "Shift-Ctrl-J"    : function() {
                    jQuery('#fpcm-editor-html-ajustify-btn').click();
                },
                "Ctrl-Alt-N"    : function() {
                    jQuery('#fpcm-editor-html-insertlist-btn').click();
                },
                "Shift-Ctrl-N"    : function() {
                    jQuery('#fpcm-editor-html-insertlistnum-btn').click();
                },
                "Ctrl-Q"    : function() {
                    jQuery('#fpcm-editor-html-quote-btn').click();
                },
                "Ctrl-L"    : function() {
                    jQuery('#fpcm-dialog-editor-html-insertlink-btn').click();
                },
                "Ctrl-P"    : function() {
                    jQuery('#fpcm-dialog-editor-html-insertimage-btn').click();
                },
                "Shift-Ctrl-Z"    : function() {
                    jQuery('#fpcm-dialog-editor-html-insertmedia-btn').click();
                },
                "Ctrl-F"    : function() {
                    jQuery('#fpcm-editor-html-insertiframe-btn').click();
                },
                "Ctrl-M"    : function() {
                    jQuery('#fpcm-editor-html-insertmore-btn').click();
                },
                "Shift-Ctrl-T"    : function() {
                    jQuery('#fpcm-dialog-editor-html-inserttable-btn').click();
                },
                "Shift-Ctrl-E"    : function() {
                    jQuery('#fpcm-dialog-editor-html-insertsmiley-btn').click();
                },
                "Shift-Ctrl-D"    : function() {
                    jQuery('#fpcm-dialog-editor-html-insertdraft-btn').click();
                },
                "Shift-Ctrl-I"    : function() {
                    jQuery('#fpcm-dialog-editor-html-insertsymbol-btn').click();
                },
                "Shift-Ctrl-S"    : function() {
                    jQuery('#fpcm-editor-html-removetags-btn').click();
                    return false;
                }

            },
            value           : document.documentElement.innerHTML,
            theme           : 'fpcm'
        });
        
        editor.on('paste', function(instance, event) {
                
            if (event.clipboardData === undefined) {
                return true;
            }

            var orgText = event.clipboardData.getData('Text');            
            var chgText = fpcm.editor_videolinks.replace(orgText);

            if (orgText === chgText) {
                return false;
            }

            event.preventDefault();
            fpcmEditor.insertFrame(chgText, ['width="500"', 'height="300"', 'frameborder="0"', 'allowfullscreen']);
            return true;

        });

        self.initCodeMirrorAutosave();
        
        var size = fpcm.ui.getDialogSizes();

        jQuery('#fpcm-dialog-editor-html-insertlink-btn').click(function() {           
            fpcm.ui.dialog({
                id: 'editor-html-insertlink',
                dlWidth: size.width,
                title: fpcm.ui.translate('editorInsertLink'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('globalInsert'),
                        icon: "ui-icon-check",
                        click: function() {
                            fpcmEditor.insertLink();
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: fpcm.ui.translate('fileManagerHeadline'),
                        icon: "ui-icon-folder-open",
                        click: function() {
                            window.fileOpenMode = 1;
                            fpcmEditor.showFileManager();
                        }
                    },
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                dlOnOpen: function () {
                    fpcmEditor.setSelectToDialog(this);
                },
                dlOnClose: function () {
                    fpcmEditor.clearPathTextValuesLink();
                }
            });
            return false;
        });        
        
        jQuery('#fpcm-dialog-editor-html-insertimage-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertimage',
                dlWidth: size.width,
                title: fpcm.ui.translate('editorInsertPic'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('globalInsert'),
                        icon: "ui-icon-check",                        
                        click: function() {
                            fpcmEditor.insertPicture();
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: fpcm.ui.translate('fileManagerHeadline'),
                        icon: "ui-icon-folder-open" ,                
                        click: function() {
                            window.fileOpenMode = 2;
                            fpcmEditor.showFileManager();
                        }
                    },
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                dlOnOpen: function () {
                    fpcmEditor.setSelectToDialog(this);
                },
                dlOnClose: function() {
                    fpcmEditor.clearPathTextValuesImg();
                }
            });
            return false;
        });
        
        jQuery('#fpcm-dialog-editor-html-inserttable-btn').click(function() {
            
            fpcm.ui.spinner('#tablerows', {
                min: 1
            });

            fpcm.ui.spinner('#tablecols', {
                min: 1
            });

            fpcm.ui.dialog({
                id: 'editor-html-inserttable',
                dlWidth: size.width,
                title: fpcm.ui.translate('editorInsertTable'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('globalInsert'),
                        icon: "ui-icon-check",                        
                        click: function() {
                            fpcmEditor.insertTable();
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                dlOnOpen: function () {
                    fpcmEditor.setSelectToDialog(this);
                },
                dlOnClose: function() {
                    fpcmEditor.clearTableForm();
                }
            });
            
            return false;
        });
        
        jQuery('#fpcm-dialog-editor-html-insertcolor-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertcolor',
                dlWidth: size.width,
                title: fpcm.ui.translate('editorInsertColor'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('globalInsert'),
                        icon: "ui-icon-check",                        
                        click: function() {
                            fpcmEditor.insertColor(jQuery('#fpcmdialogeditorhtmlcolorhexcode').val(), jQuery('.color_mode:checked').val());
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ]        
            });
            return false;
        });   
        
        jQuery('#fpcm-dialog-editor-html-insertmedia-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertmedia',
                dlWidth: size.width,
                title: fpcm.ui.translate('editorInsertMedia'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('globalInsert'),
                        icon: "ui-icon-check",                        
                        click: function() {
                            fpcmEditor.insertPlayer(jQuery('#mediapath').val(), jQuery('#mediatype:checked').val());
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ]        
            });
            return false;
        });
        
        jQuery('#fpcm-dialog-editor-html-insertsmiley-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertsmileys',
                dlWidth: size.width,
                title: fpcm.ui.translate('editorInsertSmiley'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                        
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                dlOnOpen: function () {
                    fpcmAjax.action     = 'editor/smileys';
                    fpcmAjax.execDone   = "jQuery('#fpcm-dialog-editor-html-insertsmileys').append(fpcmAjax.result);";
                    fpcmAjax.async      = false;
                    fpcmAjax.post();
                    fpcmAjax.reset();                

                    jQuery('.fpcm-editor-htmlsmiley').click(function() {
                        fpcmEditor.insertSmilies(jQuery(this).attr('smileycode'));
                    });
                },
                dlOnClose: function() {
                    jQuery(this).empty();
                }
            });
            return false;
        });         
        
        jQuery('#fpcm-dialog-editor-html-insertsymbol-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertsymbol',
                dlWidth: size.width,
                dlHeight: size.height,
                title: fpcm.ui.translate('editorInsertSymbol'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                        
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ]
            });
            return false;
        });
 
        jQuery('#fpcm-dialog-editor-html-insertdraft-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertdraft',
                dlWidth: fpcm.ui.getDialogSizes(top, 0.25).width,
                title: fpcm.ui.translate('editorInsertATpl'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                        
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                dlOnOpen: function () {

                    fpcm.ui.selectmenu('#tpldraft',{

                        appendTo: '#fpcm-dialog-editor-html-insertdraft',
                        change: function( event, ui ) {

                            fpcmAjax.action     = 'editor/draft';
                            fpcmAjax.data       = {path: jQuery(this).val()};
                            fpcmAjax.execDone   = 'fpcmEditor.htmlInserTemplateCallback(fpcmAjax.result)';
                            fpcmAjax.post();

                            return false;

                        }
                        
                    });

                },
                dlOnClose: function() {
                    jQuery(this).empty();
                }
            });

            return false;

        });
        
        jQuery('#fpcm-editor-html-insertlist-btn').click(function() {

            fpcm.ui.spinner('#listrows', {
                min: 1
            });

            fpcm.ui.dialog({
                id: 'editor-html-insertlist',
                dlWidth: size.width,
                title: fpcm.ui.translate('editorInsertUl'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('globalInsert'),
                        icon: "ui-icon-check",                        
                        click: function() {
                            fpcmEditor.insertListToFrom('ul');
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                dlOnOpen: function () {
                    fpcmEditor.setSelectToDialog(this);
                },
                dlOnClose: function() {
                    fpcmEditor.clearListForm();
                }
            });

            return false;
        });

        jQuery('#fpcm-editor-html-insertlistnum-btn').click(function() {

            fpcm.ui.spinner('#listrows', {
                min: 1
            });

            fpcm.ui.dialog({
                id: 'editor-html-insertlist',
                dlWidth: size.width,
                title: fpcm.ui.translate('editorInsertOl'),
                dlButtons: [
                    {
                        text: fpcm.ui.translate('globalInsert'),
                        icon: "ui-icon-check",                        
                        click: function() {
                            fpcmEditor.insertListToFrom('ol');
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: fpcm.ui.translate('close'),
                        icon: "ui-icon-closethick",                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                dlOnOpen: function () {
                    fpcmEditor.setSelectToDialog(this);
                },
                dlOnClose: function() {
                    fpcmEditor.clearListForm();
                }
            });

            return false;
        });

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
            image_advtab                 : true,
            resize                       : true,
            convert_urls                 : true,
            browser_spellcheck           : true,
            default_link_target          : "_blank",
            autoresize_min_height        : '500',
            image_caption                : true,
            autosave_prefix              : fpcmTinyMceAutosavePrefix,
            autosave_retention           : "15m",
            autosave_restore_when_empty  : false,
            link_assume_external_targets : true,
            images_upload_url            : fpcmTinyMceFileUpload ? fpcmAjaxActionPath + 'editor/imgupload' : false,
            automatic_uploads            : fpcmTinyMceFileUpload,
            images_reuse_filename        : true,
            file_picker_callback    : function(callback, value, meta) {
                tinymce.activeEditor.windowManager.open({
                    file            : fpcmFileManagerUrl + fpcmFileManagerUrlMode,
                    title           : fpcm.ui.translate('fileManagerHeadline'),
                    width           : fpcm.ui.getDialogSizes().width,
                    height          : fpcm.ui.getDialogSizes().height,
                    close_previous  : false,
                    buttons  : [
                        {
                            text: fpcm.ui.translate('extended'),                   
                            onclick: function() {
                                var tinyMceWins = top.tinymce.activeEditor.windowManager.getWindows();
                                jQuery('#'+ tinyMceWins[1]._id).find('iframe').contents().find('.fpcm-filemanager-buttons').fadeToggle();
                            }
                        },
                        {
                            text: fpcm.ui.translate('close'),                      
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
    };

};

jQuery(document).ready(function() {
    
    fpcmJs.setFocus('articletitle');
    
    fpcmEditor = new fpcmEditor();
    
    fpcm.ui.checkboxradio('.fpcm-ui-editor-categories .fpcm-ui-input-checkbox', { icon: false });

    fpcm.ui.selectmenu('#fpcm-editor-paragraphs', {
        select: function( event, ui ) {
            if (!ui.item.value) {
                return false;
            }

            fpcmEditor.insert('<' + ui.item.value + '>', '</' + ui.item.value + '>');
        },
        change: function( event, ui ) {            
            this.selectedIndex = 0;
            this.value = '';
            jQuery(this).selectmenu("refresh");
        }
    });

    fpcm.ui.selectmenu('#fpcm-editor-styles', {
        select: function( event, ui ) {
            if (!ui.item.value) {
                return false;
            }

            fpcmEditor.insert(' class="' + ui.item.value + '"', '');
        },
        change: function( event, ui ) {            
            this.selectedIndex = 0;
            this.value = '';
            jQuery(this).selectmenu("refresh");
        }
    });

    fpcm.ui.selectmenu('#fpcm-editor-fontsizes', {
        select: function( event, ui ) {
            if (!ui.item.value) {
                return false;
            }

            fpcmEditor.insertFontsize(ui.item.value);
        },
        change: function( event, ui ) {            
            this.selectedIndex = 0;
            this.value = '';
            jQuery(this).selectmenu("refresh");
        }
    });

    jQuery('.fpcm-editor-htmlclick').click(function() {        
        var tag = jQuery(this).attr('htmltag');
        fpcmEditor.insert('<' + tag + '>', '</' + tag + '>');
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
   
    jQuery('#fpcm-editor-html-insertiframe-btn').click(function() {
        fpcmEditor.insertFrame();
        return false;
    });
    
    jQuery('#fpcm-editor-html-insertmore-btn').click(function() {
        fpcmEditor.insertMoreArea();
        return false;
    });

    jQuery('#fpcm-editor-html-removetags-btn').click(function() {
        
        fpcmAjax.action     = 'editor/cleartags';
        fpcmAjax.data       = {text: editor.doc.getValue()};
        fpcmAjax.execDone   = 'window.editor.doc.setValue(fpcmAjax.result);';
        fpcmAjax.post();
        
        return false;
    });

    fpcm.ui.button('#fpcmeditorextended', {},
    function() {

        var size = fpcm.ui.getDialogSizes();

        fpcm.ui.dialog({
            id: 'editor-extended',
            dlWidth: size.width,
            title: fpcm.ui.translate('extended'),
            dlButtons: [
                {
                    text: fpcm.ui.translate('close'),
                    icon: "ui-icon-closethick",
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
        
        jQuery('#btnArticleSave').click(function() {
            jQuery('#fpcm-dialog-editor-extended').dialog('close');
        });
        
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
        minDate: "-0d"
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

        var size = fpcm.ui.getDialogSizes();

        fpcm.ui.dialog({
            id: 'editor-shortlink',
            dlWidth: size.width,
            title: text,
            dlButtons: [
                {
                    text: fpcm.ui.translate('close'),
                    icon: "ui-icon-closethick",                        
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
    
    fpcm.ui.checkboxradio('#fpcm-dialog-editor-extended .fpcm-ui-input-checkbox', {
        icon: false
    });
    
    /**
     * Keycodes
     * http://www.brain4.de/programmierecke/js/tastatur.php
     */
    jQuery(document).keypress(function(thekey) {

        if (thekey.ctrlKey && thekey.which == 115) {
            if(jQuery("#btnArticleSave")) {
                jQuery("#btnArticleSave").click();
                return false;
            }
        }

    });  
});
