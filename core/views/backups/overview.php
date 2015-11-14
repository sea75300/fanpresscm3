<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-life-ring"></span> <?php $FPCM_LANG->write('HL_BACKUPS'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_options'); ?>
    </h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=system/logs">
        
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-backups-database"><?php $FPCM_LANG->write('BACKUPS_TAB_DATABASE'); ?></a></li>
            </ul>
            <div id="tabs-backups-database">
                <table class="fpcm-ui-table fpcm-ui-backups">
                    <?php fpcm\model\view\helper::notFoundContainer($folderList, 2); ?>
                    
                    <?php foreach ($folderList as $value) : ?>
                    <tr>
                        <td class="fpcm-ui-editbutton-col">
                            <?php \fpcm\model\view\helper::linkButton(fpcm\classes\baseconfig::$rootPath.'index.php?module=system/backups&save='.str_rot13(base64_encode($value)), 'GLOBAL_DOWNLOAD', '', 'fpcm-backuplist-save', '_blank'); ?>
                        </td>
                        <td>
                            <?php print basename($value); ?>
                        </td>
                        <td>
                            <?php print \fpcm\classes\tools::calcSize(filesize($value)); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>    
    </form>
</div>