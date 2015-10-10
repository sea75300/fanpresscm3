<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-pencil"></span> <?php $FPCM_LANG->write('HL_ARTICLE_EDIT'); ?>
        <?php \fpcm\model\view\helper::helpButton('articles_editor'); ?>
    </h1>
    
    <div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-comments"></div>
    
    <?php include __DIR__.'/articleeditor.php'; ?>
</div>