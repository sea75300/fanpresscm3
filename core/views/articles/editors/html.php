<?php include __DIR__.'/html_dialogs.php'; ?>
<table class="fpcm-ui-table">
    <?php if ($editorMode) : ?>
    <tr>
        <td>
            <div class="fpcm-ui-editor-metabox">
                <?php include dirname(__DIR__).'/times.php'; ?>
                <?php include dirname(__DIR__).'/metainfo.php'; ?>
                <div class="fpcm-clear"></div>
            </div>
        </td>
    </tr>    
    <?php endif; ?>
    <tr>
        <td>
            <?php \fpcm\model\view\helper::textInput('article[title]', 'fpcm-full-width', $article->getTitle()); ?>
        </td>
    </tr>
    <tr>
        <td class="fpcm-ui-editor-categories">
            <?php include dirname(__DIR__).'/categories.php'; ?>
        </td>
    </tr>
    <tr>
        <td class="ui-widget-content ui-corner-all ui-state-normal">
            <div class="fpcm-editor-selectboxes">
                <?php if (count($editorStyles)) : ?>
                <div class="fpcm-fpcm-editor-selectbox">
                    <button class="fpcm-ui-button fpcm-editor-select-button" id="fpcm-editor-styles"><?php $FPCM_LANG->write('EDITOR_SELECTSTYLES'); ?></button>
                    <div class="fpcm-editor-select">
                        <ul class="fpcm-editor-smenu">
                            <?php foreach ($editorStyles as $description => $tag) : ?>
                            <li class="fpcm-editor-cssclick" htmltag="<?php print $tag; ?>"><a><?php print $description; ?></a></li>
                            <?php endforeach; ?>
                        </ul>              
                    </div>                
                </div>
                <?php endif; ?>

                <div class="fpcm-fpcm-editor-selectbox">
                    <button class="fpcm-ui-button fpcm-editor-select-button" id="fpcm-editor-paragraphs"><?php $FPCM_LANG->write('EDITOR_PARAGRAPH'); ?></button>
                    <div class="fpcm-editor-select">
                        <ul class="fpcm-editor-smenu">
                            <?php foreach ($editorParagraphs as $descr => $tag) : ?>
                            <li class="fpcm-editor-htmlclick" htmltag="<?php print $tag; ?>"><a><?php print $descr; ?></a></li>
                            <?php endforeach; ?>                   
                        </ul>              
                    </div>                
                </div>

                <div class="fpcm-fpcm-editor-selectbox">
                    <button class="fpcm-ui-button fpcm-editor-select-button" id="fpcm-editor-fontsizes"><?php $FPCM_LANG->write('EDITOR_SELECTFS'); ?></button>
                    <div class="fpcm-editor-select">
                        <ul class="fpcm-editor-smenu">
                            <?php foreach ($editorFontsizes as $editorFontsize) : ?>
                            <li class="fpcm-editor-htmlfontsize" htmltag="<?php print $editorFontsize; ?>"><a><?php print $editorFontsize; ?>pt</a></li>
                            <?php endforeach; ?>
                        </ul>              
                    </div>                
                </div>                    
            </div>

            <div class="fpcm-ui-buttonset fpcm-ui-editor-buttons">
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_BOLD'); ?> (Ctrl + B)" class="fpcm-editor-htmlclick" htmltag="b"><span class="fa fa-bold"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_ITALIC'); ?> (Ctrl + I)" class="fpcm-editor-htmlclick" htmltag="i"><span class="fa fa-italic"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_UNDERLINE'); ?> (Ctrl + U)" class="fpcm-editor-htmlclick" htmltag="u"><span class="fa fa-underline"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_STRIKE'); ?> (Ctrl + O)" class="fpcm-editor-htmlclick" htmltag="s"><span class="fa fa-strikethrough"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_INSERTCOLOR'); ?> (Ctrl + Shift + F)" id="fpcm-dialog-editor-html-insertcolor-btn" onclick="return false;"><span class="fa fa-tint"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_SUP'); ?> (Ctrl + Y)" class="fpcm-editor-htmlclick" htmltag="sup"><span class="fa fa-superscript"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_SUB'); ?> (Ctrl + Shift + Y)" class="fpcm-editor-htmlclick" htmltag="sub"><span class="fa fa-subscript"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_ALEFT'); ?> (Ctrl + Shift + L)" class="fpcm-editor-alignclick" htmltag="left"><span class="fa fa-align-left"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_ACENTER'); ?> (Ctrl + Shift + C)" class="fpcm-editor-alignclick" htmltag="center"><span class="fa fa-align-center"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_ARIGHT'); ?> (Ctrl + Shift + R)" class="fpcm-editor-alignclick" htmltag="right"><span class="fa fa-align-right"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_AJUSTIFY'); ?> (Ctrl + Shift + J)" class="fpcm-editor-alignclick" htmltag="justify"><span class="fa fa-align-justify"></span></button>            
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_LISTUL'); ?> (Ctrl + .)" id="fpcm-dialog-editor-html-insertlist-btn"><span class="fa fa-list-ul"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_LISTOL'); ?> (Ctrl + #)" id="fpcm-dialog-editor-html-insertlistnum-btn"><span class="fa fa-list-ol"></span></button>            
                <button title="<?php $FPCM_LANG->write('EDITOR_INSERTTABLE'); ?> (Ctrl + Q)" class="fpcm-editor-htmlclick" htmltag="blockquote"><span class="fa fa-quote-left"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_INSERTLINK'); ?>  (Ctrl + L)" id="fpcm-dialog-editor-html-insertlink-btn"><span class="fa fa-link"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_INSERTPIC'); ?>  (Ctrl + P)" id="fpcm-dialog-editor-html-insertimage-btn"><span class="fa fa-picture-o"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_INSERTMEDIA'); ?> (Ctrl + Shift + Z)" id="fpcm-dialog-editor-html-insertmedia-btn"><span class="fa fa-youtube-play"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_IFRAME'); ?> (Ctrl + F)" id="fpcm-dialog-editor-html-insertiframe-btn"><span class="fa fa-puzzle-piece"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_READMORE'); ?> (Ctrl + M)" id="fpcm-dialog-editor-html-insertmore-btn"><span class="fa fa-plus-square"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_INSERTTABLE'); ?> (Ctrl + Shift + T)" id="fpcm-dialog-editor-html-inserttable-btn"><span class="fa fa-table"></span></button>
                <button title="<?php $FPCM_LANG->write('HL_OPTIONS_SMILEYS'); ?> (Ctrl + Shift + E)" id="fpcm-dialog-editor-html-insertsmiley-btn"><span class="fa fa-smile-o"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_ARTICLETPL'); ?> (Ctrl + Shift + D)" id="fpcm-dialog-editor-html-insertdraft-btn"><span class="fa fa-file-text-o"></span></button>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_SYMBOL'); ?> (Ctrl + Shift + I)" id="fpcm-dialog-editor-html-insertsymbol-btn"><span class="fa fa-font"></span></button>
            <?php if (count($extraButtons)) : ?>
                <?php foreach ($extraButtons as $extraButton)  : ?>
                <button title="<?php print $extraButton['title']; ?>" class="fpcm-editor-htmlclick <?php print $extraButton['class']; ?>" htmltag="<?php print $extraButton['htmltag']; ?>" id="fpcm-dialog-editor-html-<?php print $extraButton['id']; ?>-btn"><span class="<?php print $extraButton['icon']; ?>"></span></button>
                <?php endforeach; ?>
            <?php endif; ?>
                <button title="<?php $FPCM_LANG->write('EDITOR_HTML_BUTTONS_REMOVESTYLE'); ?> (Ctrl + Shift + S)" id="fpcm-dialog-editor-html-removetags-btn"><span class="fa fa-eraser"></span></button>
            </div>                
        </td>
    </tr>
    <tr>
        <td style="font-size: <?php print $editorDefaultFontsize; ?>">
            <?php \fpcm\model\view\helper::textArea('article[content]', 'fpcm-full-width', $article->getContent()) ?>
        </td>
    </tr>
</table>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmEditor.initCodeMirror();
    });    
</script>