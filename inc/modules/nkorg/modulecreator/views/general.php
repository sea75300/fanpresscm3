<table class="fpcm-ui-table fpcm-ui-options">
    <tr>
        <td><strong><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL_NAME'); ?></strong></td>
        <td><?php \fpcm\model\view\helper::textInput('nkorgmodulecreator[name]', 'fpcm-half-width fpcm-nkorgmodulecreator-input') ?></td>
    </tr>
    <tr>
        <td><strong><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL_VENDOR'); ?></strong></td>
        <td><?php \fpcm\model\view\helper::textInput('nkorgmodulecreator[vendor]', 'fpcm-half-width fpcm-nkorgmodulecreator-input') ?></td>
    </tr>
    <tr>
        <td><strong><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL_KEY'); ?></strong></td>
        <td><?php \fpcm\model\view\helper::textInput('nkorgmodulecreator[key]', 'fpcm-half-width fpcm-nkorgmodulecreator-input') ?></td>
    </tr>
    <tr>
        <td><strong><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL_AUTHOR'); ?></strong></td>
        <td><?php \fpcm\model\view\helper::textInput('nkorgmodulecreator[author]', 'fpcm-half-width fpcm-nkorgmodulecreator-input', $FPCM_USER) ?></td>
    </tr>
    <tr>
        <td><strong><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL_LINK'); ?></strong></td>
        <td><?php \fpcm\model\view\helper::textInput('nkorgmodulecreator[link]', 'fpcm-half-width fpcm-nkorgmodulecreator-input') ?></td>
    </tr>
    <tr>
        <td><strong><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL_VERSION'); ?></strong></td>
        <td><?php \fpcm\model\view\helper::textInput('nkorgmodulecreator[version]', 'fpcm-half-width fpcm-nkorgmodulecreator-input', '0.0.1') ?></td>
    </tr>
    <tr>
        <td><strong><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL_FPCMVER'); ?></strong></td>
        <td><?php \fpcm\model\view\helper::textInput('nkorgmodulecreator[sysversion]', 'fpcm-half-width fpcm-nkorgmodulecreator-input', $FPCM_VERSION) ?></td>
    </tr>
    <tr>
        <td><strong><?php $FPCM_LANG->write('NKORG_MODULECREATOR_GENERAL_DESCR'); ?></strong></td>
        <td><?php \fpcm\model\view\helper::textArea('nkorgmodulecreator[description]', 'fpcm-half-width fpcm-nkorgmodulecreator-input') ?></td>
    </tr>
</table>