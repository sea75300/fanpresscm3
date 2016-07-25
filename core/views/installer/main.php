<script type="text/javascript">
jQuery(document).ready(function () {
    fpcmInstaller = new fpcmInstaller();
    fpcmInstaller.progressbar(<?php print $maxStep; ?>, <?php print $currentStep; ?>);
});
</script>

<form action="<?php print $FPCM_BASEMODULELINK; ?>installer&step=<?php print $step; ?><?php if ($currentStep > 1) : ?>&language=<?php print $FPCM_LANG->getLangCode(); ?><?php endif; ?>" method="post" id="installerform">
    <div class="fpcm-content-wrapper fpcm-content-wrapper-installer">    
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-installer-general"><?php $FPCM_LANG->write('INSTALLER'); ?></a></li>
            </ul>

            <div id="tabs-installer-general">
                <div class="fpcm-installer-progressbar fpcm-half-width fpcm-ui-margin-center"></div>
                
                <?php if (file_exists(__DIR__.'/'.$subTemplate.'.php')) : ?>                
                    <?php include_once __DIR__.'/'.$subTemplate.'.php'; ?>
                <?php else : ?>
                    <p class="fpcm-ui-center"><?php $FPCM_LANG->write('GLOBAL_NOTFOUND'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <?php if ($showNextButton) : ?>
    <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
        <table>
            <tr>
                <td><?php \fpcm\model\view\helper::submitButton('SubmitNext', 'GLOBAL_NEXT'); ?></td>
            </tr>
        </table>
    </div>
    <?php elseif($showReload) : ?>
    <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
        <table>
            <tr>
                <td><?php \fpcm\model\view\helper::linkButton($FPCM_BASEMODULELINK.'installer&step='.$currentStep.($currentStep > 1 ? '&language='.$FPCM_LANG->getLangCode() : ''), 'GLOBAL_RELOAD'); ?></td>
            </tr>
        </table>
    </div>
    <?php endif; ?>
</form>