<?php if (!$isRevision) : ?>
    <div class="fpcm-ui-dialog-layer fpcm-hidden fpcm-editor-dialog" id="fpcm-dialog-editor-extended">  
        <table class="fpcm-ui-table fpcm-ui-editor-extended">
            <tr>
                <td class="fpcm-td-select-row"><span class="fa fa-picture-o fa-fw fa-lg"></span></td>
                <td ><?php fpcm\model\view\helper::textInput('article[imagepath]', '', $article->getImagepath(), false, 512, 'TEMPLATE_ARTICLE_ARTICLEIMAGE'); ?></td>
                <td class="fpcm-td-select-row"><?php \fpcm\model\view\helper::linkButton('', 'HL_FILES_MNG', 'fpcmuieditoraimgfmg', 'fpcm-ui-button-blank fpcm-folderopen-btn'); ?></td>
            </tr>
            <?php if (!$editorMode || $article->getPostponed()) : ?>
            <tr>
                <td><span class="fa fa-clock-o fa-fw fa-lg"></span></td>
                <td colspan="2" class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('article[postponed]', '', 1, 'EDITOR_POSTPONETO', 'articlepostponed', $article->getPostponed()); ?></td>
            </tr>
            <tr class="fpcm-ui-editor-postponed <?php if (!$article->getPostponed()) : ?>fpcm-hidden<?php endif; ?>">
                <td colspan="3" class="fpcm-ui-options fpcm-ui-editor-postpone fpcm-ui-center">
                    <?php fpcm\model\view\helper::textInput('article[postponedate]', 'fpcm-ui-datepicker', fpcm\model\view\helper::dateText($postponedTimer, 'Y-m-d', true)); ?>
                    <?php fpcm\model\view\helper::textInput('article[postponehour]', 'fpcm-ui-spinner-hour', fpcm\model\view\helper::dateText($postponedTimer, 'H', true), false, 2, false, false); ?>
                    <?php fpcm\model\view\helper::textInput('article[postponeminute]', 'fpcm-ui-spinner-minutes', fpcm\model\view\helper::dateText($postponedTimer, 'i', true), false, 2, false, false); ?>
                </td>
            </tr>
            <?php endif; ?>

            <?php if ((!$editorMode || $article->getDraft()) && !$article->getArchived()) : ?>
            <tr>
                <td><span class="fa fa-file-text-o fa-fw fa-lg"></span></td>
                <td colspan="2" class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('article[draft]', '', 1, 'EDITOR_DRAFT', 'articledraft', $article->getDraft()); ?></td>
            </tr>
            <?php endif; ?>
            <?php if (!$article->getArchived()) : ?>
            <tr>
                <td><span class="fa fa-thumb-tack fa-rotate-90 fa-fw fa-lg"></span></td>
                <td colspan="2" class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('article[pinned]', '', 1, 'EDITOR_PINNED', 'articlepinned', $article->getPinned()); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td><span class="fa fa-comments-o fa-fw fa-lg"></span></td>
                <td colspan="2" class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('article[comments]', '', 1, 'EDITOR_COMMENTS', 'articlecomments', $article->getComments()); ?></td>
            </tr>
            <?php if ($editorMode) : ?>
            <tr>
                <td><span class="fa fa-archive fa-fw fa-lg"></span></td>
                <td colspan="2" class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('article[archived]', '', 1, 'EDITOR_ARCHIVE', 'articlearchived', $article->getArchived()); ?></td>
            </tr>
            <?php endif; ?>
            <?php if ($showTwitter) : ?>
            <tr>
                <td><span class="fa fa-twitter-square fa-fw fa-lg"></span></td>
                <td><?php fpcm\model\view\helper::textInput('article[tweettxt]', '', '', false, 512, 'EDITOR_TWEET_TEXT'); ?></td>
                <td><?php fpcm\model\view\helper::shortHelpButton('EDITOR_TWEET_TEXT_REPLACER', '', $FPCM_BASEMODULELINK.'system/templates', '_blank'); ?></td>
            </tr>  
            <?php endif; ?>
            <?php if ($userIsAdmin) : ?>
            <tr>
                <td><span class="fa fa-user fa-fw fa-lg"></span></td>
                <td colspan="2" class="fpcm-td-select-row"><?php fpcm\model\view\helper::select('article[author]', $changeuserList, $article->getCreateuser(), false, false); ?></td>
            </tr>        
            <?php endif; ?>

            <?php include __DIR__.'/userfields.php'; ?>
        </table>
    </div>
<?php endif; ?>

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
<?php if ($isRevision) : ?>
    <?php if ($revisionPermission) : ?><?php fpcm\model\view\helper::submitButton('articleRevisionRestore', 'EDITOR_REVISION_RESTORE', 'fpcm-ui-revision-restore fpcm-loader'); ?><?php endif; ?>
    <?php \fpcm\model\view\helper::linkButton($article->getEditLink(), 'EDITOR_BACKTOCURRENT', '', 'fpcm-back-button'); ?>
<?php else : ?>
    <?php fpcm\model\view\helper::linkButton('#', 'GLOBAL_EXTENDED', 'fpcmeditorextended', 'fpcm-button-extended'); ?>
    <?php fpcm\model\view\helper::saveButton('articleSave'); ?>
    <?php if ($editorMode) : ?><?php fpcm\model\view\helper::deleteButton('articleDelete'); ?><?php endif; ?>
<?php endif; ?>
</div>