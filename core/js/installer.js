/**
 * FanPress CM javascript installer functions
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2015, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.installer = {

    checkDBData: function() {
        sfields = jQuery('.fpcm-installer-data');
        sParams = {};

        jQuery.each(sfields, function( key, obj ) {
            var objVal  = jQuery(obj).val();
            var objName = jQuery(obj).attr('id').replace('database', '');                                
            sParams[objName] = objVal;
        }); 

        fpcmAjax.action     = 'installer/checkdb';
        fpcmAjax.data       = {dbdata: sParams};
        fpcmAjax.execDone   = "fpcm.installer.checkDbCallback(fpcmAjax.result);";
        fpcmAjax.async      = false;
        fpcmAjax.post();
        fpcmAjax.reset();
        
        return false;
    },
    
    checkDbCallback: function(res) {

        if (res === '1' || res === 1) {
            jQuery('#installerform').submit();
            return true;
        }

        jQuery('#fpcm-messages').empty();
        window.fpcmMsg = [];
        window.fpcmMsg.push({
            txt  : fpcm.ui.translate('dbTestFailed'),
            type : 'error',
            id   : 'errordbtestfailed',
            icon : 'exclamation-triangle'
        });

        fpcm.ui.showMessages();
        fpcm.ui.prepareMessages();
        fpcm.ui.messagesInitClose();

        return false;

    },

    initDatabase: function () {
        
        if (window.fpcmSqlFiles === undefined) {
            return false;
        }

        fpcm.ui.progressbar('.fpcm-installer-progressbar', {
            max  : fpcmSqlFilesCount,
            value: 0
        });

        var pgVal = 1;

        jQuery.each(window.fpcmSqlFiles, function( key, obj ) {

            fpcmJs.appendHtml('#fpcm-installer-execlist', '<p><span class="fa fa-spinner fa-spin fa-fw"></span> ' + fpcmSqlFileExec.replace('{{tablename}}', key) + '</p>');

            fpcmAjax.action     = 'installer/initdb';
            fpcmAjax.data       = {file: obj};
            fpcmAjax.execDone   = "fpcm.installer.initDatabaseFailed(fpcmAjax.result);";
            fpcmAjax.async      = false;
            fpcmAjax.post();
            fpcmAjax.reset();
            
            if (fpcm.installer.breakDbInit) {
                return false;
            }

            fpcm.ui.progressbar('.fpcm-installer-progressbar', {
                value: pgVal
            });

            pgVal++;
        });
    },
    
    initDatabaseFailed: function (result) {

        jQuery('#fpcm-installer-execlist').find('span.fa-spinner').remove();

        if(result != 0){        
            return true;
        }

        fpcmJs.appendHtml('#fpcm-installer-execlist', "<p class='fpcm-ui-important-text'>FAILED!</p>");
        this.breakDbInit = false;
    },
    
    initUi: function() {

        fpcm.ui.tabs('#fpcm-tabs-installer', {
            disabled: disabledTabs,
            active  : activeTab,
            beforeActivate: function( event, ui ) {
                
                var backLink = ui.newTab.find('a').attr('data-backlink');
                if (!backLink) {
                    return false;
                }

                fpcmJs.relocate(backLink);
            }
        });
        
        jQuery('#btnSubmitNext.fpcm-installer-next-3').click(function() {        
            fpcm.installer.checkDBData();
            return false;
        });
    }
};

jQuery(document).ready(function () {
    fpcm.installer.initUi();
    fpcm.installer.initDatabase();
});