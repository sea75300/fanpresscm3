<p><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWTITLE_TEXT1'); ?></p>

<table class="fpcm-ui-table fpcm-ui-middle">
    <tr>
        <td class="fpcm-half-width"><?php fpcm\model\view\helper::textInput('spacertextPage', '', '&bull;'); ?></td>
        <td><?php fpcm\model\view\helper::submitButton('spacerPageTitle', 'GLOBAL_OK'); ?></td>
    </tr>
</table>

<p><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWTITLE_TEXT2'); ?></p>
<pre id='codepagetitle' class="fpcm-ui-center">
&lt;?php $api->showPageNumber('&amp;bull;'); ?&gt;
</pre>