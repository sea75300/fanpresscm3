<p>
<?php if ($sysmode) :  ?>
    <?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWLATEST_TEXT'); ?>
    
    <table class="fpcm-ui-table fpcm-ui-middle">
        <tr>
            <td class="fpcm-half-width"><?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWARTICLES_TEXT2'); ?></td>
            <td style="width: 100px;"><?php fpcm\model\view\helper::textInput('showLatestLimit', '', '5', false, 3, false); ?></td>
            <td><?php fpcm\model\view\helper::submitButton('showLatestLimitSet', 'GLOBAL_OK'); ?></td>
        </tr>
    </table>
<?php else : ?>
    <?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOW_IFRAME'); ?>
<?php endif; ?>
</p>

<pre>
<?php if ($sysmode) :  ?>
&lt;div class=&quot;fpcm-pub-latestnews&quot;&gt;
&lt;?php
    if (!defined('FPCM_PUB_LIMIT_LATEST')) define('FPCM_PUB_LIMIT_LATEST', <span id="showLatestLimitSpan">5</span>);
    if (!defined('FPCM_PUB_CATEGORY_LATEST')) define('FPCM_PUB_CATEGORY_LATEST', 1);
    $api->showLatestNews();
?&gt;
&lt;/div&gt;
<?php else : ?>
&lt;iframe class=&quot;fpcm-pub-content-frame&quot; src=&quot;<?php print $FPCM_BASEMODULELINK; ?>fpcm/latest&quot;&gt;&lt;/iframe&gt;
<?php endif;  ?>
</pre>