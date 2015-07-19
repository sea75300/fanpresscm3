<p><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWTITLE_TEXT1'); ?></p>
<p>
    <?php fpcm\model\view\helper::textInput('spacertextPage', '', '&bull;'); ?>
    <?php fpcm\model\view\helper::submitButton('spacerPageTitle', 'GLOBAL_OK'); ?>
</p>

<p><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWTITLE_TEXT2'); ?></p>
<pre id='codepagetitle' class="fpcm-ui-center">
&lt;?php $api->showPageNumber('&amp;bull;'); ?&gt;
</pre>