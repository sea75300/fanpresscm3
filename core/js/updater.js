/**
 * FanPress CM Updater Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 3.5
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.updater = {

    startTime   : 0,
    responseData: '',

    init: function () {

        fpcm.updater.startTime   = (new Date().getTime());
        
        fpcmJs.showLoader(true);
        
        if (!fpcmUpdaterProgressbar) {
            jQuery('.fpcm-updater-progressbar').remove();
        }

        fpcm.updater.progressbar(0);
        fpcm.updater.execRequest(fpcmUpdaterStartStep);

    },

    execRequest: function(idx) {

        if (idx > fpcmUpdaterMaxStep) {
            return false;
        }

        fpcm.ui.assignHtml('div.fpcm-updater-progressbar div.fpcm-ui-progressbar-label', fpcmUpdaterMessages[idx + '_START']);

        fpcm.ajax.post('packagemgr/sysupdater', {
            data: {
                step : idx,
                force: (fpcmUpdaterStartStep > 1 ? 1 : 0)
            },
            execDone: function () {
                fpcm.updater.responseData = fpcm.ajax.fromJSON(fpcm.ajax.getResult('packagemgr/sysupdater'));
                if (fpcm.updater.responseData.data === undefined) {
                    alert(fpcm.ui.translate('ajaxErrorMessage'));
                    return false;
                }

                fpcm.updater.progressbar(fpcm.updater.responseData.data.current);

                if (fpcm.updater.responseData.data.current < fpcmUpdaterMaxStep &&
                    fpcm.updater.responseData.code != fpcm.updater.responseData.data.current + '_' + 1) {
                    fpcmJs.showLoader(false);
                    fpcm.ui.appendHtml('.fpcm-updater-list', '<p class="fpcm-ui-important-text">' + fpcmUpdaterMessages[fpcm.updater.responseData.code] + '</p>');
                    return false;
                }
                else if (fpcm.updater.responseData.data.current == 6) {
                    fpcm.ui.appendHtml('.fpcm-updater-list', '<p>' + fpcmUpdaterMessages[fpcm.updater.responseData.code] + ': ' + fpcm.updater.responseData.data.newver + '</p>');
                    fpcm.updater.ajaxCallbackFinal(fpcm.updater.responseDataresponseData);
                }
                else {
                    fpcm.ui.appendHtml('.fpcm-updater-list', '<p>' + fpcmUpdaterMessages[fpcm.updater.responseData.code] + '</p>');
                }

                if (fpcm.updater.responseData.data.current < fpcmUpdaterMaxStep) {
                    fpcm.updater.execRequest(fpcm.updater.responseData.data.nextstep);
                }

                if (fpcm.updater.responseData.data.current == fpcmUpdaterMaxStep) {
                    fpcm.ui.assignText('div.fpcm-updater-progressbar div.fpcm-ui-progressbar-label', '');
                }
            }
        });
        
        return true;
    },

    ajaxCallbackFinal: function() {
        jQuery('#fpcm-ui-headspinner').removeClass('fa-spin');
        fpcmJs.addAjaxMassage('notice', fpcmUpdaterMessages['EXIT_1']);
        fpcm.ui.appendHtml('.fpcm-updater-list', '<p>' + '<span class="fa fa-check-square fa-fw fa-lg fpcm-ui-booltext-yes"></span>'  + fpcmUpdaterMessages['EXIT_1'] + '</p>');
        fpcmJs.showLoader(false);
        fpcm.updater.addTimer();
        return true;
    },

    addTimer: function() {
        var updateTimer = ((new Date().getTime()) - fpcm.updater.startTime) / 1000;
        fpcm.ui.appendHtml('.fpcm-updater-list', '<p>' + fpcmUpdaterProcessTime + ': ' + updateTimer + 'sec</p>');
        fpcmJs.showLoader(false);
        return true;
    },

    progressbar: function (pgValue) {
        
        if (!window.fpcmUpdaterProgressbar) return false;  

        fpcm.ui.progressbar('.fpcm-updater-progressbar', {
            max: fpcmUpdaterMaxStep,
            value: pgValue
        });

    }
};