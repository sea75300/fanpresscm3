<table class="fpcm-ui-table">
    <tr>
        <td colspan="2">
            <div class="fpcm-ui-editor-metabox">
                <div class="fpcm-ui-editor-metabox-left">
                    <strong><?php $FPCM_LANG->write('COMMMENT_CREATEDATE'); ?>:</strong> <?php \fpcm\model\view\helper::dateText($comment->getCreatetime()); ?><br>
                    <?php print $changeInfo; ?><br>
                    <strong><?php $FPCM_LANG->write('COMMMENT_IPADDRESS'); ?>:</strong> <?php print $comment->getIpaddress(); ?><br>                    
                </div>                
                <?php include __DIR__.'/metainfo.php'; ?>
                <div class="fpcm-clear"></div>
            </div>
        </td>
    </tr>
    <tr>
        <td><strong><?php $FPCM_LANG->write('COMMMENT_AUTHOR'); ?></strong>:</td>
        <td><?php \fpcm\model\view\helper::textInput('comment[name]', 'fpcm-full-width', $comment->getName()); ?></td>
    </tr> 
    <tr>
        <td><strong><?php $FPCM_LANG->write('GLOBAL_EMAIL'); ?></strong>:</td>
        <td><?php \fpcm\model\view\helper::textInput('comment[email]', 'fpcm-full-width', $comment->getEmail()); ?></td>
    </tr> 
    <tr>
        <td><strong><?php $FPCM_LANG->write('COMMMENT_WEBSITE'); ?></strong>:</td>
        <td><?php \fpcm\model\view\helper::textInput('comment[website]', 'fpcm-full-width', $comment->getWebsite()); ?></td>
    </tr>
    <?php if ($permApprove || $permPrivate) : ?>
    <tr>
        <td colspan="2">
            <div class="fpcm-ui-buttonset">
                <?php if ($permApprove) : ?>
                    <?php fpcm\model\view\helper::checkbox('comment[spam]', '', 1, 'COMMMENT_SPAM', 'spam', $comment->getSpammer()); ?>
                    <?php fpcm\model\view\helper::checkbox('comment[approved]', '', 1, 'COMMMENT_APPROVE', 'approved', $comment->getApproved()); ?>
                <?php endif; ?>
                <?php if ($permPrivate) : ?><?php fpcm\model\view\helper::checkbox('comment[private]', '', 1, 'COMMMENT_PRIVATE', 'private', $comment->getPrivate()); ?><?php endif; ?>
            </div>
        </td>
    </tr>
    <?php endif; ?>
    <tr>
         <td><strong><?php $FPCM_LANG->write('COMMMENT_TEXT'); ?></strong>:</td>
        <td><?php \fpcm\model\view\helper::textArea('comment[text]', 'fpcm-full-width', stripslashes($comment->getText()), false, false); ?></td>
    </tr>
</table>

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> <?php if ($commentsMode == 2) : ?>fpcm-hidden<?php endif; ?>">
    <table>
        <tr>
            <td><?php fpcm\model\view\helper::saveButton('commentSave'); ?></td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmEditor.initTinyMceComment();
        fpcmJs.setFocus('commentname');
    });
</script>