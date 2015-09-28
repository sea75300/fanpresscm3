<div class="fpcm-ui-editor-metabox-right">
    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $article->getPinned(); ?>" title="<?php $FPCM_LANG->write('EDITOR_STATUS_PINNED'); ?>">
        <span class="fa fa-thumb-tack fa-rotate-90"></span>
    </span>

    <?php if ($showDraftStatus) : ?>
    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $article->getDraft(); ?>" title="<?php $FPCM_LANG->write('EDITOR_STATUS_DRAFT'); ?>">
        <span class="fa fa-file-text-o"></span>
    </span>
    <?php endif; ?>

    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $article->getPostponed(); ?>" title="<?php $FPCM_LANG->write('EDITOR_STATUS_POSTPONETO'); ?>">
        <span class="fa fa-clock-o"></span>
    </span>
    
    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $article->getApproval(); ?>" title="<?php $FPCM_LANG->write('EDITOR_STATUS_APPROVAL'); ?>">
        <span class="fa fa-thumbs-o-up"></span>
    </span>

    <?php if ($commentEnabledGlobal) : ?>
    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $article->getComments(); ?>" title="<?php $FPCM_LANG->write('EDITOR_STATUS_COMMENTS'); ?>">
        <span class="fa fa-comments-o"></span>
    </span>
    <?php endif; ?>
    
    <?php if ($showArchiveStatus) : ?>
    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $article->getArchived(); ?>" title="<?php $FPCM_LANG->write('EDITOR_STATUS_ARCHIVE'); ?>">
        <span class="fa fa-archive"></span>
    </span>
    <?php endif; ?>
</div>