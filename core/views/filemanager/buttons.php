<?php if ($permRename || $permThumbs || $permDelete) : ?>
<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-filemanager-buttons <?php if ($mode > 1) : ?>fpcm-hidden<?php endif; ?>">
<?php fpcm\model\view\helper::checkbox('fpcm-select-all', 'fpcm-select-all-checkbutton', '', '', 'fpcm-select-all', false); ?>
<?php if ($permRename) : ?>
    <?php fpcm\model\view\helper::submitButton('renameFiles', 'FILE_LIST_RENAME', 'fpcm-loader fpcm-rename-btn'); ?> 
    <input type="hidden" name="newfilename" id="newfilename" value="">
<?php endif; ?>
<?php if ($permThumbs) : ?>
    <?php fpcm\model\view\helper::submitButton('createThumbs', 'FILE_LIST_NEWTHUMBS', 'fpcm-loader fpcm-newthumb-btn'); ?>
<?php endif; ?>
<?php if ($permDelete) : ?>
    <?php fpcm\model\view\helper::deleteButton('deleteFiles'); ?>
<?php endif; ?>
</div>
<?php endif; ?>