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
            <table class="fpcm-ui-table fpcm-ui-smileys">
                <?php \fpcm\model\view\helper::notFoundContainer($files, 4); ?>
                <?php foreach ($files as $filename) : ?>
                <tr>
                    <td class="fpcm-ui-smiley-listimg"><img src="<?php print ($smiley->getFilename() ? $smiley->getSmileyUrl() : $smiley->getSmileyUrl().$filename); ?>" alt="<?php print $filename; ?>" <?php print $smiley->getWhstring(); ?>></td>
                    <td><?php print \fpcm\model\view\helper::escapeVal($filename); ?></td>
                    <td><?php \fpcm\model\view\helper::radio('smiley[filename]', '', $filename, '', '', $smiley->getFilename()); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
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