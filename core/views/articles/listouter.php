<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-book"></span> <?php $FPCM_LANG->write('HL_ARTICLE_EDIT'); ?></h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $listAction.$listActionLimit; ?>">
        <div class="fpcm-tabs-general">
            <ul class="fpcm-tabs-articles-headers">
                <li><a href="#tabs-article-list"><?php $FPCM_LANG->write($headlineVar); ?></a></li>
                <li><a href="#tabs-article-drafts" class="tabs-article-hidesearch"><?php $FPCM_LANG->write('ARTICLES_DRAFTS'); ?></a></li>
                <?php if ($showTrash && $deletePermissions) : ?>
                <li><a href="#tabs-article-trash" class="tabs-article-hidesearch"><?php $FPCM_LANG->write('ARTICLES_TRASH'); ?></a></li>
                <?php endif; ?>
            </ul>

            <div id="tabs-article-list">
                <?php include __DIR__.'/lists/articles.php'; ?>
            </div>
            
            <div id="tabs-article-drafts">
                <?php include __DIR__.'/lists/drafts.php'; ?>
            </div>
            
            <?php if ($showTrash && $deletePermissions) : ?>
            <div id="tabs-article-trash">
                <?php include __DIR__.'/lists/trash.php'; ?>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons fpcm-ui-articlelist-buttons">
            <table>
                <tr>
                    <td><?php if ($permAdd) : ?><?php \fpcm\model\view\helper::linkButton('?module=articles/add', 'HL_ARTICLE_ADD', 'fpcm-articles-listaddnew', 'fpcm-new-btn fpcm-loader'); ?><?php endif; ?></td>
                    <td><?php \fpcm\model\view\helper::linkButton('#', 'ARTICLES_SEARCH', 'fpcm-articles-opensearch'); ?></td>
                    <td><?php \fpcm\model\view\helper::select('actions[action]', $articleActions, '', false, true, false, 'fpcm-ui-input-select-articleactions'); ?></td>
                    <td><?php \fpcm\model\view\helper::submitButton('doAction', 'GLOBAL_OK', 'fpcm-ui-articleactions-ok fpcm-loader'); ?></td>
                </tr>
            </table>
        </div>
    </form>
        
    <?php include __DIR__.'/searchform.php'; ?>
</div>