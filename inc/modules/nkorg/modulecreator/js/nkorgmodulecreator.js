if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.nkorg_modulecreator = {

    init: function() {

        jQuery('#btnStartCreation').click(function() {
            fpcm.nkorg_modulecreator.submitData();
            return false;
        });

        fpcm.ui.setFocus('nkorgmodulecreatorname');
    },

    submitData: function() {
        
        jQuery('#fpcm-nkorgmodulecreator-createmsg').empty();
        
        var dataArray = {            
            info   : {},
            events : []
        };
        
        var emptyVars = 0;
        jQuery('.fpcm-nkorgmodulecreator-input').map(function (idx, item) {
            var objVal  = jQuery(item).val();
            var objName = jQuery(item).attr('name');            
            objName = objName.replace('nkorgmodulecreator[', '').replace(']', '');

            if (objVal == '' && objName != 'dependencies') {
                emptyVars++;
            }            
            dataArray.info[objName] = objVal;
        });

        if (emptyVars > 0) {
            fpcmJs.addAjaxMassage('error', 'NKORG_MODULECREATOR_MSG_INFOERROR');
            return false;
        }

        jQuery('.fpcm-nkorgmodulecreator-eventcheckboxes:checked').map(function (idx, item) {
            dataArray.events.push(jQuery(item).val());
        });        

        if (dataArray.events.length < 1) {
            fpcmJs.addAjaxMassage('neutral', 'NKORG_MODULECREATOR_MSG_EVENTSELECT');
            dataArray.events.push('acpConfig');
        }

        fpcm.ajax.post('nkorg/modulecreator/creator', {
            data: {
                newdata: dataArray
            },
            execDone: function () {
                fpcm.ui.showLoader(false);

                var ajaxResult = fpcm.ajax.getResult('nkorg/modulecreator/creator');
                if (ajaxResult == '0' || ajaxResult == 0) {
                    fpcmJs.addAjaxMassage('error', 'NKORG_MODULECREATOR_MSG_CREATION_ERROR');
                    return false;
                } else {
                    fpcmJs.addAjaxMassage('notice', 'NKORG_MODULECREATOR_MSG_CREATION_OK');
                    jQuery('#fpcm-nkorgmodulecreator-createmsg').append('<div class="fpcm-ui-margin-center fpcm-half-width"><div class="fpcm-ui-input-wrapper"><div class="fpcm-ui-input-wrapper-inner"><input type="text" class="fpcm-ui-input-text" value="' + ajaxResult + '"></div></div></div>');
                }
            }
        });

        return true;
    }

};