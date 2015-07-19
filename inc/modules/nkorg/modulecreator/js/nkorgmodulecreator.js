var nkorgModulecreator = function () {
    
    var self = this;

    this.submitData = function() {
        
        jQuery('#fpcm-nkorgmodulecreator-createmsg').empty();
        
        var dataArray = {            
            "info"   : {},
            "events" : []
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
        
        jQuery.ajax({
            url: fpcmAjaxActionPath + 'nkorg/modulecreator/creator',
            type: 'POST',
            data: {
                'newdata' : dataArray
            }
        })
        .done(function(result) {
            fpcmJs.showLoader(false);

            if (result == '0') {
                fpcmJs.addAjaxMassage('error', 'NKORG_MODULECREATOR_MSG_CREATION_ERROR');
                return false;
            } else {
                fpcmJs.addAjaxMassage('notice', 'NKORG_MODULECREATOR_MSG_CREATION_OK');
                jQuery('#fpcm-nkorgmodulecreator-createmsg').append('<p class="fpcm-ui-center"><input type="text" class="fpcm-ui-input-text fpcm-half-width" value="' + result + '"></p>');
            }
            
    
        })
        .fail(function() {
            alert(fpcmAjaxErrorMessage);
        });
        
        return true;
    };
};

jQuery(document).ready(function () {
    nkorgModulecreator = new nkorgModulecreator();
    jQuery('#btnStartCreation').click(function() {
        nkorgModulecreator.submitData();
        return false;
    });
    fpcmJs.setFocus('nkorgmodulecreatorname');
});


    
