    <table class="fpcm-ui-table fpcm-ui-options">
        <tr>
            <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_TIMEZONE'); ?>:</td>
            <td>
                <?php fpcm\model\view\helper::selectGroup('usermeta[system_timezone]', $timezoneAreas, $author->getUserMeta('system_timezone')); ?>	
            </td>
        </tr>
        <tr>
            <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_LANG'); ?>:</td>
            <td>
                <?php \fpcm\model\view\helper::select('usermeta[system_lang]', $languages, $author->getUserMeta('system_lang'), false, false); ?>
            </td>
        </tr>                
        <tr>
            <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_DATETIMEMASK'); ?>:</td>
            <td>
                <?php \fpcm\model\view\helper::textInput('usermeta[system_dtmask]', '', $author->getUserMeta('system_dtmask')); ?>
                <a href="http://us2.php.net/manual/function.date.php" target="_blank"><span class="fa fa-question-circle fa-fw fpcm-ui-shorthelp" title="<?php $FPCM_LANG->write('SYSTEM_OPTIONS_DATETIMEMASK_HELP'); ?>"></span></a>
            </td>
        </tr>
        <tr>
            <td><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ACPARTICLES_LIMIT'); ?>:</td>
            <td>
                <?php fpcm\model\view\helper::select('usermeta[articles_acp_limit]', $articleLimitList, $author->getUserMeta('articles_acp_limit'), false, false); ?>
            </td>
        </tr>
    </table>