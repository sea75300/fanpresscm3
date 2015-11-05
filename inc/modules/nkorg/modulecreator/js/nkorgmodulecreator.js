var nkorgModulecreator = function () {
    
    var self = this;

    this.submitData = function() {
        
        jQuery('#fpcm-nkorgmodulecreator-createmsg').empty();
        
        var dataArray = {            
            'info'   : {},
            'events' : []
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
        
        fpcmAjax.action = 'nkorg/modulecreator/creator';
        fpcmAjax.data   = {newdata:dataArray};
        fpcmAjax.execDone = 'nkorgModulecreatorObj.submitDataDone(fpcmAjax.result)';
        fpcmAjax.post();
        
        return true;
    };
    
    this.submitDataDone = function(ajaxResult) {
        fpcmJs.showLoader(false);

        if (ajaxResult == '0' || ajaxResult == 0) {
            fpcmJs.addAjaxMassage('error', 'NKORG_MODULECREATOR_MSG_CREATION_ERROR');
            return false;
        } else {
            fpcmJs.addAjaxMassage('notice', 'NKORG_MODULECREATOR_MSG_CREATION_OK');
            jQuery('#fpcm-nkorgmodulecreator-createmsg').append('<div class="fpcm-ui-margin-center fpcm-half-width"><div class="fpcm-ui-input-wrapper"><div class="fpcm-ui-input-wrapper-inner"><input type="text" class="fpcm-ui-input-text" value="' + ajaxResult + '"></div></div></div>');
        }
    };
};

var nkorgModulecreatorObj = new nkorgModulecreator();

jQuery(document).ready(function () {
    
    
    jQuery('#btnStartCreation').click(function() {
        nkorgModulecreatorObj.submitData();
        return false;
    });
    fpcmJs.setFocus('nkorgmodulecreatorname');
});


    
