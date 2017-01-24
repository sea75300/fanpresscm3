/**
 * FanPress CM Options Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.options = {

    init: function () {
        
        if (window.syscheck) {

            fpcm.ui.tabs('.fpcm-tabs-general', {
                active: (window.showTwitter ? 7 : 6)
            });
            
            fpcmJs.systemCheck();
        }

        fpcm.ui.datepicker('#articles_archive_datelimit', {
            maxDate: "-3m"
        });

        jQuery('#tabs-options-syscheck').click(function () {
            fpcmJs.systemCheck();
        });
    }

};