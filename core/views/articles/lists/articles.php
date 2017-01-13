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
        <tr class="fpcm-td-spacer"><td colspan="6"></td></tr>
        <tr>
            <th></th>
            <th><?php $FPCM_LANG->writeMonth(fpcm\model\view\helper::dateText($articleMonth, 'n', true)); ?> <?php print fpcm\model\view\helper::dateText($articleMonth, 'Y', true); ?> (<?php print count($articles); ?>)</th> 
            <th></th>
            <th class="fpcm-ui-center fpcm-ui-articlelist-comments"></th>
            <th class="fpcm-td-articlelist-meta"></th>
            <th class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-allsub', 'fpcm-select-allsub', $articleMonth, '', 'fpcm-select-allsub'.$articleMonth, false); ?></th>
        </tr>
        <tr class="fpcm-td-spacer"><td></td></tr>
        <?php foreach($articles AS $articleId => $article) : ?>
            <tr>
                <td class="fpcm-ui-articlelist-open">
                    <?php \fpcm\model\view\helper::linkButton($article->getArticleLink(), 'GLOBAL_FRONTEND_OPEN', '', 'fpcm-ui-button-blank fpcm-openlink-btn', '_blank'); ?>
                    <?php \fpcm\model\view\helper::editButton($article->getEditLink(), $article->getEditPermission() ); ?>
                </td>
                <td>
                    <strong title="<?php print substr(\fpcm\model\view\helper::escapeVal(strip_tags($article->getContent())), 0, 128); ?>..."><?php print \fpcm\model\view\helper::escapeVal(strip_tags($article->getTitle())); ?></strong>
                    <br><?php include dirname(__DIR__).'/times.php'; ?>
                </td>
                <td><?php print implode(', ', $article->getCategories()); ?></td>
                <td class="fpcm-ui-articlelist-comments">
                    <?php print (isset($commentCount[$articleId])) ? $commentCount[$articleId] : 0; ?>
                    <?php if (isset($commentPrivateUnapproved[$articleId]) && $commentPrivateUnapproved[$articleId]) : ?>
                    <span class="fa fa-comments-o fa-fw fa-lg fpcm-ui-important-text" title="<?php $FPCM_LANG->write('ARTICLE_LIST_COMMENTNOTICE'); ?>"></span><?php endif; ?>
                </td>
                <td class="fpcm-td-articlelist-meta"><?php include dirname(__DIR__).'/metainfo.php'; ?></td>
                <td class="fpcm-td-select-row">
                <?php if ($article->getEditPermission()) : ?>                    
                    <?php fpcm\model\view\helper::checkbox('actions[ids][]', 'fpcm-list-selectbox fpcm-list-selectbox-sub'.$articleMonth, $articleId, '', 'chbx'.$articleId, false); ?>
                <?php else : ?>
                    <?php fpcm\model\view\helper::checkbox('actions[ro][]', 'fpcm-list-selectbox fpcm-list-selectbox-sub'.$articleMonth, $articleId, '', 'chbx'.$articleId, false, true); ?>
                <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>

<?php include dirname(dirname(__DIR__)).'/components/pager.php'; ?>