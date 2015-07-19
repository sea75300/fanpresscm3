<table class="fpcm-ui-table fpcm-ui-articles">
    <tr>
        <th></th>
        <th><?php $FPCM_LANG->write('ARTICLE_LIST_TITLE'); ?></th>
        <th class="fpcm-th-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-all', '', '', '', 'fpcm-select-all-trash', false); ?></th>
    </tr>

    <?php if (!count($trash)) : ?>
    <tr class="fpcm-td-spacer"><td></td></tr>
    <tr>
        <td colspan="3"><?php $FPCM_LANG->write('GLOBAL_NOTFOUND2'); ?></td>
    </tr>
    <?php endif; ?>
    <?php foreach($trash AS $articleMonth => $articles) : ?>
        <tr class="fpcm-td-spacer"><td></td></tr>
        <tr>
            <th></th>
            <th><?php $FPCM_LANG->writeMonth(date('n', $articleMonth)); ?> <?php print date('Y', $articleMonth); ?></th> 
            <th class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-allsub', 'fpcm-select-allsub', $articleMonth, '', 'fpcm-select-allsub', false); ?></th>
        </tr>
        <tr class="fpcm-td-spacer"><td></td></tr>
        <?php foreach($articles AS $articleId => $article) : ?>
            <tr>
                <td><?php \fpcm\model\view\helper::linkButton($article->getArticleLink(), 'GLOBAL_FRONTEND_OPEN', '', 'fpcm-articlelist-openlink'); ?></td>
                <td><strong><?php print \fpcm\model\view\helper::escapeVal(strip_tags($article->getTitle())); ?></strong></td>
                <td class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('actions[ids][]', 'fpcm-list-selectbox fpcm-list-selectbox-sub'.$articleMonth, $articleId, '', '', false) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>                    
</table>