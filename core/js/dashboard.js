/**
 * FanPress CM Dashboard Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 3.5
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.dashboard = {

    init: function () {
        this.loadDashboardContainer();
    },

    loadDashboardContainer: function() {
        fpcm.ajax.exec('dashboard', {
            execDone: function() {
                fpcmJs.assignHtml('#fpcm-dashboard-containers', fpcm.ajax.getResult('dashboard'));
                fpcmJs.assignButtons();

                jQuery('.fpcm-updatecheck-manual').click(function () {
                    fpcmJs.openManualCheckFrame();
                    return false;
                });

                var fpcmRFDinterval = setInterval(function(){
                    if (jQuery('#fpcm-dashboard-finished').length == 1) {
                        jQuery('#fpcm-dashboard-containers-loading').remove();
                        clearInterval(fpcmRFDinterval);
                        fpcm.ui.resize();
                        return false;
                    }
                }, 250);
            }
        });
    }

};