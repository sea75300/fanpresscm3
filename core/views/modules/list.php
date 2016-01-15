<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-plug"></span> <?php $FPCM_LANG->write('HL_MODULES'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_modules'); ?>
    </h1>
    <div class="fpcm-tabs-general">
        <ul>
            <li><a href="#tabs-modules-list"><?php $FPCM_LANG->write('MODULES_LIST_HEADLINE'); ?></a></li>
            <?php if ($permissionInstall) : ?><li><a href="#tabs-modules-upload"><?php $FPCM_LANG->write('MODULES_LIST_UPLOAD'); ?></a></li><?php endif; ?>
        </ul>

        <div id="tabs-modules-list">
            <div id="modules-list-content">
                <?php include __DIR__.'/list_inner.php'; ?>
            </div>
            
            <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons fpcm-ui-articlelist-buttons">
                <table>
                    <tr>
                        <?php if ($moduleManagerMode) : ?>
                        <td><?php fpcm\model\view\helper::linkButton('#', 'MODULES_LIST_RELOADPKGLIST', 'fpcm-ui-reloadpkglist', 'fpcm-ui-button-blank fpcm-reload-btn'); ?></td>
                        <?php else : ?>
                        <td><?php fpcm\model\view\helper::linkButton(\fpcm\classes\baseconfig::$moduleServerManualLink, 'MODULES_LIST_EXTERNALLIST', 'fpcm-ui-externalpkglist', 'fpcm-externallink-btn', '_blank'); ?></td>
                        <?php endif; ?>
                        <td><?php fpcm\model\view\helper::select('moduleActions', $moduleActions, '', false, true, false, 'fpcm-ui-input-select-moduleactions'); ?></td>
                        <td><?php \fpcm\model\view\helper::submitButton('doAction', 'GLOBAL_OK', 'fpcm-ui-actions-modules fpcm-loader'); ?></td>
                    </tr>
                </table>
            </div>         
        </div>
        
        <?php if ($permissionInstall) : ?>
        <div id="tabs-modules-upload">
            <form action="<?php print $FPCM_BASEMODULELINK; ?>modules/list" method="POST" enctype="multipart/form-data">
                <table id="fpcm-ui-phpupload-filelist" class="fpcm-ui-table fpcm-ui-phpupload"></table>

                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <span class="fpcm-ui-fileinput-php">
                        <?php fpcm\model\view\helper::linkButton('#', 'FILE_FORM_FILEADD') ?>
                        <?php fpcm\model\view\helper::submitButton('uploadFile', 'FILE_FORM_UPLOADSTART', 'start-upload fpcm-loader'); ?>

                        <button type="reset" class="cancel-upload" id="fpcm-ui-phpupload-cancel"><?php $FPCM_LANG->write('FILE_FORM_UPLOADCANCEL'); ?></button>

                        <input type="file" name="files[]" class="fpcm-ui-fileinput-select fpcm-hidden">
                    </span>
                </div>    
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="fpcm-ui-dialog-layer" id="fpcm-modulelist-infos">  
    <table class="fpcm-ui-table">
        <tr>
            <td class="fpcm-quarter-width"><label><?php $FPCM_LANG->write('MODULES_LIST_KEY'); ?>:</label></td>
            <td colspan="3" id="fpcm-modulelist-infos-key"></td>            
        </tr>
        <tr>
            <td class="fpcm-quarter-width"><label><?php $FPCM_LANG->write('MODULES_LIST_DESCRIPTION'); ?>:</label></td>
            <td colspan="3" id="fpcm-modulelist-infos-description"></td>
        </tr>
        <tr>
            <td class="fpcm-quarter-width"><label><?php $FPCM_LANG->write('MODULES_LIST_AUTHOR'); ?>:</label></td>
            <td colspan="3" id="fpcm-modulelist-infos-author"></td>
        </tr>
        <tr>
            <td class="fpcm-quarter-width"><label><?php $FPCM_LANG->write('MODULES_LIST_LINK'); ?>:</label></td>
            <td colspan="3" id="fpcm-modulelist-infos-link"></td>
        </tr>
        <tr>
            <td class="fpcm-quarter-width"><label><?php $FPCM_LANG->write('MODULES_LIST_VERSION_LOCAL'); ?>:</label></td>
            <td id="fpcm-modulelist-infos-version" class="fpcm-quarter-width"></td>
            <td class="fpcm-quarter-width"><label><?php $FPCM_LANG->write('MODULES_LIST_VERSION_REMOTE'); ?>:</label></td>
            <td id="fpcm-modulelist-infos-versionrem" class="fpcm-quarter-width"></td>            
        </tr>
        <tr>
            <td class="fpcm-quarter-width"><label><?php $FPCM_LANG->write('MODULES_LIST_DEPENCIES'); ?>:</label></td>
            <td colspan="3" id="fpcm-modulelist-infos-dependencies"></td>
        </tr>
    </table>
</div>