/**
 * FanPress CM Logs Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, 2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.logs = {

    init: function () {

        jQuery('.fpcm-logs-clear').click(function () {
            var logId = jQuery(this).attr('id');
            var size  = fpcm.ui.getDialogSizes(top, 0.35);
            fpcm.ui.dialog({
                title: fpcm.ui.translate('confirmHL'),
                content: fpcm.ui.translate('confirmMessage'),
                dlWidth: size.width,
                dlButtons: [
                    {
                        text: fpcm.ui.translate('yes'),
                        icon: "ui-icon-check",                    
                        click: function() {
                            fpcm.logs.clearLogs(logId); 
                            jQuery(this).dialog('close');
                        }
                    },
                    {
                        text: fpcm.ui.translate('no'),
                        icon: "ui-icon-closethick",
                        click: function() {
                            jQuery(this).dialog('close');
                        }
                    }
                ]
            });

            return false;
        });

        jQuery('.fpcm-logs-reload').click(function () {
            fpcm.logs.reloadLogs(jQuery(this).attr('id'));        
            return false;
        });

    },

    clearLogs: function(id) {

        fpcmJs.showLoader(true);
        var logType = id.split('_');

        fpcm.ajax.get('logs/clear', {
            workData: id,
            data: {
                log: logType[1]
            },
            execDone: function() {
                fpcmJs.showLoader(false);
                fpcm.logs.reloadLogs(fpcm.ajax.getWorkData('logs/clear'));
                fpcm.ui.appendMessage(fpcm.ajax.getResult('logs/clear'));
            }
        });

        return false;
    },
    
    reloadLogs: function(id) {

        fpcmJs.showLoader(true);
        var logType = id.split('_');

        fpcm.ajax.get('logs/reload', {
            workData: logType[1],
            data: {
                log: logType[1]
            },
            execDone: function() {
                fpcmJs.showLoader(false);

                var tabId = fpcm.ajax.getWorkData('logs/reload');
                fpcmJs.assignHtml('#fpcm-logcontent'+ tabId, fpcm.ajax.getResult('logs/reload'));

                if (tabId == 4) {
                    fpcm.ui.accordion('.fpcm-accordion-pkgmanager');
                }
            }
        });
        
        return false;
    }

};