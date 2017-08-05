<div class="fpcm-ui-dialog-layer fpcm-hidden" id="fpcm-dialog-articles-massedit">
    <table class="fpcm-ui-table fpcm-ui-articles-search">
        <tr>
            <td><?php \fpcm\model\view\helper::select('userid', $massEditUsers, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-massedit'); ?></td>
            <td><?php \fpcm\model\view\helper::select('categoryid', $massEditCategories, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-massedit'); ?></td>
        </tr>
        <tr>
            <td><?php \fpcm\model\view\helper::select('pinned', $massEditPinned, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-massedit'); ?></td>
            <td><?php \fpcm\model\view\helper::select('comments', $massEditComments, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-massedit'); ?></td>
        </tr>
        <tr>
            <td><?php \fpcm\model\view\helper::select('approval', $massEditApproved, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-massedit'); ?></td>
            <td><?php \fpcm\model\view\helper::select('draft', $massEditDraft, null, false, true, false, 'fpcm-articles-search-input fpcm-ui-input-select-massedit'); ?></td>
        </tr>
    </table>
</div>