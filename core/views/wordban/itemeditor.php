<table class="fpcm-ui-table">
    <tr>
        <td><?php $FPCM_LANG->write('WORDBAN_NAME'); ?>:</td>
        <td><?php \fpcm\model\view\helper::textInput('wbitem[searchtext]','',$item->getSearchtext()); ?></td>
    </tr>
    <tr>
        <td><?php $FPCM_LANG->write('WORDBAN_ICON_PATH'); ?>:</td>
        <td><?php \fpcm\model\view\helper::textInput('wbitem[replacementtext]','',$item->getReplacementtext()); ?></td>
    </tr>              
</table> 

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
    <table>
        <tr>
            <td><?php \fpcm\model\view\helper::saveButton('wbitemSave') ?></td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmJs.setFocus('wbitemsearchtext');
    });
</script>