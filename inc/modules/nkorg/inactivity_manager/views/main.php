<form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $FPCM_CURRENT_MODULE; ?>&key=nkorg/inactivity_manager">
    <div class="fpcm-content-wrapper">
        <h1><span class="fa fa-calendar fa-fw"></span> <?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_HEADLINE'); ?></h1>

        <div class="fpcm-tabs-general">

            <ul>
                <li><a href="#messages"><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_LIST'); ?></a></li>
            </ul>

            <div id="messages">
                <table class="fpcm-ui-table fpcm-ui-categories">
                    <tr>
                        <th></th>
                        <th><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_PREVIEW'); ?></th>
                        <th><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_TIMESPAN'); ?></th>
                        <th style="width:200px;"><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_NOCOMMENTS'); ?></th>
                        <th class="fpcm-th-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-all', '', '', '', 'fpcm-select-all', false); ?></th>
                    </tr>
                    <?php if (!count($messages)) : ?>
                    <tr class="fpcm-td-spacer" colspan="4"><td></td></tr>
                    <tr>
                        <td colspan="4"><?php $FPCM_LANG->write('GLOBAL_NOTFOUND2'); ?></td>
                    </tr>                    
                    <?php endif; ?> 
                    <?php foreach ($messages as $message) : ?>
                    <tr>
                        <td class="fpcm-ui-editbutton-col"><?php \fpcm\model\view\helper::editButton($message->getEditLink()); ?></td>
                        <td title="<?php print \fpcm\model\view\helper::escapeVal($message->getText()); ?>"><?php print \fpcm\model\view\helper::escapeVal(substr($message->getText(), 0, 50)); ?>...</td>
                        <td><?php print date('d.m.Y', $message->getStarttime()); ?> - <?php print date('d.m.Y', $message->getStoptime()); ?></td>
                        <td class="fpcm-ui-center"><?php fpcm\model\view\helper::boolToText($message->getNocomments()); ?></td>
                        <td class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('ids[]', 'fpcm-list-selectbox', $message->getId(), '', '', false); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
        <table>
            <tr>
                <td><?php \fpcm\model\view\helper::linkButton($FPCM_BASEMODULELINK.'nkorg/inactivity_manager/addmessage', 'NKORGINACTIVITY_MANAGER_NEWMESSAGE') ?></td>
                <td><?php \fpcm\model\view\helper::deleteButton('deleteTerms') ?></td>
            </tr>
        </table>
    </div>
</form>