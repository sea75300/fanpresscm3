<!-- Dateimanager layer -->  
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-html-filemanager"></div>

<!-- Link einfügen -->  
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-html-insertlink">  
    <table class="fpcm-ui-table">
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_LINKURL'); ?>:</label></td>
            <td><?php \fpcm\model\view\helper::textInput('links[url]', '', 'http://'); ?></td>
        </tr>
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_LINKTXT'); ?>:</label></td>
            <td><?php \fpcm\model\view\helper::textInput('links[text]', '', ''); ?></td>
        </tr>        
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_LINKTARGET'); ?>:</label></td>
            <td>
                <?php \fpcm\model\view\helper::select('links[target]', $targets, ''); ?>
            </td>
        </tr>        
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_CSS_CLASS'); ?>:</label></td>
            <td>
                <?php \fpcm\model\view\helper::select('links[css]', $cssClasses, ''); ?>
            </td>
        </tr>       
    </table>
</div>

<!-- Bild einfügen -->  
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-html-insertimage">  
    <table class="fpcm-ui-table">
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_IMGPATH'); ?>:</label></td>
            <td><?php \fpcm\model\view\helper::textInput('images[path]', '', 'http://'); ?></td>
        </tr>
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_IMGALTTXT'); ?>:</label></td>
            <td><?php \fpcm\model\view\helper::textInput('images[alt]', '', ''); ?></td>
        </tr>        
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_IMGALIGN'); ?>:</label></td>
            <td>
                <?php \fpcm\model\view\helper::select('images[align]', $aligns, ''); ?>              
            </td>
        </tr>         
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_CSS_CLASS'); ?>:</label></td>
            <td>
                <?php \fpcm\model\view\helper::select('images[css]', $cssClasses, ''); ?>             
            </td>
        </tr>       
    </table>
</div>

<!-- Tabelle einfügen -->  
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-html-inserttable">  
    <table class="fpcm-ui-table fpcm-ui-table-insert">
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTTABLE_ROWS'); ?>:</label></td>
            <td><?php \fpcm\model\view\helper::textInput('table[rows]', '', 1); ?></td>
        </tr>
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTTABLE_COLS'); ?>:</label></td>
            <td><?php \fpcm\model\view\helper::textInput('table[cols]', '', 1); ?></td>
        </tr>        
    </table>
</div>

<!-- Player einfügen -->  
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-html-insertmedia">  
    <table class="fpcm-ui-table">
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_IMGPATH'); ?>:</label></td>
            <td><?php \fpcm\model\view\helper::textInput('media[path]'); ?></td>
        </tr>   
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTMEDIA_AUDIO'); ?>:</label></td>
            <td><?php fpcm\model\view\helper::radio('media[type]', '', 'audio', '', 'mediatype', true); ?></td>
        </tr>
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTMEDIA_VIDEO'); ?>:</label></td>
            <td><?php fpcm\model\view\helper::radio('media[type]', '', 'video', '', 'mediatype', false); ?></td>
        </tr>         
    </table>
</div>

<!-- Tabelle einfügen -->
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-html-insertcolor">  
    <table class="fpcm-ui-table">
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTCOLOR_HEXCODE'); ?>:</label></td>
            <td><input type="text" name="fpcm-editor-html-colorhexcode" id="fpcm-editor-html-colorhexcode" size="7" maxlength="5" value=""></td>
        </tr>   
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTCOLOR_TEXT'); ?>:</label></td>
            <td><input type="radio" name="color_mode" id="color_mode1" class="color_mode" value="color" checked="checked"></td>
        </tr>
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTCOLOR_BACKGROUND'); ?>:</label></td>
            <td><input type="radio" name="color_mode" id="color_mode2" class="color_mode" value="background"></td>
        </tr>        
    </table>
</div>

<?php $count = 1; ?>
<!-- Smiley einfügen -->
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-html-insertsmileys"></div>

<!-- Symbol einfügen -->
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-html-insertsymbol">
    <table class="fpcm-ui-table fpcm-ui-editor-smileys">
        <tr>
        <?php for($i=161;$i<=450;$i++) : ?>
            <td><a class="fpcm-editor-htmlsymbol" symbolcode="&#<?php print $i; ?>;" href="#">&#<?php print $i; ?>;</a></td>
            <?php if ($i % 20 == 0) : ?></tr><tr><?php endif; ?>            
        <?php endfor;  ?>            
        </tr>        
    </table>
</div>

<script type="text/javascript">
    var editor = null;
    
    jQuery(document).ready(function() {        
        jQuery('#fpcm-editor-html-insertlink-btn').click(function() {
            jQuery('#fpcm-editor-html-insertlink').dialog({
                width: 500,
                height: 300,
                resizable: false,
                modal: true,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTLINK'); ?>",
                buttons: [
                    {
                        text: "<?php $FPCM_LANG->write('GLOBAL_INSERT'); ?>",
                        icons: {
                            primary: "ui-icon-check"            
                        },                        
                        click: function() {
                            fpcmEditor.insertLink();
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: "<?php $FPCM_LANG->write('HL_FILES_MNG'); ?>",
                        icons: {
                            primary: "ui-icon-folder-open"            
                        },                
                        click: function() {
                            window.fileOpenMode = 1;
                            fpcmEditor.showFileManager();
                        }
                    },
                    {
                        text: "<?php $FPCM_LANG->printClose(); ?>",
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                open: function (event, ui) {
                    fpcmEditor.setSelectToDialog(this);
                },
                close: function(event, ui) {
                    fpcmEditor.clearPathTextValuesLink();
                }
            });
            return false;
        });        
        
        jQuery('#fpcm-editor-html-insertimage-btn').click(function() {
            jQuery('#fpcm-editor-html-insertimage').dialog({
                width: 500,
                height: 300,
                resizable: false,
                modal: true,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTPIC'); ?>",
                buttons: [
                    {
                        text: "<?php $FPCM_LANG->write('GLOBAL_INSERT'); ?>",
                        icons: {
                            primary: "ui-icon-check"            
                        },                        
                        click: function() {
                            fpcmEditor.insertPicture();
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: "<?php $FPCM_LANG->write('HL_FILES_MNG'); ?>",
                        icons: {
                            primary: "ui-icon-folder-open"            
                        },                
                        click: function() {
                            window.fileOpenMode = 2;
                            fpcmEditor.showFileManager();
                        }
                    },
                    {
                        text: "<?php $FPCM_LANG->printClose(); ?>",
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                open: function (event, ui) {
                    fpcmEditor.setSelectToDialog(this);
                },
                close: function( event, ui ) {
                    fpcmEditor.clearPathTextValuesImg();
                }
            });
            return false;
        });        
        
        jQuery('#fpcm-editor-html-inserttable-btn').click(function() {
            jQuery('#fpcm-editor-html-inserttable').dialog({
                width: 300,
                height: 250,
                resizable: false,
                modal: true,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTTABLE'); ?>",
                buttons: [
                    {
                        text: "<?php $FPCM_LANG->write('GLOBAL_INSERT'); ?>",
                        icons: {
                            primary: "ui-icon-check"            
                        },                        
                        click: function() {
                            fpcmEditor.insertTable();
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: "<?php $FPCM_LANG->printClose(); ?>",
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                open: function (event, ui) {
                    fpcmEditor.setSelectToDialog(this);
                },
                close: function( event, ui ) {
                    fpcmEditor.clearTableForm();
                }
            });
            return false;
        });   
        
        jQuery('#fpcm-editor-html-insertcolor-btn').click(function() {
            jQuery('#fpcm-editor-html-insertcolor').dialog({
                width: 500,
                height: 250,
                resizable: false,
                modal: true,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTCOLOR'); ?>",
                buttons: [
                    {
                        text: "<?php $FPCM_LANG->write('GLOBAL_INSERT'); ?>",
                        icons: {
                            primary: "ui-icon-check"            
                        },                        
                        click: function() {
                            fpcmEditor.insertColor(jQuery('#fpcm-editor-html-colorhexcode').val(), jQuery('.color_mode:checked').val());
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: "<?php $FPCM_LANG->printClose(); ?>",
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ]        
            });
            return false;
        });   
        
        jQuery('#fpcm-editor-html-insertmedia-btn').click(function() {
            jQuery('#fpcm-editor-html-insertmedia').dialog({
                width: 500,
                height: 250,
                resizable: false,
                modal: true,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTMEDIA'); ?>",
                buttons: [
                    {
                        text: "<?php $FPCM_LANG->write('GLOBAL_INSERT'); ?>",
                        icons: {
                            primary: "ui-icon-check"            
                        },                        
                        click: function() {
                            fpcmEditor.insertPlayer(jQuery('#mediapath').val(), jQuery('#mediatype:checked').val());
                            jQuery( this ).dialog( "close" );
                        }
                    },
                    {
                        text: "<?php $FPCM_LANG->printClose(); ?>",
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ]        
            });
            return false;
        });         
        
        jQuery('#fpcm-editor-html-insertsmiley-btn').click(function() {
            jQuery('#fpcm-editor-html-insertsmileys').dialog({
                width: 350,
                resizable: false,
                modal: true,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTSMILEY'); ?>",
                buttons: [
                    {
                        text: "<?php $FPCM_LANG->printClose(); ?>",
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                        
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ],
                open: function (event, ui) {
                    jQuery.ajax({
                        url: fpcmAjaxActionPath + 'editor/smileys',
                        type: "POST",
                        async: false,
                        success: function(data) {
                            jQuery('#fpcm-editor-html-insertsmileys').append(data);
                        }
                    })
                    .fail(function() {
                        alert(fpcmAjaxErrorMessage);
                    });

                    jQuery('.fpcm-editor-htmlsmiley').click(function() {
                        fpcmEditor.insertSmilies(jQuery(this).attr('smileycode'));
                    });
                },
                close: function( event, ui ) {
                    jQuery(this).empty();
                }
            });
            return false;
        });         
        
        jQuery('#fpcm-editor-html-insertsymbol-btn').click(function() {
            jQuery('#fpcm-editor-html-insertsymbol').dialog({
                width: 600,
                height: 500,
                resizable: false,
                modal: true,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTSYMBOL'); ?>",
                buttons: [
                    {
                        text: "<?php $FPCM_LANG->printClose(); ?>",
                        icons: {
                            primary: "ui-icon-closethick"            
                        },                        
                        click: function() {
                            jQuery( this ).dialog( "close" );
                        }
                    }
                ]
            });
            return false;
        });
    });    
</script>