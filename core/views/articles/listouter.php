<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-book"></span> <?php $FPCM_LANG->write('HL_ARTICLE_EDIT'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_article_edit'); ?>
    </h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $listAction.$listActionLimit; ?>">
        <div class="fpcm-tabs-general">
            <ul class="fpcm-tabs-articles-headers">
                <li><a href="#tabs-article-list" data-tabid="1"><?php $FPCM_LANG->write($headlineVar); ?></a></li>
                <?php if ($showDrafts) : ?>
                <li><a href="#tabs-article-drafts" data-tabid="2" class="tabs-article-hidesearch"><?php $FPCM_LANG->write('ARTICLES_DRAFTS'); ?></a></li>
                <?php endif; ?>
                <?php if ($showTrash && $deletePermissions) : ?>
                <li><a href="#tabs-article-trash" data-tabid="3" class="tabs-article-hidesearch"><?php $FPCM_LANG->write('ARTICLES_TRASH'); ?></a></li>
                <?php endif; ?>
            </ul>

            <div id="tabs-article-list">
                <?php include __DIR__.'/lists/articles.php'; ?>
            </div>
            
            <?php if ($showDrafts) : ?>
            <div id="tabs-article-drafts">
                <?php include __DIR__.'/lists/drafts.php'; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($showTrash && $deletePermissions) : ?>
            <div id="tabs-article-trash">
                <?php include __DIR__.'/lists/trash.php'; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">

            <div class="fpcm-ui-margin-center">
                <?php if ($permAdd) : ?><?php \fpcm\model\view\helper::linkButton('?module=articles/add', 'HL_ARTICLE_ADD', 'fpcm-articles-listaddnew', 'fpcm-new-btn fpcm-loader'); ?><?php endif; ?></td>
                <?php \fpcm\model\view\helper::linkButton('#', 'ARTICLES_SEARCH', 'fpcm-articles-opensearch', 'fpcm-articles-opensearch'); ?>
                <?php \fpcm\model\view\helper::select('actions[action]', $articleActions, '', false, true, false, 'fpcm-ui-input-select-articleactions'); ?>
                <?php \fpcm\model\view\helper::submitButton('doAction', 'GLOBAL_OK', 'fpcm-ui-articleactions-ok fpcm-loader'); ?>
                <?php if ($showTrash && $deletePermissions) : ?><?php \fpcm\model\view\helper::submitButton('clearTrash', 'ARTICLE_LIST_EMPTYTRASH', 'fpcm-delete-btn fpcm-loader fpcm-hidden'); ?><?php endif; ?>
            </div>

        </div>
        
        <?php \fpcm\model\view\helper::pageTokenField(); ?>
    </form>
        
    <?php include __DIR__.'/searchform.php'; ?>
</div>