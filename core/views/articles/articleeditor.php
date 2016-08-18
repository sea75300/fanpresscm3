<div class="fpcm-tabs-general">
    <ul>
        <?php if ($isRevision) : ?>
        <li><a href="#tabs-article"><?php $FPCM_LANG->write('EDITOR_STATUS_REVISION'); ?></a></li>
        <?php else : ?>
        <li><a href="#tabs-article"><?php $FPCM_LANG->write('ARTICLES_EDITOR'); ?></a></li>
        <?php endif; ?>
        <?php if ($showComments && !$isRevision) : ?>
        <li><a href="#tabs-comments"><?php $FPCM_LANG->write('HL_COMMENTS_MNG'); ?> (<?php print $commentCount; ?>)</a></li>
        <?php endif; ?>
        <?php if ($showRevisions) : ?>
        <li><a href="#tabs-revisions"><?php $FPCM_LANG->write('HL_ARTICLE_EDIT_REVISIONS'); ?> (<?php print $revisionCount; ?>)</a></li>
        <?php endif; ?>
    </ul>            

    <form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $editorAction; ?>" name="nform">
        <div id="tabs-article">
            <!-- Dateimanager layer -->  
            <div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-html-filemanager"></div>            
            
            <?php include $editorFile; ?>                
            <?php include __DIR__.'/buttons.php'; ?>
        </div>

        <?php if ($showComments && !$isRevision) : ?>
            <div id="tabs-comments">
                <?php include dirname(__DIR__).'/comments/commentlist_inner.php'; ?>
            </div>
        <?php endif; ?>

        <?php if ($showRevisions) : ?>
            <div id="tabs-revisions">                
                <?php include __DIR__.'/lists/revisions.php'; ?>                

                <?php if ($revisionPermission) : ?>                
                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
                    <?php fpcm\model\view\helper::submitButton('articleRevisionRestore', 'EDITOR_REVISION_RESTORE', 'fpcm-ui-revision-restore fpcm-loader'); ?>
                    <?php fpcm\model\view\helper::deleteButton('revisionDelete'); ?>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php \fpcm\model\view\helper::pageTokenField(); ?>
    </form>
</div>