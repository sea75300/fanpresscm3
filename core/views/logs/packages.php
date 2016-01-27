<table class="fpcm-ui-table fpcm-ui-logs">
    <tr>
        <th><?php $FPCM_LANG->write('LOGS_LIST_TIME'); ?></th>
        <th><?php $FPCM_LANG->write('LOGS_LIST_TEXT'); ?></th>
    </tr>
    
    <?php \fpcm\model\view\helper::notFoundContainer($packagesLogs, 2); ?>
    
    <tr class="fpcm-td-spacer"><td></td></tr>
    <?php foreach ($packagesLogs as $value) : ?>
    <?php if (!is_object($value)) continue; ?>
    <tr>
        <td><?php print $value->time?></td>
        <?php if (!is_array($value->text)) continue; ?>
        <td><strong><?php print $value->pkgname; ?>:</strong>
            <ul>
                <?php foreach ($value->text as $line) : ?>
                <li><?php print $line; ?></li>
                <?php endforeach; ?>
            </ul>
        </td>

    </tr>
    <?php endforeach; ?>
</table>