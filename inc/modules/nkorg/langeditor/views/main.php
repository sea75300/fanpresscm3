<form method="post" action="<?php print $FPCM_SELF; ?>?module=<?php print $FPCM_CURRENT_MODULE; ?>&key=nkorg/langeditor">
    <div class="fpcm-content-wrapper">
        <h1>
            <span class="fa fa-language fa-fw"></span> <?php $FPCM_LANG->write('NKORG_LANGEDITOR_HEADLINE'); ?>
            <?php fpcm\model\view\helper::helpButton('NKORG_LANGEDITOR_HEADLINE'); ?>
        </h1>

        <div class="fpcm-tabs-general">

            <ul>
                <li><a href="#langvars"><?php $FPCM_LANG->write('NKORG_LANGEDITOR_HEADLINE'); ?><?php if($selectedFile) : ?>: <?php print \fpcm\model\files\ops::removeBaseDir($selectedFile); ?><?php endif; ?></a></li>
            </ul>

            <div id="langvars">
    
            <?php if (count($lines)) : ?>
                <table class="fpcm-ui-table fpcm-ui-middle">
                    <tr>
                        <th><?php $FPCM_LANG->write('NKORG_LANGEDITOR_LANGVAR'); ?></th>
                        <th><?php $FPCM_LANG->write('NKORG_LANGEDITOR_VARVALUE'); ?></th>
                        <th class="fpcm-th-select-row fpcm-ui-center">
                            <span class="fa fa-question-circle fa-fw fpcm-ui-shorthelp" title="<?php $FPCM_LANG->write('NKORG_LANGEDITOR_DELETELINE'); ?>"></span>
                        </th>
                    </tr>
                    <?php foreach ($lines as $lineName => $lineValue) : ?>
                    <?php $hash   = md5($lineName.$lineValue); ?>
                    <?php $class  = (strlen($lineName) > 512 || strlen($lineValue) > 2048 ? 'fpcm-ui-important-text' : ''); ?>
                    <tr>
                        <td>
                            <?php fpcm\model\view\helper::textInput('langitems['.$hash.'][name]', $class, $lineName, false, 512); ?>
                        </td>
                        <td>
                            <?php fpcm\model\view\helper::textInput('langitems['.$hash.'][value]', $class, str_replace(PHP_EOL, '\\n', $lineValue), false, 2048); ?>
                        </td>
                        <td class="fpcm-td-select-row fpcm-ui-center">
                            <?php \fpcm\model\view\helper::checkbox('deleteitems[]', '', $hash, '', '', false); ?>
                        </td>
                    </tr>
                    <?php $unique = uniqid(); ?>
                    <tr>
                        <td>
                            <?php fpcm\model\view\helper::textInput('langitems['.$unique.'][name]', '', '', false, 512, $FPCM_LANG->translate('NKORG_LANGEDITOR_EMPTYLINE')); ?>
                        </td>
                        <td>
                            <?php fpcm\model\view\helper::textInput('langitems['.$unique.'][value]', '', '', false, 2048, $FPCM_LANG->translate('NKORG_LANGEDITOR_EMPTYLINE')); ?>
                        </td>
                        <td class="fpcm-td-select-row fpcm-ui-center"></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else : ?>
                <?php $FPCM_LANG->write('NKORG_LANGEDITOR_FILENOTICE'); ?>                
            <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
        <div class="fpcm-ui-margin-center">
            <?php fpcm\model\view\helper::select('langfile', $langfiles, base64_encode($selectedFile), false, false, false, 'fpcm-ui-input-select-moduleactions'); ?>
            <?php fpcm\model\view\helper::submitButton('langfileSelect', 'GLOBAL_OK'); ?>
            <?php if (count($lines)) : ?><?php \fpcm\model\view\helper::saveButton('editLangfile'); ?><?php endif; ?>
        </div>
    </div>
</form>