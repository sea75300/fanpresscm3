<?php if ($permRename || $permThumbs || $permDelete) : ?>
<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-filemanager-buttons">
    <table>
        <tr>
            <td><?php fpcm\model\view\helper::checkbox('fpcm-select-all', 'fpcm-select-all-checkbutton', '', 'GLOBAL_SELECTALL', 'fpcm-select-all', false); ?></td>
            <?php if ($permRename) : ?>
                <td><?php fpcm\model\view\helper::submitButton('renameFiles', 'FILE_LIST_RENAME', 'fpcm-loader fpcm-rename-btn'); ?> 
                <input type="hidden" name="newfilename" id="newfilename" value=""><td>
            <?php endif; ?>
            <?php if ($permThumbs) : ?>
                <td><?php fpcm\model\view\helper::submitButton('createThumbs', 'FILE_LIST_NEWTHUMBS', 'fpcm-loader fpcm-newthumb-btn'); ?></td>
            <?php endif; ?>
            <?php if ($permDelete) : ?>
                <td><?php fpcm\model\view\helper::deleteButton('deleteFiles'); ?></td>
            <?php endif; ?>
        </tr>
    </table>
</div>
<?php endif; ?>