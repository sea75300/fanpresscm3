<form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $FPCM_CURRENT_MODULE; ?>&key=nkorg/tweetextender">
    <div class="fpcm-content-wrapper">
        <h1><span class="fa fa-twitter-square fa-fw"></span> <?php $FPCM_LANG->write('NKORG_TWEETENTENDER_HEADLINE'); ?></h1>

        <div class="fpcm-tabs-general">

            <ul>
                <li><a href="#terms"><?php $FPCM_LANG->write('NKORG_TWEETENTENDER_TERMLIST'); ?></a></li>
            </ul>

            <div id="terms">
                <table class="fpcm-ui-table fpcm-ui-categories">
                    <tr>
                        <th></th>
                        <th><?php $FPCM_LANG->write('NKORG_TWEETENTENDER_SEARCHTERM'); ?></th>
                        <th><?php $FPCM_LANG->write('NKORG_TWEETENTENDER_REPLACETERM'); ?></th>
                        <th class="fpcm-th-select-row"><?php fpcm\model\view\helper::checkbox('fpcm-select-all', '', '', '', 'fpcm-select-all', false); ?></th>
                    </tr>
                    <?php foreach ($terms as $term) : ?>
                    <tr>
                        <td class="fpcm-ui-editbutton-col"><?php \fpcm\model\view\helper::editButton($term->getEditLink()); ?></td>
                        <td><?php print \fpcm\model\view\helper::escapeVal($term->getSearchterm()); ?></td>
                        <td><?php print \fpcm\model\view\helper::escapeVal($term->getReplaceterm()); ?></td>
                        <td class="fpcm-td-select-row"><?php fpcm\model\view\helper::checkbox('ids[]', 'fpcm-list-selectbox', $term->getId(), '', '', false); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

    <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
        <div class="fpcm-ui-margin-center">
            <?php \fpcm\model\view\helper::linkButton($FPCM_BASEMODULELINK.'nkorg/tweetextender/addterm', 'NKORG_TWEETENTENDER_NEWTERM'); ?>
            <?php \fpcm\model\view\helper::deleteButton('deleteTerms'); ?>
        </div>
    </div>
</form>