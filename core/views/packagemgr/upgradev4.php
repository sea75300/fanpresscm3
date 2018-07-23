<div class="fpcm-content-wrapper">
    <div class="fpcm-tabs-general">
        <ul>
            <li><a href="#tabs-updater-general"><?php $FPCM_LANG->write('UPGARDEV4_HEADLINE'); ?></a></li>
        </ul>

        <div id="tabs-updater-general">
            <p>
                <span class="fpcm-update-icon fa fa-arrow-circle-right fa-lg fa-fw"></span>
                <strong><?php $FPCM_LANG->write('PACKAGES_UPDATE_CURRENT_VERSION'); ?>:</strong>
                <?php print $FPCM_VERSION; ?>
            </p>

            <p>
                <span class="fpcm-update-icon fa fa-language fa-lg fa-fw"></span>
                <strong><?php $FPCM_LANG->write('PACKAGES_UPDATE_CURRENT_LANG'); ?>:</strong>
                <?php print $FPCM_LANG->getLangCode(); ?>
            </p>

            <p data-action="download" data-icon="download" class="fpcm-ui-update-steps">
                <span class="fpcm-update-icon fa fa-download fa-lg fa-fw"></span>
                <span class="fpcm-ui-descr"><?php $FPCM_LANG->write('UPGARDEV4_DOWNLOAD'); ?></span>
            </p>

            <p data-action="extract" data-icon="file-archive-o" class="fpcm-ui-update-steps">
                <span class="fpcm-update-icon fa fa-file-archive-o fa-lg fa-fw"></span>
                <span class="fpcm-ui-descr"><?php $FPCM_LANG->write('UPGARDEV4_EXTRACT'); ?></span>
            </p>

            <p data-action="checkFs" data-icon="medkit" class="fpcm-ui-update-steps">
                <span class="fpcm-update-icon fa fa-medkit fa-lg fa-fw"></span>
                <span class="fpcm-ui-descr"><?php $FPCM_LANG->write('UPGARDEV4_CHECKFS'); ?></span>
            </p>

            <p data-action="updateFs" data-icon="copy" class="fpcm-ui-update-steps">
                <span class="fpcm-update-icon fa fa-copy fa-lg fa-fw"></span>
                <span class="fpcm-ui-descr"><?php $FPCM_LANG->write('UPGARDEV4_REPLACE'); ?></span>
            </p>

            <p data-func="redirect" data-icon="forward" class="fpcm-ui-update-steps">
                <span class="fpcm-update-icon fa fa-forward fa-lg fa-fw"></span>
                <span class="fpcm-ui-descr"><?php $FPCM_LANG->write('UPGARDEV4_REDIRECT'); ?></span>
            </p>
        </div>        
    </div>    
</div>