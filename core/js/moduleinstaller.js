/**
 * FanPress CM javascript module installer functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmModuleInstaller = function () {
    
    var self = this;
    
    this.code = '';
    
    this.init = function (type) {

        if (typeof fpcmUpdaterProgressbar == 'undefined') {
            jQuery('.fpcm-updater-programmbar').remove();
        } else {
            self.progressbar(0);            
        }

        var updateStart = (new Date().getTime());

        jQuery('.fpcm-updater-list').empty();
        fpcmJs.showLoader(true);

        var x = 1;
        jQuery.each(fpcmModuleKeys, function(idx, modKey) {
            self.progressbar(x);           
            result = self.runInstall(modKey, idx, type);
            x++;
        });
        
        var updateTimer = ((new Date().getTime()) - updateStart) / 1000;
        jQuery('.fpcm-updater-list').append('<p>' + fpcmUpdaterProcessTime + ': ' + updateTimer + 'sec</p>');
        fpcmJs.showLoader(false);
        
        return false;
    };
    
    this.runInstall = function (key, moduleIndex, type) {

        var idx      = 0;
        var skipRest = false;
        var scode    = '';
        var content  = '';

        var moduleListClass = 'fpcm-updater-list-'+ moduleIndex;
        jQuery('.fpcm-updater-list').append('<div class="' + moduleListClass + ' fpcm-ui-modules-installerbox"></div>');
        moduleListClass = '.' + moduleListClass;
        
        for (idx = fpcmUpdaterStartStep;idx <= fpcmUpdaterMaxStep; idx++) {
            
            if (skipRest) continue;
            
            scode = idx + '_START';
            
            var msgText = fpcmUpdaterMessages[scode];
            
            if (idx == 1) {
                msgText = msgText.replace('{{pkglink}}', fpcmModuleUrl.replace('{{pkgkey}}', key));
            }
            
            content = (idx == 5)
                    ? '<p class="fpcm-updater-list-with-button-' + moduleIndex + '">' + msgText + '</p>'
                    : '<p>' + msgText + '</p>';
            
            jQuery('#fpcm-ui-headspinner').addClass('fa-spin');
            jQuery(moduleListClass).append(content);
            
            fpcmAjax.action     = 'packagemgr/mod' + type;
            fpcmAjax.data       = {step:idx,key:key,midx:moduleIndex};
            fpcmAjax.execDone   = "fpcmModuleInstaller.code=jQuery.trim(fpcmAjax.result);";
            fpcmAjax.async      = false;
            fpcmAjax.post();
            fpcmAjax.reset();            

            if (idx < fpcmUpdaterMaxStep && self.code != idx + '_' +1) {
                fpcmJs.showLoader(false);
                jQuery(moduleListClass).append('<p class="fpcm-ui-important-text">' + fpcmUpdaterMessages[self.code] + '</p>');
                skipRest = true;
            } else if (idx == 5) {
                jQuery('.fpcm-updater-list-files-show').button({
                    icons: {
                        primary: "ui-icon-info"
                    },
                    text: true
                }).click(function () {
                    jQuery('.fpcm-updater-list-files-' + moduleIndex).fadeToggle();
                    return false;
                });                
                jQuery(moduleListClass).append('<p>' + self.code + '</p>');
            } else {
                jQuery(moduleListClass).append('<p><strong> ' + fpcmUpdaterMessages[self.code] + '</strong></p>');
            }
            
            jQuery('#fpcm-ui-headspinner').removeClass('fa-spin');
        }

        if (!skipRest) {
            jQuery(moduleListClass).append('<p>' + fpcmUpdaterMessages['EXIT_1'] + '</p>');   
        }

        return skipRest ? false : true;

    };
    
    this.progressbar = function (pgValue) {
        
        if (typeof fpcmUpdaterProgressbar == 'undefined') return false;  
        
        jQuery('.fpcm-updater-programmbar').progressbar({
            max: fpcmProgressbarMax,
            value: pgValue
        });
    };
    
}