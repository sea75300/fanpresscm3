<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-feed fa-border"></span> <?php $FPCM_LANG->write('NKORG_RSSIMPORT_HEADLINE'); ?></h1>
    
    <div class="fpcm-tabs-general">
        <ul>
            <li><a href="#fpcm-rssimport-general"><?php $FPCM_LANG->write('SYSTEM_HL_OPTIONS_GENERAL'); ?></a></li>
        </ul>
        
        <div id="fpcm-rssimport-general">
            <table class="fpcm-ui-table fpcm-ui-options">
                <tr>
                    <td colspan="2">
                        <p><?php $FPCM_LANG->write('NKORG_RSSIMPORT_NOTES'); ?></p>
                    </td>
                </tr>
                <tr>
                    <td><?php $FPCM_LANG->write('NKORG_RSSIMPORT_FILE'); ?>:</td>
                    <td><?php fpcm\model\view\helper::textInput('rsspath', '', 'http://'); ?></td>
                </tr>
                <tr>
                    <td><?php $FPCM_LANG->write('NKORG_RSSIMPORT_DEFAULTUSER'); ?>:</td>
                    <td><?php fpcm\model\view\helper::select('userid', $userids, $selectedUser, false, false); ?></td>
                </tr>
                <tr>
                    <td><?php $FPCM_LANG->write('NKORG_RSSIMPORT_DEFAULTCATEGORY'); ?>:</td>
                    <td><?php fpcm\model\view\helper::select('categoryid', $categoryids, $selectedCategory, false, false); ?></td>
                </tr>
            </table>
        </div>
        
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
            <table>
                <tr>
                    <td><?php \fpcm\model\view\helper::button('submit', 'checkPath', 'NKORG_RSSIMPORT_START', 'fpcm-rssimport-check'); ?></td>
                </tr>
            </table>
        </div>

    </div>

</div>