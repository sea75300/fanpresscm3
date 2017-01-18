<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-home"></span> <?php $FPCM_LANG->write('HL_DASHBOARD'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_dashboard'); ?>
    </h1>
    
    <div id="fpcm-dashboard-containers-loading" class="fpcm-ui-center">
        <span class="fa-stack fa-lg">
          <span class="fa fa-square fa-stack-2x fa-inverse"></span>
          <span class="fa fa-fw fa-spin fa-spinner fa-stack-1x"></span>
        </span>
        <strong><?php $FPCM_LANG->write('DASHBOARD_LOADING'); ?>...</strong>
    </div>
    
    <div id="fpcm-dashboard-containers"></div>

    <div class="fpcm-clear"></div>
</div>