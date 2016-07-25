<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-refresh" id="fpcm-ui-headspinner"></span> <?php $FPCM_LANG->write('MODULES_LIST_INSTALL'); ?></h1>
    <div class="fpcm-tabs-general">
        <ul>
            <li><a href="#tabs-updater-general"><?php $FPCM_LANG->write('MODULES_LIST_INSTALL'); ?></a></li>
        </ul>

        <div id="tabs-updater-general">
        <?php if (isset($nokeys)) : ?>
            <?php $FPCM_LANG->write('GLOBAL_NOTFOUND2'); ?>
        <?php else : ?>
            <?php fpcm\model\view\helper::progressBar('fpcm-updater-progressbar'); ?>
            <div class="fpcm-updater-list"></div>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
    <?php fpcm\model\view\helper::linkButton($FPCM_BASEMODULELINK.'modules/list', 'MODULES_LIST_BACKTOLIST', '', 'fpcm-loader'); ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmModuleInstaller = new fpcmModuleInstaller();
        fpcmModuleInstaller.init('install');
    });
</script>