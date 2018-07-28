/**
 * FanPress CM Namespace for upgrade to v4
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 * @since FPCM 3.6.8
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.upgradev4 = {

    actionName: '',
    elCount: [],
    elements: [],
    currentIdx: 0,
    currentEl: {},

    init: function () {
        fpcm.upgradev4.elements = jQuery('.fpcm-ui-update-steps');
        fpcm.upgradev4.elCount  = fpcm.upgradev4.elements.length;
        fpcm.upgradev4.actionName = 'packagemgr/updatev4';

        var start = fpcm.upgradev4.elements.first();
        var descrEl = start.find('.fpcm-ui-descr');
        descrEl.html(descrEl.html().replace('{{var}}', upgradeUrl));

        fpcm.upgradev4.execRequest(start);
    },

    execRequest: function(el) {

        fpcm.upgradev4.currentIdx++;
        
        fpcm.upgradev4.currentEl = el;
        fpcm.upgradev4.currentEl.find('span.fpcm-update-icon').removeClass('fa-'+el.attr('data-icon')).addClass('fa-spinner fa-pulse');

        if (el.attr('data-func')) {
            return fpcm.upgradev4[el.attr('data-func')] ? fpcm.upgradev4[el.attr('data-func')]() : false;
        }

        if (!el.attr('data-action')) {
            return false;
        }

        fpcm.ajax.post(fpcm.upgradev4.actionName, {
            data: {
                action: el.attr('data-action')
            },
            execDone: function () {

                fpcm.upgradev4.currentEl.find('span.fpcm-update-icon').removeClass('fa-spinner fa-pulse').addClass('fa-'+el.attr('data-icon'));
                var result = fpcm.ajax.getResult(fpcm.upgradev4.actionName);
                
                if (!result) {
                    return false;
                }

                result = fpcm.ajax.fromJSON(result);
                if (!result.code) {
                    
                    fpcm.upgradev4.currentEl.find('span.fpcm-update-icon').addClass('fpcm-ui-important-text');
                    fpcm.ui.addMessage({
                        txt: result.errorMsg,
                        type : 'error',
                        icon : 'exclamation-triangle'
                    }, true);

                    fpcm.upgradev4.currentEl = {};
                    return false;
                }

                fpcm.upgradev4.currentEl.find('span.fpcm-update-icon').addClass('fpcm-ui-booltext-yes');
                fpcm.upgradev4.currentEl = {};
                fpcm.upgradev4.execRequest(jQuery(fpcm.upgradev4.elements[fpcm.upgradev4.currentIdx]));
            }
        });

        return true;
    },
    
    redirect: function() {
        setTimeout(function () {
            fpcm.upgradev4.currentEl.find('span.fpcm-update-icon').removeClass('fa-spinner fa-pulse').addClass('fa-'+ fpcm.upgradev4.currentEl.attr('data-icon'));
            window.location.href = updateDbUrl;
        }, 1500);
    }

};