/**
 * FanPress CM UI Namespace
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.permissions = {

    initButtonIcons: function() {
        fpcm.ui.checkboxradio('.fpcm-ui-input-checkbox', {
            
        });
        
    }
    
}

jQuery(document).ready(function() {
    fpcm.permissions.initButtonIcons();

    jQuery("#fpcm-tabs-permissions").addClass( "ui-tabs-vertical ui-helper-clearfix" );
    jQuery("#fpcm-tabs-permissions li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
});