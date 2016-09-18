/**
 * FanPress CM UI Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, 2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.login = {

    moveToCenter: function () {
        var loginTopPos = (jQuery(window).height() / 2 - jQuery('.fpcm-login-form').height() * 0.5);
        jQuery('.fpcm-login-form').css('margin-top', loginTopPos);  
    },

    setFocus: function () {
        fpcmJs.setFocus('loginusername');
    },

};

jQuery(document).ready(function () {
    fpcm.login.moveToCenter();
    fpcm.login.setFocus();
});