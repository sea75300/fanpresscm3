<p>
<?php if ($sysmode) :  ?>
    <?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOWARTICLES_TEXT'); ?>
<?php else : ?>
    <?php $FPCM_LANG->write('NKORG_INTEGRATION_SHOW_IFRAME'); ?>
<?php endif;  ?>
</p>
<pre>
<?php if ($sysmode) :  ?>
&lt;div class=&quot;fpcm-pub-content&quot;&gt;
&lt;?php
    if (!defined('FPCM_PUB_LIMIT_LISTALL')) define('FPCM_PUB_LIMIT_LISTALL', 5);
    if (!defined('FPCM_PUB_LIMIT_ARCHIVE')) define('FPCM_PUB_LIMIT_ARCHIVE', 5);
    if (!defined('FPCM_PUB_CATEGORY_LISTALL')) define('FPCM_PUB_CATEGORY_LISTALL', 1);
    $api->showArticles();
?&gt;
&lt;/div&gt;
<?php else : ?>
&lt;iframe class=&quot;fpcm-pub-content-frame&quot; src=&quot;<?php print $FPCM_BASEMODULELINK; ?>fpcm/list&quot;&gt;&lt;/iframe&gt;
<?php endif;  ?>
</pre>