<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-calendar fa-fw"></span> <?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_HEADLINE'); ?></h1>

    <div class="fpcm-tabs-general">
        
        <ul>
            <li><a href="#msgeditor"><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_EDITMESSAGE'); ?></a></li>
        </ul>
        
        <div id="msgeditor">
            <form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $FPCM_CURRENT_MODULE; ?><?php print $additional; ?>">
                <table class="fpcm-ui-table fpcm-ui-options">
                    <tr>
                        <td><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_TEXT'); ?>:</td>
                        <td><?php \fpcm\model\view\helper::textArea('msg[text]', 'fpcm-half-width',$msg->getText()); ?></td>
                    </tr>
                    <tr>
                        <td><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_START'); ?></td>
                        <td><?php \fpcm\model\view\helper::textInput('msg[start]', 'nkorg-inactivity-manager-dates', date('Y-m-d', $msg->getStarttime())); ?></td>
                    </tr>  
                    <tr>
                        <td><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_STOP'); ?></td>
                        <td><?php \fpcm\model\view\helper::textInput('msg[stop]', 'nkorg-inactivity-manager-dates', date('Y-m-d', $msg->getStoptime())); ?></td>
                    </tr> 
                    <tr>
                        <td><?php $FPCM_LANG->write('NKORGINACTIVITY_MANAGER_NOCOMMENTS'); ?></td>
                        <td><?php fpcm\model\view\helper::checkbox('msg[nocomments]', '', '1', '', '', $msg->getNocomments()); ?></td>
                    </tr>
                </table> 

                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php \fpcm\model\view\helper::saveButton('msgSave') ?></td>
                        </tr>
                    </table>
                </div>            
            </form>
        </div>
    </div>
</div>