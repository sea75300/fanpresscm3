/**
 * FanPress CM javascript module installer functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, 2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

var fpcmModuleInstaller = function () {
    
    var self = this;
    
    this.responseData = '';    
    this.startTime = 0;    
    this.moduleListClass = '';    
    this.idx = 0;
    this.key = '';
    this.type = '';
    this.moduleIndex = '';
    this.ajaxHandler;
    this.moduleKeyCount = 0;
    
    this.init = function (type) {

        if (typeof fpcmUpdaterProgressbar == 'undefined') {
            jQuery('.fpcm-updater-programmbar').remove();
        } else {
            self.progressbar(0);            
        }

        self.ajaxHandler = new fpcmAjaxHandler();
        self.startTime   = (new Date().getTime());
        self.moduleKeyCount = fpcmModuleKeys.length;

        jQuery('.fpcm-updater-list').empty();
        fpcmJs.showLoader(true);

        self.idx = 1;
        self.progressbar(1);           
        self.runInstall(fpcmModuleKeys[0], 1, type);
        
        return false;
    };
    
    this.runInstall = function (key, moduleIndex, type) {
        self.moduleListClass = 'fpcm-updater-list-'+ moduleIndex;
        fpcmJs.appendHtml('.fpcm-updater-list', '<div class="' + self.moduleListClass + ' fpcm-ui-modules-installerbox"></div>');
        self.moduleListClass = '.' + self.moduleListClass;

        self.key = key;
        self.type = type;
        self.moduleIndex = moduleIndex;
        
        self.execRequest(fpcmUpdaterStartStep);

        return true;
    };
    
    this.execRequest = function(idx) {

        if (idx > fpcmUpdaterMaxStep) {
            return false;
        }

        var msgText = fpcmUpdaterMessages[idx + '_START'];

        if (idx == 1) {
            msgText = msgText.replace('{{pkglink}}', fpcmModuleUrl.replace('{{pkgkey}}', self.key));
        }

        fpcmJs.assignHtml('div.fpcm-updater-programmbar div.fpcm-ui-progressbar-label', msgText);

        self.ajaxHandler.action     = 'packagemgr/mod' + self.type;
        self.ajaxHandler.data       = {step:idx,key:self.key,midx:self.moduleIndex};
        self.ajaxHandler.execDone   = "fpcmModuleInstaller.responseData=fpcmModuleInstaller.ajaxHandler.result;fpcmModuleInstaller.ajaxCallback();";
        self.ajaxHandler.post();
        
        return true;
    };
    
    this.ajaxCallback = function() {

        self.responseData = JSON.parse(self.responseData);
        if (self.responseData.data === undefined) {
            alert(fpcmAjaxResponseErrorMessage);
            return false;
        }

        if (self.responseData.code != self.responseData.data.current + '_' +1) {
            fpcmJs.showLoader(false);
            fpcmJs.appendHtml(self.moduleListClass, '<p class="fpcm-ui-important-text">' + fpcmUpdaterMessages[self.responseData.code] + '</p>');
            return false;
        }

        fpcmJs.appendHtml(self.moduleListClass, '<p>' + fpcmUpdaterMessages[self.responseData.code] + '</p>');

        if (self.responseData.code && self.responseData.data.current == fpcmUpdaterMaxStep) {
            fpcmJs.appendHtml(self.moduleListClass, '<p>' + fpcmUpdaterMessages['EXIT_1'] + '</p>');
            
            if (self.moduleKeyCount > self.idx) {
                self.idx++;
                self.progressbar(self.idx);           
                self.runInstall(fpcmModuleKeys[(self.idx-1)], self.idx, self.type);            
                return true;
            }
            
            self.addTimer();
            return true;
        }

        self.execRequest(self.responseData.data.nextstep);

        return true;
    };
    
    this.addTimer = function() {
        var updateTimer = ((new Date().getTime()) - self.startTime) / 1000;
        fpcmJs.appendHtml('.fpcm-updater-list', '<p>' + fpcmUpdaterProcessTime + ': ' + updateTimer + 'sec</p>');
        fpcmJs.assignHtml('div.fpcm-updater-programmbar div.fpcm-ui-progressbar-label', '');
        fpcmJs.showLoader(false);
    };
    
    this.progressbar = function (pgValue) {
        
        if (typeof fpcmUpdaterProgressbar == 'undefined') return false;  
        
        jQuery('.fpcm-updater-programmbar').progressbar({
            max: fpcmProgressbarMax,
            value: pgValue
        });
    };
    
}