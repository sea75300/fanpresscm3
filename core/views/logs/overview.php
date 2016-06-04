<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-exclamation-triangle"></span> <?php $FPCM_LANG->write('HL_LOGS'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_options'); ?>
    </h1>
    <form method="post" action="<?php print $FPCM_SELF; ?>?module=system/logs">
        
        <div class="fpcm-tabs-general">
            <ul>
                <li><a href="#tabs-logs-sessionlog" id="fpcm-logs-reload_0" class="fpcm-logs-reload"><?php $FPCM_LANG->write('HL_LOGS_SESSIONS'); ?></a></li>
                <li><a href="#tabs-logs-systemlog" id="fpcm-logs-reload_1" class="fpcm-logs-reload"><?php $FPCM_LANG->write('HL_LOGS_SYSTEM'); ?></a></li>
                <li><a href="#tabs-logs-phplog" id="fpcm-logs-reload_2" class="fpcm-logs-reload"><?php $FPCM_LANG->write('HL_LOGS_ERROR'); ?></a></li>
                <li><a href="#tabs-logs-sqllog" id="fpcm-logs-reload_3" class="fpcm-logs-reload"><?php $FPCM_LANG->write('HL_LOGS_DATABASE'); ?></a></li>
                <li><a href="#tabs-logs-packages" id="fpcm-logs-reload_4" class="fpcm-logs-reload"><?php $FPCM_LANG->write('HL_LOGS_PACKAGES'); ?></a></li>
            </ul>
            <div id="tabs-logs-sessionlog">
                <div id="fpcm-logcontent0">
                    <?php include __DIR__.'/sessions.php'; ?>
                </div>
                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php fpcm\model\view\helper::submitButton('fpcm-logs-clear_0', 'LOGS_CLEARLOG', 'fpcm-logs-clear fpcm-clear-btn'); ?></td>
                        </tr>
                    </table>
                </div>              
            </div>
            <div id="tabs-logs-systemlog">
                <div id="fpcm-logcontent1">
                    <?php include __DIR__.'/system.php'; ?>
                </div>                
                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php fpcm\model\view\helper::submitButton('fpcm-logs-clear_1', 'LOGS_CLEARLOG', 'fpcm-logs-clear fpcm-clear-btn'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="tabs-logs-phplog">
                <div id="fpcm-logcontent2">
                    <?php include __DIR__.'/errors.php'; ?>
                </div>                
                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php fpcm\model\view\helper::submitButton('fpcm-logs-clear_2', 'LOGS_CLEARLOG', 'fpcm-logs-clear fpcm-clear-btn'); ?></td>
                        </tr>
                    </table>
                </div>          
            </div>             
            <div id="tabs-logs-sqllog">
                <div id="fpcm-logcontent3">
                    <?php include __DIR__.'/database.php'; ?>
                </div>                
                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php fpcm\model\view\helper::submitButton('fpcm-logs-clear_3', 'LOGS_CLEARLOG', 'fpcm-logs-clear fpcm-clear-btn'); ?></td>
                        </tr>
                    </table>
                </div> 
            </div>             
            <div id="tabs-logs-packages">
                <div id="fpcm-logcontent4">
                    <?php include __DIR__.'/packages.php'; ?>
                </div>
                <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?>">
                    <table>
                        <tr>
                            <td><?php fpcm\model\view\helper::submitButton('fpcm-logs-clear_4', 'LOGS_CLEARLOG', 'fpcm-logs-clear fpcm-clear-btn'); ?></td>
                        </tr>
                    </table>
                </div> 
            </div>            
        </div>    
    </form>
</div>