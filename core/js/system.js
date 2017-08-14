/**
 * FanPress CM system javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.system = {
    
    init: function() {
        fpcmJs.runCronsAsync();
        setInterval(fpcmJs.runMinuteIntervals, 60000);
        fpcm.system.initPasswordFieldActions();
    },
    
    initPasswordFieldActions: function() {

        jQuery('#password_confirm').focusout(function () {
            var password = jQuery('#password').val();
            var confirm  = jQuery(this).val();

            if (password != confirm) {
                if (fpcmLang.passCheckAlert !== undefined) {
                    alert(fpcm.ui.translate('passCheckAlert'));
                } else {
                    fpcmJs.addAjaxMassage('error', 'SAVE_FAILED_PASSWORD_MATCH');                
                }
            }

            return false;
        });

        jQuery("#generatepasswd" ).click(function () {
            fpcmJs.generatePasswdString();
            return false;
        });

    }

};

jQuery.noConflict();
jQuery(document).ready(function () {

    fpcmJs   = new fpcmJs();

    jQuery.each(fpcm, function(idx, object) {

        if (typeof object.init === 'function') {
            object.init();
        }

    });

});
