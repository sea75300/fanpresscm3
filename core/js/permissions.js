/**
 * FanPress CM Permissions Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015-2017, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.permissions = {

    init: function() {
        fpcm.permissions.initButtonIcons();
        jQuery("#fpcm-tabs-permissions").addClass( "ui-tabs-vertical ui-helper-clearfix" );
        jQuery("#fpcm-tabs-permissions li").removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
        fpcm.ui.resize();
    },

    initButtonIcons: function() {
        fpcm.ui.checkboxradio('.fpcm-ui-input-checkbox', {
            icon: false
        });
    }

};