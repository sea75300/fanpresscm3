<div class="fpcm-content-wrapper">
    <h1><span class="fa fa-line-chart fa-fw"></span> <?php $FPCM_LANG->write('NKORG_EXTENDEDSTATS_HEADLINE'); ?></h1>
    
    <div class="fpcm-tabs-general">
        
        <ul>
            <li><a href="#fpcm-nkorg-extendedstats-main"><?php $FPCM_LANG->write('NKORG_EXTENDEDSTATS_BYMONTH'); ?></a></li>
        </ul>
        
        <form method="post" action="<?php print $FPCM_SELF; ?>?module=modules/config&key=nkorg/extendedstats">

            <div id="fpcm-nkorg-extendedstats-main">
                <div class="fpcm-half-width">
                    <div class="fpcm-half-width" style="float:left;display:block;">
                        <div style="margin: 0.4em 0.4em 1.8em 0em;">
                        <?php \fpcm\model\view\helper::textInput('dateFrom', '', $start, false, 10, $FPCM_LANG->translate('ARTICLE_SEARCH_DATE_FROM')); ?>
                        </div>
                    </div>

                    <div class="fpcm-half-width" style="float:left;display:block;">
                        <div style="margin: 0.4em 0em 1.8em 0.4em;">
                        <?php \fpcm\model\view\helper::textInput('dateTo', '', $stop, false, 10, $FPCM_LANG->translate('ARTICLE_SEARCH_DATE_TO')); ?>
                        </div>
                    </div>
                    <div class="fpcm-clear"></div>
                </div>

                <canvas id="fpcm-nkorg-extendedstats-chart" height="100"></canvas>
            </div>

            <div class="<?php \fpcm\model\view\helper::buttonsContainerClass(); ?> fpcm-ui-list-buttons">

                <div class="fpcm-ui-margin-center">
                    <?php \fpcm\model\view\helper::select('chartType', $chartTypes, $chartType, false, false, false, 'fpcm-ui-input-select-articleactions'); ?>
                    <?php \fpcm\model\view\helper::submitButton('setdatespan', 'GLOBAL_OK', 'fpcm-loader'); ?>
                </div>
            </div>
        </form>

    </div>
</div>