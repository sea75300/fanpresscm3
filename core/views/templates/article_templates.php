<table class="fpcm-ui-table fpcm-ui-backups">
    <tr>
        <th class="fpcm-ui-editbutton-col"></th>
        <th><?php $FPCM_LANG->write('FILE_LIST_FILENAME'); ?></th>
        <th><?php $FPCM_LANG->write('FILE_LIST_FILESIZE'); ?></th>
        <th class="fpcm-th-select-row"></th>
    </tr>
    <?php fpcm\model\view\helper::notFoundContainer($templateFiles, 4); ?>

    <tr class="fpcm-td-spacer"><td></td></tr>
    <?php foreach ($templateFiles as $templateFile) : ?>
    <tr>
        <td class="fpcm-ui-editbutton-col fpcm-ui-center"><?php \fpcm\model\view\helper::linkButton($templateFile->getFileUrl(), 'GLOBAL_DOWNLOAD', '', 'fpcm-ui-button-blank fpcm-download-btn', '_blank'); ?></td>
        <td><?php print $templateFile->getFilename(); ?></td>
        <td><?php print \fpcm\classes\tools::calcSize($templateFile->getFilesize()); ?></td>
        <td class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('deltplfiles[]', 'fpcm-list-selectbox', base64_encode($templateFile->getFilename()), '', '', false); ?></td>
    </tr>
    <?php endforeach; ?>
    <tr class="fpcm-td-spacer" colspan="3"><td></td></tr>
</table>

<table id="fpcm-ui-phpupload-filelist" class="fpcm-ui-table fpcm-ui-phpupload"></table>

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>" id="article_template_buttons">
    <table>
        <tr>
            <td>
                <span class="fpcm-ui-fileinput-php">
                    <?php fpcm\model\view\helper::linkButton('#', 'FILE_FORM_FILEADD', 'btnAddFile') ?>
                    <?php fpcm\model\view\helper::submitButton('uploadFile', 'FILE_FORM_UPLOADSTART', 'start-upload fpcm-loader'); ?>
                    <button type="reset" class="cancel-upload" id="btnCancelUpload"><?php $FPCM_LANG->write('FILE_FORM_UPLOADCANCEL'); ?></button>
                    <input type="file" name="files[]" multiple class="fpcm-ui-fileinput-select fpcm-hidden">
                </span>
            </td>
            <td><?php fpcm\model\view\helper::deleteButton('fileDelete'); ?></td>
        </tr>
    </table>
</div>