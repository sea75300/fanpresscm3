<?php if (!count($files)) : ?>
<table class="fpcm-ui-table fpcm-ui-filemanager">
    <tr>
        <td colspan="4"><?php $FPCM_LANG->write('GLOBAL_NOTFOUND2'); ?></td>
    </tr>
</table>
<?php endif; ?> 
<div class="fpcm-filelist-images">
    <?php foreach($files AS $file) : ?>
    <div class="fpcm-filelist-thumb-box">
        <div class="fpcm-filelist-thumb-box-inner">
            <div class="fpcm-ui-center">
                <a href="<?php print $file->getImageUrl(); ?>" target="_blank" class="fpcm-link-fancybox fpcm-filelist-thumb-link" rel="fpcm-link-fancybox"><img src="<?php if (file_exists($file->getFileManagerThumbnail())) : ?><?php print $file->getFileManagerThumbnailUrl(); ?><?php else : ?><?php print $FPCM_THEMEPATH; ?>dummy.png<?php endif; ?>" width="100" height="100" title="<?php print $file->getFileName(); ?>"></a>
            </div>

            <div class="fpcm-filelist-actions-box fpcm-ui-center">
                <div class="fpcm-filelist-actions">
                    <a href="<?php print $file->getThumbnailUrl(); ?>" class="fpcm-filelist-link-thumb fpcm-ui-filelist-button" target="_blank"><?php $FPCM_LANG->write('FILE_LIST_OPEN_THUMB'); ?></a>
                    <a href="<?php print $file->getImageUrl(); ?>" target="_blank" class="fpcm-filelist-link-full fpcm-file-list-link"><?php $FPCM_LANG->write('FILE_LIST_OPEN_FULL'); ?></a>
                    <?php if ($mode == 1) : ?>
                    <a href="<?php print $file->getThumbnailUrl(); ?>" imgtxt="<?php print $file->getFilename(); ?>" class="fpcm-filelist-tinymce-thumb fpcm-ui-filelist-button"><?php $FPCM_LANG->write('FILE_LIST_INSERT_THUMB'); ?></a>
                    <a href="<?php print $file->getImageUrl(); ?>" imgtxt="<?php print $file->getFilename(); ?>" class="fpcm-filelist-tinymce-full fpcm-ui-filelist-button"><?php $FPCM_LANG->write('FILE_LIST_INSERT_FULL'); ?></a>
                    <?php endif; ?>                    
                </div>
                
                <div class="fpcm-filelist-actions-checkbox">
                    <?php fpcm\model\view\helper::checkbox('filenames[]', 'fpcm-list-selectbox', base64_encode($file->getFilename()), 'GLOBAL_DELETE', 'cb_'.$file->getFilename(), false); ?>
                </div>
                
                <div class="fpcm-clear"></div>
            </div> 
            
            <div class="fpcm-filelist-meta fpcm-ui-left fpcm-small-text">
                <table class="fpcm-ui-table fpcm-ui-nobg">
                    <tr>
                        <td><strong><?php $FPCM_LANG->write('FILE_LIST_UPLOAD_DATE'); ?>:</strong></td>
                        <td><?php print date($FPCM_DATETIME_MASK, $file->getFiletime()); ?></td>                    
                    </tr>
                    <tr>
                        <td><strong><?php $FPCM_LANG->write('FILE_LIST_UPLOAD_BY'); ?>:</strong></td>
                        <td><?php print isset($users[$file->getUserid()]) ? $users[$file->getUserid()]->getDisplayName() : $FPCM_LANG->translate('GLOBAL_NOTFOUND'); ?></td>                    
                    </tr>
                    <tr>
                        <td><strong><?php $FPCM_LANG->write('FILE_LIST_RESOLUTION'); ?>:</strong></td>
                        <td><?php print $file->getWidth(); ?> <span class="fa fa-times fa-fw"></span> <?php print $file->getHeight(); ?> <?php $FPCM_LANG->write('FILE_LIST_RESOLUTION_PIXEL'); ?></td>                    
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <div class="fpcm-clear"></div>
</div>

<?php include __DIR__.'/buttons.php'; ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmJs.setFileManagerIconButtons();
    });
</script>

