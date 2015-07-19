<table class="fpcm-ui-table">
    <tr>
        <td><?php $FPCM_LANG->write('FILE_LIST_SMILEYCODE'); ?>:</td>
        <td>
            <?php \fpcm\model\view\helper::textInput('smiley[code]', '', $smiley->getSmileyCode()); ?>
        </td>
    </tr>
    <tr>
        <td><?php $FPCM_LANG->write('FILE_LIST_FILENAME'); ?>:</td>
        <td>
            <?php fpcm\model\view\helper::select('smiley[filename]', $files, $smiley->getFilename()); ?>
        </td>
    </tr>                    
</table>            

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
    <table>
        <tr>
            <td><?php \fpcm\model\view\helper::saveButton('saveSmiley'); ?></td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmJs.setFocus('smileycode');
    });
</script>