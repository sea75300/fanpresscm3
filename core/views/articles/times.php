<?php
    if ($timesMode) {
        $timeInfoCreate = $FPCM_LANG->translate('EDITOR_AUTHOREDIT', array(
            '{{username}}' => isset($users[$article->getCreateuser()]) ? $users[$article->getCreateuser()] : $FPCM_LANG->translate('GLOBAL_NOTFOUND'),
            '{{time}}'     => date($FPCM_DATETIME_MASK, $article->getCreatetime())
        ));

        $timeInfoChange = $FPCM_LANG->translate('EDITOR_LASTEDIT', array(
            '{{username}}' => isset($users[$article->getChangeuser()]) ? $users[$article->getChangeuser()] : $FPCM_LANG->translate('GLOBAL_NOTFOUND'),
            '{{time}}'     => date($FPCM_DATETIME_MASK, $article->getChangetime())
        ));         
    } else {
        $timeInfoCreate = $FPCM_LANG->translate('EDITOR_AUTHOREDIT', array(
            '{{username}}' => isset($users[$article->getCreateuser()]) ? $users[$article->getCreateuser()]->getDisplayname() : $FPCM_LANG->translate('GLOBAL_NOTFOUND'),
            '{{time}}'     => date($FPCM_DATETIME_MASK, $article->getCreatetime())
        ));

        $timeInfoChange = $FPCM_LANG->translate('EDITOR_LASTEDIT', array(
            '{{username}}' => isset($users[$article->getChangeuser()]) ? $users[$article->getChangeuser()]->getDisplayname() : $FPCM_LANG->translate('GLOBAL_NOTFOUND'),
            '{{time}}'     => date($FPCM_DATETIME_MASK, $article->getChangetime())
        ));        
    }            
?>

<div class="fpcm-ui-editor-metabox-left">
    <?php if (!$timesMode && !$isRevision) : ?>
    <div class="fpcm-ui-editor-metabox-left-frontend"><?php \fpcm\model\view\helper::linkButton($article->getArticleLink(), 'GLOBAL_FRONTEND_OPEN', '', 'fpcm-ui-button-blank fpcm-openlink-btn', '_blank'); ?></div>
    <div class="fpcm-ui-editor-metabox-left-short"><?php \fpcm\model\view\helper::linkButton($article->getArticleShortLink(), 'EDITOR_ARTICLE_SHORTLINK', '', 'fpcm-ui-button-blank fpcm-articlelist-shortlink'); ?></div>
    <?php if ($article->getImagepath()) : ?><div class="fpcm-ui-editor-metabox-left-aimg"><?php \fpcm\model\view\helper::linkButton($article->getImagepath(), 'EDITOR_ARTICLEIMAGE_SHOW', '', 'fpcm-articlelist-articleimage'); ?></div><?php endif; ?>
    <?php endif; ?>
    
    <div><?php print $timeInfoCreate; ?><br>
    <?php print $timeInfoChange; ?></div>
</div>

<?php if (!$timesMode) : ?>
<!-- SHortlink layer -->  
<div class="fpcm-ui-dialog-layer fpcm-editor-dialog" id="fpcm-editor-shortlink"></div>
<?php endif; ?>