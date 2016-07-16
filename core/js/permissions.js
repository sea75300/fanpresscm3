/**
 * FanPress CM UI Namespace
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.permissions = {

    initButtonIcons: function() {
        jQuery('.fpcm-ui-buttonset-permissions').find('input[type="checkbox"]').button({
            icons: {
                primary: "ui-icon-check"
            },
            text: false
        });
    }
    
}

jQuery(document).ready(function() {
    fpcm.permissions.initButtonIcons();
});