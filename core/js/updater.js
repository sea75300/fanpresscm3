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
            jQuery('.fpcm-updater-progressbar').remove();
        }

        self.progressbar(0);
        self.execRequest(fpcmUpdaterStartStep);
    };
    
    this.execRequest = function(idx) {

        if (idx > fpcmUpdaterMaxStep) {
            return false;
        }

        fpcmJs.assignHtml('div.fpcm-updater-progressbar div.fpcm-ui-progressbar-label', fpcmUpdaterMessages[idx + '_START']);

        self.ajaxHandler.action     = 'packagemgr/sysupdater';
        self.ajaxHandler.data       = {
            step:idx,
            force: (fpcmUpdaterStartStep > 1 ? 1 : 0)
        };
        self.ajaxHandler.execDone   = "fpcmUpdater.responseData=fpcmUpdater.ajaxHandler.result;fpcmUpdater.ajaxCallback();";
        self.ajaxHandler.post();
        
        return true;
    };
    
    this.ajaxCallback = function() {

        self.responseData = fpcmAjax.fromJSON(self.responseData);
        if (self.responseData.data === undefined) {
            alert(fpcmAjaxResponseErrorMessage);
            return false;
        }

        fpcmUpdater.progressbar(self.responseData.data.current);
        
        if (self.responseData.data.current < fpcmUpdaterMaxStep && self.responseData.code != self.responseData.data.current + '_' + 1) {
            fpcmJs.showLoader(false);
            fpcmJs.appendHtml('.fpcm-updater-list', '<p class="fpcm-ui-important-text">' + fpcmUpdaterMessages[self.responseData.code] + '</p>');
            return false;
        }
        else if (self.responseData.data.current == 6) {
            fpcmJs.appendHtml('.fpcm-updater-list', '<p>' + fpcmUpdaterMessages[self.responseData.code] + ': ' + self.responseData.data.newver + '</p>');
            fpcmUpdater.ajaxCallbackFinal(fpcmUpdater.responseData);
        }
        else {
            fpcmJs.appendHtml('.fpcm-updater-list', '<p>' + fpcmUpdaterMessages[self.responseData.code] + '</p>');
        }

        if (self.responseData.data.current < fpcmUpdaterMaxStep) {
            self.execRequest(self.responseData.data.nextstep);
        }
        
        if (self.responseData.data.current == fpcmUpdaterMaxStep) {
            fpcmJs.assignText('div.fpcm-updater-progressbar div.fpcm-ui-progressbar-label', '');
        }

        return true;
    };
    
    this.ajaxCallbackFinal = function(result) {

        jQuery('#fpcm-ui-headspinner').removeClass('fa-spin');
        fpcmJs.addAjaxMassage('notice', fpcmUpdaterMessages['EXIT_1']);
        fpcmJs.appendHtml('.fpcm-updater-list', '<p>' + '<span class="fa fa-check-square fa-fw fa-lg fpcm-ui-booltext-yes"></span>'  + fpcmUpdaterMessages['EXIT_1'] + '</p>');
        fpcmJs.showLoader(false);
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

        fpcm.ui.progressbar('.fpcm-updater-progressbar', {
            max: fpcmUpdaterMaxStep,
            value: pgValue
        });

    };
    
}