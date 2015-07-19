<p><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWTITLE_TEXT1'); ?></p>
<p>
    <?php fpcm\model\view\helper::textInput('spacertextArticle', '', '&bull;'); ?>
    <?php fpcm\model\view\helper::submitButton('spacerArticleTitle', 'GLOBAL_OK'); ?>
</p>

<p><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWTITLE_TEXT2'); ?></p>
<pre id='codearticletitle' class="fpcm-ui-center">
&lt;?php $api->showTitle('&amp;bull;'); ?&gt;
</pre>