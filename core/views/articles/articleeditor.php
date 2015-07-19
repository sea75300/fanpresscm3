<div class="fpcm-tabs-general">
    <ul>
        <li><a href="#tabs-article"><?php $FPCM_LANG->write('ARTICLES_EDITOR'); ?></a></li>
        <?php if ($showComments && !$isRevision) : ?>
        <li><a href="#tabs-comments"><?php $FPCM_LANG->write('HL_COMMENTS_MNG'); ?> (<?php print $commentCount; ?>)</a></li>
        <?php endif; ?>
        <?php if ($showRevisions) : ?>
        <li><a href="#tabs-revisions"><?php $FPCM_LANG->write('HL_ARTICLE_EDIT_REVISIONS'); ?> (<?php print $revisionCount; ?>)</a></li>
        <?php endif; ?>
    </ul>            

    <form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $editorAction; ?>" name="nform">
        <div id="tabs-article">
            <?php include __DIR__.'/editors/'.$editorFile.'.php'; ?>                
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
                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php fpcm\model\view\helper::submitButton('articleRevisionRestore', 'EDITOR_REVISION_RESTORE', 'fpcm-ui-revision-restore fpcm-loader'); ?></td>
                            <td><?php fpcm\model\view\helper::deleteButton('revisionDelete'); ?></td>
                        </tr>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </form>
</div>
<?php if ($isRevision) : ?>
<script type="text/javascript">
    jQuery(function() {
        fpcmEditor.removeUnloadMessage();
    });
</script>
<?php endif; ?>