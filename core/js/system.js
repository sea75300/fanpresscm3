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
        fpcm.system.runCronsAsync();
        setInterval(fpcm.system.runMinuteIntervals, 60000);
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

    },
    
    showSessionCheckDialog: function () {
        
        window.fpcmSessionCheckEnabled = false;

        fpcm.ui.dialog({
            content: fpcm.ui.translate('sessionCheckMsg'),
            dlButtons: buttons = [
                {
                    text: fpcm.ui.translate('yes'),
                    icon: "ui-icon-check",
                    click: function() {
                        fpcmJs.relocate(fpcmActionPath + 'system/login');
                        jQuery(this).dialog('close');
                    }
                },
                {
                    text: fpcm.ui.translate('no'),
                    icon: "ui-icon-closethick",
                    click: function() {
                        fpcmSessionCheckEnabled = true;
                        jQuery(this).dialog('close');
                    }
                }
            ],
            id: 'sessioncheck'
        });
    },
    
    checkSession: function() {
        
        if (!window.fpcmSessionCheckEnabled) {
            return false;
        }

        fpcm.ajax.exec('session', {
            execDone: function() {                
                if (fpcm.ajax.getResult('session') != '0') {
                    return true;
                }
                fpcm.system.showSessionCheckDialog
            },
            execFail: fpcm.system.showSessionCheckDialog,
        });
        
        return false;
    },
    
    runCronsAsync: function() {
        if (window.fpcmCronAsyncDiabled) {
            return false;
        }
        
        fpcm.ajax.get('cronasync');
    },
    
    runMinuteIntervals: function() {
        fpcm.system.runCronsAsync();
        fpcm.system.checkSession();
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
