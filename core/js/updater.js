/**
 * FanPress CM javascript updater functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmUpdater = function () {
    
    var self = this;
    
    this.runUpdate = function () {
        var updateStart = (new Date().getTime());
        
        fpcmJs.showLoader(true);
        
        if (!fpcmUpdaterProgressbar) {
            jQuery('.fpcm-updater-programmbar').remove();
        }
        self.progressbar(0);
        
        var idx      = 0;
        var code     = '';
        var skipRest = false;
        var scode    = '';
        var content  = '';        
        
        for (idx = fpcmUpdaterStartStep;idx <= fpcmUpdaterMaxStep; idx++) {
            
            if (skipRest) continue;
            
            scode = idx + '_START';
            content = (idx == 5)
                    ? '<p class="fpcm-updater-list-with-button">' + fpcmUpdaterMessages[scode] + '</p>'
                    : '<p>' + fpcmUpdaterMessages[scode] + '</p>';
            
            jQuery('#fpcm-ui-headspinner').addClass('fa-spin');            
            jQuery('.fpcm-updater-list').append(content);
            
            jQuery.ajax({
                url: fpcmAjaxActionPath + 'packagemgr/sysupdater',
                type: 'POST',
                async: false,
                data: {
                    'step': idx
                }
            })
            .done(function(result) {
                self.progressbar(idx);
                code = jQuery.trim(result);
            })
            .fail(function() {
                alert(fpcmAjaxErrorMessage);
            });
            
            if (idx == 4) {
                jQuery.ajax({
                    url: fpcmAjaxActionPath + 'packagemgr/sysupdatervc',
                    type: 'GET',
                    async: false
                })
                .done(function(result) {
                    jQuery('.fpcm-updater-list').append('<p><strong>' + fpcmUpdaterNewVersion + ':</strong> ' + result + '</p>');
                })
                .fail(function() {
                    alert(fpcmAjaxErrorMessage);
                });
            }
            
            if (idx < fpcmUpdaterMaxStep && code != idx + '_' + 1) {
                fpcmJs.showLoader(false);
                fpcmJs.addAjaxMassage('error', fpcmUpdaterMessages[code], false);
                skipRest = true;
            } else if (idx == 5) {
                jQuery('.fpcm-updater-list-files-show').button({
                    icons: {
                        primary: "ui-icon-info"
                    },
                    text: true
                }).click(function () {
                    jQuery('.fpcm-updater-list-files').fadeToggle();
                });                
                jQuery('.fpcm-updater-list').append('<p>' + code + '</p>');
            } else {
                jQuery('.fpcm-updater-list').append('<p><strong> ' + fpcmUpdaterMessages[code] + '</strong></p>');
            }            
        }
        
        jQuery('#fpcm-ui-headspinner').removeClass('fa-spin');

        if (!skipRest) fpcmJs.addAjaxMassage('notice', fpcmUpdaterMessages['EXIT_1'], false);

        var updateTimer = ((new Date().getTime()) - updateStart) / 1000;
        jQuery('.fpcm-updater-list').append('<p>' + fpcmUpdaterProcessTime + ': ' + updateTimer + 'sec</p>');
        
        fpcmJs.showLoader(false);
    };
    
    this.progressbar = function (pgValue) {
        
        if (!fpcmUpdaterProgressbar) return false;  
        
        jQuery('.fpcm-updater-programmbar').progressbar({
            max: fpcmUpdaterMaxStep,
            value: pgValue
        });
    };
    
}