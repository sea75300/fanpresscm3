<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-users"></span> <?php $FPCM_LANG->write('HL_OPTIONS_USERS'); ?></h1>
    <form method="post" action="<?php print $author->getEditLink(); ?>">
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-user"><?php $FPCM_LANG->write('USERS_EDIT'); ?></a></li>
                <li><a href="#tabs-user-meta"><?php $FPCM_LANG->write('USERS_META_OPTIONS'); ?></a></li>
            </ul>            
            
            <div id="tabs-user">                
               <?php include __DIR__.'/usereditor.php' ?>                
            </div>
            
            <div id="tabs-user-meta">                
               <?php include __DIR__.'/editormeta.php' ?>                
            </div>            
        </div>
        
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
            <?php \fpcm\model\view\helper::saveButton('userSave'); ?>
        </div>
    </form>
</div>