<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-home"></span> <?php $FPCM_LANG->write('HL_DASHBOARD'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_dashboard'); ?>
    </h1>
    <?php foreach ($containers as $container) : ?>
        <?php print $container; ?>
    <?php endforeach; ?>
    <div class="fpcm-clear"></div>
</div>