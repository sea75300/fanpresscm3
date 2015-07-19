<table class="fpcm-ui-table fpcm-ui-logs">
    <tr>
        <th><?php $FPCM_LANG->write('LOGS_LIST_TIME'); ?></th>
        <th><?php $FPCM_LANG->write('LOGS_LIST_TEXT'); ?></th>
    </tr>    
    <tr class="fpcm-td-spacer"><td></td></tr>
    <?php if (!count($errorLogs)) : ?>
    <tr>
        <td colspan="2"><?php $FPCM_LANG->write('GLOBAL_NOTFOUND2'); ?></td>
    </tr>                    
    <?php endif; ?>    
    <?php foreach ($errorLogs as $value) : ?>
    <?php if (!is_object($value)) continue; ?>
    <tr>
        <td><?php print $value->time; ?></td>
        <td><?php print str_replace('&NewLine;', '<br>', \fpcm\model\view\helper::escapeVal($value->text)); ?></td>

    </tr>
    <?php endforeach; ?>
</table>