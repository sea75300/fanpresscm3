/**
 * FanPress CM javascript updater functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmUpdater = function () {
    
    var self = this;
    
    this.code = '';
    
    this.runUpdate = function () {
        var updateStart = (new Date().getTime());
        
        fpcmJs.showLoader(true);
        
        if (!fpcmUpdaterProgressbar) {
            jQuery('.fpcm-updater-programmbar').remove();
        }
        self.progressbar(0);
        
        var idx      = 0;
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
            fpcmJs.appendHtml('.fpcm-updater-list', content);
            
            fpcmAjax.action     = 'packagemgr/sysupdater';
            fpcmAjax.data       = {step:idx};
            fpcmAjax.execDone   = "fpcmUpdater.progressbar(fpcmAjax.workData);fpcmUpdater.code = jQuery.trim(fpcmAjax.result);";
            fpcmAjax.async      = false;
            fpcmAjax.workData   = idx;
            fpcmAjax.post();
            fpcmAjax.reset();
            
            if (idx == 4) {
                fpcmAjax.action     = 'packagemgr/sysupdatervc';
                fpcmAjax.execDone   = "fpcmJs.appendHtml('.fpcm-updater-list', '<p><strong>' + fpcmUpdaterNewVersion + ':</strong> ' + fpcmAjax.result + '</p>');";
                fpcmAjax.async      = false;
                fpcmAjax.get();
                fpcmAjax.reset();                
            }
            
            if (idx < fpcmUpdaterMaxStep && self.code != idx + '_' + 1) {
                fpcmJs.showLoader(false);
                fpcmJs.addAjaxMassage('error', fpcmUpdaterMessages[self.code], false);
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
                fpcmJs.appendHtml('.fpcm-updater-list', '<p>' + self.code + '</p>');
            } else {
                fpcmJs.appendHtml('.fpcm-updater-list', '<p><strong> ' + fpcmUpdaterMessages[self.code] + '</strong></p>');
            }            
        }
        
        jQuery('#fpcm-ui-headspinner').removeClass('fa-spin');

        if (!skipRest) fpcmJs.addAjaxMassage('notice', fpcmUpdaterMessages['EXIT_1'], false);

        var updateTimer = ((new Date().getTime()) - updateStart) / 1000;
        fpcmJs.appendHtml('.fpcm-updater-list', '<p>' + fpcmUpdaterProcessTime + ': ' + updateTimer + 'sec</p>');
        
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