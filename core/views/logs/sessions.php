<table class="fpcm-ui-table fpcm-ui-logs fpcm-ui-logs-sessions">
    <tr>
        <th><?php $FPCM_LANG->write('LOGS_LIST_USER'); ?></th>
        <th><?php $FPCM_LANG->write('LOGS_LIST_IPADDRESS'); ?></th>
        <th><?php $FPCM_LANG->write('LOGS_LIST_LOGIN'); ?></th>
        <th><?php $FPCM_LANG->write('LOGS_LIST_LOGOUT'); ?></th>
    </tr>
    <tr class="fpcm-td-spacer"><td></td></tr>
    <?php if (!count($sessionList)) : ?>
    <tr>
        <td colspan="6"><?php $FPCM_LANG->write('GLOBAL_NOTFOUND2'); ?></td>
    </tr>                    
    <?php endif; ?>    
    <?php foreach ($sessionList as $sessionItem) : ?>
    <tr>
        <td><?php print isset($userList[$sessionItem->getUserId()]) ? $userList[$sessionItem->getUserId()]->getDisplayName() : $FPCM_LANG->translate('GLOBAL_NOTFOUND'); ?></td>
        <td><?php print $sessionItem->getIp(); ?></td>
        <td><?php \fpcm\model\view\helper::dateText($sessionItem->getLogin()); ?></td>
        <td><?php print $sessionItem->getLogout() > 0 ? \fpcm\model\view\helper::dateText($sessionItem->getLogout()) : $FPCM_LANG->translate('LOGS_LIST_TIMEOUT'); ?></td>
    </tr>
    <?php endforeach; ?>
</table>