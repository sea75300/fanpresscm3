<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-check-square-o fa-fw"></span> <?php $FPCM_LANG->write('FPCM_EXAMPLE_HEADLINE'); ?></h1>

    <div class="fpcm-tabs-general">

        <ul>
            <li><a href="#example"><?php $FPCM_LANG->write('NKORG_TWEETENTENDER_TERMLIST'); ?></a></li>
        </ul>

        <div id="example">
            <p>This is an example module view. Below you'll see the output of the module logfile, which includes the output of all events.</p>
            <pre>
                <?php print $logfiledata; ?>
            </pre>
        </div>
    </div>
</div>