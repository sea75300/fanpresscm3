<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-book"></span> <?php $FPCM_LANG->write('HL_ARTICLE_EDIT'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_article_edit'); ?>
    </h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $listAction.$listActionLimit; ?>">
        <div class="fpcm-tabs-general">
            <ul class="fpcm-tabs-articles-headers">
                <li><a href="#tabs-article-list" data-tabid="1"><?php $FPCM_LANG->write($headlineVar); ?></a></li>
            </ul>

            <div id="tabs-article-list">
                <?php include __DIR__.'/lists/articles.php'; ?>
            </div>

        </div>
        
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">

            <div class="fpcm-ui-margin-center">
                <?php if ($permAdd) : ?><?php \fpcm\model\view\helper::linkButton('?module=articles/add', 'HL_ARTICLE_ADD', 'fpcm-articles-listaddnew', 'fpcm-new-btn fpcm-loader'); ?><?php endif; ?>
                <?php \fpcm\model\view\helper::linkButton('#', 'ARTICLES_SEARCH', 'fpcm-articles-opensearch', 'fpcm-articles-opensearch'); ?>
                <?php \fpcm\model\view\helper::select('actions[action]', $articleActions, '', false, true, false, 'fpcm-ui-input-select-articleactions'); ?>
                <?php \fpcm\model\view\helper::submitButton('doAction', 'GLOBAL_OK', 'fpcm-ui-articleactions-ok fpcm-loader'); ?>
            </div>

        </div>
        
        <?php \fpcm\model\view\helper::pageTokenField(); ?>
    </form>
        
    <?php include __DIR__.'/searchform.php'; ?>
</div>