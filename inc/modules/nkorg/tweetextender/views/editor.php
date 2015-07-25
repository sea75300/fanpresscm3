<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-twitter-square fa-fw"></span> <?php $FPCM_LANG->write('NKORG_TWEETENTENDER_HEADLINE'); ?></h1>

    <div class="fpcm-tabs-general">
        
        <ul>
            <li><a href="#termeditor"><?php $FPCM_LANG->write('NKORG_TWEETENTENDER_EDITTERM'); ?></a></li>
        </ul>
        
        <div id="termeditor">
            <form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $FPCM_CURRENT_MODULE; ?><?php print $additional; ?>">
                <table class="fpcm-ui-table">
                    <tr>
                        <td><?php $FPCM_LANG->write('NKORG_TWEETENTENDER_SEARCHTERM'); ?>:</td>
                        <td><?php \fpcm\model\view\helper::textInput('term[search]','',$term->getSearchterm()); ?></td>
                    </tr>
                    <tr>
                        <td><?php $FPCM_LANG->write('NKORG_TWEETENTENDER_REPLACETERM'); ?>:</td>
                        <td><?php \fpcm\model\view\helper::textInput('term[replace]','',$term->getReplaceterm()); ?></td>
                    </tr>         
                </table> 

                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php \fpcm\model\view\helper::saveButton('termSave') ?></td>
                        </tr>
                    </table>
                </div>            
            </form>
        </div>
    </div>
</div>