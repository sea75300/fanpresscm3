<p>
<?php if ($sysmode) :  ?>
    <?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWARTICLES_TEXT'); ?>
    
<table class="fpcm-ui-table fpcm-ui-middle">
    <tr>
        <td class="fpcm-half-width"><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWARTICLES_TEXT2'); ?></td>
        <td style="width: 100px;"><?php fpcm\model\view\helper::textInput('limitListShowArticles', '', '5', false, 5, false); ?></td>
        <td><?php fpcm\model\view\helper::submitButton('limitListSetShowArticles', 'GLOBAL_OK'); ?></td>
    </tr>
    <tr>
        <td class="fpcm-half-width"><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWARTICLES_TEXT3'); ?></td>
        <td style="width: 100px;"><?php fpcm\model\view\helper::textInput('limitListShowArchive', '', '5', false, 5, false); ?></td>
        <td><?php fpcm\model\view\helper::submitButton('limitListSetShowArchive', 'GLOBAL_OK'); ?></td>
    </tr>
</table>

<?php else : ?>
    <?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOW_IFRAME'); ?>
<?php endif;  ?>
</p>
<pre>
<?php if ($sysmode) :  ?>
&lt;div class=&quot;fpcm-pub-content&quot;&gt;
&lt;?php
    if (!defined('FPCM_PUB_LIMIT_LISTALL')) define('FPCM_PUB_LIMIT_LISTALL', <span id="limitListSpanShowArticles">5</span>);
    if (!defined('FPCM_PUB_LIMIT_ARCHIVE')) define('FPCM_PUB_LIMIT_ARCHIVE', <span id="limitListSpanShowArchive">5</span>);
    if (!defined('FPCM_PUB_CATEGORY_LISTALL')) define('FPCM_PUB_CATEGORY_LISTALL', 1);
    $api->showArticles();
?&gt;
&lt;/div&gt;
<?php else : ?>
&lt;iframe class=&quot;fpcm-pub-content-frame&quot; src=&quot;<?php print $FPCM_BASEMODULELINK; ?>fpcm/list&quot;&gt;&lt;/iframe&gt;
<?php endif;  ?>
</pre>