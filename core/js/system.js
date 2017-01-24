/**
 * FanPress CM system javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
jQuery.noConflict();
jQuery(document).ready(function () {

    if (typeof fpcmSessionCheckEnabled !== 'undefined' && fpcmSessionCheckEnabled) {
        setInterval(function() {
            fpcmJs.checkSession();
        }, 60000);
    }

    fpcmAjax = new fpcmAjaxHandler();

    fpcmJs = new fpcmJs();
    fpcmJs.runCronsAsync();
    
    jQuery.each(fpcm, function(idx, object) {
        if (typeof object.init === 'function') {
            object.init();
        }
    });

    fpcm.ui.resize();
    jQuery(window).resize(function () {
        fpcm.ui.resize();
    });
    
    jQuery('.fpcm-loader').click(function () {
        if (jQuery(this).hasClass('fpcm-noloader')) return false;        
        fpcmJs.showLoader(true);
    });

    jQuery('#fpcm-clear-cache').click(function () {
        return fpcmJs.clearCache();
    });

    if (typeof fpcmDtMasks != 'undefined') {
        jQuery("#system_dtmask").autocomplete({
            source: fpcmDtMasks
        });
        jQuery("#usermetasystem_dtmask").autocomplete({
            source: fpcmDtMasks
        });        
    };
    
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

});
