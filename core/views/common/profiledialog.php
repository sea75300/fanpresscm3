<?php if ($FPCM_LOGGEDIN) : ?>
<div class="fpcm-ui-dialog-layer" id="fpcm-profile-dialog-layer">
    <table>
        <tr>
            <td rowspan="2" class="fpcm-profile-info-icon">
                <span class="fa-stack fa-fw fa-2x">
                    <span class="fa fa-square fa-stack-2x fa-fw"></span>
                    <span class="fa fa-info-circle fa-stack-1x fa-inverse fa-fw"></span>
                </span>
            </td>
            <td><b><?php $FPCM_LANG->write('PROFILE_MENU_LOGGEDINSINCE'); ?>:</b> <?php \fpcm\model\view\helper::dateText($FPCM_SESSION_LOGIN); ?> (<?php print $FPCM_DATETIME_ZONE; ?>)</td>
        </tr>
        <tr>
            <td><b><?php $FPCM_LANG->write('PROFILE_MENU_YOURIP'); ?>:</b> <?php print fpcm\classes\http::getIp(); ?></td>
        </tr>
    </table>
</div> 
<?php endif; ?>