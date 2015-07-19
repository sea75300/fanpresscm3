<p>
<?php if ($sysmode) :  ?>
    <?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWLATEST_TEXT'); ?>
<?php else : ?>
    <?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOW_IFRAME'); ?>
<?php endif;  ?>
</p>

<pre>
<?php if ($sysmode) :  ?>
&lt;div class=&quot;fpcm-pub-latestnews&quot;&gt;
&lt;?php
    if (!defined('FPCM_PUB_LIMIT_LATEST')) define('FPCM_PUB_LIMIT_LATEST', 5);
    if (!defined('FPCM_PUB_CATEGORY_LATEST')) define('FPCM_PUB_CATEGORY_LATEST', 1);
    $api->showLatestNews();
?&gt;
&lt;/div&gt;
<?php else : ?>
&lt;iframe class=&quot;fpcm-pub-content-frame&quot; src=&quot;<?php print $FPCM_BASEMODULELINK; ?>fpcm/latest&quot;&gt;&lt;/iframe&gt;
<?php endif;  ?>
</pre>