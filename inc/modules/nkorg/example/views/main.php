<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-check-square-o fa-fw"></span> <?php $FPCM_LANG->write('FPCM_EXAMPLE_HEADLINE'); ?></h1>

    <div class="fpcm-tabs-general">

        <ul>
            <li><a href="#example"><?php $FPCM_LANG->write('FPCM_EXAMPLE_HEADLINE'); ?></a></li>
        </ul>

        <div id="example">
            <p>This is an example module view. Below you'll see the output of the module logfile, which includes the output of all events.</p>
            <pre>
                <?php print $logfiledata; ?>
            </pre>
        </div>
        
        <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">
            <div class="fpcm-ui-margin-center">
                <form method="post" action="<?php print $FPCM_BASEMODULELINK.$FPCM_CURRENT_MODULE; ?>&key=nkorg/example">
                    <?php \fpcm\model\view\helper::submitButton('clearLog', 'LOGS_CLEARLOG'); ?>
                </form>
            </div>
        </div>
    </div>
</div>