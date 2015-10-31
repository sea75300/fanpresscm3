/**
 * FanPress CM system javascript functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */

jQuery.noConflict();
jQuery(document).ready(function () {
    jQuery('.fpcm-backuplist-save').button({
        icons: {
            primary: "ui-icon-disk",
        },
        text: false
    });
});