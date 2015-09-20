<?php if ($mode == 2) : ?>
<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-folder-open"></span> <?php $FPCM_LANG->write('HL_FILES_MNG'); ?></h1>
<?php else : ?>
<div class="fpcm-inner-wrapper">
<?php endif; ?>
    
    <div class="fpcm-tabs-general">
        <ul>
            <li id="tabs-files-list-reload"><a href="#tabs-files-list"><?php $FPCM_LANG->write('FILE_LIST_AVAILABLE'); ?></a></li>                
            <?php if ($permUpload) : ?><li><a href="#tabs-files-upload"><?php $FPCM_LANG->write('FILE_LIST_UPLOADFORM'); ?></a></li><?php endif; ?>                
        </ul>

        <form method="post" action="<?php print $FPCM_SELF; ?>?module=files/list&mode=<?php print $mode; ?>">
            <div id="tabs-files-list">
                <?php include __DIR__.'/listinner.php'; ?>
            </div>
        </form>

        <?php if ($permUpload) : ?>
        <div id="tabs-files-upload">
            <?php if ($newUploader) : ?>
                <?php include __DIR__.'/forms/jqupload.php'; ?>
            <?php else : ?>
                <?php include __DIR__.'/forms/phpupload.php'; ?>
            <?php endif; ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($loadAjax) : ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmJs.reloadFiles();
    });
</script>
<?php endif; ?>