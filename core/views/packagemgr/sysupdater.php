<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-refresh" id="fpcm-ui-headspinner"></span> <?php $FPCM_LANG->write('HL_PACKAGEMGR_SYSUPDATES'); ?></h1>
    <div class="fpcm-tabs-general">
        <ul>
            <li><a href="#tabs-updater-general"><?php $FPCM_LANG->write('HL_PACKAGEMGR_SYSUPDATES'); ?></a></li>
        </ul>

        <div id="tabs-updater-general">
            <?php fpcm\model\view\helper::progressBar('fpcm-updater-programmbar'); ?>
            
            <p><strong><?php $FPCM_LANG->write('PACKAGES_UPDATE_CURRENT_VERSION'); ?>:</strong> <?php print $FPCM_VERSION; ?></p>
            <p><strong><?php $FPCM_LANG->write('PACKAGES_UPDATE_CURRENT_LANG'); ?>:</strong> <?php print $FPCM_LANG->getLangCode(); ?></p>
            
            <div class="fpcm-updater-list"></div>
        </div>        
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function() {
        fpcmUpdater = new fpcmUpdater();
        fpcmUpdater.runUpdate();
    });
</script>