<!-- Link einfügen -->  
<div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-insertlink">  
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
<div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-insertimage">  
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
<div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-inserttable">  
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
<div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-insertmedia">  
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
<div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-insertcolor">  
    <table class="fpcm-ui-table">
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTCOLOR_HEXCODE'); ?>:</label></td>
            <td><?php \fpcm\model\view\helper::textInput('fpcm-dialog-editor-html-colorhexcode', '', '', false, 5); ?></td>
        </tr>   
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTCOLOR_TEXT'); ?>:</label></td>
            <td><?php fpcm\model\view\helper::radio('color_mode', 'color_mode', 'color', '', 'color_mode1'); ?></td>
        </tr>
        <tr>
            <td><label><?php $FPCM_LANG->write('EDITOR_INSERTCOLOR_BACKGROUND'); ?>:</label></td>
            <td><?php fpcm\model\view\helper::radio('color_mode', 'color_mode', 'background', '', 'color_mode2', false); ?></td>
        </tr>        
    </table>
</div>

<?php $count = 1; ?>
<!-- Smiley einfügen -->
<div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-insertsmileys"></div>

<!-- Symbol einfügen -->
<div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-insertsymbol">
    <table class="fpcm-ui-table fpcm-ui-editor-smileys">
        <tr>
        <?php for($i=161;$i<=450;$i++) : ?>
            <td><a class="fpcm-editor-htmlsymbol" symbolcode="&#<?php print $i; ?>;" href="#">&#<?php print $i; ?>;</a></td>
            <?php if ($i % 20 == 0) : ?></tr><tr><?php endif; ?>            
        <?php endfor;  ?>            
        </tr>        
    </table>
</div>

<!-- Vorlage einfügen -->
<div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-insertdraft">
    <table class="fpcm-ui-table">
        <tr>
            <td><?php \fpcm\model\view\helper::select('tpldraft', $editorTemplatesList, ''); ?></td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    var editor = null;    
    
    jQuery(document).ready(function() {        
        jQuery('#fpcm-dialog-editor-html-insertlink-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertlink',
                dlWidth: 500,
                dlHeight: 300,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTLINK'); ?>",
                dlButtons: [
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
                dlWidth: 500,
                dlHeight: 300,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTPIC'); ?>",
                dlButtons: [
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
            fpcm.ui.dialog({
                id: 'editor-html-inserttable',
                dlWidth: 300,
                dlHeight: 250,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTTABLE'); ?>",
                dlButtons: [
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
                dlWidth: 500,
                dlHeight: 250,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTCOLOR'); ?>",
                dlButtons: [
                    {
                        text: "<?php $FPCM_LANG->write('GLOBAL_INSERT'); ?>",
                        icons: {
                            primary: "ui-icon-check"            
                        },                        
                        click: function() {
                            fpcmEditor.insertColor(jQuery('#fpcmdialogeditorhtmlcolorhexcode').val(), jQuery('.color_mode:checked').val());
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
        
        jQuery('#fpcm-dialog-editor-html-insertmedia-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertmedia',
                dlWidth: 500,
                dlHeight: 250,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTMEDIA'); ?>",
                dlButtons: [
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
        
        jQuery('#fpcm-dialog-editor-html-insertsmiley-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertsmileys',
                dlWidth: 350,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTSMILEY'); ?>",
                dlButtons: [
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
                dlWidth: 600,
                dlHeight: 500,
                title: "<?php $FPCM_LANG->write('EDITOR_INSERTSYMBOL'); ?>",
                dlButtons: [
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
 
        jQuery('#fpcm-dialog-editor-html-insertdraft-btn').click(function() {
            fpcm.ui.dialog({
                id: 'editor-html-insertdraft',
                dlWidth: 350,
                dlHeight: 250,
                title: "<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_ARTICLETPL'); ?>",
                dlButtons: [
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
    });    
</script>