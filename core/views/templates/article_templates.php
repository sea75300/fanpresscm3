<div class="fpcm-content-wrapper">

    <table class="fpcm-ui-table fpcm-ui-backups">
        <tr>
            <th><?php $FPCM_LANG->write('FILE_LIST_FILENAME'); ?></th>
            <th><?php $FPCM_LANG->write('FILE_LIST_FILESIZE'); ?></th>
            <th class="fpcm-th-select-row"></th>
        </tr>
        <?php fpcm\model\view\helper::notFoundContainer($templateFiles, 3); ?>

        <tr class="fpcm-td-spacer"><td></td></tr>
        <?php foreach ($templateFiles as $value) : ?>
        <tr>
            <td><?php print basename($value); ?></td>
            <td><?php print \fpcm\classes\tools::calcSize(filesize($value)); ?></td>
            <td class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('deltplfiles[]', 'fpcm-list-selectbox', base64_encode(basename($value)), '', '', false); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr class="fpcm-td-spacer" colspan="3"><td></td></tr>
    </table>

    <table id="fpcm-ui-phpupload-filelist" class="fpcm-ui-table fpcm-ui-phpupload"></table>

</div>

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>" id="article_template_buttons">
    <table>
        <tr>
            <td>
                <span class="fpcm-ui-fileinput-php">
                    <?php fpcm\model\view\helper::linkButton('#', 'FILE_FORM_FILEADD') ?>
                    <?php fpcm\model\view\helper::submitButton('uploadFile', 'FILE_FORM_UPLOADSTART', 'start-upload fpcm-loader'); ?>
                    <input type="file" name="files[]" class="fpcm-ui-fileinput-select fpcm-hidden">
                </span>
            </td>
            <td><?php fpcm\model\view\helper::deleteButton('fileDelete'); ?></td>
        </tr>
    </table>
</div>