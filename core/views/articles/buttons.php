<?php if (!$isRevision) : ?>
    <div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-extended-dialog">  
        <table class="fpcm-ui-table fpcm-ui-editor-extended">
            <tr>
                <td><strong><span class="fa fa-picture-o fa-fw"></span> <?php $FPCM_LANG->write('TEMPLATE_ARTICLE_ARTICLEIMAGE'); ?></strong></td>
                <td class="fpcm-td-select-row"><?php fpcm\model\view\helper::textInput('article[imagepath]', '', $article->getImagepath()); ?></td>
                <td><?php \fpcm\model\view\helper::linkButton('', 'HL_FILES_MNG', 'fpcmuieditoraimgfmg'); ?></td>
            </tr>
            <?php if (!$editorMode || $article->getPostponed()) : ?>
            <tr>
                <td><strong><span class="fa fa-clock-o fa-fw"></span> <?php $FPCM_LANG->write('EDITOR_POSTPONETO'); ?></strong></td>
                <td class="fpcm-td-select-row fpcm-ui-center"><?php fpcm\model\view\helper::checkbox('article[postponed]', '', 1, '', 'articlepostponed', $article->getPostponed()); ?></td>
            </tr>
            <tr class="fpcm-ui-editor-postponed <?php if (!$article->getPostponed()) : ?>fpcm-hidden<?php endif; ?>">
                <td colspan="2" class="fpcm-ui-options fpcm-ui-editor-postpone fpcm-ui-center">
                    <?php fpcm\model\view\helper::textInput('article[postponedate]', 'fpcm-ui-datepicker', date('Y-m-d', $postponedTimer)); ?>
                    <?php fpcm\model\view\helper::textInput('article[postponehour]', 'fpcm-ui-spinner-hour', date('H', $postponedTimer), false, 2, false, false); ?>
                    <?php fpcm\model\view\helper::textInput('article[postponeminute]', 'fpcm-ui-spinner-minutes', date('i', $postponedTimer), false, 2, false, false); ?>
                </td>
            </tr>
            <?php endif; ?>

            <?php if ((!$editorMode || $article->getDraft()) && !$article->getArchived()) : ?>
            <tr>
                <td><strong><span class="fa fa-file-text-o fa-fw"></span> <?php $FPCM_LANG->write('EDITOR_DRAFT'); ?></strong></td>
                <td class="fpcm-td-select-row fpcm-ui-center"><?php fpcm\model\view\helper::checkbox('article[draft]', '', 1, '', '', $article->getDraft()); ?></td>
            </tr>
            <?php endif; ?>
            <?php if (!$article->getArchived()) : ?>
            <tr>
                <td><strong><span class="fa fa-thumb-tack fa-rotate-90 fa-fw"></span> <?php $FPCM_LANG->write('EDITOR_PINNED'); ?></strong></td>
                <td class="fpcm-td-select-row fpcm-ui-center"><?php fpcm\model\view\helper::checkbox('article[pinned]', '', 1, '', '', $article->getPinned()); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td><strong><span class="fa fa-comments-o fa-fw"></span> <?php $FPCM_LANG->write('EDITOR_COMMENTS'); ?></strong></td>
                <td class="fpcm-td-select-row fpcm-ui-center"><?php fpcm\model\view\helper::checkbox('article[comments]', '', 1, '', '', $article->getComments()); ?></td>
            </tr>
            <?php if ($editorMode) : ?>
            <tr>
                <td><strong><span class="fa fa-archive fa-fw"></span> <?php $FPCM_LANG->write('EDITOR_ARCHIVE'); ?></strong></td>
                <td class="fpcm-td-select-row fpcm-ui-center"><?php fpcm\model\view\helper::checkbox('article[archived]', '', 1, '', '', $article->getArchived()); ?></td>
            </tr>
            <?php endif; ?>
            <?php if ($userIsAdmin) : ?>
            <tr>
                <td><strong><span class="fa fa-user fa-fw"></span> <?php $FPCM_LANG->write('EDITOR_CHANGEAUTHOR'); ?></strong></td>
                <td class="fpcm-td-select-row"><?php fpcm\model\view\helper::select('article[author]', $changeuserList, $article->getCreateuser()); ?></td>
            </tr>        
            <?php endif; ?>

            <?php include __DIR__.'/userfields.php'; ?>
        </table>
    </div>
<?php endif; ?>

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
    <table>
        <tr>
            <?php if ($isRevision) : ?>
                <td>
                    <?php if ($revisionPermission) : ?><?php fpcm\model\view\helper::submitButton('articleRevisionRestore', 'EDITOR_REVISION_RESTORE', 'fpcm-ui-revision-restore fpcm-loader'); ?><?php endif; ?>
                    <td><?php \fpcm\model\view\helper::linkButton($article->getEditLink(), 'EDITOR_BACKTOCURRENT'); ?></td>
            <?php else : ?>
                <td><?php fpcm\model\view\helper::linkButton('#', 'GLOBAL_EXTENDED', 'fpcmeditorextended', ''); ?></td>
                <td><?php fpcm\model\view\helper::saveButton('articleSave'); ?></td>
                <?php if ($editorMode) : ?><td><?php fpcm\model\view\helper::deleteButton('articleDelete'); ?></td><?php endif; ?>
            <?php endif; ?>
        </tr>
    </table>
</div>