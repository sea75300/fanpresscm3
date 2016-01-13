<table class="fpcm-ui-table fpcm-ui-comments">
    <tr>
        <th <?php if ($commentsMode == 1) : ?>class="fpcm-ui-articlelist-open"<?php endif; ?>></th>
        <th><?php $FPCM_LANG->write('COMMMENT_AUTHOR'); ?></th>
        <th><?php $FPCM_LANG->write('GLOBAL_EMAIL'); ?></th>
        <th><?php $FPCM_LANG->write('COMMMENT_CREATEDATE'); ?></th>
        <th></th>
        <th class="fpcm-th-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-all', '', '', '', 'fpcm-select-all', false); ?></th>
    </tr>
    
    <?php \fpcm\model\view\helper::notFoundContainer($comments, 6); ?>

    <tr class="fpcm-td-spacer"><td></td></tr>
    <?php foreach($comments AS $comment) : ?>
    <tr>
        <td <?php if ($commentsMode == 1) : ?>class="fpcm-ui-articlelist-open"<?php endif; ?>>
            <?php if ($commentsMode == 1) : ?><?php \fpcm\model\view\helper::linkButton($comment->getArticleLink(), 'GLOBAL_FRONTEND_OPEN', '', 'fpcm-openlink-btn', '_blank'); ?><?php endif; ?>
            <?php \fpcm\model\view\helper::editButton($comment->getEditLink().'&mode='.$commentsMode, $isAdmin || $permEditAll || ($permEditOwn && !$isAdmin && !$permEditAll && in_array($comment->getArticleid(), $ownArticleIds)), $commentsMode == 2 ? 'fpcm-ui-commentlist-link': ''); ?>
        </td>
        <td><strong title="<?php print substr(\fpcm\model\view\helper::escapeVal($comment->getText()), 0, 100); ?>..."><?php print \fpcm\model\view\helper::escapeVal($comment->getName()); ?></strong></td>
        <td><?php print \fpcm\model\view\helper::escapeVal($comment->getEmail()); ?></td>
        <td><?php print date($FPCM_DATETIME_MASK, $comment->getCreatetime()); ?></td>
        <td class="fpcm-td-commentlist-meta"><?php include __DIR__.'/metainfo.php'; ?></td>
        <td class="fpcm-td-select-row">
        <?php if ($isAdmin || $permEditAll || ($permEditOwn && !$isAdmin && !$permEditAll && in_array($comment->getArticleid(), $ownArticleIds))) : ?>                    
            <?php fpcm\model\view\helper::checkbox('ids[]', 'fpcm-list-selectbox', $comment->getId(), '', '', false); ?>
        <?php else : ?>
            <?php fpcm\model\view\helper::checkbox('ids[ro]', 'fpcm-list-selectbox', '', '', '', false, true); ?>
        <?php endif; ?>            
        </td>
    </tr>      
    <?php endforeach; ?>
</table>

<?php if ($permApprove || $permPrivate || $deleteCommentsPermissions) : ?>
<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-commentaction-buttons">
    <table>
        <tr>
        <?php if ($permApprove) : ?>
            <td><?php fpcm\model\view\helper::submitButton('spammerComments', 'COMMMENT_SPAM_BTN', 'fpcm-loader fpcm-ui-commentaction fpcm-ui-commentaction-spam'); ?></td>
            <td><?php fpcm\model\view\helper::submitButton('approveComments', 'COMMMENT_APPROVE_BTN', 'fpcm-loader fpcm-ui-commentaction fpcm-ui-commentaction-approve'); ?></td>
        <?php endif; ?>
        <?php if ($permPrivate) : ?>
            <td><?php fpcm\model\view\helper::submitButton('privateComments', 'COMMMENT_PRIVATE_BTN', 'fpcm-loader fpcm-ui-commentaction fpcm-ui-commentaction-private'); ?></td>
        <?php endif; ?>

        <?php if ($deleteCommentsPermissions) : ?>
            <td><?php fpcm\model\view\helper::deleteButton('deleteComments'); ?></td>
        <?php endif; ?>
        </tr>
    </table>
</div>
<?php endif; ?>