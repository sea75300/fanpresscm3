<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-wrench"></span> <?php $FPCM_LANG->write('HL_PROFILE'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_profile'); ?>
    </h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=system/profile">
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-user"><?php $FPCM_LANG->write('HL_PROFILE'); ?></a></li>
                <li><a href="#tabs-user-meta"><?php $FPCM_LANG->write('USERS_META_OPTIONS'); ?></a></li>
            </ul>            
            
            <div id="tabs-user">                
               <?php include dirname(__DIR__).'/users/usereditor.php' ?>                
            </div>
            
            <div id="tabs-user-meta">                
               <?php include dirname(__DIR__).'/users/editormeta.php' ?>                
            </div>            
        </div>
        
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
            <table>
                <tr>
                    <td><?php \fpcm\model\view\helper::saveButton('profileSave'); ?></td>
                </tr>
            </table>
        </div>
    </form>
</div>