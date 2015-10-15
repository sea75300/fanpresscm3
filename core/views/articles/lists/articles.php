<table class="fpcm-ui-table fpcm-ui-articles">
    <tr>
        <th></th>
        <th><?php $FPCM_LANG->write('ARTICLE_LIST_TITLE'); ?></th>
        <th class="fpcm-ui-center"><?php $FPCM_LANG->write('HL_CATEGORIES_MNG'); ?></th>
        <th class="fpcm-ui-center fpcm-ui-articlelist-comments"><?php $FPCM_LANG->write('HL_COMMENTS_MNG'); ?> (<?php print $commentSum; ?>)</th>
        <th class="fpcm-td-articlelist-meta"></th>
        <th class="fpcm-th-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-all', '', '', '', 'fpcm-select-all', false); ?></th>
    </tr>

    <?php \fpcm\model\view\helper::notFoundContainer($list, 6); ?>

    <?php foreach($list AS $articleMonth => $articles) : ?>
        <tr class="fpcm-td-spacer" colspan="6"><td></td></tr>
        <tr>
            <th></th>
            <th><?php $FPCM_LANG->writeMonth(date('n', $articleMonth)); ?> <?php print date('Y', $articleMonth); ?> (<?php print count($articles); ?>)</th> 
            <th></th>
            <th class="fpcm-ui-center fpcm-ui-articlelist-comments"></th>
            <th class="fpcm-td-articlelist-meta"></th>
            <th class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-allsub', 'fpcm-select-allsub', $articleMonth, '', 'fpcm-select-allsub', false); ?></th>
        </tr>
        <tr class="fpcm-td-spacer"><td></td></tr>
        <?php foreach($articles AS $articleId => $article) : ?>
            <tr>
                <td class="fpcm-ui-articlelist-open">
                    <?php \fpcm\model\view\helper::linkButton($article->getArticleLink(), 'GLOBAL_FRONTEND_OPEN', '', 'fpcm-articlelist-openlink', '_blank'); ?>
                    <?php \fpcm\model\view\helper::editButton($article->getEditLink(), $isAdmin || $permEditAll || ($permEditOwn && !$isAdmin && !$permEditAll && $currentUserId == $article->getCreateuser()) ); ?>
                </td>
                <td>
                    <strong title="<?php print substr(\fpcm\model\view\helper::escapeVal(strip_tags($article->getContent())), 0, 128); ?>..."><?php print \fpcm\model\view\helper::escapeVal(strip_tags($article->getTitle())); ?></strong>
                    <br><?php include dirname(__DIR__).'/times.php'; ?>
                </td>
                <td><?php print implode(', ', $article->getCategories()); ?></td>
                <td class="fpcm-ui-articlelist-comments <?php if (isset($commentPrivateUnapproved[$articleId]) && $commentPrivateUnapproved[$articleId]) : ?>fpcm-ui-important-text<?php endif; ?>" <?php if (isset($commentPrivateUnapproved[$articleId]) && $commentPrivateUnapproved[$articleId]) : ?>title="<?php $FPCM_LANG->write('ARTICLE_LIST_COMMENTNOTICE'); ?>"<?php endif; ?>>
                    <?php print (isset($commentCount[$articleId])) ? $commentCount[$articleId] : 0; ?>
                </td>
                <td class="fpcm-td-articlelist-meta"><?php include dirname(__DIR__).'/metainfo.php'; ?></td>
                <td class="fpcm-td-select-row">
                <?php if ($isAdmin || $permEditAll || ($permEditOwn && !$isAdmin && !$permEditAll && $currentUserId == $article->getCreateuser())) : ?>                    
                    <?php fpcm\model\view\helper::checkbox('actions[ids][]', 'fpcm-list-selectbox fpcm-list-selectbox-sub'.$articleMonth, $articleId, '', '', false); ?>
                <?php else : ?>
                    <?php fpcm\model\view\helper::checkbox('actions[ro][]', 'fpcm-list-selectbox fpcm-list-selectbox-sub'.$articleMonth, $articleId, '', '', false, true); ?>
                <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>

<?php if ($showPager) : ?>
<table class="fpcm-ui-table fpcm-ui-articlelist-acp fpcm-ui-margin-center">
    <tr>
        <td class="fpcm-ui-center">
            <?php if ($backBtn) : ?>
                <?php \fpcm\model\view\helper::linkButton($backBtn > 1 ? $FPCM_SELF.'?module='.$listAction.'&page='.$backBtn : $FPCM_SELF.'?module='.$listAction, 'GLOBAL_BACK', '', 'fpcm-ui-pager-buttons fpcm-ui-pager-prev'); ?>
            <?php else : ?>            
                <?php \fpcm\model\view\helper::dummyButton('GLOBAL_BACK', 'fpcm-ui-pager-buttons fpcm-ui-pager-prev fpcm-ui-readonly'); ?>            
            <?php endif; ?>
        </td>
        <td class="fpcm-ui-center">            
            <?php \fpcm\model\view\helper::select('pageSelect', $pageSelectOptions, $pageCurrent, false, false); ?>
        </td class="fpcm-ui-center">
        <td class="fpcm-ui-center">
            <?php if ($nextBtn) : ?>
                <?php \fpcm\model\view\helper::linkButton($FPCM_SELF.'?module='.$listAction.'&page='.$nextBtn, 'GLOBAL_NEXT', '', 'fpcm-ui-pager-buttons fpcm-ui-pager-next'); ?>
            <?php else : ?>            
                <?php \fpcm\model\view\helper::dummyButton('GLOBAL_NEXT', 'fpcm-ui-pager-buttons fpcm-ui-pager-next fpcm-ui-readonly'); ?>            
            <?php endif; ?>
        </td>
    </tr>    
</table>
<?php endif; ?>