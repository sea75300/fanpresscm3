<table class="fpcm-ui-table fpcm-ui-options">
    <tr>			
        <td><?php $FPCM_LANG->write('FPCM_CLASSICIMPORTER_IMPORT_FPCM2_PATH'); ?>:</td>
        <td><?php fpcm\model\view\helper::textInput('fpcm2_path', '', '/fanpress/'); ?></td>
        <td><?php \fpcm\model\view\helper::button('submit', 'checkPath', 'FPCM_CLASSICIMPORTER_IMPORT_FPCM2_CHECKPATH', 'fpcm-classicimporter-importstart') ?></td>
        <td><?php if (!$doimport) : ?><?php \fpcm\model\view\helper::button('submit', 'systemReset', 'FPCM_CLASSICIMPORTER_RESETSYSTEM', 'fpcm-classicimporter-importstart') ?><?php endif; ?></td>
    </tr>
</table>