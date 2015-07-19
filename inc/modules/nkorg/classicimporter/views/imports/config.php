<p><?php $FPCM_LANG->write('FPCM_CLASSICIMPORTER_IMPORT_CONFIG_TXT'); ?></p>
<ul>
    <li><?php $FPCM_LANG->write('GLOBAL_EMAIl'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_URL'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_DATETIMEMASK'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWS_SORTING'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_STYLESHEET'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ANTISPAMQUESTION'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_ANTISPAMANSWER'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWSSHOWMAXIMGSIZE'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_NEWSSHOWIMGTHUMBSIZE'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_TWITTER_CONSUMER_KEY'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_TWITTER_CONSUMER_SECRET'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_TWITTER_USER_TOKEN'); ?></li>
    <li><?php $FPCM_LANG->write('SYSTEM_OPTIONS_TWITTER_USER_SECRET'); ?></li>
</ul>
<p><?php \fpcm\model\view\helper::button('button', 'startImportConfig', 'FPCM_CLASSICIMPORTER_IMPORT_START', 'fpcm-classicimporter-importstart'); ?></p>
<p class="fpcm-ui-checkdata-text fpcm-ui-important-text">
    <span class="fa fa-exclamation-circle"></span> <?php $FPCM_LANG->write('FPCM_CLASSICIMPORTER_CHECK'); ?>
</p>

