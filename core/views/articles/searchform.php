<div class="fpcm-ui-dialog-layer" id="fpcm-articles-search-dialog">
    <table class="fpcm-ui-table fpcm-ui-articles-search">
        <tr>
            <td><label><?php $FPCM_LANG->write('ARTICLE_SEARCH_TYPE'); ?>:</label><br><?php \fpcm\model\view\helper::select('searchtype', $searchTypes, -1, true, false, false, 'fpcm-articles-search-input fpcm-ui-input-select-articlesearch'); ?></td>
            <td><label><?php $FPCM_LANG->write('ARTICLE_SEARCH_USER'); ?>:</label><br><?php \fpcm\model\view\helper::select('userid', $searchUsers, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-articlesearch'); ?></td>
            <td><label><?php $FPCM_LANG->write('ARTICLE_SEARCH_CATEGORY'); ?>:</label><br><?php \fpcm\model\view\helper::select('categoryid', $searchCategories, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-articlesearch'); ?></td>
        </tr>
        <tr>
            <td><label><?php $FPCM_LANG->write('ARTICLE_SEARCH_PINNED'); ?>:</label><br><?php \fpcm\model\view\helper::select('pinned', $searchPinned, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-articlesearch'); ?></td>
            <td><label><?php $FPCM_LANG->write('ARTICLE_SEARCH_POSTPONED'); ?>:</label><br><?php \fpcm\model\view\helper::select('postponed', $searchPostponed, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-articlesearch'); ?></td>
            <td><label><?php $FPCM_LANG->write('ARTICLE_SEARCH_COMMENTS'); ?>:</label><br><?php \fpcm\model\view\helper::select('comments', $searchComments, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-articlesearch'); ?></td>
        </tr>
        <tr>
        </tr>
        <tr>
            <td><label><?php $FPCM_LANG->write('ARTICLE_SEARCH_DATE'); ?>:</label></td>            
            <td colspan="2" rowspan="3"><label><?php $FPCM_LANG->write('ARTICLE_SEARCH_TEXT'); ?>:</label><br><?php \fpcm\model\view\helper::textArea('text', 'fpcm-articles-search-input fpcm-full-width-text') ?></td>
        </tr>
        <tr>
            <td class="fpcm-ui-center"><?php \fpcm\model\view\helper::textInput('datefrom', 'fpcm-articles-search-input fpcm-full-width-date', ''); ?></td>
        </tr>
        <tr>
            <td class="fpcm-ui-center"><?php \fpcm\model\view\helper::textInput('dateto', 'fpcm-articles-search-input fpcm-full-width-date', ''); ?></td>
        </tr>
    </table>
</div>