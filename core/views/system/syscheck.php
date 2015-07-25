<table class="fpcm-ui-table fpcm-ui-syscheck">
    <tr>
        <th></th>
        <th></th>
        <th class="fpcm-ui-center"><?php $FPCM_LANG->write('SYSTEM_OPTIONS_SYSCHECK_CURRENT'); ?></th>
        <th class="fpcm-ui-center"><?php $FPCM_LANG->write('SYSTEM_OPTIONS_SYSCHECK_RECOMMEND'); ?></th>
        <th class="fpcm-ui-center"><?php $FPCM_LANG->write('SYSTEM_OPTIONS_SYSCHECK_STATUS'); ?></th>
    </tr>
<?php foreach ($checkOptions as $checkOption => $checkResult) : ?>
    <tr>
        <td><?php if (isset($checkResult['helplink'])) : ?><a class="fpcm-link" href="<?php print $checkResult['helplink']; ?>" title="<?php $FPCM_LANG->write('GLOBAL_INFO'); ?>" target="_blank"><span class="fa fa-question-circle fa-fw fpcm-ui-shorthelp"></span></a><?php endif; ?></td>
        <td>
            <spam><?php print $checkOption; ?></spam>
            <?php if (isset($checkResult['actionbtn']) && !$checkResult['result']) : ?>
            <?php fpcm\model\view\helper::linkButton($checkResult['actionbtn']['link'], $checkResult['actionbtn']['description']); ?>
            <?php endif; ?>
        </td>
        <td class="fpcm-ui-center"><?php print $checkResult['current']; ?></td>
        <td class="fpcm-ui-center"><?php print $checkResult['recommend']; ?></td>
        <td><?php \fpcm\model\view\helper::boolToText($checkResult['result']); ?></td>
    </tr>
<?php endforeach; ?>    
</table>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.fpcm-ui-button').button();
    });
</script>