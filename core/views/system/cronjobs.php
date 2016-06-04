<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-history"></span> <?php $FPCM_LANG->write('HL_CRONJOBS'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_options'); ?>
    </h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=system/crons">
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-options-general"><?php $FPCM_LANG->write('SYSTEM_HL_OPTIONS_GENERAL'); ?></a></li>
            </ul>

            <div id="tabs-options-general">

                <table class="fpcm-ui-table fpcm-ui-logs fpcm-ui-logs-cronjobs">
                    <tr>
                        <th><?php $FPCM_LANG->write('LOGS_LIST_CRONJOB_NAME'); ?></th>
                        <th class="fpcm-ui-center"><?php $FPCM_LANG->write('LOGS_LIST_CRONJOB_LASTEXEC'); ?></th>
                        <th class="fpcm-ui-center"><?php $FPCM_LANG->write('LOGS_LIST_CRONJOB_NEXTEXEC'); ?></th>
                    </tr>
                    <tr class="fpcm-td-spacer"><td></td></tr>   
                    <?php foreach ($cronjobList as $cronjob) : ?>
                    <tr <?php if ($currentTime > ($cronjob->getNextExecTime() - 60)) : ?>class="fpcm-ui-important-text"<?php endif; ?>>
                        <td><?php $FPCM_LANG->write('CRONJOB_'.strtoupper($cronjob->getCronName())); ?></td>
                        <td class="fpcm-ui-center"><?php \fpcm\model\view\helper::dateText($cronjob->getLastExecTime()); ?></td>
                        <td class="fpcm-ui-center"><?php \fpcm\model\view\helper::dateText($cronjob->getNextExecTime()); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

            </div>
        
    </form> 
</div>