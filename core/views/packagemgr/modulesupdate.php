<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-refresh" id="fpcm-ui-headspinner"></span> <?php $FPCM_LANG->write('MODULES_LIST_UPDATE'); ?></h1>
    <div class="fpcm-tabs-general">
        <ul>
            <li><a href="#tabs-updater-general"><?php $FPCM_LANG->write('MODULES_LIST_UPDATE'); ?></a></li>
        </ul>

        <div id="tabs-updater-general">
        <?php if (isset($nokeys)) : ?>
            <?php $FPCM_LANG->write('GLOBAL_NOTFOUND2'); ?>
        <?php else : ?>
            <div class="fpcm-updater-programmbar"></div>
            <div class="fpcm-updater-list"></div>
        <?php endif; ?>
        </div>
    </div>
</div>

<div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
    <table>
        <tr>
            <td><?php fpcm\model\view\helper::linkButton($FPCM_BASEMODULELINK.'modules/list', 'MODULES_LIST_BACKTOLIST', '', 'fpcm-loader'); ?></td>
        </tr>
    </table>
</div>

<script type="text/javascript">
    jQuery(function() {
        fpcmModuleInstaller = new fpcmModuleInstaller();
        fpcmModuleInstaller.init('update');
    });
</script>