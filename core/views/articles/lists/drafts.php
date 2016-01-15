<table class="fpcm-ui-table fpcm-ui-articles">
    <tr>
        <th></th>
        <th><?php $FPCM_LANG->write('ARTICLE_LIST_TITLE'); ?></th>
        <th class="fpcm-td-articlelist-times"></th>
        <th class="fpcm-td-articlelist-meta"></th>
        <th class="fpcm-th-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-all', '', '', '', 'fpcm-select-all-draft', false); ?></th>
    </tr>

    <?php \fpcm\model\view\helper::notFoundContainer($drafts, 5); ?>

    <?php foreach($drafts AS $articleMonth => $articles) : ?>
        <tr class="fpcm-td-spacer"><td></td></tr>
        <tr>
            <th></th>
            <th><?php $FPCM_LANG->writeMonth(fpcm\model\view\helper::dateText($articleMonth, 'n', true)); ?> <?php print fpcm\model\view\helper::dateText($articleMonth, 'Y', true); ?></th> 
            <th class="fpcm-td-articlelist-times"></th>
            <th class="fpcm-td-articlelist-meta"></th>
            <th class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-allsub', 'fpcm-select-allsub', '-draft'.$articleMonth, '', 'fpcm-select-allsub', false); ?></th>
        </tr>
        <tr class="fpcm-td-spacer"><td></td></tr>
        <?php foreach($articles AS $articleId => $article) : ?>
            <tr>
                <td class="fpcm-ui-articlelist-open">
                    <?php \fpcm\model\view\helper::linkButton($article->getArticleLink(), 'GLOBAL_FRONTEND_OPEN', '', 'fpcm-ui-button-blank fpcm-openlink-btn'); ?>
                    <?php \fpcm\model\view\helper::editButton($article->getEditLink(), $isAdmin || $permEditAll || ($permEditOwn && !$isAdmin && !$permEditAll && $currentUserId == $article->getCreateuser()) ); ?>
                </td>
                <td><strong title="<?php print substr(\fpcm\model\view\helper::escapeVal(strip_tags($article->getContent())), 0, 128); ?>..."><?php print \fpcm\model\view\helper::escapeVal(strip_tags($article->getTitle())); ?></strong></td>
                <td class="fpcm-td-articlelist-times"><?php include dirname(__DIR__).'/times.php'; ?></td>
                <td class="fpcm-td-articlelist-meta"><?php include dirname(__DIR__).'/metainfo.php'; ?></td>
                <td class="fpcm-td-select-row">
                <?php if ($isAdmin || $permEditAll || ($permEditOwn && !$isAdmin && !$permEditAll && $currentUserId == $article->getCreateuser())) : ?>                    
                    <?php fpcm\model\view\helper::checkbox('actions[ids][]', 'fpcm-list-selectbox-draft fpcm-list-selectbox-sub-draft'.$articleMonth, $articleId, '', '', false); ?>
                <?php else : ?>
                    <?php fpcm\model\view\helper::checkbox('actions[ro][]', 'fpcm-list-selectbox-draft fpcm-list-selectbox-sub-draft'.$articleMonth, $articleId, '', '', false, true); ?>
                <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>                    
</table>