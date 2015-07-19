<div class="fpcm-ui-editor-metabox-right">
    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $comment->getSpammer(); ?>" title="<?php $FPCM_LANG->write('COMMMENT_SPAM'); ?>">
        <span class="fa fa-flag"></span>
    </span>
    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $comment->getApproved(); ?>" title="<?php $FPCM_LANG->write('COMMMENT_APPROVE'); ?>">
        <span class="fa fa-check-circle-o"></span>
    </span>
    <span class="fpcm-ui-editor-metainfo fpcm-ui-status-<?php print $comment->getPrivate(); ?>" title="<?php $FPCM_LANG->write('COMMMENT_PRIVATE'); ?>">
        <span class="fa fa-eye-slash"></span>
    </span>
</div>