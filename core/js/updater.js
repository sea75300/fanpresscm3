/**
 * FanPress CM javascript updater functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmUpdater = function () {
    
    var self = this;
    
    this.responseData = '';    
    this.startTime = 0;    
    this.ajaxHandler;
    
    this.runUpdate = function () {

        self.ajaxHandler = new fpcmAjaxHandler();
        self.startTime   = (new Date().getTime());
        
        fpcmJs.showLoader(true);
        
        if (!fpcmUpdaterProgressbar) {
            jQuery('.fpcm-updater-programmbar').remove();
        }

        self.progressbar(0);
        self.execRequest(fpcmUpdaterStartStep);
    };
    
    this.execRequest = function(idx) {

        var scode    = '';
        var content  = '';

        if (idx > fpcmUpdaterMaxStep) {
            return false;
        }

        scode = idx + '_START';

        content = (idx == 5)
                ? '<p class="fpcm-updater-list-with-button">' + fpcmUpdaterMessages[scode] + '</p>'
                : '<p>' + fpcmUpdaterMessages[scode] + '</p>';

        jQuery('#fpcm-ui-headspinner').addClass('fa-spin');            
        fpcmJs.appendHtml('.fpcm-updater-list', content);

        self.ajaxHandler.action     = 'packagemgr/sysupdater';
        self.ajaxHandler.data       = {step:idx};
        self.ajaxHandler.execDone   = "fpcmUpdater.responseData=fpcmUpdater.ajaxHandler.result;fpcmUpdater.ajaxCallback();";
        self.ajaxHandler.post();
        
        return true;
    };
    
    this.ajaxCallback = function() {

        self.responseData = JSON.parse(self.responseData);
        fpcmUpdater.progressbar(self.responseData.data.current);
        
        if (self.responseData.data.current < fpcmUpdaterMaxStep && self.responseData.code != idx + '_' + 1) {
            fpcmJs.showLoader(false);
            fpcmJs.addAjaxMassage('error', fpcmUpdaterMessages[self.responseData.code], false);
        }

        if (self.responseData.code != self.responseData.data.current + '_' +1) {
            fpcmJs.showLoader(false);
            fpcmJs.appendHtml('.fpcm-updater-list', '<p class="fpcm-ui-important-text">' + fpcmUpdaterMessages[self.responseData.code] + '</p>');
            return false;
        }

        fpcmJs.appendHtml('.fpcm-updater-list', '<p><strong> ' + fpcmUpdaterMessages[self.responseData.code] + '</strong></p>');

        if (self.responseData.data.current == 4) {
            self.ajaxHandler.action     = 'packagemgr/sysupdatervc';
            self.ajaxHandler.execDone   = "fpcmUpdater.ajaxCallbackFinal(fpcmUpdater.ajaxHandler.result);";
            self.ajaxHandler.async      = false;
            self.ajaxHandler.get();
        }

        self.execRequest(self.responseData.data.nextstep);

        return true;
    };
    
    this.ajaxCallbackFinal = function(version) {
        fpcmJs.appendHtml('.fpcm-updater-list', '<p><strong>' + fpcmUpdaterNewVersion + ':</strong> ' + version + '</p>');

        if (self.responseData.code && self.responseData.data.current == fpcmUpdaterMaxStep) {
            fpcmJs.addAjaxMassage('notice', fpcmUpdaterMessages['EXIT_1'], false);
        }
        
        fpcmJs.showLoader(false);
        jQuery('#fpcm-ui-headspinner').removeClass('fa-spin');
        self.addTimer();

        return true;
    };
    
    this.addTimer = function() {
        var updateTimer = ((new Date().getTime()) - self.startTime) / 1000;
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