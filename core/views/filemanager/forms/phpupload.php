<form action="<?php print $actionPath; ?>" method="POST" enctype="multipart/form-data">
    <p><?php print $maxFilesInfo; ?></p>
    
    <table id="fpcm-ui-phpupload-filelist" class="fpcm-ui-table fpcm-ui-phpupload"></table>
    
    <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-filemanager-buttons">
        <?php fpcm\model\view\helper::linkButton('#', 'FILE_FORM_FILEADD', 'btnAddFile') ?>
        <?php fpcm\model\view\helper::submitButton('uploadFile', 'FILE_FORM_UPLOADSTART', 'start-upload fpcm-loader'); ?>

        <button type="reset" class="cancel-upload" id="btnCancelUpload"><?php $FPCM_LANG->write('FILE_FORM_UPLOADCANCEL'); ?></button>

    </div>
    <input type="file" name="files[]" multiple class="fpcm-ui-fileinput-select fpcm-hidden">
</form>