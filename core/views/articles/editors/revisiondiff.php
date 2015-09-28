<table class="fpcm-ui-table">
    <tr>
        <td class="fpcm-half-width">
            <div class="fpcm-ui-editor-metabox">
                <?php include dirname(__DIR__).'/times.php'; ?>
                <?php include dirname(__DIR__).'/metainfo.php'; ?>
                <div class="fpcm-clear"></div>
            </div>
        </td>
        <?php $revision = $article; ?>
        <?php $article  = $currentArticle; ?>
        <td class="fpcm-half-width">
            <div class="fpcm-ui-editor-metabox">
                <?php include dirname(__DIR__).'/times.php'; ?>
                <?php include dirname(__DIR__).'/metainfo.php'; ?>
                <div class="fpcm-clear"></div>
            </div>
        </td>
        <?php $article = $revision; ?>
    </tr>    
    <tr>
        <td>
            <h3><?php print fpcm\model\view\helper::escapeVal($article->getTitle()); ?></h3>
        </td>
        <td>
            <h3><?php print fpcm\model\view\helper::escapeVal($currentArticle->getTitle()); ?></h3>
        </td>
    </tr>
    <tr>
        <td>
            <div class="fpcm-ui-buttonset">
                <?php foreach ($categories as $value => $key) : ?>
                <?php if (!in_array($value, $article->getCategories())) continue; ?>
                <span class="fpcm-ui-button"><?php print fpcm\model\view\helper::escapeVal($key->getName()); ?></span>
                <?php endforeach; ?>
            </div>
        </td>
        <td>
            <div class="fpcm-ui-buttonset">
                <?php foreach ($categories as $value => $key) : ?>
                <?php if (!in_array($value, $currentArticle->getCategories())) continue; ?>
                <span class="fpcm-ui-button"><?php print fpcm\model\view\helper::escapeVal($key->getName()); ?></span>
                <?php endforeach; ?>
            </div> 
        </td>
    </tr>
    <tr>
        <td class="fpcm-ui-editor-contentdiff-left">
            <?php print html_entity_decode($textTo); ?>
        </td>
        <td class="fpcm-ui-editor-contentdiff-right">
            <?php print html_entity_decode($textFrom); ?>
        </td>
    </tr>
</table>