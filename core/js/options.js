/**
 * FanPress CM UI Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, 2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.options = {

    init: function () {
        
        if (syscheck) {

            fpcm.ui.tabs('.fpcm-tabs-general', {
                active: (showTwitter ? 7 : 6)
            });
            
            jQuery('#tabs-options-syscheck').trigger('click');
        }

        fpcm.ui.datepicker('#articles_archive_datelimit', {
            maxDate: "-3m"
        });
    }

};