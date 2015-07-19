<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-user-plus"></span> <?php $FPCM_LANG->write('HL_OPTIONS_USERS'); ?></h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=users/addroll">
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-roll"><?php $FPCM_LANG->write('USERS_ROLL_ADD'); ?></a></li>
            </ul>            
            
            <div id="tabs-roll">
                <table class="fpcm-ui-table">
                    <tr>
                        <td><?php $FPCM_LANG->write('USERS_ROLLS_NAME'); ?>:</td>
                        <td>
                            <?php \fpcm\model\view\helper::textInput('rollname'); ?>
                        </td>
                    </tr>      
                </table>            

                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php \fpcm\model\view\helper::saveButton('saveRoll'); ?></td>
                        </tr>
                    </table>
                </div>                
            </div>
        </div>
    </div>             
</form>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmJs.setFocus('rollname');
    });
</script>