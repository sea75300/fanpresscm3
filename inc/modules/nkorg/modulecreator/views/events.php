<p class="fpcm-ui-center"><?php $FPCM_LANG->write('NKORG_MODULECREATOR_EVENTLIST_TXT'); ?></p>
<table class="fpcm-ui-table">
    <tr>
    <?php foreach ($sortedEvents as $sortLetter => $events) : ?>
        <?php $i = 1; ?>
        <tr><th class="fpcm-th-full">- <?php print $sortLetter; ?> -</th></tr>
        <tr><td class="fpcm-ui-spacer"></td></tr>
        <tr>
            <td class="fpcm-ui-center">
                <div class="fpcm-ui-buttonset">
                <?php foreach ($events as $key => $event) : ?>
                    <?php \fpcm\model\view\helper::checkbox('nkorgmodulecreator[events][]', 'fpcm-nkorgmodulecreator-eventcheckboxes', $event, $event, md5($event), ($event == 'acpConfig' ? true : false), ($event == 'acpConfig' ? true : false)); ?>
                    
        <?php if ($i % 3 == 0) : ?>
                </div>
            </td>
        </tr>
        <tr>
            <td class="fpcm-ui-center">
                <div class="fpcm-ui-buttonset">
        <?php endif;  ?>
                <?php $i++; ?>
                <?php endforeach; ?>
                </div>
            </td>
        </tr>
        <tr><td class="fpcm-ui-spacer"></td></tr>
    <?php endforeach; ?>
    </tr>
</table>