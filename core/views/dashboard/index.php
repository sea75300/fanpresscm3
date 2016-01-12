<div class="fpcm-content-wrapper">
    <h1>
        <span class="fa fa-home"></span> <?php $FPCM_LANG->write('HL_DASHBOARD'); ?>
        <?php \fpcm\model\view\helper::helpButton('hl_dashboard'); ?>
    </h1>
    
    <div id="fpcm-dashboard-containers"></div>
    <div class="fpcm-clear"></div>
</div>

<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function () {
    fpcmJs.loadDashboardContainer();
});
</script>