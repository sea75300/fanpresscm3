<table class="fpcm-ui-table fpcm-ui-logs fpcm-ui-logs-cronjobs">
    <tr>
        <th><?php $FPCM_LANG->write('LOGS_LIST_CRONJOB_NAME'); ?></th>
        <th class="fpcm-ui-center"><?php $FPCM_LANG->write('LOGS_LIST_CRONJOB_LASTEXEC'); ?></th>
        <th class="fpcm-ui-center"><?php $FPCM_LANG->write('LOGS_LIST_CRONJOB_NEXTEXEC'); ?></th>
    </tr>
    <tr class="fpcm-td-spacer"><td></td></tr>   
    <?php foreach ($cronjobList as $cronjob) : ?>
    <tr <?php if ($currentTime > $cronjob->getNextExecTime()) : ?>class="fpcm-ui-important-text"<?php endif; ?>>
        <td><?php $FPCM_LANG->write('CRONJOB_'.strtoupper($cronjob->getCronName())); ?></td>
        <td class="fpcm-ui-center"><?php print date($FPCM_DATETIME_MASK, $cronjob->getLastExecTime()); ?></td>
        <td class="fpcm-ui-center"><?php print date($FPCM_DATETIME_MASK, $cronjob->getNextExecTime()); ?></td>
    </tr>
    <?php endforeach; ?>
</table>