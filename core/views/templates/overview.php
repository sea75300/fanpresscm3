<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-code"></span> <?php $FPCM_LANG->write('HL_OPTIONS_TEMPLATES'); ?></h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=system/templates">
        
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-templates-articles"><?php $FPCM_LANG->write('TEMPLATE_HL_ARTICLES'); ?></a></li>
                <?php if (isset($contentArticleSingle) && isset($replacementsArticleSingle)) : ?>
                <li><a href="#tabs-templates-article"><?php $FPCM_LANG->write('TEMPLATE_HL_ARTICLE_SINGLE'); ?></a></li>
                <?php endif; ?>
                <li><a href="#tabs-templates-comments"><?php $FPCM_LANG->write('TEMPLATE_HL_COMMENTS'); ?></a></li>
                <li><a href="#tabs-templates-commentform"><?php $FPCM_LANG->write('TEMPLATE_HL_COMMENTFORM'); ?></a></li>
                <li><a href="#tabs-templates-latestnews"><?php $FPCM_LANG->write('TEMPLATE_HL_LATESTNEWS'); ?></a></li>
                <li><a href="#tabs-templates-tweet"><?php $FPCM_LANG->write('TEMPLATE_HL_TWEET'); ?></a></li>
            </ul>
            <div id="tabs-templates-articles">
                <?php include __DIR__.'/articles.php'; ?>
            </div>
            <?php if (isset($contentArticleSingle) && isset($replacementsArticleSingle)) : ?>
            <div id="tabs-templates-article">
                <?php include __DIR__.'/article.php'; ?>
            </div>
            <?php endif; ?>
            <div id="tabs-templates-comments">
                <?php include __DIR__.'/comments.php'; ?>
            </div>
            <div id="tabs-templates-commentform">
                <?php include __DIR__.'/commentform.php'; ?>
            </div>             
            <div id="tabs-templates-latestnews">
                <?php include __DIR__.'/latestnews.php'; ?>
            </div>             
            <div id="tabs-templates-tweet">
                <?php include __DIR__.'/tweet.php'; ?>
            </div>
        </div>
        
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
            <table>
                <tr>
                    <td><?php \fpcm\model\view\helper::saveButton('saveTemplates'); ?></td>
                </tr>
            </table>
        </div>         
    </form>
</div>