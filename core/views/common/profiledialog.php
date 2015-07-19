<?php if ($FPCM_LOGGEDIN) : ?>
<div class="fpcm-ui-dialog-layer" id="fpcm-profile-dialog-layer">
    <table>
        <tr>
            <td rowspan="2" class="fpcm-profile-info-icon"><i class="fa fa-info-circle"></i></td>
            <td><b><?php $FPCM_LANG->write('PROFILE_MENU_LOGGEDINSINCE'); ?>:</b> <?php print date($FPCM_DATETIME_MASK, $FPCM_SESSION_LOGIN); ?> (<?php print $FPCM_DATETIME_ZONE; ?>)</td>
        </tr>
        <tr>
            <td><b><?php $FPCM_LANG->write('PROFILE_MENU_YOURIP'); ?>:</b> <?php print fpcm\classes\http::getIp(); ?></td>
        </tr>
    </table>
</div> 
<?php endif; ?>