<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-comments"></span> <?php $FPCM_LANG->write('HL_COMMENTS_MNG'); ?></h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=comments/list">
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-users-active"><?php $FPCM_LANG->write('HL_COMMENTS_MNG'); ?></a></li>
            </ul>            
            
            <div id="tabs-users-active">
                <?php include __DIR__.'/commentlist_inner.php'; ?>
            </div>
        </div>
    </div>

    <?php \fpcm\model\view\helper::pageTokenField(); ?>
</form>